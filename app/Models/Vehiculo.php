<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Vehiculo extends Model
{
    use HasFactory, SoftDeletes;

    // Especificamos los campos que se pueden asignar masivamente
    protected $fillable = [
        'marca',
        'modelo',
        'patente',
        'anio',
        'tipo',
        'user_id'
    ];

    // Relación muchos a uno con Usuario
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Relación uno a muchos con Turno
    public function turnos()
    {
        return $this->hasMany(Turno::class);
    }

    // Método para representar el objeto como string
    public function __toString()
    {
        return sprintf("%s - %s %d %s", $this->marca, $this->modelo, $this->anio, $this->patente);
    }
}
