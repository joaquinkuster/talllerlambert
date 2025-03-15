<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Turno extends Model
{
    use HasFactory;

    // Especificamos los campos que se pueden asignar masivamente
    protected $fillable = [
        'fechaHora',
        'estado',
        'user_id',
        'vehiculo_id'
    ];

    protected $casts = [
        'fechaHora' => 'datetime:Y-m-d H:i',
    ];

    // Relación muchos a muchos con Servicio
    public function servicios()
    {
        return $this->belongsToMany(Servicio::class, 'servicio_turno');
    }

    // Relación muchos a uno con Usuario
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Relación muchos a uno con Vehiculo
    public function vehiculo()
    {
        return $this->belongsTo(Vehiculo::class);
    }
}
