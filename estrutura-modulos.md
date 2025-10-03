# Estrutura de Módulos - Rifassys

**Sistema:** Plataforma de Rifas Solidárias Inteligente  
**Data:** 01 de outubro de 2025

---

## 📁 Estrutura de Diretórios do Projeto

```
rifassys/
├── app/
│   ├── Console/
│   │   ├── Commands/
│   │   │   ├── DrawPendingRaffles.php          # Executa sorteios automaticamente
│   │   │   ├── ExpireReservedNumbers.php       # Expira reservas de números
│   │   │   ├── CheckPendingPayments.php        # Verifica status de pagamentos
│   │   │   └── ProcessDeliveryConfirmations.php # Processa confirmações pendentes
│   │   └── Kernel.php
│   │
│   ├── Events/
│   │   ├── PaymentConfirmed.php                # Pagamento confirmado
│   │   ├── RaffleDrawn.php                     # Sorteio realizado
│   │   ├── PrizeDelivered.php                  # Prêmio entregue
│   │   └── DeliveryConfirmed.php               # Entrega confirmada pelo ganhador
│   │
│   ├── Exceptions/
│   │   ├── PaymentException.php
│   │   ├── RaffleException.php
│   │   └── WhatsAppException.php
│   │
│   ├── Http/
│   │   ├── Controllers/
│   │   │   ├── Web/
│   │   │   │   ├── HomeController.php          # Página inicial
│   │   │   │   ├── RaffleController.php        # Landing page de rifas
│   │   │   │   ├── PurchaseController.php      # Fluxo de compra
│   │   │   │   └── ChatbotController.php       # API do chatbot
│   │   │   │
│   │   │   ├── Dashboard/
│   │   │   │   ├── DashboardController.php     # Dashboard principal
│   │   │   │   ├── MyRafflesController.php     # Gerenciar rifas
│   │   │   │   ├── CreateRaffleController.php  # Criar nova rifa
│   │   │   │   ├── ClientsController.php       # Listar clientes
│   │   │   │   ├── FinancialController.php     # Relatórios financeiros
│   │   │   │   ├── DeliveryController.php      # Gestão de entrega (CPF)
│   │   │   │   └── SettingsController.php      # Configurações
│   │   │   │
│   │   │   ├── Admin/
│   │   │   │   ├── AdminDashboardController.php
│   │   │   │   ├── UsersController.php
│   │   │   │   ├── AllRafflesController.php
│   │   │   │   ├── FinancialController.php
│   │   │   │   └── ExceptionsController.php    # Sistema de exceções
│   │   │   │
│   │   │   └── Api/
│   │   │       ├── WebhookController.php       # Webhooks Asaas
│   │   │       ├── WhatsAppWebhookController.php
│   │   │       └── PaymentStatusController.php
│   │   │
│   │   ├── Middleware/
│   │   │   ├── CheckUserStatus.php             # Verifica status do usuário
│   │   │   ├── CheckRaffleOwnership.php        # Verifica dono da rifa
│   │   │   ├── AdminMiddleware.php             # Apenas admins
│   │   │   └── RateLimitPurchases.php          # Limita compras
│   │   │
│   │   └── Requests/
│   │       ├── CreateRaffleRequest.php
│   │       ├── PurchaseRequest.php
│   │       ├── UpdateProfileRequest.php
│   │       └── DeliveryConfirmationRequest.php
│   │
│   ├── Jobs/
│   │   ├── ProcessConfirmedPayment.php         # Processa pagamento confirmado
│   │   ├── ExecuteRaffleDraw.php               # Executa sorteio
│   │   ├── SendDeliveryConfirmation.php        # Envia confirmação WhatsApp
│   │   ├── ReleaseCustodyFunds.php             # Libera fundos (CPF)
│   │   ├── SendPurchaseConfirmation.php        # Confirmação de compra
│   │   ├── GenerateRaffleNumbers.php           # Gera números da rifa
│   │   ├── UpdateRaffleStats.php               # Atualiza estatísticas
│   │   └── ProcessRefund.php                   # Processa reembolso
│   │
│   ├── Listeners/
│   │   ├── SendPaymentNotification.php
│   │   ├── UpdateRaffleProgress.php
│   │   ├── NotifyWinner.php
│   │   └── CreateDeliveryConfirmation.php
│   │
│   ├── Models/
│   │   ├── User.php                            # Usuário (organizador)
│   │   ├── UserProfile.php                     # Perfil CPF/CNPJ
│   │   ├── Raffle.php                          # Rifa
│   │   ├── RaffleNumber.php                    # Números da rifa
│   │   ├── RaffleParticipant.php               # Participante (comprador)
│   │   ├── RafflePurchase.php                  # Compra
│   │   ├── RaffleWinner.php                    # Ganhador
│   │   ├── Transaction.php                     # Transação financeira
│   │   ├── DeliveryConfirmation.php            # Confirmação de entrega
│   │   ├── ChatbotConversation.php             # Conversa do chatbot
│   │   ├── AiGeneratedContent.php              # Conteúdo gerado por IA
│   │   └── AdminException.php                  # Exceção administrativa
│   │
│   ├── Notifications/
│   │   ├── PurchaseConfirmed.php               # Compra confirmada
│   │   ├── RaffleDrawnNotification.php         # Sorteio realizado
│   │   ├── YouWonNotification.php              # Você ganhou!
│   │   ├── DeliveryPending.php                 # Entrega pendente
│   │   └── FundsReleased.php                   # Fundos liberados
│   │
│   ├── Observers/
│   │   ├── RaffleObserver.php                  # Observa mudanças na rifa
│   │   ├── PurchaseObserver.php                # Observa compras
│   │   └── TransactionObserver.php             # Observa transações
│   │
│   ├── Policies/
│   │   ├── RafflePolicy.php                    # Políticas de autorização
│   │   ├── UserPolicy.php
│   │   └── TransactionPolicy.php
│   │
│   ├── Providers/
│   │   ├── AppServiceProvider.php
│   │   ├── AuthServiceProvider.php
│   │   ├── EventServiceProvider.php
│   │   └── RouteServiceProvider.php
│   │
│   ├── Services/
│   │   ├── Payment/
│   │   │   ├── AsaasService.php                # Integração Asaas
│   │   │   ├── PaymentService.php              # Lógica de pagamentos
│   │   │   ├── SplitPaymentService.php         # Split para CNPJ
│   │   │   └── CustodyService.php              # Custódia para CPF
│   │   │
│   │   ├── WhatsApp/
│   │   │   ├── WuzapiService.php               # Integração Wuzapi
│   │   │   ├── MessageService.php              # Envio de mensagens
│   │   │   └── DeliveryConfirmationService.php # Confirmação de entrega
│   │   │
│   │   ├── AI/
│   │   │   ├── OpenAIService.php               # Integração OpenAI
│   │   │   ├── RegulationGeneratorService.php  # Gerador de regulamento
│   │   │   └── ChatbotService.php              # Lógica do chatbot
│   │   │
│   │   ├── Raffle/
│   │   │   ├── RaffleService.php               # CRUD de rifas
│   │   │   ├── NumberGeneratorService.php      # Geração de números
│   │   │   ├── DrawService.php                 # Lógica de sorteio
│   │   │   └── PurchaseService.php             # Lógica de compra
│   │   │
│   │   ├── Upload/
│   │   │   └── ImageUploadService.php          # Upload de imagens
│   │   │
│   │   └── Report/
│   │       ├── FinancialReportService.php      # Relatórios financeiros
│   │       └── StatisticsService.php           # Estatísticas
│   │
│   └── Traits/
│       ├── HasUuid.php                         # Adiciona UUID aos models
│       ├── Loggable.php                        # Log automático de ações
│       └── FormatsDocument.php                 # Formatação CPF/CNPJ
│
├── bootstrap/
│   ├── app.php
│   └── cache/
│
├── config/
│   ├── app.php
│   ├── database.php
│   ├── queue.php
│   ├── services.php                            # Configurações de serviços externos
│   └── ...
│
├── database/
│   ├── factories/
│   │   ├── UserFactory.php
│   │   ├── RaffleFactory.php
│   │   └── RafflePurchaseFactory.php
│   │
│   ├── migrations/
│   │   ├── 2024_XX_XX_modify_users_table.php
│   │   ├── 2024_XX_XX_create_user_profiles_table.php
│   │   ├── 2024_XX_XX_create_raffles_table.php
│   │   ├── 2024_XX_XX_create_raffle_numbers_table.php
│   │   ├── 2024_XX_XX_create_raffle_participants_table.php
│   │   ├── 2024_XX_XX_create_raffle_purchases_table.php
│   │   ├── 2024_XX_XX_create_raffle_winners_table.php
│   │   ├── 2024_XX_XX_create_transactions_table.php
│   │   ├── 2024_XX_XX_create_delivery_confirmations_table.php
│   │   ├── 2024_XX_XX_create_chatbot_conversations_table.php
│   │   ├── 2024_XX_XX_create_ai_generated_contents_table.php
│   │   ├── 2024_XX_XX_create_admin_exceptions_table.php
│   │   └── 2024_XX_XX_create_activity_log_table.php
│   │
│   └── seeders/
│       ├── DatabaseSeeder.php
│       ├── RolesAndPermissionsSeeder.php
│       ├── AdminUserSeeder.php
│       └── DemoRaffleSeeder.php                # Dados de demonstração
│
├── docker/
│   ├── Dockerfile
│   ├── nginx/
│   │   └── conf.d/
│   │       └── app.conf
│   └── php/
│       └── local.ini
│
├── public/
│   ├── index.php
│   ├── images/
│   ├── css/
│   └── js/
│
├── resources/
│   ├── css/
│   │   └── app.css
│   │
│   ├── js/
│   │   ├── app.js
│   │   ├── alpine.js
│   │   ├── chart.js
│   │   └── components/
│   │       ├── chatbot.js                      # Chatbot frontend
│   │       ├── countdown.js                    # Contador regressivo
│   │       ├── number-selector.js              # Seletor de números
│   │       └── checkout-modal.js               # Modal de checkout
│   │
│   └── views/
│       ├── layouts/
│       │   ├── app.blade.php                   # Layout principal
│       │   ├── dashboard.blade.php             # Layout dashboard
│       │   ├── admin.blade.php                 # Layout admin
│       │   ├── navigation.blade.php            # Menu de navegação
│       │   └── footer.blade.php                # Rodapé
│       │
│       ├── components/
│       │   ├── button.blade.php
│       │   ├── input.blade.php
│       │   ├── card.blade.php
│       │   ├── modal.blade.php
│       │   ├── countdown.blade.php             # Contador regressivo
│       │   ├── number-grid.blade.php           # Grade de números
│       │   ├── chatbot.blade.php               # Widget chatbot
│       │   └── raffle-card.blade.php           # Card de rifa
│       │
│       ├── home/
│       │   └── index.blade.php                 # Página inicial
│       │
│       ├── raffle/
│       │   ├── show.blade.php                  # Landing page da rifa
│       │   ├── partials/
│       │   │   ├── header.blade.php
│       │   │   ├── gallery.blade.php
│       │   │   ├── number-selector.blade.php
│       │   │   ├── description.blade.php
│       │   │   ├── regulation.blade.php
│       │   │   └── winner.blade.php
│       │   └── checkout-modal.blade.php
│       │
│       ├── dashboard/
│       │   ├── index.blade.php                 # Dashboard principal
│       │   │
│       │   ├── raffles/
│       │   │   ├── index.blade.php             # Lista de rifas
│       │   │   ├── create.blade.php            # Criar rifa (wizard)
│       │   │   ├── edit.blade.php              # Editar rifa
│       │   │   ├── clients.blade.php           # Lista de clientes
│       │   │   ├── financial.blade.php         # Relatório financeiro
│       │   │   └── delivery.blade.php          # Gestão de entrega
│       │   │
│       │   └── settings/
│       │       └── index.blade.php             # Configurações
│       │
│       ├── admin/
│       │   ├── dashboard.blade.php             # Dashboard admin
│       │   │
│       │   ├── users/
│       │   │   ├── index.blade.php             # Lista de usuários
│       │   │   ├── show.blade.php              # Detalhes do usuário
│       │   │   └── edit.blade.php              # Editar usuário
│       │   │
│       │   ├── raffles/
│       │   │   ├── index.blade.php             # Todas as rifas
│       │   │   └── show.blade.php              # Detalhes da rifa
│       │   │
│       │   ├── financial/
│       │   │   └── index.blade.php             # Relatório financeiro geral
│       │   │
│       │   └── exceptions/
│       │       ├── index.blade.php             # Lista de exceções
│       │       └── show.blade.php              # Resolver exceção
│       │
│       └── auth/
│           ├── login.blade.php
│           ├── register.blade.php
│           ├── forgot-password.blade.php
│           └── reset-password.blade.php
│
├── routes/
│   ├── web.php                                 # Rotas públicas e dashboard
│   ├── api.php                                 # Rotas API (webhooks)
│   ├── console.php                             # Rotas console
│   └── channels.php                            # Broadcasting
│
├── storage/
│   ├── app/
│   │   ├── public/
│   │   │   ├── raffles/                        # Imagens de rifas
│   │   │   └── profiles/                       # Logos de perfis
│   │   └── private/
│   │       └── reports/                        # Relatórios gerados
│   ├── framework/
│   └── logs/
│
├── tests/
│   ├── Feature/
│   │   ├── Auth/
│   │   │   └── AuthenticationTest.php
│   │   ├── Raffle/
│   │   │   ├── CreateRaffleTest.php
│   │   │   ├── PurchaseRaffleTest.php
│   │   │   └── DrawRaffleTest.php
│   │   ├── Payment/
│   │   │   ├── PixPaymentTest.php
│   │   │   ├── SplitPaymentTest.php
│   │   │   └── CustodyTest.php
│   │   └── WhatsApp/
│   │       └── DeliveryConfirmationTest.php
│   │
│   └── Unit/
│       ├── Services/
│       │   ├── AsaasServiceTest.php
│       │   ├── WuzapiServiceTest.php
│       │   └── OpenAIServiceTest.php
│       └── Models/
│           ├── RaffleTest.php
│           └── UserTest.php
│
├── .env.example
├── .gitignore
├── artisan
├── composer.json
├── composer.lock
├── docker-compose.yml
├── package.json
├── package-lock.json
├── phpunit.xml
├── README.md
├── PLANO-DESENVOLVIMENTO-RIFASSYS.md          # Este documento
└── estrutura-modulos.md                        # Estrutura detalhada
```

