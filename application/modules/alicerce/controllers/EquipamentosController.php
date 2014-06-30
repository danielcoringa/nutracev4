<?php

/**
 * Description of Security
 * @category   PublicAnuncios
 * @package    Coringa_Controller
 * @copyright  Copyright (c) 2013-2013 CoringaSistemas INC (http://www.coringasistemas.com.br)
 */
class Alicerce_EquipamentosController extends Coringa_Controller_Alicerce_Action {

    public function init() {
        parent::init();
        parent::norender();
        $this->view->empresa = $this->empresa;
        parent::verifyAjax();
    }

    public function indexAction() {
        $this->render('index');
    }

    public function categoriasAction() {


        $this->render('categorias/index');
    }

    public function categoriasCadastroAction() {
        $params = $this->getRequest()->getParams();

        $dc = new Alicerce_Model_DbTable_Categoria();
        if ($params['editar'] != '') {
            $this->view->data = $dc->getCategoria($params['editar']);
        }
        $request = $this->getRequest();
        if ($request->isPost()) {
            $dados = $request->getPost();
            unset($dados['radio']);
            if ($dados['cod_categoria'] != '') {
                $mode = 'Alterado';
                $insert = $dc->update($dados, 'cod_categoria=' . $dados['cod_categoria']);
            }
            else {
                $mode = 'Adicionado';
                $insert = $dc->insert($dados);
            }
            echo "$.jGrowl('Registro {$mode} com Sucesso!');";
            echo "location.hash = 'equipamentos/categorias';";
            exit;
        };
        $this->render('categorias/cadastro');
    }

    public function listagemSimplesAction() {

        $this->render('index');
    }

    public function listagemAction() {

        $this->render('index2');
    }

    public function cadastroAction() {
        $params = $this->getRequest()->getParams();

        $dc = new Alicerce_Model_DbTable_Equipamento();
        $dcat = new Alicerce_Model_DbTable_Categoria();
        $dm = new Alicerce_Model_DbTable_Modelo();
        $du = new Alicerce_Model_DbTable_Unidade();
        $da = new Alicerce_Model_DbTable_Acessorio();
        $this->view->categorias = $dcat->getCategoriaSelect();
        $this->view->modelos = $dm->getDadosSelect();
        $this->view->unidades = $du->getDadosSelect();
        if ($params['editar'] != '') {
            $this->view->data = $dc->getEquipamento($params['editar']);
            $img_e = new Alicerce_Model_DbTable_Imagem();
            $forn = new Alicerce_Model_DbTable_Fornecedor();
            $this->view->img_equipamento = $img_e->getImagens($params['editar']);
            $this->view->fornecedores = $forn->getDadosCategoria($this->view->data['cod_categoria']);
        }
        $request = $this->getRequest();
        if ($request->isPost()) {
            $dados = $request->getPost();
            unset($dados['radio']);

            $dados_imagem = $dados['imglist'];
            unset($dados['imglist']);

            if ($dados['cod_equipamento'] != '') {
                $update = $dc->update($dados, 'cod_equipamento=' . $dados['cod_equipamento']);
                $update = $dc->update($dados, 'cod_equipamento_dup=' . $dados['cod_equipamento']);
                $mode = 'Alterado';
                // Adiciona as imagens no banco de dados
                $db = new Alicerce_Model_DbTable_Imagem();
                $delete = $db->delete("cod_equipamento=" . $dados['cod_equipamento']);

                foreach ($dados_imagem as $img) {

                    $dados_img['cod_equipamento'] = $dados['cod_equipamento'];
                    $dados_img['link_imagem'] = $img;
                    $db->insert($dados_img);
                }
            }
            else {
                $mode = 'Adicionado';
                $dados['qtd_estoque_atual'] = $dados['qtd_estoque_efetivo'];
                $insert = $dc->insert($dados);

                if ($insert > 0) {
                    // Adiciona as imagens no banco de dados
                    $db = new Alicerce_Model_DbTable_Imagem();
                    if (count($dados_imagem) > 0)
                        foreach ($dados_imagem as $img) {
                            $dados_img['cod_equipamento'] = $insert;
                            $dados_img['link_imagem'] = $img;
                            $db->insert($dados_img);
                        }
                }
            }
            echo "$.jGrowl('Registro {$mode} com Sucesso!');";
            echo "location.hash = 'equipamentos/listagem';";
            exit;
        };
    }

