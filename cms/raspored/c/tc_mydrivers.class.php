<?php
/*
 * Author: Rafael Rocha - www.rafaelrocha.net - info@rafaelrocha.net
 * 
 * Create Date: 9-04-2013
 * 
 * Version of MYSQL_to_PHP: 1.1
 * 
 * License: LGPL 
 * 
 */
require_once 'db.class.php';

Class SubDrivers {

	private $OwnerID; //int(10) unsigned
	private $DriverID; //int(10) unsigned
	private $DriverName; //varchar(100)
	private $DriverPassword; //varchar(32)
	private $DriverEmail; //varchar(100)
	private $DriverTel; //varchar(50)
	private $Notes; //text
	private $connection;

	public function SubDrivers(){
		$this->connection = new DataBaseMysql();
	}

    /**
     * New object to the class. Don´t forget to save this new object "as new" by using the function $class->saveAsNew(); 
     *
     */
	public function New_SubDrivers($OwnerID,$DriverName,$DriverPassword,$DriverEmail,$DriverTel,$Notes){
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
		$result = $this->connection->RunQuery("Select * from SubDrivers where DriverID = \"$key_row\" ");
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
		$this->connection->RunQuery("DELETE FROM SubDrivers WHERE DriverID = $key_row");
	}

    /**
     * Update the active row table on table
     */
	public function saveRow(){
		$this->connection->RunQuery("UPDATE SubDrivers set OwnerID = \"$this->OwnerID\", DriverName = \"$this->DriverName\", DriverPassword = \"$this->DriverPassword\", DriverEmail = \"$this->DriverEmail\", DriverTel = \"$this->DriverTel\", Notes = \"$this->Notes\" where DriverID = \"$this->DriverID\"");
	}

    /**
     * Save the active var class as a new row on table
     */
	public function saveAsNew(){
		$this->connection->RunQuery("Insert into SubDrivers (OwnerID, DriverName, DriverPassword, DriverEmail, DriverTel, Notes) values (\"$this->OwnerID\", \"$this->DriverName\", \"$this->DriverPassword\", \"$this->DriverEmail\", \"$this->DriverTel\", \"$this->Notes\")");
	}

    /**
     * Returns array of keys order by $column -> name of column $order -> desc or acs
     *
     * @param string $column
     * @param string $order
     */
	public function getKeysBy($column, $order, $where = NULL){
		$keys = array(); $i = 0;
		$result = $this->connection->RunQuery("SELECT DriverID from SubDrivers $where ORDER BY $column $order");
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
     * Close mysql connection
     */
	public function endSubDrivers(){
		$this->connection->CloseMysql();
	}

}
