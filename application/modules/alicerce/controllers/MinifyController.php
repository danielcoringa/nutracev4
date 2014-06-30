<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class Alicerce_MinifyController extends Coringa_Controller_Alicerce_Action {

    public function init() {
        parent::norenderall();
        $default = array(
            'js/alicerce/mylibs/polyfills/modernizr-2.6.1.min.js',
            'js/alicerce/mylibs/polyfills/matchmedia.js',
            'js/alicerce/jquery.cookie.js',
            'js/alicerce/coringa.js',
            'js/alicerce/mango.js',
            'js/alicerce/hashchange.js',
            'js/alicerce/app.js',
            'js/alicerce/mylibs/jquery.hashchange.js',
            'js/alicerce/mylibs/jquery.idle-timer.js',
            'js/alicerce/mylibs/number-functions.js',
            'js/alicerce/mylibs/jquery.jgrowl.js',
            'js/alicerce/mylibs/jquery.plusplus.js',
            'js/alicerce/mylibs/jquery.scrollTo.js',
            'js/alicerce/mylibs/tooltips/jquery.tipsy.js',
            'js/alicerce/mylibs/jquery.ui.touch-punch.js',
            'js/alicerce/mylibs/syntaxhighlighter/shCore.js',
            'js/alicerce/mylibs/syntaxhighlighter/shAutoloader.js',
            'js/alicerce/mylibs/syntaxhighlighter/shBrushJScript.js',
            'js/alicerce/script.js',
            'js/alicerce/plugins.js');
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
            '/css/alicerce/grid.css',
            '/css/alicerce/layout.css',
            '/css/alicerce/external/jquery-ui-1.8.21.custom.css',
            '/css/alicerce/redmond/jquery.ui.theme.css',
            '/css/alicerce/style.css',
            '/css/alicerce/elements.css',
            '/css/alicerce/shCore.css',
            '/css/alicerce/print-invoice.css',
            '/css/alicerce/typographics.css',
            '/css/alicerce/media-queries.css',
            '/css/alicerce/ie-fixes.css',
            '/css/alicerce/forms.css',
            '/css/alicerce/external/jquery.chosen.css',
            '/css/alicerce/external/jquery.jgrowl.css',
            '/css/alicerce/external/syntaxhighlighter/shCore.css',
            '/css/alicerce/external/syntaxhighlighter/shThemeDefault.css',
            '/css/alicerce/icons-pack.css',
            '/css/alicerce/fonts/font-awesome.css'
        );
        $css2 = array('/css/alicerce/style.css');
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
