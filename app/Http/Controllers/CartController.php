<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Raffle;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class CartController extends Controller
{
    /**
     * Display the cart page.
     */
    public function index()
    {
        $cartItems = $this->getCartItems();
        $totalAmount = $cartItems->sum('total_price');
        
        return view('cart.index', compact('cartItems', 'totalAmount'));
    }

    /**
     * Add item to cart.
     */
    public function store(Request $request)
    {
        $request->validate([
            'raffle_id' => 'required|exists:raffles,id',
            'quantity' => 'required|integer|min:1',
        ]);

        $raffle = Raffle::findOrFail($request->raffle_id);
        
        // Check if raffle is active and has enough tickets
        if (!$raffle->isActive()) {
            return response()->json(['error' => 'Esta rifa não está mais ativa.'], 400);
        }
        
        if ($request->quantity > $raffle->remaining_tickets) {
            return response()->json(['error' => 'Quantidade solicitada excede os bilhetes disponíveis.'], 400);
        }

        $totalPrice = $request->quantity * $raffle->price_per_ticket;
        
        // Get user ID or session ID
        $userId = Auth::id();
        $sessionId = $userId ? null : Session::getId();
        
        // Check if item already exists in cart
        $existingItem = Cart::where(function ($query) use ($userId, $sessionId) {
            if ($userId) {
                $query->where('user_id', $userId);
            } else {
                $query->where('session_id', $sessionId);
            }
        })->where('raffle_id', $request->raffle_id)->first();
        
        if ($existingItem) {
            // Update existing item
            $existingItem->update([
                'ticket_quantity' => $request->quantity,
                'total_price' => $totalPrice,
            ]);
            $message = 'Quantidade atualizada no carrinho.';
        } else {
            // Create new cart item
            Cart::create([
                'user_id' => $userId,
                'raffle_id' => $request->raffle_id,
                'ticket_quantity' => $request->quantity,
                'total_price' => $totalPrice,
                'session_id' => $sessionId,
            ]);
            $message = 'Item adicionado ao carrinho.';
        }
        
        $cartCount = $this->getCartItems()->count();
        
        return response()->json([
            'success' => true,
            'message' => $message,
            'cart_count' => $cartCount,
        ]);
    }

    /**
     * Update cart item quantity.
     */
    public function update(Request $request, Cart $cart)
    {
        $request->validate([
            'quantity' => 'required|integer|min:1',
        ]);

        // Check ownership
        if (!$this->canAccessCartItem($cart)) {
            return response()->json(['error' => 'Acesso negado.'], 403);
        }
        
        $raffle = $cart->raffle;
        
        if ($request->quantity > $raffle->remaining_tickets) {
            return response()->json(['error' => 'Quantidade solicitada excede os bilhetes disponíveis.'], 400);
        }
        
        $totalPrice = $request->quantity * $raffle->price_per_ticket;
        
        $cart->update([
            'ticket_quantity' => $request->quantity,
            'total_price' => $totalPrice,
        ]);
        
        return response()->json([
            'success' => true,
            'message' => 'Quantidade atualizada.',
            'total_price' => $totalPrice,
        ]);
    }

    /**
     * Remove item from cart.
     */
    public function destroy(Cart $cart)
    {
        // Check ownership
        if (!$this->canAccessCartItem($cart)) {
            return response()->json(['error' => 'Acesso negado.'], 403);
        }
        
        $cart->delete();
        
        $cartCount = $this->getCartItems()->count();
        
        return response()->json([
            'success' => true,
            'message' => 'Item removido do carrinho.',
            'cart_count' => $cartCount,
        ]);
    }

    /**
     * Clear all items from cart.
     */
    public function clear()
    {
        $userId = Auth::id();
        $sessionId = $userId ? null : Session::getId();
        
        Cart::where(function ($query) use ($userId, $sessionId) {
            if ($userId) {
                $query->where('user_id', $userId);
            } else {
                $query->where('session_id', $sessionId);
            }
        })->delete();
        
        return response()->json([
            'success' => true,
            'message' => 'Carrinho esvaziado.',
        ]);
    }

    /**
     * Get cart items for current user/session.
     */
    private function getCartItems()
    {
        $userId = Auth::id();
        $sessionId = $userId ? null : Session::getId();
        
        return Cart::with('raffle')
            ->where(function ($query) use ($userId, $sessionId) {
                if ($userId) {
                    $query->where('user_id', $userId);
                } else {
                    $query->where('session_id', $sessionId);
                }
            })
            ->get();
    }

    /**
     * Check if user can access cart item.
     */
    private function canAccessCartItem(Cart $cart)
    {
        $userId = Auth::id();
        $sessionId = $userId ? null : Session::getId();
        
        if ($userId) {
            return $cart->user_id === $userId;
        } else {
            return $cart->session_id === $sessionId;
        }
    }

    /**
     * Get cart count for AJAX requests.
     */
    public function count()
    {
        $cartCount = $this->getCartItems()->count();
        
        return response()->json(['count' => $cartCount]);
    }
}


