<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class Zend_View_Helper_GetAudio extends Zend_View_Helper_Abstract {

    public function init() {

    }

    public function getAudio($cod, $mode = 'false') {
        if ($cod > 0) {
            $db = new Admin_Model_DbTable_Audio();
            $dados = $db->getDados($cod);
            return '<iframe width="100%" height="166" scrolling="no" frameborder="no" src="https://w.soundcloud.com/player/?url=https%3A//api.soundcloud.com/tracks/' . $dados['id_musica'] . '&amp;color=ff6600&amp;auto_play=' . $mode . '&amp;show_artwork=true"></iframe>';
        }
    }

}
