<?php

namespace App\Http\Controllers;

use App\Models\Raffle;
use App\Models\BrazilState;
use App\Models\BrazilCity;
use Illuminate\Http\Request;
use Illuminate\View\View;

class RaffleController extends Controller
{
    /**
     * Display a listing of active raffles.
     */
    public function index(Request $request): View
    {
        $query = Raffle::active()->with('organizer');

        // Filter by ID if provided
        if ($request->has('raffle_id') && !empty($request->raffle_id)) {
            $query->byId($request->raffle_id);
        }

        // Filter by category if provided
        if ($request->has('category') && $request->category !== 'all') {
            $query->byCategory($request->category);
        }

        // Filter by state if provided
        if ($request->has('state') && $request->state !== 'all') {
            $query->byState($request->state);
        }

        // Filter by city if provided
        if ($request->has('city') && $request->city !== 'all') {
            $query->byCity($request->city);
        }

        // Filter by price range if provided
        if ($request->has('min_price') && $request->min_price) {
            $minPrice = (float) $request->min_price;
            $maxPrice = $request->has('max_price') && $request->max_price ? (float) $request->max_price : 999999;
            $query->byPriceRange($minPrice, $maxPrice);
        }

        // Search functionality
        if ($request->has('search') && !empty($request->search)) {
            $searchTerm = $request->search;
            $query->where(function ($q) use ($searchTerm) {
                $q->where('title', 'LIKE', "%{$searchTerm}%")
                  ->orWhere('description', 'LIKE', "%{$searchTerm}%")
                  ->orWhere('prize_description', 'LIKE', "%{$searchTerm}%");
            });
        }

        // Sort options
        $sortBy = $request->get('sort', 'featured');
        switch ($sortBy) {
            case 'newest':
                $query->orderBy('created_at', 'desc');
                break;
            case 'oldest':
                $query->orderBy('created_at', 'asc');
                break;
            case 'price_low':
                $query->orderBy('price_per_ticket', 'asc');
                break;
            case 'price_high':
                $query->orderBy('price_per_ticket', 'desc');
                break;
            case 'ending_soon':
                $query->orderBy('draw_date', 'asc');
                break;
            case 'progress':
                $query->orderByRaw('(sold_tickets / total_tickets) DESC');
                break;
            default: // featured
                $query->orderBy('featured', 'desc')
                      ->orderBy('created_at', 'desc');
        }

        $raffles = $query->paginate(12);

        // Get filter options
        $categories = Raffle::active()
            ->select('category')
            ->distinct()
            ->pluck('category')
            ->filter()
            ->sort()
            ->values();

        // Get all Brazilian states
        $states = BrazilState::orderBy('name')->get();

        // Get cities based on selected state
        $cities = collect();
        if ($request->has('state') && $request->state !== 'all') {
            $state = BrazilState::where('name', $request->state)->first();
            if ($state) {
                $cities = $state->cities()->orderBy('name')->get();
            }
        }

        // Get price range
        $priceRange = Raffle::active()
            ->selectRaw('MIN(price_per_ticket) as min_price, MAX(price_per_ticket) as max_price')
            ->first();

        // Get featured raffles for the marketplace
        $featuredRaffles = Raffle::active()
            ->featured()
            ->with('organizer')
            ->orderBy('progress_percentage', 'desc')
            ->orderBy('created_at', 'desc')
            ->limit(6)
            ->get();

        return view('raffles.index', compact('raffles', 'categories', 'states', 'cities', 'priceRange', 'featuredRaffles'));
    }

    /**
     * Display the specified raffle.
     */
    public function show(Raffle $raffle): View
    {
        // Check if raffle is public and active
        if (!$raffle->is_public || !$raffle->isActive()) {
            abort(404);
        }

        // Load relationships
        $raffle->load(['organizer', 'tickets.paid', 'prizes']);
        
        // Load organizer's raffles for statistics
        $raffle->organizer->load('raffles');

        // Get recent tickets for this raffle
        $recentTickets = $raffle->tickets()
            ->paid()
            ->orderBy('purchased_at', 'desc')
            ->limit(10)
            ->get();

        // Get similar raffles
        $similarRaffles = Raffle::active()
            ->where('id', '!=', $raffle->id)
            ->where('category', $raffle->category)
            ->with('organizer')
            ->limit(4)
            ->get();

        return view('raffles.show', compact('raffle', 'recentTickets', 'similarRaffles'));
    }

