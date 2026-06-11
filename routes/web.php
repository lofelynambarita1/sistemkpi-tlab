<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\KpiController;
use App\Http\Controllers\HrManagerKpiController;
use Illuminate\Support\Facades\Route;

// ─────────────── AUTH ───────────────
Route::get('/', [AuthController::class, 'showLogin'])->name('login');
Route::get('/login', [AuthController::class, 'showLogin']);
Route::post('/login', [AuthController::class, 'login'])->name('login.post');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthController::class, 'register'])->name('register.post');

// ─────────────── AUTHENTICATED ───────────────
Route::middleware(['auth'])->group(function () {

    // Dashboard (semua role)
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // ─── STAFF KPI ───────────────────────────────────────────────────────────
    Route::middleware(['staff.only'])->prefix('kpi')->name('kpi.')->group(function () {
        Route::get('/',                    [KpiController::class, 'index'])->name('index');
        Route::get('/create',              [KpiController::class, 'create'])->name('create');
        Route::post('/',                   [KpiController::class, 'store'])->name('store');
        Route::get('/{kpiDocument}',       [KpiController::class, 'show'])->name('show');
        Route::get('/{kpiDocument}/edit',  [KpiController::class, 'edit'])->name('edit');
        Route::put('/{kpiDocument}',       [KpiController::class, 'update'])->name('update');
    });

    // ─── HR & MANAGER ────────────────────────────────────────────────────────
    Route::middleware(['hr.manager.only'])->prefix('hr/kpi')->name('hr.kpi.')->group(function () {
        Route::get('/',                   [HrManagerKpiController::class, 'index'])->name('index');
        Route::get('/{kpiDocument}',      [HrManagerKpiController::class, 'show'])->name('show');
        Route::get('/{kpiDocument}/edit', [HrManagerKpiController::class, 'edit'])->name('edit');
        Route::put('/{kpiDocument}',      [HrManagerKpiController::class, 'update'])->name('update');
        Route::delete('/{kpiDocument}',   [HrManagerKpiController::class, 'destroy'])->name('destroy');

        Route::put('/{kpiDocument}/jobdesc/{jobdesc}',
            [HrManagerKpiController::class, 'updateJobdesc'])->name('update.jobdesc');
        Route::put('/{kpiDocument}/ci/{ci}',
            [HrManagerKpiController::class, 'updateCI'])->name('update.ci');
        Route::put('/{kpiDocument}/sd/{sd}',
            [HrManagerKpiController::class, 'updateSD'])->name('update.sd');
        Route::put('/{kpiDocument}/hr-activity/{hrActivity}',
            [HrManagerKpiController::class, 'updateHRActivity'])->name('update.hr_activity');
        Route::put('/{kpiDocument}/perilaku/{perilaku}',
            [HrManagerKpiController::class, 'updatePerilaku'])->name('update.perilaku');
    });
});