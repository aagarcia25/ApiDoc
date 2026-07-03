<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class Correos extends Model
{
    use HasFactory;
    use HasUuids;

    protected $table = 'correos_foro';
    protected $keyType = 'string';
    public $incrementing = false;

    protected $fillable = [
        'nombre',
        'apellido_paterno',
        'apellido_materno',
        'correo',
        'cargo',
        'ente',
        'telefono',
        'acceso_jueves',
        'acceso_viernes',
    ];

    protected $casts = [
        'id' => 'string',
    ];
}
