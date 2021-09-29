<?php

namespace App\Http\Controllers;

use App\Events\EmpresaSelect;
use Illuminate\Http\Request;
use App\Models\s_Acceso;
use App\Models\s_Empresa;
use App\Models\User;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use PhpCfdi\SatWsDescargaMasiva\RequestBuilder\FielRequestBuilder\Fiel;
use PhpCfdi\SatWsDescargaMasiva\RequestBuilder\FielRequestBuilder\FielRequestBuilder;

class EmpresaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $empresas = DB::table('s_acceso')
            ->join('s_empresa', 's_empresa.idempresa', '=', 's_acceso.idempresa')
            ->select('s_empresa.*')
            ->where('s_acceso.idusuario',  auth()->user()->id)
            ->get();

        return view('empresa.index', compact('empresas'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return  view('empresa.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'nombre' => 'required',
            'razonsocial' => 'required',
            'claveciec' => 'required',
            'rfc' => 'required',
            'certificado' => 'required|mimes:cer',
            'llaveprivada' => 'required|mimes:key',
            'claveciec' => 'required',
            'password' => 'required|same:confirm-password',
        ]);

        $certificado = time() . '_' . $request->file('certificado')->getClientOriginalName();
        $llaveprivada = time() . '_' . $request->file('llaveprivada')->getClientOriginalName();

        $path_certificado = $request->file('certificado')->storeAs(
            'files',
            auth()->user()->id,
            $certificado
        );

        $path_llaveprivada = $request->file('llaveprivada')->storeAs(
            'files',
            auth()->user()->id,
            $llaveprivada
        );

        // Creación de la FIEL, puede leer archivos DER (como los envía el SAT) o PEM (convertidos con openssl)
        $fiel = Fiel::create(
            Storage::get($path_certificado),
            Storage::get($path_llaveprivada),
            $request->input('password')
        );

        $empresa = s_Empresa::create(
            $request->only(
                'nombre',
                'razonsocial',
                'claveciec',
                'rfc',
            )
                + ['clavefiel' => '123'] //$fiel]

        );

        $acceso = s_Acceso::create(
            [
                'idempresa' => $empresa->idempresa,
                'idusuario' => auth()->user()->id,
                'creadopor' => auth()->user()->id
            ]
        );
        return redirect()->route('empresa.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(s_Empresa $empresa)
    {
        session(['idEmpresa' =>  $empresa->idempresa]);
        Cache::put('idEmpresa', $empresa->idempresa);
        return redirect()->route('consulta.index');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
