<?php

/**
 * Description of Security
 * @category   PublicAnuncios
 * @package    Coringa_Controller
 * @copyright  Copyright (c) 2013-2013 CoringaSistemas INC (http://www.coringasistemas.com.br)
 */
class Admin_Model_DbTable_Conf_Geral extends Zend_Db_Table_Abstract {

    protected $_name = 'tab_conf_geral';
    protected $_primary = 'cod_conf_geral';

    public function getConf() {
        return $this->fetchRow();
    }

}
