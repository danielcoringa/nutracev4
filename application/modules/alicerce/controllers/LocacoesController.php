<?php

/**
 * Description of Security
 * @category   PublicAnuncios
 * @package    Coringa_Controller
 * @copyright  Copyright (c) 2013-2013 CoringaSistemas INC (http://www.coringasistemas.com.br)
 */
class Alicerce_LocacoesController extends Coringa_Controller_Alicerce_Action {

    public function init() {
        parent::init();
        parent::norender();
        $this->view->empresa = $this->empresa;
        parent::verifyAjax();
    }

    public function ativasAction() {
        parent::tables();
        $this->view->mode = 'Ativas';
        $this->view->table = 'locacaoa';
        $this->render('index');
    }

    public function ativasCadastroAction() {
        $this->cadastroAction();
    }

    public function concluidasCadastroAction() {
        $this->cadastroAction();
    }

    public function concluidasAction() {
        parent::tables();
        $this->view->mode = 'Concluídas';
        $this->view->table = 'locacaoc';
        $this->render('index');
    }

    public function cadastroAction() {

        $params = $this->getRequest()->getParams();
        parent::tables();
        parent::forms();
        $dbc = new Alicerce_Model_DbTable_Cliente();
        $this->view->cliente = $dbc->getClienteSelect();
        $this->view->mode = 'Novo ';
        $dbe = new Alicerce_Model_DbTable_Estados();
        $this->view->estados = $dbe->getEstados();
        $db = new Alicerce_Model_DbTable_Locacao();
        $dbo = new Alicerce_Model_DbTable_Obra();
        if ($params['editar'] != '') {
            $this->view->mode = 'Editar ';
            $this->view->data = $db->getLocacao($params['editar']);
            $dbel = new Alicerce_Model_DbTable_EquipamentoLocacao();
            $selel = $dbel->select();
            $selel->setIntegrityCheck(false);
            $selel->from(array("tael" => "tab_web_equipamento_locacao"));
            $selel->joinInner(array("tae" => "tab_web_equipamento"), "tae.cod_equipamento=tael.cod_equipamento");

            $selel->where("tael.cod_locacao=?", $params['editar']);
            $selel->where("tael.ind_status=?", 'A');


            $retel = $dbel->fetchAll($selel);
            $x = 0;
            foreach ($retel as $row) {

                $dados[$x]['cod_equipamento_locacao'] = $row['cod_equipamento_locacao'];
                $dados[$x]['cod_equipamento'] = $row['cod_equipamento'];
                $dados[$x]['qtd_equipamento'] = $row['qtd_equipamento'];
                $dados[$x]['nom_equipamento'] = $row['nom_equipamento'];
                $dados[$x]['vlr_locacao'] = $row['vlr_locacao'];
                $dados[$x]['vlr_total'] = $row['vlr_equipamento'];
                $x++;
            }

            $this->view->dataEquip = $dados;
        }
        $request = $this->getRequest();
        if ($request->isPost()) {
            $d = $request->getPost();
            foreach ($d as $k => $v) {
                if ($v != '') {
                    //echo $k . '=' . $v;
                    $dados[$k] = $v;
                }
            }
            $da = $dados['dta_locacao'];
            $da = explode("/", $da);
            $datual = $da[2] . '-' . $da[1] . '-' . $da[0];
            unset($dados['dta_locacao']);
            unset($dados['tbgrid_length']);
            unset($dados['vequipt']);
            unset($dados['equiplist']);
            $dados['dta_locacao'] = $datual;
            $da = $dados['dta_devolucao'];
            $da = explode("/", $da);
            $datual = $da[2] . '-' . $da[1] . '-' . $da[0];
            unset($dados['dta_devolucao']);
            $dados['dta_devolucao'] = $datual;
            unset($dados['radio']);

            $codequips = $dados['cequip'];
            $qtdequips = $dados['qequip'];
            $vlrequips = $dados['vequip'];
            $acessorios = $dados['indacessorio'];


            unset($dados['cequip']);
            unset($dados['qequip']);
            unset($dados['vequip']);
            unset($dados['indacessorio']);

            if ($dados['cod_locacao'] != '') {
                $mode = 'Alterado';
                $insert = $db->update($dados, 'cod_locacao=' . $dados['cod_locacao']);
                $dbel = new Alicerce_Model_DbTable_EquipamentoLocacao();
                $selel = $dbel->select();
                $selel->where("cod_locacao=?", $dados['cod_locacao']);
                $resultel = $dbel->fetchAll();
                if (count($resultel) > 0) {
                    foreach ($resultel as $rowee) {

                        $dbe = new Alicerce_Model_DbTable_Equipamento();
                        $selup = $dbe->select();
                        $selup->where("cod_equipamento=" . $rowee['cod_equipamento']);
                        $resup = $dbe->fetchRow($selup);
                        if (count($resup) > 0) {
                            $total = $resup['qtd_estoque_efetivo'];
                            $qatual = $resup['qtd_estoque_atual'];
                            $satual = $qatual + $rowee['qtd_equipamento'];
                            if ($satual <= $total) {
                                $dadosup['qtd_estoque_atual'] = $satual;
                                $dbe->update($dadosup, "cod_equipamento=" . $rowee['cod_equipamento']);
                            }
                            else {
                                $dadosup['qtd_estoque_atual'] = $total;
                                $dbe->update($dadosup, "cod_equipamento=" . $rowee['cod_equipamento']);
                            }
                        }
                    }
                    $dbel->delete("cod_locacao=" . $dados['cod_locacao']);
                }
                $t = count($codequips);


                for ($i = 0; $i < $t; $i++) {
                    if ($codequips[$i] !== '') {
                        $dados_el['cod_locacao'] = $dados['cod_locacao'];
                        $dados_el['cod_equipamento'] = $codequips[$i];
                        $dados_el['qtd_equipamento'] = $qtdequips[$i];
                        $dados_el['dta_locacao'] = $dados['dta_locacao'];
                        $dados_el['dta_devolucao'] = $dados['dta_devolucao'];
                        $dados_el['ind_acessorio'] = $acessorios[$i];
                        $dbel->insert($dados_el);

                        $dbe = new Alicerce_Model_DbTable_Equipamento();
                        $sele = $dbe->select();
                        $sele->where('cod_equipamento=?', $codequips[$i]);
                        $resulte = $dbe->fetchRow($sele);
                        $qtd_atual = $resulte['qtd_estoque_atual'];
                        $qtd_new = $qtd_atual - $qtdequips[$i];
                        if ($qtd_new >= 0) {
                            $dados_ind['qtd_estoque_atual'] = $qtd_new;
                            $update = $dbe->update($dados_ind, "cod_equipamento=" . $codequips[$i]);
                        }
                    }
                }
            }
            else {
                $mode = 'Adicionado';
                $insert = $db->insert($dados);

                if ($insert > 0) {
                    $dbel = new Alicerce_Model_DbTable_EquipamentoLocacao();
                    echo "window.open('/pdf/contrato/id/$insert');";
                    $t = count($codequips);
                    for ($i = 0; $i < $t; $i++) {
                        $dados_el['cod_locacao'] = $insert;
                        $dados_el['cod_equipamento'] = $codequips[$i];
                        $dados_el['qtd_equipamento'] = $qtdequips[$i];
                        $dados_el['dta_locacao'] = $dados['dta_locacao'];
                        $dados_el['dta_devolucao'] = $dados['dta_devolucao'];
                        $dados_el['ind_acessorio'] = $acessorios[$i];
                        $dbel->insert($dados_el);
                        $dbe = new Alicerce_Model_DbTable_Equipamento();
                        $sele = $dbe->select();
                        $sele->where('cod_equipamento=?', $codequips[$i]);
                        $resulte = $dbe->fetchRow($sele);
                        $qtd_atual = $resulte['qtd_estoque_atual'];
                        $qtd_new = $qtd_atual - $qtdequips[$i];
                        if ($qtd_new >= 0) {
                            $dados_ind['qtd_estoque_atual'] = $qtd_new;
                            $update = $dbe->update($dados_ind, "cod_equipamento=" . $codequips[$i]);
                        }
                    }
                }
            }



            echo "$.jGrowl('Registro {$mode} com Sucesso!');";
            echo "location.hash = 'locacoes/ativas';";
            exit;
        }
        $this->render('cadastro');
    }

