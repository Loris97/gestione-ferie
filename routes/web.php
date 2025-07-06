<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\DipendenteController;
use App\Http\Controllers\PasswordController;
use App\Http\Controllers\FerieController;
use Illuminate\Support\Facades\Route;
use App\Http\Middleware\IsAdmin;
use App\Http\Middleware\IsDipendente;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;

require __DIR__ . '/auth.php';

// Rotta principale: reindirizza in base al ruolo dell'utente autenticato
Route::get('/', function () {
    if (Auth::check()) {
        $user = Auth::user();
        if ($user->ruolo === 'admin') {
            return redirect()->route('admin.home');
        } else {
            return redirect()->route('dipendente.home');
        }
    }
    return Redirect::route('login');
});


// Rotte profilo utente (solo autenticati)
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Rotte per amministratori (solo admin)
Route::middleware(['auth', IsAdmin::class])->group(function () {
    Route::get('/admin', [AdminController::class, 'index']);
    Route::get('/home', [AdminController::class, 'index']);
    Route::post('ferie/{id}/approve', [FerieController::class, 'approve'])->name('ferie.approve');
    Route::post('ferie/{id}/reject', [FerieController::class, 'reject'])->name('ferie.reject');
    Route::get('/dipendente/{id}/ferie', [FerieController::class, 'showForDipendente'])->name('ferie.dipendente');
    Route::get('/dipendente/{id}/edit', [DipendenteController::class, 'edit'])->name('dipendente.edit');
    Route::put('/dipendente/{id}', [DipendenteController::class, 'update'])->name('dipendente.update');
    Route::delete('/dipendente/{id}', [DipendenteController::class, 'destroy'])->name('dipendente.destroy');
    Route::get('/dipendente/create', [DipendenteController::class, 'create'])->name('dipendente.create');
    Route::post('/dipendente', [DipendenteController::class, 'store'])->name('dipendente.store');
    Route::get('/admin', [AdminController::class, 'index'])->name('admin.home');
    Route::patch('/ferie/{id}/status', [FerieController::class, 'updateStatus'])->name('ferie.updateStatus');
});

// Rotte per dipendenti (solo dipendente)
Route::middleware(['auth', 'must_change_password', IsDipendente::class])->group(function () {
    Route::get('/home', [DipendenteController::class, 'index']);
    Route::get('/dipendente', [DipendenteController::class, 'index'])->name('dipendente.home');
    Route::get('ferie/create', [FerieController::class, 'create'])->name('ferie.create');
    Route::post('ferie', [FerieController::class, 'store'])->name('ferie.store');
    Route::get('/auth/change-password', [PasswordController::class, 'showChangeForm'])->name('password.change');
    Route::post('/auth/change-password', [PasswordController::class, 'change'])->name('password.update');
});
