<?php

/**
 * Description of Security
 * @category   PublicAnuncios
 * @package    Coringa_Controller
 * @copyright  Copyright (c) 2013-2013 CoringaSistemas INC (http://www.coringasistemas.com.br)
 */
class Alicerce_Model_DbTable_EquipamentoLocacao extends Coringa_Db_Table_Alicerce {

    protected $_name = 'tab_web_equipamento_locacao';
    protected $_primary = 'cod_equipamento_locacao';

    public function gridList($status) {
        $select = $this->select();
        $select->where('ind_status=?', $status);
        return $this->fetchAll($select);
    }

    public function getEquipamentoLocacao($cod) {
        $select = $this->select();
        $select->where('cod_equipamento_locacao=?', $cod);
        return $this->fetchRow($select);
    }

    public function getEquipamentoPorLocacao($cod) {
        $select = $this->select();
        $select->where('cod_locacao=?', $cod);
        $select->where('ind_status="A"');
        return $this->fetchAll($select);
    }

    public function getEquipamentoLocacaoSelect() {
        $select = $this->select();
        $select->where('ind_status=?', 'L');
        return $this->fetchAll($select);
    }

    public function getDevolvidos($param) {
        $select = $this->select();
        $select->setIntegrityCheck(false);
        $select->from(array("twl" => "tab_web_locacao"));
        $select->joinLeft(array("twel" => "tab_web_equipamento_locacao"), "twel.cod_locacao=twl.cod_locacao");
        $select->joinLeft(array("twe" => "tab_web_equipamento"), "twe.cod_equipamento=twel.cod_equipamento");
        $select->where("twl.cod_locacao=?", $param);
        $select->where("twel.ind_status='C'");
        $return = $this->fetchAll($select)->toArray();
        return $return;
    }

    public function getEstoquePendente() {
        $db = new Alicerce_Model_DbTable_Locacao();
        $sel = $db->select();
        $sel->where("dta_devolucao <?", Date("Y-m-d h:i:s"));
        $ret = $db->fetchAll($sel);
        if (count($ret) > 0) {
            // A devolução ultrapassou a data
            foreach ($ret as $row) {
                $select = $this->select();
                $select->where("cod_locacao=?", $row['cod_locacao']);
                $select->where("ind_status='A'");
                $return = $this->fetchAll($select);
                foreach ($return as $row2) {
                    $soma = $row2['qtd_equipamento'] + $soma;
                }
            }
            return str_pad($soma, 2, '0', 0);
        }
        else {
            return "00";
        }
    }

    public function getEstoqueLocado() {
        $db = new Alicerce_Model_DbTable_Equipamento();
        $sel = $db->select();
        $sel->where("qtd_estoque_atual < qtd_estoque_efetivo");
        $ret = $db->fetchAll($sel);
        if (count($ret) > 0) {
            // A devolução ultrapassou a data
            foreach ($ret as $row) {
                $soma = $soma + $row['qtd_estoque_efetivo'] - $row['qtd_estoque_atual'];
            }
            return str_pad($soma, 2, '0', 0);
        }
        else {
            return "00";
        }
    }

}

?>
