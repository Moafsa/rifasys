<?php

namespace App\Http\Controllers;

use App\Models\Raffle;
use App\Models\RaffleTicket;
use App\Models\User;
use App\Services\WuzapiRaffles;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class RaffleController extends Controller
{
    protected WuzapiRaffles $wuzapiRaffles;

    public function __construct(WuzapiRaffles $wuzapiRaffles)
    {
        $this->wuzapiRaffles = $wuzapiRaffles;
    }

    /**
     * Create a new raffle and send notification
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'price_per_ticket' => 'required|numeric|min:0.01',
            'total_tickets' => 'required|integer|min:1',
            'draw_date' => 'required|date|after:now',
        ]);

        $raffle = Raffle::create([
            'user_id' => Auth::id(),
            'title' => $request->title,
            'description' => $request->description,
            'price_per_ticket' => $request->price_per_ticket,
            'total_tickets' => $request->total_tickets,
            'available_tickets' => $request->total_tickets,
            'draw_date' => $request->draw_date,
            'status' => 'active',
        ]);

        // Send WhatsApp notification to raffle creator
        if (config('services.wuzapi.raffle_notifications.enabled')) {
            try {
                $this->wuzapiRaffles->sendRaffleCreatedNotification($raffle, Auth::user());
            } catch (\Exception $e) {
                Log::error('Failed to send raffle creation notification', [
                    'raffle_id' => $raffle->id,
                    'user_id' => Auth::id(),
                    'error' => $e->getMessage()
                ]);
            }
        }

        return redirect()->route('raffles.show', $raffle)
            ->with('success', 'Rifa criada com sucesso!');
    }

    /**
     * Process ticket purchase and send confirmation
     */
    public function purchaseTickets(Request $request, Raffle $raffle)
    {
        $request->validate([
            'numbers' => 'required|array|min:1',
            'numbers.*' => 'integer|min:1|max:' . $raffle->total_tickets,
        ]);

        $numbers = $request->numbers;
        $totalAmount = count($numbers) * $raffle->price_per_ticket;

        // Check if numbers are available
        $existingTickets = RaffleTicket::where('raffle_id', $raffle->id)
            ->whereIn('number', $numbers)
            ->exists();

        if ($existingTickets) {
            return back()->with('error', 'Alguns números já foram comprados.');
        }

        // Create tickets
        foreach ($numbers as $number) {
            RaffleTicket::create([
                'raffle_id' => $raffle->id,
                'user_id' => Auth::id(),
                'number' => $number,
                'purchase_date' => now(),
            ]);
        }

        // Update raffle available tickets
        $raffle->update([
            'available_tickets' => $raffle->available_tickets - count($numbers)
        ]);

        // Send WhatsApp confirmation
        if (config('services.wuzapi.raffle_notifications.purchase_confirmation')) {
            try {
                $this->wuzapiRaffles->sendTicketPurchaseSummary(
                    $raffle,
                    $numbers,
                    Auth::user(),
                    $totalAmount
                );
            } catch (\Exception $e) {
                Log::error('Failed to send purchase confirmation', [
                    'raffle_id' => $raffle->id,
                    'user_id' => Auth::id(),
                    'error' => $e->getMessage()
                ]);
            }
        }

        return redirect()->route('raffles.show', $raffle)
            ->with('success', 'Números comprados com sucesso!');
    }

    /**
     * Draw raffle and send notifications
     */
    public function drawRaffle(Raffle $raffle)
    {
        if ($raffle->user_id !== Auth::id()) {
            abort(403, 'Unauthorized');
        }

        if ($raffle->status !== 'active') {
            return back()->with('error', 'Esta rifa não está ativa.');
        }

        // Generate winning number
        $winningNumber = rand(1, $raffle->total_tickets);
        
        // Find winner
        $winningTicket = RaffleTicket::where('raffle_id', $raffle->id)
            ->where('number', $winningNumber)
            ->first();

        // Update raffle status
        $raffle->update([
            'status' => 'completed',
            'winning_number' => $winningNumber,
            'winner_id' => $winningTicket ? $winningTicket->user_id : null,
        ]);

        // Send draw notification to organizer
        if (config('services.wuzapi.raffle_notifications.draw_notifications')) {
            try {
                $this->wuzapiRaffles->sendRaffleDrawNotification($raffle, $winningNumber);
            } catch (\Exception $e) {
                Log::error('Failed to send draw notification', [
                    'raffle_id' => $raffle->id,
                    'error' => $e->getMessage()
                ]);
            }
        }

        // Send winner notification
        if ($winningTicket && config('services.wuzapi.raffle_notifications.winner_notifications')) {
            try {
                $this->wuzapiRaffles->sendWinnerNotification(
                    $raffle,
                    $winningTicket->user,
                    $winningNumber
                );
            } catch (\Exception $e) {
                Log::error('Failed to send winner notification', [
                    'raffle_id' => $raffle->id,
                    'winner_id' => $winningTicket->user_id,
                    'error' => $e->getMessage()
                ]);
            }
        }

        return redirect()->route('raffles.show', $raffle)
            ->with('success', 'Sorteio realizado! Número sorteado: ' . $winningNumber);
    }

    /**
     * Send raffle reminder
     */
    public function sendReminder(Raffle $raffle)
    {
        if ($raffle->user_id !== Auth::id()) {
            abort(403, 'Unauthorized');
        }

        try {
            $this->wuzapiRaffles->sendRaffleReminder($raffle, Auth::user());
            
            return back()->with('success', 'Lembrete enviado com sucesso!');
        } catch (\Exception $e) {
            Log::error('Failed to send raffle reminder', [
                'raffle_id' => $raffle->id,
                'user_id' => Auth::id(),
                'error' => $e->getMessage()
            ]);
            
            return back()->with('error', 'Falha ao enviar lembrete.');
        }
    }

    /**
     * Share raffle via WhatsApp
     */
    public function shareRaffle(Raffle $raffle, Request $request)
    {
        $request->validate([
            'phone' => 'required|string'
        ]);

        try {
            $this->wuzapiRaffles->sendRaffleShare($raffle, $request->phone);
            
            return back()->with('success', 'Rifa compartilhada com sucesso!');
        } catch (\Exception $e) {
            Log::error('Failed to share raffle', [
                'raffle_id' => $raffle->id,
                'phone' => $request->phone,
                'error' => $e->getMessage()
            ]);
            
            return back()->with('error', 'Falha ao compartilhar rifa.');
        }
    }

    /**
     * Update raffle status and send notification
     */
    public function updateStatus(Raffle $raffle, Request $request)
    {
        $request->validate([
            'status' => 'required|in:active,paused,cancelled,completed'
        ]);

        $raffle->update(['status' => $request->status]);

        // Send status update notification
        if (config('services.wuzapi.raffle_notifications.enabled')) {
            try {
                $this->wuzapiRaffles->sendRaffleStatusUpdate(
                    $raffle,
                    $request->status,
                    $raffle->user->phone
                );
            } catch (\Exception $e) {
                Log::error('Failed to send status update', [
                    'raffle_id' => $raffle->id,
                    'status' => $request->status,
                    'error' => $e->getMessage()
                ]);
            }
        }

        return back()->with('success', 'Status da rifa atualizado!');
    }
}