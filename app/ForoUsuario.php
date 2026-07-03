<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Hash;

class ForoUsuario extends Model
{
    protected $table = 'foro_usuarios';

    protected $fillable = [
        'nombre',
        'usuario',
        'password',
        'activo',
    ];

    protected $hidden = [
        'password',
    ];

    public function setPasswordAttribute($value)
    {
        if (!Hash::info($value)['algo']) {
            $this->attributes['password'] = Hash::make($value);
        } else {
            $this->attributes['password'] = $value;
        }
    }
}