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

Class v4_logTaxido {

	public $ID; //int(10)
	public $UserIP; //varchar(255)
	public $LogEntry; //text
	public $DateTime; //timestamp
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
	public function New_v4_logTaxido($UserIP,$LogEntry,$DateTime){
		$this->UserIP = $UserIP;
		$this->LogEntry = $LogEntry;
		$this->DateTime = $DateTime;
	}

    /**
     * Load one row into var_class. To use the vars use for exemple echo $class->getVar_name; 
     *
     * @param key_table_type $key_row
     * 
     */
	public function getRow($key_row){
		$result = $this->connection->RunQuery("Select * from v4_logTaxido where ID = \"$key_row\" ");
		if($result->num_rows < 1) return false;
		while($row = $result->fetch_array(MYSQLI_ASSOC)){
			$this->ID = $row["ID"];
			$this->UserIP = $row["UserIP"];
			$this->LogEntry = $row["LogEntry"];
			$this->DateTime = $row["DateTime"];
		}
	}

    /**
     * Delete the row by using the key as arg
     *
     * @param key_table_type $key_row
     *
     */
	public function deleteRow($key_row){
		$this->connection->RunQuery("DELETE FROM v4_logTaxido WHERE ID = $key_row");
	}

    /**
     * Update the active row table on table
     */
	public function saveRow(){
		$result = $this->connection->RunQuery("UPDATE v4_logTaxido set 
UserIP = '".$this->myreal_escape_string($this->UserIP)."', 
LogEntry = '".$this->myreal_escape_string($this->LogEntry)."', 
DateTime = '".$this->myreal_escape_string($this->DateTime)."' WHERE ID = '".$this->ID."'");
	return $result; 
}

    /**
     * Save the active var class as a new row on table
     */
	public function saveAsNew(){
		$this->connection->RunQuery("INSERT INTO v4_logTaxido (UserIP, LogEntry, DateTime) values ('".$this->myreal_escape_string($this->UserIP)."', '".$this->myreal_escape_string($this->LogEntry)."', '".$this->myreal_escape_string($this->DateTime)."')");
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
		$result = $this->connection->RunQuery("SELECT ID from v4_logTaxido $where ORDER BY $column $order");
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
	 * @return UserIP - varchar(255)
	 */
	public function getUserIP(){
		return $this->UserIP;
	}

	/**
	 * @return LogEntry - text
	 */
	public function getLogEntry(){
		return $this->LogEntry;
	}

	/**
	 * @return DateTime - timestamp
	 */
	public function getDateTime(){
		return $this->DateTime;
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
	public function setUserIP($UserIP){
		$this->UserIP = $UserIP;
	}

	/**
	 * @param Type: text
	 */
	public function setLogEntry($LogEntry){
		$this->LogEntry = $LogEntry;
	}

	/**
	 * @param Type: timestamp
	 */
	public function setDateTime($DateTime){
		$this->DateTime = $DateTime;
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
			'UserIP' => $this->getUserIP(),
			'LogEntry' => $this->getLogEntry(),
			'DateTime' => $this->getDateTime()		);
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
			'ID',			'UserIP',			'LogEntry',			'DateTime'		);
		return $fieldNames;
	}
    /**
     * Close mysql connection
     */
	public function endv4_logTaxido(){
		$this->connection->CloseMysql();
	}

}