<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\VotingController;
use App\Http\Controllers\TicketPurchaseController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\EventController as AdminEventController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\ContestantController;

/*
|--------------------------------------------------------------------------
| Public Routes
|--------------------------------------------------------------------------
*/

// Landing Page
Route::get('/', function () {
    return view('pages.landing');
})->name('landing');

// About Page
Route::get('/about', function () {
    return view('pages.about');
})->name('about');

// Pricing Page
Route::get('/pricing', function () {
    return view('pages.pricing');
})->name('pricing');

// Contact Page
Route::get('/contact', function () {
    return view('pages.contact');
})->name('contact');

// Contact Form Submission
Route::post('/contact', [App\Http\Controllers\ContactController::class, 'submit'])->name('contact.submit');

// Privacy Policy
Route::get('/privacy', function () {
    return view('pages.privacy');
})->name('privacy');

// Terms of Service
Route::get('/terms', function () {
    return view('pages.terms');
})->name('terms');

// Events homepage
Route::get('/events', [HomeController::class, 'index'])->name('home');

// Event details
Route::get('/events/{slug}', [EventController::class, 'show'])->name('events.show');
Route::get('/events/{event}/category/{category}', [EventController::class, 'category'])->name('events.category');

/*
|--------------------------------------------------------------------------
| Voting Routes
|--------------------------------------------------------------------------
*/

Route::middleware(['throttle:5,1'])->group(function () {
    Route::get('/vote/{contestant}', [VotingController::class, 'show'])->name('voting.show');
    Route::post('/vote/{contestant}', [VotingController::class, 'initiate'])->name('voting.initiate');
});

// Voting callback and success (MUST come before other routes with parameters)
Route::get('/voting/callback', [VotingController::class, 'callback'])->name('voting.callback');
Route::get('/voting/success/{vote}', [VotingController::class, 'success'])->name('voting.success');

/*
|--------------------------------------------------------------------------
| Public Ticket Purchase Routes
|--------------------------------------------------------------------------
*/

Route::get('/events/{event:slug}/tickets', [TicketPurchaseController::class, 'show'])->name('tickets.show');
Route::post('/tickets/{ticket}/checkout', [TicketPurchaseController::class, 'checkout'])->name('tickets.checkout');

// IMPORTANT: Static routes MUST come before dynamic parameter routes
Route::get('/tickets/callback', [TicketPurchaseController::class, 'callback'])->name('tickets.callback');

// Dynamic parameter routes
Route::get('/tickets/{order}/payment', [TicketPurchaseController::class, 'payment'])->name('tickets.payment');
Route::post('/tickets/{order}/process-payment', [TicketPurchaseController::class, 'processPayment'])->name('tickets.process-payment');
Route::get('/tickets/{order}/success', [TicketPurchaseController::class, 'success'])->name('tickets.success');
Route::get('/tickets/{order}/download', [TicketPurchaseController::class, 'download'])->name('tickets.download');

/*
|--------------------------------------------------------------------------
| Authenticated Routes
|--------------------------------------------------------------------------
*/

Route::middleware('auth')->group(function () {
    // Profile routes
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

/*
|--------------------------------------------------------------------------
| Admin Routes
|--------------------------------------------------------------------------
*/

Route::middleware(['auth'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    
    // Events management
    Route::resource('events', AdminEventController::class);
    
    // Categories management
    Route::get('/events/{event}/categories/create', [CategoryController::class, 'create'])->name('categories.create');
    Route::post('/events/{event}/categories', [CategoryController::class, 'store'])->name('categories.store');
    Route::get('/categories/{category}/edit', [CategoryController::class, 'edit'])->name('categories.edit');
    Route::put('/categories/{category}', [CategoryController::class, 'update'])->name('categories.update');
    Route::delete('/categories/{category}', [CategoryController::class, 'destroy'])->name('categories.destroy');
    
    // Contestants management
    Route::get('/categories/{category}/contestants/create', [ContestantController::class, 'create'])->name('contestants.create');
    Route::post('/categories/{category}/contestants', [ContestantController::class, 'store'])->name('contestants.store');
    Route::get('/contestants/{contestant}/edit', [ContestantController::class, 'edit'])->name('contestants.edit');
    Route::put('/contestants/{contestant}', [ContestantController::class, 'update'])->name('contestants.update');
    Route::delete('/contestants/{contestant}', [ContestantController::class, 'destroy'])->name('contestants.destroy');
    Route::post('/categories/{category}/evict-bottom', [ContestantController::class, 'evictBottom'])->name('contestants.evict-bottom');
    
    // Audit logs
    Route::get('/audit-logs', function () {
        $logs = \App\Models\AuditLog::with('user')
            ->latest()
            ->paginate(50);
        
        return view('admin.audit-logs', compact('logs'));
    })->name('audit-logs');
});

/*
|--------------------------------------------------------------------------
| Auth Routes & Organizer Routes
|--------------------------------------------------------------------------
*/

require __DIR__.'/auth.php';
require __DIR__.'/organizer.php';