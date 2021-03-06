<?php

namespace App\Http\Controllers\Service;

use App\Http\Controllers\Controller;
use App\Models\FileDownload;
use Illuminate\Http\Request;

use App\Models\s_Empresa;
use App\Models\s_Solicitud;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use PhpCfdi\SatWsDescargaMasiva\Services\Query\QueryParameters;
use PhpCfdi\SatWsDescargaMasiva\Shared\DateTimePeriod;
use PhpCfdi\SatWsDescargaMasiva\Shared\DownloadType;
use PhpCfdi\SatWsDescargaMasiva\Shared\RequestType;
use ZipArchive;

class ServiceController extends Controller
{
    public function getConsultation(Request $request, s_Empresa $empresa)
    {

        $this->validate($request, [
            'data' => 'required',
            'download' => 'required',
            'start' => 'required|date',
            'end' => 'required|date'
        ]);

        $solicitud = s_Solicitud::all()->where('idempresa',  $empresa->idempresa);
        return response()->json($solicitud, 200);

        // return response()->json([
        //     "requestId" => "1231546789",
        //     "message" =>  $empresa->rfc,
        //     'estadopet' => "Aceptada",
        //     'estadosol' =>  'En proceso',

        // ], 200);

        $input = $request->all();
        $tipo = substr($input['data'], 0, 1);
        $archivo = substr($input['download'], 0, 4);

        //Del 13/ene/2019 00:00:00 al 13/ene/2019 23:59:59 (inclusive)
        $startdate = $input['start'] . ' ' . '00:00:00';
        $enddate = $input['end'] . ' ' . '23:59:59';

        $estadopet  = "Aceptada";
        $estadosol =  'En proceso';

        // Creación de servicio
        $service = new ConnectionController();
        $service->createWebClient($empresa);

        if ($input['data'] == 'emitidos' && $input['download'] == 'metadata') {
            $consulta = QueryParameters::create(
                DateTimePeriod::createFromValues($startdate,  $enddate),
                DownloadType::issued(), // Emitidos DownloadType::issued()
                RequestType::metadata(), // Metadatos RequestType::metadata()
                $empresa->rfc // RFC MAG041126GT8
            );
        }

        if ($input['data'] == 'recibidos' && $input['download'] == 'metadata') {
            $consulta = QueryParameters::create(
                DateTimePeriod::createFromValues($startdate,  $enddate),
                DownloadType::received(), // Recibidos DownloadType::received()
                RequestType::metadata(), // Metadatos RequestType::metadata()
                $empresa->rfc // RFC MAG041126GT8
            );
        }

        if ($input['data'] == 'emitidos' && $input['download'] == 'CFDI') {
            $consulta = QueryParameters::create(
                DateTimePeriod::createFromValues($startdate,  $enddate),
                DownloadType::received(), // Recibidos DownloadType::received()
                RequestType::cfdi(), // Archivos CFDI RequestType::cfdi()
                $empresa->rfc // RFC MAG041126GT8
            );
        }

        if ($input['data'] == 'recibidos' && $input['download'] == 'CFDI') {
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

        s_Solicitud::create(
            [
                'fechaini' => $input['start'],
                'fechafin' =>  $input['end'],
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
        $solicitud = s_Solicitud::all()->where('idempresa',  $empresa->idempresa);

        if ($estadopet !== 'Fallo') {

            return response()->json($solicitud, 200);
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

    public function getVerification(s_Empresa $empresa, $requestId)
    {

        $zipfile = storage_path('app/public/files/' . auth('sanctum')->user()->id . '/' . 'zip_cfdi_meta/' . $empresa->idempresa . '/' . "$requestId.zip");
        //file_put_contents($zipfile, '$download->getPackageContent()');
        $file = FileDownload::create([
            'name' => "$requestId.zip",
            'paht' => $zipfile,
            'idpet' => $requestId,
            'procesada' =>  DB::raw('false')
        ]);

        return response()->json([
            "message" => "Desarga Finalizada",
            "requestId" =>  $file,
        ], 200);

        $solicitud = s_Solicitud::find('idpet', $requestId);

        // Creación de servicio
        $service = new ConnectionController();
        $service->createWebClient($empresa);

        // consultar el servicio de verificación
        $verify = $service->verify($requestId);

        // revisar que el proceso de verificación fue correcto
        if (!$verify->getStatus()->isAccepted()) {
            $solicitud->estadosol = 'Fallo al verificar';
            $solicitud->save();

            return response()->json([
                "message" => "Fallo al verificar la consulta {$requestId}: {$verify->getStatus()->getMessage()}",
                'cod' => 400
            ]);
        }

        // revisar que la consulta no haya sido rechazada
        if (!$verify->getCodeRequest()->isAccepted()) {
            $solicitud->estadosol = 'Rechazada';
            $solicitud->save();

            return response()->json([
                "message" => "La solicitud {$requestId} fue rechazada: {$verify->getCodeRequest()->getMessage()}",
                'cod' => 400
            ]);
        }

        // revisar el progreso de la generación de los paquetes
        $statusRequest = $verify->getStatusRequest();
        if ($statusRequest->isExpired() || $statusRequest->isFailure() || $statusRequest->isRejected()) {
            $solicitud->estadosol = 'No se puede completar';
            $solicitud->save();

            return response()->json([
                "message" => "La solicitud {$requestId} no se puede completar",
                'cod' => 400
            ]);
        }

        if ($statusRequest->isInProgress() || $statusRequest->isAccepted()) {
            $solicitud->estadosol = 'Se está procesando';
            $solicitud->save();

            return response()->json([
                "message" => "La solicitud {$requestId} se está procesando",
                'cod' => 400
            ]);
        }

        if ($statusRequest->isFinished()) {
            $solicitud->estadosol = 'Procesada';
            $solicitud->procesada = DB::raw('true');
            $solicitud->save();

            $message = "La solicitud {$requestId}";
        }

        $packagesIds = $verify->getPackagesIds();
        //return response()->json([
        //   'packagesIds' => $packagesIds,
        //   'packages' => "Se encontraron {$verify->countPackages()} paquetes",
        //   "message" => $message,
        //   "requestId" => $requestId,
        // ], 200);

        $message = "";
        $error = "";

        foreach ($packagesIds as $packageId) {
            $download = $service->download($packageId);
            if (!$download->getStatus()->isAccepted()) {
                $error += "El paquete {$packageId} no se ha podido descargar: {$download->getStatus()->getMessage()}<br>";
                continue;
            }
            $zipfile = storage_path('app/public/files/' . auth('sanctum')->user()->id . '/' . 'zip_cfdi_meta/' . $empresa->idempresa . '/' . "$packageId.zip");
            file_put_contents($zipfile, $download->getPackageContent());
            $message += "El paquete {$packageId} se ha almacenado<br>";
            FileDownload::create([
                'name' => $packageId,
                'paht' => $zipfile,
                'idpet' => $requestId,
                'procesada' =>  DB::raw('true')
            ]);
        }

        return response()->json(['message' => $message, 'error' => $error], 200);
    }
}
