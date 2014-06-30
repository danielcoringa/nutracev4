<?php

class Admin_Model_Grid {

    public function truncate($string, $size) {
        $trunc = new Admin_Model_Truncate();
        $trunc->truncate(strip_tags($string), $size);
        return $trunc->render();
    }

    public function ativo($mode) {
        $array = array("A" => "<i class='fa fa-check-circle-o'></i> Ativo", "I" => "Inativo", "E" => "Excluído");
        return $array[$mode];
    }

    public function getCategoria($cod) {
        $db = new Admin_Model_DbTable_CategoriaArtigo();
        $dbc = new Admin_Model_DbTable_Categoria();
        $result = $db->getDados($cod);
        foreach ($result as $row) {
            $result2 = $dbc->getDados($row['cod_categoria']);
            $cats[] = $result2['nom_categoria'];
        }
        return implode(',', $cats);
    }

    public function getTipoArtigo($mode) {
        switch ($mode) {
            case 'image':
                $retorno = 'Imagem e Texto';
                break;
            case 'gallery':
                $retorno = 'Galeria de Fotos';
                break;
            case 'audio':
                $retorno = 'Audio/Música';
                break;
            case 'video':
                $retorno = 'Artigo de Vídeo';
                break;
            default:
                $retorno = 'Artigo Padrão';
                break;
        }
        return $retorno;
    }

    public function datahora($var) {
        if ($var == '0000-00-00 00:00:00') {
            return "Registro ainda não foi alterado.";
        }
        else {
            $data = explode(" ", $var);
            $d = explode("-", $data[0]);
            $hora = $data[1];
            $data = $d[2] . '/' . $d[1] . '/' . $d[0];
            return $data . ' ' . (substr($hora, 0, -3));
        }
    }

}