    public function uploadAction() {
        $this->_helper->layout->disableLayout();
        $this->_helper->viewRenderer->setNoRender(TRUE);
        $uploadimg = new Alicerce_Model_UploadImage(); // Carrega a classe de tratamento de imagens
        $folder = BASIC_FOLDER . '/media/';
        $uploadimg->setFolder($folder); // Atribui a pasta para uploads
        $uploadimg->sendFile($_FILES); // Envia as imagens para a pasta
    }

    public function estoqueAction() {


        $this->render('estoque/index');
    }

    public function reservasAction() {
        $this->render('wait/index');
    }

    public function modelosAction() {

        $this->render('modelos/index');
    }

    public function modelosCadastroAction() {

        $params = $this->getRequest()->getParams();

        $dc = new Alicerce_Model_DbTable_Modelo();
        if ($params['editar'] != '') {
            $this->view->data = $dc->getDados($params['editar']);
        }
        $request = $this->getRequest();
        if ($request->isPost()) {
            $dados = $request->getPost();
            unset($dados['radio']);
            if ($dados['cod_modelo'] != '') {
                $mode = 'Alterado';
                $insert = $dc->update($dados, 'cod_modelo=' . $dados['cod_modelo']);
            }
            else {
                $mode = 'Adicionado';
                $insert = $dc->insert($dados);
            }

            echo "$.jGrowl('Registro {$mode} com Sucesso!');";
            echo "location.hash = 'equipamentos/modelos';";
            exit;
        };
        $this->render('modelos/cadastro');
    }

    public function acessoriosAction() {

        $this->render('acessorios/index');
    }

    public function acessoriosCadastroAction() {

        $params = $this->getRequest()->getParams();
        parent::forms();
        $dc = new Alicerce_Model_DbTable_Acessorio();
        $de = new Alicerce_Model_DbTable_Equipamento();

        $du = new Alicerce_Model_DbTable_Unidade();

        $this->view->unidades = $du->getDadosSelect();
        $this->view->equipamentos = $de->getDadosSelect();
        if ($params['editar'] != '') {
            $this->view->data = $dc->getDados($params['editar']);
        }
        $request = $this->getRequest();
        if ($request->isPost()) {
            $dados = $request->getPost();
            unset($dados['radio']);
            if ($dados['cod_acessorio'] != '') {
                $mode = 'Alterado';
                $insert = $dc->update($dados, 'cod_acessorio=' . $dados['cod_acessorio']);
            }
            else {
                $mode = 'Adicionado';
                $insert = $dc->insert($dados);
            }
            echo "$.jGrowl('Registro {$mode} com Sucesso!');";
            echo "location.hash = 'equipamentos/acessorios';";
            exit;
        };
        $this->render('acessorios/cadastro');
    }

    public function manutencaoAction() {
        $this->render('manutencao/index');
    }

