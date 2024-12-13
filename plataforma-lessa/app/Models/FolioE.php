<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FolioE extends Model
{
    use HasFactory;

    // Define el nombre de la tabla si no sigue la convención de Laravel
    protected $table = 'folios_extra';

    // Define la clave primaria
    protected $primaryKey = 'folio';

    // Indica que la clave primaria no es un entero autoincremental
    public $incrementing = false;

    // Define el tipo de la clave primaria
    protected $keyType = 'string';

    // Indica que no usas las columnas created_at y updated_at
    public $timestamps = false;

    // Lista de columnas que se pueden asignar en masa
    protected $fillable = [
        'folio',
        'fecha',
        'folio_cliente',
        'estatus',
        'nombre_autoriza_muestras',
        'puesto_autoriza_muestra',
        'nombre_tomador_muestra',
        'puesto_tomador_muestra',
    ];

    
}