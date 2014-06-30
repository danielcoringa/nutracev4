<?php

/* CLASSE LOGIN
 * *************************************************************
 * Desenvolvedor: RODRIGO DANIEL ANDRADE
 * Objetivo     : FORNECER LOGIN A DETERMINADA TELA
 * Bibliotecas  : Zend_Db_Table | Zend_Auth_Adapter | Zend_ACL
 * *************************************************************
 */

class Login_Model_Login {

    static function setLogin($login, $senha) {
        // Cria uma instancia de si mesmo
        $model = new self;
        // Criando um adaptador do banco de dados
        $db_login = Zend_Db_Table::getDefaultAdapter();


        // Criando um adaptador para o banco de dados usando
        // o Auth do Zend
        // os Parametros são ($adaptador, $tabela, $usuario, $senha, $criptografia
        $adaptar_login = new Zend_Auth_Adapter_DbTable($db_login, 'usuarios', 'usuario', 'senha');
        // Fazendo um Select
        $select = $adaptar_login->getDbSelect();
        // Aqui pode se aplicar um where
        $select->where('ativo = ?', 1);
        // Verificações do Auth
        $adaptar_login->setIdentity($login);
        $adaptar_login->setIdentityColumn('usuario');
        $adaptar_login->setCredential($senha);
        // Instancia o Auth
        $auth = Zend_Auth::getInstance();
        $result = $auth->authenticate($adaptar_login);
        if ($result->isValid()) {
            $select = $db_login->select();
            $select->from(array("twu" => "usuarios"));
            $select->join(array("twg" => "tiposusuarios"), 'twg.id=twu.tiposusuarios_id','twg.nome');
            $select->where("usuario like '" . $login . "'");
            $select->where("senha like '" . $senha . "'");
            $row = $db_login->fetchAll($select);
            return $row;
        } else {
            return $model->getMessages($result);
        }
    }

    // Função para tratar as mensagens de erro
    public function getMessages(Zend_Auth_Result $result) {
        switch ($result->getCode()) {
            case $result::FAILURE_IDENTITY_NOT_FOUND:
                $msg = "Acesso Negado. Usuário inválido!";
                break;
            case $result::FAILURE_IDENTITY_AMBIGUOUS:
                $msg = "Usuário ou senha inválidos!";
                break;
            case $result::FAILURE_CREDENTIAL_INVALID:
                $msg = "Acesso Negado. Senha inválida!";
                break;
            default:

                $msg = "Erro desconhecido.";
        }
        return $msg;
    }

}

?>
