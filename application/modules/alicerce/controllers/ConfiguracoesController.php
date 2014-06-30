<?php

/**
 * Description of Security
 * @category   PublicAnuncios
 * @package    Coringa_Controller
 * @copyright  Copyright (c) 2013-2013 CoringaSistemas INC (http://www.coringasistemas.com.br)
 */
class Alicerce_ConfiguracoesController extends Coringa_Controller_Alicerce_Action {

    public function init() {
        parent::init();
        parent::norender();
        $this->view->empresa = $this->empresa;
        parent::verifyAjax();
    }

    public function contratoAction() {
        parent::tables();
        parent::forms();
        $request = $this->getRequest();
        if ($request->isPost()) {
            $dados = $request->getPost();
            $db = new Alicerce_Model_DbTable_Configuracao();
            $sel = $db->fetchRow();
            if (count($sel) > 0) {
                $mode = 'Alterado';
                $update = $db->update($dados, "cod_configuracao=1");
            }
            else {
                $mode = 'Adicionado';
                $insert = $db->insert($dados);
            }
            echo "$.jGrowl('Registro {$mode} com Sucesso!');";
            echo "$(':submit').removeAttr('disabled');";
            exit;
        }
        $params = $request->getParams();

        $this->view->config = $this->config;
    }

    public function unidadesAction() {
        parent::tables();
        $this->render('unidades/index');
    }

    public function unidadesCadastroAction() {
        $params = $this->getRequest()->getParams();
        parent::forms();
        $dc = new Alicerce_Model_DbTable_Unidade();
        if ($params['editar'] != '') {
            $this->view->data = $dc->getDados($params['editar']);
        }
        $request = $this->getRequest();
        if ($request->isPost()) {
            $dados = $request->getPost();
            unset($dados['radio']);
            if ($params['editar'] != '') {
                $mode = 'Alterado';
                $insert = $dc->update($dados, 'cod_unidade=' . $params['editar']);
            }
            else {
                $mode = 'Adicionado';
                $insert = $dc->insert($dados);
            }
            if ($insert > 0) {
                echo "$.jGrowl('Registro {$mode} com Sucesso!');";
                echo "$('form').clear();";
                echo "$(':submit').removeAttr('disabled');";
                exit;
            }
        };
        $this->render('unidades/cadastro');
    }

    public function empresaAction() {
        parent::forms();
        $db = new Alicerce_Model_DbTable_Empresa();
        $this->view->data = $db->getEmpresaDefault();
        $dbE = new Alicerce_Model_DbTable_Estados();
        $this->view->estados = $dbE->getEstados();
        $dc = new Alicerce_Model_DbTable_Cidades();
        $this->view->cidades = $dc->getCidade($this->view->data['des_estado']);

        $request = $this->getRequest();
        if ($request->isPost()) {
            $dados = $request->getPost();
            unset($dados['radio']);
            $cod_empresa = $dados['cod_empresa_ed'];
            unset($dados['cod_empresa_ed']);
            if ($dados['cod_empresa_ed'] !== '') {
                $mode = 'Alterado';
                $db->update($dados, "cod_empresa=" . $cod_empresa);
            }
            else {
                $mode = 'Adicionado';
                $db->insert($dados);
            }
            echo "$.jGrowl('Registro {$mode} com Sucesso!');";
            echo "$(':submit').removeAttr('disabled');";
            exit;
        }

        $this->render('empresa/cadastro');
    }

    public function backupAction() {
        $request = $this->getRequest();


        if ($request->isPost()) {
            $dados = $request->getPost();

            $db = new Alicerce_Model_DbTable_Configuracao();
            $db->update($dados, 'cod_configuracao=1');
            echo "$.jGrowl('Configurações alteradas com Sucesso!');";
            echo "$('button').removeAttr('disabled');";
            exit;
        }
        $this->view->data = $this->config;
        $this->render('backup');
    }

}

?>
