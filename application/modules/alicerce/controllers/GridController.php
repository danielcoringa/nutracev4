<?php

/**
 * Description of Security
 * @category   PublicAnuncios
 * @package    Coringa_Controller
 * @copyright  Copyright (c) 2013-2013 CoringaSistemas INC (http://www.coringasistemas.com.br)
 */
class Alicerce_GridController extends Coringa_Controller_Alicerce_Action {

    public function init() {
        parent::init();
        parent::norenderall();
        $this->_helper->viewRenderer->setNoRender(TRUE);
        $iTotal = 0;
        $iFilteredTotal = 0;
        $this->output = array(
            "sEcho" => intval($_GET['sEcho']),
            "iTotalRecords" => $iTotal,
            "iTotalDisplayRecords" => $iFilteredTotal,
            "aaData" => array()
        );
    }

    public function listAction() {
        $params = $this->getRequest()->getParams();
        $this->$params['t']();
        echo json_encode($this->output);
    }

    private function cliente() {
        $db = new Alicerce_Model_DbTable_Cliente();
        $retorno = $db->gridList('A', 0);
        foreach ($retorno as $row) {
            $rows = array(
                '<input type="checkbox" class="optcheck" value="' . $row['cod_cliente'] . '" />',
                str_pad($row['cod_cliente'], 4, '0', STR_PAD_LEFT),
                $this->setFullField($row['nom_cliente']),
                $row['num_cnpj_cpf'],
                $row['num_fone'],
                $row['des_cidade'],
                $row['des_estado']
            );
            $this->output['aaData'][] = $rows;
        }
    }

    private function usuario() {
        $db = new Alicerce_Model_DbTable_Usuario();
        $retorno = $db->gridList('A');
        foreach ($retorno as $row) {
            $rows = array(
                '<input type="checkbox" class="optcheck" value="' . $row['cod_usuario'] . '" />',
                str_pad($row['cod_usuario'], 4, '0', STR_PAD_LEFT),
                $this->setFullField($row['nom_usuario']),
                $row['nom_grupo'],
                $this->showStatus($row['ind_status']),
                $row['dta_last_access']
            );
            $this->output['aaData'][] = $rows;
        }
    }

    private function grupo() {
        $db = new Alicerce_Model_DbTable_Grupo();
        $retorno = $db->gridList('A', $this->empresa['cod_empresa']);
        foreach ($retorno as $row) {
            $rows = array(
                '<input type="checkbox" class="optcheck" value="' . $row['cod_grupo'] . '" />',
                str_pad($row['cod_grupo'], 4, '0', STR_PAD_LEFT),
                $this->setFullField($row['nom_grupo']),
                $this->showStatus($row['ind_status'])
            );
            $this->output['aaData'][] = $rows;
        }
    }

    private function equipAtraso() {
        $dbel = new Alicerce_Model_DbTable_EquipamentoLocacao();
        $sela = $dbel->select();
        $sela->setIntegrityCheck(false);
        $sela->from(array("twel" => "tab_web_equipamento_locacao"));
        $sela->joinInner(array("twe" => "tab_web_equipamento"), "twe.cod_equipamento=twel.cod_equipamento", array("nom_equipamento" => "twe.nom_equipamento"));
        $sela->joinInner(array("twl" => "tab_web_locacao"), "twl.cod_locacao=twel.cod_locacao");
        $sela->joinInner(array("twc" => "tab_web_cliente"), "twc.cod_cliente=twl.cod_cliente", array("nom_cliente" => "twc.nom_cliente"));
        $sela->where("twel.ind_status=?", "A");
        $sela->where("twel.dta_devolucao< NOW()");
        $resa = $dbel->fetchAll($sela)->toArray();
        foreach ($resa as $row) {
            $rows = array(
                '<input type="checkbox" class="optcheck" value="' . $row['cod_equipamento'] . '" />',
                str_pad($row['cod_equipamento'], 4, '0', STR_PAD_LEFT),
                $row['qtd_equipamento'],
                $this->setFullField($row['nom_equipamento']),
                $this->setFullField($row['nom_cliente']),
                str_pad($row['cod_locacao'], 4, '0', STR_PAD_LEFT),
                $this->dataFormat($row['dta_locacao']),
                $this->dataFormat($row['dta_devolucao']),
                $this->returnDias($row['dta_devolucao'], Date("Y-m-d hh:ii:ss"))
            );
            $this->output['aaData'][] = $rows;
        }
    }

