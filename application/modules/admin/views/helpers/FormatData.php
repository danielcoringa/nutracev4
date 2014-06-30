<?php

class Zend_View_Helper_FormatData extends Zend_View_Helper_Abstract {

    public function FormatData($var) {
        if ($var != '') {
            list($d1, $h) = explode(" ", $var);
            list($a, $m, $d) = explode("-", $d1);
            if (strlen($h) > 5) {
                $h = substr($h, 0, -3);
            }
            return "$d/$m/$a $h";
        } else {
            return false;
        }
    }

}

?>
