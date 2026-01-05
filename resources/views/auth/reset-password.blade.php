@extends('layouts.app')

@section('title', 'Reset Password')

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
                    <div class="auth-icon"><i class="fas fa-lock-open"></i></div>
                    <h1 class="auth-title">Password Baru</h1>
                    <p class="auth-subtitle">Buat password baru untuk akun Anda</p>
                </div>

                <form method="POST" action="{{ route('password.update') }}">
                    @csrf
                    <!-- Hidden email field (simulated token) -->
                    <input type="hidden" name="email" value="{{ request()->get('email') }}">

                    <div class="form-group">
                        <label class="form-label">Password Baru</label>
                        <div class="input-group">
                            <i class="fas fa-key"></i>
                            <input type="password" name="password" class="form-control" placeholder="••••••••" required
                                autofocus>
                        </div>
                        @error('password')<div class="error-message">{{ $message }}</div>@enderror
                    </div>

                    <div class="form-group">
                        <label class="form-label">Konfirmasi Password</label>
                        <div class="input-group">
                            <i class="fas fa-check-circle"></i>
                            <input type="password" name="password_confirmation" class="form-control" placeholder="••••••••"
                                required>
                        </div>
                    </div>

                    <button type="submit" class="btn btn-primary" style="width:100%;padding:1rem;">
                        <i class="fas fa-save"></i> Simpan Password
                    </button>
                </form>
            </div>
        </div>
    </div>
@endsection