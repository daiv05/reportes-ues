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
        Schema::create('recursos_reportes', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_historial_acciones_reporte');
            $table->string('nombre', 100);
            $table->decimal('costo');
            $table->foreign('id_historial_acciones_reporte')->references('id')->on('historial_acciones_reportes')->onDelete('restrict');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('recursos_reportes');
    }
};