    /**
     * Get active raffles for homepage.
     */
    public function getActiveRaffles()
    {
        return Raffle::active()
            ->with('organizer')
            ->orderBy('featured', 'desc')
            ->orderBy('created_at', 'desc')
            ->limit(6)
            ->get();
    }

    /**
     * Get featured raffles for homepage.
     */
    public function getFeaturedRaffles()
    {
        return Raffle::active()
            ->featured()
            ->with('organizer')
            ->orderBy('created_at', 'desc')
            ->limit(3)
            ->get();
    }

    /**
     * Get raffles by category.
     */
    public function getRafflesByCategory($category)
    {
        return Raffle::active()
            ->byCategory($category)
            ->with('organizer')
            ->orderBy('featured', 'desc')
            ->orderBy('created_at', 'desc')
            ->limit(6)
            ->get();
    }

    /**
     * Get raffle statistics.
     */
    public function getRaffleStats()
    {
        $totalRaffles = Raffle::active()->count();
        $totalTicketsSold = Raffle::active()->sum('sold_tickets');
        $totalAmountRaised = Raffle::active()
            ->get()
            ->sum(function ($raffle) {
                return $raffle->sold_tickets * $raffle->price_per_ticket;
            });

        return [
            'total_active_raffles' => $totalRaffles,
            'total_tickets_sold' => $totalTicketsSold,
            'total_amount_raised' => $totalAmountRaised,
        ];
    }

    /**
     * Add raffle tickets to cart (requires authentication)
     */
    public function addToCart(Request $request, Raffle $raffle)
    {
        // Check if user is authenticated
        if (!auth()->check()) {
            return response()->json(['error' => 'Faça login para adicionar itens ao carrinho'], 401);
        }

        $request->validate([
            'quantity' => 'required|integer|min:1|max:50'
        ]);

        $quantity = $request->quantity;
        $user = auth()->user();

        // Check if user already has this raffle in cart
        $existingCart = \App\Models\Cart::where('user_id', $user->id)
            ->where('raffle_id', $raffle->id)
            ->first();

        if ($existingCart) {
            $newQuantity = $existingCart->ticket_quantity + $quantity;
            $existingCart->update([
                'ticket_quantity' => $newQuantity,
                'total_price' => $newQuantity * $raffle->price_per_ticket
            ]);
        } else {
            \App\Models\Cart::create([
                'user_id' => $user->id,
                'raffle_id' => $raffle->id,
                'ticket_quantity' => $quantity,
                'total_price' => $quantity * $raffle->price_per_ticket
            ]);
        }

        return response()->json([
            'success' => true,
            'message' => "{$quantity} bilhetes adicionados ao carrinho!",
            'cart_count' => \App\Models\Cart::where('user_id', $user->id)->sum('ticket_quantity')
        ]);
    }

    /**
     * Purchase raffle tickets directly with number selection (requires authentication)
     */
    public function purchase(Request $request, Raffle $raffle)
    {
        // Check if user is authenticated
        if (!auth()->check()) {
            return response()->json(['error' => 'Faça login para comprar bilhetes da rifa.'], 401);
        }

        $request->validate([
            'selected_numbers' => 'required|array|min:1',
            'selected_numbers.*' => 'integer|min:1|max:' . $raffle->total_tickets
        ]);

        $selectedNumbers = $request->selected_numbers;
        $quantity = count($selectedNumbers);
        $totalPrice = $quantity * $raffle->price_per_ticket;

        // Check if raffle is still active
        if (!$raffle->isActive()) {
            return response()->json(['error' => 'Esta rifa não está mais ativa.'], 400);
        }

        // Check if numbers are still available
        $unavailableNumbers = [];
        foreach ($selectedNumbers as $number) {
            // Check if number is already sold (simplified check - in real app, you'd check tickets table)
            if ($number <= $raffle->sold_tickets) {
                $unavailableNumbers[] = $number;
            }
        }

        if (!empty($unavailableNumbers)) {
            return response()->json([
                'error' => 'Alguns números selecionados já foram vendidos: ' . implode(', ', $unavailableNumbers)
            ], 400);
        }

        // Store purchase in session for payment processing
        session([
            'pending_purchase' => [
                'raffle_id' => $raffle->id,
                'selected_numbers' => $selectedNumbers,
                'quantity' => $quantity,
                'total_price' => $totalPrice,
                'timestamp' => now()->timestamp
            ]
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Números selecionados com sucesso! Redirecionando para pagamento...',
            'redirect_url' => route('payment.methods')
        ]);
    }
}
