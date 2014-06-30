<?php

class Admin_ConfiguracoesController extends Coringa_Controller_Admin_Action {

    public function init() {
        parent::noRender();
        $db = new Admin_Model_DbTable_Conf_Geral();
        $this->data = $db->getConf();
    }

    public function basicConfAction() {
        $this->render('basic');
    }

    public function imageConfAction() {
        $this->render('image');
    }

    public function alterarAction() {
        $db = new Admin_Model_DbTable_Conf_Geral();
        $request = $this->getRequest();
        if ($request->isPost()) {
            $dados = $request->getPost();
            $retorno = $db->update($dados, "cod_conf_geral=1");
        }
    }

    public function uploadAction() {
        $request = $this->getRequest();
        $dados = $request->getPost();
        switch ($dados['tipo_upload']) {
            default:
                $upload = new Admin_Model_UploadImage();
                $upload->setFolder();
                $result = $upload->sendFile($_FILES);
                echo $result;
                break;
        }
    }

    public function uploadBgAction() {
        $request = $this->getRequest();
        $dados = $request->getPost();
        $upload = new Admin_Model_UploadImage();
        $upload->setFolder();
        $result = $upload->sendFileBg($_FILES);
        echo '$(".btn-clear").click();$("#bg_image").val("' . $result . '");$(".bgpage").attr("style","background:url(/' . $result . ') no-repeat center 100%");';
    }

    public function excludeImgAction() {
        $request = $this->getRequest();
        $dados = $request->getPost();
        $pasta = explode("/", $dados['arquivo']);
        unset($pasta[(count($pasta) - 1)]);
        $pasta = implode("/", $pasta);
        $fb = str_replace("index.php", "", $_SERVER['SCRIPT_FILENAME']);

        $arq = str_replace($pasta . '/', '', $dados['arquivo']);
        $ext = substr($arq, -3);
        $arqname = str_replace("." . $ext, '', $arq);

        $tipos = array("_thumb", "_big", "_small", "_large", "_medium", "_list");
        foreach ($tipos as $tipo) {
            $arq_tmp = $fb . $pasta . '/' . $arqname . $tipo . '.' . $ext;

            if (is_file($arq_tmp)) {

                unlink($arq_tmp);
            }
        }
        unlink($fb . $dados['arquivo']);


        echo '$(".bootbox").modal("hide");listaGallery("img","' . $pasta . '");';
    }

    public function imageWidgetAction() {
        session_start();
        $request = $this->getRequest();
        if ($request->isPost()) {
            $dados = $request->getPost();
            switch ($dados['tipo']) {
                case 'google':
                    $this->view->widget = '/configuracoes/widgets/google.phtml';
                    break;
                case 'flickr':
                    if (isset($_SESSION['phpFlickr_auth_token'])) {
                        $flickr = new Admin_Model_Flickr();
                        $this->view->images = $flickr->getImages();
                    }
                    $this->view->flickr = $_SESSION['phpFlickr_auth_token'];
                    $this->view->widget = '/configuracoes/widgets/flickr.phtml';
                    break;
                default:
                    $this->view->widget = '/configuracoes/widgets/image.phtml';
                    break;
            }
            $this->render("images-widget");
        }
    }

    /*
     * FLICKR API
     */

    public function flickrAction() {
        session_start();
        $flickr = new Admin_Model_Flickr();
        $this->view->flickr = $_SESSION['phpFlickr_auth_token'];
        $params = $this->getRequest()->getParams();
        if ($params['tipo'] == 'upload') {
            if (count($_FILES['img_artigo']) > 0) {
                $flickr->upload($_FILES['img_artigo']['tmp_name']);
            }
        }
        if (strlen($params['delete']) > 0) {
            $flickr->delete($params['delete']);
        }
        if ($params['tipo'] == 'search') {
            echo $flickr->search($params['search-img']);
            exit;
        }
        if ($params['frob'] > 0) {
            echo $flickr->setReturn($params['frob']);
        }
        if ($params['login'] == 'true') {
            echo $flickr->getAccess();
        }
    }

    /*
     * GOOGLE API
     */

    public function googleAction() {
        $params = $this->getRequest()->getParams();
        $search = $this->getRequest()->getParam('search-img');
        if ($params['search-from'] == 'google') {
            echo 'listaGoogle("' . $search . '",30);';
        }
    }

    public function copyImgAction() {
        $params = $this->getRequest()->getParam('imagem');
        $upload = new Admin_Model_UploadImage();
        $upload->setFolder();
        echo $upload->copyFile($params);
    }

    public function addCategoriaAction() {
        $params = $this->getRequest();
        $dd = $params->getPost();
        $dados['nom_categoria'] = $dd['addcat'];
        $dbc = new Admin_Model_DbTable_Categoria();
        $insert = $dbc->insert($dados);
        if ($insert > 0) {
            echo "$('.categoria-body').append('<div class=\"form-group\"><label class=\"checkbox\">";
            echo '<input class="catsel" type="checkbox" name="id_categoria[]" id="id_categoria" value="' . $insert . '" />';
            echo ucwords($dd['addcat']);
            echo '</label></div>';
            echo "');";
        }
    }

