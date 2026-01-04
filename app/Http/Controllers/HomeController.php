<?php

namespace App\Http\Controllers;

use App\Models\AuctionItem;
use App\Models\Category;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Show the landing page.
     */
    public function index()
    {
        $featuredAuctions = AuctionItem::with(['category', 'bids'])
            ->active()
            ->orderBy('total_bids', 'desc')
            ->take(6)
            ->get();

        $categories = Category::where('is_active', true)
            ->withCount([
                'auctionItems' => function ($query) {
                    $query->where('status', 'active');
                }
            ])
            ->get();

        $endingSoon = AuctionItem::with(['category'])
            ->active()
            ->where('end_time', '<=', now()->addHours(24))
            ->orderBy('end_time')
            ->take(4)
            ->get();

        $stats = [
            'total_auctions' => AuctionItem::where('status', 'active')->count(),
            'total_users' => \App\Models\User::where('role', 'user')->count(),
            'completed_auctions' => AuctionItem::where('status', 'ended')->count(),
        ];

        return view('home', compact('featuredAuctions', 'categories', 'endingSoon', 'stats'));
    }
}
