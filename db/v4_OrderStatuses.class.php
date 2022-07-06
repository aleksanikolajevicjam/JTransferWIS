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

Class v4_OrderStatuses {

	public $OrderStatusID; //int(11)
	public $OrderStatusName; //varchar(100)
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
	public function New_v4_OrderStatuses($OrderStatusName){
		$this->OrderStatusName = $OrderStatusName;
	}

    /**
     * Load one row into var_class. To use the vars use for exemple echo $class->getVar_name; 
     *
     * @param key_table_type $key_row
     * 
     */
	public function getRow($key_row){
		$result = $this->connection->RunQuery("Select * from v4_OrderStatuses where OrderStatusID = \"$key_row\" ");
		if($result->num_rows < 1) return false;
		while($row = $result->fetch_array(MYSQLI_ASSOC)){
			$this->OrderStatusID = $row["OrderStatusID"];
			$this->OrderStatusName = $row["OrderStatusName"];
		}
	}

    /**
     * Delete the row by using the key as arg
     *
     * @param key_table_type $key_row
     *
     */
	public function deleteRow($key_row){
		$this->connection->RunQuery("DELETE FROM v4_OrderStatuses WHERE OrderStatusID = $key_row");
	}

    /**
     * Update the active row table on table
     */
	public function saveRow(){
		$result = $this->connection->RunQuery("UPDATE v4_OrderStatuses set 
OrderStatusName = '".$this->myreal_escape_string($this->OrderStatusName)."' WHERE OrderStatusID = '".$this->OrderStatusID."'");
	return $result; 
}

    /**
     * Save the active var class as a new row on table
     */
	public function saveAsNew(){
		$this->connection->RunQuery("INSERT INTO v4_OrderStatuses (OrderStatusName) values ('".$this->myreal_escape_string($this->OrderStatusName)."')");
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
		$result = $this->connection->RunQuery("SELECT OrderStatusID from v4_OrderStatuses $where ORDER BY $column $order");
			while($row = $result->fetch_array(MYSQLI_ASSOC)){
				$keys[$i] = $row["OrderStatusID"];
				$i++;
			}
	return $keys;
	}

	/**
	 * @return OrderStatusID - int(11)
	 */
	public function getOrderStatusID(){
		return $this->OrderStatusID;
	}

	/**
	 * @return OrderStatusName - varchar(100)
	 */
	public function getOrderStatusName(){
		return $this->OrderStatusName;
	}

	/**
	 * @param Type: int(11)
	 */
	public function setOrderStatusID($OrderStatusID){
		$this->OrderStatusID = $OrderStatusID;
	}

	/**
	 * @param Type: varchar(100)
	 */
	public function setOrderStatusName($OrderStatusName){
		$this->OrderStatusName = $OrderStatusName;
	}

    /**
     * fieldValues - Load all fieldNames and fieldValues into Array. 
     *
     * @param 
     * 
     */
	public function fieldValues(){
		$fieldValues = array(
			'OrderStatusID' => $this->getOrderStatusID(),
			'OrderStatusName' => $this->getOrderStatusName()		);
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
			'OrderStatusID',			'OrderStatusName'		);
		return $fieldNames;
	}
    /**
     * Close mysql connection
     */
	public function endv4_OrderStatuses(){
		$this->connection->CloseMysql();
	}

}