    public function thumbAction() {
        $params = $this->getRequest()->getParams();
        $thumb = new Admin_Model_UploadImage();
        $thumb->setFolder();
        echo $thumb->copyFile($params['url'], 'thumb');
    }

    /*
     * GALERIA DE IMAGENS
     */

    public function galeriaAction() {
        $this->noRender();
        $files = $_FILES;
        $gallery = new Admin_Model_UploadGallery();
        $gallery->setFolder();
        $dados = $gallery->sendFile($files);
        echo '{"files":[{'
        . '"url": "' . $dados['url'] . '",'
        . '"thumbnailUrl": "' . $dados['thumb'] . ' ",'
        . '"name": "' . $dados['filename'] . '",'
        . '"type": "' . $files['files']['type'] . '",'
        . '"size": ' . $files['files']['size'] . ','
        //. '"deleteUrl": "/arquivos/galeria-exclude/",'
        . '"deleteType": "DELETE"'
        . '}]}';
    }

    public function galeriaExcludeAction() {
        $this->noRender();
        $dados = $this->getRequest()->getPost();
        $db = new Admin_Model_DbTable_Galeria();
        $select = $db->select();
        $select->where("cod_galeria=?", $dados['codimg']);
        $data = $db->fetchRow($select);

        $modes = array("", "_big", "_thumb", "_list", "_medium", "_gallery");
        foreach ($modes as $mode) {
            $fb = str_replace('index.php', '', $_SERVER['SCRIPT_FILENAME']);
            $arquivo = $fb . $data['nom_pasta'] . $data['nom_imagem'] . $mode . '.' . $data['ext_imagem'];
            if (is_file($arquivo)) {
                unlink($arquivo);
            }
        }
        $db->delete("cod_galeria=" . $dados['codimg']);
    }

    /*
     * SOUNDCLOUD API
     */

    public function soundCloudAction() {

        session_start();
        $this->noRender();
        require_once '../library/Coringa/Soundcloud.php';

        if (!isset($_SESSION['sound_token'])) {
            // create client object with app credentials
            $client = new Services_Soundcloud('97618e871411a2ccbd0c25a5df08e7e4', '746ab6b44080196e0da0396bf015e82a', 'http://admin.rodrigodaniel.com.br/configuracoes/sound-confirm');
            // redirect user to authorize URL
            $this->view->link = $client->getAuthorizeUrl();
        }
        else {
            // create a client object with access token
            $client = new Services_Soundcloud('97618e871411a2ccbd0c25a5df08e7e4', '746ab6b44080196e0da0396bf015e82a', 'http://admin.rodrigodaniel.com.br/configuracoes/sound-confirm');
            $client->setAccessToken($_SESSION['sound_token']['access_token']);

            try {

                $me = json_decode($client->get('me'), true);
                $tracks = json_decode($client->get('me/tracks'));
            } catch (Services_Soundcloud_Invalid_Http_Response_Code_Exception $e) {
                var_dump($e->getMessage());
                session_destroy();
                exit();
            }
        }
        $this->view->tracks = $tracks;
        $this->render("soundcloud");
    }

    public function soundConfirmAction() {
        require_once '../library/Coringa/Soundcloud.php';
        session_start();
        $this->noRender();
        // create client object with app credentials
        $client = new Services_Soundcloud('97618e871411a2ccbd0c25a5df08e7e4', '746ab6b44080196e0da0396bf015e82a', 'http://admin.rodrigodaniel.com.br/configuracoes/sound-confirm');
        // exchange authorization code for access token
        $code = $_GET['code'];
        try {
            $accessToken = $client->accessToken($code);
            try {
                $me = json_decode($client->get('me'), true);
            } catch (Services_Soundcloud_Invalid_Http_Response_Code_Exception $e) {
                var_dump($e->getMessage());
                exit();
            }
        } catch (Services_Soundcloud_Invalid_Http_Response_Code_Exception $e) {
            var_dump($e->getMessage());
            exit();
        }
        $_SESSION['sound_token'] = $accessToken;

        echo "<script>";
        echo "window.opener.$(document).ready(function(){";
        echo "window.opener.soundcloud.call();";
        echo "window.close();";


        echo " });";
        echo "</script>";
    }

    public function searchScAction() {
        require_once '../library/Coringa/Soundcloud.php';
        session_start();
        $this->noRender();
        $params = $this->getRequest()->getParams();
        $busca = str_replace('%20', ',', urlencode($params['busca']));
        // create a client object with access token
        $client = new Services_Soundcloud('97618e871411a2ccbd0c25a5df08e7e4', '746ab6b44080196e0da0396bf015e82a', 'http://admin.rodrigodaniel.com.br/configuracoes/sound-confirm');
        $client->setAccessToken($_SESSION['sound_token']['access_token']);
        try {
            $me = json_decode($client->get('me'), true);
            $tracks = json_decode($client->get('tracks', array('q' => $busca)));
            $this->view->tracks = $tracks;
            $this->render("scbusca");
        } catch (Services_Soundcloud_Invalid_Http_Response_Code_Exception $e) {
            var_dump($e->getMessage());
            exit();
        }
    }

