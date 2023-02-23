<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Model;


class User extends Model implements 
{
    use HasFactory;
    protected $table = "Usuarios";
    public $timestamps = false;
    protected $primaryKey = 'Id';
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'Id',
        'NombreUsuario',
        'Contrasena',
    ];

    

}