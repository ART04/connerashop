<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * Campos que se pueden guardar de forma masiva.
     */
    protected $fillable = [
        'name',
        'apellido',
        'email',
        'telefono',
        'empresa',
        'ciudad',
        'estado_direccion',
        'password',
        'role',
        'estatus',
    ];

    /**
     * Campos que se ocultan al convertir a array/JSON (seguridad).
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Conversiones automaticas de tipo.
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }
}