<?php

// routes/api.php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\EmployeeKpiController;
use App\Http\Controllers\ManagerKpiController;
use App\Http\Controllers\AdminUserController;

Route::middleware('auth:sanctum')->group(function () {
    
    Route::middleware('role:admin')->prefix('admin')->group(function () {
        Route::get('/dashboard/stats', [AdminUserController::class, 'dashboardStats']);
        Route::post('/users/bulk-delete', [AdminUserController::class, 'bulkDelete']);
        Route::put('/profile', [AdminUserController::class, 'updateProfile']);
    });

    
    Route::middleware('role:manager')->prefix('manager')->group(function () {
        Route::get('/kpis/pending', [ManagerKpiController::class, 'indexPending']);
        Route::post('/kpis/bulk-action', [ManagerKpiController::class, 'bulkAction']);
        Route::get('/history', [ManagerKpiController::class, 'history']);
        Route::put('/profile', [AdminUserController::class, 'updateProfile']);
    });

    Route::middleware('role:associate,intermediate,senior,lead,principle')->prefix('employee')->group(function () {
        Route::post('/kpi', [EmployeeKpiController::class, 'store']);
        Route::get('/history', [EmployeeKpiController::class, 'history']);
        Route::put('/profile', [AdminUserController::class, 'updateProfile']);
    });
});