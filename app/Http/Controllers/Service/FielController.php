<?php

namespace App\Http\Controllers\Service;

use App\Http\Controllers\Controller;
use App\Models\s_Empresa;
use App\Models\archivo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use PhpCfdi\SatWsDescargaMasiva\RequestBuilder\FielRequestBuilder\Fiel;
use PhpCfdi\SatWsDescargaMasiva\RequestBuilder\FielRequestBuilder\FielRequestBuilder;

class FielController extends Controller
{
    public function createFiel(Request $request, s_Empresa $empresa)
    {
        $this->validate($request, [
            'cer' => 'required',
            'key' => 'required', 
            'password' => 'required',
        ]);

        if ($request->hasFile('cer')) {
            $cer = $request->cer->getClientOriginalName();
        }

        if ($request->hasFile('key')) {
            $key = $request->key->getClientOriginalName();
        }

        //$certificado = time() . '_' . $request->file('certificado')->getClientOriginalName();
        //$llaveprivada = time() . '_' . $request->file('llaveprivada')->getClientOriginalName();

        $path_certificado = $request->file('cer')->store(
            'public/files/',
            $cer
        );

        $path_llaveprivada = $request->file('key')->store(
            'public/files/',
            $key
        );

        $archivo = archivo::create(
            [
                'tabla' => 's_empresa',
                'extension' => 'key',
                'tipoarchivo' => 'archivo',
                'nombrearchivo' => $key,
                'rutaoriginal' => $path_llaveprivada,
                'elementosistema' => true,
                'idtabla' => $empresa->idempresa,
                'datos' => 'save',
                'no_modificar'=> true,
            ],
            [
                'tabla' => 's_empresa',
                'extension' => 'cer',
                'tipoarchivo' => 'archivo',
                'nombrearchivo'=> $cer,
                'rutaoriginal' => $path_certificado,
                'elementosistema' => true,
                'idtabla' => $empresa->idempresa,
                'datos' => 'save',
                'no_modificar'=> true,
            ]
        );

        // Creación de la FIEL, puede leer archivos DER (como los envía el SAT) o PEM (convertidos con openssl)
        $fiel = Fiel::create(
            $path_certificado,
            $path_llaveprivada,
            $request->input('password')
        );

        $empresa->clavefiel = $fiel;
        $empresa->save();
        return response()->json([
            'fiel' => $fiel,
            'message' => 'Creación de la FIEL'
        ], 200);
    }
}
