<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\MuestrasE;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class MuestraseController extends Controller
{

    public function get(){
        try {
             $muestrase= MuestrasE::all();
             return response()->json($muestrase, 200);
            }
             catch(\Throwable $th){
             return response()->json(['message' => 'Error al obtener las muestras causado por: ', $th], 500);
         }
      }

      public function getMuestraseByFolio(Request $request)
      {
          $validated = $request->validate([
              'email' => 'required',
              'folio' => 'required',
          ]);
  
          try {

            
            $muestrase = DB::table('muestras_extra')
            ->select(
                'registro_muestra',
                'fecha_muestreo',
                'nombre_muestra',
                'cantidad_aprox',
                'temperatura',
                'lugar_toma',
                'descripcion_toma',
                'observaciones',
                'muestras_extra.estatus'
            )
            ->leftJoin('folios_extra', 'muestras_extra.folio_muestreo', '=', 'folios_extra.folio')
            ->where('folios_extra.folio_cliente', $validated['email'])
            ->where('muestras_extra.folio_muestreo', $validated['folio']) #folio
            ->get();


              return response()->json([
                  'success' => true,
                  'data' => $muestrase,
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
