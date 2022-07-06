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

Class v4_MyDrivers {

	public $OwnerID; //int(10) unsigned
	public $DriverID; //int(10) unsigned
	public $DriverName; //varchar(100)
	public $DriverPassword; //varchar(32)
	public $DriverEmail; //varchar(100)
	public $DriverTel; //varchar(50)
	public $Notes; //text
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
	public function New_v4_MyDrivers($OwnerID,$DriverName,$DriverPassword,$DriverEmail,$DriverTel,$Notes){
		$this->OwnerID = $OwnerID;
		$this->DriverName = $DriverName;
		$this->DriverPassword = $DriverPassword;
		$this->DriverEmail = $DriverEmail;
		$this->DriverTel = $DriverTel;
		$this->Notes = $Notes;
	}

    /**
     * Load one row into var_class. To use the vars use for exemple echo $class->getVar_name; 
     *
     * @param key_table_type $key_row
     * 
     */
	public function getRow($key_row){
		$result = $this->connection->RunQuery("Select * from v4_MyDrivers where DriverID = \"$key_row\" ");
		if($result->num_rows < 1) return false;
		while($row = $result->fetch_array(MYSQLI_ASSOC)){
			$this->OwnerID = $row["OwnerID"];
			$this->DriverID = $row["DriverID"];
			$this->DriverName = $row["DriverName"];
			$this->DriverPassword = $row["DriverPassword"];
			$this->DriverEmail = $row["DriverEmail"];
			$this->DriverTel = $row["DriverTel"];
			$this->Notes = $row["Notes"];
		}
	}

    /**
     * Delete the row by using the key as arg
     *
     * @param key_table_type $key_row
     *
     */
	public function deleteRow($key_row){
		$this->connection->RunQuery("DELETE FROM v4_MyDrivers WHERE DriverID = $key_row");
	}

    /**
     * Update the active row table on table
     */
	public function saveRow(){
		$result = $this->connection->RunQuery("UPDATE v4_MyDrivers set 
OwnerID = '".$this->myreal_escape_string($this->OwnerID)."', 
DriverName = '".$this->myreal_escape_string($this->DriverName)."', 
DriverPassword = '".$this->myreal_escape_string($this->DriverPassword)."', 
DriverEmail = '".$this->myreal_escape_string($this->DriverEmail)."', 
DriverTel = '".$this->myreal_escape_string($this->DriverTel)."', 
Notes = '".$this->myreal_escape_string($this->Notes)."' WHERE DriverID = '".$this->DriverID."'");
	return $result; 
}

    /**
     * Save the active var class as a new row on table
     */
	public function saveAsNew(){
		$this->connection->RunQuery("INSERT INTO v4_MyDrivers (OwnerID, DriverName, DriverPassword, DriverEmail, DriverTel, Notes) values ('".$this->myreal_escape_string($this->OwnerID)."', '".$this->myreal_escape_string($this->DriverName)."', '".$this->myreal_escape_string($this->DriverPassword)."', '".$this->myreal_escape_string($this->DriverEmail)."', '".$this->myreal_escape_string($this->DriverTel)."', '".$this->myreal_escape_string($this->Notes)."')");
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
		$result = $this->connection->RunQuery("SELECT DriverID from v4_MyDrivers $where ORDER BY $column $order");
			while($row = $result->fetch_array(MYSQLI_ASSOC)){
				$keys[$i] = $row["DriverID"];
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
	 * @return DriverID - int(10) unsigned
	 */
	public function getDriverID(){
		return $this->DriverID;
	}

	/**
	 * @return DriverName - varchar(100)
	 */
	public function getDriverName(){
		return $this->DriverName;
	}

	/**
	 * @return DriverPassword - varchar(32)
	 */
	public function getDriverPassword(){
		return $this->DriverPassword;
	}

	/**
	 * @return DriverEmail - varchar(100)
	 */
	public function getDriverEmail(){
		return $this->DriverEmail;
	}

	/**
	 * @return DriverTel - varchar(50)
	 */
	public function getDriverTel(){
		return $this->DriverTel;
	}

	/**
	 * @return Notes - text
	 */
	public function getNotes(){
		return $this->Notes;
	}

	/**
	 * @param Type: int(10) unsigned
	 */
	public function setOwnerID($OwnerID){
		$this->OwnerID = $OwnerID;
	}

	/**
	 * @param Type: int(10) unsigned
	 */
	public function setDriverID($DriverID){
		$this->DriverID = $DriverID;
	}

	/**
	 * @param Type: varchar(100)
	 */
	public function setDriverName($DriverName){
		$this->DriverName = $DriverName;
	}

	/**
	 * @param Type: varchar(32)
	 */
	public function setDriverPassword($DriverPassword){
		$this->DriverPassword = $DriverPassword;
	}

	/**
	 * @param Type: varchar(100)
	 */
	public function setDriverEmail($DriverEmail){
		$this->DriverEmail = $DriverEmail;
	}

	/**
	 * @param Type: varchar(50)
	 */
	public function setDriverTel($DriverTel){
		$this->DriverTel = $DriverTel;
	}

	/**
	 * @param Type: text
	 */
	public function setNotes($Notes){
		$this->Notes = $Notes;
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
			'DriverID' => $this->getDriverID(),
			'DriverName' => $this->getDriverName(),
			'DriverPassword' => $this->getDriverPassword(),
			'DriverEmail' => $this->getDriverEmail(),
			'DriverTel' => $this->getDriverTel(),
			'Notes' => $this->getNotes()		);
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
			'OwnerID',			'DriverID',			'DriverName',			'DriverPassword',			'DriverEmail',			'DriverTel',			'Notes'		);
		return $fieldNames;
	}
    /**
     * Close mysql connection
     */
	public function endv4_MyDrivers(){
		$this->connection->CloseMysql();
	}

}