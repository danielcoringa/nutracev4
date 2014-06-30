<?php

/**
 * Description of Security
 * @category   PublicAnuncios
 * @package    Coringa_Controller
 * @copyright  Copyright (c) 2013-2013 CoringaSistemas INC (http://www.coringasistemas.com.br)
 */
class Alicerce_Model_DbTable_Empresa extends Coringa_Db_Table_Alicerce {

    protected $_name = 'tab_web_empresa';
    protected $_primary = 'cod_empresa';

    public function gridList($status) {
        $select = $this->select();
        $select->where('ind_status=?', $status);
        return $this->fetchAll($select);
    }

    public function getDados($where = null) {
        $select = $this->select();
        if ($where !== null) {
            $select->where($where);
        }
        return $this->fetchAll($select);
    }

    public function getEmpresaDefault() {
//        $authNamespace = new Zend_Session_Namespace("auth");
//        $cod_empresa = $_SESSION['auth']['cod_empresa'];
//        $select = $this->select();
//        $select->where('ind_status=?', 'A');
//        if ($cod_empresa != '') {
//            $select->where('cod_empresa=?', $cod_empresa);
//            return $this->fetchRow($select);
//        }
//        else {
//            return false;
//        }
        return $this->fetchRow();
    }

}

?>
