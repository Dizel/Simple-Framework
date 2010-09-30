<?php
/*	@description Clase para acessar banco de dados. Os metódos podem ser chamados em chain ( $this->a()->b()->c() )
 * 	@author Ricardo - 2009-11
 */

class Database
{
	
	var $query = '';
	
	function __construct() {
		$conn = mysql_connect(DB_HOST, DB_USER, DB_PASS) or die ("<br><br><center>Problemas ao conectar no servidor: " . mysql_error() . "</center>");
		mysql_select_db(DB_NAME);
	}
	
	function clear() {
		// clear the query
		$this->query = '';
	}
	
	function customQuery($sql) {
		$this->query = $sql;
		return $this;
	}
	
	function select($table,$fields = '*',$alias = '') {
		$this->query = 'SELECT ' . $fields . ' FROM ' . $table;
		if($alias!='') $this->query .= ' as ' . $alias;
		
		return $this;
	}
	
	function insert($table,$values,$fields='') {
		$this->query = 'INSERT INTO  ' . $table;
		if($fields!='') {
			$this->query .= ' (' . $fields . ')';
			$this->query .= ' VALUES (' . $values . ')';
		} else {
			// get the fields and values
			$this->query .= $this->getFieldsInsert($values);
		}
//		echo $this->query; exit;
		return $this;
	}
	
	function update($table,$set) {
		$this->query = 'UPDATE ' . $table . ' SET ' . $set;
		
		$i=0;
		/*
		 * if $set is array()
		foreach($set as $s) {
			if($i!=0) {
				$this->query .= ', ';
				$i=1;
			}
			$this->query .= $s;
		}
		*/
		return $this;
	}
	
	function delete($table) {
		$this->query = 'DELETE FROM ' . $table;
		
		return $this;
	}
	
	function join($join,$type='INNER') {
		$this->query .= ' ' . $type . ' JOIN ' . $join;
		
		return $this;
	}
	
	function where($where = array()) {
		if(count($where) > 0) {
			$i=0;
			$this->query .= ' WHERE ';
			foreach($where as $wh) {
				if($i!=0) {
					$this->query .= ' AND ';
				}
				$this->query .= $wh;
				$i=1;
			}
		}
		
		return $this;
	}
	
	function orderby($order) {
		$this->query .= ' ORDER BY ' . $order;
		
		return $this;
	}
	
	function groupby($group) {
		$this->query .= ' GROUP BY ' . $group;
		
		return $this;
	}
	
	function limit($limit) {
		$this->query .= ' LIMIT ' . $limit;
		
		return $this;
	}
	
	function run($stop = 0) {
		if($stop==1) {
			echo $this->query; exit;
		}
		$q = mysql_query($this->query) or die(mysql_error() . '<br>' . $this->query);
		
		return $q;
	}
	
	function trataString($str) {
		return "'" . $str . "'";
	}
	
	// get the fields and values from an array (except if it's the $exclude)
	function getFields($fields,$separator=',',$exclude='') {
		$out = '0';
		foreach($fields as $name => $value) {
			if($name!=$exclude) {
				$out .= $separator . ' ' . $name . " = '" . $value . "'";
			}
		}
		
		$out = str_replace('0'.$separator.' ', '', $out);
		
		return $out;
		
	}
	
	// get the fields for the insert statement
	function getFieldsInsert($f) {
		$fields = '(0';
		$values = '(0';

		foreach($f as $name => $value) {
			$fields .= ',' . $name;
			$values .= ",'" . $value . "'";
		}
		
		$fields = str_replace('0,', '', $fields);
		$values = str_replace('0,', '', $values);
		
		$out = $fields . ') VALUES ' . $values . ')';
		
		return $out;
		
	}
	
	// retorna a listagem dos estados
	function estados() {
		$q = $this->select('estados')->orderby('nome')->run();
		$estados = array();
		$i=0;
		while($rs = mysql_fetch_array($q)) {
			$estados[$rs['idEstado']] = $rs['nome'];
		}
		
		return $estados;
	}
}

?>