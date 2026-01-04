@extends('layouts.app')

@section('title', 'Beranda')

@section('styles')
    <style>
        /* Hero Section */
        .hero {
            min-height: 90vh;
            display: flex;
            align-items: center;
            background: linear-gradient(135deg, rgba(15, 15, 35, 0.95) 0%, rgba(26, 26, 46, 0.9) 100%),
                url('https://images.unsplash.com/photo-1558618666-fcd25c85cd64?w=1920') center/cover;
            position: relative;
            overflow: hidden;
        }

        .hero::before {
            content: '';
            position: absolute;
            top: -50%;
            left: -50%;
            width: 200%;
            height: 200%;
            background: radial-gradient(circle, rgba(99, 102, 241, 0.1) 0%, transparent 50%);
            animation: rotate 30s linear infinite;
        }

        @keyframes rotate {
            from {
                transform: rotate(0deg);
            }

            to {
                transform: rotate(360deg);
            }
        }

        .hero-content {
            position: relative;
            z-index: 1;
            max-width: 700px;
        }

        .hero-badge {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            padding: 0.5rem 1rem;
            background: rgba(99, 102, 241, 0.2);
            border: 1px solid rgba(99, 102, 241, 0.3);
            border-radius: 9999px;
            font-size: 0.875rem;
            color: var(--primary-light);
            margin-bottom: 1.5rem;
            animation: fadeIn 0.6s ease;
        }

        .hero-title {
            font-size: 3.5rem;
            font-weight: 800;
            line-height: 1.1;
            margin-bottom: 1.5rem;
            animation: fadeIn 0.6s ease 0.1s backwards;
        }

        .hero-title span {
            background: var(--gradient-gold);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .hero-description {
            font-size: 1.25rem;
            color: var(--gray-300);
            margin-bottom: 2rem;
            animation: fadeIn 0.6s ease 0.2s backwards;
        }

        .hero-actions {
            display: flex;
            gap: 1rem;
            animation: fadeIn 0.6s ease 0.3s backwards;
        }

        .hero-stats {
            display: flex;
            gap: 3rem;
            margin-top: 4rem;
            animation: fadeIn 0.6s ease 0.4s backwards;
        }

        .hero-stat {
            text-align: center;
        }

        .hero-stat-value {
            font-size: 2.5rem;
            font-weight: 700;
            background: var(--gradient-primary);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .hero-stat-label {
            color: var(--gray-400);
            font-size: 0.9rem;
        }

        /* Section */
        .section {
            padding: 5rem 0;
        }

        .section-header {
            text-align: center;
            margin-bottom: 3rem;
        }

        .section-title {
            font-size: 2.5rem;
            font-weight: 700;
            margin-bottom: 1rem;
        }

        .section-subtitle {
            color: var(--gray-400);
            font-size: 1.1rem;
            max-width: 600px;
            margin: 0 auto;
        }

        /* Categories */
        .category-card {
            background: rgba(26, 26, 46, 0.6);
            border: 1px solid rgba(255, 255, 255, 0.1);
            border-radius: var(--radius-xl);
            padding: 2rem;
            text-align: center;
            transition: var(--transition);
            cursor: pointer;
        }

        .category-card:hover {
            transform: translateY(-10px);
            border-color: var(--primary);
            box-shadow: var(--shadow-glow);
        }

        .category-icon {
            width: 70px;
            height: 70px;
            background: var(--gradient-primary);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 1.5rem;
            font-size: 1.75rem;
        }

        .category-name {
            font-size: 1.25rem;
            font-weight: 600;
            margin-bottom: 0.5rem;
        }

        .category-count {
            color: var(--gray-400);
            font-size: 0.9rem;
        }

        /* Auction Card */
        .auction-card {
            background: rgba(26, 26, 46, 0.8);
            border: 1px solid rgba(255, 255, 255, 0.1);
            border-radius: var(--radius-xl);
            overflow: hidden;
            transition: var(--transition);
        }

        .auction-card:hover {
            transform: translateY(-8px);
            border-color: rgba(99, 102, 241, 0.5);
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.3);
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
            transition: var(--transition);
        }

        .auction-card:hover .auction-image img {
            transform: scale(1.1);
        }

        .auction-badge {
            position: absolute;
            top: 1rem;
            left: 1rem;
            padding: 0.375rem 0.75rem;
            background: var(--danger);
            color: white;
            font-size: 0.75rem;
            font-weight: 600;
            border-radius: var(--radius);
            display: flex;
            align-items: center;
            gap: 0.25rem;
        }

        .auction-badge.live {
            background: var(--success);
            animation: pulse 2s infinite;
        }

        .auction-content {
            padding: 1.5rem;
        }

        .auction-category {
            color: var(--primary-light);
            font-size: 0.8rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 1px;
            margin-bottom: 0.5rem;
        }

        .auction-title {
            font-size: 1.1rem;
            font-weight: 600;
            margin-bottom: 1rem;
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }

        .auction-price-section {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding-top: 1rem;
            border-top: 1px solid rgba(255, 255, 255, 0.1);
        }

        .auction-price-label {
            color: var(--gray-400);
            font-size: 0.8rem;
        }

        .auction-price {
            font-size: 1.25rem;
            font-weight: 700;
            color: var(--accent);
        }

        .auction-timer {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            color: var(--gray-400);
            font-size: 0.9rem;
        }

        .auction-timer i {
            color: var(--danger);
        }

        /* Features */
        .feature-card {
            text-align: center;
            padding: 2rem;
        }

        .feature-icon {
            width: 80px;
            height: 80px;
            background: var(--gradient-primary);
            border-radius: var(--radius-xl);
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 1.5rem;
            font-size: 2rem;
        }

        .feature-title {
            font-size: 1.25rem;
            font-weight: 600;
            margin-bottom: 0.75rem;
        }

        .feature-description {
            color: var(--gray-400);
        }

        /* CTA Section */
        .cta-section {
            background: var(--gradient-primary);
            border-radius: var(--radius-2xl);
            padding: 4rem;
            text-align: center;
            position: relative;
            overflow: hidden;
        }

        .cta-section::before {
            content: '';
            position: absolute;
            top: -50%;
            right: -50%;
            width: 100%;
            height: 200%;
            background: radial-gradient(circle, rgba(255, 255, 255, 0.1) 0%, transparent 50%);
        }

        .cta-title {
            font-size: 2.5rem;
            font-weight: 700;
            margin-bottom: 1rem;
            position: relative;
        }

        .cta-description {
            font-size: 1.1rem;
            opacity: 0.9;
            margin-bottom: 2rem;
            max-width: 600px;
            margin-left: auto;
            margin-right: auto;
            position: relative;
        }

        /* Ending Soon */
        .ending-soon-card {
            display: flex;
            gap: 1rem;
            background: rgba(26, 26, 46, 0.6);
            border: 1px solid rgba(255, 255, 255, 0.1);
            border-radius: var(--radius-lg);
            padding: 1rem;
            transition: var(--transition);
        }

        .ending-soon-card:hover {
            background: rgba(26, 26, 46, 0.9);
            border-color: var(--danger);
        }

        .ending-soon-image {
            width: 80px;
            height: 80px;
            border-radius: var(--radius);
            object-fit: cover;
            flex-shrink: 0;
        }

        .ending-soon-content {
            flex: 1;
            min-width: 0;
        }

        .ending-soon-title {
            font-weight: 600;
            margin-bottom: 0.25rem;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .ending-soon-timer {
            color: var(--danger);
            font-size: 0.9rem;
            font-weight: 600;
        }

        @media (max-width: 768px) {
            .hero-title {
                font-size: 2.5rem;
            }

            .hero-stats {
                gap: 1.5rem;
            }

            .hero-stat-value {
                font-size: 1.75rem;
            }

            .section-title {
                font-size: 2rem;
            }

            .cta-section {
                padding: 2rem;
            }

            .cta-title {
                font-size: 1.75rem;
            }
        }
    </style>
@endsection

@section('content')
    <!-- Hero Section -->
    <section class="hero">
        <div class="container">
            <div class="hero-content">
                <div class="hero-badge">
                    <i class="fas fa-bolt"></i>
                    Platform Lelang Terpercaya #1 di Indonesia
                </div>
                <h1 class="hero-title">
                    Temukan Barang <span>Impian</span> Anda dengan Harga Terbaik
                </h1>
                <p class="hero-description">
                    Bergabunglah dengan ribuan pengguna yang telah memenangkan lelang. Dapatkan barang berkualitas dengan
                    penawaran kompetitif.
                </p>
                <div class="hero-actions">
                    <a href="{{ route('auctions.index') }}" class="btn btn-gold btn-lg">
                        <i class="fas fa-gavel"></i> Mulai Lelang
                    </a>
                    <a href="{{ route('register') }}" class="btn btn-secondary btn-lg">
                        <i class="fas fa-user-plus"></i> Daftar Gratis
                    </a>
                </div>
                <div class="hero-stats">
                    <div class="hero-stat">
                        <div class="hero-stat-value">{{ number_format($stats['total_auctions']) }}+</div>
                        <div class="hero-stat-label">Lelang Aktif</div>
                    </div>
                    <div class="hero-stat">
                        <div class="hero-stat-value">{{ number_format($stats['total_users']) }}+</div>
                        <div class="hero-stat-label">Pengguna Aktif</div>
                    </div>
                    <div class="hero-stat">
                        <div class="hero-stat-value">{{ number_format($stats['completed_auctions']) }}+</div>
                        <div class="hero-stat-label">Lelang Selesai</div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Categories Section -->
    @if($categories->count() > 0)
        <section class="section">
            <div class="container">
                <div class="section-header">
                    <h2 class="section-title">Kategori Populer</h2>
                    <p class="section-subtitle">Jelajahi berbagai kategori barang lelang yang tersedia</p>
                </div>
                <div class="grid grid-4">
                    @foreach($categories as $category)
                        <a href="{{ route('auctions.index', ['category' => $category->id]) }}" class="category-card">
                            <div class="category-icon">
                                <i class="fas fa-{{ $category->icon ?? 'box' }}"></i>
                            </div>
                            <h3 class="category-name">{{ $category->name }}</h3>
                            <p class="category-count">{{ $category->auction_items_count }} Lelang Aktif</p>
                        </a>
                    @endforeach
                </div>
            </div>
        </section>
    @endif

    <!-- Featured Auctions -->
    @if($featuredAuctions->count() > 0)
        <section class="section" style="background: rgba(26, 26, 46, 0.5);">
            <div class="container">
                <div class="section-header">
                    <h2 class="section-title">Lelang Populer</h2>
                    <p class="section-subtitle">Barang-barang dengan penawaran tertinggi saat ini</p>
                </div>
                <div class="grid grid-3">
                    @foreach($featuredAuctions as $auction)
                        <a href="{{ route('auctions.show', $auction->id) }}" class="auction-card">
                            <div class="auction-image">
                                <img src="{{ $auction->image ? asset('storage/' . $auction->image) : 'https://via.placeholder.com/400x300/1a1a2e/6366f1?text=No+Image' }}"
                                    alt="{{ $auction->title }}">
                                @if($auction->isActive())
                                    <div class="auction-badge live">
                                        <i class="fas fa-circle"></i> LIVE
                                    </div>
                                @endif
                            </div>
                            <div class="auction-content">
                                <div class="auction-category">{{ $auction->category->name ?? 'Umum' }}</div>
                                <h3 class="auction-title">{{ $auction->title }}</h3>
                                <div class="auction-price-section">
                                    <div>
                                        <div class="auction-price-label">Harga Saat Ini</div>
                                        <div class="auction-price">Rp {{ number_format($auction->current_price, 0, ',', '.') }}
                                        </div>
                                    </div>
                                    <div class="auction-timer">
                                        <i class="fas fa-clock"></i>
                                        {{ $auction->end_time->diffForHumans() }}
                                    </div>
                                </div>
                            </div>
                        </a>
                    @endforeach
                </div>
                <div class="text-center mt-5">
                    <a href="{{ route('auctions.index') }}" class="btn btn-primary btn-lg">
                        Lihat Semua Lelang <i class="fas fa-arrow-right"></i>
                    </a>
                </div>
            </div>
        </section>
    @endif

    <!-- Ending Soon -->
    @if($endingSoon->count() > 0)
        <section class="section">
            <div class="container">
                <div class="d-flex align-center justify-between mb-4">
                    <div>
                        <h2 class="section-title" style="margin-bottom: 0.5rem;">⏰ Segera Berakhir</h2>
                        <p class="text-muted">Jangan lewatkan kesempatan terakhir!</p>
                    </div>
                </div>
                <div class="grid grid-2">
                    @foreach($endingSoon as $auction)
                        <a href="{{ route('auctions.show', $auction->id) }}" class="ending-soon-card">
                            <img src="{{ $auction->image ? asset('storage/' . $auction->image) : 'https://via.placeholder.com/100x100/1a1a2e/6366f1?text=No+Image' }}"
                                alt="{{ $auction->title }}" class="ending-soon-image">
                            <div class="ending-soon-content">
                                <div class="ending-soon-title">{{ $auction->title }}</div>
                                <div class="text-gold font-semibold">Rp {{ number_format($auction->current_price, 0, ',', '.') }}
                                </div>
                                <div class="ending-soon-timer">
                                    <i class="fas fa-fire"></i> Berakhir {{ $auction->end_time->diffForHumans() }}
                                </div>
                            </div>
                        </a>
                    @endforeach
                </div>
            </div>
        </section>
    @endif

    <!-- Features -->
    <section class="section" style="background: rgba(26, 26, 46, 0.5);">
        <div class="container">
            <div class="section-header">
                <h2 class="section-title">Mengapa LelangKu?</h2>
                <p class="section-subtitle">Keunggulan platform lelang kami</p>
            </div>
            <div class="grid grid-4">
                <div class="feature-card">
                    <div class="feature-icon">
                        <i class="fas fa-shield-alt"></i>
                    </div>
                    <h3 class="feature-title">100% Aman</h3>
                    <p class="feature-description">Transaksi aman dengan sistem pembayaran terpercaya</p>
                </div>
                <div class="feature-card">
                    <div class="feature-icon">
                        <i class="fas fa-bolt"></i>
                    </div>
                    <h3 class="feature-title">Real-time</h3>
                    <p class="feature-description">Pantau penawaran secara langsung tanpa delay</p>
                </div>
                <div class="feature-card">
                    <div class="feature-icon">
                        <i class="fas fa-users"></i>
                    </div>
                    <h3 class="feature-title">Komunitas</h3>
                    <p class="feature-description">Bergabung dengan komunitas lelang terbesar</p>
                </div>
                <div class="feature-card">
                    <div class="feature-icon">
                        <i class="fas fa-headset"></i>
                    </div>
                    <h3 class="feature-title">Support 24/7</h3>
                    <p class="feature-description">Tim support siap membantu kapan saja</p>
                </div>
            </div>
        </div>
    </section>

    <!-- CTA Section -->
    <section class="section">
        <div class="container">
            <div class="cta-section">
                <h2 class="cta-title">Siap Untuk Mulai Melelang?</h2>
                <p class="cta-description">Daftar sekarang dan dapatkan akses ke ribuan barang lelang dengan harga terbaik!
                </p>
                <a href="{{ route('register') }}" class="btn btn-gold btn-lg">
                    <i class="fas fa-rocket"></i> Daftar Sekarang - Gratis!
                </a>
            </div>
        </div>
    </section>
@endsection