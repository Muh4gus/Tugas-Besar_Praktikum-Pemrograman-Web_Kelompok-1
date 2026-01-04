<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Bid extends Model
{
    protected $fillable = [
        'auction_item_id',
        'user_id',
        'amount',
        'is_winning',
    ];

    protected $casts = [
        'amount' => 'decimal:2',
        'is_winning' => 'boolean',
    ];

    /**
     * Get the auction item for this bid.
     */
    public function auctionItem(): BelongsTo
    {
        return $this->belongsTo(AuctionItem::class);
    }

    /**
     * Get the user who placed this bid.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Mark this bid as winning and unmark others.
     */
    public function markAsWinning(): void
    {
        // Unmark all other bids for this auction
        self::where('auction_item_id', $this->auction_item_id)
            ->where('id', '!=', $this->id)
            ->update(['is_winning' => false]);

        // Mark this bid as winning
        $this->update(['is_winning' => true]);
    }
}