    public function devolucaoAction() {
        parent::tables();
        $this->render('devolucao/index');
    }

    public function contratosAction() {
        $this->render('wait/index');
    }

    public function devolverAction() {
        parent::forms();
        parent::tables();
        $request = $this->getRequest();
        $params = $request->getParams();
        $cod_locacao = $params['pedido'] ? $params['pedido'] : $params['cod_locacao'];
        $dbc = new Alicerce_Model_DbTable_Cliente();
        $this->view->cliente = $dbc->getClienteSelect();
        $db = new Alicerce_Model_DbTable_Locacao;
        $this->view->data = $db->getLocacaoJoin($cod_locacao);
        $dbel = new Alicerce_Model_DbTable_EquipamentoLocacao();
        $selel = $dbel->select();
        $selel->setIntegrityCheck(false);
        $selel->from(array("tael" => "tab_web_equipamento_locacao"));
        $selel->joinInner(array("tae" => "tab_web_equipamento"), "tae.cod_equipamento=tael.cod_equipamento");

        $selel->where("tael.cod_locacao=?", $cod_locacao);
        $selel->where("tael.ind_status=?", "A");


        $retel = $dbel->fetchAll($selel);
        $x = 0;
        foreach ($retel as $row) {

            $dados[$x]['cod_equipamento_locacao'] = $row['cod_equipamento_locacao'];
            $dados[$x]['cod_equipamento'] = $row['cod_equipamento'];
            $dados[$x]['qtd_equipamento'] = $row['qtd_equipamento'];
            $dados[$x]['nom_equipamento'] = $row['nom_equipamento'];
            $dados[$x]['vlr_locacao'] = $row['vlr_locacao'];
            $dados[$x]['vlr_total'] = $row['vlr_equipamento'];
            $x++;
        }

        $this->view->dataEquip = $dados;
        if ($request->isPost()) {
            $dbe = new Alicerce_Model_DbTable_Equipamento();
            foreach ($retel as $row) {


                $rete = $dbe->getEquipamento($row['cod_equipamento']);

                $qtd_atual = $rete['qtd_estoque_atual']; //
                $qtd_devolver = $row['qtd_equipamento'] + $qtd_atual;
                $dadosup['qtd_estoque_atual'] = $qtd_devolver;
                if ($qtd_atual <= $row['qtd_estoque_efetivo']) {
                    $dbe->update($dadosup, 'cod_equipamento=' . $row['cod_equipamento']);
                }
                else {
                    $dados['qtd_estoque_atual'] = $row['qtd_estoque_efetivo'];
                    $dbe->update($dadosup, 'cod_equipamento=' . $row['cod_equipamento']);
                }
                $dbel->update(array("ind_status" => "C", "dta_devolucao" => Date("Y-m-d H:i:s")), "cod_equipamento_locacao=" . $row['cod_equipamento_locacao']);
            }
            $db->update(array("ind_status" => "C", "dta_devolucao" => Date("Y-m-d h:i:s")), "cod_locacao=" . $cod_locacao);

            echo "$.jGrowl('Registro Devolvidos e Finalizado com Sucesso!');";
            echo "location.hash = 'locacoes/devolucao';";
            exit;
        }
        $this->render("devolucao/devolucao");
    }

