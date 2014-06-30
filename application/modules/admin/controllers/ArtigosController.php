<?php

class Admin_ArtigosController extends Coringa_Controller_Admin_Action {
    /*
     * To change this license header, choose License Headers in Project Properties.
     * To change this template file, choose Tools | Templates
     * and open the template in the editor.
     */

    public function init() {
        parent::init();
    }

    public function indexAction() {
        $_SESSION['teste'] = 'teste';
    }

    public function cadastroAction() {
        $dbc = new Admin_Model_DbTable_Categoria();
        $this->view->categorias = $dbc->getSelect();
        $db = new Admin_Model_DbTable_Artigo();
        $params = $this->getRequest()->getParams();
        $request = $this->getRequest();
        if ($request->isPost()) {
            parent::noRender();
            $dados = $request->getPost();

            $insert = $db->inserir($dados);
            if ($insert > 0) {
                echo 'Messenger().post({message: "Registro Salvo com Sucesso.", type: "success"});setTimeout(function(){$(".bootbox").modal("hide");},3000);';
            }
            else {
                echo 'Messenger().post({message: "Erro ao Salvar o Registro tente novamente.", type: "error"});$(".bootbox").modal("hide");';
            }
            exit;
        }
        if (isset($params['editar'])) {
            $dados = $db->getDados($params['editar']);
            $this->view->data = $dados;
        }
    }

    public function cadastroTmpAction() {
        session_start();
        $dbc = new Admin_Model_DbTable_Categoria();
        $db = new Admin_Model_DbTable_Artigo();
        $this->view->categorias = $dbc->getSelect();
        $params = $this->getRequest()->getParams();
        $request = $this->getRequest();

        if ($request->isPost()) {
            $dados = $request->getPost();
            $this->noRender();
            // Salva os registros na tabela de artigos
            if (!isset($params['editar'])) {
                $inserir = $db->inserir($dados);
                if (count($_FILES) > 0) {
                    //verifica se o artigo foi salvo
                    $upload = new Admin_Model_UploadImage();
                    $upload->setFolder();
                    $upload->sendFile($_FILES, $inserir, $dados);
                }
                if (!isset($_FILES['bg_image'])) {
                    $dbc = new Admin_Model_DbTable_Conf_Artigo();
                    $datac['cod_artigo'] = $inserir;
                    $datac['bg_color'] = $dados['bg_color'];
                    $datac['bg_repeat'] = $dados['bg_repeat'];
                    $datac['bg_position'] = $dados['bg_position'];
                    $datac['bg_size'] = $dados['bg_size'];
                    $datac['sidebar'] = $dados['sidebar'];
                    $datac['bgcolor_meta'] = $dados['bgcolor_meta'];
                    $datac['bg_pattern'] = $dados['bg_pattern'];
                    $dbc->insert($datac);
                }
            }
            else {
                $dados = $request->getPost();
                $update = $db->atualizar($dados, 'cod_artigo=' . $params['editar']);
                if (count($_FILES) > 0) {
                    //verifica se o artigo foi salvo
                    $upload = new Admin_Model_UploadImage();
                    $upload->setFolder();
                    $upload->sendFile($_FILES, $params['editar'], $dados);
                }
                if (!isset($_FILES['bg_image'])) {
                    $dbc = new Admin_Model_DbTable_Conf_Artigo();
                    if ($dados['bg_image_check'] == '') {
                        $datac['bg_image'] = '';
                    }
                    $datac['bg_color'] = $dados['bg_color'];
                    $datac['bg_repeat'] = $dados['bg_repeat'];
                    $datac['bg_position'] = $dados['bg_position'];
                    $datac['bg_size'] = $dados['bg_size'];
                    $datac['sidebar'] = $dados['sidebar'];
                    $datac['bgcolor_meta'] = $dados['bgcolor_meta'];
                    $datac['bg_pattern'] = $dados['bg_pattern'];
                    $dbc->update($datac, 'cod_artigo=' . $params['editar']);
                }
            }
            echo 'artigos';
        }
        if (isset($params['editar'])) {
            $dados = $db->getDados($params['editar']);
            $this->view->data = $dados;
        }
    }