---

## 🔄 Fluxos Principais do Sistema

### 1. Fluxo de Cadastro de Usuário

```
Usuário acessa /cadastro
    ↓
Escolhe CPF ou CNPJ
    ↓
Preenche formulário
    ↓
Sistema valida documento (CPF/CNPJ)
    ↓
Cria User + UserProfile
    ↓
Envia e-mail de verificação
    ↓
[CPF] Solicita cadastro de Chave PIX
[CNPJ] Solicita walletId da Asaas
    ↓
Redireciona para /dashboard
```

### 2. Fluxo de Criação de Rifa

```
Organizador acessa /dashboard/rifas/criar
    ↓
PASSO 1: Informações Básicas
  - Título
  - Descrição
  - Upload de imagens do prêmio
  - Data/hora do sorteio
    ↓
PASSO 2: Configuração dos Números
  - Quantidade total de números
  - Valor por número
  - Min/max números por compra
    ↓
PASSO 3: Regulamento com IA
  - Clica em "Gerar Regulamento com IA"
  - OpenAIService gera texto baseado nos dados
  - Organizador pode editar
  - Salva em ai_generated_contents
    ↓
PASSO 4: Revisão e Publicação
  - Organizador revisa tudo
  - Clica em "Publicar"
    ↓
Sistema cria Raffle (status: active)
    ↓
Job GenerateRaffleNumbers cria todos os números (status: available)
    ↓
Raffle publicada com slug único
    ↓
Landing Page disponível em /rifa/{slug}
```

