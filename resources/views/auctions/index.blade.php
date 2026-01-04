@extends('layouts.app')
@section('title', 'Daftar Lelang')
@section('styles')
    <style>
        .page-header {
            padding: 3rem 0;
            background: linear-gradient(135deg, rgba(99, 102, 241, 0.1) 0%, rgba(139, 92, 246, 0.05) 100%);
        }

        .page-title {
            font-size: 2rem;
            font-weight: 700;
        }

        .filters {
            display: flex;
            gap: 1rem;
            flex-wrap: wrap;
            margin-bottom: 2rem;
        }

        .filter-group {
            flex: 1;
            min-width: 200px;
        }

        .auction-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
            gap: 1.5rem;
        }

        .auction-card {
            background: rgba(26, 26, 46, 0.8);
            border: 1px solid rgba(255, 255, 255, 0.1);
            border-radius: 1rem;
            overflow: hidden;
            transition: all 0.3s ease;
        }

        .auction-card:hover {
            transform: translateY(-8px);
            border-color: rgba(99, 102, 241, 0.5);
        }

        .auction-image {
            position: relative;
            height: 200px;
            overflow: hidden;
        }

        .auction-image img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform 0.3s;
        }

        .auction-card:hover .auction-image img {
            transform: scale(1.1);
        }

        .auction-badge {
            position: absolute;
            top: 1rem;
            left: 1rem;
            padding: 0.375rem 0.75rem;
            background: var(--success);
            color: white;
            font-size: 0.75rem;
            font-weight: 600;
            border-radius: 0.5rem;
        }

        .auction-content {
            padding: 1.5rem;
        }

        .auction-category {
            color: var(--primary-light);
            font-size: 0.8rem;
            font-weight: 600;
            text-transform: uppercase;
            margin-bottom: 0.5rem;
        }

        .auction-title {
            font-size: 1.1rem;
            font-weight: 600;
            margin-bottom: 1rem;
        }

        .auction-meta {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding-top: 1rem;
            border-top: 1px solid rgba(255, 255, 255, 0.1);
        }

        .auction-price {
            font-size: 1.25rem;
            font-weight: 700;
            color: var(--accent);
        }

        .auction-timer {
            color: var(--gray-400);
            font-size: 0.9rem;
        }

        .pagination {
            display: flex;
            justify-content: center;
            gap: 0.5rem;
            margin-top: 2rem;
        }

        .pagination a,
        .pagination span {
            padding: 0.5rem 1rem;
            background: rgba(255, 255, 255, 0.05);
            border-radius: 0.5rem;
            color: var(--gray-300);
        }

        .pagination a:hover,
        .pagination .active {
            background: var(--primary);
            color: white;
        }

        .empty-state {
            text-align: center;
            padding: 4rem 2rem;
        }

        .empty-icon {
            font-size: 4rem;
            color: var(--gray-600);
            margin-bottom: 1rem;
        }
    </style>
@endsection
@section('content')
    <div class="page-header">
        <div class="container">
            <h1 class="page-title"><i class="fas fa-gavel text-primary"></i> Daftar Lelang</h1>
            <p class="text-muted">Temukan barang impian Anda</p>
        </div>
    </div>
    <div class="container" style="padding: 2rem 0;">
        <form method="GET" class="filters">
            <div class="filter-group">
                <input type="text" name="search" class="form-control" placeholder="Cari barang..."
                    value="{{ request('search') }}">
            </div>
            <div class="filter-group">
                <select name="category" class="form-control">
                    <option value="">Semua Kategori</option>
                    @foreach($categories as $cat)
                        <option value="{{ $cat->id }}" {{ request('category') == $cat->id ? 'selected' : '' }}>{{ $cat->name }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="filter-group">
                <select name="sort" class="form-control">
                    <option value="newest" {{ request('sort') == 'newest' ? 'selected' : '' }}>Terbaru</option>
                    <option value="ending_soon" {{ request('sort') == 'ending_soon' ? 'selected' : '' }}>Segera Berakhir
                    </option>
                    <option value="price_low" {{ request('sort') == 'price_low' ? 'selected' : '' }}>Harga Terendah</option>
                    <option value="price_high" {{ request('sort') == 'price_high' ? 'selected' : '' }}>Harga Tertinggi
                    </option>
                    <option value="most_bids" {{ request('sort') == 'most_bids' ? 'selected' : '' }}>Bid Terbanyak</option>
                </select>
            </div>
            <button type="submit" class="btn btn-primary"><i class="fas fa-search"></i> Filter</button>
        </form>

        @if($auctions->count() > 0)
            <div class="auction-grid">
                @foreach($auctions as $auction)
                    <a href="{{ route('auctions.show', $auction->id) }}" class="auction-card">
                        <div class="auction-image">
                            <img src="{{ $auction->image ? asset('storage/' . $auction->image) : 'https://via.placeholder.com/400x300/1a1a2e/6366f1?text=No+Image' }}"
                                alt="{{ $auction->title }}">
                            <div class="auction-badge"><i class="fas fa-circle"></i> LIVE</div>
                        </div>
                        <div class="auction-content">
                            <div class="auction-category">{{ $auction->category->name ?? 'Umum' }}</div>
                            <h3 class="auction-title">{{ $auction->title }}</h3>
                            <div class="auction-meta">
                                <div class="auction-price">Rp {{ number_format($auction->current_price, 0, ',', '.') }}</div>
                                <div class="auction-timer"><i class="fas fa-clock"></i> {{ $auction->end_time->diffForHumans() }}
                                </div>
                            </div>
                        </div>
                    </a>
                @endforeach
            </div>
            <div class="pagination">{{ $auctions->withQueryString()->links('pagination::simple-bootstrap-5') }}</div>
        @else
            <div class="empty-state">
                <div class="empty-icon"><i class="fas fa-box-open"></i></div>
                <h3>Tidak ada lelang ditemukan</h3>
                <p class="text-muted">Coba ubah filter pencarian Anda</p>
            </div>
        @endif
    </div>
@endsection