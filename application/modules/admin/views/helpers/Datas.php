<?php

class Zend_View_Helper_Datas extends Zend_View_Helper_Abstract {

    public function numDias($mes, $ano) {
        if (($mes < 8 && $mes % 2 == 1) || ($mes > 7 && $mes % 2 == 0)) {
            return 31;
            exit;
        }
        if ($mes != 2) {
            return 30;
            exit;
        }
        if ($ano % 4 == 0) {
            return 29;
            exit;
        }
        return 28;
    }

    public function datas($data, $dias) {
        list($d, $mes, $ano) = explode("/", $data);
        $futuro = $d + $dias;
        while ($futuro > $this->numDias($mes, $ano)) {
            $futuro -= $this->numDias($mes, $ano);
            $mes++;
            if ($mes > 12) {
                $mes = 1;
                $ano++;
            }
        }
        if ($futuro < 10)
            $futuro = '0' . $futuro;
        if ($mes < 10)
            $mes = '0' . $mes;
        return $futuro . '/' . $mes . '/' . $ano;
    }

}

?>
