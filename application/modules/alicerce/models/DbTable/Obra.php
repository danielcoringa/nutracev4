<?php

/**
 * Description of Security
 * @category   PublicAnuncios
 * @package    Coringa_Controller
 * @copyright  Copyright (c) 2013-2013 CoringaSistemas INC (http://www.coringasistemas.com.br)
 */
class Alicerce_Model_DbTable_Obra extends Coringa_Db_Table_Alicerce {

    protected $_name = 'tab_web_obra';
    protected $_primary = 'cod_obra';

    public function gridList($status) {
        $select = $this->select();
        $select->where('ind_status="A"');

        return $this->fetchAll($select);
    }

    public function getObra($val) {
        $select = $this->select();
        $select->where("cod_obra=?", $val);
        return $this->fetchRow($select);
    }

    public function getObraCliente($val) {
        $select = $this->select();
        $select->where("cod_cliente=?", $val);
        return $this->fetchAll($select);
    }

    public function getObraRel($params) {
        $select = $this->select();
        $select->setIntegrityCheck(false);
        $select->from(array("two" => "tab_web_obra"));
        $select->joinInner(array("twc" => "tab_web_cliente"), "twc.cod_cliente=two.cod_cliente", array("nom_cliente" => "twc.nom_cliente"));
        if ($params['cod_cliente'] != '')
            $select->where("two.cod_cliente=?", $params['cod_cliente']);

        if ($params['ind_status'] != '')
            $select->where("two.ind_status=?", $params['ind_status']);
        if ($params['dta_inicio'] != '')
            $select->where("two.dta_inicio >= ?", $this->dateen($params['dta_inicio']));

        if ($params['dta_final'] != '')
            $select->where("two.dta_termino <= ?", $this->dateen($params['dta_final']));

        if ($params['order_by'] != '')
            $select->order($params['order_by'] . ' ' . $params['ascdesc']);
        return $this->fetchAll($select)->toArray();
    }

}

?>
