<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class Login_MinifyController extends Coringa_Controller_Login_Action {

    public function init() {
        parent::norenderall();
        $default = array(
            'js/login/mylibs/polyfills/modernizr-2.6.1.min.js',
            'js/login/mylibs/polyfills/matchmedia.js',
            'js/login/jquery.cookie.js',
            'js/login/coringa.js',
            'js/login/mango.js',
            'js/login/hashchange.js',
            'js/login/app.js',
            'js/login/mylibs/jquery.hashchange.js',
            'js/login/mylibs/jquery.idle-timer.js',
            'js/login/mylibs/number-functions.js',
            'js/login/mylibs/jquery.jgrowl.js',
            'js/login/mylibs/jquery.plusplus.js',
            'js/login/mylibs/jquery.scrollTo.js',
            'js/login/mylibs/tooltips/jquery.tipsy.js',
            'js/login/mylibs/jquery.ui.touch-punch.js',
            'js/login/mylibs/syntaxhighlighter/shCore.js',
            'js/login/mylibs/syntaxhighlighter/shAutoloader.js',
            'js/login/mylibs/syntaxhighlighter/shBrushJScript.js',
            'js/login/script.js',
            'js/login/plugins.js');
        $this->setScripts($default);
    }

    public function setScripts($scripts) {
        if (is_array($scripts)) {
            $this->scripts = $scripts;
        }
    }

    public function javascriptAction() {

        $params = $this->getRequest()->getParams();
        $this->getResponse()
                ->setHeader('Content-type', 'application/x-javascript');
        $js = new Coringa_Minify_ParserJs();
        $js->setScripts($this->scripts);
        echo $js->init();
    }

    public function cssAction() {
        header("Content-type: text/css");
        $css = array(
            '/css/login/grid.css',
            '/css/login/layout.css',
            '/css/login/external/jquery-ui-1.8.21.custom.css',
            '/css/login/redmond/jquery.ui.theme.css',
            '/css/login/style.css',
            '/css/login/elements.css',
            '/css/login/shCore.css',
            '/css/login/shThemeDefault.css',
            '/css/login/print-invoice.css',
            '/css/login/typographics.css',
            '/css/login/media-queries.css',
            '/css/login/ie-fixes.css',
            '/css/login/forms.css',
            '/css/login/external/jquery.chosen.css',
            '/css/login/external/jquery.jgrowl.css',
            '/css/login/external/syntaxhighlighter/shCore.css',
            '/css/login/external/syntaxhighlighter/shThemeDefault.css',
            '/css/login/icons-pack.css',
            '/css/login/fonts/font-awesome.css'
        );
        $css2 = array('/css/login/style.css');
        foreach ($css as $file_css) {
            $folder = str_replace("index.php", "", $_SERVER['SCRIPT_FILENAME']);
            $data.= file_get_contents($folder . $file_css);
        }
        $teste = new Coringa_Css_Minify();
        $teste->minify($data);
        echo $teste->getMinified();
        //echo $data;
    }

}
