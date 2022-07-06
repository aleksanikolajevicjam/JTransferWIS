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
require_once 'db.class.php';

Class v4_PaymentGateways {

	public $ID; //int(5)
	public $Gateway; //varchar(255)
	public $Active; //tinyint(1)
	public $connection;

	function __construct(){
		$this->connection = new DataBaseMysql();
	}	public function myreal_escape_string($string){
		return $this->connection->real_escape_string($string);
	}

    /**
     * New object to the class. Don´t forget to save this new object "as new" by using the function $class->saveAsNew(); 
     *
     */
	public function New_v4_PaymentGateways($Gateway,$Active){
		$this->Gateway = $Gateway;
		$this->Active = $Active;
	}

    /**
     * Load one row into var_class. To use the vars use for exemple echo $class->getVar_name; 
     *
     * @param key_table_type $key_row
     * 
     */
	public function getRow($key_row){
		$result = $this->connection->RunQuery("Select * from v4_PaymentGateways where ID = \"$key_row\" ");
		if($result->num_rows < 1) return false;
		while($row = $result->fetch_array(MYSQLI_ASSOC)){
			$this->ID = $row["ID"];
			$this->Gateway = $row["Gateway"];
			$this->Active = $row["Active"];
		}
	}

    /**
     * Delete the row by using the key as arg
     *
     * @param key_table_type $key_row
     *
     */
	public function deleteRow($key_row){
		$this->connection->RunQuery("DELETE FROM v4_PaymentGateways WHERE ID = $key_row");
	}

    /**
     * Update the active row table on table
     */
	public function saveRow(){
		$result = $this->connection->RunQuery("UPDATE v4_PaymentGateways set 
Gateway = '".$this->myreal_escape_string($this->Gateway)."', 
Active = '".$this->myreal_escape_string($this->Active)."' WHERE ID = '".$this->ID."'");
	return $result; 
}

    /**
     * Save the active var class as a new row on table
     */
	public function saveAsNew(){
		$this->connection->RunQuery("INSERT INTO v4_PaymentGateways (Gateway, Active) values ('".$this->myreal_escape_string($this->Gateway)."', '".$this->myreal_escape_string($this->Active)."')");
		return $this->connection->insert_id(); //return insert_id 
	}

    /**
     * Returns array of keys order by $column -> name of column $order -> desc or acs
     *
     * @param string $column
     * @param string $order
     */
	public function getKeysBy($column, $order, $where = NULL){
		$keys = array(); $i = 0;
		$result = $this->connection->RunQuery("SELECT ID from v4_PaymentGateways $where ORDER BY $column $order");
			while($row = $result->fetch_array(MYSQLI_ASSOC)){
				$keys[$i] = $row["ID"];
				$i++;
			}
	return $keys;
	}

	/**
	 * @return ID - int(5)
	 */
	public function getID(){
		return $this->ID;
	}

	/**
	 * @return Gateway - varchar(255)
	 */
	public function getGateway(){
		return $this->Gateway;
	}

	/**
	 * @return Active - tinyint(1)
	 */
	public function getActive(){
		return $this->Active;
	}

	/**
	 * @param Type: int(5)
	 */
	public function setID($ID){
		$this->ID = $ID;
	}

	/**
	 * @param Type: varchar(255)
	 */
	public function setGateway($Gateway){
		$this->Gateway = $Gateway;
	}

	/**
	 * @param Type: tinyint(1)
	 */
	public function setActive($Active){
		$this->Active = $Active;
	}

    /**
     * fieldValues - Load all fieldNames and fieldValues into Array. 
     *
     * @param 
     * 
     */
	public function fieldValues(){
		$fieldValues = array(
			'ID' => $this->getID(),
			'Gateway' => $this->getGateway(),
			'Active' => $this->getActive()		);
		return $fieldValues;
	}
    /**
     * fieldNames - returns array of fieldNames 
     *
     * @param 
     * 
     */
	public function fieldNames(){
		$fieldNames = array(
			'ID',			'Gateway',			'Active'		);
		return $fieldNames;
	}
    /**
     * Close mysql connection
     */
	public function endv4_PaymentGateways(){
		$this->connection->CloseMysql();
	}

}