<?php

/**
 * Description of Security
 * @category   PublicAnuncios
 * @package    Coringa_Controller
 * @copyright  Copyright (c) 2013-2013 CoringaSistemas INC (http://www.coringasistemas.com.br)
 */
class Alicerce_Model_DbTable_Imagem extends Coringa_Db_Table_Alicerce {

    protected $_name = 'tab_web_imagem';
    protected $_primary = 'cod_imagem';

    public function gridList($status) {
        $select = $this->select();
        $select->where('ind_status=?', $status);
        return $this->fetchAll($select);
    }

    public function getImagens($cod) {
        $select = $this->select();
        $select->where('cod_equipamento=?', $cod);
        $return = $this->fetchAll($select)->toArray();
        $x = 0;
        foreach ($return as $row) {
            $val = $row['link_imagem'];
            $imagem = str_replace(BASIC_FOLDER . '/media/', "", $val);
            $img_arr = explode(".", $imagem);
            $img_name = $img_arr[0];
            $img_ext = $img_arr[1];
            $thumb = '/media/' . $img_name . '_medium.' . $img_ext;
            $dados[$x]['real'] = $img_name . '.' . $img_ext;
            $dados[$x]['thumb'] = $thumb;
            $x++;
        }
        return $dados;
    }

    public function getImagemSelect() {
        $select = $this->select();
        $select->where('ind_status=?', 'A');
        return $this->fetchAll($select);
    }

    public function deletar($nom_imagem) {

        //$nom_imagem = BASIC_FOLDER . '/media/' . $nom_imagem;
        $where = "link_imagem LIKE '" . $nom_imagem . "'";
        $ret = $this->fetchRow($where);

        return $this->delete($where);
    }

}

?>