    public function manutencaoCadastroAction() {
        $db = new Alicerce_Model_DbTable_EquipamentoManutencao();
        $dcat = new Alicerce_Model_DbTable_Categoria();
        $this->view->categorias = $dcat->getCategoriaSelect();
        $request = $this->getRequest();
        $codm = $request->getParam('editar');
        $dbe = new Alicerce_Model_DbTable_Equipamento();
        if ($codm > 0) {
            $this->view->data = $db->getEquipamentoManutencao($codm);

            $this->view->equipamentos = $dbe->getDadosSelect();
        }
        if ($request->isPost()) {
            $dados = $request->getPost();
            unset($dados['radio']);
            unset($dados['cod_categoria']);
            $da = $dados['dta_manutencao'];
            $da = explode("/", $da);
            $datual = $da[2] . '-' . $da[1] . '-' . $da[0];
            unset($dados['dta_manutencao']);
            $dados['dta_manutencao'] = $datual;
            $da = $dados['dta_retorno'];
            $da = explode("/", $da);
            $datual = $da[2] . '-' . $da[1] . '-' . $da[0];
            unset($dados['dta_retorno']);
            $dados['dta_retorno'] = $datual;
            if ($dados['cod_equipamento_manutencao'] != '') {
                $mode = 'Alterado';
                $ant = $db->getEquipamentoManutencao($dados['cod_equipamento_manutencao']);
                $qea = $ant['qtd_equipamento'];
                $ret = $dbe->getEquipamento($dados['cod_equipamento']);
                $atual = $ret['qtd_estoque_atual'];
                $ddr['qtd_estoque_atual'] = ($atual + $qea);
                $dbe->update($ddr, "cod_equipamento=" . $dados['cod_equipamento']);
                for ($x = 0; $x < $dados['qtd_equipamento']; $x++) {
                    $ret = $dbe->getEquipamento($dados['cod_equipamento']);
                    $atual = $ret['qtd_estoque_atual'];
                    $atual--;
                    $dd['qtd_estoque_atual'] = $atual;
                    $dbe->update($dd, "cod_equipamento=" . $dados['cod_equipamento']);
                }

                $insert = $db->update($dados, 'cod_equipamento_manutencao=' . $dados['cod_equipamento_manutencao']);
            }
            else {
                $mode = 'Adicionado';
                for ($x = 0; $x < $dados['qtd_equipamento']; $x++) {
                    $ret = $dbe->getEquipamento($dados['cod_equipamento']);
                    $atual = $ret['qtd_estoque_atual'];
                    $total = $ret['qtd_estoque_efetivo'];
                    $atual--;
                    $dd['qtd_estoque_atual'] = $atual;

                    $dbe->update($dd, "cod_equipamento=" . $dados['cod_equipamento']);
                }
                $insert = $db->insert($dados);
            }
            echo "$.jGrowl('Registro {$mode} com Sucesso!');";
            echo "location.hash = 'equipamentos/manutencao';";
            exit;
        }
        $this->render('manutencao/cadastro');
    }

    public function adiarAction() {
        $this->_helper->layout->disableLayout();
        $this->_helper->viewRenderer->setNoRender(TRUE);
        $db = new Alicerce_Model_DbTable_EquipamentoManutencao();
        $dados = $this->getRequest()->getPost();
        $da = $dados['dta_retorno'];
        $da = explode("/", $da);
        $datual = $da[2] . '-' . $da[1] . '-' . $da[0];
        unset($dados['dta_retorno']);
        $dados['dta_retorno'] = $datual;
        $update = $db->update($dados, "cod_equipamento_manutencao=" . $dados['cod_equipamento_manutencao']);
        if ($update > 0) {
            echo "$.jGrowl('Retorno de Equipamento em Manutenção Alterado');";
            echo '$(".coringa_dialog_confirm").remove();';
        }
    }