    private function pedidoAtraso() {
        $db = new Alicerce_Model_DbTable_Locacao();
        $select = $db->select();
        $select->setIntegrityCheck(false);
        $select->from(array("twl" => "tab_web_locacao"));
        $select->joinInner(array("twc" => "tab_web_cliente"), "twc.cod_cliente=twl.cod_cliente", array("nom_cliente" => "twc.nom_cliente"));
        $select->where("twl.ind_status=?", "A");
        $select->where("twl.dta_devolucao<NOW()");
        $result = $db->fetchAll($select)->toArray();
        foreach ($result as $row) {
            $rows = array(
                '<input type="checkbox" class="optcheck" value="' . $row['cod_locacao'] . '" />',
                str_pad($row['cod_locacao'], 4, '0', STR_PAD_LEFT),
                $this->setFullField($row['nom_cliente']),
                $row['vlr_total'],
                $this->dataFormat($row['dta_locacao']),
                $this->dataFormat($row['dta_devolucao'])
            );
            $this->output['aaData'][] = $rows;
        }
    }

    private function coresponsabilidade() {
        $db = new Alicerce_Model_DbTable_Cliente();
        $retorno = $db->gridListCo('A');
        foreach ($retorno as $row) {
            $rows = array(
                '<input type="checkbox" class="optcheck" value="' . $row['cod_cliente'] . '" />',
                str_pad($row['cod_cliente'], 4, '0', STR_PAD_LEFT),
                $this->setFullField($row['nom_cliente']),
                $row['num_cnpj_cpf'],
                $row['num_fone'],
                $row['des_cidade'],
                $row['des_estado'],
                $row['nom_cliente_responsavel']
            );
            $this->output['aaData'][] = $rows;
        }
    }

    private function categoria() {
        $db = new Alicerce_Model_DbTable_Categoria();
        $retorno = $db->gridList('A');
        foreach ($retorno as $row) {
            $rows = array(
                '<input type="checkbox" class="optcheck" value="' . $row['cod_categoria'] . '" />',
                str_pad($row['cod_categoria'], 4, '0', STR_PAD_LEFT),
                $this->setFullField($row['nom_categoria']),
                $this->showStatus($row['ind_status'])
            );
            $this->output['aaData'][] = $rows;
        }
    }

    private function cobranca() {
        $db = new Alicerce_Model_DbTable_Cobranca();
        $retorno = $db->gridList('A');
        foreach ($retorno as $row) {
            $rows = array(
                '<input type="checkbox" class="optcheck" value="' . $row['cod_cobranca'] . '" />',
                str_pad($row['cod_cobranca'], 4, '0', STR_PAD_LEFT),
                $this->setFullField($row['des_endereco']),
                $row['des_bairro'],
                $row['des_cidade'],
                $row['des_estado'],
                $row['num_fone'],
                $row['nom_cliente']
            );
            $this->output['aaData'][] = $rows;
        }
    }

    private function obra() {
        $db = new Alicerce_Model_DbTable_Cliente();
        $retorno = $db->gridListObras('A');
        foreach ($retorno as $row) {
            $rows = array(
                '<input type="checkbox" class="optcheck" value="' . $row['cod_obra'] . '" />',
                str_pad($row['cod_obra'], 4, '0', STR_PAD_LEFT),
                $this->setFullField($row['nom_cliente']),
                $row['des_obra'],
                $row['des_endereco'],
                $row['des_bairro'],
                $this->dataFormat($row['dta_inicio'])
            );
            $this->output['aaData'][] = $rows;
        }
    }

