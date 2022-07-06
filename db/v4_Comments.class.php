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

Class v4_Comments {

	public $ID; //int(10) unsigned
	public $OwnerID; //int(10) unsigned
	public $Comment; //text
	public $Author; //varchar(255)
	public $EntryTime; //varchar(50)
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
	public function New_v4_Comments($OwnerID,$Comment,$Author,$EntryTime){
		$this->OwnerID = $OwnerID;
		$this->Comment = $Comment;
		$this->Author = $Author;
		$this->EntryTime = $EntryTime;
	}

    /**
     * Load one row into var_class. To use the vars use for exemple echo $class->getVar_name; 
     *
     * @param key_table_type $key_row
     * 
     */
	public function getRow($key_row){
		$result = $this->connection->RunQuery("Select * from v4_Comments where ID = \"$key_row\" ");
		if($result->num_rows < 1) return false;
		while($row = $result->fetch_array(MYSQLI_ASSOC)){
			$this->ID = $row["ID"];
			$this->OwnerID = $row["OwnerID"];
			$this->Comment = $row["Comment"];
			$this->Author = $row["Author"];
			$this->EntryTime = $row["EntryTime"];
		}
	}

    /**
     * Delete the row by using the key as arg
     *
     * @param key_table_type $key_row
     *
     */
	public function deleteRow($key_row){
		$this->connection->RunQuery("DELETE FROM v4_Comments WHERE ID = $key_row");
	}

    /**
     * Update the active row table on table
     */
	public function saveRow(){
		$result = $this->connection->RunQuery("UPDATE v4_Comments set 
OwnerID = '".$this->myreal_escape_string($this->OwnerID)."', 
Comment = '".$this->myreal_escape_string($this->Comment)."', 
Author = '".$this->myreal_escape_string($this->Author)."', 
EntryTime = '".$this->myreal_escape_string($this->EntryTime)."' WHERE ID = '".$this->ID."'");
	return $result; 
}

    /**
     * Save the active var class as a new row on table
     */
	public function saveAsNew(){
		$this->connection->RunQuery("INSERT INTO v4_Comments (OwnerID, Comment, Author, EntryTime) values ('".$this->myreal_escape_string($this->OwnerID)."', '".$this->myreal_escape_string($this->Comment)."', '".$this->myreal_escape_string($this->Author)."', '".$this->myreal_escape_string($this->EntryTime)."')");
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
		$result = $this->connection->RunQuery("SELECT ID from v4_Comments $where ORDER BY $column $order");
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
	 * @return Comment - text
	 */
	public function getComment(){
		return $this->Comment;
	}

	/**
	 * @return Author - varchar(255)
	 */
	public function getAuthor(){
		return $this->Author;
	}

	/**
	 * @return EntryTime - varchar(50)
	 */
	public function getEntryTime(){
		return $this->EntryTime;
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
	 * @param Type: text
	 */
	public function setComment($Comment){
		$this->Comment = $Comment;
	}

	/**
	 * @param Type: varchar(255)
	 */
	public function setAuthor($Author){
		$this->Author = $Author;
	}

	/**
	 * @param Type: varchar(50)
	 */
	public function setEntryTime($EntryTime){
		$this->EntryTime = $EntryTime;
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
			'Comment' => $this->getComment(),
			'Author' => $this->getAuthor(),
			'EntryTime' => $this->getEntryTime()		);
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
			'ID',			'OwnerID',			'Comment',			'Author',			'EntryTime'		);
		return $fieldNames;
	}
    /**
     * Close mysql connection
     */
	public function endv4_Comments(){
		$this->connection->CloseMysql();
	}

}