    public function listaAction() {
        $this->noRender();
        $db = new Admin_Model_DbTable_Artigo();
        echo $db->grid($_GET['sEcho']);
    }

    public function getCodeAction() {
        session_name("youtube");
        session_start();
        $this->noRender();
        $params = $this->getRequest()->getParams();
        $client = new Coringa_Google_Client();
        $client->setApplicationName('rd-youtube');
// Visit https://code.google.com/apis/console?api=plus to generate your
// client id, client secret, and to register your redirect uri.
        $client->setClientId('1044219149899-nkamhugmd5i9dir0uh2pp7tr1ovjkq6n.apps.googleusercontent.com');
        $client->setClientSecret('Y5Jn_b11f74sJjiWrX3fTZhk');
        $client->setRedirectUri('http://admin.rodrigodaniel.com.br/artigos/get-code');
        $client->setDeveloperKey('AIzaSyDTP2rhrqjGTt_wvq2fg71sJC5wQ9ZaMz8');
        $scopes = array("https://gdata.youtube.com&access_type=offline");
        $client->setScopes($scopes);
        //$plus = new Coringa_Google_PlusService($client);

        if (isset($params['code'])) {

            $client->authenticate();
            $at = json_decode($client->getAccessToken(), true);

            $session_token = $at['access_token'];
            // Store the session token in our session.


            $_SESSION['token'] = $session_token;
            // print_r($_SESSION);
            echo "<script> "
            . "window.opener.callYoutube();"
            . "window.close();"
            . "</script>";
        }
    }

    public function youtubeAction() {
        session_name("youtube");
        session_start();
        $this->noRender();
        $yt = new Admin_Model_Youtube();
        $yt->setDefault();
        $this->view->feed = $yt->getVideoFeed();
        $this->render("youtube");
    }

    public function searchYtAction() {
        $busca = $this->getRequest()->getParam("busca");
        session_name("youtube");
        session_start();
        $this->noRender();
        $yt = new Admin_Model_Youtube();
        $yt->setDefault();
        $yt->setBusca($busca);
        $this->view->feeds = $yt->getVideoFeed();
        $this->render('ytbusca');
    }

    public function uploadYtAction() {

        session_name("youtube");
        session_start();
        header('Access-Control-Allow-Origin: *');
        $this->noRender();
        require_once 'Zend/Loader.php'; // the Zend dir must be in your include_path
        Zend_Loader::loadClass('Zend_Gdata_YouTube');
        $applicationId = 'rd-youtube';
        $clientId = '1044219149899-nkamhugmd5i9dir0uh2pp7tr1ovjkq6n.apps.googleusercontent.com';
        $developerKey = 'AIzaSyDTP2rhrqjGTt_wvq2fg71sJC5wQ9ZaMz8';
        $token = urldecode('Y5Jn_b11f74sJjiWrX3fTZhk');

        $authenticationURL = 'https://www.google.com/accounts/ClientLogin';
        $client = Zend_Gdata_AuthSub::getHttpClient($_SESSION['token']);


        $yt = new Zend_Gdata_YouTube($client, $applicationId, $clientId, $developerKey);
        $myid = substr(md5(uniqid()), 0, 8);
        $myVideoEntry = new Zend_Gdata_YouTube_VideoEntry();
        $myVideoEntry->setVideoTitle('VT_' . $myid);
        $myVideoEntry->setVideoDescription('Aguardando Descrições');
        // Note that category must be a valid YouTube category
        $myVideoEntry->setVideoCategory('Film');
        $myVideoEntry->SetVideoTags('Video');
        $tokenHandlerUrl = 'http://gdata.youtube.com/action/GetUploadToken';
        $tokenArray = $yt->getFormUploadToken($myVideoEntry, $tokenHandlerUrl);
        $this->view->tokenValue = $tokenArray['token'];
        $this->view->postUrl = $tokenArray['url'];
        $this->view->nextUrl = 'http://admin.rodrigodaniel.com.br/artigos/sucesso-yt';
        $this->render('ytupload');
    }