    public function renovacaoAction() {
        parent::tables();
        $this->render("renovacoes/index");
    }

    public function renovarAction() {

        $params = $this->getRequest()->getParams();
        parent::tables();
        parent::forms();
        $dbc = new Alicerce_Model_DbTable_Cliente();
        $this->view->cliente = $dbc->getClienteSelect();
        $dbe = new Alicerce_Model_DbTable_Estados();
        $this->view->estados = $dbe->getEstados();
        $db = new Alicerce_Model_DbTable_Locacao();
        $dbo = new Alicerce_Model_DbTable_Obra();
        if ($params['pedido'] != '') {

            $this->view->data = $db->getLocacao($params['pedido']);
            $dbel = new Alicerce_Model_DbTable_EquipamentoLocacao();
            $selel = $dbel->select();
            $selel->setIntegrityCheck(false);
            $selel->from(array("tael" => "tab_web_equipamento_locacao"));
            $selel->joinInner(array("tae" => "tab_web_equipamento"), "tae.cod_equipamento=tael.cod_equipamento");

            $selel->where("tael.cod_locacao=?", $params['pedido']);


            $retel = $dbel->fetchAll($selel);
            $x = 0;
            foreach ($retel as $row) {

                $dados[$x]['cod_equipamento_locacao'] = $row['cod_equipamento_locacao'];
                $dados[$x]['cod_equipamento'] = $row['cod_equipamento'];
                $dados[$x]['qtd_equipamento'] = $row['qtd_equipamento'];
                $dados[$x]['nom_equipamento'] = $row['nom_equipamento'];
                $dados[$x]['vlr_locacao'] = $row['vlr_locacao'];
                $dados[$x]['vlr_total'] = $row['vlr_equipamento'];
                $x++;
            }

            $this->view->dataEquip = $dados;
        }
        $request = $this->getRequest();
        if ($request->isPost()) {
            $dados = $request->getPost();
            $da = $dados['dta_locacao'];
            $da = explode("/", $da);
            $datual = $da[2] . '-' . $da[1] . '-' . $da[0];
            unset($dados['dta_locacao']);
            unset($dados['tbgrid_length']);
            unset($dados['vequipt']);
            $dados['dta_locacao'] = $datual;
            $da = $dados['dta_devolucao'];
            $da = explode("/", $da);
            $datual = $da[2] . '-' . $da[1] . '-' . $da[0];
            unset($dados['dta_devolucao']);
            $dados['dta_devolucao'] = $datual;
            unset($dados['radio']);

            $codequips = $dados['cequip'];
            $qtdequips = $dados['qequip'];
            $vlrequips = $dados['vequip'];


            unset($dados['cequip']);
            unset($dados['qequip']);
            unset($dados['vequip']);

            if ($params['pedido'] != '') {
                $insert = $db->update($dados, 'cod_locacao=' . $params['pedido']);
            }
            if ($insert > 0) {

                $this->_redirect('/locacoes/ativas');
            }
        }
        $this->render("renovacoes/renovacao");
    }

