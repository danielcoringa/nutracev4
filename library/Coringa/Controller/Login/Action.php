<?php

class Coringa_Controller_Login_Action extends Zend_Controller_Action {

    public function init() {
        $this->view->headLink()->appendStylesheet('/login/minify/css');
        $this->view->headScript()->appendFile('/js/login/jquery.easytabs.js');
        $this->view->headScript()->appendFile('/js/login/jquery.maskMoney.js');
        $this->view->headScript()->appendFile('/js/login/mylibs/forms/jquery.checkbox.js');
        $this->view->headScript()->appendFile('/js/login/mylibs/forms/jquery.chosen.js');
        $this->view->headScript()->appendFile('/js/login/mylibs/jquery.ui.multiaccordion.js');
        $this->view->headScript()->appendFile('/js/login/jquery_form.js');
        $authNamespace = new Zend_Session_Namespace("auth");
    }

    public function tables() {

        $this->view->headScript()->appendFile('/js/login/mylibs/dynamic-tables/jquery.dataTables.js');
        $this->view->headScript()->appendFile('/js/login/mylibs/dynamic-tables/jquery.dataTables.tableTools.js');
        $this->view->headScript()->appendFile('/js/login/mylibs/dynamic-tables/jquery.dataTables.tableTools.zeroClipboard.js');
    }

    public function forms() {
        $this->view->headScript()->appendFile('/js/login/mylibs/forms/jquery.autosize.js');
        $this->view->headScript()->appendFile('/js/login/mylibs/forms/jquery.cleditor.js');
        $this->view->headScript()->appendFile('/js/login/mylibs/forms/jquery.colorpicker.js');
        $this->view->headScript()->appendFile('/js/login/mylibs/forms/jquery.ellipsis.js');
        $this->view->headScript()->appendFile('/js/login/mylibs/forms/jquery.fileinput.js');
        $this->view->headScript()->appendFile('/js/login/mylibs/forms/jquery.fullcalendar.js');
        $this->view->headScript()->appendFile('/js/login/mylibs/forms/jquery.maskedinput.js');
        $this->view->headScript()->appendFile('/js/login/mylibs/forms/jquery.mousewheel.js');
        $this->view->headScript()->appendFile('/js/login/mylibs/forms/jquery.placeholder.js');
        $this->view->headScript()->appendFile('/js/login/mylibs/forms/jquery.pwdmeter.js');
        $this->view->headScript()->appendFile('/js/login/mylibs/forms/jquery.ui.datetimepicker.js');
        $this->view->headScript()->appendFile('/js/login/mylibs/forms/jquery.ui.spinner.js');
        $this->view->headScript()->appendFile('/js/login/mylibs/forms/jquery.validate.js');
        $this->view->headScript()->appendFile('/js/login/jquery.maskMoney.js');
        $this->view->headScript()->appendFile('/js/login/php.default.min.js');

        $this->view->headScript()->appendFile('/js/login/mylibs/forms/uploader/plupload.full.min.js');
        $this->view->headScript()->appendFile('/js/login/mylibs/forms/uploader/jquery.plupload.queue/jquery.plupload.queue.js');

        $this->view->headLink()->appendStylesheet('/css/login/external/jquery.cleditor.css');
    }

    public function dashboard() {
        $this->view->headScript()->appendFile('/js/login/mylibs/charts/jquery.flot.js');
        $this->view->headScript()->appendFile('/js/login/mylibs/charts/jquery.flot.orderBars.js');
        $this->view->headScript()->appendFile('/js/login/mylibs/charts/jquery.flot.navigate.js');
        $this->view->headScript()->appendFile('/js/login/mylibs/charts/jquery.flot.pie.js');
        $this->view->headScript()->appendFile('/js/login/mylibs/charts/jquery.flot.resize.js');
    }

    public function tradicional() {
        $this->view->headLink()->appendStylesheet('/css/login/style.css');
        $this->view->headLink()->appendStylesheet('/css/login/grid.css');
        $this->view->headLink()->appendStylesheet('/css/login/layout.css');
        $this->view->headLink()->appendStylesheet('/css/login/external/jquery-ui-1.8.21.custom.css');
        $this->view->headLink()->appendStylesheet('/css/login/redmond/jquery.ui.theme.css');
        $this->view->headLink()->appendStylesheet('/css/login/elements.css');
        $this->view->headLink()->appendStylesheet('/css/login/shCore.css');
        $this->view->headLink()->appendStylesheet('/css/login/print-invoice.css');
        $this->view->headLink()->appendStylesheet('/css/login/typographics.css');
        $this->view->headLink()->appendStylesheet('/css/login/media-queries.css');
        $this->view->headLink()->appendStylesheet('/css/login/ie-fixes.css');
        $this->view->headLink()->appendStylesheet('/css/login/icons.css');
        $this->view->headLink()->appendStylesheet('/css/login/icons-pack.css');
        $this->view->headLink()->appendStylesheet('/css/login/external/jquery.chosen.css');
        $this->view->headLink()->appendStylesheet('/css/login/external/jquery.jgrowl.css');
        $this->view->headLink()->appendStylesheet('/css/login/external/syntaxhighlighter/shCore.css');
        $this->view->headLink()->appendStylesheet('/css/login/external/syntaxhighlighter/shThemeDefault.css');

        $this->view->headLink()->appendStylesheet('/css/login/fonts/font-awesome.css');
        $this->view->headLink()->appendStylesheet('/css/login/forms.css');
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
