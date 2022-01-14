<?php

namespace App\Http\Controllers\Service;

use App\Http\Controllers\Controller;
use App\Models\s_Empresa;
use Illuminate\Http\Request;

use PhpCfdi\SatWsDescargaMasiva\PackageReader\Exceptions\OpenZipFileException;
use PhpCfdi\SatWsDescargaMasiva\PackageReader\CfdiPackageReader;
use PhpCfdi\SatWsDescargaMasiva\PackageReader\MetadataPackageReader;


class ReadCfdiController extends Controller
{
    public function readCFDI(s_Empresa $empresa, Request $request)
    {
        //Lectura de paquetes de tipo CFDI
        /**
         * @var string $zipfile contiene la ruta al archivo de paquete de archivos ZIP
         */

        if ($request->hasFile('zip')) {
            $zip = $request->key->getClientOriginalName();
        }

        $path_certificado = $request->file('cer')->storeAs(
            'files/' . auth('sanctum')->user()->id . '/' . 'fiel/' . $empresa->idempresa,
            $zip
        );

        try {
            $cfdiReader = CfdiPackageReader::createFromFile($zipfile);
        } catch (OpenZipFileException $exception) {
            echo $exception->getMessage(), PHP_EOL;
            return;
        }

        // leer todos los CFDI dentro del archivo ZIP con el UUID como llave
        foreach ($cfdiReader->cfdis() as $uuid => $content) {
            file_put_contents("cfdis/$uuid.xml", $content);
        }
    }
    public function readMetadata()
    {
        //Lectura de paquetes de tipo Metadata
        /**
         * @var string $zipfile contiene la ruta al archivo de paquete de Metadata
         */

        // abrir el archivo de Metadata
        try {
            $metadataReader = MetadataPackageReader::createFromFile($zipfile);
        } catch (OpenZipFileException $exception) {
            echo $exception->getMessage(), PHP_EOL;
            return;
        }

        // leer todos los registros de metadata dentro de todos los archivos del archivo ZIP
        foreach ($metadataReader->metadata() as $uuid => $metadata) {
            echo $metadata->uuid, ': ', $metadata->fechaEmision, PHP_EOL;
        }
    }
}
