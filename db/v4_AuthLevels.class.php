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

Class v4_AuthLevels {

	public $AuthLevelID; //int(10) unsigned
	public $AuthLevelName; //varchar(50)
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
	public function New_v4_AuthLevels($AuthLevelName){
		$this->AuthLevelName = $AuthLevelName;
	}

    /**
     * Load one row into var_class. To use the vars use for exemple echo $class->getVar_name; 
     *
     * @param key_table_type $key_row
     * 
     */
	public function getRow($key_row){
		$result = $this->connection->RunQuery("Select * from v4_AuthLevels where AuthLevelID = \"$key_row\" ");
		if($result->num_rows < 1) return false;
		while($row = $result->fetch_array(MYSQLI_ASSOC)){
			$this->AuthLevelID = $row["AuthLevelID"];
			$this->AuthLevelName = $row["AuthLevelName"];
		}
	}

    /**
     * Delete the row by using the key as arg
     *
     * @param key_table_type $key_row
     *
     */
	public function deleteRow($key_row){
		$this->connection->RunQuery("DELETE FROM v4_AuthLevels WHERE AuthLevelID = $key_row");
	}

    /**
     * Update the active row table on table
     */
	public function saveRow(){
		$result = $this->connection->RunQuery("UPDATE v4_AuthLevels set 
AuthLevelName = '".$this->myreal_escape_string($this->AuthLevelName)."' WHERE AuthLevelID = '".$this->AuthLevelID."'");
	return $result; 
}

    /**
     * Save the active var class as a new row on table
     */
	public function saveAsNew(){
		$this->connection->RunQuery("INSERT INTO v4_AuthLevels (AuthLevelName) values ('".$this->myreal_escape_string($this->AuthLevelName)."')");
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
		$result = $this->connection->RunQuery("SELECT AuthLevelID from v4_AuthLevels $where ORDER BY $column $order");
			while($row = $result->fetch_array(MYSQLI_ASSOC)){
				$keys[$i] = $row["AuthLevelID"];
				$i++;
			}
	return $keys;
	}

	/**
	 * @return AuthLevelID - int(10) unsigned
	 */
	public function getAuthLevelID(){
		return $this->AuthLevelID;
	}

	/**
	 * @return AuthLevelName - varchar(50)
	 */
	public function getAuthLevelName(){
		return $this->AuthLevelName;
	}

	/**
	 * @param Type: int(10) unsigned
	 */
	public function setAuthLevelID($AuthLevelID){
		$this->AuthLevelID = $AuthLevelID;
	}

	/**
	 * @param Type: varchar(50)
	 */
	public function setAuthLevelName($AuthLevelName){
		$this->AuthLevelName = $AuthLevelName;
	}

    /**
     * fieldValues - Load all fieldNames and fieldValues into Array. 
     *
     * @param 
     * 
     */
	public function fieldValues(){
		$fieldValues = array(
			'AuthLevelID' => $this->getAuthLevelID(),
			'AuthLevelName' => $this->getAuthLevelName()		);
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
			'AuthLevelID',			'AuthLevelName'		);
		return $fieldNames;
	}
    /**
     * Close mysql connection
     */
	public function endv4_AuthLevels(){
		$this->connection->CloseMysql();
	}

}