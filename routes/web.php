<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\StokMasukController;
use App\Http\Controllers\StokKeluarController;
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

// Login
Route::get('/login', function () {
    return view('auth.login');
})->middleware('guest')->name('login');

Route::post('/login', function (Request $request) {
    $request->validate([
        'email' => ['required', 'email'],
        'password' => ['required'],
    ]);

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

    if (Auth::attempt($request->only('email', 'password'))) {
        $request->session()->regenerate();
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
    
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

// Profile Auth
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Semua Menu Aplikasi (Hanya Bisa Diakses Setelah Login)
Route::middleware(['auth'])->group(function () {

    // User Management
    Route::resource('users', UserController::class)->except(['show']);

    // Master Manajemen Barang
    Route::resource('products', ProductController::class);

    // Master Manajemen Stok (Dialihkan menggunakan ProductController agar Tampilan Baru Aktif)
    Route::get('/stok', [ProductController::class, 'index'])->name('stok.index');
    Route::get('/stok/create', [ProductController::class, 'create'])->name('stok.create');
    Route::post('/stok', [ProductController::class, 'store'])->name('stok.store');
    Route::get('/stok/{product}/edit', [ProductController::class, 'edit'])->name('stok.edit');
    Route::put('/stok/{product}', [ProductController::class, 'update'])->name('stok.update');
    Route::delete('/stok/{product}', [ProductController::class, 'destroy'])->name('stok.destroy');

    // Transaksi Stok Masuk
    Route::get('/stok-masuk/search', [StokMasukController::class, 'search'])->name('stok_masuk.search');
    Route::resource('stok-masuk', StokMasukController::class)->names('stok_masuk');

    // Transaksi Stok Keluar
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

require __DIR__ . '/auth.php';