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
            $table->string('carnet');
            $table->string('email')->unique();
            $table->string('password');
            $table->foreignId('id_persona')
                ->constrained('personas')
                ->onUpdate('cascade')
                ->onDelete('restrict');
            $table->boolean('activo')->default(true);
            $table->rememberToken();
            $table->timestamp('email_verified_at')->nullable();
            $table->timestamps();
            $table->foreignId('id_escuela')
                ->nullable()
                ->constrained('escuelas')
                ->onDelete('set null');
                $table->integer('es_estudiante')->default(1);  // 1 es estudiante, 0 otro tipo de usuario
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