    public function comprovantesAction() {
        $this->render("comprovantes/index");
    }

    public function renovarCadastroAction() {
        $params = $this->getRequest()->getParams();
        $dbc = new Alicerce_Model_DbTable_Cliente();
        $this->view->cliente = $dbc->getClienteSelect();

        $dbe = new Alicerce_Model_DbTable_Estados();
        $this->view->estados = $dbe->getEstados();
        $db = new Alicerce_Model_DbTable_Locacao();
        $dbo = new Alicerce_Model_DbTable_Obra();
        if ($params['pedido'] != '') {

            $this->view->data = $db->getLocacao($params['pedido']);
            $dbel = new Alicerce_Model_DbTable_EquipamentoLocacao();
            $selel = $dbel->select();
            $selel->setIntegrityCheck(false);
            $selel->from(array("tael" => "tab_web_equipamento_locacao"));
            $selel->joinInner(array("tae" => "tab_web_equipamento"), "tae.cod_equipamento=tael.cod_equipamento");

            $selel->where("tael.cod_locacao=?", $params['pedido']);


            $retel = $dbel->fetchAll($selel);
            $x = 0;
            foreach ($retel as $row) {

                $dados[$x]['cod_equipamento_locacao'] = $row['cod_equipamento_locacao'];
                $dados[$x]['cod_equipamento'] = $row['cod_equipamento'];
                $dados[$x]['qtd_equipamento'] = $row['qtd_equipamento'];
                $dados[$x]['nom_equipamento'] = $row['nom_equipamento'];
                $dados[$x]['vlr_locacao'] = $row['vlr_locacao'];
                $dados[$x]['vlr_total'] = $row['vlr_equipamento'];
                $x++;
            }

            $this->view->dataEquip = $dados;
        }
        $this->view->obras = $dbo->getObraCliente(1);
        $request = $this->getRequest();
        if ($request->isPost()) {

            $d = $request->getPost();
            foreach ($d as $k => $v) {
                if ($v != '') {
                    //echo $k . '=' . $v;
                    $dados[$k] = $v;
                }
            }
            $da = $dados['dta_locacao'];
            $da = explode("/", $da);
            $datual = $da[2] . '-' . $da[1] . '-' . $da[0];
            unset($dados['dta_locacao']);
            unset($dados['tbgrid_length']);
            unset($dados['vequipt']);
            unset($dados['equiplist']);
            $dados['dta_locacao'] = $datual;
            $da = $dados['dta_renovacao'];
            $da = explode("/", $da);
            $datual = $da[2] . '-' . $da[1] . '-' . $da[0];
            unset($dados['dta_devolucao']);
            $dados['dta_devolucao'] = $datual;
            unset($dados['dta_renovacao']);
            $dados['dta_renovacao'] = $datual;
            unset($dados['radio']);

            $codequips = $dados['cequip'];
            $qtdequips = $dados['qequip'];
            $vlrequips = $dados['vequip'];


            unset($dados['cequip']);
            unset($dados['qequip']);
            unset($dados['vequip']);



            $insert = $db->update($dados, 'cod_locacao=' . $dados['cod_locacao']);
            $dbel = new Alicerce_Model_DbTable_EquipamentoLocacao();
            $selel = $dbel->select();
            $selel->where("cod_locacao=?", $dados['cod_locacao']);
            $resultel = $dbel->fetchAll();
            if (count($resultel) > 0) {
                foreach ($resultel as $rowee) {

                    $dbe = new Alicerce_Model_DbTable_Equipamento();
                    $selup = $dbe->select();
                    $selup->where("cod_equipamento=" . $rowee['cod_equipamento']);
                    $resup = $dbe->fetchRow($selup);
                    if (count($resup) > 0) {
                        $total = $resup['qtd_estoque_efetivo'];
                        $qatual = $resup['qtd_estoque_atual'];
                        $satual = $qatual + $rowee['qtd_equipamento'];
                        if ($satual <= $total) {
                            $dadosup['qtd_estoque_atual'] = $satual;
                            $dbe->update($dadosup, "cod_equipamento=" . $rowee['cod_equipamento']);
                        }
                        else {
                            $dadosup['qtd_estoque_atual'] = $total;
                            $dbe->update($dadosup, "cod_equipamento=" . $rowee['cod_equipamento']);
                        }
                    }
                }
                $dbel->delete("cod_locacao=" . $dados['cod_locacao']);
            }
            $t = count($codequips);


            for ($i = 0; $i < $t; $i++) {
                if ($codequips[$i] !== '') {
                    $dados_el['cod_locacao'] = $dados['cod_locacao'];
                    $dados_el['cod_equipamento'] = $codequips[$i];
                    $dados_el['qtd_equipamento'] = $qtdequips[$i];
                    $dados_el['dta_locacao'] = $dados['dta_locacao'];
                    $dados_el['dta_devolucao'] = $dados['dta_devolucao'];
                    $dbel->insert($dados_el);

                    $dbe = new Alicerce_Model_DbTable_Equipamento();
                    $sele = $dbe->select();
                    $sele->where('cod_equipamento=?', $codequips[$i]);
                    $resulte = $dbe->fetchRow($sele);
                    $qtd_atual = $resulte['qtd_estoque_atual'];
                    $qtd_new = $qtd_atual - $qtdequips[$i];
                    if ($qtd_new >= 0) {
                        $dados_ind['qtd_estoque_atual'] = $qtd_new;
                        $update = $dbe->update($dados_ind, "cod_equipamento=" . $codequips[$i]);
                    }
                }
            }
            echo "$.jGrowl('Registro Renovado com Sucesso!');";
            echo "location.hash = 'locacoes/renovacao';";
            exit;
        }
        $this->render("renovacoes/renovacao");
    }

}

?>
