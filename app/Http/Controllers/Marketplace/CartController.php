<?php

namespace App\Http\Controllers\Marketplace;

use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Models\Raffle;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\View\View;

class CartController extends Controller
{
    /**
     * Display the shopping cart.
     */
    public function index(): View
    {
        if (!auth()->check()) {
            return redirect()->route('login');
        }

        $cartItems = Cart::where('user_id', auth()->id())
            ->with('raffle.organizer')
            ->get();

        $subtotal = $cartItems->sum('total_price');
        $totalItems = $cartItems->sum('ticket_quantity');

        return view('marketplace.cart', compact('cartItems', 'subtotal', 'totalItems'));
    }

    /**
     * Add raffle to cart.
     */
    public function store(Request $request, Raffle $raffle): JsonResponse
    {
        if (!auth()->check()) {
            return response()->json(['error' => 'Login required'], 401);
        }

        $request->validate([
            'quantity' => 'required|integer|min:1|max:50'
        ]);

        $quantity = $request->quantity;
        $user = auth()->user();

        // Check if raffle is still active
        if (!$raffle->isActive()) {
            return response()->json(['error' => 'This raffle is no longer active'], 400);
        }

        // Check if user already has this raffle in cart
        $existingCart = Cart::where('user_id', $user->id)
            ->where('raffle_id', $raffle->id)
            ->first();

        if ($existingCart) {
            $newQuantity = $existingCart->ticket_quantity + $quantity;
            $existingCart->update([
                'ticket_quantity' => $newQuantity,
                'total_price' => $newQuantity * $raffle->price_per_ticket
            ]);
        } else {
            Cart::create([
                'user_id' => $user->id,
                'raffle_id' => $raffle->id,
                'ticket_quantity' => $quantity,
                'total_price' => $quantity * $raffle->price_per_ticket
            ]);
        }

        $cartCount = Cart::where('user_id', $user->id)->sum('ticket_quantity');

        return response()->json([
            'success' => true,
            'message' => "{$quantity} tickets added to cart!",
            'cart_count' => $cartCount
        ]);
    }

    /**
     * Update cart item quantity.
     */
    public function update(Request $request, Cart $cart): JsonResponse
    {
        if (!auth()->check() || $cart->user_id !== auth()->id()) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        $request->validate([
            'quantity' => 'required|integer|min:1|max:50'
        ]);

        $quantity = $request->quantity;
        $cart->update([
            'ticket_quantity' => $quantity,
            'total_price' => $quantity * $cart->raffle->price_per_ticket
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Cart updated successfully'
        ]);
    }

    /**
     * Remove item from cart.
     */
    public function destroy(Cart $cart): JsonResponse
    {
        if (!auth()->check() || $cart->user_id !== auth()->id()) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        $cart->delete();

        $cartCount = Cart::where('user_id', auth()->id())->sum('ticket_quantity');

        return response()->json([
            'success' => true,
            'message' => 'Item removed from cart',
            'cart_count' => $cartCount
        ]);
    }

    /**
     * Clear entire cart.
     */
    public function clear(): JsonResponse
    {
        if (!auth()->check()) {
            return response()->json(['error' => 'Login required'], 401);
        }

        Cart::where('user_id', auth()->id())->delete();

        return response()->json([
            'success' => true,
            'message' => 'Cart cleared successfully'
        ]);
    }

    /**
     * Get cart count.
     */
    public function count(): JsonResponse
    {
        if (!auth()->check()) {
            return response()->json(['cart_count' => 0]);
        }

        $cartCount = Cart::where('user_id', auth()->id())->sum('ticket_quantity');

        return response()->json(['cart_count' => $cartCount]);
    }

    /**
     * Get cart summary for header.
     */
    public function summary(): JsonResponse
    {
        if (!auth()->check()) {
            return response()->json(['items' => [], 'total' => 0, 'count' => 0]);
        }

        $cartItems = Cart::where('user_id', auth()->id())
            ->with('raffle')
            ->get();

        $total = $cartItems->sum('total_price');
        $count = $cartItems->sum('ticket_quantity');

        return response()->json([
            'items' => $cartItems,
            'total' => $total,
            'count' => $count
        ]);
    }
}
