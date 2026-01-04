@extends('layouts.app')
@section('title', 'Profil Saya')
@section('content')
    <div class="container" style="padding: 2rem 0;">
        <h1 style="font-size: 1.75rem; font-weight: 700; margin-bottom: 2rem;"><i class="fas fa-user text-primary"></i>
            Profil Saya</h1>
        <div class="card">
            <div class="card-body">
                <form action="{{ route('profile.update') }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="form-group">
                        <label class="form-label">Nama Lengkap</label>
                        <input type="text" name="name" class="form-control" value="{{ auth()->user()->name }}" required>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Email</label>
                        <input type="email" class="form-control" value="{{ auth()->user()->email }}" disabled>
                        <small class="text-muted">Email tidak dapat diubah</small>
                    </div>
                    <div class="form-group">
                        <label class="form-label">No. Telepon</label>
                        <input type="text" name="phone" class="form-control" value="{{ auth()->user()->phone }}">
                    </div>
                    <div class="form-group">
                        <label class="form-label">Alamat</label>
                        <textarea name="address" class="form-control" rows="3">{{ auth()->user()->address }}</textarea>
                    </div>
                    <button type="submit" class="btn btn-primary"><i class="fas fa-save"></i> Simpan Perubahan</button>
                </form>
            </div>
        </div>
    </div>
@endsection