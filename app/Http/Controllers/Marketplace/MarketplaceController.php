<?php

namespace App\Http\Controllers\Marketplace;

use App\Http\Controllers\Controller;
use App\Models\Raffle;
use App\Models\BrazilState;
use App\Models\BrazilCity;
use App\Models\Cart;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\JsonResponse;

class MarketplaceController extends Controller
{
    /**
     * Display the marketplace dashboard with lateral header.
     */
    public function index(Request $request): View
    {
        try {
            $query = Raffle::active()->with('organizer');

            // Apply filters
            $this->applyFilters($query, $request);

            // Apply sorting
            $this->applySorting($query, $request);

            $raffles = $query->paginate(12);

            // Get filter options
            $filterData = $this->getFilterData($request);

            // Get marketplace statistics
            $stats = $this->getMarketplaceStats();

            // Get featured raffles
            $featuredRaffles = Raffle::active()
                ->featured()
                ->with('organizer')
                ->orderBy('progress_percentage', 'desc')
                ->limit(6)
                ->get();

            // Get user's cart count if authenticated
            $cartCount = auth()->check() ? Cart::where('user_id', auth()->id())->sum('ticket_quantity') : 0;

            return view('marketplace.index', compact(
                'raffles', 
                'filterData', 
                'stats', 
                'featuredRaffles', 
                'cartCount'
            ));
        } catch (\Exception $e) {
            // Log the error for debugging
            \Log::error('Marketplace error: ' . $e->getMessage());
            
            // Fallback to simple view if there's an error
            return view('marketplace.simple');
        }
    }

    /**
     * Display marketplace categories.
     */
    public function categories(): View
    {
        $categories = Raffle::active()
            ->select('category')
            ->distinct()
            ->pluck('category')
            ->filter()
            ->map(function ($category) {
                return [
                    'name' => $category,
                    'count' => Raffle::active()->byCategory($category)->count(),
                    'icon' => $this->getCategoryIcon($category),
                    'color' => $this->getCategoryColor($category)
                ];
            })
            ->sortBy('name');

        return view('marketplace.categories', compact('categories'));
    }

    /**
     * Display raffles by category.
     */
    public function category(Request $request, string $category): View
    {
        $query = Raffle::active()
            ->byCategory($category)
            ->with('organizer');

        $this->applyFilters($query, $request);
        $this->applySorting($query, $request);

        $raffles = $query->paginate(12);
        $filterData = $this->getFilterData($request);

        return view('marketplace.category', compact('raffles', 'filterData', 'category'));
    }

    /**
     * Display marketplace search results.
     */
    public function search(Request $request): View
    {
        $query = Raffle::active()->with('organizer');

        // Search functionality
        if ($request->has('q') && !empty($request->q)) {
            $searchTerm = $request->q;
            $query->where(function ($q) use ($searchTerm) {
                $q->where('title', 'LIKE', "%{$searchTerm}%")
                  ->orWhere('description', 'LIKE', "%{$searchTerm}%")
                  ->orWhere('prize_description', 'LIKE', "%{$searchTerm}%");
            });
        }

        $this->applyFilters($query, $request);
        $this->applySorting($query, $request);

        $raffles = $query->paginate(12);
        $filterData = $this->getFilterData($request);

        return view('marketplace.search', compact('raffles', 'filterData'));
    }

    /**
     * Display user's wishlist.
     */
    public function wishlist(): View
    {
        if (!auth()->check()) {
            return redirect()->route('login');
        }

        $wishlist = auth()->user()->wishlist()->with('raffle.organizer')->paginate(12);

        return view('marketplace.wishlist', compact('wishlist'));
    }

    /**
     * Add raffle to wishlist.
     */
    public function addToWishlist(Request $request, Raffle $raffle): JsonResponse
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
    public function removeFromWishlist(Raffle $raffle): JsonResponse
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
     * Get marketplace recommendations.
     */
    public function recommendations(): JsonResponse
    {
        $recommendations = Raffle::active()
            ->featured()
            ->with('organizer')
            ->orderBy('progress_percentage', 'desc')
            ->limit(6)
            ->get();

        return response()->json($recommendations);
    }

    /**
     * Apply filters to query.
     */
    private function applyFilters($query, Request $request): void
    {
        // Filter by category
        if ($request->has('category') && $request->category !== 'all') {
            $query->byCategory($request->category);
        }

        // Filter by state
        if ($request->has('state') && $request->state !== 'all') {
            $query->byState($request->state);
        }

        // Filter by city
        if ($request->has('city') && $request->city !== 'all') {
            $query->byCity($request->city);
        }

        // Filter by price range
        if ($request->has('min_price') && $request->min_price) {
            $minPrice = (float) $request->min_price;
            $maxPrice = $request->has('max_price') && $request->max_price ? (float) $request->max_price : 999999;
            $query->byPriceRange($minPrice, $maxPrice);
        }
    }

    /**
     * Apply sorting to query.
     */
    private function applySorting($query, Request $request): void
    {
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
    }

    /**
     * Get filter data for the view.
     */
    private function getFilterData(Request $request): array
    {
        $categories = Raffle::active()
            ->select('category')
            ->distinct()
            ->pluck('category')
            ->filter()
            ->sort()
            ->values();

        $states = BrazilState::orderBy('name')->get();

        $cities = collect();
        if ($request->has('state') && $request->state !== 'all') {
            $state = BrazilState::where('name', $request->state)->first();
            if ($state) {
                $cities = $state->cities()->orderBy('name')->get();
            }
        }

        $priceRange = Raffle::active()
            ->selectRaw('MIN(price_per_ticket) as min_price, MAX(price_per_ticket) as max_price')
            ->first();

        return [
            'categories' => $categories,
            'states' => $states,
            'cities' => $cities,
            'priceRange' => $priceRange
        ];
    }

    /**
     * Get marketplace statistics.
     */
    private function getMarketplaceStats(): array
    {
        $totalRaffles = Raffle::active()->count();
        $totalTicketsSold = Raffle::active()->sum('sold_tickets');

        return [
            'total_active_raffles' => $totalRaffles,
            'total_tickets_sold' => $totalTicketsSold,
        ];
    }

    /**
     * Get category icon.
     */
    private function getCategoryIcon(string $category): string
    {
        return match ($category) {
            'social' => 'S',
            'medical' => 'M',
            'education' => 'E',
            'religious' => 'R',
            'sports' => 'E',
            default => 'G'
        };
    }

    /**
     * Get category color.
     */
    private function getCategoryColor(string $category): string
    {
        return match ($category) {
            'social' => 'from-purple-400 to-blue-500',
            'medical' => 'from-green-400 to-blue-500',
            'education' => 'from-pink-400 to-purple-500',
            'religious' => 'from-blue-400 to-indigo-500',
            'sports' => 'from-orange-400 to-red-500',
            default => 'from-purple-400 to-blue-500'
        };
    }
}
