<?php

class Coringa_Security_Plugin_Acl extends Zend_Controller_Plugin_Abstract {

    /**
     *
     * @var Zend_Auth
     */
    protected $_auth; //Zend_Auth instance for user access
    protected $_acl; //Zend_Acl instance for user privileges
    protected $_module;
    protected $_action;
    protected $_controller;
    protected $_currentRole;
    protected $_resource;

    public function __construct(Zend_Acl $acl, array $options = array()) {
        $this->_auth = Zend_Auth::getInstance();
        $this->_acl = $acl;
        $params = array('host' => 'localhost',
           'username' => 'nutrace_root',
            'password' => 'Str0ng@123',
            'dbname' => 'nutrace_banco');
        $db = Zend_Db::factory('PDO_MYSQL', $params);
        $cod_user = $_SESSION['auth']['user_id'];
        if ($cod_user == '') {
            $cod_user = 0;
        }
    }

    public function preDispatch(Zend_Controller_Request_Abstract $request) {

        $this->_init($request);

        if ($this->_acl->has($this->_resource)) {
            if(empty($this->_currentRole)){$this->_currentRole = 'visitante';echo 'visitante';}
            // if the current user role is not allowed to do something
            if (!$this->_acl->isAllowed($this->_currentRole, $this->_resource, $this->_action)) {

                $request->setParam("error", "Sem Acesso");
                $request->setModuleName('login');
                $request->setControllerName('index');
                $request->setParam("origem", $this->_module);
                $request->setActionName('index');
            }
        }
        else {

            $request->setModuleName('login');
            $request->setControllerName('index');
            $request->setParam("error", "Sem Acesso");
            $request->setParam("origem", $this->moduleAmigavel($this->_module));
            $request->setActionName('index');
        }
    }

    protected function _init($request) {
        $this->_module = $request->getModuleName();
        $this->_action = $request->getActionName();
        $this->_controller = $request->getControllerName();
        $this->_currentRole = $this->_getCurrentUserRole();


        $params = $request->getParams();
        if (isset($params['cadastro'])) {
            $this->_resource = $this->_module . ':' . $this->_controller . ":" . $this->_action;
        }
        else {
            $this->_resource = $this->_module . ':' . $this->_controller;
        }
    }

    private function moduleAmigavel($var) {
        $amigavel = array("admin" => "Administração Nutrace",
            "login" => "Tela de Entrada",
            "cursos" => "Cursos On-Line");
        return $amigavel[$var];
    }

    protected function _getCurrentUserRole() {

        if ($this->_auth->hasIdentity()) {
            $authData = $this->_auth->getIdentity();
            //$role = isset($authData->myType())?strtolower($authData->property->privilage): 'guest';
            //retrieving the UserType
            $authNamespace = new Zend_Session_Namespace("auth");

            if ($authNamespace->users === true) {
                $role = $authNamespace->role;
            }
        }
        else {
            $role = 'visitante';
        }
        return $role;
    }

}

?>
