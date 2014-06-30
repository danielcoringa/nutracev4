<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class Coringa_Form_Element_Char extends Coringa_Form_Element {

    public function init() {

    }

    public function setMetadata($meta, $dados) {
        $this->meta = $meta;
        $this->dados = $dados;
    }

    public function draw() {
        if ($this->meta['required'] < 1) {
            $required = 'required="required" ';
        }
        if ($this->dados[$this->meta['col_name']] === $this->meta['default']) {
            $checked = 'checked="checked" ';
        }
        $this->label = ''; // '<label for="' . $this->meta['col_name'] . '">' . $this->translate->_($this->meta['col_name']) . '</label>';
        $this->input = '<input type="checkbox" ' .
                'value="' . $this->meta['default'] . '" ' .
                $required .
                'id="' . $this->meta['col_name'] . '" ' .
                $checked .
                'name="' . $this->meta['col_name'] . '" >' . $this->translate->_($this->meta['default'] . '_' . $this->meta['col_name']);
        return '<div class="checkbox">' . $this->label . $this->input . '</div>';
    }

}
