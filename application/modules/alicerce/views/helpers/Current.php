<?php

/*
 * Função básica para verificar a página ativa e atribuir o CSS corretamente ao
 * menu lateral
 */

class Zend_View_Helper_Current extends Zend_View_Helper_Abstract {

    public function current($n) {
        // Se for a página principal
        $local2 = $_SERVER['REQUEST_URI'];
        $l2 = explode('/', $local2);
        $l1 = explode('/', $n);
        if (count($l1) == 2) {

            if ($l1[1] == $l2[1]) {
                return "current open";
            }
        } else {
            if ($l2[2] == $l1[2]) {
                return 'current';
            }
        }
    }

}

?>
