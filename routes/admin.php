<?php

use App\Http\Controllers\Admin\AdminDashboardController;
use App\Http\Controllers\Admin\AdminUserController;
use App\Http\Controllers\Admin\AdminEventController;
use App\Http\Controllers\Admin\AdminWithdrawalController;
use App\Http\Controllers\Admin\AdminTransactionController;
use App\Http\Controllers\Admin\AdminTicketController;
use App\Http\Controllers\Admin\AdminSettingController;
use App\Http\Controllers\Admin\AdminReportController;
use App\Http\Controllers\Admin\AdminAuditController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Admin Routes
|--------------------------------------------------------------------------
|
| These routes are loaded by the RouteServiceProvider and are assigned
| the "admin" middleware group. All routes here require admin access.
|
*/

Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    
    // Dashboard
    Route::get('/', [AdminDashboardController::class, 'index'])->name('dashboard');
    Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard.index');
    
    // Users (Organizers) Management
    Route::prefix('users')->name('users.')->group(function () {
        Route::get('/', [AdminUserController::class, 'index'])->name('index');
        Route::get('/{user}', [AdminUserController::class, 'show'])->name('show');
        Route::post('/{user}/suspend', [AdminUserController::class, 'suspend'])->name('suspend');
        Route::post('/{user}/activate', [AdminUserController::class, 'activate'])->name('activate');
        Route::post('/{user}/note', [AdminUserController::class, 'updateNote'])->name('note');
        Route::delete('/{user}', [AdminUserController::class, 'destroy'])->name('destroy');
    });
    
    // Events Management
    Route::prefix('events')->name('events.')->group(function () {
        Route::get('/', [AdminEventController::class, 'index'])->name('index');
        Route::get('/{event}', [AdminEventController::class, 'show'])->name('show');
        Route::post('/{event}/suspend', [AdminEventController::class, 'suspend'])->name('suspend');
        Route::post('/{event}/activate', [AdminEventController::class, 'activate'])->name('activate');
        Route::post('/{event}/feature', [AdminEventController::class, 'toggleFeatured'])->name('feature');
        Route::delete('/{event}', [AdminEventController::class, 'destroy'])->name('destroy');
    });
    
    // Withdrawals Management
    Route::prefix('withdrawals')->name('withdrawals.')->group(function () {
        Route::get('/', [AdminWithdrawalController::class, 'index'])->name('index');
        Route::get('/{withdrawal}', [AdminWithdrawalController::class, 'show'])->name('show');
        Route::post('/{withdrawal}/approve', [AdminWithdrawalController::class, 'approve'])->name('approve');
        Route::post('/{withdrawal}/reject', [AdminWithdrawalController::class, 'reject'])->name('reject');
        Route::post('/{withdrawal}/mark-completed', [AdminWithdrawalController::class, 'markCompleted'])->name('complete');
    });
    
    // Transactions
    Route::prefix('transactions')->name('transactions.')->group(function () {
        Route::get('/', [AdminTransactionController::class, 'index'])->name('index');
        Route::get('/{transaction}', [AdminTransactionController::class, 'show'])->name('show');
        Route::get('/export/csv', [AdminTransactionController::class, 'export'])->name('export');
    });
    
    // Tickets
    Route::prefix('tickets')->name('tickets.')->group(function () {
        Route::get('/', [AdminTicketController::class, 'index'])->name('index');
        Route::get('/{ticket}', [AdminTicketController::class, 'show'])->name('show');
    });
    
    // Reports & Flagged Content
    Route::prefix('reports')->name('reports.')->group(function () {
        Route::get('/', [AdminReportController::class, 'index'])->name('index');
        Route::get('/{report}', [AdminReportController::class, 'show'])->name('show');
        Route::post('/{report}/resolve', [AdminReportController::class, 'resolve'])->name('resolve');
        Route::post('/{report}/dismiss', [AdminReportController::class, 'dismiss'])->name('dismiss');
    });
    
    // Settings
    Route::prefix('settings')->name('settings.')->group(function () {
        Route::get('/', [AdminSettingController::class, 'index'])->name('index');
        Route::put('/', [AdminSettingController::class, 'update'])->name('update');
        Route::post('/clear-cache', [AdminSettingController::class, 'clearCache'])->name('clear-cache');
        Route::post('/maintenance', [AdminSettingController::class, 'toggleMaintenance'])->name('maintenance');
    });
    
    // Audit Logs
    Route::get('/audit-logs', [AdminAuditController::class, 'index'])->name('audit-logs');
    Route::get('/audit-logs/{log}', [AdminAuditController::class, 'show'])->name('audit-logs.show');
    Route::get('/audit-logs/export/csv', [AdminAuditController::class, 'export'])->name('audit-logs.export');
    
    // API endpoints for charts/data
    Route::prefix('api')->name('api.')->group(function () {
        Route::get('/stats', [AdminDashboardController::class, 'getStats'])->name('stats');
        Route::get('/revenue-chart', [AdminDashboardController::class, 'getRevenueChart'])->name('revenue-chart');
        Route::get('/votes-chart', [AdminDashboardController::class, 'getVotesChart'])->name('votes-chart');
        Route::get('/recent-activity', [AdminDashboardController::class, 'getRecentActivity'])->name('recent-activity');
    });
});
