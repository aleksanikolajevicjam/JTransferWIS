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

Class v4_SpecialTimes {

	public $ID; //int(10) unsigned
	public $OwnerID; //int(10) unsigned
	public $VehicleTypeID; //int(10) unsigned
	public $StartSeason; //varchar(10)
	public $EndSeason; //varchar(10)
	public $WeekDays; //varchar(10)
	public $SpecialDate; //varchar(10)
	public $StartTime; //varchar(10)
	public $EndTime; //varchar(10)
	public $CorrectionPercent; //decimal(5,2)
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
	public function New_v4_SpecialTimes($OwnerID,$VehicleTypeID,$StartSeason,$EndSeason,$WeekDays,$SpecialDate,$StartTime,$EndTime,$CorrectionPercent){
		$this->OwnerID = $OwnerID;
		$this->VehicleTypeID = $VehicleTypeID;	
		$this->StartSeason = $StartSeason;
		$this->EndSeason = $EndSeason;	
		$this->WeekDays = $WeekDays;	
		$this->SpecialDate = $SpecialDate;
		$this->StartTime = $StartTime;
		$this->EndTime = $EndTime;
		$this->CorrectionPercent = $CorrectionPercent;
	}

    /**
     * Load one row into var_class. To use the vars use for exemple echo $class->getVar_name; 
     *
     * @param key_table_type $key_row
     * 
     */
	public function getRow($key_row){
		$result = $this->connection->RunQuery("Select * from v4_SpecialTimes where ID = \"$key_row\" ");
		if($result->num_rows < 1) return false;
		while($row = $result->fetch_array(MYSQLI_ASSOC)){
			$this->ID = $row["ID"];
			$this->OwnerID = $row["OwnerID"];
			$this->VehicleTypeID = $row["VehicleTypeID"];		
			$this->StartSeason = $row["StartSeason"];
			$this->EndSeason = $row["EndSeason"];
			$this->WeekDays = $row["WeekDays"];
			$this->SpecialDate = $row["SpecialDate"];
			$this->StartTime = $row["StartTime"];
			$this->EndTime = $row["EndTime"];
			$this->CorrectionPercent = $row["CorrectionPercent"];
		}
	}

    /**
     * Delete the row by using the key as arg
     *
     * @param key_table_type $key_row
     *
     */
	public function deleteRow($key_row){
		$this->connection->RunQuery("DELETE FROM v4_SpecialTimes WHERE ID = $key_row");
	}

    /**
     * Update the active row table on table
     */
	public function saveRow(){
		$result = $this->connection->RunQuery("UPDATE v4_SpecialTimes set 
OwnerID = '".$this->myreal_escape_string($this->OwnerID)."', 
VehicleTypeID = '".$this->myreal_escape_string($this->VehicleTypeID)."', 
StartSeason = '".$this->myreal_escape_string($this->StartSeason)."', 
EndSeason = '".$this->myreal_escape_string($this->EndSeason)."', 
WeekDays = '".$this->myreal_escape_string($this->WeekDays)."', 
SpecialDate = '".$this->myreal_escape_string($this->SpecialDate)."', 
StartTime = '".$this->myreal_escape_string($this->StartTime)."', 
EndTime = '".$this->myreal_escape_string($this->EndTime)."', 
CorrectionPercent = '".$this->myreal_escape_string($this->CorrectionPercent)."' WHERE ID = '".$this->ID."'");
	return $result; 
}

    /**
     * Save the active var class as a new row on table
     */
	public function saveAsNew(){
		$this->connection->RunQuery("INSERT INTO v4_SpecialTimes (OwnerID, VehicleTypeID, StartSeason, EndSeason, WeekDays, SpecialDate, StartTime, EndTime, CorrectionPercent) 
			values (
				'".$this->myreal_escape_string($this->OwnerID)."', 
				'".$this->myreal_escape_string($this->VehicleTypeID)."',
				'".$this->myreal_escape_string($this->StartSeason)."', 
				'".$this->myreal_escape_string($this->EndSeason)."', 
				'".$this->myreal_escape_string($this->WeekDays)."', 
				'".$this->myreal_escape_string($this->SpecialDate)."', 
				'".$this->myreal_escape_string($this->StartTime)."', 
				'".$this->myreal_escape_string($this->EndTime)."', 
				'".$this->myreal_escape_string($this->CorrectionPercent)."'
			)
		");
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
		$result = $this->connection->RunQuery("SELECT ID from v4_SpecialTimes $where ORDER BY $column $order");
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
	 * @return VehicleTypeID - int(10) unsigned
	 */
	public function getVehicleTypeID(){
		return $this->VehicleTypeID;
	}

	/**
	 * @return StartSeason - varchar(10)
	 */
	public function getStartSeason(){
		return $this->StartSeason;
	}	
	
	/**
	 * @return EndSeason - varchar(10)
	 */
	public function getEndSeason(){
		return $this->EndSeason;
	}	
	
	/**
	 * @return WeekDays - varchar(10)
	 */
	public function getWeekDays(){
		return $this->WeekDays;
	}	
	
	/**
	 * @return SpecialDate - varchar(10)
	 */
	public function getSpecialDate(){
		return $this->SpecialDate;
	}

	/**
	 * @return StartTime - varchar(10)
	 */
	public function getStartTime(){
		return $this->StartTime;
	}

	/**
	 * @return EndTime - varchar(10)
	 */
	public function getEndTime(){
		return $this->EndTime;
	}

	/**
	 * @return CorrectionPercent - decimal(5,2)
	 */
	public function getCorrectionPercent(){
		return $this->CorrectionPercent;
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
	public function setVehicleTypeID($VehicleTypeID){
		$this->VehicleTypeID = $VehicleTypeID;
	}

	/**
	 * @param Type: varchar(10)
	 */
	public function setStartSeason($StartSeason){
		$this->StartSeason = $StartSeason;
	}

	/**
	 * @param Type: varchar(10)
	 */
	public function setEndSeason($EndSeason){
		$this->EndSeason = $EndSeason;
	}

	/**
	 * @param Type: varchar(10)
	 */
	public function setWeekDays($WeekDays){
		$this->WeekDays = $WeekDays;
	}

	/**
	 * @param Type: varchar(10)
	 */
	public function setSpecialDate($SpecialDate){
		$this->SpecialDate = $SpecialDate;
	}

	/**
	 * @param Type: varchar(10)
	 */
	public function setStartTime($StartTime){
		$this->StartTime = $StartTime;
	}

	/**
	 * @param Type: varchar(10)
	 */
	public function setEndTime($EndTime){
		$this->EndTime = $EndTime;
	}

	/**
	 * @param Type: decimal(5,2)
	 */
	public function setCorrectionPercent($CorrectionPercent){
		$this->CorrectionPercent = $CorrectionPercent;
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
			'VehicleTypeID' => $this->getVehicleTypeID(),
			'StartSeason' => $this->getStartSeason(),
			'EndSeason' => $this->getEndSeason(),
			'WeekDays' => $this->getWeekDays(),
			'SpecialDate' => $this->getSpecialDate(),
			'StartTime' => $this->getStartTime(),
			'EndTime' => $this->getEndTime(),
			'CorrectionPercent' => $this->getCorrectionPercent()		);
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
			'ID',			'OwnerID',			'VehicleTypeID',		'StartSeason',		'EndSeason',		'WeekDays',		'SpecialDate',			'StartTime',			'EndTime',			'CorrectionPercent'		);
		return $fieldNames;
	}
    /**
     * Close mysql connection
     */
	public function endv4_SpecialTimes(){
		$this->connection->CloseMysql();
	}

}