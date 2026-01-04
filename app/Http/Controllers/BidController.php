<?php

namespace App\Http\Controllers;

use App\Models\AuctionItem;
use App\Models\AuctionLog;
use App\Models\Bid;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class BidController extends Controller
{
    /**
     * Store a new bid.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'auction_item_id' => ['required', 'exists:auction_items,id'],
            'amount' => ['required', 'numeric', 'min:0'],
        ]);

        $auction = AuctionItem::findOrFail($validated['auction_item_id']);

        // Check if auction is active
        if (!$auction->isActive()) {
            return back()->with('error', 'Lelang ini sudah tidak aktif.');
        }

        // Check if user is not bidding on their own item
        if ($auction->user_id === auth()->id()) {
            return back()->with('error', 'Anda tidak dapat melakukan bid pada item Anda sendiri.');
        }

        // Check minimum bid
        $minimumBid = $auction->current_price + $auction->minimum_bid_increment;
        if ($validated['amount'] < $minimumBid) {
            return back()->with('error', 'Bid minimum adalah Rp ' . number_format($minimumBid, 0, ',', '.'));
        }

        try {
            DB::transaction(function () use ($validated, $auction) {
                // Create bid
                $bid = Bid::create([
                    'auction_item_id' => $auction->id,
                    'user_id' => auth()->id(),
                    'amount' => $validated['amount'],
                ]);

                // Update auction current price and bid count
                $auction->update([
                    'current_price' => $validated['amount'],
                    'total_bids' => $auction->total_bids + 1,
                ]);

                // Log activity
                AuctionLog::log(
                    $auction->id,
                    auth()->id(),
                    'bid_placed',
                    'User ' . auth()->user()->name . ' placed a bid of Rp ' . number_format($validated['amount'], 0, ',', '.'),
                    (string) $auction->current_price,
                    (string) $validated['amount']
                );
            });

            return back()->with('success', 'Bid berhasil ditempatkan!');
        } catch (\Exception $e) {
            return back()->with('error', 'Terjadi kesalahan saat menempatkan bid.');
        }
    }

    /**
     * Get bid history for an auction.
     */
    public function history($auctionId)
    {
        $bids = Bid::with('user')
            ->where('auction_item_id', $auctionId)
            ->orderBy('created_at', 'desc')
            ->get();

        return response()->json($bids);
    }
}
