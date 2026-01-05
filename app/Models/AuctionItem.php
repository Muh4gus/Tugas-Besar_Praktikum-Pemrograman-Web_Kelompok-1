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
     * Relasi: User pemilik barang lelang.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Relasi: Kategori dari barang lelang.
     */
    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    /**
     * Relasi: Pemenang lelang (User).
     */
    public function winner(): BelongsTo
    {
        return $this->belongsTo(User::class, 'winner_id');
    }

    /**
     * Relasi: Semua bid (penawaran) untuk barang ini.
     */
    public function bids(): HasMany
    {
        return $this->hasMany(Bid::class);
    }

    /**
     * Relasi: Log aktivitas barang ini.
     */
    public function logs(): HasMany
    {
        return $this->hasMany(AuctionLog::class);
    }

    /**
     * Ambil data bid tertinggi saat ini.
     */
    public function highestBid()
    {
        return $this->bids()->orderBy('amount', 'desc')->first();
    }

    /**
     * Cek apakah lelang sedang aktif (waktu mulai < sekarang < waktu selesai).
     */
    public function isActive(): bool
    {
        return $this->status === 'active' &&
            now()->between($this->start_time, $this->end_time);
    }

    /**
     * Cek apakah lelang sudah berakhir.
     */
    public function hasEnded(): bool
    {
        return $this->status === 'ended' || now()->gt($this->end_time);
    }

    /**
     * Hitung sisa waktu dalam detik.
     */
    public function getTimeRemainingAttribute(): int
    {
        if ($this->hasEnded()) {
            return 0;
        }
        return max(0, now()->diffInSeconds($this->end_time, false));
    }

    /**
     * Hitung jumlah bid minimum berikutnya (Harga + Kelipatan).
     */
    public function getMinimumBidAttribute(): float
    {
        return $this->current_price + $this->minimum_bid_increment;
    }

    /**
     * Scope Query: Hanya ambil lelang yang aktif.
     */
    public function scopeActive($query)
    {
        return $query->where('status', 'active')
            ->where('start_time', '<=', now())
            ->where('end_time', '>', now());
    }

    /**
     * Scope Query: Hanya ambil lelang yang berakhir.
     */
    public function scopeEnded($query)
    {
        return $query->where(function ($q) {
            $q->where('status', 'ended')
                ->orWhere('end_time', '<', now());
        });
    }
}
