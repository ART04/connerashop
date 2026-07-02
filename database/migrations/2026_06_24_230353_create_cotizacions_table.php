<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Plano de la tabla 'cotizaciones'.
 * Guarda cada solicitud de cotizacion que hace un cliente.
 */
return new class extends Migration
{
    public function up(): void
    {
        Schema::create('cotizaciones', function (Blueprint $table) {
            $table->id();

            // Folio unico visible (ej: COT-2026-000001)
            $table->string('folio')->unique();

            // Cliente que la solicito. Si se borra el cliente, la cotizacion queda sin dueno.
            $table->foreignId('user_id')
                  ->nullable()
                  ->constrained('users')
                  ->nullOnDelete();

            // Datos de contacto (por si cotiza sin cuenta, o para tenerlos a la mano)
            $table->string('nombre');
            $table->string('email');
            $table->string('telefono')->nullable();
            $table->string('empresa')->nullable();

            // Comentarios del cliente
            $table->text('comentarios')->nullable();

            // Recibo CFE (archivo opcional: PDF o imagen)
            $table->string('recibo_cfe')->nullable();

            // Estado de la cotizacion
            $table->string('estado')->default('nueva'); // nueva, en_proceso, enviada, aprobada, rechazada, cancelada

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('cotizaciones');
    }
};