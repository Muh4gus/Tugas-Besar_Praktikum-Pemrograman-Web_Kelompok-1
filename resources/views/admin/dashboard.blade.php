@extends('layouts.admin')
@section('title', 'Dashboard')
@section('content')
    <div class="page-header">
        <h1 class="page-title">Dashboard Admin</h1>
    </div>

    <div class="stats-grid">
        <div class="stat-card">
            <div class="stat-icon" style="background: rgba(99, 102, 241, 0.2); color: var(--primary);"><i
                    class="fas fa-users"></i></div>
            <div class="stat-value">{{ number_format($stats['total_users']) }}</div>
            <div class="stat-label">Total Pengguna</div>
        </div>
        <div class="stat-card">
            <div class="stat-icon" style="background: rgba(16, 185, 129, 0.2); color: var(--success);"><i
                    class="fas fa-box"></i></div>
            <div class="stat-value">{{ number_format($stats['total_auctions']) }}</div>
            <div class="stat-label">Total Lelang</div>
        </div>
        <div class="stat-card">
            <div class="stat-icon" style="background: rgba(245, 158, 11, 0.2); color: var(--warning);"><i
                    class="fas fa-gavel"></i></div>
            <div class="stat-value">{{ number_format($stats['total_bids']) }}</div>
            <div class="stat-label">Total Bid</div>
        </div>
        <div class="stat-card">
            <div class="stat-icon" style="background: rgba(251, 191, 36, 0.2); color: var(--accent);"><i
                    class="fas fa-coins"></i></div>
            <div class="stat-value">Rp {{ number_format($stats['total_revenue'] / 1000000, 1) }}M</div>
            <div class="stat-label">Total Transaksi</div>
        </div>
    </div>

    <div style="display: grid; grid-template-columns: 2fr 1fr; gap: 1.5rem;">
        <div class="card">
            <div class="card-header">Lelang Terbaru</div>
            <table class="table">
                <thead>
                    <tr>
                        <th>Item</th>
                        <th>Status</th>
                        <th>Harga</th>
                        <th>Bid</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($recentAuctions as $item)
                        <tr>
                            <td>{{ Str::limit($item->title, 30) }}</td>
                            <td>
                                @if($item->status == 'active')<span class="badge badge-success">Aktif</span>
                                @elseif($item->status == 'pending')<span class="badge badge-warning">Pending</span>
                                @elseif($item->status == 'ended')<span class="badge badge-primary">Selesai</span>
                                @else<span class="badge badge-danger">Dibatalkan</span>@endif
                            </td>
                            <td>Rp {{ number_format($item->current_price, 0, ',', '.') }}</td>
                            <td>{{ $item->total_bids }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="text-center" style="color: var(--gray-400);">Belum ada data</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="card">
            <div class="card-header">Aktivitas Terbaru</div>
            <div class="card-body" style="max-height: 400px; overflow-y: auto;">
                @forelse($recentLogs as $log)
                    <div style="padding: 0.75rem 0; border-bottom: 1px solid rgba(255,255,255,0.1);">
                        <div style="font-size: 0.875rem;">{{ $log->description }}</div>
                        <div style="font-size: 0.75rem; color: var(--gray-500);">{{ $log->created_at->diffForHumans() }}</div>
                    </div>
                @empty
                    <p style="color: var(--gray-400);">Tidak ada aktivitas</p>
                @endforelse
            </div>
        </div>
    </div>
@endsection