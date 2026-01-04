<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AuctionItem;
use App\Models\AuctionLog;
use App\Models\Bid;
use App\Models\Category;
use App\Models\User;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    /**
     * Show admin dashboard.
     */
    public function index()
    {
        $stats = [
            'total_users' => User::where('role', 'user')->count(),
            'total_auctions' => AuctionItem::count(),
            'active_auctions' => AuctionItem::where('status', 'active')->count(),
            'total_bids' => Bid::count(),
            'total_revenue' => AuctionItem::where('status', 'ended')
                ->whereNotNull('winner_id')
                ->sum('current_price'),
        ];

        $recentAuctions = AuctionItem::with(['category', 'user'])
            ->orderBy('created_at', 'desc')
            ->take(5)
            ->get();

        $recentBids = Bid::with(['user', 'auctionItem'])
            ->orderBy('created_at', 'desc')
            ->take(10)
            ->get();

        $recentLogs = AuctionLog::with(['user', 'auctionItem'])
            ->orderBy('created_at', 'desc')
            ->take(10)
            ->get();

        return view('admin.dashboard', compact('stats', 'recentAuctions', 'recentBids', 'recentLogs'));
    }

    /**
     * Generate reports.
     */
    public function reports(Request $request)
    {
        $startDate = $request->get('start_date', now()->subMonth()->format('Y-m-d'));
        $endDate = $request->get('end_date', now()->format('Y-m-d'));

        $auctionStats = AuctionItem::whereBetween('created_at', [$startDate, $endDate])
            ->selectRaw('status, COUNT(*) as count')
            ->groupBy('status')
            ->get();

        $bidStats = Bid::whereBetween('created_at', [$startDate, $endDate])
            ->selectRaw('DATE(created_at) as date, COUNT(*) as count, SUM(amount) as total')
            ->groupBy('date')
            ->orderBy('date')
            ->get();

        $topBidders = User::withCount([
            'bids' => function ($query) use ($startDate, $endDate) {
                $query->whereBetween('created_at', [$startDate, $endDate]);
            }
        ])
            ->having('bids_count', '>', 0)
            ->orderBy('bids_count', 'desc')
            ->take(10)
            ->get();

        return view('admin.reports', compact('auctionStats', 'bidStats', 'topBidders', 'startDate', 'endDate'));
    }
}
