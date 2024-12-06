<?php

use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/inicio', function () {
    return Inertia::render('Inicio', [
        'nombre' => 'Luis Eduardo Sánchez Sánchez',
    ]);
});

Route::get('/contacto', function () {
    return Inertia::render('Contacto');
});
