<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\FolioM;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;


class FolioController extends Controller
{
    public function get(){
        try{
            $folio = FolioM::all();
            return response()->json($folio, 200);
        }
        catch(\Throwable $th){
            return response()->json(['message' => 'Error al obtener los folios causado por: ', $th], 500);
        }
    }

    public function getFoliosByClientAndDate(Request $request)
    {
        $validated = $request->validate([
            'fecha_inicio' => 'required|date',
            'fecha_fin' => 'required|date|after_or_equal:fecha_inicio',
        ]);

        try {
            $folios = DB::table('folios_muestreos')
                ->whereBetween('fecha', [$validated['fecha_inicio'], $validated['fecha_fin']])
                ->get();

            return response()->json([
                'success' => true,
                'data' => $folios,
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al recuperar los folios.',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

}


