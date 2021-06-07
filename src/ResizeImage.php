<?php
namespace App;

use \Gumlet\ImageResize;
use \Gumlet\ImageResizeException;

class ResizeImage
{
    private $diskImages;
    private const IMAGE_QUALITY = 65;

    public function __construct()
    {
        $this->diskImages = $this->getFilesList();
    }

    public function resizeSelectedImages()
    {
        $diskImagesToProcess = $this-> diskImages;
        foreach ($diskImagesToProcess as $imageName) {
            try {
                list($width, $height) = getimagesize($imageName);
                $path_parts = pathinfo($imageName);
                $data = [];
                $data['path'] = $imageName;
                $data['file'] = $path_parts['basename'];
                $data['initWidth'] = $width;
                $data['initHeight'] = $height;
                $data['sizeBefore'] = filesize($imageName);
                $data['sizeAfter'] = filesize($imageName);
                $data['resized'] = 0;

                $image = new ImageResize($imageName);

                if (($path_parts['extension'] === 'jpg') || ($path_parts['extension'] === 'jpeg')) {
                    $image->quality_jpg = self::IMAGE_QUALITY;
                }

                if ($path_parts['extension'] === 'png') {
                    $image->quality_png = 9;
                }

                $image->save($imageName);

                unset($image);

            } catch (ImageResizeException $e) {
                echo $e;
            }
        }
    }

    private function getFilesList() {
        $fileList = [];
        foreach(glob(__DIR__ . '../images/*') as $file) {
            $fileList[] = $file;
        }
        return $fileList;
    }
}
