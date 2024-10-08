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
        Schema::create('escuelas', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_facultad');
            $table->string('nombre', 50);
            $table->boolean('activo')->default(true);
            $table->timestamps();

            // Aquí puedes agregar una clave foránea , ejemplo:
            // $table->foreign('id_facultad')->references('id')->on('facultades')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('escuelas');
    }
};
