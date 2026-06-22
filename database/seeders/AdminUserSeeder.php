<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

/**
 * Crea (o actualiza) la cuenta del ADMINISTRADOR de Connera Shop.
 * El correo y la contraseña se leen del archivo .env (privado),
 * así tu clave nunca queda visible en el código de GitHub.
 */
class AdminUserSeeder extends Seeder
{
    public function run(): void
    {
        // "updateOrCreate" busca por correo:
        //   - si ya existe esa cuenta, la actualiza
        //   - si no existe, la crea
        // Así puedes correr esto cuantas veces quieras sin duplicar al admin.
        User::updateOrCreate(
            ['email' => env('ADMIN_EMAIL', 'admin@connerashop.com')], // a quién buscar
            [
                'name'     => 'Administrador',
                // La contraseña se encripta sola automáticamente al guardarla.
                'password' => env('ADMIN_PASSWORD', 'connera-temporal-2026'),
                'role'     => 'admin', // Esta cuenta es de tipo administrador.
            ]
        );
    }
}