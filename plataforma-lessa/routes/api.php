<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\FolioController;
use App\Http\Controllers\API\MuestrasController;
use App\Http\Controllers\API\FolioeController;
use App\Http\Controllers\API\MuestraseController;
use App\Http\Controllers\API\FileController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

// Route::prefix('folios')->group(function(){
//    Route::get('/', [FolioController::class, 'get']);
// });


Route::get('/folios', [FolioController::class, 'getFoliosByClientAndDate']);

Route::get('/muestras', [MuestrasController::class, 'getMuestrasByFolio']);

Route::get('/folio-info', [FolioController::class, 'obtenerFolioInfo']);

Route::get('/foliose', [FolioeController::class, 'getFolioseByClientAndDate']);

Route::get('/folioe-info', [FolioeController::class, 'obtenerFolioeInfo']);

Route::get('/muestrase', [MuestraseController::class, 'getMuestraseByFolio']);

Route::get('/api/folioe-info', [FolioeController::class, 'obtenerFolioeInfo'])->name('folioe-info');

Route::middleware('auth:sanctum')->get('/file-url/{cliente}/{filename}', [FileController::class, 'getTemporaryUrl']);

Route::middleware('auth:sanctum')->get('/file-download/{filename}', [FileController::class, 'downloadFile']);