### 3. Fluxo de Compra (Cliente)

```
Cliente acessa /rifa/{slug}
    ↓
Visualiza informações da rifa
    ↓
Seleciona números na grade interativa
  - Números disponíveis: clicáveis (verde)
  - Números vendidos: bloqueados (cinza)
    ↓
Clica em "Comprar Agora"
    ↓
Modal de Checkout abre
  - Preenche: Nome, CPF, WhatsApp
  - Valida CPF
    ↓
Sistema:
  1. Cria/busca RaffleParticipant
  2. Reserva os números (status: reserved)
  3. Cria RafflePurchase (status: pending)
    ↓
AsaasService:
  1. Cria/busca Customer na Asaas
  2. Cria Payment (billingType: PIX)
  3. Obtém QR Code PIX
    ↓
Exibe QR Code e Pix Copia e Cola
  - Timer de 15 minutos
    ↓
Cliente paga o PIX
    ↓
Asaas envia webhook para /api/webhooks/asaas
    ↓
WebhookController valida e dispara:
  - Job ProcessConfirmedPayment
    ↓
Job ProcessConfirmedPayment:
  1. Atualiza RafflePurchase (status: confirmed)
  2. Marca números como vendidos (status: sold)
  3. Atualiza estatísticas da Raffle
  4. Cria Transaction
  5. [CPF] Marca Transaction (status: held)
  6. [CNPJ] Executa split payment
  7. Dispara Job SendPurchaseConfirmation
    ↓
Cliente recebe confirmação via WhatsApp
```

