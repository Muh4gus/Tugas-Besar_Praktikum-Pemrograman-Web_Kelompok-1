@extends('layouts.admin')
@section('title', 'Edit Item Lelang')
@section('content')
    <div class="page-header">
        <h1 class="page-title">Edit Item Lelang</h1>
        <a href="{{ route('admin.items.index') }}" class="btn btn-secondary"><i class="fas fa-arrow-left"></i> Kembali</a>
    </div>
    <div class="card">
        <div class="card-body">
            <form action="{{ route('admin.items.update', $item->id) }}" method="POST" enctype="multipart/form-data">
                @csrf @method('PUT')
                <div class="form-group">
                    <label class="form-label">Kategori *</label>
                    <select name="category_id" class="form-control" required>
                        @foreach($categories as $cat)<option value="{{ $cat->id }}" {{ $item->category_id == $cat->id ? 'selected' : '' }}>{{ $cat->name }}</option>@endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label class="form-label">Judul Item *</label>
                    <input type="text" name="title" class="form-control" value="{{ $item->title }}" required>
                </div>
                <div class="form-group">
                    <label class="form-label">Deskripsi *</label>
                    <textarea name="description" class="form-control" rows="4" required>{{ $item->description }}</textarea>
                </div>
                <div class="form-group">
                    <label class="form-label">Gambar</label>
                    @if($item->image)<img src="{{ asset('storage/' . $item->image) }}"
                    style="width: 150px; height: 100px; object-fit: cover; border-radius: 0.5rem; margin-bottom: 0.5rem; display: block;">@endif
                    <input type="file" name="image" class="form-control" accept="image/*">
                </div>
                <div class="form-group">
                    <label class="form-label">Status *</label>
                    <select name="status" class="form-control" required>
                        <option value="pending" {{ $item->status == 'pending' ? 'selected' : '' }}>Pending</option>
                        <option value="active" {{ $item->status == 'active' ? 'selected' : '' }}>Aktif</option>
                        <option value="ended" {{ $item->status == 'ended' ? 'selected' : '' }}>Selesai</option>
                        <option value="cancelled" {{ $item->status == 'cancelled' ? 'selected' : '' }}>Dibatalkan</option>
                    </select>
                </div>
                <div class="form-group">
                    <label class="form-label">Waktu Berakhir *</label>
                    <input type="datetime-local" name="end_time" class="form-control"
                        value="{{ $item->end_time->format('Y-m-d\TH:i') }}" required>
                </div>
                <button type="submit" class="btn btn-primary"><i class="fas fa-save"></i> Update</button>
            </form>
        </div>
    </div>
@endsection