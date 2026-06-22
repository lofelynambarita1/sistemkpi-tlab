<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\HrManagerKpiController;
use App\Http\Controllers\KpiController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ReviewKpiController;
use Illuminate\Support\Facades\Route;

// ─────────────── AUTH ───────────────
Route::get('/',             [AuthController::class, 'showLogin'])->name('login');
Route::get('/login',        [AuthController::class, 'showLogin']);
Route::post('/login',       [AuthController::class, 'login'])->name('login.post');
Route::post('/logout',      [AuthController::class, 'logout'])->name('logout');

Route::get('/register',     [AuthController::class, 'showRegister'])->name('register');
Route::post('/register',    [AuthController::class, 'register'])->name('register.post');

// ─────────────── AUTHENTICATED ───────────────
Route::middleware(['auth'])->group(function () {

    // Dashboard (semua role)
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Profile
    Route::get('/profile',        [ProfileController::class, 'show'])->name('profile.show');
    Route::put('/profile',        [ProfileController::class, 'update'])->name('profile.update');

    // ─── ADMIN ────────────────────────────────────────────────────────────────
    // Admin functionality now handled by Filament panel at /admin
    // Kept for backward compatibility — redirects to Filament
    Route::middleware(['admin.only'])->prefix('admin')->name('admin.')->group(function () {
        Route::get('/dashboard', function () {
            return redirect('/admin');
        })->name('dashboard');
        Route::get('/users', function () {
            return redirect('/admin/users');
        })->name('users.index');
        Route::get('/profile',            [AdminController::class, 'profile'])->name('profile');
        Route::put('/profile',            [AdminController::class, 'updateProfile'])->name('profile.update');
    });

    // ─── REVIEW KPI (Lead / Lead HR / Manager) ───────────────────────────────
    Route::prefix('review')->name('review.')->group(function () {
        Route::get('/',                  [ReviewKpiController::class, 'index'])->name('index');
        Route::get('/export',            [ReviewKpiController::class, 'export'])->name('export');
        Route::post('/bulk-approve',     [ReviewKpiController::class, 'bulkApprove'])->name('bulk-approve');
        Route::post('/bulk-reject',      [ReviewKpiController::class, 'bulkReject'])->name('bulk-reject');
        Route::get('/{kpiForm}',         [ReviewKpiController::class, 'show'])->name('show');
        Route::post('/{kpiForm}/approve', [ReviewKpiController::class, 'approve'])->name('approve');
        Route::post('/{kpiForm}/reject',  [ReviewKpiController::class, 'reject'])->name('reject');
    });

    // ─── ROLE-SPECIFIC ROUTE ALIASES (for sidebar) ──────────────────────────
    // Manager
    Route::get('/manager/dashboard',        [DashboardController::class, 'index'])->name('manager.dashboard');
    Route::get('/manager/review',           [ReviewKpiController::class, 'index'])->name('manager.review.index');
    Route::get('/manager/profile',          [ProfileController::class, 'show'])->name('manager.profile');

    // Lead HR
    Route::get('/leadhr/dashboard',         [DashboardController::class, 'index'])->name('leadhr.dashboard');
    Route::get('/leadhr/kpi',               [KpiController::class, 'index'])->name('leadhr.kpi.index');
    Route::get('/leadhr/review',            [ReviewKpiController::class, 'index'])->name('leadhr.review.index');
    Route::get('/leadhr/profile',           [ProfileController::class, 'show'])->name('leadhr.profile');

    // Lead
    Route::get('/lead/dashboard',           [DashboardController::class, 'index'])->name('lead.dashboard');
    Route::get('/lead/kpi',                 [KpiController::class, 'index'])->name('lead.kpi.index');
    Route::get('/lead/review',              [ReviewKpiController::class, 'index'])->name('lead.review.index');
    Route::get('/lead/profile',             [ProfileController::class, 'show'])->name('lead.profile');

    // Principle
    Route::get('/principle/dashboard',      [DashboardController::class, 'index'])->name('principle.dashboard');
    Route::get('/principle/kpi',            [KpiController::class, 'index'])->name('principle.kpi.index');
    Route::get('/principle/profile',        [ProfileController::class, 'show'])->name('principle.profile');

    // Employee (associate / intermediate / senior)
    Route::get('/employee/dashboard',       [DashboardController::class, 'index'])->name('employee.dashboard');
    Route::get('/employee/kpi',             [KpiController::class, 'index'])->name('employee.kpi.index');
    Route::get('/employee/profile',         [ProfileController::class, 'show'])->name('employee.profile');

    // ─── PANDUAN ─────────────────────────────────────────────────────────────
    Route::get('/panduan', function () {
        return view('panduan');
    })->name('panduan');

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
        Route::get('/',                             [HrManagerKpiController::class, 'index'])->name('index');
        Route::get('/{kpiDocument}',                [HrManagerKpiController::class, 'show'])->name('show');
        Route::get('/{kpiDocument}/edit',           [HrManagerKpiController::class, 'edit'])->name('edit');
        Route::put('/{kpiDocument}',                [HrManagerKpiController::class, 'update'])->name('update');
        Route::delete('/{kpiDocument}',             [HrManagerKpiController::class, 'destroy'])->name('destroy');

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
