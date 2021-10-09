<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class s_Acceso extends Model
{
    use HasFactory;

    public $timestamps = true;

    protected $table = 's_acceso';

    const UPDATED_AT = null;
    const CREATED_AT = 'creado';

    protected $fillable = [
        'idempresa',
        'idusuario',
        'creadopor',
        'creado'
    ];

    protected $primaryKey = 'idacceso';
}
