<?php

namespace App\Http\Controllers;

use App\Models\Cliente;
use App\Models\ClienteDocumento;
use Illuminate\Http\Request;
use ZipArchive;
use File;
use Illuminate\Support\Facades\Storage;

class ClienteFileDownloadController extends Controller
{
    public function descargarArchivos(Request $request, Cliente $cliente, ClienteDocumento $documento = null){
        if (!$request->hasValidSignature()) {
            abort(403);
        }

        if ($documento === null) {
            $zip = new ZipArchive;

            $zipname = 'app/public/zip/documentos.zip';

            if (isset($request->documentos)) {
                $documentos = $cliente->documentos->whereIn('id', json_decode($request->documentos));
            }else{
                $documentos = $cliente->documentos;
            }

            if (count($documentos) > 0) {
                if ($zip->open(storage_path($zipname), ZipArchive::CREATE | ZipArchive::OVERWRITE) === TRUE) {
                    foreach ($documentos as $doc) {
                        if (!$doc->excluir) {
                            $zip->addFile(storage_path('app/' . $doc->path), basename($doc->path));
                        }
                    }
                    $zip->close();

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
}
