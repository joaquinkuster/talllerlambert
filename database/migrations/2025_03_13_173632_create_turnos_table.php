<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('turnos', function (Blueprint $table) {
            $table->id();
            $table->datetime('fechaHora'); // Fecha y hora del turno (por ejemplo, 2023-10-25 08:00)
            $table->enum('estado', ['Pendiente', 'Finalizado', 'Cancelado'])->default('Pendiente');
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade'); // Clave foránea para usuarios
            $table->foreignId('vehiculo_id')->constrained('vehiculos')->onDelete('cascade'); // Clave foránea para vehiculos
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('turnos');
    }
};
