<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class Admin_CategoriasController extends Coringa_Controller_Admin_Action {

    public function init() {

    }

    public function indexAction() {

    }

    public function cadastroAction() {
        // $this->noRender();
        $db = new Admin_Model_DbTable_Categoria();
        $params = $this->getRequest()->getParams();
        $request = $this->getRequest();
        $dados = $request->getPost();
        if ($request->isPost()) {
            $this->noRender();
            if ($params['editar'] > 0) {

                $registro = $db->atualizar($dados);
            }
            else {
                $registro = $db->inserir($dados);
            }
            echo "categorias";
        }
        else {
            $form = new Coringa_Form_Dinamico();

            if ($params['editar'] > 0) {
                $dados = $db->getDados($params['editar']);
            }
            $form->setTable($db);
            $this->view->elements = $form->drawElements($dados);
        }
    }

    public function listaAction() {
        $this->noRender();
        $db = new Admin_Model_DbTable_Categoria();
        echo $db->grid($_GET['sEcho']);
    }

}
