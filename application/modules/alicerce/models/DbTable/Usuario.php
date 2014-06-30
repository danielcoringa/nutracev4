<?php

/**
 * Description of Security
 * @category   PublicAnuncios
 * @package    Coringa_Controller
 * @copyright  Copyright (c) 2013-2013 CoringaSistemas INC (http://www.coringasistemas.com.br)
 */
class Alicerce_Model_DbTable_Usuario extends Coringa_Db_Table_Alicerce {

    protected $_name = 'tab_web_usuario';
    protected $_primary = 'cod_usuario';

    public function gridList($status) {
        $select = $this->select();
        $select->setIntegrityCheck(false);
        $select->from(array("tau" => "tab_web_usuario"));
        $select->joinInner(array("tag" => "tab_web_grupo"), "tag.cod_grupo=tau.cod_grupo", array("nom_grupo" => "tag.nom_grupo"));
        $select->where('tau.ind_status=?', $status);

        return $this->fetchAll($select);
    }

    public function getUsuario($val) {
        $select = $this->select();
        $select->where("cod_usuario=?", $val);
        return $this->fetchRow($select);
    }

}

?>
