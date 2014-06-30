<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class Admin_Model_UploadGallery {

    public function init() {

    }

    public function setFolder() {
        $fb = str_replace('index.php', '', $_SERVER['SCRIPT_FILENAME']);
        $folder = $fb . 'gallery/';
        $folderb = 'gallery/';
        if (is_dir($folder . date('Y'))) {
            $folder = $folder . date('Y') . '/';
            $folderb = $folderb . date('Y') . '/';
        }
        else {
            mkdir($folder . date('Y'));
            $folder = $folder . date('Y') . '/';
            $folderb = $folderb . date('Y') . '/';
        }
        if (is_dir($folder . date('m'))) {
            $folder = $folder . date('m') . '/';
            $folderb = $folderb . date('m') . '/';
        }
        else {
            mkdir($folder . date('m'));
            $folder = $folder . date('m') . '/';
            $folderb = $folderb . date('m') . '/';
        }
        $this->folder = $folder;
        $this->folderb = $folderb;
    }

    public function sendFile($file) {
        // Chama a classe de Imagens
        $sImage = new Admin_Model_SimpleImage();


        $nameunic = str_replace(' ', '_', microtime());
        $nameunic = str_replace('.', '_', $nameunic);
        $targetFile = $this->folder . $nameunic;
        $fileExtension = substr($file['files']['name'], -3);

        $sImage->load($file['files']['tmp_name']);
        $tFile = $targetFile;
        $sImage->save($tFile . '.' . $fileExtension);

        $sImage->load($file['files']['tmp_name']);
        $sImage->resizeToWidth(1920);
        $tFile = $targetFile . '_big';
        $sImage->save($tFile . '.' . $fileExtension);

        $sImage->resizeToWidth(600);
        $tFile = $targetFile . '_gallery';
        $sImage->save($tFile . '.' . $fileExtension);

        $sImage->resizeToWidth(80);
        $tFile = $targetFile . '_thumb';
        $sImage->save($tFile . '.' . $fileExtension);

        $dret['folder'] = $this->folderb;
        $dret['url'] = '/' . $this->folderb . $nameunic . '.' . $fileExtension;
        $dret['thumb'] = '/' . $this->folderb . $nameunic . '_thumb.' . $fileExtension;
        $dret['filename'] = $nameunic . '.' . $fileExtension;

        $dret['ext'] = $fileExtension;
        return $dret;
    }

}
