<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class Coringa_Form_Element_Text extends Coringa_Form_Element {

    public function init() {

    }

    public function setMetadata($meta, $dados) {
        $this->meta = $meta;
        $this->dados = $dados;
    }

    public function draw() {
        $this->label = '<label for="' . $this->meta['col_name'] . '">' . $this->translate->_($this->meta['col_name']) . '</label>';
        if ($this->meta['required'] < 1) {
            $required = 'required="required" ';
        }
        $this->input = '<textarea ' .
                'class="ckeditor" ' .
                'id="' . $this->meta['col_name'] . '" ' .
                'name="' . $this->meta['col_name'] . '"' .
                $required .
                '" >' .
                $this->dados[$this->meta['col_name']] .
                '</textarea>';
        return $this->drawLayout($this->label . $this->input);
    }

}
