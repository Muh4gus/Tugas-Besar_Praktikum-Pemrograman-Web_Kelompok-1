@extends('layouts.admin')
@section('title', 'Detail Item Lelang')
@section('content')
    <div class="page-header">
        <h1 class="page-title">Detail Item Lelang</h1>
        <a href="{{ route('admin.items.index') }}" class="btn btn-secondary"><i class="fas fa-arrow-left"></i> Kembali</a>
    </div>

    <div style="display: grid; grid-template-columns: 2fr 1fr; gap: 1.5rem;">
        <div>
            <div class="card mb-4">
                <div class="card-body">
                    <div style="display: flex; gap: 1.5rem;">
                        <div style="width: 200px; height: 150px; flex-shrink: 0;">
                            <img src="{{ $item->image ? asset('storage/' . $item->image) : 'https://via.placeholder.com/200x150' }}"
                                style="width: 100%; height: 100%; object-fit: cover; border-radius: 0.5rem;">
                        </div>
                        <div style="flex: 1;">
                            <h2 style="font-size: 1.5rem; font-weight: 700; margin-bottom: 0.5rem;">{{ $item->title }}</h2>
                            <div class="text-primary font-semibold mb-2">{{ $item->category->name ?? '-' }}</div>
                            <p class="text-muted" style="margin-bottom: 1rem;">{{ $item->description }}</p>
                            <div style="display: flex; gap: 2rem;">
                                <div>
                                    <div class="text-sm text-muted">Harga Awal</div>
                                    <div class="font-semibold">Rp {{ number_format($item->starting_price, 0, ',', '.') }}
                                    </div>
                                </div>
                                <div>
                                    <div class="text-sm text-muted">Harga Saat Ini</div>
                                    <div class="font-semibold text-accent">Rp
                                        {{ number_format($item->current_price, 0, ',', '.') }}</div>
                                </div>
                                <div>
                                    <div class="text-sm text-muted">Status</div>
                                    <div>
                                        @if($item->status == 'active')<span class="badge badge-success">Aktif</span>
                                        @elseif($item->status == 'pending')<span class="badge badge-warning">Pending</span>
                                        @elseif($item->status == 'ended')<span class="badge badge-primary">Selesai</span>
                                        @else<span class="badge badge-danger">Dibatalkan</span>@endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card">
                <div class="card-header">Riwayat Bid ({{ $item->bids->count() }})</div>
                <table class="table">
                    <thead>
                        <tr>
                            <th>User</th>
                            <th>Jumlah</th>
                            <th>Waktu</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($item->bids()->orderBy('amount', 'desc')->get() as $bid)
                            <tr>
                                <td>{{ $bid->user->name }}</td>
                                <td>Rp {{ number_format($bid->amount, 0, ',', '.') }}</td>
                                <td>{{ $bid->created_at->format('d M Y H:i') }}</td>
                                <td>
                                    @if($bid->is_winning)<span class="badge badge-success">Menang</span>
                                    @else<span class="text-muted">-</span>@endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="text-center text-muted">Belum ada bid</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <div>
            <div class="card mb-4">
                <div class="card-header">Informasi Lelang</div>
                <div class="card-body">
                    <div class="form-group">
                        <label class="form-label text-sm">Pemilik</label>
                        <div>{{ $item->user->name }}</div>
                    </div>
                    <div class="form-group">
                        <label class="form-label text-sm">Pemenang</label>
                        <div>{{ $item->winner->name ?? '-' }}</div>
                    </div>
                    <div class="form-group">
                        <label class="form-label text-sm">Waktu Mulai</label>
                        <div>{{ $item->start_time->format('d M Y H:i') }}</div>
                    </div>
                    <div class="form-group">
                        <label class="form-label text-sm">Waktu Berakhir</label>
                        <div>{{ $item->end_time->format('d M Y H:i') }}</div>
                    </div>
                    <div class="form-group">
                        <label class="form-label text-sm">Dibuat</label>
                        <div>{{ $item->created_at->format('d M Y H:i') }}</div>
                    </div>
                </div>
            </div>

            <div class="card">
                <div class="card-header">Log Aktivitas</div>
                <div class="card-body" style="max-height: 300px; overflow-y: auto;">
                    @forelse($item->logs()->orderBy('created_at', 'desc')->get() as $log)
                        <div style="padding: 0.75rem 0; border-bottom: 1px solid rgba(255,255,255,0.1); font-size: 0.85rem;">
                            <div style="margin-bottom: 0.25rem;">{{ $log->description }}</div>
                            <div class="text-muted text-xs">{{ $log->created_at->format('d M H:i') }} •
                                {{ $log->user->name ?? 'System' }}</div>
                        </div>
                    @empty
                        <div class="text-muted text-center">Tidak ada log</div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
@endsection