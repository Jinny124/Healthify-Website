<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\VoteController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ThreadController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\LocaleController;
use App\Http\Middleware\LocalizationMiddleWare;


Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::get('/aboutus',function () {
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

require __DIR__ . '/auth.php';

Route::middleware(LocalizationMiddleWare::class)->group(function(){
    Route::get('/', [ThreadController::class, 'search'])->name('threads.search');
    Route::get('threads/create', [ThreadController::class, 'create'])->name('threads.thread.create');
    Route::post('threads', [ThreadController::class, 'store'])->name('threads.thread.store');
    Route::delete('/threads/{thread}', [ThreadController::class, 'destroy'])->name('threads.destroy');



    Route::get('threads/{thread}', [ThreadController::class, 'show'])->name('threads.thread.show');

    Route::post('threads/{thread}/comments', [CommentController::class, 'store'])->name('comments.store');
    Route::delete('/comments/{comment}', [CommentController::class, 'destroy'])->name('comments.destroy');

    Route::post('/vote/{type}/{id}', [VoteController::class, 'vote'])->name('vote');

    Route::get('/profile/{user}', [ProfileController::class, 'show'])->name('profile.show');
    Route::get('locale/{lang}', [LocaleController::class, 'setLocale'])->name('lang.switch');
});