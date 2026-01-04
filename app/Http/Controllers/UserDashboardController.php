<?php

namespace App\Http\Controllers;

use App\Models\AuctionItem;
use Illuminate\Http\Request;

class UserDashboardController extends Controller
{
    /**
     * Show user dashboard.
     */
    public function index()
    {
        $user = auth()->user();

        $stats = [
            'total_bids' => $user->bids()->count(),
            'active_bids' => $user->bids()
                ->whereHas('auctionItem', function ($query) {
                    $query->where('status', 'active');
                })
                ->count(),
            'won_auctions' => $user->wonAuctions()->count(),
        ];

        $recentBids = $user->bids()
            ->with('auctionItem')
            ->orderBy('created_at', 'desc')
            ->take(5)
            ->get();

        $activeAuctions = AuctionItem::with('category')
            ->active()
            ->take(4)
            ->get();

        return view('user.dashboard', compact('stats', 'recentBids', 'activeAuctions'));
    }

    /**
     * Show user's bids.
     */
    public function myBids()
    {
        $bids = auth()->user()->bids()
            ->with(['auctionItem', 'auctionItem.category'])
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('user.my-bids', compact('bids'));
    }

    /**
     * Show auctions won by user.
     */
    public function wonAuctions()
    {
        $wonAuctions = auth()->user()->wonAuctions()
            ->with(['category', 'bids'])
            ->orderBy('end_time', 'desc')
            ->paginate(10);

        return view('user.won-auctions', compact('wonAuctions'));
    }

    /**
     * Show user profile.
     */
    public function profile()
    {
        return view('user.profile');
    }

    /**
     * Update user profile.
     */
    public function updateProfile(Request $request)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'phone' => ['nullable', 'string', 'max:20'],
            'address' => ['nullable', 'string', 'max:500'],
        ]);

        auth()->user()->update($validated);

        return back()->with('success', 'Profil berhasil diperbarui!');
    }
}
