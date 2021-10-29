<?php

namespace App\Http\Controllers\Service;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

//Agregados
use PhpCfdi\SatWsDescargaMasiva\Service;
use PhpCfdi\SatWsDescargaMasiva\WebClient\GuzzleWebClient;

class ConnectionController extends Controller
{
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