### 4. Fluxo de Sorteio Automático

```
Command DrawPendingRaffles roda via cron (a cada minuto)
    ↓
Busca rifas com:
  - status: active
  - draw_date <= now()
  - drawn_at IS NULL
    ↓
Para cada rifa:
  - Dispara Job ExecuteRaffleDraw
    ↓
Job ExecuteRaffleDraw:
  1. Busca todos os números vendidos
  2. Se nenhum vendido, cancela sorteio
  3. Sorteia número aleatório
  4. Busca RaffleNumber sorteado
  5. Marca número (is_winner: true)
  6. Cria RaffleWinner
  7. Atualiza Raffle:
     - drawn_at: now()
     - status: drawn
  8. Dispara Event RaffleDrawn
    ↓
Listener NotifyWinner:
  1. Envia notificação para ganhador via WhatsApp
  2. Envia e-mail
    ↓
[CPF] CreateDeliveryConfirmation Listener:
  1. Cria DeliveryConfirmation (status: pending)
  2. Gera token único
    ↓
Landing Page atualiza exibindo:
  - Animação de sorteio
  - Nome do ganhador
  - Número sorteado
```

### 5. Fluxo de Confirmação de Entrega (CPF)

```
Organizador CPF acessa /dashboard/rifas/{id}/entrega
    ↓
Visualiza dados do ganhador
    ↓
Clica em "Marcar Prêmio como Entregue"
    ↓
Sistema dispara Job SendDeliveryConfirmation
    ↓
Job SendDeliveryConfirmation:
  1. Busca DeliveryConfirmation
  2. WuzapiService envia mensagem WhatsApp:
     - Texto: "Olá [Nome], você confirmou o recebimento do prêmio [Prêmio]?"
     - Botões: [SIM] [NÃO]
  3. Atualiza status: message_sent
    ↓
Ganhador clica em um dos botões
    ↓
Wuzapi envia webhook para /api/webhooks/whatsapp
    ↓
WhatsAppWebhookController:
  1. Identifica token
  2. Busca DeliveryConfirmation
    ↓
[SE CONFIRMAR]:
  3. Atualiza status: confirmed
  4. Atualiza RaffleWinner (delivery_status: confirmed_by_winner)
  5. Dispara Job ReleaseCustodyFunds
    ↓
Job ReleaseCustodyFunds:
  1. Busca todas as Transactions da rifa (status: held)
  2. Calcula valor líquido (após taxas)
  3. AsaasService transfere para chave PIX do organizador
  4. Atualiza Transactions (status: completed, released_at: now())
  5. Atualiza Raffle (status: prize_delivered)
  6. Envia notificação ao organizador
    ↓
[SE NEGAR]:
  3. Atualiza status: denied
  4. Atualiza RaffleWinner (delivery_status: disputed)
  5. Cria AdminException:
     - type: delivery_disputed
     - severity: high
     - Aguarda ação manual do admin
    ↓
Admin acessa /admin/excecoes
    ↓
Resolve conflito manualmente
    ↓
Decide:
  - Liberar fundos para organizador
  - Reembolsar ganhador
  - Outra ação
```

