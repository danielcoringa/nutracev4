<?php
/**
 * Description of Security
 * @category   PublicAnuncios
 * @package    Coringa_Controller
 * @copyright  Copyright (c) 2013-2013 CoringaSistemas INC (http://www.coringasistemas.com.br)
 */
class Coringa_Controller_Site_Action extends Zend_Controller_Action {

    public function init() {
        $defaultNamespace = new Zend_Session_Namespace('checkin');
        if(!isset($defaultNamespace->site)){
            $defaultNamespace->site = md5(uniqid(microtime()));
        }
        $this->view->keyInternal = $_SESSION['checkin']['site'];
        $dba = new Admin_Model_DbTable_Artigo();
        $dbc = new Admin_Model_DbTable_Categoria();
        $this->view->categorias = $dbc->getSelect();
        $params = $this->getRequest()->getParams();
        //if ($params['controller'] != 'index') {
        //}
        $this->view->news = $dba->getNews();
        $this->view->popular = $dba->getSuggest('popular');
        $this->view->latest = $dba->getSuggest('latest');
        $this->view->random = $dba->getSuggest('random');
    }

    public function noRender() {
        $this->view->keyInternal = $_SESSION['checkin']['site'];
        $dba = new Admin_Model_DbTable_Artigo();
        /* $this->_helper->layout->disableLayout(); */
        $this->_helper->viewRenderer->setNoRender(TRUE);
        $dba = new Admin_Model_DbTable_Artigo();


        $params = $this->getRequest()->getParams();

        $this->view->news = $dba->getNews();
        $this->view->popular = $dba->getSuggest('popular');
        $this->view->latest = $dba->getSuggest('latest');
        $this->view->random = $dba->getSuggest('random');
    }

    public function flickrs() {
        $flickr = new Zend_Service_Flickr('a596d0ee3afb48aa81730f1ce1077d6e');
        $results = $flickr->userSearch("danielcoringa");
        $flickrs = array();
        foreach ($results as $result) {
            $flickrs[] = $result;
        }
        $this->view->flickrs = $flickrs;
    }

    public function noLayout() {
        $this->view->keyInternal = $_SESSION['checkin']['site'];
//        $defaultNamespace = new Zend_Session_Namespace('checkin');
//        $defaultNamespace->setExpirationSeconds(3600);
//        $defaultNamespace->site = uniqid(microtime());
        $defaultNamespace = new Zend_Session_Namespace('checkin');
        
        $this->_helper->layout->disableLayout();
        $dba = new Admin_Model_DbTable_Artigo();
        $flickr = new Zend_Service_Flickr('a596d0ee3afb48aa81730f1ce1077d6e');
        $results = $flickr->userSearch("danielcoringa");
        $params = $this->getRequest()->getParams();
        if ($params['controller'] != 'index') {
            $flickrs = array();
            foreach ($results as $result) {
                $flickrs[] = $result;
            }
            $this->view->flickrs = $flickrs;
        }
        $this->view->news = $dba->getNews();
        $this->view->popular = $dba->getSuggest('popular');
        $this->view->latest = $dba->getSuggest('latest');
        $this->view->random = $dba->getSuggest('random');
    }
    public function verify(){
               
        $this->sessao = $_SESSION['checkin'];
        if($this->sessao['site']==''){
            print_r($this->sessao);
            
            
        }
        if($this->getRequest()->getParam("internal")==''){
            
            die('C3P0');
            
        }
        if($this->getRequest()->getParam("internal")!= $this->sessao['site']){
            print_r($this->sessao);
            die('OBI HAN');
            }
    }
}