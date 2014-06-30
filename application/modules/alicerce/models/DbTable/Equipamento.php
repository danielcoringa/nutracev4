<?php

/**
 * Description of Security
 * @category   PublicAnuncios
 * @package    Coringa_Controller
 * @copyright  Copyright (c) 2013-2013 CoringaSistemas INC (http://www.coringasistemas.com.br)
 */
class Alicerce_Model_DbTable_Equipamento extends Coringa_Db_Table_Alicerce {

    protected $_name = 'tab_web_equipamento';
    protected $_primary = 'cod_equipamento';

    public function gridList() {
        $select = $this->select();

        $select->where('cod_equipamento_dup=0');
        return $this->fetchAll($select);
    }

    public function gridListAll() {
        $select = $this->select();
        $select->setIntegrityCheck(false);
        $select->from(array("twe" => "tab_web_equipamento"));
        $select->joinInner(array("twc" => "tab_web_categoria"), "twc.cod_categoria=twe.cod_categoria", array("nom_categoria" => "twc.nom_categoria"));
        $select->where("twe.ind_status<>'I'");
        return $this->fetchAll($select);
    }

    public function getEquipamento($cod) {
        $select = $this->select();
        $select->where('cod_equipamento=?', $cod);
        return $this->fetchRow($select);
    }

    public function getDadosSelect() {
        $select = $this->select();
        $select->where('ind_status=?', 'A');
        return $this->fetchAll($select);
    }

    public function getTotalEstoque() {
        $select = $this->select();
        $select->where("qtd_estoque_atual >= qtd_estoque_efetivo");
        $ret = $this->fetchAll($select);
        foreach ($ret as $row) {
            $soma = $soma + $row['qtd_estoque_atual'];
        }
        return str_pad($soma, 2, '0', STR_PAD_LEFT);
    }

}

?>
