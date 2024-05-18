<?php

namespace App\Traits;

use Illuminate\Support\Facades\Storage;
use Imagick;

trait ThumbImgTrait{
    public function convertImage($file){
        $image = new Imagick();
        $extension = pathinfo($file, PATHINFO_EXTENSION);
        $name = explode("/", $file);
        $name = str_replace($extension, "jpg", end($name));
        $fileName = "";
        $filesformat = array("jpeg", "gif", "png", "jpg", "pdf");

        if (in_array($extension, $filesformat)) {
            $doc = storage_path("app/" . $file) . "[0]";
            $fileName = storage_path('app/documentos/thumbs/' . $name);
            $image = new Imagick($doc);
            $image->mergeImageLayers(Imagick::LAYERMETHOD_FLATTEN);
            $image->setImageAlphaChannel(Imagick::ALPHACHANNEL_REMOVE);
            $image->minifyImage();
            $image->setImageFormat('jpg');
            $image->writeImage($fileName);

            $this->compressImage($fileName, $fileName, 100);
        }

        return $fileName;
    }

    public function compressImage($source, $destination, $quality)
    {
        $info = getimagesize($source);

        switch ($info['mime']) {
            case 'image/jpeg':
                $image = imagecreatefromjpeg($source);
                break;
            case 'image/gif':
                $image = imagecreatefromgif($source);
                break;
            case 'image/png':
                $image = imagecreatefrompng($source);
                break;
        }

        imagejpeg($image, $destination, $quality);
    }

    public function getThumbImg($path){
        $extension = pathinfo($path, PATHINFO_EXTENSION);
        $thumb = explode("/", $path);
        $thumb_name = str_replace($extension, "jpg", end($thumb));
        $thumb = storage_path("app/documentos/thumbs/" . $thumb_name);

        if (file_exists($thumb)) {
            $thumb = asset("storage/thumbs/" . $thumb_name);
        } else{
            $thumb = null;
        }

        return $thumb;
    }

    public function deleteThumbImg($path): bool{
        $thumb = explode("/", $path);
        $thumb = "app/documentos/thumbs/" . end($thumb);

        if (file_exists(storage_path($thumb))) {
            return Storage::delete(str_replace("app/","",$thumb));
        }

        return false;
    }
}
