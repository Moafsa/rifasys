<?php

namespace App\Services;

use App\Models\Raffle;
use App\Models\User;
use App\Models\RaffleTicket;
use Illuminate\Support\Facades\Log;

class WuzapiRaffles
{
    protected WuzapiService $wuzapiService;

    public function __construct(WuzapiService $wuzapiService)
    {
        $this->wuzapiService = $wuzapiService;
    }

    /**
     * Send verification link via WhatsApp
     */
    public function sendVerificationLink(string $phone, string $verificationLink, string $userName = ''): ?array
    {
        $message = "🎯 *RAFE - Plataforma de Rifas*\n\n";
        $message .= "Olá" . ($userName ? " {$userName}" : "") . "!\n\n";
        $message .= "Clique no link abaixo para verificar sua conta:\n\n";
        $message .= "🔗 *Link de Verificação:*\n";
        $message .= "{$verificationLink}\n\n";
        $message .= "⏰ Este link expira em 3 minutos.\n";
        $message .= "Se você não solicitou esta verificação, ignore esta mensagem.\n\n";
        $message .= "✨ *RAFE - Conectando pessoas através de rifas solidárias*";

        return $this->wuzapiService->sendMessage($phone, $message);
    }

    /**
     * Send verification code message
     */
    public function sendVerificationCode(string $phone, string $code, string $userName = ''): ?array
    {
        $message = "🎯 *RAFE - Plataforma de Rifas*\n\n";
        $message .= "Olá" . ($userName ? " {$userName}" : "") . "!\n\n";
        $message .= "Seu código de verificação é:\n";
        $message .= "🔐 *{$code}*\n\n";
        $message .= "Este código expira em 3 minutos.\n";
        $message .= "Se você não solicitou este código, ignore esta mensagem.\n\n";
        $message .= "✨ *RAFE - Conectando pessoas através de rifas solidárias*";

        return $this->wuzapiService->sendMessage($phone, $message);
    }

    /**
     * Send verification confirmation message with buttons
     */
    public function sendVerificationConfirmation(string $phone, string $userName = ''): ?array
    {
        $message = "🎯 *RAFE - Plataforma de Rifas*\n\n";
        $message .= "Olá" . ($userName ? " {$userName}" : "") . "!\n\n";
        $message .= "Você está tentando verificar sua conta na RAFE.\n";
        $message .= "É você que está acessando nossa plataforma?\n\n";
        $message .= "Clique no botão abaixo para confirmar:";

        $buttons = [
            [
                'id' => 'confirm_verification',
                'title' => '✅ Sim, sou eu'
            ],
            [
                'id' => 'deny_verification', 
                'title' => '❌ Não sou eu'
            ]
        ];

        return $this->wuzapiService->sendButtons($phone, $message, $buttons);
    }

    /**
     * Send purchase confirmation message
     */
    public function sendPurchaseConfirmation(string $phone, array $purchaseData): ?array
    {
        $message = "🎉 *RAFE - Compra Confirmada!*\n\n";
        $message .= "Olá {$purchaseData['user_name']}!\n\n";
        $message .= "✅ Sua compra foi confirmada:\n";
        $message .= "🎫 Rifa: {$purchaseData['raffle_title']}\n";
        $message .= "🔢 Números: " . implode(', ', $purchaseData['numbers']) . "\n";
        $message .= "💰 Valor: R$ " . number_format($purchaseData['total_amount'], 2, ',', '.') . "\n\n";
        $message .= "Boa sorte! 🍀\n\n";
        $message .= "*RAFE - Conectando pessoas através de rifas solidárias*";

        return $this->wuzapiService->sendMessage($phone, $message);
    }

    /**
     * Send raffle creation notification
     */
    public function sendRaffleCreatedNotification(Raffle $raffle, User $user): ?array
    {
        $message = "🎉 *Nova Rifa Criada!*\n\n";
        $message .= "Olá {$user->name}!\n\n";
        $message .= "Sua rifa foi criada com sucesso:\n";
        $message .= "🎫 *Título:* {$raffle->title}\n";
        $message .= "💰 *Valor por número:* R$ " . number_format($raffle->price_per_ticket, 2, ',', '.') . "\n";
        $message .= "🔢 *Total de números:* {$raffle->total_tickets}\n";
        $message .= "📅 *Data do sorteio:* " . $raffle->draw_date->format('d/m/Y H:i') . "\n\n";
        $message .= "Compartilhe sua rifa e boa sorte! 🍀\n\n";
        $message .= "*RAFE - Conectando pessoas através de rifas solidárias*";

        return $this->wuzapiService->sendMessage($user->phone, $message);
    }