### 6. Fluxo do Chatbot

```
Cliente na Landing Page clica no ícone do chatbot
    ↓
Modal do chatbot abre
    ↓
Cliente digita pergunta
    ↓
Frontend envia POST /api/chatbot
  - session_id (UUID gerado no cliente)
  - raffle_id
  - message
    ↓
ChatbotController:
  1. Salva mensagem em ChatbotConversation
  2. Busca contexto da conversa (últimas 5 mensagens)
  3. Busca dados da Raffle
  4. Chama ChatbotService
    ↓
ChatbotService:
  1. Prepara contexto para OpenAI:
     - Informações da rifa
     - Regulamento
     - FAQs gerais da plataforma
  2. OpenAIService.chatbotResponse()
  3. Retorna resposta
    ↓
Controller salva resposta do bot
    ↓
Retorna JSON para frontend
    ↓
Frontend exibe resposta no chat
```

---

## 🎨 Paleta de Cores (Agro Green)

```css
/* Definições Tailwind CSS */
colors: {
  'agro-green': {
    50: '#f0fdf4',   /* Backgrounds sutis */
    100: '#dcfce7',  /* Hover states leves */
    200: '#bbf7d0',  /* Badges, tags */
    300: '#86efac',  /* Borders, divisores */
    400: '#4ade80',  /* Elementos secundários */
    500: '#22c55e',  /* Cor primária principal */
    600: '#16a34a',  /* Botões, CTAs */
    700: '#15803d',  /* Hover em botões */
    800: '#166534',  /* Textos de destaque */
    900: '#14532d',  /* Textos escuros */
    950: '#052e16',  /* Backgrounds escuros */
  },
}
```

