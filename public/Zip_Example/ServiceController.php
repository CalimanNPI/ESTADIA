<?php

namespace App\Http\Controllers\Service;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\s_Empresa;
use App\Models\s_Solicitud;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use PhpCfdi\SatWsDescargaMasiva\RequestBuilder\FielRequestBuilder\FielRequestBuilder;
use PhpCfdi\SatWsDescargaMasiva\Services\Query\QueryParameters;
use PhpCfdi\SatWsDescargaMasiva\Shared\DateTimePeriod;
use PhpCfdi\SatWsDescargaMasiva\Shared\DownloadType;
use PhpCfdi\SatWsDescargaMasiva\Shared\RequestType;

//Agregados
use PhpCfdi\SatWsDescargaMasiva\Service;
use PhpCfdi\SatWsDescargaMasiva\WebClient\GuzzleWebClient;
use ZipArchive;
use Illuminate\Support\Str;

class ServiceController extends Controller
{
    public function getConsultation(Request $request)
    {

        $this->validate($request, [
            'datatypes' => 'required',
            'downloadtypes' => 'required',
            'startdate' => 'required|date',
            'enddate' => 'required|date'
        ]);
        $value = session()->get('empresa');

        $user= auth('api')->user();

        return response()->json([
            "requestId" => "1231546789",
            "message" =>  "ASdasd",
            'estadopet' => "Aceptada",
            'estadosol' =>  'En proceso',

        ], 200);

        $input = $request->all();
        $tipo = substr($input['datatypes'], 0, 1);
        $archivo = substr($input['downloadtypes'], 0, 4);

        $value = session('empresa');
        $empresa = s_Empresa::find($value);

        //Del 13/ene/2019 00:00:00 al 13/ene/2019 23:59:59 (inclusive)
        $startdate = $input['startdate'] . ' ' . '00:00:00';
        $enddate = $input['enddate'] . ' ' . '23:59:59';

        $estadopet  = "Aceptada";
        $estadosol =  'En proceso';

        // Creación de servicio
        $service = new ConnectionController();
        $service->createWebClient($empresa);

        if ($input['datatypes'] == 'emitidos' && $input['downloadtypes'] == 'metadata') {
            $consulta = QueryParameters::create(
                DateTimePeriod::createFromValues($startdate,  $enddate),
                DownloadType::issued(), // Emitidos DownloadType::issued()
                RequestType::metadata(), // Metadatos RequestType::metadata()
                $empresa->rfc // RFC MAG041126GT8
            );
        }

        if ($input['datatypes'] == 'recibidos' && $input['downloadtypes'] == 'metadata') {
            $consulta = QueryParameters::create(
                DateTimePeriod::createFromValues($startdate,  $enddate),
                DownloadType::received(), // Recibidos DownloadType::received()
                RequestType::metadata(), // Metadatos RequestType::metadata()
                $empresa->rfc // RFC MAG041126GT8
            );
        }

        if ($input['datatypes'] == 'emitidos' && $input['downloadtypes'] == 'CFDI') {
            $consulta = QueryParameters::create(
                DateTimePeriod::createFromValues($startdate,  $enddate),
                DownloadType::received(), // Recibidos DownloadType::received()
                RequestType::cfdi(), // Archivos CFDI RequestType::cfdi()
                $empresa->rfc // RFC MAG041126GT8
            );
        }

        if ($input['datatypes'] == 'recibidos' && $input['downloadtypes'] == 'CFDI') {
            $consulta = QueryParameters::create(
                DateTimePeriod::createFromValues($startdate,  $enddate),
                DownloadType::issued(), // Emitidos DownloadType::issued()
                RequestType::cfdi(), // Archivos CFDI RequestType::cfdi()
                $empresa->rfc // RFC MAG041126GT8
            );
        }

        // presentar la consulta
        $query = $service->query($consulta);

        // verificar que el proceso de consulta fue correcto
        if (!$query->getStatus()->isAccepted()) {
            $estadopet  = "Fallo";
            $estadosol =  'Fallo';
        }

        $requestId = $query->getRequestId(); // El identificador de la consulta está en $query->getRequestId()

        $solicitud = s_Solicitud::create(
            [
                'fechaini' => $input['startdate'],
                'fechafin' =>  $input['enddate'],
                'tipo' =>  $tipo,
                'idpet' => $requestId,
                'estadopet' => $estadopet,
                'estadosol' =>  $estadosol,
                'procesada' => DB::raw('false'),
                'idempresa' =>  $empresa->idempresa,
                'visible' =>  DB::raw('true'),
                'tipo_archivos' => $archivo,
            ]
        );

        if ($estadopet !== 'Fallo') {
            return response()->json([
                "requestId" => $requestId,
                "message" => "La solicitud {$requestId} está lista",
                'estadopet' => "Aceptada",
                'estadosol' =>  'En proceso',

            ], 200);
        }

        return response()->json([
            "message" => "Fallo al presentar la consulta: {$query->getStatus()->getMessage()}",
            'estadopet' => "Fallo",
            'estadosol' =>  'Fallo',
            'cod' => 400
        ]);
    }

