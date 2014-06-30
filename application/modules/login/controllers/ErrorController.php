<?php

class Login_ErrorController extends Zend_Controller_Action {

    public function errorAction() {
        $errors = $this->_getParam('error_handler');

        if (!$errors || !$errors instanceof ArrayObject) {
            $this->view->message = 'You have reached the error page';
            return;
        }

        switch ($errors->type) {
            case Zend_Controller_Plugin_ErrorHandler::EXCEPTION_NO_ROUTE:
            case Zend_Controller_Plugin_ErrorHandler::EXCEPTION_NO_CONTROLLER:
            case Zend_Controller_Plugin_ErrorHandler::EXCEPTION_NO_ACTION:
                // 404 error -- controller or action not found
                $this->getResponse()->setHttpResponseCode(404);
                $priority = Zend_Log::NOTICE;
                $this->view->message = 'Página não Encontrada';
                $this->view->exceptioncode = 404;

                break;
            default:
                // application error
                $this->getResponse()->setHttpResponseCode(500);
                if (stristr($errors->exception, '401')) {
                    $priority = Zend_Log::CRIT;
                    $this->view->exceptioncode = 401;
                    $this->view->message = 'Sessão Encerrada';
                    session_destroy();
                   // $this->_redirect('/artigos/youtube');
                }
                else {
                    $priority = Zend_Log::CRIT;
                    $this->view->message = 'Erro no Aplicativo';
                    $this->view->exceptioncode = 500;
                }
                //session_destroy();


                break;
        }

        // Log exception, if logger available
        if ($log = $this->getLog()) {
            $log->log($this->view->message, $priority, $errors->exception);
            $log->log('Request Parameters', $priority, $errors->request->getParams());
        }

        // conditionally display exceptions
        if ($this->getInvokeArg('displayExceptions') == true) {
            $this->view->exception = $errors->exception;
        }

        $this->view->request = $errors->request;
    }

    public function getLog() {
        $bootstrap = $this->getInvokeArg('bootstrap');
        if (!$bootstrap->hasResource('Log')) {
            return false;
        }
        $log = $bootstrap->getResource('Log');
        return $log;
    }

}
