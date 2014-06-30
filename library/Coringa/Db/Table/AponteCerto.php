<?php

class Coringa_Db_Table_AponteCerto extends Zend_Db_Table_Abstract {
/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
 public function __construct($config = array())
    {
        $this->_setAdapter(Zend_Registry::get('coringa_apontecerto'));
        $this->setDefaultAdapter(Zend_Registry::get('coringa_apontecerto'));
        parent::__construct($config);
        
    }
    
}
?>