    /**
     * Send raffle draw notification
     */
    public function sendRaffleDrawNotification(Raffle $raffle, int $winningNumber): ?array
    {
        $message = "🎊 *Sorteio Realizado!*\n\n";
        $message .= "A rifa *{$raffle->title}* foi sorteada!\n\n";
        $message .= "🏆 *Número sorteado:* {$winningNumber}\n";
        $message .= "🎫 *Rifa:* {$raffle->title}\n";
        $message .= "💰 *Prêmio:* R$ " . number_format($raffle->total_amount, 2, ',', '.') . "\n\n";
        $message .= "Parabéns ao ganhador! 🎉\n\n";
        $message .= "*RAFE - Conectando pessoas através de rifas solidárias*";

        return $this->wuzapiService->sendMessage($raffle->user->phone, $message);
    }

    /**
     * Send winner notification
     */
    public function sendWinnerNotification(Raffle $raffle, User $winner, int $winningNumber): ?array
    {
        $message = "🏆 *PARABÉNS! VOCÊ GANHOU!* 🏆\n\n";
        $message .= "Olá {$winner->name}!\n\n";
        $message .= "🎉 Você foi o ganhador da rifa:\n";
        $message .= "🎫 *Rifa:* {$raffle->title}\n";
        $message .= "🔢 *Número sorteado:* {$winningNumber}\n";
        $message .= "💰 *Prêmio:* R$ " . number_format($raffle->total_amount, 2, ',', '.') . "\n\n";
        $message .= "Entre em contato com o organizador para receber seu prêmio!\n\n";
        $message .= "*RAFE - Conectando pessoas através de rifas solidárias*";

        return $this->wuzapiService->sendMessage($winner->phone, $message);
    }

    /**
     * Send raffle reminder
     */
    public function sendRaffleReminder(Raffle $raffle, User $user): ?array
    {
        $message = "⏰ *Lembrete de Rifa*\n\n";
        $message .= "Olá {$user->name}!\n\n";
        $message .= "Lembre-se da sua rifa:\n";
        $message .= "🎫 *Rifa:* {$raffle->title}\n";
        $message .= "📅 *Data do sorteio:* " . $raffle->draw_date->format('d/m/Y H:i') . "\n";
        $message .= "🔢 *Números disponíveis:* " . $raffle->available_tickets . "\n\n";
        $message .= "Compartilhe com seus amigos! 🚀\n\n";
        $message .= "*RAFE - Conectando pessoas através de rifas solidárias*";

        return $this->wuzapiService->sendMessage($user->phone, $message);
    }

    /**
     * Send raffle menu with options
     */
    public function sendRaffleMenu(string $phone, string $userName = ''): ?array
    {
        $message = "🎯 *RAFE - Menu de Rifas*\n\n";
        $message .= "Olá" . ($userName ? " {$userName}" : "") . "!\n\n";
        $message .= "Escolha uma opção:";

        $buttons = [
            [
                'id' => 'create_raffle',
                'title' => '🎫 Criar Rifa'
            ],
            [
                'id' => 'my_raffles',
                'title' => '📋 Minhas Rifas'
            ],
            [
                'id' => 'buy_tickets',
                'title' => '🛒 Comprar Números'
            ],
            [
                'id' => 'help',
                'title' => '❓ Ajuda'
            ]
        ];

        return $this->wuzapiService->sendButtons($phone, $message, $buttons);
    }

