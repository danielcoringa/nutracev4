<?php

class Alicerce_IndexController extends Coringa_Controller_Alicerce_Action {

    public function init() {
        /* Initialize action controller here */
        parent::init();
        parent::dashboard();
        parent::tables();
        parent::forms();
    }

    public function indexAction() {

        // action body
    }

    public function dashboardAction() {

        parent::norender();
        $dbc = new Alicerce_Model_DbTable_Cliente();
        $this->view->total_cliente = $dbc->getTotal('A');
        $dbl = new Alicerce_Model_DbTable_Locacao();
        $this->view->total_pedido = $dbl->getTotal('C');
        $dbem = new Alicerce_Model_DbTable_EquipamentoManutencao();
        $dbel = new Alicerce_Model_DbTable_EquipamentoLocacao();
        $dbcat = new Alicerce_Model_DbTable_Categoria();
        $dbwidget = new Alicerce_Model_DbTable_Widget();
        $this->view->widgets = $dbwidget->getWidget();
        $this->view->categorias = $dbcat->getCategoriaSelect();
        $this->view->total_pedido_ativo = $dbl->getTotal('A');
        $this->view->total_cancelado = $dbl->getTotal('I');
        $this->view->total_locado = $dbel->getEstoqueLocado();
        $this->view->total_pendente = $dbel->getEstoquePendente();
        $this->view->total_manutencao = $dbem->getEstoqueManutencao();
        $this->view->agenda = array(
            "minTime" => $this->config['agenda_min_time'],
            "maxTime" => $this->config['agenda_max_time'],
            "notification" => $this->config['agenda_notification'] == 'A' ? '/extras/agenda/m/notification' : '/extras/agenda'
        );
        $this->render('dashboard');
    }

    public function sobreAction() {
        parent::norender();
        $this->render('sobre');
    }

    public function termosDeUsoAction() {
        parent::norender();
        $this->render('termos-de-uso');
    }

    public function contatoAction() {
        parent::norender();
        $this->render('contato');
    }

}