    private function equipamento() {
        $db = new Alicerce_Model_DbTable_Equipamento();
        $retorno = $db->gridListAll('A');
        foreach ($retorno as $row) {
            $rows = array(
                '<input type="checkbox" class="optcheck" value="' . $row['cod_equipamento'] . '" />',
                str_pad($row['cod_equipamento'], 4, '0', STR_PAD_LEFT),
                $this->showThumb($row['cod_equipamento']),
                $this->setFullField($row['nom_equipamento']),
                $row['nom_categoria'],
                str_pad($row['qtd_estoque_atual'], 2, '0', STR_PAD_LEFT),
                str_pad($row['qtd_estoque_efetivo'], 2, '0', STR_PAD_LEFT)
            );
            $this->output['aaData'][] = $rows;
        }
    }

    private function equipamentoManutencao() {
        $db = new Alicerce_Model_DbTable_EquipamentoManutencao();
        $retorno = $db->gridList('A');
        foreach ($retorno as $row) {
            $rows = array(
                '<input type="checkbox" class="optcheck" value="' . $row['cod_equipamento_manutencao'] . '" />',
                str_pad($row['cod_equipamento_manutencao'], 4, '0', STR_PAD_LEFT),
                $this->showThumb($row['cod_equipamento']),
                $row['nom_equipamento'],
                $row['des_manutencao'],
                $this->dataFormat($row['dta_manutencao']),
                $this->dataFormat($row['dta_retorno']),
                $row['vlr_manutencao']
            );
            $this->output['aaData'][] = $rows;
        }
    }

    private function estoque() {
        $db = new Alicerce_Model_DbTable_Categoria();
        $retorno = $db->estoqueList();
        foreach ($retorno as $row) {
            $rows = array(
                '<input type="checkbox" class="optcheck" value="' . $row['cod_equipamento'] . '" />',
                str_pad($row['cod_categoria'], 4, '0', STR_PAD_LEFT),
                $this->setFullField($row['nom_categoria']),
                str_pad($row['total_equip'], 2, '0', STR_PAD_LEFT),
                str_pad($row['total_ativo'], 2, '0', STR_PAD_LEFT),
                str_pad($row['total_locado'], 2, '0', STR_PAD_LEFT),
                str_pad($row['total_manutencao'], 2, '0', STR_PAD_LEFT),
                str_pad($row['total_atrasado'], 2, '0', STR_PAD_LEFT),
            );
            $this->output['aaData'][] = $rows;
        }
    }

    private function locacaoa() {
        $db = new Alicerce_Model_DbTable_Locacao();
        $retorno = $db->gridList('A');
        foreach ($retorno as $row) {
            $rows = array(
                '<input type="checkbox" class="optcheck" value="' . $row['cod_locacao'] . '" />',
                str_pad($row['cod_locacao'], 4, '0', STR_PAD_LEFT),
                $this->setFullField($row['nom_cliente']),
                $row['des_obra'],
                $this->dataFormat($row['dta_locacao']),
                '<div class="verify-data">' . $this->dataFormat($row['dta_devolucao']) . '</div>',
                $row['vlr_total'],
            );
            $this->output['aaData'][] = $rows;
        }
    }

    private function locacaoc() {
        $db = new Alicerce_Model_DbTable_Locacao();
        $retorno = $db->gridList('C');
        foreach ($retorno as $row) {
            $rows = array(
                '<input type="checkbox" class="optcheck" value="' . $row['cod_locacao'] . '" />',
                str_pad($row['cod_locacao'], 4, '0', STR_PAD_LEFT),
                $this->setFullField($row['nom_cliente']),
                $row['des_obra'],
                $this->dataFormat($row['dta_locacao']),
                $this->dataFormat($row['dta_devolucao']),
                $row['vlr_total'],
            );
            $this->output['aaData'][] = $rows;
        }
    }

    private function locacaod() {
        $db = new Alicerce_Model_DbTable_Locacao();
        $retorno = $db->gridListDevolucao();
        foreach ($retorno as $row) {
            $rows = array(
                '<input type="checkbox" class="optcheck" value="' . $row['cod_locacao'] . '" />',
                str_pad($row['cod_locacao'], 4, '0', STR_PAD_LEFT),
                $this->setFullField($row['nom_cliente']),
                $row['des_obra'],
                $this->dataFormat($row['dta_locacao']),
                $this->dataFormat($row['dta_devolucao']),
                $row['vlr_total'],
            );
            $this->output['aaData'][] = $rows;
        }
    }

