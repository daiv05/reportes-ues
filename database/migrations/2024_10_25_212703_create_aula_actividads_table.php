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
        Schema::create('aula_actividads', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_aula')->constrained('aulas');
            $table->foreignId('id_actividad')->constrained('actividades');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('aula_actividads');
    }
};
