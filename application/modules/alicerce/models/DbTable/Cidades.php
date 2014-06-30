<?php

/**
 * Description of Security
 * @category   PublicAnuncios
 * @package    Coringa_Controller
 * @copyright  Copyright (c) 2013-2013 CoringaSistemas INC (http://www.coringasistemas.com.br)
 */
class Alicerce_Model_DbTable_Cidades extends Coringa_Db_Table_Alicerce {

    protected $_name = 'tab_web_cidade';
    protected $_primary = 'cod_cidade';

    public function gridList($status) {
        $select = $this->select();
        $select->where('ind_status=?', $status);

        return $this->fetchAll($select);
    }

    public function getCidade($uf) {
        $select = $this->select();
        $select->where("ind_sigla=?", $uf);
        return $this->fetchAll($select);
    }

}

?>
