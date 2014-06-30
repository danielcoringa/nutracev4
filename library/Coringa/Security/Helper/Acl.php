<?php

class Coringa_Security_Helper_Acl extends Zend_Controller_Action_Helper_Abstract {

    //the acl object
    public $acl;

    //the constructor of the our ACL
    public function __construct() {
        $this->acl = new Zend_Acl();
        $this->auth = new Zend_Session_Namespace("auth");
        $this->userid = $this->auth->user_id;
        if ($this->userid == '') {
            $this->userid = 0;
        }
        $params = array('host' => 'localhost',
            'username' => 'nutrace_root',
            'password' => 'Str0ng@123',
            'dbname' => 'nutrace_banco');
        $this->_db = Zend_Db::factory('PDO_MYSQL', $params);
    }

    private function montaAcl() {
        
    }

    //function that sets roles for the people
    public function setRoles() {

        $vuser = $this->_db->select();
        $vuser->from(array("tu" => "usuarios"));
        $vuser->joinInner(array("tg" => "tiposusuarios"), "tg.id=tu.tiposusuarios_id");
        $vuser->where("tu.id = " . $this->userid);

        $this->r = $this->_db->fetchAll($vuser);
        //print_r($vuser->__toString());exit;
        // Verifica o tipo de acesso
        if (count($this->r) > 0) {
            $role = strtolower($this->r[0]['nome']);
        } else {
            $role = 'visitante';
        }

        $this->role = $role;
        $this->acl->addRole(new Zend_Acl_Role($role));
    }

    //function that set the resources to be accessed on the site
    public function setResources() {
        //$this->montaAcl();
        if ($this->role == 'produtor' || $this->role == 'administrador') {
            $this->acl->add(new Zend_Acl_Resource('admin'));
            $this->acl->add(new Zend_Acl_Resource('admin:index'));
            $this->acl->add(new Zend_Acl_Resource('admin:grid'));
            $this->acl->add(new Zend_Acl_Resource('admin:listar'));
            $this->acl->add(new Zend_Acl_Resource('admin:error'));
            $this->acl->add(new Zend_Acl_Resource('admin:json'));
        }
        if ($this->role == 'administrador') {
            $this->acl->add(new Zend_Acl_Resource('admin:usuarios'));
        }
        $this->acl->add(new Zend_Acl_Resource('login'));
        $this->acl->add(new Zend_Acl_Resource('login:index'));
        $this->acl->add(new Zend_Acl_Resource('login:minify'));
        $this->acl->add(new Zend_Acl_Resource('login:error'));
    }

    //function that sets the privileges for the different roles
    public function setPrivileges() {
        if ($this->role == 'produtor' || $this->role == 'administrador') {
            $this->acl->allow($this->role, 'admin');
            $this->acl->allow($this->role, 'admin:index');
            $this->acl->allow($this->role, 'admin:grid');
            $this->acl->allow($this->role, 'admin:listar');
            $this->acl->allow($this->role, 'admin:error');
            $this->acl->allow($this->role, 'admin:json');
        }
        if ($this->role == 'administrador') {
            $this->acl->allow($this->role, 'admin:usuarios');
        }
        $this->acl->allow($this->role, 'login');
        $this->acl->allow($this->role, 'login:index');
        $this->acl->allow($this->role, 'login:minify');
        $this->acl->allow($this->role, 'login:error');
        //print_r($this->acl);exit;
    }

    public function setAcl() {
        Zend_Registry::set('acl', $this->acl);
    }

}
