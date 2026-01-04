@extends('layouts.app')
@section('title', 'Bid Saya')
@section('content')
    <div class="container" style="padding: 2rem 0;">
        <h1 style="font-size: 1.75rem; font-weight: 700; margin-bottom: 2rem;"><i class="fas fa-gavel text-primary"></i> Bid
            Saya</h1>
        <div class="card">
            <div class="card-body" style="padding: 0;">
                <table style="width: 100%; border-collapse: collapse;">
                    <thead>
                        <tr style="background: rgba(255,255,255,0.05);">
                            <th style="padding: 1rem; text-align: left;">Item</th>
                            <th style="padding: 1rem; text-align: left;">Bid Anda</th>
                            <th style="padding: 1rem; text-align: left;">Harga Saat Ini</th>
                            <th style="padding: 1rem; text-align: left;">Status</th>
                            <th style="padding: 1rem; text-align: left;">Waktu</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($bids as $bid)
                            <tr style="border-bottom: 1px solid rgba(255,255,255,0.1);">
                                <td style="padding: 1rem;">
                                    <a href="{{ route('auctions.show', $bid->auction_item_id) }}"
                                        style="display: flex; align-items: center; gap: 1rem;">
                                        <img src="{{ $bid->auctionItem->image ? asset('storage/' . $bid->auctionItem->image) : 'https://via.placeholder.com/50' }}"
                                            style="width: 50px; height: 50px; border-radius: 0.5rem; object-fit: cover;">
                                        <span>{{ Str::limit($bid->auctionItem->title, 40) }}</span>
                                    </a>
                                </td>
                                <td style="padding: 1rem; font-weight: 600; color: var(--accent);">Rp
                                    {{ number_format($bid->amount, 0, ',', '.') }}</td>
                                <td style="padding: 1rem;">Rp {{ number_format($bid->auctionItem->current_price, 0, ',', '.') }}
                                </td>
                                <td style="padding: 1rem;">
                                    @if($bid->auctionItem->status == 'active')
                                        @if($bid->amount == $bid->auctionItem->current_price)
                                            <span class="badge badge-success">Tertinggi</span>
                                        @else
                                            <span class="badge badge-warning">Kalah</span>
                                        @endif
                                    @else
                                        @if($bid->is_winning)
                                            <span class="badge badge-success">Menang</span>
                                        @else
                                            <span class="badge badge-danger">Kalah</span>
                                        @endif
                                    @endif
                                </td>
                                <td style="padding: 1rem;" class="text-muted">{{ $bid->created_at->diffForHumans() }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center text-muted" style="padding: 3rem;">Belum ada bid</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        <div style="margin-top: 1rem;">{{ $bids->links() }}</div>
    </div>
@endsection