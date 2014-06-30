<?php

class Alicerce_AjaxController extends Coringa_Controller_Alicerce_Action {

    public function init() {
        parent::norenderall();
    }

    public function indexAction() {
        parent::dashboard();
        parent::tables();
        parent::forms();
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
        $this->view->realRender = "index/dashboard.phtml";
    }

    public function locacoesAction() {
        parent::tables();
        $tipo = $this->getRequest()->getParams();
        if ($tipo == 'ativas') {
            $this->view->mode = 'Ativas';
        }
        else {
            $this->view->mode = 'Concluídas';
        }
        $this->view->table = 'locacaoa';
        $this->view->realRender = "locacoes/index.phtml";

        $this->render('index');
    }

    public function addOptionAction() {
        $params = $this->getRequest()->getPost();
        $tabela = $params['tabela'];
        $campo = $params['campo'];
        $camporef = $params['camporef'];
        $valor = $params['valor'];
        $dbt = 'Alicerce_Model_DbTable_' . ucfirst($tabela);
        $db = new $dbt();

        if (isset($params['value_ref'])) {
            $campo_name = $params['camponamed'];
            $val_ref = $params['value_ref'];
            $dados[$campo_name] = $val_ref;
        }
        if (isset($params['campofixo'])) {
            $dv = explode(",", $params['campofixo']);
            foreach ($dv as $dvv) {
                $dt = explode("=", $dvv);
                $dados[$dt[0]] = $dt[1];
            }
        }
        $dados[$campo] = $valor;
        $insert = $db->insert($dados);
        $retorno = '$("#' . $camporef . '").append("<option value=\'' . $insert . '\'>' . $valor . '</option>");';
        $retorno.= '$("#' . $camporef . '").trigger("liszt:updated");';

        echo $retorno;
    }

}

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

