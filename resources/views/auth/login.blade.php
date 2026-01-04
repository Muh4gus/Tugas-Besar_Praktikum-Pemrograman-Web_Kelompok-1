@extends('layouts.app')

@section('title', 'Masuk')

@section('styles')
    <style>
        .auth-page {
            min-height: calc(100vh - 80px);
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 3rem 1rem;
        }

        .auth-container {
            width: 100%;
            max-width: 450px;
        }

        .auth-card {
            background: rgba(26, 26, 46, 0.9);
            backdrop-filter: blur(20px);
            border: 1px solid rgba(255, 255, 255, 0.1);
            border-radius: 1.5rem;
            padding: 3rem;
        }

        .auth-header {
            text-align: center;
            margin-bottom: 2rem;
        }

        .auth-icon {
            width: 80px;
            height: 80px;
            background: var(--gradient-primary);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 1.5rem;
            font-size: 2rem;
        }

        .auth-title {
            font-size: 1.75rem;
            font-weight: 700;
            margin-bottom: 0.5rem;
        }

        .auth-subtitle {
            color: var(--gray-400);
        }

        .input-group {
            position: relative;
        }

        .input-group i {
            position: absolute;
            left: 1rem;
            top: 50%;
            transform: translateY(-50%);
            color: var(--gray-500);
        }

        .input-group .form-control {
            padding-left: 2.75rem;
        }

        .form-check {
            display: flex;
            align-items: center;
            gap: 0.75rem;
        }

        .form-check input {
            width: 18px;
            height: 18px;
            accent-color: var(--primary);
        }

        .auth-footer {
            text-align: center;
            margin-top: 2rem;
            padding-top: 2rem;
            border-top: 1px solid rgba(255, 255, 255, 0.1);
            color: var(--gray-400);
        }

        .auth-footer a {
            color: var(--primary-light);
            font-weight: 600;
        }

        .error-message {
            color: var(--danger);
            font-size: 0.85rem;
            margin-top: 0.5rem;
        }
    </style>
@endsection

@section('content')
    <div class="auth-page">
        <div class="auth-container">
            <div class="auth-card animate-fade-in">
                <div class="auth-header">
                    <div class="auth-icon"><i class="fas fa-sign-in-alt"></i></div>
                    <h1 class="auth-title">Selamat Datang!</h1>
                    <p class="auth-subtitle">Masuk ke akun LelangKu Anda</p>
                </div>
                <form method="POST" action="{{ route('login') }}">
                    @csrf
                    <div class="form-group">
                        <label class="form-label">Email</label>
                        <div class="input-group">
                            <i class="fas fa-envelope"></i>
                            <input type="email" name="email" class="form-control" placeholder="email@example.com"
                                value="{{ old('email') }}" required autofocus>
                        </div>
                        @error('email')<div class="error-message">{{ $message }}</div>@enderror
                    </div>
                    <div class="form-group">
                        <label class="form-label">Password</label>
                        <div class="input-group">
                            <i class="fas fa-lock"></i>
                            <input type="password" name="password" class="form-control" placeholder="••••••••" required>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="form-check">
                            <input type="checkbox" name="remember" id="remember">
                            <label for="remember">Ingat saya</label>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary" style="width:100%;padding:1rem;">
                        <i class="fas fa-sign-in-alt"></i> Masuk
                    </button>
                </form>
                <div class="auth-footer">Belum punya akun? <a href="{{ route('register') }}">Daftar Sekarang</a></div>
            </div>
        </div>
    </div>
@endsection