<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BookController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\MemberController;
use App\Http\Controllers\LoanController;
use Inertia\Inertia;

Route::get('/', [HomeController::class, 'index']);
Route::get('/tentang', [HomeController::class, 'tentang']);
Route::get('/kontak', [HomeController::class, 'kontak']);
Route::get('/home', [HomeController::class, 'index']);




Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

Route::get('/dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
     Route::resource('books', BookController::class);
     Route::resource('members', MemberController::class);

   Route::get('/cari-buku', [BookController::class, 'search'])->name('books.search');

   Route::get('/cari-anggota', [MemberController::class, 'search'])->name('members.search');

   Route::get('/cek-nis-anggota', [MemberController::class, 'cekNis'])->name('members.cek-nis');

  Route::get('/cek-kode-buku', [BookController::class, 'cekKode'])->name('books.cek-kode');
   
    Route::resource('books', BookController::class);
    Route::resource('members', MemberController::class);
    Route::resource('loans', LoanController::class)->only(['index', 'create', 'store']);

});

require __DIR__.'/auth.php';
