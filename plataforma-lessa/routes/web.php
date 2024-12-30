<?php

use App\Http\Controllers\API\FolioController;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\FrontController;
use App\Http\Controllers\API\FileController;
use App\Http\Controllers\API\FolioeController;

Route::get('/', function () {
    return response()->file(public_path('index.html'));
});


Route::get('login', [AuthController::class, 'login'])->name('login');
Route::post('login', [AuthController::class, 'loginPost']);
Route::get('logout', [AuthController::class, 'logout']);

Route::get('/analisis-de-agua', function () {
    return inertia('AnalisisDeAgua'); // Aquí el nombre debe coincidir con el archivo .vue sin la extensión.
});

Route::get('/folioe-info', function(){
    return Inertia::render('obtenerFolioeInfo', [
        'user' => \Illuminate\Support\Facades\Auth::user(),
    ]);
})->name('folioe.info')->middleware('auth');

Route::get('/consulta-informes', function () {
    return Inertia::render('ConsultaInformes', [
        'user' => \Illuminate\Support\Facades\Auth::user(), // Aquí se pasa el usuario autenticado
    ]);
})->name('consulta.informes')->middleware('auth');

Route::get('/consulta-informese', function () {
    return Inertia::render('ConsultaInformese', [
        'user' => \Illuminate\Support\Facades\Auth::user(), // Aquí se pasa el usuario autenticado
    ]);
})->name('consulta.informese')->middleware('auth');


Route::get('/consulta-muestras', function () {
    return Inertia::render('ConsultaMuestras', [
        'user' => \Illuminate\Support\Facades\Auth::user(), // Aquí se pasa el usuario autenticado
    ]);
})->name('consulta.muestras')->middleware('auth');

Route::get('/folio-info', function(){
return Inertia::render('obtenerFolioInfo', [
    'user' => \Illuminate\Support\Facades\Auth::user(), // Aquí se pasa el usuario autenticado
]);
})->name('folio.info')->middleware('auth');



Route::middleware('auth')->group(function () {
    Route::get('inicio', function () {
        return 'Inicio';
    });
});

Route::get('inicio', [FrontController::class, 'inicio'])->middleware('auth');


Route::get('/consulta-muestrase', function () {
    return Inertia::render('ConsultaMuestrase', [
        'user' => \Illuminate\Support\Facades\Auth::user(), // Aquí se pasa el usuario autenticado
    ]);
})->name('consulta.muestrase')->middleware('auth');

Route::middleware('auth:sanctum')->get('/file-url/{cliente}/{filename}', [FileController::class, 'getTemporaryUrl']);



