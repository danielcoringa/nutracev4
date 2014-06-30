<?php

/**
 * Description of Security
 * @category   PublicAnuncios
 * @package    Coringa_Controller
 * @copyright  Copyright (c) 2013-2013 CoringaSistemas INC (http://www.coringasistemas.com.br)
 */
class Alicerce_Model_DbTable_Widget extends Coringa_Db_Table_Alicerce {

    protected $_name = 'tab_web_widget';
    protected $_primary = 'cod_widget';

    public function getWidget() {
        $select = $this->select();
        $select->order("num_ordem ASC");
        return $this->fetchAll($select)->toArray();
    }

}

?>
