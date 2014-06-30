<?php

/**
 * Description of Security
 * @category   Nutrace
 * @package    Coringa_Controller
 * @copyright  Copyright (c) 2013-2013 CoringaSistemas INC (http://www.coringasistemas.com.br)
 */
class Admin_Model_DbTable_Locais extends Zend_Db_Table_Abstract {

    protected $_name = 'locais';
    protected $_primary = 'id';

    public function gridList() {
        $select = $this->select();
        $select->where("ativo=?", 1);
        return $this->fetchAll($select);
    }

    public function inserir($dados) {
        
        return $dados;
    }
    public function getDados($where = '') {
        $select = $this->select();
        $select->where("usuarios_id=?", $where);
        return $this->fetchAll($select)->toArray();
    }

    public function getSelect() {
        return $this->fetchAll('ativo=1')->toArray();
    }
    public function getColunas(){
        $cols = array("id","nome","endereco","cidade","uf");
        return $cols;
    }

    
    

    

}
