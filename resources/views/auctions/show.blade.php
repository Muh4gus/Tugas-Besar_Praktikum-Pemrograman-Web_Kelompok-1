@extends('layouts.app')
@section('title', $auction->title)
@section('styles')
    <style>
        .auction-detail {
            padding: 2rem 0 4rem;
        }

        .auction-grid {
            display: grid;
            grid-template-columns: 1fr 400px;
            gap: 2rem;
        }

        @media (max-width: 1024px) {
            .auction-grid {
                grid-template-columns: 1fr;
            }
        }

        .auction-image-main {
            border-radius: 1rem;
            overflow: hidden;
            background: rgba(26, 26, 46, 0.8);
        }

        .auction-image-main img {
            width: 100%;
            height: 400px;
            object-fit: cover;
        }

        .auction-info {
            background: rgba(26, 26, 46, 0.8);
            border: 1px solid rgba(255, 255, 255, 0.1);
            border-radius: 1rem;
            padding: 2rem;
            position: sticky;
            top: 100px;
        }

        .auction-status {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            padding: 0.5rem 1rem;
            background: rgba(16, 185, 129, 0.2);
            color: var(--success);
            border-radius: 9999px;
            font-size: 0.875rem;
            font-weight: 600;
            margin-bottom: 1rem;
        }

        .auction-status.ended {
            background: rgba(239, 68, 68, 0.2);
            color: var(--danger);
        }

        .auction-title-detail {
            font-size: 1.5rem;
            font-weight: 700;
            margin-bottom: 1rem;
        }

        .price-section {
            background: rgba(99, 102, 241, 0.1);
            border-radius: 0.75rem;
            padding: 1.5rem;
            margin-bottom: 1.5rem;
        }

        .price-label {
            color: var(--gray-400);
            font-size: 0.875rem;
            margin-bottom: 0.25rem;
        }

        .price-value {
            font-size: 2rem;
            font-weight: 700;
            color: var(--accent);
        }

        .min-bid {
            color: var(--gray-400);
            font-size: 0.9rem;
            margin-top: 0.5rem;
        }

        .timer-section {
            display: flex;
            gap: 1rem;
            margin-bottom: 1.5rem;
        }

        .timer-box {
            flex: 1;
            text-align: center;
            background: rgba(255, 255, 255, 0.05);
            border-radius: 0.5rem;
            padding: 1rem;
        }

        .timer-value {
            font-size: 1.5rem;
            font-weight: 700;
        }

        .timer-label {
            font-size: 0.75rem;
            color: var(--gray-400);
        }

        .bid-form {
            margin-bottom: 1.5rem;
        }

        .bid-input {
            display: flex;
            gap: 0.5rem;
        }

        .bid-input input {
            flex: 1;
        }

        .bid-history {
            margin-top: 2rem;
        }

        .bid-item {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 0.75rem 0;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
        }

        .bid-user {
            display: flex;
            align-items: center;
            gap: 0.75rem;
        }

        .bid-avatar {
            width: 32px;
            height: 32px;
            border-radius: 50%;
        }

        .bid-amount {
            font-weight: 600;
            color: var(--accent);
        }

        .auction-desc {
            background: rgba(26, 26, 46, 0.8);
            border: 1px solid rgba(255, 255, 255, 0.1);
            border-radius: 1rem;
            padding: 2rem;
            margin-top: 2rem;
        }

        .desc-title {
            font-size: 1.25rem;
            font-weight: 600;
            margin-bottom: 1rem;
        }

        .related-section {
            margin-top: 3rem;
        }

        .related-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
            gap: 1rem;
        }
    </style>
@endsection
@section('content')
    <div class="auction-detail">
        <div class="container">
            <div class="auction-grid">
                <div>
                    <div class="auction-image-main">
                        <img src="{{ $auction->image ? asset('storage/' . $auction->image) : 'https://via.placeholder.com/800x400/1a1a2e/6366f1?text=No+Image' }}"
                            alt="{{ $auction->title }}">
                    </div>
                    <div class="auction-desc">
                        <h3 class="desc-title">Deskripsi</h3>
                        <p class="text-muted">{!! nl2br(e($auction->description)) !!}</p>
                    </div>
                </div>
                <div class="auction-info">
                    @if($auction->isActive())
                        <div class="auction-status"><i class="fas fa-circle"></i> Lelang Aktif</div>
                    @else
                        <div class="auction-status ended"><i class="fas fa-times-circle"></i> Lelang Berakhir</div>
                    @endif
                    <div class="text-sm text-primary mb-2">{{ $auction->category->name ?? 'Umum' }}</div>
                    <h1 class="auction-title-detail">{{ $auction->title }}</h1>
                    <div class="price-section">
                        <div class="price-label">Harga Saat Ini</div>
                        <div class="price-value">Rp {{ number_format($auction->current_price, 0, ',', '.') }}</div>
                        <div class="min-bid">Bid minimum: Rp {{ number_format($auction->minimum_bid, 0, ',', '.') }}</div>
                    </div>
                    <div class="timer-section" id="countdown">
                        <div class="timer-box">
                            <div class="timer-value" id="days">00</div>
                            <div class="timer-label">Hari</div>
                        </div>
                        <div class="timer-box">
                            <div class="timer-value" id="hours">00</div>
                            <div class="timer-label">Jam</div>
                        </div>
                        <div class="timer-box">
                            <div class="timer-value" id="minutes">00</div>
                            <div class="timer-label">Menit</div>
                        </div>
                        <div class="timer-box">
                            <div class="timer-value" id="seconds">00</div>
                            <div class="timer-label">Detik</div>
                        </div>
                    </div>
                    @auth
                        @if($auction->isActive() && $auction->user_id !== auth()->id())
                            <form action="{{ route('bids.store') }}" method="POST" class="bid-form">
                                @csrf
                                <input type="hidden" name="auction_item_id" value="{{ $auction->id }}">
                                <div class="bid-input">
                                    <input type="number" name="amount" class="form-control" placeholder="Masukkan bid Anda"
                                        min="{{ $auction->minimum_bid }}" step="1000" required>
                                    <button type="submit" class="btn btn-gold"><i class="fas fa-gavel"></i> Bid</button>
                                </div>
                            </form>
                        @endif
                    @else
                        <a href="{{ route('login') }}" class="btn btn-primary" style="width:100%">Login untuk Bid</a>
                    @endauth

                    <div class="bid-history">
                        <h4>Riwayat Bid ({{ $bids->count() }})</h4>
                        @forelse($bids as $bid)
                            <div class="bid-item">
                                <div class="bid-user">
                                    <img src="{{ $bid->user->avatar_url }}" class="bid-avatar" alt="">
                                    <span>{{ $bid->user->name }}</span>
                                </div>
                                <div class="bid-amount">Rp {{ number_format($bid->amount, 0, ',', '.') }}</div>
                            </div>
                        @empty
                            <p class="text-muted">Belum ada bid</p>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('scripts')
    <script>
        const endTime = new Date("{{ $auction->end_time->toIso8601String() }}").getTime();
        const timer = setInterval(function () {
            const now = new Date().getTime();
            const distance = endTime - now;
            if (distance < 0) { clearInterval(timer); location.reload(); return; }
            document.getElementById("days").innerHTML = Math.floor(distance / (1000 * 60 * 60 * 24));
            document.getElementById("hours").innerHTML = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
            document.getElementById("minutes").innerHTML = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
            document.getElementById("seconds").innerHTML = Math.floor((distance % (1000 * 60)) / 1000);
        }, 1000);
    </script>
@endsection