**Aplicação:**
- **Primária:** `agro-green-600` - Botões principais, links
- **Secundária:** `agro-green-100` - Backgrounds de cards
- **Acentos:** `agro-green-500` - Badges de status "ativo"
- **Textos:** `agro-green-900` - Títulos de seções
- **Bordas:** `agro-green-300` - Divisores e bordas sutis

---

## 🔐 Níveis de Permissão

### 1. Visitante (Não Autenticado)
- ✅ Ver home com rifas ativas
- ✅ Ver landing page de rifas
- ✅ Comprar números
- ✅ Usar chatbot

### 2. Organizador (Role: organizer)
- ✅ Todas as permissões de Visitante
- ✅ Criar rifas
- ✅ Editar/excluir próprias rifas
- ✅ Ver lista de clientes das próprias rifas
- ✅ Ver relatórios financeiros das próprias rifas
- ✅ [CPF] Marcar prêmio como entregue
- ✅ Configurar perfil e dados de pagamento

### 3. Administrador (Role: admin)
- ✅ Todas as permissões de Organizador
- ✅ Acessar painel admin
- ✅ Ver/editar todos os usuários
- ✅ Ver/gerenciar todas as rifas
- ✅ Suspender/bloquear usuários
- ✅ Resolver exceções
- ✅ Ver logs do sistema
- ✅ Acessar relatórios financeiros globais

