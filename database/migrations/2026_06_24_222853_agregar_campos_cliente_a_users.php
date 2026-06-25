<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Agrega campos adicionales a la tabla 'users' para los clientes.
 * Estos campos son opcionales (nullable) para no afectar al admin
 * que ya existe.
 */
return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            // Datos extra del cliente (todos opcionales)
            $table->string('apellido')->nullable()->after('name');
            $table->string('telefono')->nullable()->after('email');
            $table->string('empresa')->nullable()->after('telefono');
            $table->string('ciudad')->nullable()->after('empresa');
            $table->string('estado_direccion')->nullable()->after('ciudad'); // estado/provincia
            $table->string('estatus')->default('activo')->after('role');      // activo, inactivo, bloqueado
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['apellido', 'telefono', 'empresa', 'ciudad', 'estado_direccion', 'estatus']);
        });
    }
};