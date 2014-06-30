<?php

/**
 * Description of Security
 * @category   PublicAnuncios
 * @package    Coringa_Controller
 * @copyright  Copyright (c) 2013-2013 CoringaSistemas INC (http://www.coringasistemas.com.br)
 */
class Site_Model_DbTable_Portfolio extends Zend_Db_Table_Abstract {

    protected $_name = 'tab_sit_portfolio';
    protected $_primary = 'cod_portfolio';

    public function gridList() {
        $select = $this->select();
        $select->where("ind_status=?", "A");
        return $this->fetchAll($select);
    }

    public function inserir($dados) {
        $data = array();
        foreach ($dados as $key => $val) {
            if ($val !== '') {
                $data[$key] = $val;
            }
        }
        return $this->insert($data);
    }

    public function atualizar($dados) {
        $data = array();
        $cod_portfolio = $dados['cod_portfolio'];
        foreach ($dados as $key => $val) {
            if ($val !== '') {
                $data[$key] = $val;
            }
        }
        return $this->update($data, "cod_portfolio=" . $cod_portfolio);
    }

    public function getDados($where) {
        if (isset($where)) {
            $select = $this->select();
            $select->where("cod_portfolio=?", $where);
            return $this->fetchRow($select);
        }
    }

    public function getSelect() {
        $select = $this->select();
        $select->where("ind_status='A'");
        $select->order("nom_portfolio ASC");
        return $this->fetchAll($select)->toArray();
    }

    public function grid($echo) {
        $iTotal = 0;
        $iFilteredTotal = 0;
        $output = array(
            "sEcho" => intval($echo),
            "iTotalRecords" => $iTotal,
            "iTotalDisplayRecords" => $iFilteredTotal,
            "aaData" => array()
        );
        $retorno = $this->gridList('A');
        foreach ($retorno as $row) {
            $rows = array(
                '<input type="checkbox" class="optcheck" value="' . $row['cod_portfolio'] . '" />',
                $row['nom_portfolio'],
                $row['des_portfolio'],
                $row['ind_status']
            );
            $output['aaData'][] = $rows;
        }
        return json_encode($output);
    }

}
