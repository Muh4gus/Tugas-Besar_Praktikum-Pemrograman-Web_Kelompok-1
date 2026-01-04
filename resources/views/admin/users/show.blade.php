@extends('layouts.admin')
@section('title', 'Detail Pengguna')
@section('content')
    <div class="page-header">
        <h1 class="page-title">Detail Pengguna</h1>
        <a href="{{ route('admin.users.index') }}" class="btn btn-secondary"><i class="fas fa-arrow-left"></i> Kembali</a>
    </div>

    <div style="display: grid; grid-template-columns: 1fr 2fr; gap: 1.5rem;">
        <div>
            <div class="card mb-4">
                <div class="card-body text-center">
                    <img src="{{ $user->avatar_url }}"
                        style="width: 100px; height: 100px; border-radius: 50%; margin-bottom: 1rem;">
                    <h2 style="font-size: 1.5rem; font-weight: 700;">{{ $user->name }}</h2>
                    <div class="text-muted mb-3">{{ $user->email }}</div>

                    <div style="display: flex; justify-content: center; gap: 1rem; margin-bottom: 1.5rem;">
                        <div class="text-center">
                            <div class="font-bold text-lg">{{ $user->auction_items_count }}</div>
                            <div class="text-xs text-muted">Lelang</div>
                        </div>
                        <div class="text-center">
                            <div class="font-bold text-lg">{{ $user->bids_count }}</div>
                            <div class="text-xs text-muted">Bid</div>
                        </div>
                        <div class="text-center">
                            <div class="font-bold text-lg">{{ $user->won_auctions_count }}</div>
                            <div class="text-xs text-muted">Menang</div>
                        </div>
                    </div>

                    <div class="form-group text-left">
                        <label class="form-label text-sm">Role</label>
                        <form action="{{ route('admin.users.update-role', $user->id) }}" method="POST">
                            @csrf @method('PUT')
                            <select name="role" onchange="this.form.submit()" class="form-control">
                                <option value="user" {{ $user->role == 'user' ? 'selected' : '' }}>User</option>
                                <option value="admin" {{ $user->role == 'admin' ? 'selected' : '' }}>Admin</option>
                            </select>
                        </form>
                    </div>
                </div>
            </div>

            <div class="card">
                <div class="card-header">Info Kontak</div>
                <div class="card-body">
                    <div class="form-group">
                        <label class="form-label text-sm">No. Telepon</label>
                        <div>{{ $user->phone ?? '-' }}</div>
                    </div>
                    <div class="form-group">
                        <label class="form-label text-sm">Alamat</label>
                        <div>{{ $user->address ?? '-' }}</div>
                    </div>
                    <div class="form-group">
                        <label class="form-label text-sm">Bergabung</label>
                        <div>{{ $user->created_at->format('d M Y') }}</div>
                    </div>
                </div>
            </div>
        </div>

        <div>
            <div class="card mb-4">
                <div class="card-header">Aktivitas Bid Terbaru</div>
                <table class="table">
                    <thead>
                        <tr>
                            <th>Item</th>
                            <th>Jumlah</th>
                            <th>Waktu</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($recentBids as $bid)
                            <tr>
                                <td>
                                    <a href="{{ route('admin.items.show', $bid->auction_item_id) }}"
                                        class="text-primary hover:underline">
                                        {{ Str::limit($bid->auctionItem->title, 40) }}
                                    </a>
                                </td>
                                <td>Rp {{ number_format($bid->amount, 0, ',', '.') }}</td>
                                <td>{{ $bid->created_at->diffForHumans() }}</td>
                                <td>
                                    @if($bid->is_winning)<span class="badge badge-success">Menang</span>
                                    @else<span class="text-muted">-</span>@endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="text-center text-muted">Belum ada aktivitas bid</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection