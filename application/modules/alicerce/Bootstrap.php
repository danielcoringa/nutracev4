<?php

class Alicerce_Bootstrap extends Zend_Application_Module_Bootstrap {

    protected function _init() {
        //
    }

    protected function _initAclControllerPlugin() {

        $this->bootstrap('frontcontroller');


        $front = Zend_Controller_Front::getInstance();

        $aclhelper = new Coringa_Security_Helper_Acl();
        $aclhelper->setRoles();
        $aclhelper->setResources();
        $aclhelper->setPrivileges();
        $aclhelper->setAcl();

        $aclPlugin = new Coringa_Security_Plugin_Acl($aclhelper->acl);
        $front->registerPlugin($aclPlugin);
    }

    protected function _initTranslate() {
        $translator = new Zend_Translate(array(
            'adapter' => 'array',
            'content' => APPLICATION_PATH . '/data/locales',
            'locale' => 'pt_BR',
            'disableNotices' => 'true',
            'scan' => Zend_Translate::LOCALE_DIRECTORY
        ));
        Zend_Validate_Abstract::setDefaultTranslator($translator);
    }

}
