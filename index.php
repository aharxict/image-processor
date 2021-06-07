<?php

require_once 'vendor/autoload.php';

use App\ResizeImage;

echo 'Start process';

$resizeImage = new ResizeImage();
$resizeImage->resizeSelectedImages();