<?php

/**
 * Description of Security
 * @category   PublicAnuncios
 * @package    Coringa_Controller
 * @copyright  Copyright (c) 2013-2013 CoringaSistemas INC (http://www.coringasistemas.com.br)
 */
class Alicerce_Model_DbTable_EquipamentoManutencao extends Coringa_Db_Table_Alicerce {

    protected $_name = 'tab_web_equipamento_manutencao';
    protected $_primary = 'cod_equipamento_manutencao';

    public function gridList($status) {
        $select = $this->select();
        $select->setIntegrityCheck(false);
        $select->from(array("twem" => "tab_web_equipamento_manutencao"));
        $select->joinInner(array("twe" => "tab_web_equipamento"), "twe.cod_equipamento=twem.cod_equipamento");
        $select->joinInner(array("twc" => "tab_web_categoria"), "twc.cod_categoria=twe.cod_categoria", "twc.nom_categoria");
        $select->where('twem.ind_status=?', $status);
        return $this->fetchAll($select);
    }

    public function getEquipamentoManutencao($cod) {
        $select = $this->select();
        $select->setIntegrityCheck(false);
        $select->from(array("twem" => "tab_web_equipamento_manutencao"));
        $select->joinInner(array("twe" => "tab_web_equipamento"), "twe.cod_equipamento=twem.cod_equipamento");
        $select->where('twem.cod_equipamento_manutencao=?', $cod);
        return $this->fetchRow($select);
    }

    public function getEquipamentoManutencaoAuto() {
        $select = $this->select();
        $select->setIntegrityCheck(false);
        $select->from(array("twem" => "tab_web_equipamento_manutencao"));
        $select->joinInner(array("twe" => "tab_web_equipamento"), "twe.cod_equipamento=twem.cod_equipamento");
        $select->where('twem.ind_automatico="S"');
        $select->where('twem.dta_retorno<=NOW()');
        $select->where('twem.ind_status="A"');
        return $this->fetchAll($select)->toArray();
    }

    public function getEstoqueManutencao() {
        $select = $this->select();
        $select->where("ind_status='A'");
        $retorno = $this->fetchAll($select);
        return str_pad(count($retorno), 2, '0', 0);
    }

}

?>
