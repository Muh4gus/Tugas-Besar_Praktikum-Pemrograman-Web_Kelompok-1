<?php

namespace App\Http\Controllers;

use App\Models\AuctionItem;
use App\Models\Category;
use Illuminate\Http\Request;

class AuctionController extends Controller
{
    /**
     * Display listing of active auctions.
     */
    public function index(Request $request)
    {
        $query = AuctionItem::with(['category', 'bids', 'user'])
            ->where('status', 'active');

        // Filter by category
        if ($request->filled('category')) {
            $query->where('category_id', $request->category);
        }

        // Search by title
        if ($request->filled('search')) {
            $query->where('title', 'like', '%' . $request->search . '%');
        }

        // Sort options
        $sort = $request->get('sort', 'newest');
        switch ($sort) {
            case 'ending_soon':
                $query->orderBy('end_time', 'asc');
                break;
            case 'price_low':
                $query->orderBy('current_price', 'asc');
                break;
            case 'price_high':
                $query->orderBy('current_price', 'desc');
                break;
            case 'most_bids':
                $query->orderBy('total_bids', 'desc');
                break;
            default:
                $query->orderBy('created_at', 'desc');
        }

        $auctions = $query->paginate(12);
        $categories = Category::where('is_active', true)->get();

        return view('auctions.index', compact('auctions', 'categories'));
    }

    /**
     * Display the specified auction.
     */
    public function show($id)
    {
        $auction = AuctionItem::with(['category', 'user', 'winner'])
            ->findOrFail($id);

        // Increment views
        $auction->increment('views');

        // Get bid history
        $bids = $auction->bids()
            ->with('user')
            ->orderBy('amount', 'desc')
            ->take(10)
            ->get();

        // Get related auctions
        $relatedAuctions = AuctionItem::where('category_id', $auction->category_id)
            ->where('id', '!=', $auction->id)
            ->where('status', 'active')
            ->take(4)
            ->get();

        return view('auctions.show', compact('auction', 'bids', 'relatedAuctions'));
    }
}
