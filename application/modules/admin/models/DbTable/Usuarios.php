<?php

/**
 * Description of Security
 * @category   PublicAnuncios
 * @package    Coringa_Controller
 * @copyright  Copyright (c) 2013-2013 CoringaSistemas INC (http://www.coringasistemas.com.br)
 */
class Admin_Model_DbTable_Usuarios extends Coringa_Db_Table_Admin {

    protected $_name = 'usuarios';
    protected $_primary = 'id';
    //Campos da Grid
    private $_camposLst = array('id' => array('nome' => 'txt_cod_usuario', 'tipo' => 'int', 'sortable' => 'yes', 'tamanho' => '11'),
        'nome' => array('nome' => 'txt_nom_nome', 'tipo' => 'varchar', 'sortable' => 'yes', 'tamanho' => '35'),
        'usuario' => array('nome' => 'txt_nom_usuario', 'tipo' => 'varchar', 'sortable' => 'yes', 'tamanho' => '35'),
        'senha' => array('nome' => 'txt_nom_senha', 'tipo' => 'varchar', 'sortable' => 'yes', 'tamanho' => '60'),
        'data_cadastro' => array('nome' => 'txt_dat_cadastro', 'tipo' => 'varchar', 'sortable' => 'yes', 'tamanho' => '45'),
        'ativo' => array('nome' => 'txt_ind_ativo', 'tipo' => 'varchar', 'sortable' => 'yes', 'tamanho' => '15')
    );

    public function inserir($dados) {
        $data = array();
        foreach ($dados as $key => $val) {
            if ($val !== '') {
                $data[$key] = $val;
            }
        }
        return $this->insert($data);
    }

    public function getcamposLst() {

        return $this->_camposLst;
    }

    public function getTotalRegistros() {

        return count($this->fetchAll()->toArray());
    }

    public function getId() {
        return $this->_primary;
    }

}
