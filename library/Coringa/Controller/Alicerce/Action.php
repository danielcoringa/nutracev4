<?php

class Coringa_Controller_Alicerce_Action extends Zend_Controller_Action {

    public function init() {

        $empresa = new Alicerce_Model_DbTable_Empresa();
        $this->view->empresa = $empresa->getEmpresaDefault();
        $this->empresa = $empresa->getEmpresaDefault();
        $cfg = new Alicerce_Model_DbTable_Configuracao();
        $this->config = $cfg->config();
        $this->view->headLink()->appendStylesheet('/alicerce/minify/css');
        $this->view->headScript()->appendFile('/js/alicerce/jquery.easytabs.js');
        $this->view->headScript()->appendFile('/js/alicerce/jquery.maskMoney.js');
        $this->view->headScript()->appendFile('/js/alicerce/mylibs/forms/jquery.checkbox.js');
        $this->view->headScript()->appendFile('/js/alicerce/mylibs/forms/jquery.chosen.js');
        $this->view->headScript()->appendFile('/js/alicerce/mylibs/jquery.ui.multiaccordion.js');
        $this->view->headScript()->appendFile('/js/alicerce/jquery_form.js');
        $authNamespace = new Zend_Session_Namespace("auth");
    }

    public function tables() {

        $this->view->headScript()->appendFile('/js/alicerce/mylibs/dynamic-tables/jquery.dataTables.js');
        $this->view->headScript()->appendFile('/js/alicerce/mylibs/dynamic-tables/jquery.dataTables.tableTools.js');
        $this->view->headScript()->appendFile('/js/alicerce/mylibs/dynamic-tables/jquery.dataTables.tableTools.zeroClipboard.js');
    }

    public function forms() {
        $this->view->headScript()->appendFile('/js/alicerce/mylibs/forms/jquery.autosize.js');
        $this->view->headScript()->appendFile('/js/alicerce/mylibs/forms/jquery.cleditor.js');
        $this->view->headScript()->appendFile('/js/alicerce/mylibs/forms/jquery.colorpicker.js');
        $this->view->headScript()->appendFile('/js/alicerce/mylibs/forms/jquery.ellipsis.js');
        $this->view->headScript()->appendFile('/js/alicerce/mylibs/forms/jquery.fileinput.js');
        $this->view->headScript()->appendFile('/js/alicerce/mylibs/forms/jquery.fullcalendar.js');
        $this->view->headScript()->appendFile('/js/alicerce/mylibs/forms/jquery.maskedinput.js');
        $this->view->headScript()->appendFile('/js/alicerce/mylibs/forms/jquery.mousewheel.js');
        $this->view->headScript()->appendFile('/js/alicerce/mylibs/forms/jquery.placeholder.js');
        $this->view->headScript()->appendFile('/js/alicerce/mylibs/forms/jquery.pwdmeter.js');
        $this->view->headScript()->appendFile('/js/alicerce/mylibs/forms/jquery.ui.datetimepicker.js');
        $this->view->headScript()->appendFile('/js/alicerce/mylibs/forms/jquery.ui.spinner.js');
        $this->view->headScript()->appendFile('/js/alicerce/mylibs/forms/jquery.validate.js');
        $this->view->headScript()->appendFile('/js/alicerce/jquery.maskMoney.js');
        $this->view->headScript()->appendFile('/js/alicerce/php.default.min.js');

        $this->view->headScript()->appendFile('/js/alicerce/mylibs/forms/uploader/plupload.full.min.js');
        $this->view->headScript()->appendFile('/js/alicerce/mylibs/forms/uploader/jquery.plupload.queue/jquery.plupload.queue.js');

        $this->view->headLink()->appendStylesheet('/css/alicerce/external/jquery.cleditor.css');
    }

    public function dashboard() {
        $this->view->headScript()->appendFile('/js/alicerce/mylibs/charts/jquery.flot.js');
        $this->view->headScript()->appendFile('/js/alicerce/mylibs/charts/jquery.flot.orderBars.js');
        $this->view->headScript()->appendFile('/js/alicerce/mylibs/charts/jquery.flot.navigate.js');
        $this->view->headScript()->appendFile('/js/alicerce/mylibs/charts/jquery.flot.pie.js');
        $this->view->headScript()->appendFile('/js/alicerce/mylibs/charts/jquery.flot.resize.js');
    }

    public function tradicional() {
        $this->view->headLink()->appendStylesheet('/css/alicerce/style.css');
        $this->view->headLink()->appendStylesheet('/css/alicerce/grid.css');
        $this->view->headLink()->appendStylesheet('/css/alicerce/layout.css');
        $this->view->headLink()->appendStylesheet('/css/alicerce/external/jquery-ui-1.8.21.custom.css');
        $this->view->headLink()->appendStylesheet('/css/alicerce/redmond/jquery.ui.theme.css');
        $this->view->headLink()->appendStylesheet('/css/alicerce/elements.css');
        $this->view->headLink()->appendStylesheet('/css/alicerce/shCore.css');
        $this->view->headLink()->appendStylesheet('/css/alicerce/print-invoice.css');
        $this->view->headLink()->appendStylesheet('/css/alicerce/typographics.css');
        $this->view->headLink()->appendStylesheet('/css/alicerce/media-queries.css');
        $this->view->headLink()->appendStylesheet('/css/alicerce/ie-fixes.css');
        $this->view->headLink()->appendStylesheet('/css/alicerce/icons.css');
        $this->view->headLink()->appendStylesheet('/css/alicerce/icons-pack.css');
        $this->view->headLink()->appendStylesheet('/css/alicerce/external/jquery.chosen.css');
        $this->view->headLink()->appendStylesheet('/css/alicerce/external/jquery.jgrowl.css');
        $this->view->headLink()->appendStylesheet('/css/alicerce/external/syntaxhighlighter/shCore.css');
        $this->view->headLink()->appendStylesheet('/css/alicerce/external/syntaxhighlighter/shThemeDefault.css');

        $this->view->headLink()->appendStylesheet('/css/alicerce/fonts/font-awesome.css');
        $this->view->headLink()->appendStylesheet('/css/alicerce/forms.css');
    }

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
