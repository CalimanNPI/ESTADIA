<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class s_Empresa extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $table = 's_empresa';

    protected $fillable = [
        'nombre',
        'razonsocial',
        'rfc',
        'claveciec',
        'clavefiel',
        'idempresa'
    ];

    protected $primaryKey = 'idempresa'; 

    protected $attributes = [
        'activa' => 'true',
        'activacion' => '123',
    ];
}
