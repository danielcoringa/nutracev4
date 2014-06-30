<?php

/**
 * Description of Security
 * @category   PublicAnuncios
 * @package    Coringa_Controller
 * @copyright  Copyright (c) 2013-2013 CoringaSistemas INC (http://www.coringasistemas.com.br)
 */
class Alicerce_ExtrasController extends Coringa_Controller_Alicerce_Action {

    public function init() {
        parent::init();
        parent::norenderall();
        $this->_helper->viewRenderer->setNoRender(TRUE);
    }

    public function autocompleteAction() {
        $json = json_encode(array("id" => "1", "label" => "asdf", "value" => "123"));
        echo "[" . $json . "]";
    }

    public function cidadesAction() {
        $params = $this->getRequest()->getParams();
        if ($params['uf']) {
            $db = new Alicerce_Model_DbTable_Cidades();
            $json = json_encode($db->getCidade($params['uf'])->toArray());
        }
        echo "[" . $json . "]";
    }

    public function validaDocAction() {
        $validate = new Coringa_Validate_Helper();
        $params = $this->getRequest()->getParams();
        $valor = $validate->replace($params['num_cnpj_cpf']);
        echo $validate->verifyCnpjCpf($valor);
    }

    public function deletaRegistroAction() {
        $params = $this->getRequest()->getParams();
        $tabela = $params['tablename'];
        $tabela = substr($tabela, 0, -1);
        if ($tabela == 'fornecedore') {
            $tabela = 'fornecedor';
        }
        $campo = "cod_" . strtolower($tabela);
        $tabela = ucwords(str_replace("_", " ", $tabela));

        $tabela = str_replace(" ", "", $tabela);

        $valor = $params['cods'];
        $dbname = "Alicerce_Model_DbTable_" . $tabela;
        $db = new $dbname();
        if (!is_array($valor)) {
            $where = "{$campo}={$valor}";
            $delete = $db->update(array("ind_status" => "I"), $where);
            echo "$.jGrowl('Registro excluído.');";
            echo "oTable = $('#tbgrid').dataTable();";
            echo "$('input[type=checkbox]:checked', oTable.fnGetNodes()).closest('tr').fadeTo(300, 0, function() {";
            echo "oTable.fnDeleteRow(this);";
            echo "});";
        }
        else {
            foreach ($valor as $row) {
                if ($row != '') {
                    $where = "$campo=" . $row;
                    $delete = $db->update(array("ind_status" => "I"), $where);
                    echo "$.jGrowl('Registro excluído.');";
                    echo "oTable = $('#tbgrid').dataTable();";
                    echo "$('input[type=checkbox]:checked', oTable.fnGetNodes()).closest('tr').fadeTo(300, 0, function() {";
                    echo "oTable.fnDeleteRow(this);";
                    echo "});";
                }
            }
        }
        echo "$('.coringa_dialog_confirm').remove();";
    }

    public function deletaRegistroAllAction() {
        $params = $this->getRequest()->getParams();
        $tabela = $params['tablename'];
        $campo = "cod_" . $params['tablename'];
        $valor = $params['cods'];
        $dbname = "Alicerce_Model_DbTable_" . ucfirst($tabela);
        $db = new $dbname();
        if (!is_array($valor)) {
            $where = "$campo=" . $valor;
            $delete = $db->update(array("ind_status" => "I"), $where);
            echo "$.jGrowl('Registro excluído.');";
            echo "oTable = $('#tbgrid').dataTable();";
            echo "$('input[type=checkbox]:checked', oTable.fnGetNodes()).closest('tr').fadeTo(300, 0, function() {";
            echo "oTable.fnDeleteRow(this);";
            echo "});";
        }
        else {
            foreach ($valor as $row) {
                $where = "$campo=" . $row;
                $delete = $db->update(array("ind_status" => "I"), $where);
                echo "$.jGrowl('Registro excluído.');";
                echo "oTable = $('#tbgrid').dataTable();";
                echo "$('input[type=checkbox]:checked', oTable.fnGetNodes()).closest('tr').fadeTo(300, 0, function() {";
                echo "oTable.fnDeleteRow(this);";
                echo "});";
            }
        }
        $campo = "cod_" . $params['tablename'] . "_dup";
        if (!is_array($valor)) {
            $where = "$campo=" . $valor;
            $delete = $db->update(array("ind_status" => "I"), $where);
            echo "$.jGrowl('Registro excluído.');";
            echo "oTable = $('#tbgrid').dataTable();";
            echo "$('input[type=checkbox]:checked', oTable.fnGetNodes()).closest('tr').fadeTo(300, 0, function() {";
            echo "oTable.fnDeleteRow(this);";
            echo "});";
        }
        else {
            foreach ($valor as $row) {
                $where = "$campo=" . $row;
                $delete = $db->update(array("ind_status" => "I"), $where);
                echo "$.jGrowl('Registro excluído.');";
                echo "oTable = $('#tbgrid').dataTable();";
                echo "$('input[type=checkbox]:checked', oTable.fnGetNodes()).closest('tr').fadeTo(300, 0, function() {";
                echo "oTable.fnDeleteRow(this);";
                echo "});";
            }
        }
        echo "$('.coringa_dialog_confirm').remove();";
    }

