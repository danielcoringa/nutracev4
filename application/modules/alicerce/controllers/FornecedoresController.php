<?php

/**
 * Description of Security
 * @category   PublicAnuncios
 * @package    Coringa_Controller
 * @copyright  Copyright (c) 2013-2013 CoringaSistemas INC (http://www.coringasistemas.com.br)
 */
class Alicerce_FornecedoresController extends Coringa_Controller_Alicerce_Action {

    public function init() {
        parent::init();
        parent::norender();
        $this->view->empresa = $this->empresa;
        parent::verifyAjax();
    }

    public function listagemAction() {
        parent::tables();
        $this->render("index");
    }

    public function cadastroAction() {
        $params = $this->getRequest()->getParams();
        parent::forms();
        $dt = new Alicerce_Model_DbTable_Fornecedor();
        $dcat = new Alicerce_Model_DbTable_Categoria();


        $this->view->categorias = $dcat->getCategoriaSelect();
        if ($params['editar'] != '') {
            $data = $dt->getDados($params['editar']);
            $this->view->data = $data;
            $dc = new Alicerce_Model_DbTable_Cidades();
            $this->view->cidades = $dc->getCidade($data['des_estado']);
        }
        $request = $this->getRequest();
        if ($request->isPost()) {
            $dados = $request->getPost();
            unset($dados['radio']);

            if ($dados['cod_fornecedor'] != '') {
                $mode = 'Alterado';
                $insert = $dt->update($dados, 'cod_fornecedor=' . $dados['cod_fornecedor']);
            }
            else {
                $mode = 'Adicionado';
                $insert = $dt->insert($dados);
            }

            echo "$.jGrowl('Registro {$mode} com Sucesso!');";
            echo "location.hash = 'fornecedores/listagem';";
            exit;
        };

        $db = new Alicerce_Model_DbTable_Estados();
        $this->view->estados = $db->getEstados();
    }

}

?>
