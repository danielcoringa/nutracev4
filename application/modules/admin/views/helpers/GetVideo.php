<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class Zend_View_Helper_GetVideo extends Zend_View_Helper_Abstract {

    public function init() {

    }

    public function getVideo($cod) {
        if ($cod > 0) {
            $db = new Admin_Model_DbTable_Video();
            $dados = $db->getDados($cod);
            if ($dados[0]['tipo_video'] == 'youtube') {
                return '<embed width="100%" height="100%" src="http://www.youtube.com/v/' . $dados[0]['id_video'] . '&autoplay=0&rel=0&showinfo=0" type="application/x-shockwave-flash" allowFullScreen="true"> </embed>';
            }
            else {
                return '<iframe src="//player.vimeo.com/video/' . $dados[0]['id_video'] . '?autoplay=0" width="100%" height="100%" frameborder="0" webkitallowfullscreen mozallowfullscreen allowfullscreen></iframe>';
            }
        }
    }

}