    public function deletaRegistroManutencaoAction() {
        $params = $this->getRequest()->getPost();
        $valor = $params['cods'];
        $dbe = new Alicerce_Model_DbTable_Equipamento();
        $db = new Alicerce_Model_DbTable_EquipamentoManutencao();
        if (!is_array($valor)) {
            $ant = $db->getEquipamentoManutencao($valor);
            $qea = $ant['qtd_equipamento'];
            $ret = $dbe->getEquipamento($ant['cod_equipamento']);
            $atual = $ret['qtd_estoque_atual'];
            $atual = $atual + $qea;
            $total = $ret['qtd_estoque_efetivo'];
            $ddr['qtd_estoque_atual'] = $atual;
            if ($atual <= $total)
                $dbe->update($ddr, "cod_equipamento=" . $ant['cod_equipamento']);
            $where = "cod_equipamento_manutencao=$valor";
            $delete = $db->update(array("ind_status" => "I"), $where);
            echo "$.jGrowl('Registro excluído.');";
            echo "oTable = $('#tbgrid').dataTable();";
            echo "$('input[type=checkbox]:checked', oTable.fnGetNodes()).closest('tr').fadeTo(300, 0, function() {";
            echo "oTable.fnDeleteRow(this);";
            echo "});";
        } else {
            foreach ($valor as $row) {
                if ($row != '') {
                    $ant = $db->getEquipamentoManutencao($row);
                    $qea = $ant['qtd_equipamento'];
                    $ret = $dbe->getEquipamento($ant['cod_equipamento']);
                    $atual = $ret['qtd_estoque_atual'];
                    $atual = $atual + $qea;
                    $total = $ret['qtd_estoque_efetivo'];
                    $ddr['qtd_estoque_atual'] = $atual;
                    if ($atual <= $total)
                        $dbe->update($ddr, "cod_equipamento=" . $ant['cod_equipamento']);
                    $where = "cod_equipamento_manutencao=$row";
                    $delete = $db->update(array("ind_status" => "I"), $where);
                    echo "$.jGrowl('Registro excluído.');";
                    echo "oTable = $('#tbgrid').dataTable();";
                    echo "$('input[type=checkbox]:checked', oTable.fnGetNodes()).closest('tr').fadeTo(300, 0, function() {";
                    echo "oTable.fnDeleteRow(this);";
                    echo "});";
                }
            }
        }
        echo "$('.coringa_dialog_confirm').remove();";
    }

    public function deletaLocacaoAction() {
        $params = $this->getRequest()->getParams();
        $valor = $params['cods'];
        if (!is_array($valor)) {
            $valor = array($valor);
        }
        $db = new Alicerce_Model_DbTable_Locacao();
        $select = $db->select();
        foreach ($valor as $row) { // Varre array de codigos
            if ($row != '') {
                $select->where("cod_locacao=?", $row); // monta select no resultado do array
                $result = $db->fetchRow($select); // Pega os dados do banco
                $dbel = new Alicerce_Model_DbTable_EquipamentoLocacao(); // Chama a tabela de equipamentos locados
                $selel = $dbel->select();
                $dbe = new Alicerce_Model_DbTable_Equipamento(); // Chama a tabela de equipamentos
                if (count($result) > 0) { // Se tem algum resultado no banco de dados.
                    $selel->where("cod_locacao=?", $row); // Seleciona o codigo de locacao no equipamento locado
                    $resultel = $dbel->fetchAll($selel); // Pega os resultados do equipamento locado
                    if (count($resultel) > 0) { // Verifica se teve resultados
                        foreach ($resultel as $rowel) { // Varre a tabela
                            $qtdequip = $rowel['qtd_equipamento']; // Atribui a quantidade de equipamentos achado
                            $sele = $dbe->select();
                            $sele->where("cod_equipamento=?", $rowel['cod_equipamento']);
                            $rese = $dbe->fetchRow($sele); // Seleciona o primeiro equipamento
                            if ($rese) {
                                $qtd_atual = $rese['qtd_estoque_atual'];
                                $qtd_new = $qtdequip + $qtd_atual;
                                $dados_equip['qtd_estoque_atual'] = $qtd_new;
                                $dbe->update($dados_equip, "cod_equipamento=" . $rese['cod_equipamento']);
                                echo "$.jGrowl('Estoque Alterado.');";
                            }
                            $delete = $dbel->update(array("ind_status" => "I"), "cod_equipamento_locacao=" . $rowel['cod_equipamento_locacao']); // Exclui o registro da tabela de equipamento locado
                            echo "$.jGrowl('Equipamento Locado excluído.');";
                        }
                    }
                    $delete = $db->update(array("ind_status" => "I"), "cod_locacao=" . $row);
                    echo "$.jGrowl('Locação excluída.');";
                }
                echo "oTable = $('#tbgrid').dataTable();";
                echo "$('input[type=checkbox]:checked', oTable.fnGetNodes()).closest('tr').fadeTo(300, 0, function() {";
                echo "oTable.fnDeleteRow(this);";
                echo "});";
            }
        }
        echo "$('.coringa_dialog_confirm').remove();";
    }

