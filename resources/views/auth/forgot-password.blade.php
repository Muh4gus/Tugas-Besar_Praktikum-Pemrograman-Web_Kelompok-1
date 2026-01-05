@extends('layouts.app')

@section('title', 'Lupa Password')

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

        .success-message {
            background: rgba(16, 185, 129, 0.2);
            border: 1px solid var(--success);
            color: var(--success);
            padding: 1rem;
            border-radius: 0.5rem;
            margin-bottom: 1.5rem;
            text-align: center;
        }
    </style>
@endsection

@section('content')
    <div class="auth-page">
        <div class="auth-container">
            <div class="auth-card animate-fade-in">
                <div class="auth-header">
                    <div class="auth-icon"><i class="fas fa-key"></i></div>
                    <h1 class="auth-title">Lupa Password?</h1>
                    <p class="auth-subtitle">Masukkan email Anda untuk reset password</p>
                </div>

                @if (session('status'))
                    <div class="success-message">
                        <i class="fas fa-check-circle"></i> {!! session('status') !!}
                    </div>
                @endif

                <form method="POST" action="{{ route('password.email') }}">
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

                    <button type="submit" class="btn btn-primary" style="width:100%;padding:1rem;">
                        <i class="fas fa-paper-plane"></i> Kirim Link Reset
                    </button>
                </form>
                <div class="auth-footer">
                    Kembali ke halaman <a href="{{ route('login') }}">Masuk</a>
                </div>
            </div>
        </div>
    </div>
@endsection