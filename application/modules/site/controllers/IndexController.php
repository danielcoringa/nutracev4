<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class Site_IndexController extends Zend_Controller_Action {

    public function indexAction() {
        $categoria = new Site_Model_DbTable_Categoria();
        $dadosc = $categoria->getSelect();
        $this->view->dados_categoria = $dadosc;
        unset($categoria);
        
        $this->view->rb = array(0=>"warning",1=>"success",2=>"info",3=>"danger",4=>"default");
        
        $portfolio = new Site_Model_DbTable_Portfolio();
        $dadosp = $portfolio->getSelect();
        $this->view->dados_portfolio = $dadosp;
        unset($portfolio);
    }

}
