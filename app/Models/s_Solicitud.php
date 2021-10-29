<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class s_Solicitud extends Model
{
    use HasFactory;

    public $timestamps = true;

    const UPDATED_AT = null;
    const CREATED_AT = 'fechasol';

    protected $table = 's_solicitud';

    protected $fillable = [
        'fechasol',
        'fechaini',
        'fechafin',
        'tipo',
        'idpet',
        'estadopet',
        'estadosol',
        'procesada',
        'idempresa',
        'visible',
        'tipo_archivos',
    ];

    protected $primaryKey = 'idsolicitud'; 
}
