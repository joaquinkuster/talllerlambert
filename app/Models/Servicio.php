<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Servicio extends Model
{
    use HasFactory, SoftDeletes;

    // Especificamos los campos que se pueden asignar masivamente
    protected $fillable = ['nombre', 'descripcion', 'costo', 'duracion'];

    // Cambiamos los nombres de las columnas de fecha y hora por defecto
    const CREATED_AT = 'fecha_creacion';
    const UPDATED_AT = 'fecha_actualizacion';
}
