<?php

/**
 * Description of Security
 * @category   PublicAnuncios
 * @package    Coringa_Controller
 * @copyright  Copyright (c) 2013-2013 CoringaSistemas INC (http://www.coringasistemas.com.br)
 */
class Alicerce_RelatoriosController extends Coringa_Controller_Alicerce_Action {

    public function init() {
        // Layout
        parent::init();
        parent::norender();
        $this->view->empresa = $this->empresa;
        parent::forms();
        //Banco de Dados
        $this->db = new Alicerce_Model_DbTable_Cliente();
        //Gerador de PDF
        $this->pdf = new Coringa_Pdf_Fpdf();
        //Paramentros da Página
        $this->request = $this->getRequest();
        $this->params = $this->request->getPost();
        //parent::verifyAjax();
    }

    public function clientesAction() {
        if ($this->request->isPost()) {
            parent::norender();
            $this->_helper->viewRenderer->setNoRender(TRUE);
            $_SESSION['results'] = $this->db->getClienteRel($this->params);
            $_SESSION['filtros'] = $this->params;
            $_SESSION['relatorio'] = 'relatorioCliente';
            echo "$.jGrowl('Relatorio gerado com Sucesso!');";
            echo "window.open('/relatorios/make-relatorio','','width=840,height=640');";
            echo "$(':submit').removeAttr('disabled');";
            exit;
        }
        $this->view->clientes = $this->db->getClienteSelect();
    }

    public function makeRelatorioAction() {
        parent::norender();
        $relatorio = $_SESSION['relatorio'];
        $this->_helper->viewRenderer->setNoRender(TRUE);
        $this->pdf->setResults($_SESSION['results']);
        $this->pdf->$relatorio($_SESSION['filtros']);
    }

    public function coResponsabilidadesAction() {
        if ($this->request->isPost()) {
            parent::norender();
            $this->_helper->viewRenderer->setNoRender(TRUE);
            $_SESSION['results'] = $this->db->getCoClienteRel($this->params);
            $_SESSION['filtros'] = $this->params;
            $_SESSION['relatorio'] = 'relatorioCoResponsabilidade';

            echo "$.jGrowl('Relatorio gerado com Sucesso!');";
            echo "window.open('relatorios/make-relatorio','','width=840,height=640');";
            echo "$(':submit').removeAttr('disabled');";
            exit;
        }
        $this->view->clientes = $this->db->getClienteSelect();
        $this->view->coclientes = $this->db->getClienteSelect('cod_co_responsabilidade>0 AND ind_status="A"');
    }

    public function cobrancasAction() {
        if ($this->request->isPost()) {
            $db = new Alicerce_Model_DbTable_Cobranca();
            parent::norender();
            $this->_helper->viewRenderer->setNoRender(TRUE);
            $_SESSION['results'] = $db->getCobrancaRel($this->params);
            $_SESSION['filtros'] = $this->params;
            $_SESSION['relatorio'] = 'relatorioCobranca';

            echo "$.jGrowl('Relatorio gerado com Sucesso!');";
            echo "window.open('relatorios/make-relatorio','','width=840,height=640');";
            echo "$(':submit').removeAttr('disabled');";
            exit;
        }
        $this->view->clientes = $this->db->getClienteSelect();
    }

    public function obrasAction() {
        if ($this->request->isPost()) {
            $db = new Alicerce_Model_DbTable_Obra();
            parent::norender();
            $this->_helper->viewRenderer->setNoRender(TRUE);
            $_SESSION['results'] = $db->getObraRel($this->params);
            $_SESSION['filtros'] = $this->params;
            $_SESSION['relatorio'] = 'relatorioObra';

            echo "$.jGrowl('Relatorio gerado com Sucesso!');";
            echo "window.open('relatorios/make-relatorio','','width=840,height=640');";
            echo "$(':submit').removeAttr('disabled');";
            exit;
        }
        $this->view->clientes = $this->db->getClienteSelect();
    }

    public function equipamentosAction() {
        $dbcat = new Alicerce_Model_DbTable_Categoria();
        $this->view->categorias = $dbcat->getCategoriaSelect();
    }

}

?>
