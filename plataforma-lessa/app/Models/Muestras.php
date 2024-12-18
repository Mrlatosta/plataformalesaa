<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Muestras extends Model
{
    use HasFactory;

    // Define el nombre de la tabla si no sigue la convención de Laravel
    protected $table = 'muestras';

    // Define la clave primaria
    protected $primaryKey = 'registro_muestra';

    // Indica que la clave primaria no es un entero autoincremental
    public $incrementing = false;

    // Define el tipo de la clave primaria
    protected $keyType = 'string';

    // Indica que no usas las columnas created_at y updated_at
    public $timestamps = false;

    // Lista de columnas que se pueden asignar en masa
    protected $fillable = [
        'registro_muestra',
        'fecha_muestreo',
        'nombre_muestra',
        'cantidad_aprox',
        'temperatura',
        'lugar_toma',
        'descripcion_toma',
        'observaciones',
        'estatus',
    ];
}