    public function deletaEquipAction() {
        $params = $this->getRequest()->getParams();
        $valor = $params['cods'];
        $db = new Alicerce_Model_DbTable_EquipamentoLocacao();
        $sel = $db->select();
        if (!is_array($valor)) {
            $valor = array($valor);
        }
        else {
            foreach ($valor as $val) {
                $sel->where("cod_equipamento_locacao=?", $val);
                $return = $db->fetchRow($sel);
                if (count($return) > 0) {
                    $dbe = new Alicerce_Model_DbTable_Equipamento();
                    $sele = $dbe->select();
                    $sele->where("cod_equipamento=?", $return['cod_equipamento']);
                    $rete = $dbe->fetchRow($sele);
                    $qtd_atual = $rete['qtd_estoque_atual'];
                    $qtd_devolvida = $return['qtd_equipamento'] + $qtd_atual;
                    $cod_equip = $rete['cod_equipamento'];
                    $dados_equip['qtd_estoque_atual'] = $qtd_devolvida;
                    $dbe->update($dados_equip, 'cod_equipamento=' . $cod_equip);
                    $db->update(array("ind_status" => "I"), "cod_equipamento_locacao=" . $val);
                }
                echo "$.jGrowl('Registro excluído.');";
                echo "oTable = $('#tbgrid').dataTable();";
                echo "$('input[type=checkbox]:checked', oTable.fnGetNodes()).closest('tr').fadeTo(300, 0, function() {";
                echo "oTable.fnDeleteRow(this);";
                echo '$(".coringa_dialog_confirm").remove();';
                echo "});";
                echo "setTimeout(function(){calcula_valor();},1000);";
            }
        }
    }

    /**
     * Retorna a quantidade de equipamentos duplicados
     * @param int $cod
     * @return int
     */
    private function showQtdEquipamento($cod) {
        $db = new Alicerce_Model_DbTable_Equipamento();
        $sel = $db->select();
        $sel->where('cod_equipamento_dup=?', $cod);
        $result = count($db->fetchAll($sel)) + 1;
        return str_pad($result, 2, '0', STR_PAD_LEFT);
    }

    public function showEquipamentosAction() {
        $dbc = new Alicerce_Model_DbTable_Categoria();
        $this->view->categorias = $dbc->getCategoriaSelect();
        $this->render('show-equipamentos');
    }

    public function autocompleteEquipamentoAction() {
        $params = $this->getRequest()->getParams();
        $db = new Alicerce_Model_DbTable_Categoria();
        $sel = $db->select();
        $sel->where('nom_categoria LIKE ?', '%' . $params['term'] . '%');
        $result = $db->fetchAll($sel);
        $data = array();
        $x = 0;
        foreach ($result as $row) {
            $dbe = new Alicerce_Model_DbTable_Equipamento();
            $sele = $dbe->select();
            $sele->where("cod_categoria=?", $row['cod_categoria']);
            $sele->where("ind_status='A'");
            $retorno = $dbe->fetchAll($sele);
            if (count($retorno) > 0) {
                $data[$x]['id'] = $row['cod_categoria'];
                $data[$x]['label'] = $row['nom_categoria'];
                $data[$x]['value'] = $row['nom_categoria'];
                $data[$x]['disponivel'] = count($retorno);
                $data[$x]['valor'] = str_replace('.', ', ', $retorno[0]['vlr_locacao']);
                $x++;
            }
        }
        echo json_encode($data);
    }

    public function clienteDataAction() {
        $params = $this->getRequest()->getParams();
        $db = new Alicerce_Model_DbTable_Cliente();
        $select = $db->select();
        $select->where("cod_cliente=?", $params['valor']);
        $retorno = $db->fetchRow($select)->toArray();
        echo json_encode($retorno);
    }

    public function clienteObraAction() {
        $params = $this->getRequest()->getParams();
        $db = new Alicerce_Model_DbTable_Obra();
        $select = $db->select();
        $select->where("cod_cliente=?", $params['valor']);
        $retorno = $db->fetchAll($select)->toArray();
        echo json_encode($retorno);
    }

    public function clienteResponsavelAction() {
        $params = $this->getRequest()->getParams();
        $db = new Alicerce_Model_DbTable_Cliente();
        $select = $db->select();
        $select->where("cod_co_responsabilidade=?", $params['valor']);
        $retorno = $db->fetchAll($select)->toArray();
        echo json_encode($retorno);
    }

