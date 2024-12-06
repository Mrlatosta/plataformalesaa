<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\FolioM;

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
}
