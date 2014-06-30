<?php

/**
 * Controller Listar
 * 
 */
class Admin_ListarController extends Coringa_Controller_Admin_Action {

    public function init() {
        $this->view->title = 'Listar Dados';
        $this->view->modulo = 'listar';
    }

    public function fazendasAction() {
        $this->render('listar');
    }

    public function gridAction() {
        parent::noRender();
        $objLocais = new Admin_Model_DbTable_Locais();
        $colunas = $objLocais->getColunas();
        $locais = $objLocais->getDados($_SESSION['auth']['user_id']);
        $iTotal = count($locais);
        $iFilteredTotal = count($locais);
        
        $output = array(
            "draw" => intval($_REQUEST['draw']),
            "recordsTotal" => $iTotal,
            "recordsFiltered" => $iFilteredTotal,
            "aaData" => array()
        );
        
        //print_r($locais);exit();
        $x=0;
        foreach($locais as $loc){
            
            for($i=0;$i<count($colunas);$i++){
                $row[$i] = $loc[$colunas[$i]];
            }
             $output['aaData'][] = $row;
             $x++;
        }
        
        
        echo json_encode($output);
    }

}
