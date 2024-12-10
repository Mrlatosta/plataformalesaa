<?php

use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\FrontController;

Route::get('login', [AuthController::class, 'login'])->name('login');
Route::post('login', [AuthController::class, 'loginPost']);
Route::get('logout', [AuthController::class, 'logout']);

Route::middleware('auth')->group(function () {
    Route::get('inicio', function () {
        return 'Inicio';
    });
});

Route::get('inicio',[FrontController::class,'inicio'])->middleware('auth');
