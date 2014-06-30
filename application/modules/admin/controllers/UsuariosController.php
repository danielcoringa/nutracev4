<?php

/*
 * Sistema Lincenciado para uso exclusivo pela FeedBack Sistemas
 * *************************************************************
 * Informações do Sistema:
 * *************************************************************
 * Framework: Zend Framework
 * Versão...: 1.12
 * Developer: Rodrigo Daniel
 * Librarys.: Coringa, Zend
 * Modificado Em 20/06/2014
 * *************************************************************
 */

/**
 * Controlador UsuariosController
 *
 * @author Rodrigo
 */
class Admin_UsuariosController extends Coringa_Controller_Admin_Action {

// Inicializando o Controlador
    public function init() {
// Códigos de Inicialização
        parent::init();
        $this->view->title = 'Usuários';
        $this->view->nom_modulo = 'usuarios';
        $this->bd = new Admin_Model_DbTable_Usuarios();
        $this->view->campos = $this->bd->getcamposLst();
    }

// Ação INDEX
    public function indexAction() {
        $this->breadCrumb();
        $this->view->description = 'Listagem de Usuários';
        $this->renderScript('/listar/listar.phtml');
    }

    public function perfilAction() {
        // Verifica requisição
        $params = $this->getRequest()->getParams();
        if (isset($params['id'])) {
            $this->view->user = $this->bd->listar(null, array('id' => $params['id']));
        } else {
            $this->view->user = $this->bd->listar(null, array('id' => $_SESSION['auth']['user_id']));
        }
        $this->breadCrumb();
        $this->view->description = 'Perfil de Usuário';
    }

}
