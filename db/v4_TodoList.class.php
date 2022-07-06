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

Class v4_TodoList {

	public $ID; //int(10) unsigned
	public $OwnerID; //int(10) unsigned
	public $Task; //varchar(255)
	public $DateAdded; //date
	public $TimeAdded; //time
	public $Completed; //tinyint(1)
	public $DateCompleted; //date
	public $TimeCompleted; //time
	public $SortOrder; //int(5) unsigned
	public $GroupID; //int(5) unsigned
	public $ShareWithGroup; //tinyint(1)
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
	public function New_v4_TodoList($OwnerID,$Task,$DateAdded,$TimeAdded,$Completed,$DateCompleted,$TimeCompleted,$SortOrder,$GroupID,$ShareWithGroup){
		$this->OwnerID = $OwnerID;
		$this->Task = $Task;
		$this->DateAdded = $DateAdded;
		$this->TimeAdded = $TimeAdded;
		$this->Completed = $Completed;
		$this->DateCompleted = $DateCompleted;
		$this->TimeCompleted = $TimeCompleted;
		$this->SortOrder = $SortOrder;
		$this->GroupID = $GroupID;
		$this->ShareWithGroup = $ShareWithGroup;
	}

    /**
     * Load one row into var_class. To use the vars use for exemple echo $class->getVar_name; 
     *
     * @param key_table_type $key_row
     * 
     */
	public function getRow($key_row){
		$result = $this->connection->RunQuery("Select * from v4_TodoList where ID = \"$key_row\" ");
		if($result->num_rows < 1) return false;
		while($row = $result->fetch_array(MYSQLI_ASSOC)){
			$this->ID = $row["ID"];
			$this->OwnerID = $row["OwnerID"];
			$this->Task = $row["Task"];
			$this->DateAdded = $row["DateAdded"];
			$this->TimeAdded = $row["TimeAdded"];
			$this->Completed = $row["Completed"];
			$this->DateCompleted = $row["DateCompleted"];
			$this->TimeCompleted = $row["TimeCompleted"];
			$this->SortOrder = $row["SortOrder"];
			$this->GroupID = $row["GroupID"];
			$this->ShareWithGroup = $row["ShareWithGroup"];
		}
	}

    /**
     * Delete the row by using the key as arg
     *
     * @param key_table_type $key_row
     *
     */
	public function deleteRow($key_row){
		$this->connection->RunQuery("DELETE FROM v4_TodoList WHERE ID = $key_row");
	}

    /**
     * Update the active row table on table
     */
	public function saveRow(){
		$result = $this->connection->RunQuery("UPDATE v4_TodoList set 
OwnerID = '".$this->myreal_escape_string($this->OwnerID)."', 
Task = '".$this->myreal_escape_string($this->Task)."', 
DateAdded = '".$this->myreal_escape_string($this->DateAdded)."', 
TimeAdded = '".$this->myreal_escape_string($this->TimeAdded)."', 
Completed = '".$this->myreal_escape_string($this->Completed)."', 
DateCompleted = '".$this->myreal_escape_string($this->DateCompleted)."', 
TimeCompleted = '".$this->myreal_escape_string($this->TimeCompleted)."', 
SortOrder = '".$this->myreal_escape_string($this->SortOrder)."', 
GroupID = '".$this->myreal_escape_string($this->GroupID)."', 
ShareWithGroup = '".$this->myreal_escape_string($this->ShareWithGroup)."' WHERE ID = '".$this->ID."'");
	return $result; 
}

    /**
     * Save the active var class as a new row on table
     */
	public function saveAsNew(){
		$this->connection->RunQuery("INSERT INTO v4_TodoList (OwnerID, Task, DateAdded, TimeAdded, Completed, DateCompleted, TimeCompleted, SortOrder, GroupID, ShareWithGroup) values ('".$this->myreal_escape_string($this->OwnerID)."', '".$this->myreal_escape_string($this->Task)."', '".$this->myreal_escape_string($this->DateAdded)."', '".$this->myreal_escape_string($this->TimeAdded)."', '".$this->myreal_escape_string($this->Completed)."', '".$this->myreal_escape_string($this->DateCompleted)."', '".$this->myreal_escape_string($this->TimeCompleted)."', '".$this->myreal_escape_string($this->SortOrder)."', '".$this->myreal_escape_string($this->GroupID)."', '".$this->myreal_escape_string($this->ShareWithGroup)."')");
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
		$result = $this->connection->RunQuery("SELECT ID from v4_TodoList $where ORDER BY $column $order");
			while($row = $result->fetch_array(MYSQLI_ASSOC)){
				$keys[$i] = $row["ID"];
				$i++;
			}
	return $keys;
	}

	/**
	 * @return ID - int(10) unsigned
	 */
	public function getID(){
		return $this->ID;
	}

	/**
	 * @return OwnerID - int(10) unsigned
	 */
	public function getOwnerID(){
		return $this->OwnerID;
	}

	/**
	 * @return Task - varchar(255)
	 */
	public function getTask(){
		return $this->Task;
	}

	/**
	 * @return DateAdded - date
	 */
	public function getDateAdded(){
		return $this->DateAdded;
	}

	/**
	 * @return TimeAdded - time
	 */
	public function getTimeAdded(){
		return $this->TimeAdded;
	}

	/**
	 * @return Completed - tinyint(1)
	 */
	public function getCompleted(){
		return $this->Completed;
	}

	/**
	 * @return DateCompleted - date
	 */
	public function getDateCompleted(){
		return $this->DateCompleted;
	}

	/**
	 * @return TimeCompleted - time
	 */
	public function getTimeCompleted(){
		return $this->TimeCompleted;
	}

	/**
	 * @return SortOrder - int(5) unsigned
	 */
	public function getSortOrder(){
		return $this->SortOrder;
	}

	/**
	 * @return GroupID - int(5) unsigned
	 */
	public function getGroupID(){
		return $this->GroupID;
	}

	/**
	 * @return ShareWithGroup - tinyint(1)
	 */
	public function getShareWithGroup(){
		return $this->ShareWithGroup;
	}

	/**
	 * @param Type: int(10) unsigned
	 */
	public function setID($ID){
		$this->ID = $ID;
	}

	/**
	 * @param Type: int(10) unsigned
	 */
	public function setOwnerID($OwnerID){
		$this->OwnerID = $OwnerID;
	}

	/**
	 * @param Type: varchar(255)
	 */
	public function setTask($Task){
		$this->Task = $Task;
	}

	/**
	 * @param Type: date
	 */
	public function setDateAdded($DateAdded){
		$this->DateAdded = $DateAdded;
	}

	/**
	 * @param Type: time
	 */
	public function setTimeAdded($TimeAdded){
		$this->TimeAdded = $TimeAdded;
	}

	/**
	 * @param Type: tinyint(1)
	 */
	public function setCompleted($Completed){
		$this->Completed = $Completed;
	}

	/**
	 * @param Type: date
	 */
	public function setDateCompleted($DateCompleted){
		$this->DateCompleted = $DateCompleted;
	}

	/**
	 * @param Type: time
	 */
	public function setTimeCompleted($TimeCompleted){
		$this->TimeCompleted = $TimeCompleted;
	}

	/**
	 * @param Type: int(5) unsigned
	 */
	public function setSortOrder($SortOrder){
		$this->SortOrder = $SortOrder;
	}

	/**
	 * @param Type: int(5) unsigned
	 */
	public function setGroupID($GroupID){
		$this->GroupID = $GroupID;
	}

	/**
	 * @param Type: tinyint(1)
	 */
	public function setShareWithGroup($ShareWithGroup){
		$this->ShareWithGroup = $ShareWithGroup;
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
			'OwnerID' => $this->getOwnerID(),
			'Task' => $this->getTask(),
			'DateAdded' => $this->getDateAdded(),
			'TimeAdded' => $this->getTimeAdded(),
			'Completed' => $this->getCompleted(),
			'DateCompleted' => $this->getDateCompleted(),
			'TimeCompleted' => $this->getTimeCompleted(),
			'SortOrder' => $this->getSortOrder(),
			'GroupID' => $this->getGroupID(),
			'ShareWithGroup' => $this->getShareWithGroup()		);
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
			'ID',			'OwnerID',			'Task',			'DateAdded',			'TimeAdded',			'Completed',			'DateCompleted',			'TimeCompleted',			'SortOrder',			'GroupID',			'ShareWithGroup'		);
		return $fieldNames;
	}
    /**
     * Close mysql connection
     */
	public function endv4_TodoList(){
		$this->connection->CloseMysql();
	}

}