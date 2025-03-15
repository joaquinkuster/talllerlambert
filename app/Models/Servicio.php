<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Servicio extends Model
{
    use HasFactory, SoftDeletes;

    // Especificamos los campos que se pueden asignar masivamente
    protected $fillable = [
        'nombre',
        'descripcion',
        'costo',
        'duracion'
    ];

     // Relación muchos a muchos con Turno
     public function turnos()
     {
         return $this->belongsToMany(Turno::class, 'servicio_turno');
     }

    // Método para representar el objeto como string
    public function __toString()
    {
        return sprintf("%s - $%s - %d min", $this->nombre, number_format($this->costo, 2, ',', '.'), $this->duracion);
    }
}
