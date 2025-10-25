<?php

namespace App\Http\Controllers\Marketplace;

use App\Http\Controllers\Controller;
use App\Models\Raffle;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\View\View;

class WishlistController extends Controller
{
    /**
     * Display user's wishlist.
     */
    public function index(): View
    {
        if (!auth()->check()) {
            return redirect()->route('login');
        }

        $wishlist = auth()->user()->wishlist()
            ->with('raffle.organizer')
            ->paginate(12);

        return view('marketplace.wishlist', compact('wishlist'));
    }

    /**
     * Add raffle to wishlist.
     */
    public function store(Request $request, Raffle $raffle): JsonResponse
    {
        if (!auth()->check()) {
            return response()->json(['error' => 'Login required'], 401);
        }

        $user = auth()->user();
        
        if ($user->wishlist()->where('raffle_id', $raffle->id)->exists()) {
            return response()->json(['error' => 'Already in wishlist'], 400);
        }

        $user->wishlist()->create(['raffle_id' => $raffle->id]);

        return response()->json([
            'success' => true,
            'message' => 'Added to wishlist'
        ]);
    }

    /**
     * Remove raffle from wishlist.
     */
    public function destroy(Raffle $raffle): JsonResponse
    {
        if (!auth()->check()) {
            return response()->json(['error' => 'Login required'], 401);
        }

        auth()->user()->wishlist()->where('raffle_id', $raffle->id)->delete();

        return response()->json([
            'success' => true,
            'message' => 'Removed from wishlist'
        ]);
    }

    /**
     * Toggle raffle in wishlist.
     */
    public function toggle(Request $request, Raffle $raffle): JsonResponse
    {
        if (!auth()->check()) {
            return response()->json(['error' => 'Login required'], 401);
        }

        $user = auth()->user();
        $inWishlist = $user->wishlist()->where('raffle_id', $raffle->id)->exists();

        if ($inWishlist) {
            $user->wishlist()->where('raffle_id', $raffle->id)->delete();
            $message = 'Removed from wishlist';
            $action = 'removed';
        } else {
            $user->wishlist()->create(['raffle_id' => $raffle->id]);
            $message = 'Added to wishlist';
            $action = 'added';
        }

        return response()->json([
            'success' => true,
            'message' => $message,
            'action' => $action,
            'in_wishlist' => !$inWishlist
        ]);
    }

    /**
     * Get wishlist count.
     */
    public function count(): JsonResponse
    {
        if (!auth()->check()) {
            return response()->json(['count' => 0]);
        }

        $count = auth()->user()->wishlist()->count();

        return response()->json(['count' => $count]);
    }

    /**
     * Check if raffle is in wishlist.
     */
    public function check(Raffle $raffle): JsonResponse
    {
        if (!auth()->check()) {
            return response()->json(['in_wishlist' => false]);
        }

        $inWishlist = auth()->user()->wishlist()->where('raffle_id', $raffle->id)->exists();

        return response()->json(['in_wishlist' => $inWishlist]);
    }
}