---

## 📊 Estatísticas e Métricas

### Dashboard do Organizador
1. **Arrecadação Total:** Soma de `total_revenue` de todas as rifas
2. **Rifas Ativas:** Count de rifas com `status = active`
3. **Número de Compradores:** Count distinct de `raffle_participants` nas suas rifas
4. **Gráfico de Vendas:** Chart.js com vendas por dia (últimos 30 dias)

### Dashboard Admin
1. **Total de Usuários:** Count de `users`
2. **Rifas Totais:** Count de `raffles`
3. **Volume Financeiro:** Soma de todas as `transactions`
4. **Taxa de Conversão:** (Rifas completadas / Rifas criadas) * 100
5. **Exceções Abertas:** Count de `admin_exceptions` com `status = open`
6. **Gráficos:**
   - Cadastros por mês
   - Rifas criadas por mês
   - Volume financeiro por mês
   - Top 10 organizadores

---

## 🚀 Jobs Assíncronos (Queues)

### High Priority Queue
- `ProcessConfirmedPayment`
- `SendDeliveryConfirmation`
- `ExecuteRaffleDraw`

### Default Queue
- `SendPurchaseConfirmation`
- `UpdateRaffleStats`
- `GenerateRaffleNumbers`

### Low Priority Queue
- `SendEmailNotification`
- `GenerateMonthlyReport`

**Configuração em `config/queue.php`:**
```php
'connections' => [
    'redis' => [
        'driver' => 'redis',
        'connection' => 'default',
        'queue' => env('REDIS_QUEUE', 'default'),
        'retry_after' => 90,
        'block_for' => null,
    ],
],
```

---

## ⏰ Comandos Agendados (Schedule)

**Arquivo: `app/Console/Kernel.php`**

```php
protected function schedule(Schedule $schedule)
{
    // Executa sorteios pendentes (a cada minuto)
    $schedule->command('raffles:draw-pending')->everyMinute();
    
    // Expira reservas de números (a cada 5 minutos)
    $schedule->command('raffles:expire-reservations')->everyFiveMinutes();
    
    // Verifica status de pagamentos pendentes (a cada 10 minutos)
    $schedule->command('payments:check-pending')->everyTenMinutes();
    
    // Processa confirmações de entrega pendentes (a cada hora)
    $schedule->command('deliveries:process-confirmations')->hourly();
    
    // Backup do banco de dados (diário às 2h)
    $schedule->command('backup:run')->dailyAt('02:00');
    
    // Limpa logs antigos (semanal)
    $schedule->command('logs:clear')->weekly();
}
```

---

## 🔔 Sistema de Notificações

### Canais de Notificação
1. **E-mail** (via SMTP)
2. **WhatsApp** (via Wuzapi)
3. **Database** (notificações in-app)

### Notificações Implementadas

| Evento | Destinatário | Canal | Conteúdo |
|--------|--------------|-------|----------|
| Compra Confirmada | Cliente | WhatsApp + Email | Números comprados + dados da rifa |
| Sorteio Realizado | Todos participantes | WhatsApp | Resultado do sorteio |
| Você Ganhou! | Ganhador | WhatsApp + Email | Parabéns + instruções |
| Confirmação de Entrega | Ganhador | WhatsApp | Botões SIM/NÃO |
| Fundos Liberados | Organizador CPF | WhatsApp + Email | Valor transferido |
| Pagamento Recebido | Organizador CNPJ | Email | Extrato do split |
| Nova Exceção | Admin | Database + Email | Detalhes da exceção |

