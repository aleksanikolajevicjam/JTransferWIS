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

Class v4_Tasks {

	public $OwnerID; //int(10) unsigned
	public $TaskID; //tinyint(4) unsigned
	public $Task; //varchar(255)
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
	public function New_v4_Tasks($OwnerID,$Task){
		$this->OwnerID = $OwnerID;
		$this->Task = $Task;
	}

    /**
     * Load one row into var_class. To use the vars use for exemple echo $class->getVar_name; 
     *
     * @param key_table_type $key_row
     * 
     */
	public function getRow($key_row){
		$result = $this->connection->RunQuery("Select * from v4_Tasks where TaskID = \"$key_row\" ");
		if($result->num_rows < 1) return false;
		while($row = $result->fetch_array(MYSQLI_ASSOC)){
			$this->OwnerID = $row["OwnerID"];
			$this->TaskID = $row["TaskID"];
			$this->Task = $row["Task"];
		}
	}

    /**
     * Delete the row by using the key as arg
     *
     * @param key_table_type $key_row
     *
     */
	public function deleteRow($key_row){
		$this->connection->RunQuery("DELETE FROM v4_Tasks WHERE TaskID = $key_row");
	}

    /**
     * Update the active row table on table
     */
	public function saveRow(){
		$result = $this->connection->RunQuery("UPDATE v4_Tasks set 
OwnerID = '".$this->myreal_escape_string($this->OwnerID)."', 
Task = '".$this->myreal_escape_string($this->Task)."' WHERE TaskID = '".$this->TaskID."'");
	return $result; 
}

    /**
     * Save the active var class as a new row on table
     */
	public function saveAsNew(){
		$this->connection->RunQuery("INSERT INTO v4_Tasks (OwnerID, Task) values ('".$this->myreal_escape_string($this->OwnerID)."', '".$this->myreal_escape_string($this->Task)."')");
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
		$result = $this->connection->RunQuery("SELECT TaskID from v4_Tasks $where ORDER BY $column $order");
			while($row = $result->fetch_array(MYSQLI_ASSOC)){
				$keys[$i] = $row["TaskID"];
				$i++;
			}
	return $keys;
	}

	/**
	 * @return OwnerID - int(10) unsigned
	 */
	public function getOwnerID(){
		return $this->OwnerID;
	}

	/**
	 * @return TaskID - tinyint(4) unsigned
	 */
	public function getTaskID(){
		return $this->TaskID;
	}

	/**
	 * @return Task - varchar(255)
	 */
	public function getTask(){
		return $this->Task;
	}

	/**
	 * @param Type: int(10) unsigned
	 */
	public function setOwnerID($OwnerID){
		$this->OwnerID = $OwnerID;
	}

	/**
	 * @param Type: tinyint(4) unsigned
	 */
	public function setTaskID($TaskID){
		$this->TaskID = $TaskID;
	}

	/**
	 * @param Type: varchar(255)
	 */
	public function setTask($Task){
		$this->Task = $Task;
	}

    /**
     * fieldValues - Load all fieldNames and fieldValues into Array. 
     *
     * @param 
     * 
     */
	public function fieldValues(){
		$fieldValues = array(
			'OwnerID' => $this->getOwnerID(),
			'TaskID' => $this->getTaskID(),
			'Task' => $this->getTask()		);
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
			'OwnerID',			'TaskID',			'Task'		);
		return $fieldNames;
	}
    /**
     * Close mysql connection
     */
	public function endv4_Tasks(){
		$this->connection->CloseMysql();
	}

}