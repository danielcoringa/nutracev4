<?php

/**
 * Description of Security
 * @category   PublicAnuncios
 * @package    Coringa_Controller
 * @copyright  Copyright (c) 2013-2013 CoringaSistemas INC (http://www.coringasistemas.com.br)
 */
class Alicerce_Model_DbTable_Locacao extends Coringa_Db_Table_Alicerce {

    protected $_name = 'tab_web_locacao';
    protected $_primary = 'cod_locacao';

    public function gridList($status = null) {
        $select = $this->select();
        $select->setIntegrityCheck(false);
        $select->from(array("twl" => "tab_web_locacao"));
        $select->joinInner(array("twc" => "tab_web_cliente"), "twc.cod_cliente=twl.cod_cliente");
        $select->joinLeft(array("two" => "tab_web_obra"), "two.cod_obra=twl.cod_obra");
        if ($status !== null)
            $select->where('twl.ind_status=?', $status);

        return $this->fetchAll($select);
    }

    public function getLocacao($valor) {
        $select = $this->select();
        $select->setIntegrityCheck(false);
        $select->from(array("twl" => "tab_web_locacao"));
//        $select->joinLeft(array("twc" => "tab_web_cliente"), "twc.cod_cliente=twl.cod_cliente");
//        $select->joinLeft(array("two" => "tab_web_obra"), "two.cod_obra=twl.cod_obra");
        $select->where("twl.cod_locacao=" . $valor);
        //die($select->__toString());
        return $this->fetchRow($select);
    }

    public function getLocacaoJoin($valor) {
        $select = $this->select();
        $select->setIntegrityCheck(false);
        $select->from(array("twl" => "tab_web_locacao"));
        $select->joinInner(array("twc" => "tab_web_cliente"), "twc.cod_cliente=twl.cod_cliente");
        $select->joinLeft(array("two" => "tab_web_obra"), "two.cod_obra=twl.cod_obra");
        $select->where("twl.cod_locacao=" . $valor);
        //die($select->__toString());
        return $this->fetchRow($select);
    }

    public function getDados($valor) {
        $select = $this->select();
        $select->setIntegrityCheck(false);
        $select->from(array("twl" => "tab_web_locacao"));
        $select->where("twl.ind_status='I'");
        $result = $this->fetchAll($select)->toArray();
        return $result;
    }

    public function getDadosPdf($valor) {
        $select = $this->select();
        $select->setIntegrityCheck(false);
        $select->from(array("twl" => "tab_web_locacao"));
        $select->joinInner(array("twc" => "tab_web_cliente"), "twc.cod_cliente=twl.cod_cliente");
        $select->joinInner(array("two" => "tab_web_obra"), "two.cod_obra=twl.cod_obra", array("des_endereco_obra" => "two.des_endereco", "des_bairro_obra" => "two.des_bairro", "num_cep_obra" => "two.num_cep", "des_cidade_obra" => "two.des_cidade", "des_estado_obra" => "two.des_estado"));
        $select->where("twl.cod_locacao=?", $valor);
        $result = $this->fetchRow($select);
        return $result;
    }

    public function getTotal($status) {
        $ret = $this->fetchAll("ind_status='$status'");
        return str_pad(count($ret), 2, '0', STR_PAD_LEFT);
    }

    public function getAgenda() {
        $select = $this->select();
        $select->where("ind_status=?", "A");
        // $select->where("cod_empresa=?", $cp);
        return $this->fetchAll($select)->toArray();
    }

    public function gridListDevolucao() {
        $select = $this->select();

        $select->setIntegrityCheck(false);
        $select->distinct();
        $select->from(array("twl" => "tab_web_locacao"));
        $select->joinInner(array("twc" => "tab_web_cliente"), "twc.cod_cliente=twl.cod_cliente");
        $select->joinLeft(array("two" => "tab_web_obra"), "two.cod_obra=twl.cod_obra");
        $select->joinRight(array("twel" => "tab_web_equipamento_locacao"), "twel.cod_locacao=twl.cod_locacao", "twel.cod_locacao");
        $select->where('twel.ind_status="C"');

        return $this->fetchAll($select);
    }

}

?>
