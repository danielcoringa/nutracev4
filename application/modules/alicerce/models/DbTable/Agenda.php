<?php

/**
 * Description of Security
 * @category   PublicAnuncios
 * @package    Coringa_Controller
 * @copyright  Copyright (c) 2013-2013 CoringaSistemas INC (http://www.coringasistemas.com.br)
 */
class Alicerce_Model_DbTable_Agenda extends Coringa_Db_Table_Alicerce {

    protected $_name = 'tab_web_agenda';
    protected $_primary = 'cod_agenda';

    public function getAgenda($dt1 = null, $dt2 = null) {
        $select = $this->select();
        if ($dt1 != null)
            $select->where("dta_inicial>=?", $dt1);
        if ($dt2 != null)
            $select->where("dta_final<=?", $dt2);
        return $this->fetchAll($select)->toArray();
    }

    public function getEvento($cod) {
        $select = $this->select();
        $select->where("cod_agenda=?", $cod);
        return $this->fetchRow($select)->toArray();
    }

}

?>
