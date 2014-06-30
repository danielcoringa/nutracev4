<?php

/**
 * Coringa Sistemas
 * @category   PublicAnuncios
 * @package    Coringa_Controller
 * @copyright  Copyright (c) 2013-2014 CoringaSistemas INC (http://www.coringasistemas.com.br :: http://www.rodrigodaniel.com.br)
 */
class Coringa_Controller_Blog_Action extends Zend_Controller_Action {

    public function init() {
        $dbc = new Admin_Model_DbTable_Categoria();
        $params = $this->getRequest()->getParams();
        $this->view->entrymode = $params;

        $this->view->categorias = $dbc->getSelect();
    }

    public function noRender() {

        /* $this->_helper->layout->disableLayout(); */
        $this->_helper->viewRenderer->setNoRender(TRUE);
    }

    public function flickrs() {
        $flickr = new Zend_Service_Flickr('a596d0ee3afb48aa81730f1ce1077d6e');
        $results = $flickr->userSearch("danielcoringa");
        $flickrs = array();
        foreach ($results as $result) {
            $flickrs[] = $result;
        }
        $this->view->flickrs = $flickrs;
    }

    public function noLayout() {
        $this->view->keyInternal = $_SESSION['checkin']['site'];
    }

}
