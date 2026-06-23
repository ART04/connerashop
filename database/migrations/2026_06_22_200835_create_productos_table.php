<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Plano de la tabla 'productos'.
 * Define todos los campos de cada producto del catalogo.
 */
return new class extends Migration
{
    public function up(): void
    {
        Schema::create('productos', function (Blueprint $table) {
            $table->id();                                  // Identificador unico

            $table->string('nombre');                      // Nombre del producto
            $table->string('slug')->unique();              // Version para URL (se genera sola)

            // Conexion con la tabla 'categorias':
            // guarda a que categoria pertenece este producto.
            // Si se borra la categoria, este campo queda en null (no se borra el producto).
            $table->foreignId('categoria_id')
                  ->nullable()
                  ->constrained('categorias')
                  ->nullOnDelete();

            $table->text('descripcion')->nullable();       // Descripcion larga
            $table->decimal('precio', 10, 2)->default(0);  // Precio de referencia
            $table->string('marca')->nullable();           // Marca (texto por ahora)

            $table->string('imagen')->nullable();          // Ruta de la foto guardada

            $table->string('enlace_amazon')->nullable();   // URL de Amazon
            $table->string('enlace_mercadolibre')->nullable(); // URL de Mercado Libre

            $table->boolean('destacado')->default(false);  // Mostrar en portada
            $table->boolean('activo')->default(true);      // Visible o no
            $table->integer('orden')->default(0);          // Orden de aparicion

            $table->timestamps();                          // Fechas automaticas
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('productos');
    }
};