    public function sucessoYtAction() {
        $this->noRender();
        header('Access-Control-Allow-Origin: *');
        echo "Sucesso!";
    }

    public function deleteYtAction() {
        $this->noRender();
        $params = $this->getRequest()->getParams();
        session_name("youtube");
        session_start();
        header('Access-Control-Allow-Origin: *');
        $this->noRender();
        require_once 'Zend/Loader.php'; // the Zend dir must be in your include_path
        Zend_Loader::loadClass('Zend_Gdata_YouTube');
        $applicationId = 'rd-youtube';
        $clientId = '1044219149899-nkamhugmd5i9dir0uh2pp7tr1ovjkq6n.apps.googleusercontent.com';
        $developerKey = 'AIzaSyDTP2rhrqjGTt_wvq2fg71sJC5wQ9ZaMz8';
        $token = urldecode('Y5Jn_b11f74sJjiWrX3fTZhk');

        $authenticationURL = 'https://www.google.com/accounts/ClientLogin';
        $client = Zend_Gdata_AuthSub::getHttpClient($_SESSION['token']);


        $yt = new Zend_Gdata_YouTube($client, $applicationId, $clientId, $developerKey);
        $videoEntry = $yt->getFullVideoEntry($params['video_id']);
        $delete = $yt->delete($videoEntry);
        echo "callYoutube();";
    }

    public function formEditYtAction() {
        $this->noRender();
        $params = $this->getRequest()->getParams();
        session_name("youtube");
        session_start();
        header('Access-Control-Allow-Origin: *');
        $this->noRender();
        require_once 'Zend/Loader.php'; // the Zend dir must be in your include_path
        Zend_Loader::loadClass('Zend_Gdata_YouTube');
        $applicationId = 'rd-youtube';
        $clientId = '1044219149899-nkamhugmd5i9dir0uh2pp7tr1ovjkq6n.apps.googleusercontent.com';
        $developerKey = 'AIzaSyDTP2rhrqjGTt_wvq2fg71sJC5wQ9ZaMz8';
        $token = urldecode('Y5Jn_b11f74sJjiWrX3fTZhk');

        $authenticationURL = 'https://www.google.com/accounts/ClientLogin';
        $client = Zend_Gdata_AuthSub::getHttpClient($_SESSION['token']);


        $yt = new Zend_Gdata_YouTube($client, $applicationId, $clientId, $developerKey);
        $videoEntry = $yt->getFullVideoEntry($params['video_id']);
        $this->view->entry = $videoEntry;
        $this->view->videoID = $params['video_id'];
        $this->render("form-edit-yt");
    }

    public function editYtAction() {
        $this->noRender();
        $params = $this->getRequest()->getParams();
        session_name("youtube");
        session_start();
        header('Access-Control-Allow-Origin: *');
        $this->noRender();
        require_once 'Zend/Loader.php'; // the Zend dir must be in your include_path
        Zend_Loader::loadClass('Zend_Gdata_YouTube');
        $applicationId = 'rd-youtube';
        $clientId = '1044219149899-nkamhugmd5i9dir0uh2pp7tr1ovjkq6n.apps.googleusercontent.com';
        $developerKey = 'AIzaSyDTP2rhrqjGTt_wvq2fg71sJC5wQ9ZaMz8';
        $token = urldecode('Y5Jn_b11f74sJjiWrX3fTZhk');

        $authenticationURL = 'https://www.google.com/accounts/ClientLogin';
        $client = Zend_Gdata_AuthSub::getHttpClient($_SESSION['token']);


        $yt = new Zend_Gdata_YouTube($client, $applicationId, $clientId, $developerKey);
        $videoEntry = $yt->getFullVideoEntry($params['id_video']);

        $putUrl = $videoEntry->getEditLink()->getHref();
        $videoEntry->setVideoTitle($params['nom_video']);
        $videoEntry->setVideoDescription($params['des_video']);
        $yt->updateEntry($videoEntry, $putUrl);
    }