    /**
     * Send raffle details
     */
    public function sendRaffleDetails(Raffle $raffle, string $phone): ?array
    {
        $message = "🎫 *Detalhes da Rifa*\n\n";
        $message .= "📝 *Título:* {$raffle->title}\n";
        $message .= "📄 *Descrição:* {$raffle->description}\n";
        $message .= "💰 *Valor por número:* R$ " . number_format($raffle->price_per_ticket, 2, ',', '.') . "\n";
        $message .= "🔢 *Total de números:* {$raffle->total_tickets}\n";
        $message .= "🔢 *Números disponíveis:* {$raffle->available_tickets}\n";
        $message .= "📅 *Data do sorteio:* " . $raffle->draw_date->format('d/m/Y H:i') . "\n";
        $message .= "👤 *Organizador:* {$raffle->user->name}\n\n";
        $message .= "Para comprar números, acesse o link da rifa!";

        return $this->wuzapiService->sendMessage($phone, $message);
    }

    /**
     * Send ticket purchase summary
     */
    public function sendTicketPurchaseSummary(Raffle $raffle, array $tickets, User $user, float $totalAmount): ?array
    {
        $message = "🛒 *Resumo da Compra*\n\n";
        $message .= "Olá {$user->name}!\n\n";
        $message .= "🎫 *Rifa:* {$raffle->title}\n";
        $message .= "🔢 *Números comprados:* " . implode(', ', $tickets) . "\n";
        $message .= "💰 *Valor total:* R$ " . number_format($totalAmount, 2, ',', '.') . "\n\n";
        $message .= "Boa sorte! 🍀\n\n";
        $message .= "*RAFE - Conectando pessoas através de rifas solidárias*";

        return $this->wuzapiService->sendMessage($user->phone, $message);
    }

    /**
     * Send raffle share message
     */
    public function sendRaffleShare(Raffle $raffle, string $phone): ?array
    {
        $message = "🎫 *Nova Rifa Disponível!*\n\n";
        $message .= "🎯 *{$raffle->title}*\n\n";
        $message .= "📄 {$raffle->description}\n\n";
        $message .= "💰 *Valor por número:* R$ " . number_format($raffle->price_per_ticket, 2, ',', '.') . "\n";
        $message .= "🔢 *Números disponíveis:* {$raffle->available_tickets}\n";
        $message .= "📅 *Data do sorteio:* " . $raffle->draw_date->format('d/m/Y H:i') . "\n\n";
        $message .= "Participe e boa sorte! 🍀\n\n";
        $message .= "*RAFE - Conectando pessoas através de rifas solidárias*";

        return $this->wuzapiService->sendMessage($phone, $message);
    }

    /**
     * Send help message
     */
    public function sendHelpMessage(string $phone): ?array
    {
        $message = "❓ *RAFE - Ajuda*\n\n";
        $message .= "Como usar a RAFE:\n\n";
        $message .= "🎫 *Criar Rifa:*\n";
        $message .= "• Acesse o site e clique em 'Criar Rifa'\n";
        $message .= "• Preencha os dados da sua rifa\n";
        $message .= "• Compartilhe o link com seus amigos\n\n";
        $message .= "🛒 *Comprar Números:*\n";
        $message .= "• Acesse o link da rifa\n";
        $message .= "• Escolha seus números\n";
        $message .= "• Faça o pagamento\n\n";
        $message .= "📞 *Suporte:*\n";
        $message .= "• Email: suporte@rafe.com.br\n";
        $message .= "• WhatsApp: (11) 99999-9999\n\n";
        $message .= "*RAFE - Conectando pessoas através de rifas solidárias*";

        return $this->wuzapiService->sendMessage($phone, $message);
    }

    /**
     * Send raffle status update
     */
    public function sendRaffleStatusUpdate(Raffle $raffle, string $status, string $phone): ?array
    {
        $statusMessages = [
            'active' => '✅ Sua rifa está ativa e recebendo compras!',
            'paused' => '⏸️ Sua rifa foi pausada temporariamente.',
            'cancelled' => '❌ Sua rifa foi cancelada.',
            'completed' => '🏁 Sua rifa foi finalizada e o sorteio realizado!',
        ];

        $message = "📢 *Atualização da Rifa*\n\n";
        $message .= "🎫 *Rifa:* {$raffle->title}\n\n";
        $message .= $statusMessages[$status] ?? "Status: {$status}\n\n";
        $message .= "*RAFE - Conectando pessoas através de rifas solidárias*";

        return $this->wuzapiService->sendMessage($phone, $message);
    }
}
