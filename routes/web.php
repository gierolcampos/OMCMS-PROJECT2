<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

Route::get('/', function () {
    return Auth::check() ? redirect()->route('home') : redirect()->route('login');
});

// Protected routes that require authentication
Route::middleware(['auth'])->group(function () {
    Route::get('/homicse', [HomeController::class, 'index'])->name('home');
    
    Route::get('/dashboard', function () {
        return view('dashboard.index');
    })->name('dashboard');
    
    Route::get('/members', function () {
        return view('members.index');
    })->name('members');
    
    Route::get('/events', function () {
        return view('events.index');
    })->name('events');
    
    Route::get('/announcements', function () {
        return view('announcements.index');
    })->name('announcements');

    Route::get('/payments', function () {
        return view('payments.index');
    })->name('payments');

    Route::get('/letters', function () {
        return view('letters.index');
    })->name('letters'); 

    Route::get('/ics-hall', function () {
        return view('ics-hall.index');
    })->name('ics-hall');

    Route::get('/aboutus', function () {
        return view('aboutus.index');
    })->name('aboutus');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
