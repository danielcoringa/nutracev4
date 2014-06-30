<?php

class Coringa_Db_Table_TvLojista extends Zend_Db_Table_Abstract {
    /*
     * To change this template, choose Tools | Templates
     * and open the template in the editor.
     */

    public function __construct($config = array()) {

        $this->_setAdapter(Zend_Registry::get('coringa_tvlojista'));
        $this->setDefaultAdapter(Zend_Registry::get('coringa_tvlojista'));
        parent::__construct($config);
        $params = array ('host'     => '127.0.0.1',
                 'username' => 'tvlojist_root',
                 'password' => 'mysql123',
                 'dbname'   => 'tvlojist_db');
        $db = Zend_Db::factory('PDO_MYSQL',$params);
        $cod_user = $_SESSION['auth']['user_id'];
        if($cod_user==''){$cod_user=0;}
        $columnMapping = array('ind_level' => 'priority', 'des_mensagem' => 'message', 'cod_usuario'=>'cod_usuario', 'trace'=>'trace');
        $writer = new Zend_Log_Writer_Db($db, 'tab_web_log', $columnMapping);
        $logger = new Zend_Log($writer);
        $logger->setEventItem('cod_usuario', $cod_user);
        $this->log = $logger;
    }

    public function init() {


        

        $this->removidos = array();
        $this->campos_centralizados = array('ind_status');
//        $this->_setAdapter(Zend_Registry::get('coringa_tvlojista'));
//        $this->setDefaultAdapter(Zend_Registry::get('coringa_tvlojista'));
    }

    /*
     * Function getConn()
     * Função para pegar o adaptador do Banco de Dados
     */

    public function getConn() {
        return Zend_Db_Table_Abstract::getDefaultAdapter();
    }

    /*
     * Function criarTabela
     * @param $campos array - Campos a serem removidos da tabela
     * @return $string - Tabela formatada para visualização
     */

    public function criarTabela($tools = 'basic') {
        //Pega o nome das colunas
        $order = $this->order;
        $cols = $order;
        if (count($this->table) > 0) {
            foreach ($this->table as $row) {
                $colst = array();

                foreach ($row as $value => $key) {

                    //Verifica se o nome não foi removido
                    $this->removidos = $this->removidos != '' ? $this->removidos : array();
                    if (!in_array($value, $this->removidos)) {

                        $colst[] = $value;
                    }
                }
                if ($this->adicionados) {
                    foreach ($this->adicionados as $val) {

                        $colst[] = $val;
                    }
                }
                foreach ($colst as $value)
                    if (!in_array($value, $order)) {
                        $cols[] = $value;
                    }
            }
        }

        // Monta os botões da ferramenta superior
        $data = $this->tools($tools);
        $data.= '<table class="dynamic styled" data-show-Filter-Bar="true" data-table-tools=\'{"display":true}\' id="tbgrid">';
        $data.= '    <thead>';
        $data.= '<th style="width:1%"><div class="check-all"><input type="checkbox" class="check-all"></div></th>';
        if ($cols != null) {
            $cols = array_unique($cols);
        }


        if ($cols) {
            $x = 0;
            foreach ($cols as $th) {
                $data.='	<th>' . $this->traduzir($th) . '</th>';
            }
        }
        $data .= '<th>Controles</th>';
        $data.='	</thead>';
        $data.=' <tbody class="sortable">';
        $rows = $this->row;

        $num_cols = count($cols);
        $y = 0;
        if (count($rows) > 0) {
            foreach ($rows as $key => $value) {
                $data .= "<tr id='" . base64_encode($this->_name . ',' . $cols[0] . ',' . $value[$cols[0]] . ',' . $this->_schema) . "'>";
                $data .="<td style='width:1%' ><input type='checkbox' class='optcheck' data-id='" . $value[$cols[0]] . "' data-table='" . base64_encode($this->_schema . '.' . $this->_name) . "' data-field='" . base64_encode($cols[0]) . "' ></td>";
                for ($x = 0; $x < $num_cols; $x++) {
                    if ($this->adicionados) {
                        if (in_array($cols[$x], $this->adicionados)) {

                            $data .="<td class='selrows' >" . $this->maskField($value[$cols[0]], $cols[$x]) . "</td>";
                        } else {
                            $data .="<td class='selrows' >" . $this->maskField($value[$cols[$x]], $cols[$x]) . "</td>";
                        }
                    } else {

                        if ($x == 0) {
                            $data .="<td class='selrows' style='width:10px'>" . $this->maskField($value[$cols[$x]], $cols[$x]) . "</td>";
                        } else {
                            $data .="<td class='selrows'>" . $this->maskField($value[$cols[$x]], $cols[$x]) . "</td>";
                        }
                    }
                }
                // exit;
                $data .='<td class="center">';
                // Monta os controles do registro
                $data .=$this->controles($tools);
                $data .=' </td> ';
                $data.='</tr>';
                $y++;
            }
        }
        $x = 0;
        $data.='</tbody></table>';
        return $data;
    }

