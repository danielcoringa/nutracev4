<?php
/**
 * Description of Security
 * @category   Coringa
 * @package    Coringa_Security
 * @copyright  Copyright (c) 2013-2013 Coringa Sistemas Inc. (http://www.coringasistemas.com.br)
 */
class Coringa_Security_Acl extends Zend_Controller_Plugin_Abstract
{
     public function preDispatch(Zend_Controller_Request_Abstract $request)
    {
	 $authNamespace = new Zend_Session_Namespace("auth");
     }
    
   

}

?>