---

## 🧪 Checklist de Testes

### Testes Unitários
- [ ] Models: Relationships, Scopes, Accessors
- [ ] Services: AsaasService, WuzapiService, OpenAIService
- [ ] Helpers: Document validation, Formatting

### Testes de Integração
- [ ] Fluxo completo de cadastro
- [ ] Fluxo completo de criação de rifa
- [ ] Fluxo completo de compra (CPF e CNPJ)
- [ ] Fluxo de sorteio automático
- [ ] Fluxo de confirmação de entrega
- [ ] Webhooks Asaas
- [ ] Webhooks Wuzapi

### Testes de Performance
- [ ] Carga de 1000 rifas simultâneas
- [ ] Compra de 100 números simultâneos
- [ ] Geração de 10000 números
- [ ] Consultas ao banco otimizadas (< 100ms)

### Testes de Segurança
- [ ] Validação de CSRF em todos os forms
- [ ] SQL Injection prevention
- [ ] XSS prevention
- [ ] Rate limiting em APIs públicas
- [ ] Autorização em todas as rotas protegidas

---

## 📦 Dependências Principais

### Backend (Composer)
```json
{
  "require": {
    "php": "^8.3",
    "laravel/framework": "^11.0",
    "laravel/breeze": "^2.0",
    "spatie/laravel-sluggable": "^3.6",
    "spatie/laravel-permission": "^6.4",
    "guzzlehttp/guzzle": "^7.8",
    "mpdf/qrcode": "^1.2",
    "nesbot/carbon": "^3.0",
    "ramsey/uuid": "^4.7"
  },
  "require-dev": {
    "barryvdh/laravel-ide-helper": "^3.0",
    "barryvdh/laravel-debugbar": "^3.13",
    "phpunit/phpunit": "^11.0"
  }
}
```

### Frontend (NPM)
```json
{
  "devDependencies": {
    "@tailwindcss/forms": "^0.5.7",
    "@tailwindcss/typography": "^0.5.13",
    "@tailwindcss/aspect-ratio": "^0.4.2",
    "alpinejs": "^3.14.0",
    "axios": "^1.7.0",
    "chart.js": "^4.4.0",
    "laravel-vite-plugin": "^1.0",
    "lodash": "^4.17.21",
    "sweetalert2": "^11.12.0",
    "tailwindcss": "^3.4.0",
    "vite": "^5.0"
  }
}
```

---

## 🎯 Métricas de Sucesso

### KPIs do Produto
1. **Taxa de Conversão:** Visitantes → Compradores
2. **Ticket Médio:** Valor médio por compra
3. **Rifas Completadas:** % de rifas que atingem 100% de vendas
4. **Tempo Médio de Venda:** Tempo entre publicação e conclusão
5. **NPS:** Net Promoter Score dos organizadores

### KPIs Técnicos
1. **Uptime:** > 99.9%
2. **Tempo de Resposta:** < 200ms (p95)
3. **Taxa de Erro:** < 0.1%
4. **Cobertura de Testes:** > 80%
5. **Performance de Queries:** < 50ms (p95)

---

## 🔄 Versionamento e Releases

### Estratégia de Branches
```
main (production)
  ├── develop (staging)
  │   ├── feature/payment-integration
  │   ├── feature/ai-chatbot
  │   ├── feature/delivery-confirmation
  │   └── bugfix/number-reservation-timeout
  └── hotfix/critical-payment-bug
```

### Semantic Versioning
- **MAJOR:** Mudanças incompatíveis na API
- **MINOR:** Novas funcionalidades compatíveis
- **PATCH:** Correções de bugs

**Exemplo:** v1.2.3
- 1 = Major (primeira versão)
- 2 = Minor (2 novas features adicionadas)
- 3 = Patch (3ª correção de bug)

---

**Documento criado em:** 01/10/2025  
**Última atualização:** 01/10/2025  
**Versão:** 1.0


