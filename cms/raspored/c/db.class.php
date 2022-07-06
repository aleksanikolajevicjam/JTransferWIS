<?php

/*
 * Author: Rafael Rocha - www.rafaelrocha.net - info@rafaelrocha.net
 *
 * Create Date: 9-04-2013
 *
 * Version of MYSQL_to_PHP: 1.1
 *
 * License: LGPL
 *
 */

Class DataBaseMysql {

	public $conn;

	public function DataBaseMysql(){
		//$this->conn = new mysqli("localhost", "jamtrans_cezar", "3WLRAFu;E_!F", "jamtrans_touradria");
        $this->conn = new mysqli("localhost", "jamtrans_cms", "~5%OuH{etSL)", "jamtrans_touradria");   
		
		
		if($this->conn->connect_error){
			echo "Error connect to mysql";die;
		}
	}

	public function RunQuery($query_tag){
		$result = $this->conn->query($query_tag) or die("Error SQL query-> $query_tag  ". mysql_error());
		return $result;
	}

	public function TotalOfRows($table_name){
		$result = $this->RunQuery("Select * from $table_name");
		return $result->num_rows;
	}

	public function CloseMysql(){
		$this->conn->close();
	}

}

?>
