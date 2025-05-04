<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\AboutUsController;
use App\Http\Controllers\NonIcsMemberController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\MemberController;
use App\Http\Controllers\LetterController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

Route::get('/', function () {
    return Auth::check() ? redirect()->route('home.index') : redirect()->route('home.index');
});



Route::middleware(['auth', 'verified'])->group(function () {

    // Client side

    // Events routes
    Route::get('/events', [App\Http\Controllers\EventController::class, 'index'])->name('events.index');
    Route::get('/events/calendar', [App\Http\Controllers\EventController::class, 'calendar'])->name('events.calendar');
    Route::get('/events/custom-calendar', [App\Http\Controllers\EventController::class, 'customCalendar'])->name('events.custom-calendar');
    Route::get('/events/upd-calendar', [App\Http\Controllers\EventController::class, 'updCalendar'])->name('events.upd-calendar');
    Route::get('/events/export/ical', [App\Http\Controllers\EventController::class, 'exportIcal'])->name('events.export.ical');
    Route::resource('events', App\Http\Controllers\EventController::class)->except(['index']);

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

     // Client Payment Routes
     Route::prefix('omcms/payments')->middleware(['auth', 'verified'])->group(function () {
        Route::get('/', [PaymentController::class, 'clientIndex'])->name('client.payments.index');
        Route::get('/create', [PaymentController::class, 'memberCreate'])->name('client.payments.create');
        Route::post('/', [PaymentController::class, 'memberStore'])->name('client.payments.store');
        Route::get('/{id}', [PaymentController::class, 'show'])->name('client.payments.show');
        Route::get('/{id}/edit', [PaymentController::class, 'memberEdit'])->name('client.payments.edit');
        Route::put('/{id}', [PaymentController::class, 'memberUpdate'])->name('client.payments.update');
    });


});


 // Admin side
 Route::prefix('admin')->middleware('is_admin')->group(function () {
    // Route::get('/', function () {
    //     return view('admin.dashboard');
    // });

    Route::get('/home', [HomeController::class, 'index'])->name('home');

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
    Route::patch('/members/{member}/status', [MemberController::class, 'updateStatus'])->name('members.updateStatus');
    Route::patch('/members/{member}/role', [MemberController::class, 'updateRole'])->name('members.updateRole');

    Route::get('/admin-members', [MemberController::class, 'index'])->name('admin.members.index');

     // Letters routes
    Route::get('/letters', [LetterController::class, 'index'])->name('admin.letters.index');
    Route::get('/letters/create', [LetterController::class, 'create'])->name('admin.letters.create');
    Route::post('/letters', [LetterController::class, 'store'])->name('admin.letters.store');
    Route::get('/letters/{letter}', [LetterController::class, 'show'])->name('admin.letters.show');
    Route::get('/letters/{letter}/edit', [LetterController::class, 'edit'])->name('admin.letters.edit');
    Route::put('/letters/{letter}', [LetterController::class, 'update'])->name('admin.letters.update');
    Route::delete('/letters/{letter}', [LetterController::class, 'destroy'])->name('admin.letters.destroy');

    // Admin Payment Routes
    Route::prefix('payments')->group(function () {
        Route::get('/', [PaymentController::class, 'index'])->name('admin.payments.index');
        Route::get('/create', [PaymentController::class, 'create'])->name('admin.payments.create');
        Route::post('/', [PaymentController::class, 'store'])->name('admin.payments.store');

        // Non-ICS Member Payment Routes - must be defined before the generic routes
        Route::get('/non-ics/{id}', [PaymentController::class, 'showNonIcs'])->name('admin.payments.show-non-ics');
        Route::post('/non-ics/{id}/approve', [PaymentController::class, 'approveNonIcs'])->name('admin.payments.approve-non-ics');
        Route::post('/non-ics/{id}/reject', [PaymentController::class, 'rejectNonIcs'])->name('admin.payments.reject-non-ics');

        // Regular payment routes
        Route::get('/{id}', [PaymentController::class, 'show'])->name('admin.payments.show');
        Route::get('/{id}/edit', [PaymentController::class, 'edit'])->name('admin.payments.edit');
        Route::put('/{id}', [PaymentController::class, 'update'])->name('admin.payments.update');
        Route::delete('/{id}', [PaymentController::class, 'destroy'])->name('admin.payments.destroy');
        Route::post('/{id}/approve', [PaymentController::class, 'approve'])->name('admin.payments.approve');
        Route::post('/{id}/reject', [PaymentController::class, 'reject'])->name('admin.payments.reject');
    });


    // Admin Non-ICS Members Routes Payment section
    Route::prefix('non-ics-members')->group(function () {
        Route::get('/', [NonIcsMemberController::class, 'index'])->name('admin.non-ics-members.index');
        Route::get('/create', [NonIcsMemberController::class, 'create'])->name('admin.non-ics-members.create');
        Route::post('/', [NonIcsMemberController::class, 'store'])->name('admin.non-ics-members.store');
        Route::get('/{id}', [NonIcsMemberController::class, 'show'])->name('admin.non-ics-members.show');
        Route::get('/{id}/edit', [NonIcsMemberController::class, 'edit'])->name('admin.non-ics-members.edit');
        Route::put('/{id}', [NonIcsMemberController::class, 'update'])->name('admin.non-ics-members.update');
        Route::delete('/{id}', [NonIcsMemberController::class, 'destroy'])->name('admin.non-ics-members.destroy');


    });
});


// Protected routes that require authentication
Route::middleware(['auth'])->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';

// Include payment types routes
require __DIR__.'/payment-types.php';
