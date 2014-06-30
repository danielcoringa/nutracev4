<?php

/**
 * Description of Security
 * @category   PublicAnuncios
 * @package    Coringa_Controller
 * @copyright  Copyright (c) 2013-2013 CoringaSistemas INC (http://www.coringasistemas.com.br)
 */
class Alicerce_Model_DbTable_Estados extends Coringa_Db_Table_Alicerce {

    protected $_name = 'tab_web_estado';
    protected $_primary = 'cod_estado';

    public function gridList($status) {
        $select = $this->select();
        $select->where('ind_status=?', $status);

        return $this->fetchAll($select);
    }

    public function getEstados() {
        $select = $this->select();
        $select->order("nom_estado ASC");
        return $this->fetchAll($select);
    }

}

?>
