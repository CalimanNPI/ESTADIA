<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class archivo extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $table = 'archivo';

    protected $fillable = [
        'tabla',
        'extension',
        'tipoarchivo',
        'nombrearchivo',
        'rutaoriginal',
        'elementosistema',
        'idtabla',
        'datos',
        'no_modificar',
    ];

    protected $primaryKey = 'idarchivo';
}
