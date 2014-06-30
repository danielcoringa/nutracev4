<?php

class Zend_View_Helper_FormataData extends Zend_View_Helper_Abstract {

    public function FormataData($var) {
        if ($var != '') {

            $data = explode(" ", $var);
            $d = explode("-", $data[0]);
            $hora = $data[1];
            $data = $d[2] . '/' . $d[1] . '/' . $d[0];
            return $data;
        } else {
            return false;
        }
    }

}

?>
