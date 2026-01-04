<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Category extends Model
{
    protected $fillable = [
        'name',
        'description',
        'image',
        'icon',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    /**
     * Get the auction items for the category.
     */
    public function auctionItems(): HasMany
    {
        return $this->hasMany(AuctionItem::class);
    }

    /**
     * Get active auction items count.
     */
    public function activeAuctionsCount(): int
    {
        return $this->auctionItems()->where('status', 'active')->count();
    }
}
