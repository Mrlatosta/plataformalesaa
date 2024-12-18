<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use Illuminate\Http\Request;

class FrontController extends Controller
{
    public function inicio()
    {   
        $user = \Illuminate\Support\Facades\Auth::user();
        return Inertia::render('Inicio',[
            'user' => $user,
            //'user'=>\Illuminate\Support\Facades\Auth::user()
        ]);
    }
}
