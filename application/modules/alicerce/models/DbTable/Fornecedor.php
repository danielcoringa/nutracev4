<?php

/**
 * Description of Security
 * @category   PublicAnuncios
 * @package    Coringa_Controller
 * @copyright  Copyright (c) 2013-2013 CoringaSistemas INC (http://www.coringasistemas.com.br)
 */
class Alicerce_Model_DbTable_Fornecedor extends Coringa_Db_Table_Alicerce {

    protected $_name = 'tab_web_fornecedor';
    protected $_primary = 'cod_fornecedor';

    public function gridList($status) {
        $select = $this->select();
        $select->setIntegrityCheck(false);
        $select->from(array("twf" => "tab_web_fornecedor"));
        $select->joinLeft(array("twc" => "tab_web_categoria"), "twc.cod_categoria=twf.cod_categoria", "nom_categoria");
        $select->where('twf.ind_status=?', $status);
        return $this->fetchAll($select);
    }

    public function getDados($cod) {
        $select = $this->select();
        $select->where('cod_fornecedor=?', $cod);
        return $this->fetchRow($select);
    }

    public function getDadosCategoria($cod) {
        $select = $this->select();
        $select->where('cod_categoria=?', $cod);
        return $this->fetchAll($select)->toArray();
    }

    public function getDadosSelect() {
        $select = $this->select();
        $select->where('ind_status=?', 'A');
        return $this->fetchAll($select);
    }

}

?>
