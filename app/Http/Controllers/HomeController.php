<?php

namespace App\Http\Controllers;

use App\Models\Raffle;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Show the application homepage.
     */
    public function index()
    {
        // Get active raffles for the homepage
        $activeRaffles = Raffle::active()
            ->with('organizer')
            ->orderBy('featured', 'desc')
            ->orderBy('created_at', 'desc')
            ->limit(6)
            ->get();

        // Get best selling raffles (by progress percentage)
        $bestSellingRaffles = Raffle::active()
            ->with('organizer')
            ->orderBy('progress_percentage', 'desc')
            ->orderBy('sold_tickets', 'desc')
            ->limit(3)
            ->get();

        // Get well-rated raffles (simulated for now - in future will be based on actual ratings)
        $wellRatedRaffles = Raffle::active()
            ->with('organizer')
            ->orderBy('featured', 'desc')
            ->orderBy('created_at', 'desc')
            ->limit(3)
            ->get();

        // Get raffle statistics
        $raffleStats = [
            'total_active_raffles' => Raffle::active()->count(),
            'total_tickets_sold' => Raffle::active()->sum('sold_tickets'),
            'total_amount_raised' => Raffle::active()
                ->get()
                ->sum(function ($raffle) {
                    return $raffle->sold_tickets * $raffle->price_per_ticket;
                }),
        ];

        return view('home', compact('activeRaffles', 'bestSellingRaffles', 'wellRatedRaffles', 'raffleStats'));
    }

    /**
     * Show the about page.
     */
    public function about()
    {
        return view('about');
    }

    /**
     * Show the contact page.
     */
    public function contact()
    {
        return view('contact');
    }
}