    public function uploadScAction() {
        $fb = str_replace('index.php', '', $_SERVER['SCRIPT_FILENAME']);

        $folder = $fb . 'audio/';
        require_once '../library/Coringa/Soundcloud.php';
        session_start();
        $this->noRender();
        // create a client object with access token
        $client = new Services_Soundcloud('97618e871411a2ccbd0c25a5df08e7e4', '746ab6b44080196e0da0396bf015e82a', 'http://admin.rodrigodaniel.com.br/configuracoes/sound-confirm');
        $client->setAccessToken($_SESSION['sound_token']['access_token']);
        $fn = $_FILES['file_sc']['name'];
        $ext = substr($fn, -3);
        $filename = str_replace("." . $ext, '', $fn);
        $filename = md5($filename) . '.' . $ext;
        $fname = $filename;
        $filename = $folder . $filename;

        if (move_uploaded_file($_FILES['file_sc']['tmp_name'], $filename)) {
            echo "console.log('codificando...');";
            // $this->_redirect('/configuracoes/codifica-sc/?file=' . $fname . '&titulo=' . urlencode($_POST['nom_musica']));
            echo "soundcloud.codifica('" . $fname . "','" . $_POST['nom_musica'] . "');";
        }
    }

    public function codificaScAction() {
        set_time_limit(3600);
        $fb = str_replace('index.php', '', $_SERVER['SCRIPT_FILENAME']);
        $folder = $fb . 'audio/';
        require_once '../library/Coringa/Soundcloud.php';
        session_start();
        $this->noRender();
        $params = $this->getRequest()->getParams();
        // create a client object with access token
        $client = new Services_Soundcloud('97618e871411a2ccbd0c25a5df08e7e4', '746ab6b44080196e0da0396bf015e82a', 'http://admin.rodrigodaniel.com.br/configuracoes/sound-confirm');
        $client->setAccessToken($_SESSION['sound_token']['access_token']);
        //       try {
        // upload audio file
        $track = array(
            'track[title]' => $params['titulo'],
            'track[tags]' => 'personal',
            'track[asset_data]' => '@' . $folder . $params['file']
        );

        try {
            $response = $client->post('tracks', $track);
            echo "soundcloud.call()";
        } catch (Services_Soundcloud_Invalid_Http_Response_Code_Exception $e) {
            exit($e->getMessage());
        }
    }

    public function deleteScAction() {
        $fb = str_replace('index.php', '', $_SERVER['SCRIPT_FILENAME']);
        $folder = $fb . 'media/tmp/';
        require_once '../library/Coringa/Soundcloud.php';
        session_start();
        $this->noRender();
        $params = $this->getRequest()->getParams();
        // create a client object with access token
        $client = new Services_Soundcloud('97618e871411a2ccbd0c25a5df08e7e4', '746ab6b44080196e0da0396bf015e82a', 'http://admin.rodrigodaniel.com.br/configuracoes/sound-confirm');
        $client->setAccessToken($_SESSION['sound_token']['access_token']);
        try {

            $track = json_decode($client->delete('tracks/' . $params['audio_id']));
            echo 'soundcloud.call();';
        } catch (Exception $e) {
            var_dump($e->getMessage());
            exit;
        }
    }

    public function editScAction() {
        require_once '../library/Coringa/Soundcloud.php';
        session_start();
        $this->noRender();
        $params = $this->getRequest()->getParams();
        // create a client object with access token
        $client = new Services_Soundcloud('97618e871411a2ccbd0c25a5df08e7e4', '746ab6b44080196e0da0396bf015e82a', 'http://admin.rodrigodaniel.com.br/configuracoes/sound-confirm');
        $client->setAccessToken($_SESSION['sound_token']['access_token']);

        $track = json_decode($client->put('tracks/' . $params['id_audio'], array(
                    'track[title]' => $params['nom_audio'],
                    'track[description]' => $params['des_audio'],
        )));
    }

    public function formEditScAction() {
        $this->noRender();
        require_once '../library/Coringa/Soundcloud.php';
        session_start();
        $this->noRender();
        $params = $this->getRequest()->getParams();
        // create a client object with access token
        $client = new Services_Soundcloud('97618e871411a2ccbd0c25a5df08e7e4', '746ab6b44080196e0da0396bf015e82a', 'http://admin.rodrigodaniel.com.br/configuracoes/sound-confirm');
        $client->setAccessToken($_SESSION['sound_token']['access_token']);
        try {
            $tracks = json_decode($client->get('tracks/' . $params['audio_id']));
            $this->view->audio = $tracks;
        } catch (Exception $ex) {
            var_dump($ex);
        }
        $this->render("form-edit-sc");
    }

}

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

