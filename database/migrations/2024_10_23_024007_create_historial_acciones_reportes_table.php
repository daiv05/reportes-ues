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
        Schema::create('historial_acciones_reportes', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_acciones_reporte');
            $table->unsignedBigInteger('id_empleado_puesto');
            $table->unsignedBigInteger('id_estado');
            $table->text('foto_evidencia')->nullable();
            $table->text('comentario')->nullable();
            $table->date('fecha_actualizacion');
            $table->time('hora_actualizacion');
            $table->timestamps();

            $table->foreign('id_acciones_reporte')->references('id')->on('acciones_reportes')->onDelete('restrict');
            $table->foreign('id_empleado_puesto')->references('id')->on('empleados_puestos')->onDelete('restrict');
            $table->foreign('id_estado')->references('id')->on('estados')->onDelete('restrict');
        
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('historial_acciones_reportes');
    }
};
