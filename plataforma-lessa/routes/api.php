<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\FolioController;
use App\Http\Controllers\API\MuestrasController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

// Route::prefix('folios')->group(function(){
//    Route::get('/', [FolioController::class, 'get']);
// });


Route::get('/folios', [FolioController::class, 'getFoliosByClientAndDate']);

Route::get('/muestras', [MuestrasController::class, 'getMuestrasByFolio']);





