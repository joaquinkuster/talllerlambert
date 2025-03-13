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

    // Relación con usuario
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Método para representar el objeto como string
    public function __toString()
    {
        return substr(sprintf("%s - %s %d %s", $this->marca, $this->modelo, $this->anio, $this->patente), 0, 15);
    }
}