    public function vimeoAction() {
        $this->noRender();
        require_once('../library/Coringa/Vimeo/vimeo.php');
        session_name("vimeo");
        session_start();
        $vimeo = new phpVimeo('eb380c3c78bdf7496acea922fe17f70681a757da', '70ab97bd546efe7e591276cfa4a672dbdbf3558a');
        try {
            $vimeo->setToken($_SESSION['oauth_request_token'], $_SESSION['oauth_request_token_secret']);
            $videos = $vimeo->call('vimeo.videos.getAll');
            //$videos = $vimeo->call('vimeo.videos.search', array("query" => "shakira", "per_page" => 10));
            foreach ($videos->videos->video as $video) {
                $id = $video->id;
                $info = $vimeo->call("vimeo.videos.getInfo", array("video_id" => $id));
                $vds[] = $info->video;
            }
            $this->view->videos = $vds;
            //$this->view->videos = $vimeo->call('vimeo.videos.search', array("query" => "shakira"));
        } catch (Exception $e) {
            $this->authVimeo();
        }

        $this->render("vimeo");
    }

    public function searchVmAction() {
        $busca = $this->getRequest()->getParam("busca");
        $this->noRender();
        session_name("vimeo");
        session_start();
        require_once('../library/Coringa/Vimeo/vimeo.php');
        $vimeo = new phpVimeo('eb380c3c78bdf7496acea922fe17f70681a757da', '70ab97bd546efe7e591276cfa4a672dbdbf3558a');
        $vimeo->setToken($_SESSION['oauth_request_token'], $_SESSION['oauth_request_token_secret']);
        try {
            $vimeo->setToken($_SESSION['oauth_request_token'], $_SESSION['oauth_request_token_secret']);
            //$videos = $vimeo->call('vimeo.videos.getAll');
            $videos = $vimeo->call('vimeo.videos.search', array("query" => $busca, "per_page" => 10));
            foreach ($videos->videos->video as $video) {
                $id = $video->id;
                $info = $vimeo->call("vimeo.videos.getInfo", array("video_id" => $id));
                $vds[] = $info->video;
            }
            $this->view->videos = $vds;
            //$this->view->videos = $vimeo->call('vimeo.videos.search', array("query" => "shakira"));
        } catch (Exception $e) {
            $this->authVimeo();
        }

        $this->render("vmbusca");
    }

    public function vimeoConfirmAction() {
        $this->noRender();
        session_name("vimeo");
        session_start();
        $params = $this->getRequest()->getParams();
        require_once('../library/Coringa/Vimeo/vimeo.php');
        $vimeo = new phpVimeo('eb380c3c78bdf7496acea922fe17f70681a757da', '70ab97bd546efe7e591276cfa4a672dbdbf3558a');
        //$vimeo->setToken($_SESSION['oauth_request_token'], $_SESSION['oauth_request_token_secret']);
        $vimeo->setToken('a6527cd7df355a389267a884c33ef66b', 'bbbdc34c6064fce4a550792a35f62bc626e9a5f2');
        print_r($vimeo->call("vimeo.videos.getUploaded"));
        echo "<script>window.opener.callVimeo();window.close();</script>";
    }

