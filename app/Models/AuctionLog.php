<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class AuctionLog extends Model
{
    protected $fillable = [
        'auction_item_id',
        'user_id',
        'action',
        'description',
        'old_value',
        'new_value',
        'ip_address',
    ];

    /**
     * Get the auction item for this log.
     */
    public function auctionItem(): BelongsTo
    {
        return $this->belongsTo(AuctionItem::class);
    }

    /**
     * Get the user associated with this log.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Create a log entry.
     */
    public static function log(
        ?int $auctionItemId,
        ?int $userId,
        string $action,
        string $description,
        ?string $oldValue = null,
        ?string $newValue = null
    ): self {
        return self::create([
            'auction_item_id' => $auctionItemId,
            'user_id' => $userId,
            'action' => $action,
            'description' => $description,
            'old_value' => $oldValue,
            'new_value' => $newValue,
            'ip_address' => request()->ip(),
        ]);
    }
}
