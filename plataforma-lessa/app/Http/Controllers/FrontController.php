<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use Illuminate\Http\Request;

class FrontController extends Controller
{
    function inicio()
    {
        return Inertia::render('Inicio',[
            'user'=>\Illuminate\Support\Facades\Auth::user()
        ]);
    }
}
