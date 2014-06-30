<?php
/**
 * Controller Login de Usuários no Sistema
 * *****************************************
 * Descrição...:Resposável pelo acesso dos usuários e administradores no Sistema
 * Views.......:Index / Logout
 * Data Criação:22/06/2014
 * Autor.......:Rodrigo Daniel
 * Email.......:email@rodrigodaniel.com.br
 * Suporte.....:suporte@rodrigodaniel.com.br
 * Site........:http://www.rodrigodaniel.com.br
 * Empresa.....:Feedback LTDA
 */
class Login_IndexController extends Coringa_Controller_Login_Action {

    public function init() {
        /* Inicialização dos Controllers */
        parent::init();
        //parent::tradicional();
    }
    /**
     * Ação Index - /login/index
     * **************************
     * Descrição...: Recebe os dados e direciona o usuário para sua respectiva
     *               view
     */
    public function indexAction() {
        // Armazena a requisição do usuário
        $request = $this->_request; 
        // Armazena os erros
        $errorv = $this->getRequest()->getParam('error'); 
        // Armazena o destino do usuário
        $this->view->controle = $this->getRequest()->getParam('origem');
        // Se o erro for encontrado mostra a mensagem de erro.
        if (isset($errorv)) {
            $this->_helper->FlashMessenger(array("alert alert-error" => "Acesso Restrito. Sem Permissão."));
        }
        // Se a requisição foi pelo formulário de login
        if ($request->isPost()) {
            // Armazena os dados do formulário
            $data = $request->getPost();
            
            // Executa o método de login 
            $login = Login_Model_Login::setLogin($data['login_name'], $data['login_pw']);
            
            // Verifica se o retorno é uma matriz
            if (is_array($login)) {
                // Faz conexao com o banco de dados e pega os dados do usuario
                $authNamespace = new Zend_Session_Namespace("auth");
                
                $authNamespace->users = true;
                $authNamespace->user_id = $login[0]['id'];
                $authNamespace->username = $login[0]['usuario'];
                $authNamespace->user_pwd = $login[0]['senha'];
                $authNamespace->grupo_id = $login[0]['tiposusuario_id'];
                $authNamespace->role = strtolower($login[0]['nome']);
                // Remove a renderização
                $this->norenderall();
                // Redireciona o usuário
                $this->_redirect('/');
                exit;
            } 
            // Se o retorno não é uma matriz então é um erro
            else {
                $authNamespace = new Zend_Session_Namespace("auth");
                $authNamespace->users = false;
                $this->_helper->FlashMessenger(array("alert alert-error" => $login));
            }
        }
    }
    /**
     * Ação Logout - /login/logout
     * ***************************
     * Descrição...: Responsável para finalizar a sessão do usuário no sistema
     */
    public function logoutAction() {

        $this->_helper->layout->disableLayout();
        $this->_helper->viewRenderer->setNoRender(TRUE);
        session_destroy();
        $this->_redirect('/');
    }

}
