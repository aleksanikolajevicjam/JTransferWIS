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

Class v4_SubVehicles {

	public $VehicleID; //int(10) unsigned
	public $OwnerID; //int(10) unsigned
	public $VehicleTypeID; //int(10) unsigned
	public $VehicleDescription; //text
	public $VehicleCapacity; //int(10) unsigned
	public $RaptorID; //int(10) unsigned
	public $Active; //tinyint(4)
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
	public function New_v4_SubVehicles($OwnerID,$VehicleTypeID,$VehicleDescription,$VehicleCapacity,$RaptorID,$Active){
		$this->OwnerID = $OwnerID;
		$this->VehicleTypeID = $VehicleTypeID;
		$this->VehicleDescription = $VehicleDescription;
		$this->VehicleCapacity = $VehicleCapacity;
		$this->RaptorID = $RaptorID;
		$this->Active = $Active;
	}

    /**
     * Load one row into var_class. To use the vars use for exemple echo $class->getVar_name; 
     *
     * @param key_table_type $key_row
     * 
     */
	public function getRow($key_row){
		$result = $this->connection->RunQuery("Select * from v4_SubVehicles where VehicleID = \"$key_row\" ");
		if($result->num_rows < 1) return false;
		while($row = $result->fetch_array(MYSQLI_ASSOC)){
			$this->VehicleID = $row["VehicleID"];
			$this->OwnerID = $row["OwnerID"];
			$this->VehicleTypeID = $row["VehicleTypeID"];
			$this->VehicleDescription = $row["VehicleDescription"];
			$this->VehicleCapacity = $row["VehicleCapacity"];
			$this->RaptorID = $row["RaptorID"];
			$this->Active = $row["Active"];
		}
	}

    /**
     * Delete the row by using the key as arg
     *
     * @param key_table_type $key_row
     *
     */
	public function deleteRow($key_row){
		$this->connection->RunQuery("DELETE FROM v4_SubVehicles WHERE VehicleID = $key_row");
	}

    /**
     * Update the active row table on table
     */
	public function saveRow(){
		$result = $this->connection->RunQuery("UPDATE v4_SubVehicles set 
OwnerID = '".$this->myreal_escape_string($this->OwnerID)."', 
VehicleTypeID = '".$this->myreal_escape_string($this->VehicleTypeID)."', 
VehicleDescription = '".$this->myreal_escape_string($this->VehicleDescription)."', 
VehicleCapacity = '".$this->myreal_escape_string($this->VehicleCapacity)."', 
RaptorID = '".$this->myreal_escape_string($this->RaptorID)."', 
Active = '".$this->myreal_escape_string($this->Active)."' WHERE VehicleID = '".$this->VehicleID."'");
	return $result; 
}

    /**
     * Save the active var class as a new row on table
     */
	public function saveAsNew(){
		$this->connection->RunQuery("INSERT INTO v4_SubVehicles (
			OwnerID, 
			VehicleTypeID, 
			VehicleDescription, 
			VehicleCapacity,
			RaptorID, 
			Active
		) values (
		'".$this->myreal_escape_string($this->OwnerID)."', 
		'".$this->myreal_escape_string($this->VehicleTypeID)."', 
		'".$this->myreal_escape_string($this->VehicleDescription)."', 
		'".$this->myreal_escape_string($this->VehicleCapacity)."', 
		'".$this->myreal_escape_string($this->RaptorID)."',
		'".$this->myreal_escape_string($this->Active)."')");
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
		$result = $this->connection->RunQuery("SELECT VehicleID from v4_SubVehicles $where ORDER BY $column $order");
			while($row = $result->fetch_array(MYSQLI_ASSOC)){
				$keys[$i] = $row["VehicleID"];
				$i++;
			}
	return $keys;
	}

	/**
	 * @return VehicleID - int(10) unsigned
	 */
	public function getVehicleID(){
		return $this->VehicleID;
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
	 * @return VehicleDescription - text
	 */
	public function getVehicleDescription(){
		return $this->VehicleDescription;
	}

	/**
	 * @return VehicleCapacity - int(10) unsigned
	 */
	public function getVehicleCapacity(){
		return $this->VehicleCapacity;
	}	
	/**
	 * @return RaptorID - int(10) unsigned
	 */
	public function getRaptorID(){
		return $this->RaptorID;
	}

	/**
	 * @return Active - tinyint(4)
	 */
	public function getActive(){
		return $this->Active;
	}

	/**
	 * @param Type: int(10) unsigned
	 */
	public function setVehicleID($VehicleID){
		$this->VehicleID = $VehicleID;
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
	 * @param Type: text
	 */
	public function setVehicleDescription($VehicleDescription){
		$this->VehicleDescription = $VehicleDescription;
	}

	/**
	 * @param Type: int(10) unsigned
	 */
	public function setVehicleCapacity($VehicleCapacity){
		$this->VehicleCapacity = $VehicleCapacity;
	}	
	/**
	 * @param Type: int(10) unsigned
	 */
	public function setRaptorID($RaptorID){
		$this->RaptorID = $RaptorID;
	}

	/**
	 * @param Type: tinyint(4)
	 */
	public function setActive($Active){
		$this->Active = $Active;
	}

    /**
     * fieldValues - Load all fieldNames and fieldValues into Array. 
     *
     * @param 
     * 
     */
	public function fieldValues(){
		$fieldValues = array(
			'VehicleID' => $this->getVehicleID(),
			'OwnerID' => $this->getOwnerID(),
			'VehicleTypeID' => $this->getVehicleTypeID(),
			'VehicleDescription' => $this->getVehicleDescription(),
			'VehicleCapacity' => $this->getVehicleCapacity(),
			'RaptorID' => $this->getRaptorID(),
			'Active' => $this->getActive()		);
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
			'VehicleID',			'OwnerID',			'VehicleTypeID',			'VehicleDescription',			'VehicleCapacity',			'VehicleCapacity',		'Active'		);
		return $fieldNames;
	}
    /**
     * Close mysql connection
     */
	public function endv4_SubVehicles(){
		$this->connection->CloseMysql();
	}

}