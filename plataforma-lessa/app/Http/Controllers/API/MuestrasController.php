<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Muestras;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class MuestrasController extends Controller
{

    public function get(){
        try {
             $muestras= Muestras::all();
             return response()->json($muestras, 200);
            }
             catch(\Throwable $th){
             return response()->json(['message' => 'Error al obtener las muestras causado por: ', $th], 500);
         }
      }

      public function getMuestrasByFolio(Request $request)
      {
          $validated = $request->validate([
              'email' => 'required',
              'folio' => 'required',
          ]);
  
          try {

            
            $muestras = DB::table('muestras')
            ->select(
                'registro_muestra',
                'fecha_muestreo',
                'nombre_muestra',
                'cantidad_aprox',
                'temperatura',
                'lugar_toma',
                'descripcion_toma',
                'observaciones',
                'muestras.estatus'
            )
            ->leftJoin('folios_muestreos', 'muestras.folio_muestreo', '=', 'folios_muestreos.folio')
            ->where('folios_muestreos.folio_cliente', $validated['email'])
            ->where('muestras.folio_muestreo', $validated['folio']) #folio
            ->get();


              return response()->json([
                  'success' => true,
                  'data' => $muestras,
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
