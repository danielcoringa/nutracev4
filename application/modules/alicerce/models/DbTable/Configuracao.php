<?php

/**
 * Description of Security
 * @category   PublicAnuncios
 * @package    Coringa_Controller
 * @copyright  Copyright (c) 2013-2013 CoringaSistemas INC (http://www.coringasistemas.com.br)
 */
class Alicerce_Model_DbTable_Configuracao extends Coringa_Db_Table_Alicerce {

    protected $_name = 'tab_web_configuracao';
    protected $_primary = 'cod_configuracao';

    public function config() {
        $result = $this->fetchRow();
        if (count($result) > 0) {
            return $result->toArray();
        }
    }

}
