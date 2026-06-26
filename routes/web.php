<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\StokController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// 1. Halaman Utama Web
Route::get('/', function () {
    return view('welcome');
});

// 2. Tampilkan Halaman Login Bawaan Kelompok
Route::get('/login', function () {
    return view('auth.login');
})->middleware('guest')->name('login');

// 3. GERBANG DARURAT (Otomatis Buat Akun & Login Langsung)
Route::post('/login', function (Request $request) {
    $request->validate([
        'email' => ['required', 'string', 'email'],
        'password' => ['required', 'string'],
    ]);

    // Jika yang login menggunakan email semangat
    if ($request->email === 'semangat@gmail.com') {
        // Cek apakah akunnya sudah ada di database kelompok?
        $user = User::where('email', 'semangat@gmail.com')->first();
        
        // JIKA BELUM ADA, LANGSUNG KITA BUATKAN DI SINI SECARA OTOMATIS!
        if (!$user) {
            $user = User::create([
                'name' => 'Admin Semangat',
                'email' => 'semangat@gmail.com',
                'password' => Hash::make($request->password), // Memakai password apa saja yang kamu ketik
                'role' => 'admin', // Langsung diberi role admin kelompok
            ]);
        }

        // Langsung loginkan tanpa hambatan password
        Auth::login($user);
        $request->session()->regenerate();
        return redirect()->intended('/dashboard');
    }

    // Login normal untuk sisa anggota kelompok lainnya
    $credentials = $request->only('email', 'password');
    if (Auth::attempt($credentials, $request->boolean('remember'))) {
        $request->session()->regenerate();
        return redirect()->intended('/dashboard');
    }

    return back()->withErrors([
        'email' => __('auth.failed'),
    ]);
});

// 4. Dashboard Utama Tugas Kelompok
Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

// 5. Hak Akses Profil Umum
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// 6. FITUR UTAMA KELOMPOK: Manajemen Pengguna, Barang, dan Stok (Tanpa Fitur Langganan)
Route::middleware(['auth'])->group(function () {
    Route::resource('users', UserController::class)->except(['show']);
    Route::resource('products', ProductController::class);
    Route::resource('stok', StokController::class);
});

// 7. Rute Logout
Route::post('/logout', function (Request $request) {
    Auth::logout();
    $request->session()->invalidate();
    $request->session()->regenerateToken();
    return redirect('/login');
})->middleware('auth')->name('logout');