    private function modelo() {
        $db = new Alicerce_Model_DbTable_Modelo();
        $retorno = $db->gridList('A');
        foreach ($retorno as $row) {
            $rows = array(
                '<input type="checkbox" class="optcheck" value="' . $row['cod_modelo'] . '" />',
                str_pad($row['cod_modelo'], 4, '0', STR_PAD_LEFT),
                $this->setFullField($row['nom_modelo']),
                $this->showStatus($row['ind_status'])
            );
            $this->output['aaData'][] = $rows;
        }
    }

    private function unidade() {
        $db = new Alicerce_Model_DbTable_Unidade();
        $retorno = $db->gridList('A');
        foreach ($retorno as $row) {
            $rows = array(
                '<input type="checkbox" class="optcheck" value="' . $row['cod_unidade'] . '" />',
                str_pad($row['cod_unidade'], 4, '0', STR_PAD_LEFT),
                $this->setFullField($row['nom_unidade']),
                $this->showStatus($row['ind_status'])
            );
            $this->output['aaData'][] = $rows;
        }
    }

    private function fornecedor() {
        $db = new Alicerce_Model_DbTable_Fornecedor();
        $retorno = $db->gridList('A');
        foreach ($retorno as $row) {
            $rows = array(
                '<input type="checkbox" class="optcheck" value="' . $row['cod_fornecedor'] . '" />',
                str_pad($row['cod_fornecedor'], 4, '0', STR_PAD_LEFT),
                $this->setFullField($row['nom_fornecedor']),
                $row['nom_categoria'],
                $row['num_cnpj_cpf'],
                $row['num_fone'],
                $row['des_cidade'],
                $row['des_estado']
            );
            $this->output['aaData'][] = $rows;
        }
    }

    private function acessorio() {
        $db = new Alicerce_Model_DbTable_Acessorio();
        $retorno = $db->gridList('A');
        foreach ($retorno as $row) {
            $rows = array(
                '<input type="checkbox" class="optcheck" value="' . $row['cod_acessorio'] . '" />',
                str_pad($row['cod_acessorio'], 4, '0', STR_PAD_LEFT),
                $row['nom_acessorio'],
                $row['nom_equipamento'],
                $row['vlr_acessorio'],
                $this->showStatus($row['ind_status'])
            );
            $this->output['aaData'][] = $rows;
        }
    }

    private function dataFormat($d) {
        $dt = explode(" ", $d);
        $dt = explode("-", $dt[0]);
        return $dt[2] . '/' . $dt[1] . '/' . $dt[0];
    }

    private function returnDias($data1, $data2) {
        //Instancia a classe, atribuindo a data inicial
        list($d1, $h1) = explode(' ', $data1);
        list($d2, $h2) = explode(' ', $data2);
        $dataInicio = new DateTime($d1);
        $dataFim = new DateTime($d2);
        //Retorna a diferença entre dois objetos DateTime, no caso um objeto DataInterval
        $intervalo = $dataInicio->diff($dataFim);
        //Agora formatamos a data em dias
        return str_pad($intervalo->format('%d'), 2, '0', 0);
    }

    private function setFullField($var) {
        return '<div class="campo_full">' . $var . '</div>';
    }

    private function setMiddleField($var) {
        return '<div class="campo_middle">' . $var . '</div>';
    }

    private function showThumb($val) {
        $db = new Alicerce_Model_DbTable_Imagem();
        $sel = $db->select();
        $sel->where("cod_equipamento=?", $val);
        $ret = $db->fetchRow($sel);
        $imagem = str_replace(BASIC_FOLDER . "/media/", "", $ret["link_imagem"]);
        $img_arr = explode(".", $imagem);
        $img_name = $img_arr[0];
        $img_ext = $img_arr[1];
        $thumb = '/media/' . $img_name . '_thumb.' . $img_ext;
        return "<img src='{$thumb}' />";
    }

    private function showStatus($val) {
        $retorno = array("A" => "Disponível", "I" => "Inativo", "L" => "Locado");
        return $retorno[$val];
    }

}

?>
