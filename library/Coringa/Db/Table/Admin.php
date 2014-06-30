<?php

class Coringa_Db_Table_Admin extends Zend_Db_Table_Abstract {

    /**
     * Nome da tabela que ser� utilizada para consultas
     * definida pela classe final que estende a Database
     *
     * @var string $_name
     */
    protected $_name;

    /**
     * Chave(s) prim�ria(s) da tabela
     *
     * @var int $primary
     */
    protected $_primary;

    /**
     * Chave(s) estrangeiras(s) da tabela
     *
     * @var int $_foreignKeys
     */
    protected $_foreignKeys;

    /**
     * Colunas da tabela
     *
     * @var array $_cols
     */
    protected $_cols;

    /**
     * Statement da ultima consulta executada
     *
     * @var Zend_Db_Statement_Pdo $statement
     */
    private $statement;

    /**
     * n�mero de linhas totais de uma consulta, ignorando o limit
     * @var int $statement
     */
    private $_foundRows = 0;

    /**
     * Construtor da classe
     *
     * @param string $_name - Nome da tabela
     */
    public function init() {
        
    }

    /**
     * Executa uma consulta e retorna o objeto com os dados da consulta
     * @param array/string $cols
     * @param string $where
     * @param string $group
     * @param int
     */
    public function listar($cols = "*", $where = '', $limit = false, $group = '') {
        if (null === $cols || empty($cols))
            $cols = '*';
        if (!is_array($cols) && preg_match('/,/', $cols))
            $cols = explode(',', preg_replace('/ /', '', $cols));
        $select = $this->select(Zend_Db_Table_Abstract::SELECT_WITH_FROM_PART)->from($this->_name, $cols);
        if (!empty($where)) {
            if (is_array($where)) {
                foreach ($where as $col => $value) {
                    if (is_numeric($col))
                        $select->where($value);
                    else
                        $select->where("{$col} = ?", $value);
                }
            } else {
                $select->where($where);
            }
        }
        if (!empty($group))
            $select->group($group);
        $this->consultaSql($select, $limit);
        return $this;
    }

    public function select($withFromPart = Zend_Db_Table_Abstract::SELECT_WITHOUT_FROM_PART) {
        return parent::select()->setIntegrityCheck(false);
    }

    /**
     * Executa as querys
     * n�o executa nenhum tratamento(where, order, limitPage) quando passado uma string no $select;
     * n�o UTILIZE ESTA fun��o SEM O CONDICIONAL "WHERE" NA SUA CONSULTA STRING
     * @param object/string $select
     * @param boolean $limit
     * @return object
     */
    public function consultaSql($select, $limit = false) {
        if (!isset($select)) {
            return false;
        }
        $conn = $this->getAdapter();
        if (is_object($select) and $select instanceof Zend_Db_Select) {
            $order = $this->getOrder();
            if (!empty($order))
                $select->order($order);
            if ($limit)
                $select->limit($this->getLinhasPorPagina(), $this->getNroPagina());
            //$select->limitPage( $this->getNroPagina(), $this->getLinhasPorPagina() );
            $select = $select->__toString();
        } elseif (is_string($select)) {
            if (trim($filtros) != '')
                $select = preg_replace('/WHERE/i', 'WHERE ' . $filtros . ' AND ', $select);
        }
        $this->statement = $conn->query('SET SQL_BIG_SELECTS=1; ');
        $select = preg_replace('/SELECT/i', 'SELECT SQL_CALC_FOUND_ROWS ', $select, 1);
        $this->statement = $conn->query($select);
        $this->showProfile();
        if (preg_match('/SQL_CALC_FOUND_ROWS/', $select)) {
            $this->_foundRows = $conn->fetchOne('SELECT FOUND_ROWS()');
        }
        $this->showProfile();
        return $this;
    }

    /**
     * Executa o statement armazenado e
     * retorna um array contendo todas as linhas
     * do conjunto de resultados
     */
    public function getDados() {
        if ($this->statement) { // Verifica se o objeto existe
            $dados = $this->statement->fetchAll();
            //$this->closeConn();
            return $dados;
        }
    }

    /**
     * Executa o statement armazenado e
     * obt�m uma linha do conjunto de resultados
     */
    public function getRegistro() {
        $dados = $this->statement->fetch();
        //$this->closeConn();
        return $dados;
    }

    public function getPares() {
        $dados = $this->statement->fetchAll(PDO::FETCH_KEY_PAIR);
        //$this->closeConn();
        return $dados;
    }