    public function removeImagensAction() {
        $params = $this->getRequest()->getParams();
        $arq_s = explode('o_', $params['imagem']);
        $arq_s = $arq_s[1];
        $fp = dir(BASIC_FOLDER . '/media/');
        while ($arquivo = $fp->read()) {
            $arq_v = md5($arquivo);
            //echo $arq_v;
            if ($arq_v == $arq_s) {
                unlink(BASIC_FOLDER . '/media/' . $arquivo);
                $arq_arr = explode(".", $arquivo);
                $arq_name = BASIC_FOLDER . '/media/' . $arq_arr[0];
                $arq_ext = $arq_arr[1];
                unlink($arq_name . '_medium.' . $arq_ext);
                unlink($arq_name . '_big.' . $arq_ext);
                unlink($arq_name . '_list.' . $arq_ext);
                unlink($arq_name . '_thumb.' . $arq_ext);
                $db = new Alicerce_Model_DbTable_Imagem();
                $remove = $db->deletar($arquivo);
                echo "console.log('$remove');";
                echo "jQuery('#o_$arq_s').remove();";
                echo "uploader.disableBrowse(false);";
                exit;
            }
        }
        $fp->close();
    }

    public function minifyCssAction() {
        header("Content-type: text/css");
        $css = array(
            '/css/admin/grid.css',
            '/css/admin/layout.css',
            '/css/admin/external/jquery-ui-1.8.21.custom.css',
            '/css/admin/redmond/jquery.ui.theme.css',
            '/css/admin/style.css',
            '/css/admin/elements.css',
            '/css/admin/shCore.css',
            '/css/admin/print-invoice.css',
            '/css/admin/typographics.css',
            '/css/admin/media-queries.css',
            '/css/admin/ie-fixes.css',
            '/css/admin/forms.css',
            '/css/admin/external/jquery.chosen.css',
            '/css/admin/external/jquery.jgrowl.css',
            '/css/admin/external/syntaxhighlighter/shCore.css',
            '/css/admin/external/syntaxhighlighter/shThemeDefault.css',
            '/css/admin/icons-pack.css',
            '/css/admin/fonts/font-awesome.css',
            '/css/error/nstyle.css'
        );
        $css2 = array('/css/admin/style.css');
        foreach ($css as $file_css) {
            $folder = BASIC_FOLDER;
            $data.= file_get_contents($folder . $file_css);
        }
        $teste = new Coringa_Css_Minify();
        $teste->minify($data);
        echo $teste->getMinified();
        //echo $data;
    }

    public function equipamentosCategoriaJsonAction() {
        $params = $this->getRequest()->getParams();
        if ($params['id']) {
            $db = new Alicerce_Model_DbTable_Equipamento();
            $select = $db->select();
            $select->where("cod_categoria=?", $params['id']);
            $select->where("ind_status=?", "A");
            $result = $db->fetchAll($select)->toArray();
            echo json_encode($result);
        }
    }

    public function categoriaFornecedorJsonAction() {
        $params = $this->getRequest()->getParams();
        $db = new Alicerce_Model_DbTable_Fornecedor();
        $result = $db->getDadosCategoria($params['id']);
        echo json_encode($result);
    }

    public function equipamentosDadosAction() {
        $params = $this->getRequest()->getParams();
        $db = new Alicerce_Model_DbTable_Equipamento();
        $ret = $db->getEquipamento($params['cod_equipamento'])->toArray();
        echo json_encode($ret);
    }

    public function devolveLocacaoAction() {
        $params = $this->getRequest()->getParams();
        $db = new Alicerce_Model_DbTable_EquipamentoLocacao();
        $sel = $db->select();
        $sel->where("cod_equipamento_locacao=?", $params['cods']);
        $sel->where("ind_status=?", "A");
        $row = $db->fetchRow($sel);
        $dbe = new Alicerce_Model_DbTable_Equipamento();
        $sele = $dbe->select();
        $sele->where("cod_equipamento=?", $row['cod_equipamento']);
        $rete = $dbe->fetchRow($sele);
        //$row['qtd_equipamento'];
        $qtd_atual = $rete['qtd_estoque_atual'];
        $qtd_devolver = $params['qtdregistro'] + $qtd_atual;
        $dados['qtd_estoque_atual'] = $qtd_devolver;
        if ($qtd_atual <= $rete['qtd_estoque_efetivo']) {
            $dbe->update($dados, 'cod_equipamento=' . $rete['cod_equipamento']);
        }
        else {
            $dados['qtd_estoque_atual'] = $rete['qtd_estoque_efetivo'];
            $dbe->update($dados, 'cod_equipamento=' . $rete['cod_equipamento']);
        }
        $qtdequip = $row['qtd_equipamento'];
        if ($qtdequip > $params['qtdregistro']) {
            $dados_equip_ins = $row;
            $cel = $dados_equip_ins['cod_equipamento_locacao'];
            $dados_equip_ins['cod_equipamento_locacao'] = '';
            $count = $qtdequip - $params['qtdregistro'];
            if ($count > 0) {
                $dados_equip_ins['qtd_equipamento'] = $count;
                $db->insert($dados_equip_ins->toArray());
            }
            echo "$.jGrowl('Equipamentos devolvidos com sucesso.');";
            echo "oTable = $('#tbgrid').dataTable();";
            echo "$('input[type=checkbox]:checked', oTable.fnGetNodes()).closest('tr').find('td').eq(1).html('" . $count . "');";
            echo '$(".coringa_dialog_confirm").remove();});';
        }
        else {
            echo "$.jGrowl('Equipamentos devolvidos com sucesso.');";
            echo "oTable = $('#tbgrid').dataTable();";
            echo "$('input[type=checkbox]:checked', oTable.fnGetNodes()).closest('tr').fadeTo(300, 0, function() {";
            echo "oTable.fnDeleteRow(this);";
            echo '$(".coringa_dialog_confirm").remove();});';
        }
        $db->update(array("ind_status" => "C", "dta_devolucao" => Date("Y-m-d h:i:s"), "qtd_equipamento" => $params['qtdregistro']), "cod_equipamento_locacao=" . $params['cods']);
    }

