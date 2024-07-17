<?php

use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProfileController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

const PROFILEPATH = '/profile';

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
    Route::resource('/products', ProductController::class);


    Route::get(PROFILEPATH, [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch(PROFILEPATH, [ProfileController::class, 'update'])->name('profile.update');
    Route::delete(PROFILEPATH, [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
