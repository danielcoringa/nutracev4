<?php

/**
 * Description of Security
 * @category   PubliqueAnuncios
 * @package    Coringa_Controller
 * @copyright  Copyright (c) 2013-2013 CoringaSistemas INC (http://www.coringasistemas.com.br)
 */
class Admin_Model_UploadImage {

    public function init() {

    }

    /**
     * Seta a pasta do upload
     * @param varchar $this->folder
     */
    public function setFolder() {
        $fb = str_replace('index.php', '', $_SERVER['SCRIPT_FILENAME']);
        $folder = $fb . 'media/blog/';
        if (is_dir($folder . date('Y'))) {
            $folder = $folder . date('Y') . '/';
        }
        else {
            mkdir($folder . date('Y'));
            $folder = $folder . date('Y') . '/';
        }
        if (is_dir($folder . date('m'))) {
            $folder = $folder . date('m') . '/';
        }
        else {
            mkdir($folder . date('m'));
            $folder = $folder . date('m') . '/';
        }
        $this->folder = $folder;
        $this->folder_clean = substr(str_replace($fb, '', $folder), 0, -1);
    }

    /**
     * Retorna a pasta do upload
     * @param varchar $this->folder
     * @return varchar
     */
    public function getFolder() {
        return $this->folder;
    }

    public function sendFileBg($fls) {
        $nc = str_replace(' ', '_', microtime());
        $fb = str_replace('index.php', '', $_SERVER['SCRIPT_FILENAME']);
        $nameunic = str_replace('.', '_', $nc);
        $targetFile = $this->folder . $nameunic;

        $fileExtension = substr($fls['bgimage']['name'], -3);
        // Chama a classe de Imagens
        $sImage = new Admin_Model_SimpleImage();
        $sImage->load($fls['bgimage']['tmp_name']);

        $tFile = $targetFile . '.' . $fileExtension;
        $sImage->save($tFile);


        $arquivo = str_replace($fb, '', $tFile);
        return $arquivo;
    }

    public function sendFile($fls) {
        $dbc = new Admin_Model_DbTable_Conf_Geral();
        $this->conf = $dbc->getConf();
        // Varre os arquivos enviados
        foreach ($fls as $key => $files) {
            // Cria o nome unico para os arquivos

            $nc = str_replace(' ', '_', microtime());
            $nameunic = str_replace('.', '_', $nc);
            $targetFile = $this->folder . $nameunic;

            $fileExtension = substr($files['name'], -3);
            // Chama a classe de Imagens
            $sImage = new Admin_Model_SimpleImage();
            $sImage->load($files['tmp_name']);

            $tFile = $targetFile;
            $sImage->save($tFile . '.' . $fileExtension);
            $nameclean = $this->folder_clean . '/' . $nameunic . '.' . $fileExtension;
            if ($this->conf['ind_img_big'] == 'A') {
                $sImage->resizeToWidth($this->conf['img_big_w'] + 0);
                $tFile = $targetFile . '_big';
                $sImage->save($tFile . '.' . $fileExtension);
            }
            if ($this->conf['ind_img_large'] == 'A') {
                $sImage->resizeToWidth($this->conf['img_large_w'] + 0);
                $tFile = $targetFile . '_large';
                $sImage->save($tFile . '.' . $fileExtension);
            }
            if ($this->conf['ind_img_medium'] == 'A') {
                $sImage->resizeToWidth($this->conf['img_medium_w'] + 0);
                $tFile = $targetFile . '_medium';
                $sImage->save($tFile . '.' . $fileExtension);
            }
            if ($this->conf['ind_img_small'] == 'A') {
                $sImage->resizeToWidth($this->conf['img_small_w'] + 0);
                $tFile = $targetFile . '_small';
                $sImage->save($tFile . '.' . $fileExtension);
            }
            if ($this->conf['ind_img_thumbnail'] == 'A') {
                $sImage->resizeToWidth($this->conf['img_thumbnail_w'] + 0);
                $tFile = $targetFile . '_thumb';
                $sImage->save($tFile . '.' . $fileExtension);
            }
            if ($this->conf['ind_img_list'] == 'A') {
                $sImage->resizeToWidth($this->conf['img_list_w'] + 0);
                $tFile = $targetFile . '_list';
                $sImage->save($tFile . '.' . $fileExtension);
            }
            echo '$(".server").click();$(".btn-clear").click();$.cookie("selected","' . $nameclean . '");setTimeout(function(){listaGallery("img", "' . $this->folder_clean . '")},1000);';
        }
    }

    public function copyFile($file, $ret = null) {
        $dbc = new Admin_Model_DbTable_Conf_Geral();
        $this->conf = $dbc->getConf();
        $nc = str_replace(' ', '_', microtime());
        $nameunic = str_replace('.', '_', $nc);
        $targetFile = $this->folder . $nameunic;

        $fileExtension = substr($file, -3);
        // Chama a classe de Imagens
        $sImage = new Admin_Model_SimpleImage();
        $sImage->load($file);

        $tFile = $targetFile;
        $sImage->save($tFile . '.' . $fileExtension);
        $nameclean = $this->folder_clean . '/' . $nameunic . '.' . $fileExtension;
        $namefile = $this->folder_clean . '/' . $nameunic . '_medium.' . $fileExtension;
        if ($this->conf['ind_img_big'] == 'A') {
            $sImage->resizeToWidth($this->conf['img_big_w'] + 0);
            $tFile = $targetFile . '_big';
            $sImage->save($tFile . '.' . $fileExtension);
        }
        if ($this->conf['ind_img_large'] == 'A') {
            $sImage->resizeToWidth($this->conf['img_large_w'] + 0);
            $tFile = $targetFile . '_large';
            $sImage->save($tFile . '.' . $fileExtension);
        }
        if ($this->conf['ind_img_medium'] == 'A') {

            $sImage->resizeToWidth($this->conf['img_medium_w'] + 0);
            $tFile = $targetFile . '_medium';
            $sImage->save($tFile . '.' . $fileExtension);
        }
        if ($this->conf['ind_img_small'] == 'A') {
            $sImage->resizeToWidth($this->conf['img_small_w'] + 0);
            $tFile = $targetFile . '_small';
            $sImage->save($tFile . '.' . $fileExtension);
        }
        if ($this->conf['ind_img_thumbnail'] == 'A') {
            $sImage->resizeToWidth($this->conf['img_thumbnail_w'] + 0);
            $tFile = $targetFile . '_thumb';
            $sImage->save($tFile . '.' . $fileExtension);
        }
        if ($this->conf['ind_img_list'] == 'A') {
            $sImage->resizeToWidth($this->conf['img_list_w'] + 0);
            $tFile = $targetFile . '_list';
            $sImage->save($tFile . '.' . $fileExtension);
        }
        if ($ret == null) {
            echo '$(".server").click();$(".btn-clear").click();$.cookie("selected","' . $nameclean . '");setTimeout(function(){listaGallery("img", "' . $this->folder_clean . '")},1000);';
        }
        else {

            echo $namefile;
        }
    }

}