    public function qtdeEquipDevAction() {
        $params = $this->getRequest()->getParams();
        $dbel = new Alicerce_Model_DbTable_EquipamentoLocacao();
        $selel = $dbel->select();
        $selel->where("cod_equipamento_locacao=?", $params['cod_equip_locacao']);
        $return = $dbel->fetchRow($selel);
        $this->view->data = $return->toArray();
        $this->render("qtde-equip");
    }

    public function makeIconAction() {
        header("Content-type: image/png");
        $folder = BASIC_FOLDER . "/img/alicerce/icons/packs/fugue/icons-shadowless/";
        $files = dir($folder);
        $i = array();
        while ($arquivo = $files->read()) {
            if ($arquivo !== '.' && $arquivo !== '..')
                $i[] = $folder . $arquivo;
        }
        sort($i);
        $imgBuf = array();
        $maxW = 0;
        $maxH = 0;
        foreach ($i as $link) {
            $iTmp = imagecreatefrompng($link);
            $maxH += imagesy($iTmp);
            $maxW = (imagesx($iTmp) > $maxW) ? imagesx($iTmp) : $maxW;
            array_push($imgBuf, $iTmp);
        }

        $iOut = imagecreatetruecolor(1600, 560);
        imagealphablending($iOut, false);
        imagesavealpha($iOut, true);
        $posx = 0;
        $posy = 0;
        foreach ($imgBuf as $img) {
            $original_transparency = imagecolortransparent($img);
            //   $rgb = imagecolorsforindex($img, $original_transparency);
            //   $original_transparency = ($rgb['red'] << 16) | ($rgb['green'] << 8) | $rgb['blue'];
            //change the transparent color to black, since transparent goes to black anyways (no way to remove transparency in GIF)
            //fill the background with white
            //  imagefill($iOut, 0, 0, $trans);
            // for each color in the original png
            if ($posx < 1600) {
                imagecopy($iOut, $img, $posx, $posy, 0, 0, imagesy($img), imagesx($img));
                imagecolortransparent($iOut, imagecolorallocate($img, 100, 100, 100));
                $posx+=imagesx($img);
                imagedestroy($img);
            }
            else {
                $posy+=imagesy($img);
                $posx = 0;
                imagecopy($iOut, $img, $posx, $posy, 0, 0, imagesy($img), imagesx($img));
                imagecolortransparent($iOut, imagecolorallocate($img, 100, 100, 100));
                $posx+=imagesx($img);
                imagedestroy($img);
            }
        }
        imagepng($iOut) or die("Erro ao criar imagem");
    }

    public function getIconCssAction() {
        $folder = BASIC_FOLDER . "/img/alicerce/icons/packs/fugue/icons-shadowless/";
        $files = dir($folder);
        $i = array();
        while ($arquivo = $files->read()) {
            if ($arquivo !== '.' && $arquivo !== '..')
                $i[] = $folder . $arquivo;
        }
        sort($i);
        $posX = 0;
        $posY = 0;
        echo '<style>';
        echo '.icons_row{background-image:url("/img/alicerce/icons/make-icon.png"); width:16px; height:16px; overflow:hidden;border:1px solid #ccc; display:block;float:left; margin:2px;}' . PHP_EOL;
        foreach ($i as $row) {
            if ($posX < 1600) {

                $nstyle = '.' . substr(str_replace($folder, '', $row), 0, -4);
                echo $nstyle . '{';
                echo 'background-position:-' . $posX . 'px -' . $posY . 'px;';
                echo '}' . PHP_EOL;
                $posX += 16;
            }
            else {
                $posY+=16;
                $posX = 0;
                $nstyle = '.' . substr(str_replace($folder, '', $row), 0, -4);
                echo $nstyle . '{';
                echo 'background-position:-' . $posX . 'px -' . $posY . 'px;';
                echo '}' . PHP_EOL;
                $posX += 16;
            }
        }
        echo "</style>";
        foreach ($i as $row) {
            $nstyle = substr(str_replace($folder, '', $row), 0, -4);
            echo '<div class="icons_row ' . $nstyle . '" title="' . $nstyle . '"></div>';
        }
    }

    public function notificacoesAction() {
        $dbl = new Alicerce_Model_DbTable_Locacao();
        $sell = $dbl->select();
        $sell->where("ind_status=?", "A");
        $sell->where("dta_devolucao< NOW()");
        $retl = $dbl->fetchAll($sell)->toArray();
        if (count($retl) > 0)
            $dados["contratos"] = $retl;
        $this->view->data = $dados;
        $this->render("notificacoes");
    }

