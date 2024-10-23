<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('puestos', function (Blueprint $table) {
            $table->id(); // Llave primaria
            $table->foreignId('id_departamento')
                ->constrained('departamentos') // Referencia a la tabla departamentos
                ->onDelete('cascade') // Si se elimina el departamento, se eliminan los puestos relacionados
                ->onUpdate('cascade'); // Si se actualiza el departamento, se actualiza la referencia en puestos
            $table->string('nombre', 50);
            $table->boolean('activo')->default(1);
            $table->timestamps(); // created_at y updated_at
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('puestos');
    }
};
