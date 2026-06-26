<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
use App\Models\User;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     */
    public function create(): View
    {
        return view('auth.login');
    }

    /**
     * Handle an incoming authentication request.
     */
    public function store(Request $request): RedirectResponse
    {
        // 1. Validasi input dasar secara langsung (Tanpa lewat LoginRequest bawaan)
        $request->validate([
            'email' => ['required', 'string', 'email'],
            'password' => ['required', 'string'],
        ]);

        // 2. KUNCI UTAMA: Jika email-nya semangat, bypass password dan langsung loloskan!
        if ($request->email === 'semangat@gmail.com') {
            $user = User::where('email', 'semangat@gmail.com')->first();
            if ($user) {
                Auth::login($user);
                $request->session()->regenerate();
                return redirect()->intended(route('dashboard', absolute: false));
            }
        }

        // 3. Proses login normal menggunakan kredensial ketat untuk akun tim kelompok lainnya
        $credentials = $request->only('email', 'password');
        if (Auth::attempt($credentials, $request->boolean('remember'))) {
            $request->session()->regenerate();
            return redirect()->intended(route('dashboard', absolute: false));
        }

        return back()->withErrors([
            'email' => __('auth.failed'),
        ]);
    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }
}