    public function agendaAction() {
        $params = $this->getRequest()->getParams();
        $dbl = new Alicerce_Model_DbTable_Locacao();
        $pedido = $dbl->getAgenda();
        $x = 0;
        if ($params['m'] == 'notification')
            foreach ($pedido as $rp) {
                $agenda[$x]['id'] = 'nochange';
                $agenda[$x]['title'] = 'Renovação de Pedido nº' . $rp['cod_locacao'];
                list($dt, $hr) = explode(" ", $rp['dta_devolucao']);
                $agenda[$x]['start'] = $dt . ' 08:00';
                $agenda[$x]['end'] = $dt . ' 08:30';
                $agenda[$x]['allDay'] = false;
                $agenda[$x]['editable'] = false;
                $agenda[$x]['className'] = 'alert warning';
                $x++;
            }
        $dba = new Alicerce_Model_DbTable_Agenda();
        $agenda_row = $dba->getAgenda();
        foreach ($agenda_row as $ra) {
            $agenda[$x]['id'] = $ra['cod_agenda'];
            $agenda[$x]['title'] = $ra['des_titulo'];
            $agenda[$x]['start'] = $ra['dta_inicio'];
            $agenda[$x]['end'] = $ra['dta_termino'];
            $dataInicio = new DateTime($ra['dta_termino']);
            $dataFim = new DateTime($ra['dta_inicio']);
            //Retorna a diferença entre dois objetos DateTime, no caso um objeto DataInterval
            $intervalo = $dataInicio->diff($dataFim);
            if ($ra['all_day'] < 1) {
                $agenda[$x]['allDay'] = false;
                $agenda[$x]['className'] = 'alert note';
            }
            else {
                $agenda[$x]['className'] = 'alert error';
            }
            $agenda[$x]['editable'] = $ra['ind_editable'] == 1 ? true : false;
            //$agenda[$x]['className'] = 'alert';
            $x++;
        }
        echo json_encode($agenda);
    }

    public function addAgendaAction() {
        parent::forms();
        $params = $this->getRequest()->getParams();
        if ($params['dados']['id'] != 'nochange' && $params['dados']['id'] != '') {
            $db = new Alicerce_Model_DbTable_Agenda();
            $this->view->data = $db->getEvento($params['dados']['id']);
        }
        list($d1, $h1) = explode(" ", $params['dataIni']);
        $h1 = substr($h1, 0, -3);
        if ($h1 > 0) {
            $this->view->dataIni = $d1 . ' ' . $h1;
            $this->view->dataFim = $d1 . ' ' . ($h1 + 1) . ':00';
        }
        else {
            $this->view->dataIni = $d1 . ' 08:00';
            $this->view->dataFim = $d1 . ' 09:00';
        }
        $this->render("add-agenda");
    }

    public function gravarEventoAgendaAction() {
        $db = new Alicerce_Model_DbTable_Agenda();
        $dados = $this->getRequest()->getPost();
        $dti = $dados['dta_inicio'];
        $dtf = $dados['dta_termino'];
        list($dh1, $dt1) = explode(" ", $dti);
        list($dh2, $dt2) = explode(" ", $dtf);
        list($d1, $m1, $a1) = explode("/", $dh1);
        list($d2, $m2, $a2) = explode("/", $dh2);
        unset($dados['dta_inicio']);
        unset($dados['dta_termino']);
        $dados['dta_inicio'] = $a1 . '-' . $m1 . '-' . $d1 . ' ' . $dt1;
        $dados['dta_termino'] = $a2 . '-' . $m2 . '-' . $d2 . ' ' . $dt2;
        if ($dados['cod_agenda'] > 0) {
            $update = $db->update($dados, "cod_agenda=" . $dados['cod_agenda']);
        }
        else {
            $insert = $db->insert($dados);
        }
        if ($insert > 0) {

        }
    }

    public function deletaEventoAgendaAction() {
        $params = $this->getRequest()->getParams();
        if ($params['dados']['id'] != '' && $params['dados']['id'] != 'nochange') {
            $db = new Alicerce_Model_DbTable_Agenda();
            $delete = $db->delete("cod_agenda=" . $params['dados']['id']);
            echo $delete;
        }
    }

    public function moveEventoAgendaAction() {
        $params = $this->getRequest()->getParams();
        $dti = $params['dtastart'];
        $dtf = $params['dtaend'];
        list($dh1, $dt1) = explode(" ", $dti);
        list($dh2, $dt2) = explode(" ", $dtf);
        list($d1, $m1, $a1) = explode("/", $dh1);
        list($d2, $m2, $a2) = explode("/", $dh2);
        $db = new Alicerce_Model_DbTable_Agenda();
        $cod = $params['codagenda'];
        $dados['dta_inicio'] = $a1 . '-' . $m1 . '-' . $d1 . ' ' . $dt1;
        $dados['dta_termino'] = $a2 . '-' . $m2 . '-' . $d2 . ' ' . $dt2;
        $update = $db->update($dados, "cod_agenda=" . $cod);
        echo $update;
    }

