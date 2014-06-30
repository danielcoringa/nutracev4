<?php

/**
 * Description of Security
 * @category   PublicAnuncios
 * @package    Coringa_Controller
 * @copyright  Copyright (c) 2013-2013 CoringaSistemas INC (http://www.coringasistemas.com.br)
 */
class Alicerce_Model_DbTable_Modelo extends Coringa_Db_Table_Alicerce {

    protected $_name = 'tab_web_modelo';
    protected $_primary = 'cod_modelo';

    public function gridList($status) {
        $select = $this->select();
        $select->where('ind_status=?', $status);
        return $this->fetchAll($select);
    }

    public function getDados($cod) {
        $select = $this->select();
        $select->where('cod_modelo=?', $cod);
        return $this->fetchRow($select);
    }

    public function getDadosSelect() {
        $select = $this->select();
        $select->where('ind_status=?', 'A');
        return $this->fetchAll($select);
    }

}

?>
