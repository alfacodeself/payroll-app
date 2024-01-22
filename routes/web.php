<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Company\{WelcomeController, AuthController, DashboardController, DepartementController, JobController};

// Route Company
Route::prefix('companies/{company}')->as('company.')->group(function () {
    Route::get('/', WelcomeController::class)->name('welcome');
    Route::get('dashboard', DashboardController::class)->name('dashboard');
    Route::resource('departements', DepartementController::class);
    Route::resource('jobs', JobController::class);
    Route::prefix('auth')->as('auth.')->group(function () {
        Route::get('login', [AuthController::class, 'login'])->name('login');
        Route::post('login', [AuthController::class, 'authenticate']);
        Route::post('logout', [AuthController::class, 'logout'])->name('logout');
    });
});
