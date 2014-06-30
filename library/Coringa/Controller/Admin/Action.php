<?php

/**
 * Description of Security
 * @category   Controller
 * @package    Coringa_Controller
 * @copyright  Copyright (c) 2013-2013 CoringaSistemas INC (http://www.coringasistemas.com.br)
 */
class Coringa_Controller_Admin_Action extends Zend_Controller_Action {

    /**
     * Método de inicialização das classes filhas
     */
    public function init() {
        $adapter = new Zend_Translate(array(
            'adapter' => 'array',
            'content' => APPLICATION_PATH . '/data/locales',
            'locale' => 'pt_BR',
            'disableNotices' => 'true',
            'scan' => Zend_Translate::LOCALE_DIRECTORY
        ));
        Zend_Registry::set('Zend_Translate', $adapter);
        $this->translate = new Zend_View_Helper_Translate($adapter);

        // Mostra a lista de usuários para o administrador
        $objUsuarios = new Admin_Model_DbTable_Usuarios();
        $this->view->list_user = $objUsuarios->consulta("*", null, null, 'imagem <> "" AND excluido = 1')->getDados();
        unset($objUsuarios);
    }

    /**
     * Método para remover a renderização e o layout das páginas para ajax
     */
    public function noRender() {
        $this->_helper->layout->disableLayout();
        $this->_helper->viewRenderer->setNoRender(TRUE);
    }

    /**
     * Método para exibir o Breadcrumb da página
     */
    public function breadCrumb() {
        $this->view->breadcrumb = $this->getBreadcrumb();
    }

    public function getPlugin($param) {
        $pathPlugin = realpath('../application/modules/admin/views/scripts/plugins');

        switch ($param) {
            default:
                $render = $pathPlugin . DIRECTORY_SEPARATOR . $param . '.phtml';
                break;
        }
        return file_get_contents($render);
    }

    /**
     * Método para criar o Breadcrumb das páginas
     */
    private function getBreadcrumb() {
        // Configura a navegação
        $type = 1; // Tipos de formação: 1- lista(ul), 2- div
        $class = 'breadcrumb'; // Class CSS
        $icons = true; // Atribuição de Icones
        // Monta o html do navegador
        $breadcrumb = $this->makeTag($type, $icons, $class);
        return $breadcrumb;
    }

    /**
     * Método interno para gerar o Navegador
     * @param int $type - Tipo de navegador :: 1 - ul , 2 - div
     * @param boolean $icons - Utilizar icones no navegador
     * @param array $content - Página atual
     * @param string $class - Class CSS da TAG do navegdor
     * @return string
     */
    private function makeTag($type = 1, $icons = true, $class = null) {

        if ($type == 1) {
            return $this->makeType('ul', $class);
        }
    }

    /**
     * Método interno para checar o conteúdo do navegador
     * @param string $content - Conteudo do link
     * @param boolean $icons - Utilizar icones no navegador
     * @return string
     */
    private function checkContent($content, $icons = true, $links = true) {
        $url = $content;
        $contentt = $this->translate->translate('txt_bc_' . $content);
        switch ($content) {
            case 'usuarios':

                if ($links) {
                    $contentt = "<a href='/{$url}'>{$contentt}</a>";
                }
                if ($icons) {
                    $contentt = '<i class="fa fa-users"></i>' . PHP_EOL . $contentt;
                }
                break;

            case 'principal':


                if ($links) {
                    $contentt = "<a href='/'>{$contentt}</a>";
                }
                if ($icons) {
                    $contentt = '<i class="fa fa-home"></i>' . PHP_EOL . $contentt;
                }
                break;
            case 'perfil':


                if ($links) {
                    $contentt = "<a href='/'>{$contentt}</a>";
                }
                if ($icons) {
                    $contentt = '<i class="fa fa-user"></i>' . PHP_EOL . $contentt;
                }
                break;
            default:

                if ($links) {
                    $contentt = "<a href='/'>{$contentt}</a>";
                }
                if ($icons) {
                    $contentt = '<i class="fa fa-table"></i>' . PHP_EOL . $contentt;
                }
                break;
        }

        return $contentt;
    }

    /**
     * Método para Montar a tag da Navegação
     * @param string $type
     * @param string $class
     * @return string
     */
    private function makeType($type, $class = null) {
        $class = $class != null ? 'class="' . $class . '"' : '';
        switch ($type) {
            default:
                // Verifica a Página atual
                $controller = $this->getRequest()->getControllerName();
                $action = $this->getRequest()->getActionName();
                if ($controller !== 'index') {
                    $c1 = $this->checkContent('principal');
                    $ctag = "<li>{$c1}</li>";
                    $c2 = $this->checkContent($controller);
                    $ctag .= "<li>{$c2}</li>";
                    $c3 = $this->checkContent($action, true, false);
                    $ctag .= "<li>{$c3}</li>";
                } else {
                    $conteudo = $this->checkContent('principal', true, false);
                    $ctag = "<li>{$conteudo}</li>";
                }
                break;
        }

        $tag = "<ul {$class}>{$ctag}</ul>";
        return $tag;
    }

}
