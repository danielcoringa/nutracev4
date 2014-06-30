<?php

/**
 * Description of Security
 * @category   PublicAnuncios
 * @package    Coringa_Controller
 * @copyright  Copyright (c) 2013-2013 CoringaSistemas INC (http://www.coringasistemas.com.br)
 */
class Alicerce_Model_DbTable_Categoria extends Coringa_Db_Table_Alicerce {

    protected $_name = 'tab_web_categoria';
    protected $_primary = 'cod_categoria';

    public function gridList($status) {
        $select = $this->select();
        $select->where('ind_status=?', $status);
        return $this->fetchAll($select);
    }

    public function getCategoria($cod) {
        $select = $this->select();
        $select->where('cod_categoria=?', $cod);
        return $this->fetchRow($select);
    }

    public function getCategoriaSelect() {
        $select = $this->select();
        $select->where('ind_status=?', 'A');
        return $this->fetchAll($select);
    }

    public function estoqueList() {
        $db = new Alicerce_Model_DbTable_Equipamento();
        $dbel = new Alicerce_Model_DbTable_EquipamentoLocacao();
        $dbem = new Alicerce_Model_DbTable_EquipamentoManutencao();
        $result = $this->fetchAll("ind_status='A'");
        $x = 0;
        $dados = array();
        foreach ($result as $row => $val) {

            $sel = $db->select();
            $sel->where("ind_status<>?", "I");
            $sel->where("cod_categoria=?", $val['cod_categoria']);
            $res = $db->fetchAll($sel);
            $total_equip = 0;
            $total_ativo = 0;
            $atrasado = 0;
            $total_locado = 0;
            $total_manutencao = 0;
            foreach ($res as $row1) {
                $total_equip += $row1['qtd_estoque_efetivo'];
                $total_ativo += $row1['qtd_estoque_atual'];
            }
            // Pega os Atrasados
            $sela = $dbel->select();
            $sela->setIntegrityCheck(false);
            $sela->from(array("twel" => "tab_web_equipamento_locacao"));
            $sela->joinInner(array("twe" => "tab_web_equipamento"), "twe.cod_equipamento=twel.cod_equipamento", array("cod_categoria" => "twe.cod_categoria"));
            $sela->where("twel.ind_status=?", "A");
            $sela->where("cod_categoria=?", $val['cod_categoria']);

            $sela->where("twel.dta_devolucao<= NOW()");
            $resa = $dbel->fetchAll($sela);
            foreach ($resa as $rowa) {
                $atrasado+= $rowa['qtd_equipamento'];
            }
            //Pega os Locados
            $sell = $dbel->select();
            $sell->setIntegrityCheck(false);
            $sell->from(array("twel" => "tab_web_equipamento_locacao"));
            $sell->joinInner(array("twe" => "tab_web_equipamento"), "twe.cod_equipamento=twel.cod_equipamento", array("cod_categoria" => "twe.cod_categoria"));
            $sell->where("twel.ind_status=?", "A");
            $sell->where("cod_categoria=?", $val['cod_categoria']);
            $resl = $dbel->fetchAll($sell);
            foreach ($resl as $rowl) {
                $total_locado+= $rowl['qtd_equipamento'];
            }
            //Pega os equipamentos em Manutenção
            $selm = $dbem->select();
            $selm->setIntegrityCheck(false);
            $selm->from(array("twem" => "tab_web_equipamento_manutencao"));
            $selm->joinInner(array("twe" => "tab_web_equipamento"), "twe.cod_equipamento=twem.cod_equipamento", array("cod_categoria" => "twe.cod_categoria"));
            $selm->where("twem.ind_status=?", "A");
            $selm->where("cod_categoria=?", $val['cod_categoria']);
            $resm = $dbem->fetchAll($selm);
            foreach ($resm as $rowm) {
                $total_manutencao+= $rowm['qtd_equipamento'];
            }
            $somatd = $total_equip + $total_ativo + $atrasado;
            if ($somatd > 0) {
                $dados[$x]['cod_categoria'] = $val['cod_categoria'];
                $dados[$x]['nom_categoria'] = $val['nom_categoria'];
                $dados[$x]['des_categoria'] = $val['des_categoria'];
                $dados[$x]['total_equip'] = $total_equip;
                $dados[$x]['total_ativo'] = $total_ativo;
                $dados[$x]['total_locado'] = $total_locado;
                $dados[$x]['total_manutencao'] = $total_manutencao;
                $dados[$x]['total_atrasado'] = $atrasado;
                $x++;
            }
        }
        return $dados;
    }

}

?>
