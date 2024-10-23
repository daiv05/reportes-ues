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
        Schema::create('empleados_acciones', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_reporte');
            $table->unsignedBigInteger('id_empleado_puesto');

            $table->foreign('id_reporte')->references('id')->on('reportes')->onDelete('restrict');
            $table->foreign('id_empleado_puesto')->references('id')->on('empleados_puestos')->onDelete('restrict');
        
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('empleados_acciones');
    }
};
