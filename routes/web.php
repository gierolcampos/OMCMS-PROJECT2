<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\MemberController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

Route::get('/', function () {
    return Auth::check() ? redirect()->route('home.index') : redirect()->route('login');
});

<<<<<<< HEAD
=======
Route::middleware(['auth', 'verified'])->group(function () {

    // Client

    Route::get('/events', function () {
        return view('events.index');
    })->name('events.index');

    Route::get('/announcements', function () {
        return view('announcements.index');
    })->name('announcements');

    Route::get('/omcms/ics_hall', [HomeController::class, 'index'])->name('home.index');

    Route::get('/omcms/events', [HomeController::class, 'events'])->name('events.index');

    Route::get('/omcms/announcements', [HomeController::class, 'announcements'])->name('announcements');

    Route::get('/omcms/payments', [HomeController::class, 'payments'])->name('payments');

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
        


        Route::get('/letters', function () {
            return view('letters.index');
        })->name('letters'); 
    });

});



>>>>>>> 5d3b4c2b8dcf182cccfa632652152fed08a7c07f
// Protected routes that require authentication
Route::middleware(['auth'])->group(function () {
    Route::get('/homicse', [HomeController::class, 'index'])->name('home');
    
    Route::get('/dashboard', function () {
        return view('dashboard.index');
    })->name('dashboard');
    
    // Members routes
    Route::get('/members', [MemberController::class, 'index'])->name('members.index');
    Route::get('/members/create', [MemberController::class, 'create'])->name('members.create');
    Route::post('/members', [MemberController::class, 'store'])->name('members.store');
    Route::get('/members/{member}', [MemberController::class, 'show'])->name('members.show');
    Route::get('/members/{member}/edit', [MemberController::class, 'edit'])->name('members.edit');
    Route::put('/members/{member}', [MemberController::class, 'update'])->name('members.update');
    Route::delete('/members/{member}', [MemberController::class, 'destroy'])->name('members.destroy');
    
    // Add routes for export and import members
    Route::get('/members-export', [MemberController::class, 'export'])->name('members.export');
    Route::get('/members-import', [MemberController::class, 'showImportForm'])->name('members.showImport');
    Route::post('/members-import', [MemberController::class, 'import'])->name('members.import');
    
    Route::get('/events', function () {
        return view('events.index');
    })->name('events');
    
    Route::get('/announcements', function () {
        return view('announcements.index');
    })->name('announcements');

    Route::get('/omcms/ics_hall', [HomeController::class, 'index'])->name('home.index');

    Route::get('/omcms/events', [HomeController::class, 'events'])->name('events.index');

    Route::get('/omcms/announcements', [HomeController::class, 'announcements'])->name('announcements');

    Route::get('/omcms/payments', [HomeController::class, 'payments'])->name('payments');

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
