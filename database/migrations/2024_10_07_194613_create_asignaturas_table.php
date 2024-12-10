<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
   /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('asignaturas', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_escuela');
            $table->string('nombre')->unique();
            $table->string('nombre_completo');
            $table->boolean('activo')->default(true);
            $table->timestamps();

            // Aquí puedes agregar la clave foránea
            $table->foreign('id_escuela')->references('id')->on('escuelas')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('asignaturas');
    }
};
