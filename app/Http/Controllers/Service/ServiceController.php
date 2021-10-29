<?php

namespace App\Http\Controllers\Service;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\s_Empresa;
use App\Models\s_Solicitud;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use PhpCfdi\SatWsDescargaMasiva\Services\Query\QueryParameters;
use PhpCfdi\SatWsDescargaMasiva\Shared\DateTimePeriod;
use PhpCfdi\SatWsDescargaMasiva\Shared\DownloadType;
use PhpCfdi\SatWsDescargaMasiva\Shared\RequestType;

//Agregados
use PhpCfdi\SatWsDescargaMasiva\Service;
use PhpCfdi\SatWsDescargaMasiva\WebClient\GuzzleWebClient;
use ZipArchive;

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

       /** return response()->json([
            "requestId" => "1231546789",
            "message" => "La solicitud  está lista",
            'estadopet' => "Aceptada",
            'estadosol' =>  'En proceso',
            
        ], 200);*/
        
        $input = $request->all();
        $tipo =substr($input['datatypes'], 0, 1);
        $archivo =substr($input['downloadtypes'], 0, 4);

        $value = session('empresa');
        $empresa = s_Empresa::find($value);

        //Del 13/ene/2019 00:00:00 al 13/ene/2019 23:59:59 (inclusive)
        $startdate = $input['startdate'] . ' ' . '00:00:00';
        $enddate = $input['enddate'] . ' ' . '23:59:59';

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
            return response()->json([
                "message" => "Fallo al presentar la consulta: {$query->getStatus()->getMessage()}",
                'estadopet' => "Fallo",
                'estadosol' =>  'Fallo',
                'cod' => 400
            ]);
        }

        $requestId = $query->getRequestId(); // El identificador de la consulta está en $query->getRequestId()
        

         $solicitud = s_Solicitud::create(
                [
                    'fechaini' => $input['startdate'],
                    'fechafin' =>  $input['enddate'],
                    'tipo' =>  $input['datatypes'],
                    'idpet' => $requestId,
                    'estadopet' => "Fallo",
                    'estadosol' =>  'Fallo',
                    'procesada' => false,
                    'idempresa' =>  $empresa->idempresa,
                    'visible' =>  true,
                    'tipo_archivos' => $input['downloadtypes'],
                ]
            );
         
        $solicitud = s_Solicitud::create(
            [
                'fechaini' => $input['startdate'],
                'fechafin' =>  $input['enddate'],
                'tipo' =>  $input['datatypes'],
                'idpet' => $requestId,
                'estadopet' => "Aceptada",
                'estadosol' =>  'En proceso',
                'procesada' => false,
                'idempresa' =>  $empresa->idempresa,
                'visible' =>  true,
                'tipo_archivos' => $input['downloadtypes'],
            ]
        );
      
        return response()->json([
            "requestId" => $requestId,
            "message" => "La solicitud {$requestId} está lista",
            'estadopet' => "Aceptada",
            'estadosol' =>  'En proceso',
            
        ], 200);
    }

    public function getVerification($requestId)
    {

        return response()->json([
            'packagesIds' => "packagesIds",
            'packages' => "Se encontraron 3 paquetes",
            "message" => "message",
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
            return response()->json([
                "message" => "Fallo al verificar la consulta {$requestId}: {$verify->getStatus()->getMessage()}",
                'cod' => 400
            ]);
        }

        // revisar que la consulta no haya sido rechazada
        if (!$verify->getCodeRequest()->isAccepted()) {
            return response()->json([
                "message" => "La solicitud {$requestId} fue rechazada: {$verify->getCodeRequest()->getMessage()}",
                'cod' => 400
            ]);
        }

        // revisar el progreso de la generación de los paquetes
        $statusRequest = $verify->getStatusRequest();
        if ($statusRequest->isExpired() || $statusRequest->isFailure() || $statusRequest->isRejected()) {
            return response()->json([
                "message" => "La solicitud {$requestId} no se puede completar",
                'cod' => 400
            ]);
        }

        if ($statusRequest->isInProgress() || $statusRequest->isAccepted()) {
            return response()->json([
                "message" => "La solicitud {$requestId} se está procesando",
                'cod' => 400
            ]);
        }

        if ($statusRequest->isFinished()) {
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

        return Storage::download(__DIR__.'packageId.zip'); 

        $value = session('empresa');
        $empresa = s_Empresa::find($value);
        $message = "";
        $error = "";
        // Creación de servicio
        $service = new ConnectionController();
        $service->createWebClient($empresa);

        $zipfile = "$packagesIds.zip";
        $path = storage_path("app/public", $packagesIds);

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


        return response()->download($path);

        return response()->json([
            'errores' => $error,
            "message" => $message,
            "link"=> $path
        ], 200);

        $zipfile = "packageId.zip";
        file_put_contents($zipfile, 'ola.txt');
        // Creamos un instancia de la clase ZipArchive
        $zip = new ZipArchive();
        // Creamos y abrimos un archivo zip temporal
        $zip->open("miarchivo.zip", ZipArchive::CREATE);
        // Añadimos un directorio
        $dir = __DIR__ . '/public/storage/Archivos/1';
        $zip->addEmptyDir($dir);
        return response()->file($dir);
    }

    public function getDownload($link)
    {
        return response()->download($link);
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
