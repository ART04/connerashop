<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Plano de la tabla 'producto_documentos'.
 * Guarda los PDFs descargables de cada producto.
 * Ejemplo de una fila:  producto 5  ->  "Ficha tecnica"  ->  productos/docs/ficha.pdf
 */
return new class extends Migration
{
    public function up(): void
    {
        Schema::create('producto_documentos', function (Blueprint $table) {
            $table->id();

            $table->foreignId('producto_id')
                  ->constrained('productos')
                  ->cascadeOnDelete();

            $table->string('titulo');     // Nombre visible: "Ficha tecnica"
            $table->string('archivo');    // Ruta del PDF guardado
            $table->integer('orden')->default(0);

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('producto_documentos');
    }
};