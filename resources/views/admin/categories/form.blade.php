@extends('layouts.admin')
@section('title', isset($category) ? 'Edit Kategori' : 'Tambah Kategori')
@section('content')
    <div class="page-header">
        <h1 class="page-title">{{ isset($category) ? 'Edit' : 'Tambah' }} Kategori</h1>
        <a href="{{ route('admin.categories.index') }}" class="btn btn-secondary"><i class="fas fa-arrow-left"></i>
            Kembali</a>
    </div>
    <div class="card">
        <div class="card-body">
            <form
                action="{{ isset($category) ? route('admin.categories.update', $category->id) : route('admin.categories.store') }}"
                method="POST" enctype="multipart/form-data">
                @csrf
                @if(isset($category)) @method('PUT') @endif
                <div class="form-group">
                    <label class="form-label">Nama *</label>
                    <input type="text" name="name" class="form-control" value="{{ $category->name ?? old('name') }}"
                        required>
                </div>
                <div class="form-group">
                    <label class="form-label">Deskripsi</label>
                    <textarea name="description" class="form-control"
                        rows="3">{{ $category->description ?? old('description') }}</textarea>
                </div>
                <div class="form-group">
                    <label class="form-label">Icon (Font Awesome, e.g: car, laptop, home)</label>
                    <input type="text" name="icon" class="form-control" value="{{ $category->icon ?? old('icon') }}"
                        placeholder="laptop">
                </div>
                <div class="form-group">
                    <label class="form-label"><input type="checkbox" name="is_active" value="1" {{ (isset($category) ? $category->is_active : true) ? 'checked' : '' }}> Aktif</label>
                </div>
                <button type="submit" class="btn btn-primary"><i class="fas fa-save"></i> Simpan</button>
            </form>
        </div>
    </div>
@endsection