    public function devolverEquipamentoAction() {
        $this->_helper->layout->disableLayout();
        $this->_helper->viewRenderer->setNoRender(TRUE);
        $request = $this->getRequest();
        if ($request->isPost()) {
            $dados = $request->getPost();
            $dbel = new Alicerce_Model_DbTable_EquipamentoLocacao();
            $result = $dbel->getEquipamentoLocacao($dados['cod_equipamento_locacao']);
            $qtd_equip = $result['qtd_equipamento'];
            if ($qtd_equip == $dados['qtd_equip_dev']) {
                $dadosup['ind_situacao'] = $dados['ind_situacao'];
                $dadosup['des_observacao'] = $dados['des_observacao'];

                //Devolve equipamento para o estoque se o equipamento estiver Ok
                if ($dados['ind_situacao'] == 'N') {
                    $dbe = new Alicerce_Model_DbTable_Equipamento();
                    $result_e = $dbe->getEquipamento($result['cod_equipamento']);
                    $estoque_efetivo = $result_e['qtd_estoque_efetivo'];
                    $estoque_atual = $result_e['qtd_estoque_atual'];
                    $estoque_novo = $estoque_atual + $dados['qtd_equip_dev'];
                    if ($estoque_novo <= $estoque_efetivo) {
                        $dados_equipamento['qtd_estoque_atual'] = $estoque_novo;
                        $dbe->update($dados_equipamento, "cod_equipamento=" . $result['cod_equipamento']);
                    }
                }
                else {
                    //Envia equipamento para a manutenção
                    $dbem = new Alicerce_Model_DbTable_EquipamentoManutencao();
                    $dados_manutencao['cod_equipamento'] = $result['cod_equipamento'];
                    $dados_manutencao['qtd_equipamento'] = $dados['qtd_equip_dev'];
                    $dados_manutencao['dta_manutencao'] = date("Y-m-d h:i:s");
                    $dados_manutencao['ind_automatico'] = 'N';
                    $dados_manutencao['ind_status'] = 'A';
                    $dados_manutencao['vlr_manutencao'] = '0.00';
                    $dados_manutencao['des_manutencao'] = 'Manutenção por conta do Cliente.' . PHP_EOL . $dados['des_observacao'];
                    $dbem->insert($dados_manutencao);
                }
                //Devolve o equipamento
                $dbel->update(array("ind_status" => "C"), "cod_equipamento_locacao=" . $dados['cod_equipamento_locacao']);
                echo "$.jGrowl('Equipamentos devolvidos com sucesso.');";
                echo "oTable = $('#tbgrid').dataTable();";
                echo "$('input[type=checkbox]:checked', oTable.fnGetNodes()).closest('tr').fadeTo(300, 0, function() {";
                echo "oTable.fnDeleteRow(this);";
                echo '$(".coringa_dialog_confirm").remove();';
            }
            else {
                //Se apenas um Equipamento foi devolvido cria um novo registro com os equipamentos restantes
                $qtd_restante = $result['qtd_equipamento'] - $dados['qtd_equip_dev'];
                for ($i = 0; $i < $qtd_restante; $i++) {
                    $dados_insert = $result->toArray();
                    $dados_insert['cod_equipamento_locacao'] = '';
                    $dados_insert['qtd_equipamento'] = $i + 1;
                    $dbel->insert($dados_insert);
                }
                $dbe = new Alicerce_Model_DbTable_Equipamento();
                $result_e = $dbe->getEquipamento($result['cod_equipamento']);
                $estoque_efetivo = $result_e['qtd_estoque_efetivo'];
                $estoque_atual = $result_e['qtd_estoque_atual'];
                $estoque_novo = $estoque_atual + $dados['qtd_equip_dev'];
                if ($estoque_novo <= $estoque_efetivo) {
                    $dados_equipamento['qtd_estoque_atual'] = $estoque_novo;
                    $dbe->update($dados_equipamento, "cod_equipamento=" . $result['cod_equipamento']);
                }
                $dbel->update(array("ind_status" => "C", "qtd_equipamento" => $dados['qtd_equip_dev']), "cod_equipamento_locacao=" . $dados['cod_equipamento_locacao']);
                echo "$.jGrowl('Equipamentos devolvidos com sucesso.');";
                echo "oTable = $('#tbgrid').dataTable();";
                echo "$('input[type=checkbox]:checked', oTable.fnGetNodes()).closest('tr').find('td').eq(1).html('" . $qtd_restante . "');";
                echo '$(".coringa_dialog_confirm").remove();';
            }
        }
    }

}

?>
