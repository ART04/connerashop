<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Plano de la tabla 'producto_especificaciones'.
 * Guarda la lista flexible de caracteristicas tecnicas de cada producto.
 * Ejemplo de una fila:  producto 5  ->  "Voltaje de circuito abierto"  ->  "48.10 Vcc"
 */
return new class extends Migration
{
    public function up(): void
    {
        Schema::create('producto_especificaciones', function (Blueprint $table) {
            $table->id();

            // A que producto pertenece esta caracteristica.
            // Si se borra el producto, se borran tambien sus especificaciones.
            $table->foreignId('producto_id')
                  ->constrained('productos')
                  ->cascadeOnDelete();

            $table->string('etiqueta');   // Nombre de la caracteristica: "Voltaje de circuito abierto"
            $table->string('valor');      // Valor: "48.10 Vcc"
            $table->integer('orden')->default(0); // Orden de aparicion

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('producto_especificaciones');
    }
};