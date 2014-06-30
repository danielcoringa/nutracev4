<?php

/**
 * Description of Security
 * @category   PublicAnuncios
 * @package    Coringa_Controller
 * @copyright  Copyright (c) 2013-2013 CoringaSistemas INC (http://www.coringasistemas.com.br)
 */
class Alicerce_ObrasController extends Coringa_Controller_Alicerce_Action {

    public function init() {
        parent::init();
        parent::norender();
        $this->view->empresa = $this->empresa;
    }

    public function listagemAction() {
        parent::tables();
        $this->render('index');
    }

    public function cadastroAction() {
        $params = $this->getRequest()->getParams();

        parent::forms();
        $dbc = new Alicerce_Model_DbTable_Cliente();
        $this->view->cliente = $dbc->getClienteSelect();
        $dbe = new Alicerce_Model_DbTable_Estados();
        $this->view->estados = $dbe->getEstados();
        $db = new Alicerce_Model_DbTable_Obra();
        $dc = new Alicerce_Model_DbTable_Cidades();
        if ($params['editar'] != '') {
            $data = $db->getObra($params['editar']);
            $this->view->cidades = $dc->getCidade($data['des_estado']);
            $this->view->data = $data;
        }
        $request = $this->getRequest();
        if ($request->isPost()) {
            $dados = $request->getPost();
            $da = $dados['dta_inicio'];
            $da = explode("/", $da);
            $datual = $da[2] . '-' . $da[1] . '-' . $da[0];
            unset($dados['dta_inicio']);
            $dados['dta_inicio'] = $datual;
            unset($dados['radio']);

            if ($dados['cod_obra'] != '') {
                $mode = 'Alterado';
                $insert = $db->update($dados, 'cod_obra=' . $dados['cod_obra']);
            }
            else {
                $mode = 'Adicionado';
                $insert = $db->insert($dados);
            }


            echo "$.jGrowl('Registro {$mode} com Sucesso!');";
            echo "location.hash = 'obras/listagem';";
            exit;
        }
        $this->render('cadastro');
    }

    public function equipamentosAction() {
        $this->render("wait/index");
    }

}

?>
