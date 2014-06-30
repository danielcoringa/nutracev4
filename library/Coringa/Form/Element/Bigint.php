<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class Coringa_Form_Element_Bigint extends Coringa_Form_Element {

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
        if ($this->meta['position'] == 1) {
            $this->label = '<label for="' . $this->meta['col_name'] . '">' . $this->translate->_($this->meta['col_name']) . '</label>';
            $this->input = '<input type="text" ' .
                    'class="form-control" ' .
                    'id="' . $this->meta['col_name'] . '" ' .
                    'name="' . $this->meta['col_name'] . '"' .
                    'placeholder="Automatico" ' .
                    'value="' . $this->dados[$this->meta['col_name']] . '"' .
                    'readonly="readonly">';
        }
        else {
            $this->label = '<label for="' . $this->meta['col_name'] . '">' . $this->translate->_(str_replace("cod_", "nom_", $this->meta['col_name'])) . '</label>';
            $this->input = '<input type="text" ' .
                    'class="form-control" ' .
                    $required .
                    'id="' . $this->meta['col_name'] . '" ' .
                    'name="' . $this->meta['col_name'] . '"' .
                    'value="' . $this->dados[$this->meta['col_name']] . '"' .
                    'placeholder="Select" ';
        }


        return '<div class="form-group">' . $this->label . $this->input . '</div>';
    }

}
