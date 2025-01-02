<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\FolioE;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class FolioeController extends Controller
{
    public function get()
    {
        try {
            $folioe = FolioE::all();
            return response()->json($folioe, 200);
        } catch (\Throwable $th) {
            return response()->json(['message' => 'Error al obtener los folios causado por: ' . $th->getMessage()], 500);
        }
    }

    public function getFolioseByClientAndDate(Request $request)
    {
        $validated = $request->validate([
            'email' => 'required',
            'fecha_inicio' => 'required|date',
            'fecha_fin' => 'required|date|after_or_equal:fecha_inicio',
        ]);

        try {
            $foliose = DB::table('folios_extra')
                ->where('folio_cliente', $validated['email'])
                ->where('fecha', '>=', $validated['fecha_inicio'])
                ->where('fecha', '<=', $validated['fecha_fin'])
                ->get();

            return response()->json([
                'success' => true,
                'data' => $foliose,
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al recuperar los folios.',
                'error' => $e->getMessage(),
            ], 500);
        }
    }


    public function getFolioseByFolioe(Request $request)
    {
        $validated = $request->validate([
            'email' => 'required',
            'folio' => 'required',
        ]);

        try {
            $foliose = DB::table('folios_extra')
                ->select(
                    'folio',
                    'fecha',
                    'estatus'
                )
                ->where('folio_cliente', $validated['email'])
                ->where('folio', $validated['folio'])
                ->get();

            return response()->json([
                'success' => true,
                'data' => $foliose,
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al recuperar los folios.',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    public function obtenerFolioeInfo(Request $request)
    {
        $validated = $request->validate([
            'email' => 'required',
            'folio' => 'required',
        ]);

        try {
            $folioe = DB::table('folios_extra')
                ->select(
                    'fecha',
                    'nombre_autoriza_muestras',
                    'puesto_autoriza_muestra',
                    'nombre_tomador_muestra',
                    'puesto_tomador_muestra',
                    'estatus'
                )
                ->where('folio_cliente', $validated['email'])
                ->where('folio', $validated['folio'])
                ->first();

            return response()->json([
                'success' => true,
                'data' => $folioe,
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al recuperar la información del folio.',
                'error' => $e->getMessage(),
            ], 500);
        }
    }
}
