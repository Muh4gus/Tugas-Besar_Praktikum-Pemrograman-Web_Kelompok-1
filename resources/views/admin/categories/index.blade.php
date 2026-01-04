@extends('layouts.admin')
@section('title', 'Kategori')
@section('content')
    <div class="page-header">
        <h1 class="page-title">Kategori</h1>
        <a href="{{ route('admin.categories.create') }}" class="btn btn-primary"><i class="fas fa-plus"></i> Tambah</a>
    </div>
    <div class="card">
        <table class="table">
            <thead>
                <tr>
                    <th>Nama</th>
                    <th>Item</th>
                    <th>Status</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($categories as $cat)
                    <tr>
                        <td>{{ $cat->name }}</td>
                        <td>{{ $cat->auction_items_count }}</td>
                        <td>@if($cat->is_active)<span class="badge badge-success">Aktif</span>@else<span
                        class="badge badge-danger">Nonaktif</span>@endif</td>
                        <td>
                            <a href="{{ route('admin.categories.edit', $cat->id) }}" class="btn btn-sm btn-primary"><i
                                    class="fas fa-edit"></i></a>
                            <form action="{{ route('admin.categories.destroy', $cat->id) }}" method="POST"
                                style="display: inline;" onsubmit="return confirm('Yakin hapus?')">@csrf
                                @method('DELETE')<button class="btn btn-sm btn-danger" type="submit"><i
                                        class="fas fa-trash"></i></button></form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="text-center" style="padding: 2rem; color: var(--gray-400);">Belum ada kategori
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
@endsection