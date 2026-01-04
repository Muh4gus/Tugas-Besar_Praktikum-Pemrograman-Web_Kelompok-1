@extends('layouts.app')
@section('title', 'Lelang Dimenangkan')
@section('content')
    <div class="container" style="padding: 2rem 0;">
        <h1 style="font-size: 1.75rem; font-weight: 700; margin-bottom: 2rem;"><i class="fas fa-trophy text-gold"></i>
            Lelang Dimenangkan</h1>
        @if($wonAuctions->count() > 0)
            <div class="grid grid-3">
                @foreach($wonAuctions as $auction)
                    <div class="card">
                        <div style="height: 180px; overflow: hidden;">
                            <img src="{{ $auction->image ? asset('storage/' . $auction->image) : 'https://via.placeholder.com/400x200' }}"
                                style="width: 100%; height: 100%; object-fit: cover;">
                        </div>
                        <div class="card-body">
                            <div class="text-sm text-primary mb-2">{{ $auction->category->name ?? 'Umum' }}</div>
                            <h3 style="font-weight: 600; margin-bottom: 1rem;">{{ $auction->title }}</h3>
                            <div style="display: flex; justify-content: space-between; align-items: center;">
                                <div>
                                    <div class="text-sm text-muted">Harga Menang</div>
                                    <div style="font-size: 1.25rem; font-weight: 700; color: var(--accent);">Rp
                                        {{ number_format($auction->current_price, 0, ',', '.') }}</div>
                                </div>
                                <span class="badge badge-success">🏆 Menang</span>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
            <div style="margin-top: 2rem;">{{ $wonAuctions->links() }}</div>
        @else
            <div class="text-center" style="padding: 4rem;">
                <div style="font-size: 4rem; color: var(--gray-600); margin-bottom: 1rem;"><i class="fas fa-trophy"></i></div>
                <h3>Belum ada lelang dimenangkan</h3>
                <p class="text-muted">Ikuti lelang dan menangkan item impian Anda!</p>
                <a href="{{ route('auctions.index') }}" class="btn btn-primary mt-3">Lihat Lelang</a>
            </div>
        @endif
    </div>
@endsection