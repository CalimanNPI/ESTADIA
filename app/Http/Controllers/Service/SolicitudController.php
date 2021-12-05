<?php

namespace App\Http\Controllers\Service;

use App\Http\Controllers\Controller;
use App\Models\s_Solicitud;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SolicitudController extends Controller
{
    public function index()
    {
        $date = new \DateTime();

        $solicitud = DB::table('s_solicitud')
            ->select('s_solicitud.*')
            ->where('estadosol', 'En proceso')
            ->where('estadopet', 'Aceptada')
            ->whereDate('fechasol', $date->format('Y/m/d'))
            ->get();
        return response()->json($solicitud);
    }

    public function store(Request $request)
    {
    }

    public function show()
    {
    }

    public function update()
    {
    }

    public function destroy()
    {
    }
}
