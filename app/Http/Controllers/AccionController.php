<?php

namespace App\Http\Controllers;

use App\Models\s_Empresa;
use DateTime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use PhpCfdi\SatWsDescargaMasiva\Services\Query\QueryParameters;
use PhpCfdi\SatWsDescargaMasiva\Shared\DateTimePeriod;
use PhpCfdi\SatWsDescargaMasiva\Shared\DownloadType;
use PhpCfdi\SatWsDescargaMasiva\Shared\RequestType;


//use PhpCfdi\SatWsDescargaMasiva\Service;

class AccionController extends Controller
{
    public function index()
    {
        return view('consultas.consulta');
    }

    public function getConsulta(Request $request)
    {

        $this->validate($request, [
            'datos' => 'required',
            'descarga' => 'required',
            'fechaInicio' => 'required|date',
            'fechaFin' => 'required|date'
        ]);


        $idEmpresa = Cache::get('idEmpresa');

        $input = $request->all();
        $empresa = s_Empresa::find($idEmpresa);
        $errors = array();

        // Creación de servicio
        $service = new ServiceController();
        $service->peticion($empresa);

        //Del 13/ene/2019 00:00:00 al 13/ene/2019 23:59:59 (inclusive)
        $fecha = new DateTime($input['fechaInicio']);
        $fechaInicio = $fecha->format('d-m-Y') . ' ' . '00:00:00';
        $fecha = new DateTime($input['fechaFin']);
        $fechaFin = $fecha->format('d-m-Y') . ' ' . '23:59:59';


        if ($input['datos'] == 'emitidos' && $input['descarga'] == 'metadata') {
            $consulta = QueryParameters::create(
                DateTimePeriod::createFromValues($fechaInicio,  $fechaFin),
                DownloadType::issued(), // Emitidos DownloadType::issued()
                RequestType::metadata(), // Metadatos RequestType::metadata()
                $empresa->rfc // RFC MAG041126GT8
            );
        }

        if ($input['datos'] == 'recibidos' && $input['descarga'] == 'metadata') {
            $consulta = QueryParameters::create(
                DateTimePeriod::createFromValues($fechaInicio,  $fechaFin),
                DownloadType::received(), // Recibidos DownloadType::received()
                RequestType::metadata(), // Metadatos RequestType::metadata()
                $empresa->rfc // RFC MAG041126GT8
            );
        }

        if ($input['datos'] == 'emitidos' && $input['descarga'] == 'CFDI') {
            $consulta = QueryParameters::create(
                DateTimePeriod::createFromValues($fechaInicio,  $fechaFin),
                DownloadType::received(), // Recibidos DownloadType::received()
                RequestType::cfdi(), // Archivos CFDI RequestType::cfdi()
                $empresa->rfc // RFC MAG041126GT8
            );
        }

        if ($input['datos'] == 'recibidos' && $input['descarga'] == 'CFDI') {
            $consulta = QueryParameters::create(
                DateTimePeriod::createFromValues($fechaInicio,  $fechaFin),
                DownloadType::issued(), // Emitidos DownloadType::issued()
                RequestType::cfdi(), // Archivos CFDI RequestType::cfdi()
                $empresa->rfc // RFC MAG041126GT8
            );
        }

        // presentar la consulta
        $query = $service->query($consulta);

        // verificar que el proceso de consulta fue correcto
        if (!$query->getStatus()->isAccepted()) {
            echo "Fallo al presentar la consulta: {$query->getStatus()->getMessage()}";
            $message = "Fallo al presentar la consulta: {$query->getStatus()->getMessage()}";
            $errors[] = array('error' => $message);
        }

        $requestId = $query->getRequestId(); // El identificador de la consulta está en $query->getRequestId()
        $message = 'Se generó la solicitud';
        $errors[] = array('error' => $message);
        return view('consultas.peticion', compact('requestId', 'errors', 'empresa'));
    }

    public function getVerificar($requestId)
    {
        $idEmpresa = Cache::get('idEmpresa');
        $errors = array();

        // Creación de servicio
        $service = new ServiceController();
        $service->peticion($idEmpresa);

        // consultar el servicio de verificación
        $verify = $service->verify($requestId);

        // revisar que el proceso de verificación fue correcto
        if (!$verify->getStatus()->isAccepted()) {
            $message = "Fallo al verificar la consulta {$requestId}: {$verify->getStatus()->getMessage()}";
            $errors[] = array('error' => $message);
        }

        // revisar que la consulta no haya sido rechazada
        if (!$verify->getCodeRequest()->isAccepted()) {
            $message = "La solicitud {$requestId} fue rechazada: {$verify->getCodeRequest()->getMessage()}";
            $errors[] = array('error' => $message);
        }

        // revisar el progreso de la generación de los paquetes
        $statusRequest = $verify->getStatusRequest();
        if ($statusRequest->isExpired() || $statusRequest->isFailure() || $statusRequest->isRejected()) {
            $message = "La solicitud {$requestId} no se puede completar";
            $errors[] = array('error' => $message);
        }

        if ($statusRequest->isInProgress() || $statusRequest->isAccepted()) {
            $message = "La solicitud {$requestId} se está procesando";
            $errors[] = array('error' => $message);
        }

        if ($statusRequest->isFinished()) {
            $message = "La solicitud {$requestId} está lista";
            $errors[] = array('error' => $message);
        }

        $message = "Se encontraron {$verify->countPackages()} paquetes";
        $errors[] = array('error' => $message);
        $packagesIds = $verify->getPackagesIds();
        return view('consultas.estatus', compact('packagesIds', 'errors'));
        /**foreach ($verify->getPackagesIds() as $packageId) {
            echo " > {$packageId}", PHP_EOL;
        }*/
    }

    public function getPaquetes($packagesIds)
    {
        $idEmpresa = Cache::get('idEmpresa');
        $errors = array();
        // Creación de servicio
        $service = new ServiceController();
        $service->peticion($idEmpresa);

        // consultar el servicio de verificación
        foreach ($packagesIds as $packageId) {
            $download = $service->download($packageId);
            if (!$download->getStatus()->isAccepted()) {
                $message = "El paquete {$packageId} no se ha podido descargar: {$download->getStatus()->getMessage()}";
                $errors[] = array('error' => $message);
                continue;
            }
            $zipfile = "$packageId.zip";
            file_put_contents($zipfile, $download->getPackageContent());
            echo "El paquete {$packageId} se ha almacenado", PHP_EOL;
        }
    }
}
