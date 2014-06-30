<?php

/**
 * Description of Security
 * @category   PublicAnuncios
 * @package    Coringa_Controller
 * @copyright  Copyright (c) 2013-2013 CoringaSistemas INC (http://www.coringasistemas.com.br)
 */
class Alicerce_ClientesController extends Coringa_Controller_Alicerce_Action {

    public function init() {
        parent::init();
        parent::norender();
        $this->view->empresa = $this->empresa;
        parent::verifyAjax();
    }

    public function indexAction() {
        $this->listagemAction();
    }

    public function listagemAction() {

        $this->render("index");
    }

    public function cadastroAction() {
        $params = $this->getRequest()->getParams();
        $dt = new Alicerce_Model_DbTable_Cliente();
        $dc = new Alicerce_Model_DbTable_Cidades();
        if ($params['editar'] != '') {
            $data = $dt->getCliente($params['editar']);
            $this->view->data = $data;
            $this->view->cidades = $dc->getCidade($data['des_estado']);
        }
        $request = $this->getRequest();
        if ($request->isPost()) {
            $this->_helper->viewRenderer->setNoRender(TRUE);
            $dados = $request->getPost();
            unset($dados['radio']);
            if ($dados['cod_cliente'] != '') {
                $codcliente = $dados['cod_cliente'];
                unset($dados['cod_cliente']);

                $insert = $dt->update($dados, 'cod_cliente=' . $codcliente);
                $mode = 'Alterado';
            }
            else {
                $insert = $dt->insert($dados);
                $mode = 'Adicionado';
            }

            echo "$.jGrowl('Registro {$mode} com Sucesso!');";
            echo "location.hash = 'clientes/listagem';";
            exit;
        };
        $dbe = new Alicerce_Model_DbTable_Estados();
        $this->view->estados = $dbe->getEstados();
        $this->render("cadastro");
    }

    public function coResponsabilidadeAction() {
        parent::tables();
        $this->render("co-responsabilidade/index");
    }

    public function coResponsabilidadeCadastroAction() {
        $params = $this->getRequest()->getParams();
        parent::forms();
        $db = new Alicerce_Model_DbTable_Cliente();
        if ($params['editar'] != '') {
            $dc = new Alicerce_Model_DbTable_Cidades();
            $data = $db->getCobranca($params['editar']);
            $this->view->cidades = $dc->getCidade($data['des_estado']);
            $this->view->data = $data;
        }
        $this->view->cocliente = $db->getClienteSelect();
        $request = $this->getRequest();
        if ($request->isPost()) {
            $this->_helper->viewRenderer->setNoRender(TRUE);
            $dados = $request->getPost();
            unset($dados['radio']);
            if ($dados['cod_cliente'] != '') {
                $codcliente = $dados['cod_cliente'];
                unset($dados['cod_cliente']);

                $insert = $db->update($dados, 'cod_cliente=' . $codcliente);
                $mode = 'Alterado';
            }
            else {
                $insert = $db->insert($dados);
                $mode = 'Adicionado';
            }

            echo "$.jGrowl('Registro {$mode} com Sucesso!');";
            echo "location.hash = 'clientes/co-responsabilidade';";
            exit;
        };
        $dbe = new Alicerce_Model_DbTable_Estados();
        $this->view->estados = $dbe->getEstados();
        $this->render("co-responsabilidade/cadastro");
    }

    public function cobrancaAction() {
        parent::tables();

        $this->render("cobranca/index");
    }

    public function cobrancaCadastroAction() {
        $params = $this->getRequest()->getParams();
        parent::forms();
        $db = new Alicerce_Model_DbTable_Cobranca();
        $dbc = new Alicerce_Model_DbTable_Cliente();
        if ($params['editar'] != '') {
            $dc = new Alicerce_Model_DbTable_Cidades();
            $data = $db->getCobranca($params['editar']);
            $this->view->cidades = $dc->getCidade($data['des_estado']);
            $this->view->data = $data;
        }
        $this->view->cliente = $dbc->getClienteSelect();
        $dbes = new Alicerce_Model_DbTable_Estados();
        $this->view->estados = $dbes->getEstados();
        $request = $this->getRequest();
        if ($request->isPost()) {
            $dados = $request->getPost();
            unset($dados['radio']);

            if ($dados['cod_cobranca'] != '') {
                $insert = $db->update($dados, 'cod_cobranca=' . $dados['cod_cobranca']);
                $mode = 'Alterado';
            }
            else {
                $insert = $db->insert($dados);
                $mode = 'Adicionado';
            }

            echo "$.jGrowl('Registro {$mode} com Sucesso!');";
            echo "location.hash = 'clientes/cobranca';";
            exit;
        };

        $this->render("cobranca/cadastro");
    }

    public function addResponsavelAction() {
        $this->norenderall();
    }

}

?>
