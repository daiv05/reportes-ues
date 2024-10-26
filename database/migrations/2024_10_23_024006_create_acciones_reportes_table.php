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
        Schema::create('acciones_reportes', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_reporte');
            $table->unsignedBigInteger('id_usuario_administracion');
            $table->unsignedBigInteger('id_entidad_asignada');
            $table->unsignedBigInteger('id_usuario_supervisor');
            $table->text('comentario')->nullable();
            $table->date('fecha_asignacion');
            $table->date('fecha_inicio')->nullable();
            $table->time('hora_inicio')->nullable();
            $table->date('fecha_finalizacion')->nullable();
            $table->time('hora_finalizacion')->nullable();
            $table->timestamps();

            $table->foreign('id_reporte')->references('id')->on('reportes')->onDelete('restrict');
            $table->foreign('id_usuario_administracion')->references('id')->on('users')->onDelete('restrict');
            $table->foreign('id_entidad_asignada')->references('id')->on('entidades')->onDelete('restrict');
            $table->foreign('id_usuario_supervisor')->references('id')->on('users')->onDelete('restrict');
        
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('acciones_reportes');
    }
};
