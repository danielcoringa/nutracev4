<?php

/**
 * Description of Security
 * @category   PublicAnuncios
 * @package    Coringa_Controller
 * @copyright  Copyright (c) 2013-2013 CoringaSistemas INC (http://www.coringasistemas.com.br)
 */
class Alicerce_Model_DbTable_Grupo extends Coringa_Db_Table_Alicerce {

    protected $_name = 'tab_web_grupo';
    protected $_primary = 'cod_grupo';

    public function gridList($status, $ce) {
        $select = $this->select();
        $select->setIntegrityCheck(false);
        $select->from(array("tag" => "tab_web_grupo"));
        $select->where('tag.ind_status=?', $status);
        $select->where('tag.cod_empresa=?', $ce);
        return $this->fetchAll($select);
    }

    public function getGrupo($valor) {
        $select = $this->select();
        $select->where('cod_grupo=?', $valor);
        return $this->fetchRow($select);
    }

    public function getGrupoSelect() {
        return $this->fetchAll("ind_status='A'");
    }

}

?>
