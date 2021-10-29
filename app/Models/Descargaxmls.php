<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Descargaxmls extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $table = 'descargaxmls';

    protected $fillable = [
        'nombre',
        'ruta',
        'sentido',
        'estado',
        'procesado',
        'idestacion',
        'cookie',
    ];

    protected $primaryKey = 'url'; 
}
