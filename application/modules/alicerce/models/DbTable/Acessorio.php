<?php

/**
 * Description of Security
 * @category   PublicAnuncios
 * @package    Coringa_Controller
 * @copyright  Copyright (c) 2013-2013 CoringaSistemas INC (http://www.coringasistemas.com.br)
 */
class Alicerce_Model_DbTable_Acessorio extends Coringa_Db_Table_Alicerce {

    protected $_name = 'tab_web_acessorio';
    protected $_primary = 'cod_acessorio';

    public function gridList($status) {
        $select = $this->select();
        $select->setIntegrityCheck(false);
        $select->from(array("twa" => "tab_web_acessorio"));
        $select->joinInner(array("twe" => "tab_web_equipamento"), "twe.cod_equipamento=twa.cod_equipamento", "nom_equipamento");

        $select->where('twa.ind_status=?', $status);

        return $this->fetchAll($select);
    }

    public function getDados($cod) {
        $select = $this->select();
        $select->where('cod_acessorio=?', $cod);
        return $this->fetchRow($select);
    }

    public function getDadosSelect() {
        $select = $this->select();
        $select->where('ind_status=?', 'A');
        return $this->fetchAll($select);
    }

    public function getAcessorios($cod_equip) {
        $select = $this->select();
        $select->where("cod_equipamento=?", $cod_equip);
        return $this->fetchAll($select);
    }

}

?>
