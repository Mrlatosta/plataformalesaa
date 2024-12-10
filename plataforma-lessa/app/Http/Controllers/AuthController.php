<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Validation\ValidationException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;


class AuthController extends Controller
{
    function login()
    {
        return Inertia::render('login');
    }
    function LoginPost(Request $request){
        $credentials = $request->validate([
            'email' => 'required', // Asegúrate de que el correo tenga un formato válido
            'password' => 'required',
        ]);
        

        if (Auth::attempt($credentials)) {
          
            return response()->json(['message' => 'Login efectuado con éxito'], 200);
        }

        throw ValidationException::withMessages([
            'email' => ['Las credenciales proporcionadas no coinciden con nuestros registros.'],
        ]);
    
    return response()->json(['message' => 'Credenciales incorrectas'], 401);
    }

    function logout()
    {
        Auth::logout();
        return redirect('login');
        
    }
}