<?php

namespace App\Http\Controllers;

use App\Models\AuctionLog;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class AuthController extends Controller
{
    /**
     * Tampilkan form login.
     */
    public function showLogin()
    {
        if (Auth::check()) {
            return redirect()->route('dashboard');
        }
        return view('auth.login');
    }

    /**
     * Proses permintaan login.
     */
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (Auth::attempt($credentials, $request->boolean('remember'))) {
            $request->session()->regenerate();

            AuctionLog::log(
                null,
                Auth::id(),
                'user_login',
                'User ' . Auth::user()->name . ' logged in'
            );

            if (Auth::user()->isAdmin()) {
                return redirect()->intended(route('admin.dashboard'));
            }

            return redirect()->intended(route('dashboard'));
        }

        return back()->withErrors([
            'email' => 'Email atau password yang Anda masukkan salah.',
        ])->onlyInput('email');
    }

    /**
     * Tampilkan form registrasi.
     */
    public function showRegister()
    {
        if (Auth::check()) {
            return redirect()->route('dashboard');
        }
        return view('auth.register');
    }

    /**
     * Proses permintaan registrasi.
     */
    public function register(Request $request)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'phone' => ['nullable', 'string', 'max:20'],
            'password' => ['required', 'confirmed', Password::min(8)],
        ]);

        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'phone' => $validated['phone'] ?? null,
            'password' => Hash::make($validated['password']),
            'role' => 'user',
        ]);

        AuctionLog::log(
            null,
            $user->id,
            'user_registered',
            'New user registered: ' . $user->name
        );

        Auth::login($user);

        return redirect()->route('dashboard');
    }

    /**
     * Proses logout user.
     */
    public function logout(Request $request)
    {
        AuctionLog::log(
            null,
            Auth::id(),
            'user_logout',
            'User ' . Auth::user()->name . ' logged out'
        );

        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('home');
    }

    /**
     * Tampilkan form lupa password.
     */
    public function showForgotPassword()
    {
        return view('auth.forgot-password');
    }

    /**
     * Proses kirim link reset password (Mock/Simulasi).
     */
    public function sendResetLink(Request $request)
    {
        $request->validate(['email' => 'required|email']);

        // Mock: Cek apakah user ada di database
        $user = User::where('email', $request->email)->first();

        if (!$user) {
            return back()->withErrors(['email' => 'Email ini tidak terdaftar dalam sistem kami.']);
        }

        // Mock success message (Simulasi)
        // [DEV NOTE]: Kita sertakan link reset langsung agar bisa dites tanpa email server
        $resetLink = route('password.reset', ['email' => $request->email]);
        return back()->with('status', 'Link reset password telah dikirim! (Mode Demo: <a href="' . $resetLink . '" style="text-decoration: underline;"><b>Klik di sini untuk Reset Password</b></a>)');
    }

    /**
     * Tampilkan form reset password.
     */
    public function showResetForm(Request $request)
    {
        return view('auth.reset-password');
    }

    /**
     * Proses logika reset password.
     */
    public function resetPassword(Request $request)
    {
        $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required', 'confirmed', Password::min(8)],
        ]);

        $user = User::where('email', $request->email)->first();

        if (!$user) {
            return back()->withErrors(['email' => 'User tidak ditemukan.']);
        }

        $user->update([
            'password' => Hash::make($request->password)
        ]);

        // Auto login setelah reset
        Auth::login($user);

        return redirect()->route('dashboard')->with('success', 'Password berhasil direset! Selamat datang kembali.');
    }
}
