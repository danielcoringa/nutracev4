<?php

class Coringa_Db_Table_Alicerce extends Zend_Db_Table_Abstract {
    /*
     * To change this template, choose Tools | Templates
     * and open the template in the editor.
     */

    public function dateen($d) {
        list ($d, $m, $y) = explode('/', $d);
        return "$y-$m-$d";
    }

}

?>
