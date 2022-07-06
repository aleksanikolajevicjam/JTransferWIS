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

Class DataBaseMysql {

    public $conn;

    function __construct(){
        //$this->conn = new mysqli("127.0.0.1", "jamtrans_cezar", "3WLRAFu;E_!F", "jamtrans_touradria"); 
        $this->conn = new mysqli("127.0.0.1", "jamtrans_cms", "~5%OuH{etSL)", "jamtrans_touradria");   
		
        //$this->conn->set_charset('utf8mb4');
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
