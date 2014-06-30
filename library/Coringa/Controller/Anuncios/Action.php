<?php

class Coringa_Controller_Anuncios_Action extends Zend_Controller_Action {

    public function init() {

    }

//
//    public function tradicional() {
//        $this->view->headLink()->appendStylesheet('/css/alicerce/style.css');
//        $this->view->headLink()->appendStylesheet('/css/alicerce/grid.css');
//        $this->view->headLink()->appendStylesheet('/css/alicerce/layout.css');
//        $this->view->headLink()->appendStylesheet('/css/alicerce/external/jquery-ui-1.8.21.custom.css');
//        $this->view->headLink()->appendStylesheet('/css/alicerce/redmond/jquery.ui.theme.css');
//        $this->view->headLink()->appendStylesheet('/css/alicerce/elements.css');
//        $this->view->headLink()->appendStylesheet('/css/alicerce/shCore.css');
//        $this->view->headLink()->appendStylesheet('/css/alicerce/print-invoice.css');
//        $this->view->headLink()->appendStylesheet('/css/alicerce/typographics.css');
//        $this->view->headLink()->appendStylesheet('/css/alicerce/media-queries.css');
//        $this->view->headLink()->appendStylesheet('/css/alicerce/ie-fixes.css');
//        $this->view->headLink()->appendStylesheet('/css/alicerce/icons.css');
//        $this->view->headLink()->appendStylesheet('/css/alicerce/icons-pack.css');
//        $this->view->headLink()->appendStylesheet('/css/alicerce/external/jquery.chosen.css');
//        $this->view->headLink()->appendStylesheet('/css/alicerce/external/jquery.jgrowl.css');
//        $this->view->headLink()->appendStylesheet('/css/alicerce/external/syntaxhighlighter/shCore.css');
//        $this->view->headLink()->appendStylesheet('/css/alicerce/external/syntaxhighlighter/shThemeDefault.css');
//
//        $this->view->headLink()->appendStylesheet('/css/alicerce/fonts/font-awesome.css');
//        $this->view->headLink()->appendStylesheet('/css/alicerce/forms.css');
//    }

    public function norender() {
        $this->_helper->layout->disableLayout();
    }

    public function norenderall() {
        $this->_helper->layout->disableLayout();
        $this->_helper->viewRenderer->setNoRender(TRUE);
    }

    public function verifyAjax() {
        $param = $this->getRequest()->getParam("am");
        $request = $this->getRequest();
        if (!$request->isPost()) {
            if (!isset($param)) {
                $this->_redirect('/');
            }
        }
    }

}