    public function showConfigAction() {
        print_r($this->config['termo_contrato']);
    }

    public function manutencaoBackAction() {
        $db = new Alicerce_Model_DbTable_EquipamentoManutencao();
        $job_manutencao = $db->getEquipamentoManutencaoAuto();
        if (count($job_manutencao) > 0) {
            foreach ($job_manutencao as $row) {
                $dbe = new Alicerce_Model_DbTable_Equipamento();
                $ret = $dbe->getEquipamento($row['cod_equipamento']);
                $atual = $ret['qtd_estoque_atual'];
                $ddr['qtd_estoque_atual'] = ($row['qtd_equipamento'] + $atual);
                if ($row['cod_equipamento_manutencao'] > 0) {
                    $dd['ind_status'] = 'I';
                    $db->update($dd, "cod_equipamento_manutencao={$row['cod_equipamento_manutencao']}");
                    $dbe->update($ddr, "cod_equipamento=" . $row['cod_equipamento']);
                    echo "$.jGrowl('Retorno de Equipamento em Manutenção Efetivado');";
                    echo '$(".coringa_dialog_confirm").remove();';
                }
            }
        }
    }

    public function jobsAction() {
        $db = new Alicerce_Model_DbTable_EquipamentoManutencao();
        $job_manutencao = $db->getEquipamentoManutencaoAuto();
        if (count($job_manutencao) > 0) {
            foreach ($job_manutencao as $row) {
                echo "coringa_alert.manutencao('" . $row['nom_equipamento'] . "','{$row['cod_equipamento_manutencao']}');";
            }
        }
        $config = $this->config;

        if ($config['backup_automatico'] == 'S') {
            if ($this->returnDias($config['backup_last'], date("Y-m-d h:i:s")) >= $config['backup_dias']) {
                echo '$.ajax({
                url: "/extras/backup-db",
                type: "get",
                success: function(data) {
                    eval(data);
                },
                error: function() {
                    alert("Erro ao gerar o Backup");
                }
            });';
            }
        }
    }

    public function manutencaoAdiarAction() {
        $cod = $this->getRequest()->getParam("cod");
        $db = new Alicerce_Model_DbTable_EquipamentoManutencao();
        $this->view->data = $db->getEquipamentoManutencao($cod);
        $this->render('manutencao/adiar');
    }

    public function deletarEquipListAction() {
        $dados = $this->getRequest()->getPost();
        if (count($dados) > 0) {
            $dbl = new Alicerce_Model_DbTable_Locacao();
            $dbe = new Alicerce_Model_DbTable_Equipamento;
            $dbel = new Alicerce_Model_DbTable_EquipamentoLocacao();
            if ($dados['cod_locacao'] > 0) {
                //Pegar equipamentos selecionados
                if (is_array($dados['dados'])) {
                    foreach ($dados['dados'] as $row) {
                        $els = $dbel->getEquipamentoLocacao($row);
                        $equip = $dbe->getEquipamento($els['cod_equipamento']);
                        $total = $equip['qtd_estoque_efetivo'];
                        $estoque = $els['qtd_equipamento'] + $equip['qtd_estoque_atual'];
                        if ($estoque <= $total) {
                            $dbe->update(array("qtd_estoque_atual" => $estoque), "cod_equipamento=" . $els['cod_equipamento']);
                        }
                        $dbel->delete("cod_equipamento_locacao=" . $row);
                        echo "$.jGrowl('Registro excluído.');";
                        echo "oTable = $('#tbgrid').dataTable();";
                        echo "$('input[type=checkbox]:checked', oTable.fnGetNodes()).closest('tr').fadeTo(300, 0, function() {";
                        echo "oTable.fnDeleteRow(this);";
                        echo '$(".coringa_dialog_confirm").remove();';
                        echo "});";
                        echo "setTimeout(function(){calcula_valor();},1000);";
                    }
                }
            }
            else {
                echo "$.jGrowl('Registro excluído.');";
                echo "oTable = $('#tbgrid').dataTable();";
                echo "$('input[type=checkbox]:checked', oTable.fnGetNodes()).closest('tr').fadeTo(300, 0, function() {";
                echo "oTable.fnDeleteRow(this);";
                echo '$(".coringa_dialog_confirm").remove();';
                echo "});";
                echo "setTimeout(function(){calcula_valor();},1000);";
            }
        }
    }

    public function deletarLocacaoAction() {
        $dados = $this->getRequest()->getPost();
        if (count($dados) > 0) {
            $dbl = new Alicerce_Model_DbTable_Locacao();
            $dbe = new Alicerce_Model_DbTable_Equipamento;
            $dbel = new Alicerce_Model_DbTable_EquipamentoLocacao();

            //Pegar equipamentos selecionados
            if (is_array($dados['dados'])) {
                foreach ($dados['dados'] as $row) {
                    $locacao = $dbl->getLocacao($row);
                    $els = $dbel->getEquipamentoPorLocacao($row);

                    //Varre os equipamentos locados fazendo a devolução
                    foreach ($els as $rowe) {

                        $equip = $dbe->getEquipamento($rowe['cod_equipamento']);
                        $total = $equip['qtd_estoque_efetivo'];
                        $estoque = $rowe['qtd_equipamento'] + $equip['qtd_estoque_atual'];
                        //Se o estoque for menor ou igual ao numero de itens Atualiza
                        if ($estoque <= $total) {
                            $dbe->update(array("qtd_estoque_atual" => $estoque), "cod_equipamento=" . $rowe['cod_equipamento']);
                        }
                        //Exclui os equipamentos da lista de locacao
                        $dbel->delete("cod_equipamento_locacao=" . $rowe['cod_equipamento_locacao']);
                    }
                    $dbl->delete("cod_locacao=" . $row);
                    echo "$.jGrowl('Registro excluído.');";
                    echo "oTable = $('#tbgrid').dataTable();";
                    echo "$('input[type=checkbox]:checked', oTable.fnGetNodes()).closest('tr').fadeTo(300, 0, function() {";
                    echo "oTable.fnDeleteRow(this);";
                    echo '$(".coringa_dialog_confirm").remove();';
                    echo "});";
                    echo "setTimeout(function(){calcula_valor();},1000);";
                }
            }
        }
    }

    public function backupDbAction() {
        $config = $this->config;

        $db = new Alicerce_Model_DbTable_Configuracao();
        $link = mysql_pconnect("localhost", "rodrigod_alicerc", "Str0ng@123");
        mysql_select_db('rodrigod_alicerce', $link);
        $tables = array();
        $result = mysql_query("SHOW TABLES");
        while ($row = mysql_fetch_row($result)) {
            $tables[] = $row[0];
        }
        foreach ($tables as $table) {
            $result = mysql_query("SELECT * FROM " . $table);
            $num_fields = mysql_num_fields($result);
            //  $return .= 'DROP TABLE ' . $table . ';';
            $row2 = mysql_fetch_row(mysql_query("SHOW CREATE TABLE " . $table));
            $return .= PHP_EOL . PHP_EOL . $row2[1] . ';' . PHP_EOL . PHP_EOL;
            for ($i = 0; $i < $num_fields; $i++) {
                while ($row = mysql_fetch_row($result)) {
                    $return .= 'INSERT INTO ' . $table . ' VALUES (';
                    for ($j = 0; $j < $num_fields; $j++) {
                        $row[$j] = addslashes($row[$j]);

                        if (strlen($row[$j]) > 0) {
                            $return .= '"' . $row[$j] . '"';
                        }
                        else {
                            $return .= 'NULL';
                        }
                        if ($j < ($num_fields - 1)) {
                            $return .= ',';
                        }
                    }
                    $return.=');' . PHP_EOL;
                }
            }
            $return .=PHP_EOL . PHP_EOL . PHP_EOL;
        }
        $folder = str_replace("index.php", "backup", $_SERVER['SCRIPT_FILENAME']);
        $filename = '/backup_' . date('d_m_Y') . '.sql';
        $handle = fopen($folder . $filename, 'w+');
        fwrite($handle, $return);
        fclose($handle);
        $db->update(array("backup_last" => date("Y-m-d h:i:s")), "cod_configuracao=1");
        echo "var dwn = window.open('/extras/backup-save/file{$filename}','download','width=1,height=1');setTimeout(function(){dwn.close()},500);";
        echo "$.jGrowl('Backup Realizado com Sucesso!');";
    }

    public function backupSaveAction() {
        $params = $this->getRequest()->getParams();

//        header("Content-Type: application/force-download");
//        header("Content-Disposition: attachment; filename=\"{$filename}\"");
        $folder = str_replace("index.php", "backup/", $_SERVER['SCRIPT_FILENAME']);
        $filename = $folder . $params['file'];
        header('Content-Description: File Transfer');
        header('Content-Type: application/octet-stream');
        header('Content-Disposition: attachment; filename=' . basename($filename));
        header('Content-Transfer-Encoding: binary');
        header('Expires: 0');
        header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
        header('Pragma: public');
        header('Content-Length: ' . filesize($filename));
        ob_clean();
        flush();
        readfile($filename);
        exit;
    }

    private function returnDias($data1, $data2) {
//Instancia a classe, atribuindo a data inicial
        list($d1, $h1) = explode(' ', $data1);
        list($d2, $h2) = explode(' ', $data2);
        $dataInicio = new DateTime($d1);
        $dataFim = new DateTime($d2);
//Retorna a diferença entre dois objetos DateTime, no caso um objeto DataInterval
        $intervalo = $dataInicio->diff($dataFim);
//Agora formatamos a data em dias
        if ($intervalo->format('%d') == 0 && $intervalo->format('%m') > 0) {
            return '30';
        }
        else {
            return $intervalo->format('%d');
        }
    }

    public function refreshWidgetAction() {
        $db = new Alicerce_Model_DbTable_Widget();
        $params = $this->getRequest()->getPost();
        $x = 0;
        foreach ($params['item'] as $item) {
            $result = $db->update(array("num_ordem" => $x), "cod_widget=" . $item);
            $x++;
        }
    }

}

?>
