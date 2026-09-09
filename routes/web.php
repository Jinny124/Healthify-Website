<?php

use App\Http\Controllers\Admin\DoctorVerificationController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\LocaleController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ThreadController;
use App\Http\Controllers\VoteController;
use App\Http\Middleware\LocalizationMiddleWare;
use Illuminate\Support\Facades\Route;

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::get('/aboutus', function () {
    return view('layouts.aboutus');
})->name('aboutus');

Route::get('/help', function () {
    return view('layouts.help');
})->name('help');

Route::middleware('auth', LocalizationMiddleWare::class)->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::middleware(['auth', 'admin', LocalizationMiddleWare::class])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {
        Route::get('doctor-verifications', [DoctorVerificationController::class, 'index'])
            ->name('doctors.index');
        Route::patch('doctor-verifications/{user}/approve', [DoctorVerificationController::class, 'approve'])
            ->name('doctors.approve');
        Route::patch('doctor-verifications/{user}/reject', [DoctorVerificationController::class, 'reject'])
            ->name('doctors.reject');
    });

require __DIR__.'/auth.php';

Route::middleware(LocalizationMiddleWare::class)->group(function () {
    Route::get('/', [ThreadController::class, 'search'])->name('threads.search');

    // Writes require an authenticated user. Registered before the
    // threads/{thread} wildcard so "threads/create" is not treated as a slug.
    Route::middleware('auth')->group(function () {
        Route::get('threads/create', [ThreadController::class, 'create'])->name('threads.thread.create');
        Route::post('threads', [ThreadController::class, 'store'])->name('threads.thread.store');
        Route::delete('/threads/{thread}', [ThreadController::class, 'destroy'])->name('threads.destroy');

        Route::post('threads/{thread}/comments', [CommentController::class, 'store'])->name('comments.store');
        Route::delete('/comments/{comment}', [CommentController::class, 'destroy'])->name('comments.destroy');

        Route::post('/vote/{type}/{id}', [VoteController::class, 'vote'])->name('vote');
    });

    // Public, read-only
    Route::get('threads/{thread}', [ThreadController::class, 'show'])->name('threads.thread.show');
    Route::get('/profile/{user}', [ProfileController::class, 'show'])->name('profile.show');
    Route::get('locale/{lang}', [LocaleController::class, 'setLocale'])->name('lang.switch');
});
