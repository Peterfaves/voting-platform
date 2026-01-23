<?php

use App\Http\Controllers\Organizer\DashboardController;
use App\Http\Controllers\Organizer\EventController;
use App\Http\Controllers\Organizer\CategoryController;
use App\Http\Controllers\Organizer\ContestantController;
use App\Http\Controllers\Organizer\ReportController;
use App\Http\Controllers\Organizer\WithdrawalController;
use App\Http\Controllers\Organizer\TransactionController;
use App\Http\Controllers\Organizer\SettingsController;
use App\Http\Controllers\Organizer\ContactController;
use App\Http\Controllers\Organizer\TicketController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Organizer Routes
|--------------------------------------------------------------------------
|
| Routes for event organizers (users who create and manage voting events)
|
*/

Route::middleware(['auth'])->prefix('organizer')->name('organizer.')->group(function () {
    
    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    
    // Events Management
    Route::prefix('events')->name('events.')->group(function () {
        Route::get('/', [EventController::class, 'index'])->name('index');
        Route::get('/create', [EventController::class, 'create'])->name('create');
        Route::post('/', [EventController::class, 'store'])->name('store');
        Route::get('/manage', [EventController::class, 'manage'])->name('manage');
        Route::get('/{event}', [EventController::class, 'show'])->name('show');
        Route::get('/{event}/edit', [EventController::class, 'edit'])->name('edit');
        Route::put('/{event}', [EventController::class, 'update'])->name('update');
        Route::delete('/{event}', [EventController::class, 'destroy'])->name('destroy');
        Route::post('/{event}/publish', [EventController::class, 'publish'])->name('publish');
        Route::post('/{event}/end', [EventController::class, 'end'])->name('end');
        Route::get('/{event}/analytics', [EventController::class, 'analytics'])->name('analytics');
    });
    
    // Categories Management
    Route::get('/events/{event}/categories/create', [CategoryController::class, 'create'])->name('categories.create');
    Route::post('/events/{event}/categories', [CategoryController::class, 'store'])->name('categories.store');
    Route::get('/categories/{category}/edit', [CategoryController::class, 'edit'])->name('categories.edit');
    Route::put('/categories/{category}', [CategoryController::class, 'update'])->name('categories.update');
    Route::delete('/categories/{category}', [CategoryController::class, 'destroy'])->name('categories.destroy');
    
    // Contestants Management
    Route::get('/categories/{category}/contestants/create', [ContestantController::class, 'create'])->name('contestants.create');
    Route::post('/categories/{category}/contestants', [ContestantController::class, 'store'])->name('contestants.store');
    Route::get('/contestants/{contestant}/edit', [ContestantController::class, 'edit'])->name('contestants.edit');
    Route::put('/contestants/{contestant}', [ContestantController::class, 'update'])->name('contestants.update');
    Route::delete('/contestants/{contestant}', [ContestantController::class, 'destroy'])->name('contestants.destroy');
    
    // Reports
    Route::get('/reports', [ReportController::class, 'index'])->name('reports');
    Route::get('/reports/download', [ReportController::class, 'download'])->name('reports.download');
    
    // Withdrawals
    Route::get('/withdrawals', [WithdrawalController::class, 'index'])->name('withdrawals');
    Route::post('/withdrawals', [WithdrawalController::class, 'store'])->name('withdrawals.store');
    
    // Transactions
    Route::get('/transactions', [TransactionController::class, 'index'])->name('transactions');
    Route::get('/transactions/export', [TransactionController::class, 'export'])->name('transactions.export');
    
    // Settings
    Route::get('/settings', [SettingsController::class, 'index'])->name('settings');
    Route::put('/settings/profile', [SettingsController::class, 'updateProfile'])->name('settings.profile');
    Route::put('/settings/bank', [SettingsController::class, 'updateBankDetails'])->name('settings.bank');
    Route::put('/settings/password', [SettingsController::class, 'updatePassword'])->name('settings.password');
    
    // Contact Support
    Route::get('/contact', [ContactController::class, 'index'])->name('contact');
    Route::post('/contact', [ContactController::class, 'send'])->name('contact.send');

    // Tickets Management
    Route::get('/tickets', [TicketController::class, 'index'])->name('tickets.index');
    Route::get('/events/{event}/tickets/create', [TicketController::class, 'create'])->name('tickets.create');
    Route::post('/events/{event}/tickets', [TicketController::class, 'store'])->name('tickets.store');
    Route::get('/tickets/{ticket}/edit', [TicketController::class, 'edit'])->name('tickets.edit');
    Route::put('/tickets/{ticket}', [TicketController::class, 'update'])->name('tickets.update');
    Route::delete('/tickets/{ticket}', [TicketController::class, 'destroy'])->name('tickets.destroy');
    Route::get('/tickets/orders', [TicketController::class, 'orders'])->name('tickets.orders');
    Route::get('/tickets/scan', [TicketController::class, 'scan'])->name('tickets.scan');
    Route::post('/tickets/validate', [TicketController::class, 'validateTicket'])->name('tickets.validate');
});