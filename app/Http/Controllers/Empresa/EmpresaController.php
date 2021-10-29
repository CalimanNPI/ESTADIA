<?php

namespace App\Http\Controllers\Empresa;

use App\Http\Controllers\Controller;
use App\Http\Requests\EmpresaRequest;
use App\Http\Resources\EmpresaResource;
use Illuminate\Http\Request;
use App\Models\s_Acceso;
use App\Models\s_Empresa;
use Illuminate\Support\Facades\DB;

class EmpresaController extends Controller
{
    public function index()
    {
        $empresas = DB::table('s_empresa')
            ->join('s_acceso', 's_empresa.idempresa', '=', 's_acceso.idempresa')
            ->select('s_empresa.*')
            ->where('s_acceso.idusuario',  1)
            ->get();
        return response()->json($empresas);
    }

    public function store(EmpresaRequest $request)
    {

        $empresa = s_Empresa::create(
            $request->only(
                'nombre',
                'razonsocial',
                'claveciec',
                'rfc',
            )
        );

        $acceso = s_Acceso::create(
            [
                'idempresa' => $empresa->idempresa,
                'idusuario' =>  1,
                'creadopor' =>  1,
            ]
        );
        return new EmpresaResource($empresa);
    }

    public function show(s_Empresa $empresa)
    {
        return new EmpresaResource($empresa);
    }

    public function update(EmpresaRequest $request, s_Empresa $empresa)
    {
        $empresa->update($request->validated());
        return new EmpresaResource($empresa);
    }

    public function destroy(s_Empresa $empresa)
    {
        $empresa->delete();
        return response()->noContent();
    }

    public function globalCookie(s_Empresa $empresa)
    {
        session(['empresa' => $empresa->idempresa]);
    }
}
