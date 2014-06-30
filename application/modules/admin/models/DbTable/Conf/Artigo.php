<?php

/**
 * Description of Security
 * @category   PublicAnuncios
 * @package    Coringa_Controller
 * @copyright  Copyright (c) 2013-2013 CoringaSistemas INC (http://www.coringasistemas.com.br)
 */
class Admin_Model_DbTable_Conf_Artigo extends Zend_Db_Table_Abstract {

    protected $_name = 'tab_conf_artigo';
    protected $_primary = 'cod_conf_artigo';

    public function gridList() {
        $select = $this->select();
        $select->where("ind_status=?", "A");
        return $this->fetchAll($select);
    }

    public function inserir($dados) {
        $data = array();

        $retorno = $this->insert($data);
        $db = new Admin_Model_DbTable_CategoriaArtigo();
        foreach ($dados['cod_categoria'] as $categoria) {
            $db->insert(array("cod_categoria" => $categoria, "cod_artigo" => $retorno));
        }


        return $retorno;
    }

    public function atualizar($dados) {
        $data = array();
        $data['nom_artigo'] = $dados['nom_artigo'];
        $data['des_artigo'] = $dados['des_artigo'];
        $data['tipo_artigo'] = $dados['tipo_artigo'];
        $data['tag_artigo'] = $dados['tag_artigo'];
        $retorno = $this->update($data, "cod_artigo=" . $dados['cod_artigo']);
        $db = new Admin_Model_DbTable_CategoriaArtigo();
        $db->delete("cod_artigo=" . $dados['cod_artigo']);
        foreach ($dados['cod_categoria'] as $categoria) {
            $db->insert(array("cod_categoria" => $categoria, "cod_artigo" => $dados['cod_artigo']));
        }


        return $retorno;
    }

    public function getDados($where = '') {
        $select = $this->select();
        if ($where != '') {
            $select->where("cod_artigo=?", $where);
        }
        return $this->fetchRow($select);
    }

    public function getSelect() {
        return $this->fetchAll()->toArray();
    }

    public function getArtigos() {
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
                '<input type="checkbox" class="optcheck" value="' . $row['cod_artigo'] . '" />',
                $row['nom_artigo'],
                $row['des_artigo'],
                $row['ind_status']
            );
            $output['aaData'][] = $rows;
        }
        return json_encode($output);
    }

}
