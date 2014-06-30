<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class Coringa_Form_Element {

    public function __construct() {
        $this->translate = new Zend_Translate(
                array(
            'adapter' => 'ini',
            'content' => APPLICATION_PATH . '/data/pt-BR/campos.ini',
            'locale' => 'pt-BR'
                )
        );
    }

    public function drawLayout($content) {
        return '<div class="form-group">' . $content . '</div>';
    }

}
