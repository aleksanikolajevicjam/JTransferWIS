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

Class v4_PaymentParams {

	public $ID; //int(10)
	public $Gateway; //varchar(255)
	public $Param; //varchar(255)
	public $ParamValue; //varchar(255)
	public $NumericValue; //int(50)
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
	public function New_v4_PaymentParams($Gateway,$Param,$ParamValue,$NumericValue){
		$this->Gateway = $Gateway;
		$this->Param = $Param;
		$this->ParamValue = $ParamValue;
		$this->NumericValue = $NumericValue;
	}

    /**
     * Load one row into var_class. To use the vars use for exemple echo $class->getVar_name; 
     *
     * @param key_table_type $key_row
     * 
     */
	public function getRow($key_row){
		$result = $this->connection->RunQuery("Select * from v4_PaymentParams where ID = \"$key_row\" ");
		if($result->num_rows < 1) return false;
		while($row = $result->fetch_array(MYSQLI_ASSOC)){
			$this->ID = $row["ID"];
			$this->Gateway = $row["Gateway"];
			$this->Param = $row["Param"];
			$this->ParamValue = $row["ParamValue"];
			$this->NumericValue = $row["NumericValue"];
		}
	}

    /**
     * Delete the row by using the key as arg
     *
     * @param key_table_type $key_row
     *
     */
	public function deleteRow($key_row){
		$this->connection->RunQuery("DELETE FROM v4_PaymentParams WHERE ID = $key_row");
	}

    /**
     * Update the active row table on table
     */
	public function saveRow(){
		$result = $this->connection->RunQuery("UPDATE v4_PaymentParams set 
Gateway = '".$this->myreal_escape_string($this->Gateway)."', 
Param = '".$this->myreal_escape_string($this->Param)."', 
ParamValue = '".$this->myreal_escape_string($this->ParamValue)."', 
NumericValue = '".$this->myreal_escape_string($this->NumericValue)."' WHERE ID = '".$this->ID."'");
	return $result; 
}

    /**
     * Save the active var class as a new row on table
     */
	public function saveAsNew(){
		$this->connection->RunQuery("INSERT INTO v4_PaymentParams (Gateway, Param, ParamValue, NumericValue) values ('".$this->myreal_escape_string($this->Gateway)."', '".$this->myreal_escape_string($this->Param)."', '".$this->myreal_escape_string($this->ParamValue)."', '".$this->myreal_escape_string($this->NumericValue)."')");
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
		$result = $this->connection->RunQuery("SELECT ID from v4_PaymentParams $where ORDER BY $column $order");
			while($row = $result->fetch_array(MYSQLI_ASSOC)){
				$keys[$i] = $row["ID"];
				$i++;
			}
	return $keys;
	}

	/**
	 * @return ID - int(10)
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
	 * @return Param - varchar(255)
	 */
	public function getParam(){
		return $this->Param;
	}

	/**
	 * @return ParamValue - varchar(255)
	 */
	public function getParamValue(){
		return $this->ParamValue;
	}

	/**
	 * @return NumericValue - int(50)
	 */
	public function getNumericValue(){
		return $this->NumericValue;
	}

	/**
	 * @param Type: int(10)
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
	 * @param Type: varchar(255)
	 */
	public function setParam($Param){
		$this->Param = $Param;
	}

	/**
	 * @param Type: varchar(255)
	 */
	public function setParamValue($ParamValue){
		$this->ParamValue = $ParamValue;
	}

	/**
	 * @param Type: int(50)
	 */
	public function setNumericValue($NumericValue){
		$this->NumericValue = $NumericValue;
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
			'Param' => $this->getParam(),
			'ParamValue' => $this->getParamValue(),
			'NumericValue' => $this->getNumericValue()		);
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
			'ID',			'Gateway',			'Param',			'ParamValue',			'NumericValue'		);
		return $fieldNames;
	}
    /**
     * Close mysql connection
     */
	public function endv4_PaymentParams(){
		$this->connection->CloseMysql();
	}

}