    private function authVimeo() {
        session_name("vimeo");
        session_start();
        $vimeo = new phpVimeo('eb380c3c78bdf7496acea922fe17f70681a757da', '70ab97bd546efe7e591276cfa4a672dbdbf3558a');
        //$vimeo = new Coringa_Vimeo_Connect('eb380c3c78bdf7496acea922fe17f70681a757da', '70ab97bd546efe7e591276cfa4a672dbdbf3558a');
        $vimeo->enableCache(phpVimeo::CACHE_FILE, './cache', 300);
        // Set up variables
        $state = $_SESSION['vimeo_state'];
        $request_token = $_SESSION['oauth_request_token'];
        $access_token = $_SESSION['oauth_access_token'];

// Coming back
        if ($_REQUEST['oauth_token'] != NULL && $_SESSION['vimeo_state'] == 'start') {
            $_SESSION['vimeo_state'] = $state = 'returned';
        }

// If we have an access token, set it
        if ($_SESSION['oauth_access_token'] != null) {
            $vimeo->setToken($_SESSION['oauth_access_token'], $_SESSION['oauth_access_token_secret']);
        }

        switch ($_SESSION['vimeo_state']) {
            default:

                // Get a new request token
                $token = $vimeo->getRequestToken();

                // Store it in the session
                $_SESSION['oauth_request_token'] = $token['oauth_token'];
                $_SESSION['oauth_request_token_secret'] = $token['oauth_token_secret'];
                $_SESSION['vimeo_state'] = 'start';

                // Build authorize link
                $this->view->authorize_link = $vimeo->getAuthorizeUrl($token['oauth_token'], 'write');

                break;

            case 'returned':

                // Store it
                if ($_SESSION['oauth_access_token'] === NULL && $_SESSION['oauth_access_token_secret'] === NULL) {
                    // Exchange for an access token
                    $vimeo->setToken($_SESSION['oauth_request_token'], $_SESSION['oauth_request_token_secret']);
                    $token = $vimeo->getAccessToken($_REQUEST['oauth_verifier']);

                    // Store
                    $_SESSION['oauth_access_token'] = $token['oauth_token'];
                    $_SESSION['oauth_access_token_secret'] = $token['oauth_token_secret'];
                    $_SESSION['vimeo_state'] = 'done';

                    // Set the token
                    $vimeo->setToken($_SESSION['oauth_access_token'], $_SESSION['oauth_access_token_secret']);
                }

                // Do an authenticated call
                try {
                    $this->view->videos = $vimeo->call('vimeo.videos.getUploaded');
                } catch (VimeoAPIException $e) {
                    echo "Encountered an API error -- code {$e->getCode()} - {$e->getMessage()}";
                }

                break;
        }
    }

    public function uploadVmAction() {
        $this->noRender();
        session_name("vimeo");
        session_start();

        require_once('../library/Coringa/Vimeo/vimeo.php');
        $vimeo = new phpVimeo('eb380c3c78bdf7496acea922fe17f70681a757da', '70ab97bd546efe7e591276cfa4a672dbdbf3558a');
        try {
            $vimeo->setToken('a6527cd7df355a389267a884c33ef66b', 'bbbdc34c6064fce4a550792a35f62bc626e9a5f2');
            $video_id = $vimeo->upload($_FILES['file_vm']['tmp_name']);
            if ($video_id) {
                echo '<a href="http://vimeo.com/' . $video_id . '">Upload successful!</a>';
                //$vimeo->call('vimeo.videos.setPrivacy', array('privacy' => 'nobody', 'video_id' => $video_id));
                $vimeo->call('vimeo.videos.setTitle', array('title' => 'YOUR TITLE', 'video_id' => $video_id));
                $vimeo->call('vimeo.videos.setDescription', array('description' => 'YOUR_DESCRIPTION', 'video_id' => $video_id));
            }
            else {
                echo "Video file did not exist!";
            }
        } catch (VimeoAPIException $e) {
            echo "Encountered an API error -- code {$e->getCode()} - {$e->getMessage()}";
        }
    }