    public function getVerification($requestId)
    {

        return response()->json([
            'packagesIds' => "packagesIds",
            'packages' => "Se encontraron 3 paquetes",
            "message" => Auth::user(),
            "requestId" => $requestId,
        ], 200);

        $value = session('empresa');
        $empresa = s_Empresa::find($value);

        // Creación de servicio
        $service = new ConnectionController();
        $service->createWebClient($empresa);

        // consultar el servicio de verificación
        $verify = $service->verify($requestId);

        // revisar que el proceso de verificación fue correcto
        if (!$verify->getStatus()->isAccepted()) {
            $empresa->estadosol = 'Fallo al verificar';
            $empresa->save();

            return response()->json([
                "message" => "Fallo al verificar la consulta {$requestId}: {$verify->getStatus()->getMessage()}",
                'cod' => 400
            ]);
        }

        // revisar que la consulta no haya sido rechazada
        if (!$verify->getCodeRequest()->isAccepted()) {
            $empresa->estadosol = 'Rechazada';
            $empresa->save();

            return response()->json([
                "message" => "La solicitud {$requestId} fue rechazada: {$verify->getCodeRequest()->getMessage()}",
                'cod' => 400
            ]);
        }

        // revisar el progreso de la generación de los paquetes
        $statusRequest = $verify->getStatusRequest();
        if ($statusRequest->isExpired() || $statusRequest->isFailure() || $statusRequest->isRejected()) {
            $empresa->estadosol = 'No se puede completar';
            $empresa->save();

            return response()->json([
                "message" => "La solicitud {$requestId} no se puede completar",
                'cod' => 400
            ]);
        }

        if ($statusRequest->isInProgress() || $statusRequest->isAccepted()) {
            $empresa->estadosol = 'Se está procesando';
            $empresa->save();

            return response()->json([
                "message" => "La solicitud {$requestId} se está procesando",
                'cod' => 400
            ]);
        }

        if ($statusRequest->isFinished()) {
            $empresa->estadosol = 'Procesada';
            $empresa->procesada = DB::raw('true');
            $empresa->save();

            $message = "La solicitud {$requestId}";
        }

        $packagesIds = $verify->getPackagesIds();
        return response()->json([
            'packagesIds' => $packagesIds,
            'packages' => "Se encontraron {$verify->countPackages()} paquetes",
            "message" => $message,
            "requestId" => $requestId,
        ], 200);

        /**foreach ($verify->getPackagesIds() as $packageId) {
            echo " > {$packageId}", PHP_EOL;
        }*/
    }

    public function getDownloadLink($packagesIds)
    {

        $value = session('empresa');
        $empresa = s_Empresa::find($value);
        $message = "";
        $error = "";


        $zip = new ZipArchive();
        // Ruta absoluta
        $nombreArchivoZip = "2-simple.zip";

        if (!$zip->open($nombreArchivoZip, ZipArchive::CREATE | ZipArchive::OVERWRITE)) {
            exit("Error abriendo ZIP en $nombreArchivoZip");
        }


        // No olvides cerrar el archivo
        $resultado = $zip->close();
        if (!$resultado) {
            exit("Error creando archivo");
        }

        // Ahora que ya tenemos el archivo lo enviamos como respuesta
        // para su descarga

        // El nombre con el que se descarga
        $nombreAmigable = "simple.zip";
        header('Content-Type: application/octet-stream');
        header("Content-Transfer-Encoding: Binary");
        header("Content-disposition: attachment; filename=$nombreAmigable");
        // Leer el contenido binario del zip y enviarlo
        readfile($nombreArchivoZip);

        // Si quieres puedes eliminarlo después:
        unlink($nombreArchivoZip);



        // Creación de servicio
        $service = new ConnectionController();
        $service->createWebClient($empresa);


        // consultar el servicio de verificación
        foreach ($packagesIds as $packageId) {
            $download = $service->download($packageId);
            if (!$download->getStatus()->isAccepted()) {
                $error += "El paquete {$packageId} no se ha podido descargar: {$download->getStatus()->getMessage()}<br>";
                continue;
            }

            file_put_contents($zipfile, $download->getPackageContent());
            $message += "El paquete {$packageId} se ha almacenado<br>";
        }

        return Storage::download($path);


        return response()->download($path);

        return response()->json([
            'errores' => $error,
            "message" => $message,
            "link" => $path
        ], 200);

        $zipfile = "packageId.zip";
        file_put_contents($zipfile, 'ola.txt');

        return response()->file($dir);
    }

    public function createWebClient(s_Empresa $empresa)
    {
        // verificar que la FIEL sea válida
        if (!$empresa->clavefiel->isValid()) {
            return;
        }

        // creación del web client basado en Guzzle que implementa WebClientInterface
        // para usarlo necesitas instalar guzzlehttp/guzzle pues no es una dependencia directa
        $webClient = new GuzzleWebClient();

        // creación del objeto encargado de crear las solicitudes firmadas usando una FIEL
        $requestBuilder = new FielRequestBuilder($empresa->clavefiel);

        // Creación del servicio
        $service = new Service($requestBuilder, $webClient);

        return $service;
    }
}
