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
        Schema::create('reportes', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_aula')->nullable();
            $table->unsignedBigInteger('id_actividad')->nullable();
            $table->unsignedBigInteger('id_usuario_reporta');
            $table->text('descripcion');
            $table->string('titulo', 50);
            $table->date('fecha_reporte');
            $table->time('hora_reporte');
            $table->boolean('no_procede')->default(false);
            $table->boolean('activo')->default(true);
            $table->timestamps();

            $table->foreign('id_aula')->references('id')->on('aulas')->onDelete('restrict');
            $table->foreign('id_actividad')->references('id')->on('actividades')->onDelete('restrict');
            $table->foreign('id_usuario_reporta')->references('id')->on('users')->onDelete('restrict');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reportes');
    }
};
