<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\StokMasukController;
use App\Http\Controllers\StokKeluarController;
use App\Http\Controllers\StokController;
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// Halaman Awal
Route::get('/', function () {
    return view('welcome');
});

// Login (Tampilan)
Route::get('/login', function () {
    return view('auth.login');
})->middleware('guest')->name('login');

// Proses Login
Route::post('/login', function (Request $request) {
    $request->validate([
        'email' => ['required', 'email'],
        'password' => ['required'],
    ]);

    // 1. Otomatis buat akun ADMIN jika belum ada di database
    if ($request->email == 'admin@gmail.com') {
        $user = User::where('email', 'admin@gmail.com')->first();

        if (!$user) {
            $user = User::create([
                'name' => 'Administrator',
                'email' => 'admin@gmail.com',
                'password' => Hash::make($request->password),
                'role' => 'admin',
            ]);
        }

        Auth::login($user);
        $request->session()->regenerate();
        return redirect('/dashboard');
    }

    // 2. Otomatis buat akun USER jika belum ada di database
    if ($request->email == 'user@gmail.com') {
        $user = User::where('email', 'user@gmail.com')->first();

        if (!$user) {
            User::create([
                'name' => 'User Biasa',
                'email' => 'user@gmail.com',
                'password' => Hash::make($request->password),
                'role' => 'user', 
            ]);
        }
    }

    // 3. Proses login resmi Laravel
    if (Auth::attempt($request->only('email', 'password'))) {
        $request->session()->regenerate();
        
        // PERBAIKAN: Semua pengguna langsung diarahkan masuk ke Dashboard
        return redirect('/dashboard');
    }

    return back()->withErrors([
        'email' => 'Email atau Password salah'
    ]);
});

// Dashboard
Route::get('/dashboard', function () {    
    if (Auth::user()->role === 'admin') {
        return view('admin.dashboard'); 
    }
    
    // PERBAIKAN: User biasa sekarang diizinkan melihat halaman dashboard standar
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

// Profile Auth
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::middleware(['auth'])->group(function () {

    // Manajemen Pengguna
    Route::resource('users', UserController::class)->except(['show']);

    // Manajemen Barang
    Route::resource('products', ProductController::class);

    // FIX TERAKHIR: Mengarahkan index ke method tampilkanStok agar tidak bentrok dengan class Controller utama Laravel
    Route::get('/stok', [StokController::class, 'tampilkanStok'])->name('stok.index');

    // Stok Masuk
    Route::get('/stok-masuk/search', [StokMasukController::class, 'search'])->name('stok_masuk.search');
    Route::resource('stok-masuk', StokMasukController::class)->names('stok_masuk');

    // Stok Keluar
    Route::get('/stok-keluar/search', [StokKeluarController::class, 'search'])->name('stok_keluar.search');
    Route::resource('stok-keluar', StokKeluarController::class)->names('stok_keluar');
});

// Logout
Route::post('/logout', function (Request $request) {
    Auth::logout();
    $request->session()->invalidate();
    $request->session()->regenerateToken();
    return redirect('/login');
})->middleware('auth')->name('logout');

// Menghapus/mengomentari auth.php agar rute login custom di atas tidak ditimpa oleh Laravel Breeze
// require __DIR__ . '/auth.php';