    public function setOrder($array) {
        $this->order = $array;
    }

    private function controles($type) {
        switch ($type) {
            case 'basic':
                $data = ' 
				<button class="button grey flat block toolbut">
				   <div class="tabletool icon icon_14 i14_s_pencil tooltip edit_reg" id="edit_reg" title="Editar Registro" ></div>
				</button>
				<button class="button blue flat block  toolbut">
				   <div class="tabletool icon icon_14 i14_s_refresh tooltip ativa_reg" id="ativa_reg" title="Ativar/Desativar"></div>
				</button>
				<button class="button red flat block toolbut">
				   <div class="tabletool icon icon_14 i14_s_trashcan tooltip del_reg_sp" id="del_reg_sp" title="Excluir Registro "></div> 
				</button>
			   ';
                break;
            case 'trash':
                $data = ' 
				<button class="button blue flat block toolbut">
				   <div class="icon icon_14 i14_s_refresh tooltip" title="Restaurar Registro" id="res_reg"></div>
				</button>
				<button class="button red flat block toolbut">
				   <div class="icon icon_14 i14_s_trashcan tooltip" title="Excluir Registro " id="del_reg_def"></div> 
				</button>
				';
                break;
        }
        return $data;
    }

    private function tools($type) {
        switch ($type) {
            case 'basic':
                $data = '<div class="tabletools">
			     <div class="left">
				 <a id="add-reg" class="add-reg" href="javascript:void(0);"><i class="icon-plus"></i>Novo Registro</a> 
			     </div> 
			     <div class="left">
				 <a id="edit-reg" class="edit-reg" href="javascript:void(0);"><i class="icon-pencil"></i>Editar Registro</a> 
			     </div> 
			     <div class="left">
				 <a id="del-reg" class="del-reg" href="javascript:void(0);"><i class="icon-minus"></i>Excluir Registro(s)</a> 
			     </div>
			     <div class="right"> </div> 
			 </div>';
                break;
        }
        return $data;
    }

    /*
     * Function traduzir
     * @param $val string - Campo a ser traduzido
     * @return string - Campo traduzido
     */

    private function traduzir($val) {
        Zend_Registry::set('Zend_Locale', $val);
        $translate = new Zend_Translate('csv', APPLICATION_PATH . '/configs/data/pt_BR.csv', 'br');
        Zend_Registry::set('Zend_Translate', $translate);
        if (is_array($val)) {
            foreach ($val as $value) {
                $traduz[] = $translate->translate($value);
            }
        } else {
            $traduz = $translate->translate($val);
        }
        return $traduz;
    }

    /*
     * Function CamposRemover 
     * @param $campos array - Campos que serão removidos da tabela
     * @return array com as chaves corretas
     */

    public function CamposRemover($campos) {

        $this->removidos = $campos;
    }

    public function CamposAdicionar($campos) {

        $this->adicionados = $campos;
    }

    private function mascara($valor, $campo) {
        return $this->maskField($campo, $valor);
    }

    private function maskField($valor, $campo) {

        $vcampos = $this->search($this->campo, $campo);
        if ($vcampos[0] != '') {
            $helper = str_replace(' ', '', ucwords(
                            str_replace('_', ' ', $vcampos[0]['tipo'])
            ));
            $helper = 'Coringa_View_Helper_' . $helper;
            $result = new $helper();
            return $result->init($valor, $vcampos[0]);
        } else {
            return $valor;
        }
    }

    private function search($array, $value, $key = 'campo') {
        $results = array();

        if (is_array($array)) {
            if (isset($array[$key]) && $array[$key] == $value) {
                if (isset($array)) {
                    $results[] = $array;
                }
            }
            foreach ($array as $subarray) {
                $results = array_merge($results, $this->search($subarray, $value, $key));
            }
        }
        return $results;
    }

    public function mascaraCampo($campo) {

        $this->campo = $valor;
        $this->type = $tipo;
    }

    public function maskCampo($campo) {
        $this->campo = $campo;
    }

    public function debug($tabela) {
        echo "<pre>";
        Zend_Debug::dump($tabela->__toString());
        exit;
    }

    public function getName() {
        return $this->_name;
    }

}

?>
