<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Plano de la tabla 'marcas'.
 * Guarda los logos de las marcas que apareceran en el carrusel
 * del sitio publico. Solo nombre (para identificar) + logo.
 */
return new class extends Migration
{
    public function up(): void
    {
        Schema::create('marcas', function (Blueprint $table) {
            $table->id();

            $table->string('nombre');                 // Nombre de la marca (ej: CONNERA)
            $table->string('logo')->nullable();       // Ruta del logo guardado
            $table->string('sitio_web')->nullable();  // URL opcional (por si el logo es clicable)

            $table->boolean('activo')->default(true); // Mostrar en el carrusel o no
            $table->integer('orden')->default(0);     // Orden de aparicion

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('marcas');
    }
};