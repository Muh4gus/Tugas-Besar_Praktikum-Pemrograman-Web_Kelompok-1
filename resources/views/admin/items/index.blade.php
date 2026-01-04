@extends('layouts.admin')
@section('title', 'Item Lelang')
@section('content')
    <div class="page-header">
        <h1 class="page-title">Item Lelang</h1>
        <a href="{{ route('admin.items.create') }}" class="btn btn-primary"><i class="fas fa-plus"></i> Tambah Item</a>
    </div>
    <div class="card">
        <table class="table">
            <thead>
                <tr>
                    <th>Item</th>
                    <th>Kategori</th>
                    <th>Harga</th>
                    <th>Status</th>
                    <th>Bid</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($items as $item)
                    <tr>
                        <td style="display: flex; align-items: center; gap: 1rem;">
                            <img src="{{ $item->image ? asset('storage/' . $item->image) : 'https://via.placeholder.com/50' }}"
                                style="width: 50px; height: 50px; border-radius: 0.5rem; object-fit: cover;">
                            <span>{{ Str::limit($item->title, 40) }}</span>
                        </td>
                        <td>{{ $item->category->name ?? '-' }}</td>
                        <td>Rp {{ number_format($item->current_price, 0, ',', '.') }}</td>
                        <td>
                            @if($item->status == 'active')<span class="badge badge-success">Aktif</span>
                            @elseif($item->status == 'pending')<span class="badge badge-warning">Pending</span>
                            @elseif($item->status == 'ended')<span class="badge badge-primary">Selesai</span>
                            @else<span class="badge badge-danger">Dibatalkan</span>@endif
                        </td>
                        <td>{{ $item->total_bids }}</td>
                        <td>
                            <a href="{{ route('admin.items.edit', $item->id) }}" class="btn btn-sm btn-primary"><i
                                    class="fas fa-edit"></i></a>
                            @if($item->status == 'active' && $item->total_bids > 0)
                                <form action="{{ route('admin.items.validate-winner', $item->id) }}" method="POST"
                                    style="display: inline;">@csrf<button class="btn btn-sm btn-success" type="submit"><i
                                            class="fas fa-trophy"></i></button></form>
                            @endif
                            <form action="{{ route('admin.items.destroy', $item->id) }}" method="POST" style="display: inline;"
                                onsubmit="return confirm('Yakin hapus?')">@csrf @method('DELETE')<button
                                    class="btn btn-sm btn-danger" type="submit"><i class="fas fa-trash"></i></button></form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="text-center" style="padding: 2rem; color: var(--gray-400);">Belum ada item</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div style="margin-top: 1rem;">{{ $items->links() }}</div>
@endsection