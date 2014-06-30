<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class Admin_LixeiraController extends Coringa_Controller_Admin_Action {

    public function init() {
        parent::init();
    }

    public function excluirAction() {
        $this->noRender();
        $dbl = new Admin_Model_DbTable_Lixeira();
        $request = $this->getRequest();
        $param = $request->getPost();
        $mdb = 'Admin_Model_DbTable_';
        $tdb = $mdb . ucfirst($param['tbl']);

        if (class_exists($tdb)) {
            $campo = 'cod_' . strtolower($param['tbl']);
            $tabela = 'tab_web_' . strtolower($param['tbl']);
            $db = new $tbd();
        }
        else {
            $tdb = $mdb . ucfirst(substr($param['tbl'], 0, -1));
            if (class_exists($tdb)) {
                $campo = 'cod_' . strtolower(substr($param['tbl'], 0, -1));
                $tabela = 'tab_web_' . strtolower(substr($param['tbl'], 0, -1));
                $db = new $tdb();
            }
            else {

            }
        }
        foreach ($param['ids'] as $id) {
            $update = $db->update(array("ind_status" => 'E'), $campo . '=' . $id);
            $insert = $dbl->insert(array("nom_tabela" => $tabela, "campo_tabela" => $campo, "cod_campo" => $id));
            if ($insert > 0) {

                echo 'checks.parents("tr").hide("slow",function(){$(this).remove()});';
            }
        }
        echo "bootbox.alert('Registros Excluídos com Sucesso!');";
    }

}
