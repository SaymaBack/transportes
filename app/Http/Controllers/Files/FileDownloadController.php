<?php

namespace App\Http\Controllers\Files;

use App\Http\Controllers\Controller;
use App\Models\Cliente;
use App\Models\ClienteDocumento;
use App\Models\Empleado;
use App\Models\EmpleadoDocumento;
use Illuminate\Http\Request;
use ZipArchive;
use Illuminate\Support\Facades\Storage;

class FileDownloadController extends Controller
{
    public function descargarArchivosClientes(Request $request, Cliente $cliente, ClienteDocumento $documento = null){
        if (!$request->hasValidSignature()) {
            abort(403);
        }

        if ($documento === null) {
            $zip = new ZipArchive;

            $zipname = 'app/documentos/zip/documentos.zip';

            $documentos = null;


            /**
             * Verifica si se envio en la solicitud la lista de documentos a descargar
             */

            if (isset($request->documentos)) {
                $documentos = $cliente->documentos->whereIn('id', json_decode($request->documentos));
            }

            if (count($documentos) > 0) {
                if ($zip->open(storage_path($zipname), ZipArchive::CREATE | ZipArchive::OVERWRITE) === TRUE) {
                    foreach ($documentos as $doc) {
                        if (!$doc->excluir) {
                            $zip->addFile(storage_path('app/' . $doc->path), basename($doc->path));
                        }
                    }
                    $zip->close();

                    return response()->download(storage_path($zipname));

                    if (file_exists(storage_path($zipname))) {
                        return response()->download(storage_path($zipname));
                    }

                }
            }
        } else{
            $path = $documento->path;

            return Storage::download($path);
        }

        abort(403);
    }

    public function descargarArchivosEmpleados(Request $request, Empleado $empleado, EmpleadoDocumento $empleadoDocumento = null){
        if (!$request->hasValidSignature()) {
            abort(403);
        }

        if ($empleadoDocumento === null) {
            $zip = new ZipArchive;

            $zipname = 'app/documentos/zip/documentos.zip';

            $documentos = null;


            /**
             * Verifica si se envio en la solicitud la lista de documentos a descargar
             */

            if (isset($request->documentos)) {
                $documentos = $empleado->documentos->whereIn('id', json_decode($request->documentos));
            }

            if (count($documentos) > 0) {
                if ($zip->open(storage_path($zipname), ZipArchive::CREATE | ZipArchive::OVERWRITE) === TRUE) {
                    foreach ($documentos as $doc) {
                        if (!$doc->excluir) {
                            $zip->addFile(storage_path('app/' . $doc->path), basename($doc->path));
                        }
                    }
                    $zip->close();

                    return response()->download(storage_path($zipname));

                    if (file_exists(storage_path($zipname))) {
                        return response()->download(storage_path($zipname));
                    }

                }
            }
        } else{
            $path = $empleadoDocumento->path;

            return Storage::download($path);
        }

        abort(403);
    }
}
