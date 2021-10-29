<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class s_Estacion extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $table = 's_estacion';

    protected $fillable = [
        'estacion',
        'descripcion',
        'codigosolicitud',
        'activacion',
        'rutaarchivos',
        'rutatemporal',
        'rutarespaldos',
        'rutapg',
        'id_server',
        'cod_cliente',
    ];

    protected $primaryKey = 'idestacion'; 
}
