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

Class v4_OffDuty {

	public $ID; //int(10) unsigned
	public $OwnerID; //int(10) unsigned
	public $VehicleID; //int(10) unsigned
	public $StartDate; //varchar(12)
	public $StartTime; //varchar(5)
	public $EndDate; //varchar(12)
	public $EndTime; //varchar(5)
	public $Reason; //varchar(255)
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
	public function New_v4_OffDuty($OwnerID,$VehicleID,$StartDate,$StartTime,$EndDate,$EndTime,$Reason){
		$this->OwnerID = $OwnerID;
		$this->VehicleID = $VehicleID;
		$this->StartDate = $StartDate;
		$this->StartTime = $StartTime;
		$this->EndDate = $EndDate;
		$this->EndTime = $EndTime;
		$this->Reason = $Reason;
	}

    /**
     * Load one row into var_class. To use the vars use for exemple echo $class->getVar_name; 
     *
     * @param key_table_type $key_row
     * 
     */
	public function getRow($key_row){
		$result = $this->connection->RunQuery("Select * from v4_OffDuty where ID = \"$key_row\" ");
		if($result->num_rows < 1) return false;
		while($row = $result->fetch_array(MYSQLI_ASSOC)){
			$this->ID = $row["ID"];
			$this->OwnerID = $row["OwnerID"];
			$this->VehicleID = $row["VehicleID"];
			$this->StartDate = $row["StartDate"];
			$this->StartTime = $row["StartTime"];
			$this->EndDate = $row["EndDate"];
			$this->EndTime = $row["EndTime"];
			$this->Reason = $row["Reason"];
		}
	}

    /**
     * Delete the row by using the key as arg
     *
     * @param key_table_type $key_row
     *
     */
	public function deleteRow($key_row){
		$this->connection->RunQuery("DELETE FROM v4_OffDuty WHERE ID = $key_row");
	}

    /**
     * Update the active row table on table
     */
	public function saveRow(){
		$result = $this->connection->RunQuery("UPDATE v4_OffDuty set 
OwnerID = '".$this->myreal_escape_string($this->OwnerID)."', 
VehicleID = '".$this->myreal_escape_string($this->VehicleID)."', 
StartDate = '".$this->myreal_escape_string($this->StartDate)."', 
StartTime = '".$this->myreal_escape_string($this->StartTime)."', 
EndDate = '".$this->myreal_escape_string($this->EndDate)."', 
EndTime = '".$this->myreal_escape_string($this->EndTime)."', 
Reason = '".$this->myreal_escape_string($this->Reason)."' WHERE ID = '".$this->ID."'");
	return $result; 
}

    /**
     * Save the active var class as a new row on table
     */
	public function saveAsNew(){
		$this->connection->RunQuery("INSERT INTO v4_OffDuty (OwnerID, VehicleID, StartDate, StartTime, EndDate, EndTime, Reason) values ('".$this->myreal_escape_string($this->OwnerID)."', '".$this->myreal_escape_string($this->VehicleID)."', '".$this->myreal_escape_string($this->StartDate)."', '".$this->myreal_escape_string($this->StartTime)."', '".$this->myreal_escape_string($this->EndDate)."', '".$this->myreal_escape_string($this->EndTime)."', '".$this->myreal_escape_string($this->Reason)."')");
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
		$result = $this->connection->RunQuery("SELECT ID from v4_OffDuty $where ORDER BY $column $order");
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
	 * @return VehicleID - int(10) unsigned
	 */
	public function getVehicleID(){
		return $this->VehicleID;
	}

	/**
	 * @return StartDate - varchar(12)
	 */
	public function getStartDate(){
		return $this->StartDate;
	}

	/**
	 * @return StartTime - varchar(5)
	 */
	public function getStartTime(){
		return $this->StartTime;
	}

	/**
	 * @return EndDate - varchar(12)
	 */
	public function getEndDate(){
		return $this->EndDate;
	}

	/**
	 * @return EndTime - varchar(5)
	 */
	public function getEndTime(){
		return $this->EndTime;
	}

	/**
	 * @return Reason - varchar(255)
	 */
	public function getReason(){
		return $this->Reason;
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
	 * @param Type: int(10) unsigned
	 */
	public function setVehicleID($VehicleID){
		$this->VehicleID = $VehicleID;
	}

	/**
	 * @param Type: varchar(12)
	 */
	public function setStartDate($StartDate){
		$this->StartDate = $StartDate;
	}

	/**
	 * @param Type: varchar(5)
	 */
	public function setStartTime($StartTime){
		$this->StartTime = $StartTime;
	}

	/**
	 * @param Type: varchar(12)
	 */
	public function setEndDate($EndDate){
		$this->EndDate = $EndDate;
	}

	/**
	 * @param Type: varchar(5)
	 */
	public function setEndTime($EndTime){
		$this->EndTime = $EndTime;
	}

	/**
	 * @param Type: varchar(255)
	 */
	public function setReason($Reason){
		$this->Reason = $Reason;
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
			'VehicleID' => $this->getVehicleID(),
			'StartDate' => $this->getStartDate(),
			'StartTime' => $this->getStartTime(),
			'EndDate' => $this->getEndDate(),
			'EndTime' => $this->getEndTime(),
			'Reason' => $this->getReason()		);
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
			'ID',			'OwnerID',			'VehicleID',			'StartDate',			'StartTime',			'EndDate',			'EndTime',			'Reason'		);
		return $fieldNames;
	}
    /**
     * Close mysql connection
     */
	public function endv4_OffDuty(){
		$this->connection->CloseMysql();
	}

}