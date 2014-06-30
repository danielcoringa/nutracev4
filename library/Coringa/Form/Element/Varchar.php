<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class Coringa_Form_Element_Varchar extends Coringa_Form_Element {

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
        $this->label = '<label for="' . $this->meta['col_name'] . '">' . $this->translate->_($this->meta['col_name']) . '</label>';
        $this->input = '<input type="text" ' .
                'class="form-control" ' .
                'value="' . $this->dados[$this->meta['col_name']] . '"' .
                $required .
                'id="' . $this->meta['col_name'] . '" ' .
                'name="' . $this->meta['col_name'] . '"' .
                'size="' . $this->meta['size'] . '"' .
                'placeholder="' . $this->translate->_('place_' . $this->meta['col_name']) . '" >';
        return '<div class="form-group">' . $this->label . $this->input . '</div>';
    }

}
