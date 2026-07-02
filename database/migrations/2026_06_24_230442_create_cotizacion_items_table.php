<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Plano de la tabla 'cotizacion_items'.
 * Guarda los productos solicitados en cada cotizacion (uno o varios).
 */
return new class extends Migration
{
    public function up(): void
    {
        Schema::create('cotizacion_items', function (Blueprint $table) {
            $table->id();

            // A que cotizacion pertenece. Si se borra la cotizacion, se borran sus items.
            $table->foreignId('cotizacion_id')
                  ->constrained('cotizaciones')
                  ->cascadeOnDelete();

            // Que producto. Si se borra el producto, el item queda sin enlace pero conserva el nombre.
            $table->foreignId('producto_id')
                  ->nullable()
                  ->constrained('productos')
                  ->nullOnDelete();

            // Guardamos el nombre del producto por si el producto se borra despues
            $table->string('producto_nombre');

            $table->integer('cantidad')->default(1);
            $table->text('observaciones')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('cotizacion_items');
    }
};