    /**
     * Executa a consulta ao banco de dados e armazena o statement
     *
     * @param mixed $cols		- String/Array de colunas usados na clausula from
     * @param mixed $from		- String/Array O nome da tabela ou array associativo com chave ( alias ) e valor( nome da tabela )
     * @param array $join		- Alias da tabela como indice e o valor um array com condi��o, colunas e tipo de join( join, joinLeft, joinRight )
     * @param mixed $where		- String/Array A condi��o Where
     * @param mixed $group		- String/Array A(s) coluna(s) para o group by
     * @param bool $limit		- Limite de registro
     * @param string $having	- A condi��o having
     *
     * @return Database
     */
    public function consulta($cols = "*", $from = "", $join = array(), $where = "", $group = "", $limit = false, $having = "") {
        $select = parent::select(Zend_Db_Table_Abstract::SELECT_WITHOUT_FROM_PART)->setIntegrityCheck(false);
        if (empty($from) || null === $from)
            $from = $this->_name;
        $from = array('A' => $from);
        if (null === $cols)
            $cols = '*';
        if (!is_array($cols) && preg_match('/,/', $cols))
            $cols = explode(',', preg_replace("/ /", "", $cols));
        $select->from($from, $cols);
        if (!empty($join)) {
            foreach ($join as $alias => $params) {
                $joinType = isset($params[3]) && !empty($params[3]) && in_array($params[3], array('join', 'joinLeft', 'joinRight')) ? $params[3] : 'join';
                if (!isset($params[2]))
                    $params[2] = '';
                $select->{$joinType}(array($alias => $params[0]), $params[1], $params[2]);
            }
        }
        if (!empty($where)) {
            if (is_array($where)) {
                foreach ($where as $col => $value) {
                    if (is_numeric($col))
                        $select->where($value);
                    else
                        $select->where("{$col} = ?", $value);
                }
            } else {
                $select->where($where);
            }
        }
        if (!empty($group))
            $select->group($group);
        if (!empty($having))
            $select->having($having);
        $dados = $this->consultaSql($select, $limit);
        //$this->closeConn();
        return $dados;
    }

    /**
     * Seta a quantidade de linhas por página na listagem
     *
     * @param int $quantidadeLinhas - Quantidade de linhas
     */
    public function setLinhasPorPagina($quantidadeLinhas = 50) {
        if ((int) $quantidadeLinhas)
            $this->quantidadeLinhas = (int) $quantidadeLinhas;
    }

    /**
     * Retorna a quantidade de linhas setadas por página
     *
     * @return number $quantidadeLinhas
     */
    public function getLinhasPorPagina() {
        return $this->quantidadeLinhas;
    }

    /**
     * @param unknown_type $numeroPagina
     */
    public function setNroPagina($numeroPagina = 0) {
        if ((int) $numeroPagina)
            $this->numeroPagina = (int) $numeroPagina;
    }

    /**
     * @return number
     */
    public function getNroPagina() {
        return $this->numeroPagina;
    }

    /**
     * @param mixed $order
     */
    public function setOrder($order = '') {
        if (!empty($order))
            $this->order = $order;
    }

    /**
     * @return mixed - String/Array
     */
    public function getOrder() {
        return $this->order;
    }

    public function addFiltro($_name = null, $filtro = null) {
        if (null === $_name || null === $filtro || !is_string($filtro))
            return;
        $this->filtros[$_name] = $filtro;
    }

    /**
     * @return string
     */
    public function getLastInsertId() {
        return $this->getAdapter()->lastInsertId();
    }

    /**
     * @return number
     */
    public function getNumRegistros() {
        return $this->statement->rowCount();
    }

    /**
     * @return object Zend_Db_Profiler
     */
    public function getProfile() {
        return $this->getAdapter()->getProfiler()->getQueryProfiles();
    }

    public function showProfile() {
        if (isset($_SESSION['debug']) && $_SESSION['debug'] == SQL) {
            echo "<pre style='font-size:13px; font-weight:bold; font-family:Courier, monospace; color:#999;'>\n<br>";
            print_r($this->getAdapter()->getProfiler()->getLastQueryProfile()->getQuery());
            $params = $this->getAdapter()->getProfiler()->getLastQueryProfile()->getQueryParams();
            if (!empty($params)) {
                echo "<br />";
                print_r($params);
            }
            echo "</pre><br /><br />";
        }
    }

}
