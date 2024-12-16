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
            'email' => 'required',
            'fecha_inicio' => 'required|date',
            'fecha_fin' => 'required|date|after_or_equal:fecha_inicio',
        ]);

        try {
            $folios = DB::table('folios_muestreos')
                #email
                ->where('folio_cliente', $validated['email']) 
                #fecha_inicio
                ->where('fecha', '>=', $validated['fecha_inicio'])
                #fecha_fin
                ->where('fecha', '<=', $validated['fecha_fin'])
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

    public function obtenerFolioInfo(Request $request)
      {

        $validated = $request->validate([
            'email' => 'required',
            'folio' => 'required',
        ]);

        try {
            $folios = DB::table('folios_muestreos')

            ->select( 
                'fecha',	        
                'nombre_autoriza_muestras',
                'puesto_autoriza_muestra',
                'nombre_tomador_muestra',
                'puesto_tomador_muestra',
                'estatus'
            )

                #email
                ->where('folio_cliente', $validated['email']) 
                #folio
                ->where('folio', $validated['folio'])
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


