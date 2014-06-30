<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class Zend_View_Helper_Miniatura extends Zend_View_Helper_Abstract {

    public function init() {

    }

    public function miniatura($cod, $type = '') {
        if ($cod > 0) {
            $db = new Admin_Model_DbTable_Imagem();
            $dados = $db->getDados($cod);
            switch ($type) {
                case 'medium':
                    $img = $dados['nom_pasta'] . $dados['nom_imagem'] . '_medium.' . $dados['ext_imagem'];
                    if (!is_file($img)) {
                        $img = $dados['nom_pasta'] . $dados['nom_imagem'] . '.' . $dados['ext_imagem'];
                    }
                    break;
                default:
                    $img = $dados['nom_pasta'] . $dados['nom_imagem'] . '.' . $dados['ext_imagem'];

                    break;
            }
            return $img;
        }
        else {
            return 'img/no-image.jpg';
        }
    }

}
