<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class Admin_Model_Youtube {

    public function __construct() {
        session_name("youtube");
        session_start();
        $this->client = new Coringa_Google_Client();
        $this->client->setApplicationName('rd-youtube');
        // Visit https://code.google.com/apis/console?api=plus to generate your
        // client id, client secret, and to register your redirect uri.
        $this->client->setClientId('1044219149899-nkamhugmd5i9dir0uh2pp7tr1ovjkq6n.apps.googleusercontent.com');
        $this->client->setClientSecret('Y5Jn_b11f74sJjiWrX3fTZhk');
        $this->client->setRedirectUri('http://admin.rodrigodaniel.com.br/artigos/get-code');
        $this->client->setDeveloperKey('AIzaSyDTP2rhrqjGTt_wvq2fg71sJC5wQ9ZaMz8');
        $scopes = array("https://gdata.youtube.com");
        $this->client->setScopes($scopes);
        //$plus = new Coringa_Google_PlusService($this->client);
        if (isset($_SESSION['token'])) {
            //$this->client->setAccessToken($_SESSION['token']);
            $client = Zend_Gdata_AuthSub::getHttpClient($_SESSION['token']);
            $this->yt = new Zend_Gdata_YouTube($client);
        }
        else {

            $authUrl = $this->client->createAuthUrl();

            echo "<div class='content-vimeo'>
                    <h1>Youtube Autorização</h1>
                  </div>
                  <p>Clique no botão abaixo para autorizar o acesso à sua conta no Youtube.</p>
                  <button class='btn btn-default btn-success login-youtube'>Autorizar</button>
                  <script>
                        $('.login-youtube').bind('click', function() {";
            echo "        myWindow=window.open('$authUrl','login','width=600,height=600,directories=no,status=no,toolbar=no,menubar=no,scrollbars=no,resizable=no',true);
                          myWindow.focus();
                          });
            ";

            echo "</script>";
            exit;
        }
    }

    public function setDefault() {
        try {
            $this->user = $this->yt->getUserProfile("default");
            ;
        } catch (Exception $error) {
            //session_destroy();
        }
        $this->videoFeed = $this->yt->getuserUploads('default');
        return $this->videoFeed;








        //$this->user = $this->yt->getUserProfile("default");;
        //$this->videoFeed = $this->yt->getuserUploads('default');
        //return $this->videoFeed;
    }

    public function setBusca($busca, $index = 1, $maxResults = 20, $orderby = 'relevance') {
        $query = $this->yt->newVideoQuery();
        $query->videoQuery = $busca;
        $query->startIndex = $index;
        $query->maxResults = $maxResults;
        $query->orderBy = $orderby;
        $this->videoFeed = $this->yt->getVideoFeed($query);
    }

    public function getVideoFeed() {
        return $this->videoFeed;
    }

    public function viewLists($campo) {

    }

    public function viewList($campo) {
        //   $html .= '<div class="grid_12">';
        $html .= '<div class="box elfinder">';
//	$html .= '<div class="header">';
//	$html .= '<h2><img class="icon" src="/img/admin/icons/packs/fugue/16x16/image-sunset.png"> Mídia Explorer</h2>';
//	$html .= '</div>';

        $html .= '<div class="ui-helper-reset ui-helper-clearfix ui-widget ui-widget-content ui-corner-all elfinder elfinder-ltr elfinder-disabled" style="width: auto;">';
        $html .= '<div class="ui-helper-clearfix ui-widget-header ui-corner-top elfinder-toolbar" style="">
                    <div class="ui-widget-content ui-corner-all elfinder-buttonset">
                            <div class="ui-state-default elfinder-button tooltip" title="Vídeos Principais" onclick="showBibliotecaa(\'' . $campo . '\')">
                                <span class="elfinder-button-icon elfinder-button-icon-home"></span>
                            </div>
                    </div>
                    <div class="ui-widget-content ui-corner-all elfinder-buttonset">
                        <div class="ui-state-default elfinder-button tooltip" title="Enviar Arquivos" onclick="send_yt_file(\'' . $campo . '\')">
                            <span class="elfinder-button-icon elfinder-button-icon-upload"></span>
                        </div>
                    </div>
                    <div class="ui-widget-content ui-corner-all elfinder-buttonset">
                        <div class="ui-state-default elfinder-button tooltip" title="Editar Dados" onclick="edit_yt(\'' . $campo . '\')">
                            <span class="elfinder-button-icon elfinder-button-icon-edit"></span>
                        </div>
                        <span class="ui-widget-content elfinder-toolbar-button-separator"></span>
                        <div class="ui-state-default elfinder-button tooltip" title="Excluir Vídeo" onclick="delete_yt(\'' . $campo . '\')">
                            <span class="elfinder-button-icon elfinder-button-icon-rm"></span>
                        </div>
                    </div>
                        <div style="display: block;" class="ui-widget-content elfinder-button elfinder-button-search">
                            <input type="text" class="busca" size="42" value="' . $params['busca'] . '" >
                            <span class="ui-icon ui-icon-search" title="Encontrar Arquivos" onclick="showBibliotecaa(\'' . $campo . '\');"></span>
                            <span class="ui-icon ui-icon-close"></span>


                        </div>
                    </div>';
        $html .= '<div class="scrollbart">
					<div class="scrollbar">
                                            <div class="track">
                                                <div class="thumb">
                                                    <div class="end"></div>
                                                </div>
                                            </div>
                                        </div>
					<div class="viewport" >
                                            <div class="overview" style="width:100%!important">';
        foreach ($this->videoFeed as $videoEntry) {
            // $putUrl = $videoEntry->getEditLink()->getHref();
            //  $videoEntry->setVideoTitle('Video - '.str_pad($x,2,'0',STR_PAD_LEFT));
            //  $videoEntry->setVideoDescription('Videos de Teste do Aplicativo');
            //  $yt->updateEntry($videoEntry, $putUrl);
            // Cria as miniaturas
            $videoThumbnails = $videoEntry->getVideoThumbnails();
            //Cria o box de dados
            $html .= "<div class='data_player' data-id-video='{$videoEntry->getId()}' data-link='{$videoEntry->getVideoWatchPageUrl()}' data-id='12_" . base64_encode($videoThumbnails[0]['url']) . "' >";
            $html .= "<img src='{$videoThumbnails[0]['url']}' class='img_player' />";
            $d_h = explode("T", $videoEntry->getUpdated());
            $d = explode('-', $d_h[0]);
            $data_hora = $d[2] . '/' . $d[1] . '/' . $d[0];
            $html .= '<h2 class="title">' . $videoEntry->getVideoTitle() . " - " . $data_hora . "</h2>";
            $autor = $videoEntry->getAuthor();
            $html .= '<p>de <strong>' . $videoEntry->author[0]->name->text . '</strong> - <small>' . $videoEntry->getVideoViewCount() . ' Visualizações.</small> </p>';
            //echo 'Video ID: ' . $videoEntry->getVideoId() . "<br>";
            //echo 'Updated: ' . $videoEntry->getUpdated() . "<br>";
            $html .= '<div class="descricao">' . $videoEntry->getVideoDescription() . "</div>";
            //echo 'Category: ' . $videoEntry->getVideoCategory() . "<br>";
            //echo 'Tags: ' . implode(", ", $videoEntry->getVideoTags()) . "<br>";
            //echo 'Flash Player Url: ' . $videoEntry->getFlashPlayerUrl() . "<br>";
            $html .= 'Duração: ' . gmdate("i:s", $videoEntry->getVideoDuration()) . "<br>";
            //echo 'Rating: ' . $videoEntry->getVideoRatingInfo() . "<br>";
            //echo 'Geo Location: ' . $videoEntry->getVideoGeoLocation() . "<br>";
            //echo 'Recorded on: ' . $videoEntry->getVideoRecorded() . "<br>";
            $html .= "<div style='clear:both'></div>";
            $html .= '</div>';
        }
        $html .= '</div>';
        $html .= '</div>';
        $html .= '</div>';
        $html .= '</div>';
        // $html .= '</div>';

        $html .= '</div>';
        return $html;
    }

}
