<?php

class Zend_View_Helper_FormataDataHora extends Zend_View_Helper_Abstract {

    public function formataDataHora($date) {
        $dh = explode(" ", $date);
        list($dt, $h) = $dh;
        $dt = explode("-", $dt);
        list($y, $m, $d) = $dt;
        return "{$d}/{$m}/{$y} {$h}";
    }

}

?>
