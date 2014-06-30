<?php

/**
 * Description of Security
 * @category   PublicAnuncios
 * @package    Coringa_Controller
 * @copyright  Copyright (c) 2013-2013 CoringaSistemas INC (http://www.coringasistemas.com.br)
 */
class Alicerce_Model_DbTable_Cliente extends Coringa_Db_Table_Alicerce {

    protected $_name = 'tab_web_cliente';
    protected $_primary = 'cod_cliente';

    public function gridList($status, $ce) {
        $select = $this->select();
        $select->where('ind_status=?', $status);
        //$select->where('cod_empresa=?', $ce);
        $select->where('cod_co_responsabilidade=0');
        return $this->fetchAll($select);
    }

    public function gridListCo($status) {
        $select = $this->select();
        $select->setIntegrityCheck(false);
        $select->from(array("tba" => "tab_web_cliente"));
        $select->joinInner(array("tbb" => "tab_web_cliente"), "tba.cod_co_responsabilidade=tbb.cod_cliente", "tbb.nom_cliente AS nom_cliente_responsavel");
        $select->where('tba.ind_status=?', $status);
        $select->where('tba.cod_co_responsabilidade>0');

        return $this->fetchAll($select);
    }

    public function gridListObras($status) {
        $select = $this->select();
        $select->setIntegrityCheck(false);
        $select->from(array("tba" => "tab_web_cliente"));
        $select->joinInner(array("tbo" => "tab_web_obra"), "tba.cod_cliente=tbo.cod_cliente");
        $select->where('tba.ind_status=?', $status);
        $select->where('tbo.ind_status=?', $status);

        return $this->fetchAll($select);
    }

    public function getCliente($cod) {
        if ($cod > 0) {
            $select = $this->select();
            $select->where('cod_cliente=?', $cod);
            return $this->fetchRow($select);
        }
        else {
            return false;
        }
    }

    public function getCoCliente($cod) {
        $select = $this->select();
        $select->where('cod_co_responsabilidade=?', $cod);
        return $this->fetchRow($select);
    }

    public function getClienteSelect($where = null) {
        $select = $this->select();
        $select->where("ind_status<>'I'");
        if ($where == null) {
            $select->where('cod_co_responsabilidade=0');
        }
        else {
            $select->where($where);
        }
        return $this->fetchAll($select);
    }

    public function getClienteRel($params) {
        $select = $this->select();
        if ($params['cod_cliente'] != '')
            $select->where("cod_cliente=?", $params['cod_cliente']);

        if ($params['ind_status'] != '')
            $select->where("ind_status=?", $params['ind_status']);

        if ($params['dta_inicio'] != '')
            $select->where("dta_cadastro >= ?", $this->dateen($params['dta_inicio']));

        if ($params['dta_final'] != '')
            $select->where("dta_cadastro <= ?", $this->dateen($params['dta_final']));
        if ($params['order_by'] != '')
            $select->order($params['order_by'] . ' ' . $params['ascdesc']);

        $select->where("cod_co_responsabilidade=0");
        return $this->fetchAll($select)->toArray();
    }

    public function getCoClienteRel($params) {
        $select = $this->select();
        $select->setIntegrityCheck(false);
        $select->from(array("twc" => "tab_web_cliente"));
        $select->joinInner(array("twr" => "tab_web_cliente"), "twr.cod_cliente=twc.cod_co_responsabilidade", array("nom_cliente_responsavel" => "twr.nom_cliente"));
        if ($params['cod_cliente'] != '')
            $select->where("twc.cod_co_responsabilidade=?", $params['cod_cliente']);

        if ($params['cod_co_responsabilidade'] != '')
            $select->where("twc.cod_cliente=?", $params['cod_co_responsabilidade']);
        else
            $select->where("twc.cod_co_responsabilidade > 0");

        if ($params['ind_status'] != '')
            $select->where("twc.ind_status=?", $params['ind_status']);

        if ($params['dta_inicio'] != '')
            $select->where("twc.dta_cadastro >= ?", $this->dateen($params['dta_inicio']));

        if ($params['dta_final'] != '')
            $select->where("twc.dta_cadastro <= ?", $this->dateen($params['dta_final']));
        if ($params['order_by'] != '')
            $select->order($params['order_by'] . ' ' . $params['ascdesc']);

        return $this->fetchAll($select)->toArray();
    }

    public function getTotal($status) {
        $select = $this->select();
        $select->where("cod_co_responsabilidade=0");
        $select->where("ind_status='A'");
        $ret = $this->fetchAll($select);
        return str_pad(count($ret), 2, '0', STR_PAD_LEFT);
    }

}

?>
