<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

Route::get('/', function () {
    return Auth::check() ? redirect()->route('home') : redirect()->route('login');
});

// Protected routes that require authentication
// Route::middleware(['auth'])->group(function () {

// });




Route::middleware(['auth', 'verified'])->group(function () {

    // Client
    Route::get('/home', [HomeController::class, 'index'])->name('home');
    
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');
    
    Route::get('/members', function () {
        return view('members');
    })->name('members');
    
    Route::get('/events', function () {
        return view('events');
    })->name('events');
    
    Route::get('/announcements', function () {
        return view('announcements');
    })->name('announcements');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');



    // Admin
    Route::prefix('admin')->middleware('is_admin')->group(function () {

        Route::get('/', function () {
            return view('admin.dashboard');
        });

        // Routing here
    });

});





require __DIR__.'/auth.php';
