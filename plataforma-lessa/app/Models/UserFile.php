<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory; // Agregar esta línea
use Illuminate\Database\Eloquent\Model;

class UserFile extends Model
{
    use HasFactory;

    // Define la tabla asociada, si no sigue la convención plural de Laravel.
    protected $table = 'user_files'; // Si tu tabla tiene un nombre diferente

    // Asegúrate de definir los campos que se pueden llenar (fillable) para evitar problemas de asignación masiva.
    protected $fillable = [
        'filename',
        'user_id', // Asumiendo que hay una relación con el usuario
    ];

    // Definir la relación inversa con el modelo User (si el archivo pertenece a un usuario).
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
