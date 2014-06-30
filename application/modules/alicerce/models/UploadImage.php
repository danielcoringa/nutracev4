<?php

/**
 * Description of Security
 * @category   PubliqueAnuncios
 * @package    Coringa_Controller
 * @copyright  Copyright (c) 2013-2013 CoringaSistemas INC (http://www.coringasistemas.com.br)
 */
class Alicerce_Model_UploadImage {

    public function init() {

    }

    /**
     * Seta a pasta do upload
     * @param varchar $this->folder
     */
    public function setFolder($folder) {
        $this->folder = $folder;
    }

    /**
     * Retorna a pasta do upload
     * @param varchar $this->folder
     * @return varchar
     */
    public function getFolder() {
        return $this->folder;
    }

    public function sendFile($files) {

        $ext = explode('.', $files['file']['name']);
        $filename = $files['file']['name'];
        $nameunic = str_replace(' ', '_', microtime());
        $targetFile = $this->folder . str_replace('.', '_', $nameunic);
        $tempFile = $files['file']['tmp_name'];
        $fileExtension = $ext[1];
        if ($fileExtension == "jpg" || $fileExtension == "jpeg" || $fileExtension == "png" || $fileExtension == "gif") {
// GD variables:
            list($width, $height, $type) = GetImageSize($files['file']['tmp_name']);
            $alg1 = $width - $height;

// Image sizes:
            $bigImage = array(800, 640);
            $mediumImage = array(410, 331);
            $listImage = array(120, 88);
            $thumbnail = array(90, 61);

            $sourceAspect = $width / $height;
            $bigAspect = $bigImage[0] / $bigImage[1];
            $mediumAspect = $mediumImage[0] / $mediumImage[1];
            $listAspect = $listImage[0] / $listImage[1];
            $thumbnailAspect = $thumbnail[0] / $thumbnail[1];

// Image is PNG:
            if ($type == IMAGETYPE_PNG) {
                $image = imagecreatefrompng($files['file']['tmp_name']);
                $valid = true;
            }

// Image is JPEG:
            else if ($type == IMAGETYPE_JPEG) {
                $image = imagecreatefromjpeg($files['file']['tmp_name']);
                $valid = true;
            }

// Image is GIF:
            else if ($type == IMAGETYPE_GIF) {
                $image = imagecreatefromgif($files['file']['tmp_name']);
                $valid = true;
            }

// Format not allowed:
            else {
                $valid = false;
            }

// Start creating images:
            if ($valid) {

// Get size:
                $imageSize = getimagesize($files['file']['tmp_name']);

// Generate canvas:
                $bCanvas = imagecreatetruecolor($bigImage[0], $bigImage[1]);
                $mCanvas = imagecreatetruecolor($mediumImage[0], $mediumImage[1]);
                $lCanvas = imagecreatetruecolor($listImage[0], $listImage[1]);
                $tCanvas = imagecreatetruecolor($thumbnail[0], $thumbnail[1]);

// Copy content:
                imagecopyresampled($bCanvas, $image, 0, 0, 0, 0, $bigImage[0], $bigImage[1], $imageSize[0], $imageSize[1]);
                imagecopyresampled($mCanvas, $image, 0, 0, 0, 0, $mediumImage[0], $mediumImage[1], $imageSize[0], $imageSize[1]);
                imagecopyresampled($lCanvas, $image, 0, 0, 0, 0, $listImage[0], $listImage[1], $imageSize[0], $imageSize[1]);
                imagecopyresampled($tCanvas, $image, 0, 0, 0, 0, $thumbnail[0], $thumbnail[1], $imageSize[0], $imageSize[1]);

// Save images:
                $saveB = imagejpeg($bCanvas, $targetFile . '_big.jpg', 90);
                $saveM = imagejpeg($mCanvas, $targetFile . '_medium.jpg', 90);
                $saveT = imagejpeg($lCanvas, $targetFile . '_list.jpg', 90);
                $saveT = imagejpeg($tCanvas, $targetFile . '_thumb.jpg', 90);

// Destroy images:
                imagedestroy($image);
                imagedestroy($bCanvas);
                imagedestroy($mCanvas);
                imagedestroy($lCanvas);
                imagedestroy($tCanvas);
//    echo "jQuery('#resizeimg').attr('src','" . str_replace('/var/www/publiqueanuncios.sytes.net/public_html','',$targetFile . '.' . $fileExtension) . "');";
                echo "addImageLista('" . str_replace(".", "_", $nameunic) . "." . $fileExtension . "');";
                move_uploaded_file($tempFile, $targetFile . '.' . $fileExtension);
            }
            else {
                echo "0";
            }
        }
    }

}
