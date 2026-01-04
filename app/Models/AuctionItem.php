<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class AuctionItem extends Model
{
    protected $fillable = [
        'user_id',
        'category_id',
        'title',
        'description',
        'image',
        'gallery',
        'starting_price',
        'current_price',
        'minimum_bid_increment',
        'start_time',
        'end_time',
        'status',
        'winner_id',
        'total_bids',
        'views',
    ];

    protected $casts = [
        'gallery' => 'array',
        'starting_price' => 'decimal:2',
        'current_price' => 'decimal:2',
        'minimum_bid_increment' => 'decimal:2',
        'start_time' => 'datetime',
        'end_time' => 'datetime',
    ];

    /**
     * Get the user that owns the auction item.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the category of the auction item.
     */
    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    /**
     * Get the winner of the auction.
     */
    public function winner(): BelongsTo
    {
        return $this->belongsTo(User::class, 'winner_id');
    }

    /**
     * Get all bids for this auction item.
     */
    public function bids(): HasMany
    {
        return $this->hasMany(Bid::class);
    }

    /**
     * Get logs for this auction item.
     */
    public function logs(): HasMany
    {
        return $this->hasMany(AuctionLog::class);
    }

    /**
     * Get the highest bid.
     */
    public function highestBid()
    {
        return $this->bids()->orderBy('amount', 'desc')->first();
    }

    /**
     * Check if auction is active.
     */
    public function isActive(): bool
    {
        return $this->status === 'active' &&
            now()->between($this->start_time, $this->end_time);
    }

    /**
     * Check if auction has ended.
     */
    public function hasEnded(): bool
    {
        return $this->status === 'ended' || now()->gt($this->end_time);
    }

    /**
     * Get time remaining in seconds.
     */
    public function getTimeRemainingAttribute(): int
    {
        if ($this->hasEnded()) {
            return 0;
        }
        return max(0, now()->diffInSeconds($this->end_time, false));
    }

    /**
     * Get minimum next bid amount.
     */
    public function getMinimumBidAttribute(): float
    {
        return $this->current_price + $this->minimum_bid_increment;
    }

    /**
     * Scope for active auctions.
     */
    public function scopeActive($query)
    {
        return $query->where('status', 'active')
            ->where('start_time', '<=', now())
            ->where('end_time', '>', now());
    }

    /**
     * Scope for ended auctions.
     */
    public function scopeEnded($query)
    {
        return $query->where(function ($q) {
            $q->where('status', 'ended')
                ->orWhere('end_time', '<', now());
        });
    }
}
