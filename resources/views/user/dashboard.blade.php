@extends('layouts.app')
@section('title', 'Dashboard')
@section('styles')
    <style>
        .dashboard {
            padding: 2rem 0;
        }

        .welcome-card {
            background: var(--gradient-primary);
            border-radius: 1rem;
            padding: 2rem;
            margin-bottom: 2rem;
        }

        .welcome-title {
            font-size: 1.5rem;
            font-weight: 700;
            margin-bottom: 0.5rem;
        }

        .stats-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 1rem;
            margin-bottom: 2rem;
        }

        @media (max-width: 768px) {
            .stats-grid {
                grid-template-columns: 1fr;
            }
        }

        .stat-card {
            background: rgba(26, 26, 46, 0.8);
            border: 1px solid rgba(255, 255, 255, 0.1);
            border-radius: 1rem;
            padding: 1.5rem;
            text-align: center;
        }

        .stat-value {
            font-size: 2rem;
            font-weight: 700;
            color: var(--accent);
        }

        .stat-label {
            color: var(--gray-400);
        }

        .section-title {
            font-size: 1.25rem;
            font-weight: 600;
            margin-bottom: 1rem;
        }

        .bid-list {
            background: rgba(26, 26, 46, 0.8);
            border: 1px solid rgba(255, 255, 255, 0.1);
            border-radius: 1rem;
        }

        .bid-item {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 1rem 1.5rem;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
        }

        .bid-item:last-child {
            border-bottom: none;
        }

        .bid-info {
            display: flex;
            align-items: center;
            gap: 1rem;
        }

        .bid-image {
            width: 50px;
            height: 50px;
            border-radius: 0.5rem;
            object-fit: cover;
        }

        .bid-amount {
            font-weight: 600;
            color: var(--accent);
        }

        .quick-links {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 1rem;
        }

        .quick-link {
            background: rgba(26, 26, 46, 0.8);
            border: 1px solid rgba(255, 255, 255, 0.1);
            border-radius: 1rem;
            padding: 1.5rem;
            display: flex;
            align-items: center;
            gap: 1rem;
            transition: all 0.3s;
        }

        .quick-link:hover {
            border-color: var(--primary);
            transform: translateY(-3px);
        }

        .quick-icon {
            width: 50px;
            height: 50px;
            background: var(--gradient-primary);
            border-radius: 0.75rem;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.25rem;
        }
    </style>
@endsection
@section('content')
    <div class="dashboard">
        <div class="container">
            <div class="welcome-card">
                <h1 class="welcome-title">Halo, {{ auth()->user()->name }}! 👋</h1>
                <p>Selamat datang kembali di LelangKu</p>
            </div>

            <div class="stats-grid">
                <div class="stat-card">
                    <div class="stat-value">{{ $stats['total_bids'] }}</div>
                    <div class="stat-label">Total Bid</div>
                </div>
                <div class="stat-card">
                    <div class="stat-value">{{ $stats['active_bids'] }}</div>
                    <div class="stat-label">Bid Aktif</div>
                </div>
                <div class="stat-card">
                    <div class="stat-value">{{ $stats['won_auctions'] }}</div>
                    <div class="stat-label">Lelang Dimenangkan</div>
                </div>
            </div>

            <div style="display: grid; grid-template-columns: 2fr 1fr; gap: 2rem;">
                <div>
                    <h3 class="section-title">Bid Terbaru</h3>
                    <div class="bid-list">
                        @forelse($recentBids as $bid)
                            <a href="{{ route('auctions.show', $bid->auction_item_id) }}" class="bid-item">
                                <div class="bid-info">
                                    <img src="{{ $bid->auctionItem->image ? asset('storage/' . $bid->auctionItem->image) : 'https://via.placeholder.com/50' }}"
                                        class="bid-image">
                                    <div>
                                        <div class="font-semibold">{{ Str::limit($bid->auctionItem->title, 30) }}</div>
                                        <div class="text-sm text-muted">{{ $bid->created_at->diffForHumans() }}</div>
                                    </div>
                                </div>
                                <div class="bid-amount">Rp {{ number_format($bid->amount, 0, ',', '.') }}</div>
                            </a>
                        @empty
                            <div class="text-center text-muted" style="padding: 2rem;">Belum ada bid</div>
                        @endforelse
                    </div>
                </div>
                <div>
                    <h3 class="section-title">Menu Cepat</h3>
                    <div class="quick-links">
                        <a href="{{ route('auctions.index') }}" class="quick-link">
                            <div class="quick-icon"><i class="fas fa-gavel"></i></div>
                            <span>Lihat Lelang</span>
                        </a>
                        <a href="{{ route('my-bids') }}" class="quick-link">
                            <div class="quick-icon"><i class="fas fa-list"></i></div>
                            <span>Bid Saya</span>
                        </a>
                        <a href="{{ route('won-auctions') }}" class="quick-link">
                            <div class="quick-icon"><i class="fas fa-trophy"></i></div>
                            <span>Dimenangkan</span>
                        </a>
                        <a href="{{ route('profile') }}" class="quick-link">
                            <div class="quick-icon"><i class="fas fa-user"></i></div>
                            <span>Profil</span>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection