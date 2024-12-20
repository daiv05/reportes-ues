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
        Schema::create('reporte_bienes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_bien')->constrained('bienes');
            $table->foreignId('id_reporte')->constrained('reportes');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reporte_biens');
    }
};
