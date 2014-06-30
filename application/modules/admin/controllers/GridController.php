<?php

/**
 * Description of Security
 * @category   Nutrace - Feedback
 * @package    Coringa_Controller
 * @copyright  Copyright (c) 2013-2014 Rodrigo Daniel RoDa INC (http://www.rodrigodaniel.com.br)
 */
class Admin_GridController extends Coringa_Controller_Admin_Action {

    public function init() {
        parent::init();
        parent::norender();
        $this->_helper->viewRenderer->setNoRender(TRUE);
        $this->_params = $this->getRequest()->getParams();
    }

    public function listAction() {
        $obj = 'Admin_Model_DbTable_' . ucfirst($this->_params['t']);
        $obj = new $obj();
        $campos = $obj->getcamposLst();
        $sGroup = $campos[0];
        $sIndexColumn = $obj->getId();
        $aColumns = array();
        $aColumns[] = $sIndexColumn;
        foreach ($campos as $k => $Campos) {
            $aColumns[] = $k;
        }
        $sLimit = "";
        if (isset($this->_params['start']) && $this->_params['length'] != '-1') {
            $sLimit = "LIMIT " . ($this->_params['start']) . ", " . ($this->_params['length']);
            $obj->setNroPagina($this->_params['start']);
            $obj->setLinhasPorPagina($this->_params['length']);
        }
        /*
         * Ordering
         */
        $orders = $this->_params['order'];
        foreach ($orders as $order) {
            $sOrder[] = $aColumns[intval($order['column']) - 1] . " " . $order['dir'];
        }
        $sOrder = implode(",", $sOrder);
        $obj->setOrder($sOrder);
        /*
         * Filtering
         * NOTE this does not match the built-in DataTables filtering which does it
         * word by word on any field. It's possible to do here, but concerned about efficiency
         * on very large tables, and MySQL's regex functionality is very limited
         */
        $sWhere = "";
        $search = $this->_params['search'];
        if ($search['value'] != "") {
            $sWhere = array();
            for ($i = 0; $i < count($aColumns); $i++) {
                if (!in_array($aColumns[$i] . " LIKE '%" . ($search['value']) . "%'", $sWhere)) { // Evita a duplicidade na busca
                    $sWhere[] = 'LOWER(' . $aColumns[$i] . ") LIKE '%" . strtolower(($search['value'])) . "%'";
                }
            }
        }
        $lista = $obj->listar(null, implode(" OR ", $sWhere), $sLimit, $sGroup);
        $dados = $lista->getDados();
        $iFilteredTotal = $obj->getTotalRegistros();
        $iTotal = $obj->getTotalRegistros();
        $output = array(
            "draw" => intval($this->_params['draw']),
            "recordsTotal" => $iTotal,
            "recordsFiltered" => $iFilteredTotal,
            "data" => array()
        );
        foreach ($dados as $key => $data) {
            $row = array();
            /* Special output formatting for 'version' column */
            for ($i = 0; $i < count($aColumns); $i++) {
                if ($i == 0) {
                    $row[0] = '<input type="checkbox" class="checkboxes" value="1" id="' . $data[$aColumns[$i]] . '">';
                } elseif ($aColumns[$i] != ' ') {
                    /* General output */
//                    $row[] = trataCampo($aColumns[$i], $data[$aColumns[$i]]);
                    $row[] = $data[$aColumns[$i]];
                }
            }
            $row[] = '<button class="btn btn-small btn-success btn-edit">Editar</button>';
            flush();
            $output['aaData'][] = $row;
        }
        echo json_encode($output);
    }

    private function cliente() {
        $db = new Admin_Model_DbTable_Cliente();
        $retorno = $db->gridList('A', $this->empresa['cod_empresa']);
        foreach ($retorno as $row) {
            $rows = array(
                '<input type="checkbox" class="optcheck" value="' . $row['cod_cliente'] . '" />',
                str_pad($row['cod_cliente'], 4, '0', STR_PAD_LEFT),
                $row['nom_cliente'],
                $row['num_cnpj_cpf'],
                $row['num_fone'],
                $row['des_cidade'],
                $row['des_estado']
            );
            $this->output['aaData'][] = $rows;
        }
    }

}

?>
