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
        Schema::create('departamentos', function (Blueprint $table) {
            $table->id();
            $table->string('nombre', 50);
            $table->text('descripcion');
            $table->boolean('activo')->default(true);
            $table->unsignedBigInteger('id_departamento')->nullable(); // Campo recursivo
            $table->integer('jerarquia')->default(0); // Campo para la jerarquía
            $table->timestamps();

            // Definir la relación recursiva
            $table->foreign('id_departamento')->references('id')->on('departamentos')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('departamentos');
    }
};
