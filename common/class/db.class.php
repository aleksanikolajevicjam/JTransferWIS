<?php

/*
 * Author: Rafael Rocha
 *
 * Changes: Bogo Soic-Mirilovic bogo.split@gmail.com
 * 
 * Version of MYSQL_to_PHP: 1.1.1
 * 
 * License: LGPL 
 * 
 */
//include_once("ezsql/ez_sql_core.php");
//include_once("ezsql/mysql/ez_sql_mysql.php");
//include_once("ezsql/mysqli/ez_sql_mysqli.php"); //za php7.0
 
class DataBaseMysql {

	public $conn;

	function __construct() {
		$this->conn = new mysqli(EZSQL_DB_HOST, EZSQL_DB_USER, EZSQL_DB_PASSWORD, EZSQL_DB_NAME);
        if($this->conn->connect_error){
            echo "Error connect to mysql";die;
        } else $this->conn->query("SET NAMES 'UTF8'");
	}
	
	public function RunQuery($query_tag){
		$result = $this->conn->query($query_tag) or die("Error SQL query-> $query_tag  ". mysql_error());
		return $result;
	}

	public function insert_id(){
		return $this->conn->insert_id;
	}

	public function TotalOfRows($table_name){
		$result = $this->RunQuery("Select * from $table_name");
		return $result->num_rows;
	}

	public function CloseMysql(){
		$this->conn->close();
	}

	public function real_escape_string($value) {
		return $this->conn->real_escape_string($value);
	}

}

?>
