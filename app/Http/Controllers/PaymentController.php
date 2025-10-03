<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PaymentController extends Controller
{
    /**
     * Show payment methods selection page
     */
    public function methods()
    {
        $pendingPurchase = session('pending_purchase');
        
        if (!$pendingPurchase) {
            return redirect()->route('raffles.index')->with('error', 'Nenhuma compra pendente encontrada.');
        }

        // Load raffle details
        $raffle = \App\Models\Raffle::findOrFail($pendingPurchase['raffle_id']);
        
        return view('payment.methods', compact('pendingPurchase', 'raffle'));
    }

    /**
     * Process payment with selected method
     */
    public function process(Request $request)
    {
        $request->validate([
            'payment_method' => 'required|in:pix,credit_card'
        ]);

        $pendingPurchase = session('pending_purchase');
        
        if (!$pendingPurchase) {
            return response()->json(['error' => 'Nenhuma compra pendente encontrada.'], 400);
        }

        $raffle = \App\Models\Raffle::findOrFail($pendingPurchase['raffle_id']);
        
        // Check if raffle is still active
        if (!$raffle->isActive()) {
            return response()->json(['error' => 'Esta rifa não está mais ativa.'], 400);
        }

        // Simulate payment processing
        $paymentResult = $this->processPayment($request->payment_method, $pendingPurchase['total_price']);
        
        if ($paymentResult['success']) {
            // Create tickets
            $this->createTickets($raffle, $pendingPurchase['selected_numbers'], Auth::user());
            
            // Clear pending purchase from session
            session()->forget('pending_purchase');
            
            return response()->json([
                'success' => true,
                'message' => 'Compra realizada com sucesso! Seus números foram reservados.',
                'redirect_url' => route('payment.success')
            ]);
        } else {
            return response()->json([
                'error' => $paymentResult['error']
            ], 400);
        }
    }

    /**
     * Show payment success page
     */
    public function success()
    {
        return view('payment.success');
    }

    /**
     * Simulate payment processing
     */
    private function processPayment($method, $amount)
    {
        // Simulate payment processing delay
        sleep(1);
        
        // For demo purposes, always succeed
        // In real app, integrate with payment gateways
        return [
            'success' => true,
            'transaction_id' => 'TXN_' . time() . '_' . rand(1000, 9999),
            'method' => $method,
            'amount' => $amount
        ];
    }

    /**
     * Create tickets for purchased numbers
     */
    private function createTickets($raffle, $selectedNumbers, $user)
    {
        foreach ($selectedNumbers as $number) {
            \App\Models\Ticket::create([
                'raffle_id' => $raffle->id,
                'participant_id' => $user->id,
                'participant_email' => $user->email,
                'participant_name' => $user->name,
                'ticket_number' => $number,
                'price_paid' => $raffle->price_per_ticket,
                'status' => 'paid'
            ]);
        }

        // Update raffle sold tickets count
        $raffle->increment('sold_tickets', count($selectedNumbers));
        
        // Update progress percentage
        $raffle->update([
            'progress_percentage' => ($raffle->sold_tickets / $raffle->total_tickets) * 100
        ]);
    }
}

