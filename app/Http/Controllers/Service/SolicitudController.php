<?php

namespace App\Http\Controllers\Service;

use App\Http\Controllers\Controller;
use App\Models\s_Empresa;
use App\Models\s_Solicitud;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SolicitudController extends Controller
{
    public function solicitud(s_Empresa $empresa, $pendientes)
    {
        if ($pendientes == 'true') {
            $solicitud = s_Solicitud::all()
            ->where('idempresa',  $empresa->idempresa)
            ->where('estadosol', 'En proceso');
             return response()->json($solicitud);
        } else {
            $solicitud = s_Solicitud::all()
            ->where('idempresa',  $empresa->idempresa);
        }
        return response()->json($solicitud);
    }


    public function getPathFiles(s_Empresa $empresa)
    {
        $solicitud = DB::table('s_solicitud')
        ->join('file_downloads', 's_solicitud.idpet', '=', 'file_downloads.idpet')
        ->select('file_downloads.*')
        ->where('select_file.procesada',  true)
        ->get();

        return response()->json($solicitud);
    }
}
