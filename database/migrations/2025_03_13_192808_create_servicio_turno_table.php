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
        Schema::create('servicio_turno', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('servicio_id');
            $table->unsignedBigInteger('turno_id');
            $table->foreign('servicio_id')->references('id')->on('servicios')->onDelete('cascade'); // Clave foránea para servicios
            $table->foreign('turno_id')->references('id')->on('turnos')->onDelete('cascade'); // Clave foránea para turnos
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('servicio_turno');
    }
};
