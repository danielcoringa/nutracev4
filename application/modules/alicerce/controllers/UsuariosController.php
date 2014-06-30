<?php

/**
 * Description of Security
 * @category   PublicAnuncios
 * @package    Coringa_Controller
 * @copyright  Copyright (c) 2013-2013 CoringaSistemas INC (http://www.coringasistemas.com.br)
 */
class Alicerce_UsuariosController extends Coringa_Controller_Alicerce_Action {

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
        $dt = new Alicerce_Model_DbTable_Usuario();
        if ($params['editar'] != '') {

            $this->view->data = $dt->getUsuario($params['editar']);
        }
        $request = $this->getRequest();
        if ($request->isPost()) {
            $dados = $request->getPost();
            if (strlen($dados['des_senha']) < 30) {
                $senha = md5($dados['des_senha']);
                unset($dados['des_senha']);
                $dados['des_senha'] = $senha;
            }

            if ($dados['cod_usuario'] != '') {
                $mode = 'Alterado';
                $insert = $dt->update($dados, 'cod_usuario=' . $dados['cod_usuario']);
            }
            else {
                $mode = 'Adicionado';
                $insert = $dt->insert($dados);
            }

            echo "$.jGrowl('Registro {$mode} com Sucesso!');";
            echo "location.hash = 'usuarios/listagem';";
            exit;
        };
        $dbg = new Alicerce_Model_DbTable_Grupo();
        $this->view->grupos = $dbg->getGrupoSelect();
    }

    public function gruposAction() {
        parent::tables();
        $this->render("grupos/index");
    }

    public function gruposCadastroAction() {
        parent::forms();
        $params = $this->getRequest()->getParams();
        $dt = new Alicerce_Model_DbTable_Grupo();
        if ($params['editar'] != '') {

            $this->view->data = $dt->getGrupo($params['editar']);
        }
        $request = $this->getRequest();
        if ($request->isPost()) {
            $dados = $request->getPost();
            if ($dados['cod_grupo'] != '') {
                $mode = 'Alterado';
                $insert = $dt->update($dados, 'cod_grupo=' . $dados['cod_grupo']);
            }
            else {
                $mode = 'Adicionado';
                $insert = $dt->insert($dados);
            }


            echo "$.jGrowl('Registro {$mode} com Sucesso!');";
            echo "location.hash = 'usuarios/grupos';";
            exit;
        };
        $this->render("grupos/cadastro");
    }

}

?>
