<?php

use App\Http\Controllers\API\FolioController;
use Illuminate\Support\Facades\Route;

Route::prefix('folios')->group(function () {
    Route::get('/', [FolioController::class, 'get']);
});
