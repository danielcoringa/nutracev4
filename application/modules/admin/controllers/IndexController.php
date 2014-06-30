<?php

class Admin_IndexController extends Coringa_Controller_Admin_Action {

    public function init() {
        /* Initialize action controller here */
        parent::init();
        $this->view->nom_modulo = 'index';
    }

    public function indexAction() {
        // action body

        $this->view->description = 'Estatísticas e Mais';
        $this->view->plugins = $this->getPlugin('dateRange');
        $this->breadCrumb();
    }

    public function uiElementsAction() {
        
    }

    public function loginAction() {
        
    }

}
