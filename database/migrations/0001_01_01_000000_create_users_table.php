<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id(); 
            $table->string('nombre', 50); 
            $table->string('apellido', 50); 
            $table->string('dni', 8)->unique(); 
            $table->string('telefono')->nullable(); // teléfono (opcional)
            $table->enum('rol', ['Cliente', 'Administrador'])->default('Cliente'); 
            $table->string('correo', 150)->unique(); 
            $table->string('password', 255); 
            //$table->timestamp('fecha_de_registro')->useCurrent(); 
            $table->rememberToken(); // token para "recordar sesión"
            $table->softDeletes(); // deleted_at para borrado lógico
            $table->timestamps(); // created_at y updated_at
        });

        Schema::create('password_reset_tokens', function (Blueprint $table) {
            $table->string('correo')->primary();
            $table->string('token');
            $table->timestamp('created_at')->nullable();
        });

        Schema::create('sessions', function (Blueprint $table) {
            $table->string('id')->primary();
            $table->foreignId('user_id')->nullable()->index();
            $table->string('ip_address', 45)->nullable();
            $table->text('user_agent')->nullable();
            $table->longText('payload');
            $table->integer('last_activity')->index();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
        Schema::dropIfExists('password_reset_tokens');
        Schema::dropIfExists('sessions');
    }
};