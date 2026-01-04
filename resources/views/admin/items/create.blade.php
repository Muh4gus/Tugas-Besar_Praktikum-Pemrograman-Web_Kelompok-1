@extends('layouts.admin')
@section('title', 'Tambah Item Lelang')
@section('content')
    <div class="page-header">
        <h1 class="page-title">Tambah Item Lelang</h1>
        <a href="{{ route('admin.items.index') }}" class="btn btn-secondary"><i class="fas fa-arrow-left"></i> Kembali</a>
    </div>
    <div class="card">
        <div class="card-body">
            <form action="{{ route('admin.items.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="form-group">
                    <label class="form-label">Kategori *</label>
                    <select name="category_id" class="form-control" required>
                        <option value="">Pilih Kategori</option>
                        @foreach($categories as $cat)<option value="{{ $cat->id }}">{{ $cat->name }}</option>@endforeach
                    </select>
                    @error('category_id')<span
                    style="color: var(--danger); font-size: 0.85rem;">{{ $message }}</span>@enderror
                </div>
                <div class="form-group">
                    <label class="form-label">Judul Item *</label>
                    <input type="text" name="title" class="form-control" value="{{ old('title') }}" required>
                </div>
                <div class="form-group">
                    <label class="form-label">Deskripsi *</label>
                    <textarea name="description" class="form-control" rows="4" required>{{ old('description') }}</textarea>
                </div>
                <div class="form-group">
                    <label class="form-label">Gambar</label>
                    <input type="file" name="image" class="form-control" accept="image/*">
                </div>
                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1rem;">
                    <div class="form-group">
                        <label class="form-label">Harga Awal (Rp) *</label>
                        <input type="number" name="starting_price" class="form-control"
                            value="{{ old('starting_price', 100000) }}" min="0" required>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Kelipatan Bid (Rp) *</label>
                        <input type="number" name="minimum_bid_increment" class="form-control"
                            value="{{ old('minimum_bid_increment', 10000) }}" min="1000" required>
                    </div>
                </div>
                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1rem;">
                    <div class="form-group">
                        <label class="form-label">Waktu Mulai *</label>
                        <input type="datetime-local" name="start_time" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Waktu Berakhir *</label>
                        <input type="datetime-local" name="end_time" class="form-control" required>
                    </div>
                </div>
                <button type="submit" class="btn btn-primary"><i class="fas fa-save"></i> Simpan</button>
            </form>
        </div>
    </div>
@endsection