    public function formEditVmAction() {
        $this->noRender();
        $params = $this->getRequest()->getParams();
        require_once('../library/Coringa/Vimeo/vimeo.php');
        session_name("vimeo");
        session_start();
        $vimeo = new phpVimeo('eb380c3c78bdf7496acea922fe17f70681a757da', '70ab97bd546efe7e591276cfa4a672dbdbf3558a');
        try {
            //$vimeo->setToken($_SESSION['oauth_request_token'], $_SESSION['oauth_request_token_secret']);
            $vimeo->setToken('a6527cd7df355a389267a884c33ef66b', 'bbbdc34c6064fce4a550792a35f62bc626e9a5f2');
            $info = $vimeo->call("vimeo.videos.getInfo", array("video_id" => $params['video_id']));

            //$this->view->videos = $vimeo->call('vimeo.videos.search', array("query" => "shakira"));
        } catch (Exception $e) {
            $this->authVimeo();
        }
        $this->view->video = $info->video[0];
        $this->render("form-edit-vm");
    }

    public function editVmAction() {
        $this->noRender();
        $params = $this->getRequest()->getParams();
        require_once('../library/Coringa/Vimeo/vimeo.php');
        session_name("vimeo");
        session_start();
        $vimeo = new phpVimeo('eb380c3c78bdf7496acea922fe17f70681a757da', '70ab97bd546efe7e591276cfa4a672dbdbf3558a');
        try {
            // $vimeo->setToken($_SESSION['oauth_request_token'], $_SESSION['oauth_request_token_secret']);
            $vimeo->setToken('a6527cd7df355a389267a884c33ef66b', 'bbbdc34c6064fce4a550792a35f62bc626e9a5f2');
            $info = $vimeo->call("vimeo.videos.setDescription", array("video_id" => $params['id_video'], 'description' => $params['des_video']));
            $info = $vimeo->call("vimeo.videos.setTitle", array("video_id" => $params['id_video'], 'title' => $params['nom_video']));

            //$this->view->videos = $vimeo->call('vimeo.videos.search', array("query" => "shakira"));
        } catch (Exception $e) {
            $this->authVimeo();
        }
        echo "callVimeo();";
    }

    public function deleteVmAction() {
        $this->noRender();
        $params = $this->getRequest()->getParams();
        require_once('../library/Coringa/Vimeo/vimeo.php');
        session_name("vimeo");
        session_start();
        $vimeo = new phpVimeo('eb380c3c78bdf7496acea922fe17f70681a757da', '70ab97bd546efe7e591276cfa4a672dbdbf3558a');
        try {
            // $vimeo->setToken($_SESSION['oauth_request_token'], $_SESSION['oauth_request_token_secret']);
            $vimeo->setToken('a6527cd7df355a389267a884c33ef66b', 'bbbdc34c6064fce4a550792a35f62bc626e9a5f2');
            $vimeo->call("vimeo.videos.delete", array("video_id" => $params['video_id']));
            echo "callVimeo();";

            //$this->view->videos = $vimeo->call('vimeo.videos.search', array("query" => "shakira"));
        } catch (Exception $e) {
            $this->authVimeo();
            echo $e->getCode() . '...' . $e->getMessage();
        }
    }

    public function refreshAction() {
        $this->noRender();
        $request = $this->getRequest();
        if ($request->isPost()) {
            $data = $request->getPost();
            $this->view->page = $data['url'];
            $this->view->ajax = 'true';
            $this->render('refresh');
        }
    }

    public function flickrAction() {
        session_start();
        $this->view->flickr = $_SESSION['phpFlickr_auth_token'];
        $this->noRender();
        $params = $this->getRequest()->getParams();
        $flickr = new Admin_Model_Flickr();
        if (isset($params['upload'])) {
            $flickr->upload($_FILES['img_flickr']['tmp_name']);
            exit;
        }
        if (isset($params['login'])) {
            echo $flickr->getAccess();
        }
        if (isset($params['search_fk'])) {
            echo $flickr->search($params['search_fk']);
        }
        if (!isset($_SESSION['phpFlickr_auth_token'])) {

            $this->render('flickr');
        }
        else {

            echo $flickr->getImages();
        }
    }

    public function flickrRetornoAction() {
        session_start();

        $params = $this->getRequest()->getParams();
        $this->noRender();
        $flickr = new Admin_Model_Flickr();
        echo $flickr->setReturn($params['frob']);
    }

}
