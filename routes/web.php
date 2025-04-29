<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\AboutUsController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

Route::get('/', function () {
    return Auth::check() ? redirect()->route('home') : redirect()->route('login');
});

Route::middleware(['auth', 'verified'])->group(function () {

    // Client
    Route::get('/omcms/ics_hall', [HomeController::class, 'index'])->name('home.index');

    Route::get('/omcms/about_us/about_ics', [AboutUsController::class, 'about_ics'])->name('about_us.about_ics');

    Route::get('/omcms/about_us/vision_mission', [AboutUsController::class, 'vision_mission'])->name('about_us.vision_mission');

    Route::get('/omcms/about_us/history', [AboutUsController::class, 'history'])->name('about_us.history');

    Route::get('/omcms/about_us/logo_symbolism', [AboutUsController::class, 'logo_symbolism'])->name('about_us.logo_symbolism');

    Route::get('/omcms/about_us/student_leaders', [AboutUsController::class, 'student_leaders'])->name('about_us.student_leaders');

    Route::get('/omcms/about_us/developers', [AboutUsController::class, 'developers'])->name('about_us.developers');

    Route::get('/omcms/about_us/contact', [AboutUsController::class, 'contact'])->name('about_us.contact');

    Route::get('/aboutus', function () { return view('aboutus.index');
    })->name('aboutus');

    // Admin
    Route::prefix('admin')->middleware('is_admin')->group(function () {
        // Route::get('/', function () {
        //     return view('admin.dashboard');
        // });

        Route::get('/home', [HomeController::class, 'index'])->name('home');
    
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
    });

});



// Protected routes that require authentication
Route::middleware(['auth'])->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
