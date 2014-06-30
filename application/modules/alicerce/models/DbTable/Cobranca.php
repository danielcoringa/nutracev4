<?php

/**
 * Description of Security
 * @category   PublicAnuncios
 * @package    Coringa_Controller
 * @copyright  Copyright (c) 2013-2013 CoringaSistemas INC (http://www.coringasistemas.com.br)
 */
class Alicerce_Model_DbTable_Cobranca extends Coringa_Db_Table_Alicerce {

    protected $_name = 'tab_web_cobranca';
    protected $_primary = 'cod_cobranca';

    public function gridList($status) {
        $select = $this->select();
        $select->setIntegrityCheck(false);
        $select->from(array("taco" => "tab_web_cobranca"));
        $select->joinInner(array("tac" => "tab_web_cliente"), "tac.cod_cliente=taco.cod_cliente", 'nom_cliente');
        $select->where('taco.ind_status=?', $status);
        return $this->fetchAll($select);
    }

    public function getCobranca($valor) {
        $select = $this->select();
        $select->where('cod_cobranca=?', $valor);
        return $this->fetchRow($select);
    }

    public function getCobrancaRel($params) {
        $select = $this->select();
        $select->setIntegrityCheck(false);
        $select->from(array("twcob" => "tab_web_cobranca"));
        $select->joinInner(array("twc" => "tab_web_cliente"), "twc.cod_cliente=twcob.cod_cliente", array("nom_cliente" => "twc.nom_cliente"));
        if ($params['cod_cliente'] != '')
            $select->where("twcob.cod_cliente=?", $params['cod_cliente']);

        if ($params['ind_status'] != '')
            $select->where("twcob.ind_status=?", $params['ind_status']);
        if ($params['order_by'] != '')
            $select->order($params['order_by'] . ' ' . $params['ascdesc']);


        return $this->fetchAll($select)->toArray();
    }

}

?>
