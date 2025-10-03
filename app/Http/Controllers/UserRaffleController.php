<?php

namespace App\Http\Controllers;

use App\Models\Raffle;
use Illuminate\Http\Request;
use Illuminate\View\View;

class UserRaffleController extends Controller
{
    /**
     * Display the user's raffles (both as organizer and participant).
     */
    public function index(Request $request): View
    {
        $user = auth()->user();
        
        // Get raffles where user is organizer
        $organizerRaffles = Raffle::where('organizer_id', $user->id)
            ->with('tickets')
            ->orderBy('created_at', 'desc')
            ->paginate(10, ['*'], 'organizer_page');
        
        // Get raffles where user has tickets (as participant)
        $participantRaffles = Raffle::whereHas('tickets', function($query) use ($user) {
            $query->where('participant_email', $user->email);
        })
        ->with(['tickets' => function($query) use ($user) {
            $query->where('participant_email', $user->email);
        }])
        ->with('organizer')
        ->orderBy('created_at', 'desc')
        ->paginate(10, ['*'], 'participant_page');
        
        // Get statistics
        $stats = [
            'total_organized' => Raffle::where('organizer_id', $user->id)->count(),
            'active_organized' => Raffle::where('organizer_id', $user->id)->active()->count(),
            'completed_organized' => Raffle::where('organizer_id', $user->id)->where('status', 'completed')->count(),
            'total_participating' => Raffle::whereHas('tickets', function($query) use ($user) {
                $query->where('participant_email', $user->email);
            })->count(),
            'total_tickets_bought' => $user->tickets()->count(),
            'total_spent' => $user->tickets()->sum('price'),
        ];
        
        return view('user.raffles', compact('organizerRaffles', 'participantRaffles', 'stats'));
    }
}


