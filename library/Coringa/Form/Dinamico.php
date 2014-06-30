<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class Coringa_Form_Dinamico {

    public function __construct() {

    }

    public function setTable($table) {
        $this->table = $table;
        $this->setElements();
    }

    public function getTable() {
        return $this->table;
    }

    public function getCols() {
        $table = $this->table;
        $cols = $table->info(Zend_Db_Table_Abstract::COLS);
        return $cols;
    }

    public function getMetadata() {
        $table = $this->table;
        $metadata = $table->info(Zend_Db_Table_Abstract::METADATA);
        return $metadata;
    }

    public function setElements() {
        $meta = $this->getMetadata();
        $this->elements = array();
        $x = 0;
        foreach ($meta as $campo) {
            $this->elements[$x]['col_name'] = $campo['COLUMN_NAME'];
            $this->elements[$x]['data_type'] = $campo['DATA_TYPE'];
            $this->elements[$x]['size'] = $campo['LENGTH'];
            $this->elements[$x]['required'] = $campo['NULLABLE'];
            $this->elements[$x]['default'] = $campo['DEFAULT'];
            $this->elements[$x]['position'] = $campo['COLUMN_POSITION'];
            $x++;
        }
    }

    public function drawElements($dados) {
        if (count($this->elements) > 0) {
            foreach ($this->elements as $elemento) {
                $elm = 'Coringa_Form_Element_' . ucfirst($elemento['data_type']);
                $melm = new $elm();
                $melm->setMetadata($elemento, $dados);
                $html.=$melm->draw();
            }
        }
        else {
            die("Sem campos na tabela.");
        }
        return $html;
    }

}
