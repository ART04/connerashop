<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Esta "migración" es el plano de la tabla 'categorias'.
 * Define qué columnas (campos) tendrá cada categoría del catálogo.
 */
return new class extends Migration
{
    // Se ejecuta al construir la tabla
    public function up(): void
    {
        Schema::create('categorias', function (Blueprint $table) {
            $table->id();                              // Identificador único (1, 2, 3...)

            $table->string('nombre');                  // Nombre visible: "Paneles solares"
            $table->string('slug')->unique();          // Versión para URL: "paneles-solares" (no se repite)
            $table->text('descripcion')->nullable();   // Descripción opcional (puede ir vacía)

            $table->boolean('activo')->default(true);  // ¿Se muestra? Sí por defecto
            $table->integer('orden')->default(0);      // Orden de aparición (0, 1, 2...)

            $table->timestamps();                      // Fechas automáticas de creación y edición
        });
    }

    // Se ejecuta si hay que deshacer la tabla
    public function down(): void
    {
        Schema::dropIfExists('categorias');
    }
};