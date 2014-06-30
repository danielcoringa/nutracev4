<?php

class Admin_Model_Flickr {

    public function __construct() {
        session_start();
        require_once("../library/Coringa/phpFlickr/phpFlickr.php");
    }

    public function getAccess() {

// Create new phpFlickr object
        $f = new phpFlickr("a596d0ee3afb48aa81730f1ce1077d6e", "1752994e61eede81");
        $f->auth('delete');
        $token = $f->auth_checkToken();
    }

    public function setReturn($cod) {

        //$f = new phpFlickr("a596d0ee3afb48aa81730f1ce1077d6e", "1752994e61eede81");
        $f = new phpFlickr("a596d0ee3afb48aa81730f1ce1077d6e", "1752994e61eede81");
        $token = $f->auth_getToken($cod);

        return "<script>window.opener.console.log('$token');window.opener.flickrFunc();window.close();</script>";
    }

    public function upload($file) {
        $f = new phpFlickr("a596d0ee3afb48aa81730f1ce1077d6e", "1752994e61eede81");
        $f->auth('delete');
        $token = $f->auth_checkToken();
        if ($upload = $f->sync_upload($file)) {
            echo '$(".btn-clear").click(); flickrFunc();';
        };
    }

    public function delete($id) {
        $f = new phpFlickr("a596d0ee3afb48aa81730f1ce1077d6e", "1752994e61eede81");
        $f->auth('delete');
        $token = $f->auth_checkToken();
        if ($upload = $f->photos_delete($id)) {
            echo 'Messenger().post({message: "Imagem Excluida do Flickr com Sucesso!", type: "success"})';
        }
        else {
            echo 'Messenger().post({message: "Erro ao Excluir imagem do Flickr!", type: "danger"});flickrFunc();';
        }
    }

    public function getImages() {
        $f = new phpFlickr("a596d0ee3afb48aa81730f1ce1077d6e", "1752994e61eede81");
        $f->auth('delete');
        $token = $f->auth_checkToken();
        $nsid = $token['user']['nsid'];

// Get the friendly URL of the user's photos
        $photos_url = $f->urls_getUserPhotos($nsid);

// Get the user's first 36 public photos
        $photos = $f->photos_search(array("user_id" => $nsid));

// Loop through the photos and output the html
        $html = '';
        foreach ((array) $photos['photo'] as $photo) {
            $html.='<div class="col-sm-2" id="' . $photo['id'] . '">' .
                    '<div class="box-container dropdown">' .
                    '   <div class="box dropdown-toggle  btn btn-icon" data-toggle="dropdown">' .
                    '       <div class="img-library">' .
                    '           <img src="' . $f->buildPhotoURL($photo, "Thumbnail") . '" class="col-sm-12 " />' .
                    '       </div>' .
                    '       <div class="center-title center ellipse blue">' . $photo[title] . '</div>' .
                    '   </div>' .
                    '   <ul class="dropdown-menu">' .
                    '       <li><a href="javascript:;" onclick="addImgEditor(\'' . $f->buildPhotoURL($photo, "Large") . '\',\'f\',$(this).parent(),\'' . $f->buildPhotoURL($photo, "Medium") . '\');"><i class="fa fa-edit"></i> Anexar Imagem no Editor</a></li>' .
                    '       <li><a href="' . $f->buildPhotoURL($photo, "Large") . '" class="color-box" title="' . $photo[title] . '"><i class="fa fa-eye"></i> Previsualizar</a></li>' .
                    '       <li><a href="javascript:delImgF(\'' . $photo['id'] . '\');"><i class="fa fa-trash-o"></i> Excluir</a></li>' .
                    '   </ul>' .
                    '</div></div>';


            $i++;
            // If it reaches the sixth photo, insert a line break
            if ($i % 6 == 0) {

            }
        }
        $html.='';


        return $html;
    }

    public function search($query) {
        $f = new phpFlickr("a596d0ee3afb48aa81730f1ce1077d6e", "1752994e61eede81");
        $query = str_replace(" ", ",", $query);

        $photos = $f->photos_search(array("tags" => $query, "sort" => "interestingness-desc", "per_page" => 30, "tag_mode" => "any"));

        $html = '';
        foreach ((array) $photos['photo'] as $photo) {
            $html.='<div class="col-sm-2">' .
                    '<div class="box-container dropdown">' .
                    '   <div class="box dropdown-toggle  btn btn-icon" data-toggle="dropdown">' .
                    '       <div class="img-library">' .
                    '           <img src="' . $f->buildPhotoURL($photo, "Thumbnail") . '" class="col-sm-12 " />' .
                    '       </div>' .
                    '       <div class="center-title center ellipse blue">' . $photo[title] . '</div>' .
                    '   </div>' .
                    '   <ul class="dropdown-menu">' .
                    '       <li><a href="javascript:;" onclick="addImgEditor(\'' . $f->buildPhotoURL($photo, "Large") . '\',\'fc\',$(this).parent(),\'' . $f->buildPhotoURL($photo, "Medium") . '\');"><i class="fa fa-edit"></i> Anexar Imagem no Editor</a></li>' .
                    '       <li><a href="javascript:;" onclick="copyImg(\'' . $f->buildPhotoURL($photo, "Large") . '\');"><i class="fa fa-download"></i> Salvar no Server</a></li>' .
                    '       <li><a href="javascript:delImgF(\'' . $photo['id'] . '\');"><i class="fa fa-trash-o"></i> Excluir</a></li>' .
                    '   </ul>' .
                    '</div></div>';

            $i++;
            // If it reaches the sixth photo, insert a line break
            if ($i % 6 == 0) {

            }
        }
        $html.='';


        return $query . $html;
    }

}
