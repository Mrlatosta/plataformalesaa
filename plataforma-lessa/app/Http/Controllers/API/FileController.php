<?php
namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Models\User;
use Illuminate\Support\Facades\Log;


class FileController extends Controller
{
    // Obtener URL temporal de un archivo
    public function getTemporaryUrl($cliente,$filename)
    {

        $filename = 'Informe-' . rtrim($cliente,'-') . '-' . $filename . '.pdf';

            Log::info("Cliente solicitado: " . $cliente);
            Log::info("Archivo solicitado: " . $filename);

            $user = auth()->user();

            if (!$user->files()->where('filename', $filename)->exists()) {
                return response()->json(['message' => 'No tienes acceso a este archivo.'], 403);
            }
            
            $filePath = 'bucketinformes/' . rtrim($cliente,'/') . '/'  . $filename;
            


            $url = Storage::disk('spaces')->temporaryUrl(
                $filePath,
                // 'Informe-Wyndham Garden Cancún Downtown [Calidad]-FCLHTL-LAB-025--Lesaa.pdf',
                now()->addMinutes(5)
            );

            Log::info("URL temporal generada: " . $url);

            return response()->json([
                'data' => [
                    'file_name' => $filename,
                    'url' => $url,
                ]
            ]);
            
        }

    // Registrar archivo para un usuario
    public function store(Request $request)
    {
        // Validar los datos de entrada
        $request->validate([
            'email' => 'required|exists:users,email', // Cambiar de username a email
            'filename' => 'required|string',
        ]);

        // Buscar al usuario por su email
        $user = User::where('email', $request->email)->first();

        if (!$user) {
            return response()->json(['message' => 'Usuario no encontrado.'], 404);
        }

        // Crear archivo asociado al usuario
        $user->files()->create([
            'filename' => $request->filename,
        ]);

        return response()->json(['message' => 'Archivo registrado correctamente.']);
    }
}
