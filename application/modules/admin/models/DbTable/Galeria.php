<?php

/**
 * Description of Security
 * @category   PublicAnuncios
 * @package    Coringa_Controller
 * @copyright  Copyright (c) 2013-2013 CoringaSistemas INC (http://www.coringasistemas.com.br)
 */
class Admin_Model_DbTable_Galeria extends Zend_Db_Table_Abstract {

    protected $_name = 'tab_web_galeria';
    protected $_primary = 'cod_galeria';

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
        $cod_galeria = $dados['cod_galeria'];
        foreach ($dados as $key => $val) {
            if ($val !== '') {
                $data[$key] = $val;
            }
        }
        return $this->update($data, "cod_galeria=" . $cod_galeria);
    }

    public function getDados($where) {
        $select = $this->select();
        $select->where("cod_artigo=?", $where);
        $select->order('cod_galeria DESC');
        $return = $this->fetchAll($select);
        if ($return) {
            return $return->toArray();
        }
    }

    public function getSelect() {
        return $this->fetchAll('ind_status="A"')->toArray();
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
                '<input type="checkbox" class="optcheck" value="' . $row['cod_galeria'] . '" />',
                $row['nom_galeria'],
                $row['des_galeria'],
                $row['ind_status']
            );
            $output['aaData'][] = $rows;
        }
        return json_encode($output);
    }

}
