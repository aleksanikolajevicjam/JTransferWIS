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

Class v4_Surcharges {

	public $ID; //int(10) unsigned
	public $OwnerID; //int(10) unsigned
	public $VehicleID; //int(10) unsigned
	public $NgtStartHour; //varchar(5)
	public $NgtEndHour; //varchar(5)
	public $NgtSurcharge; //int(2)
	public $WkndSurcharge; //int(2)
	public $NgtAddPrice; //decimal(10,2) unsigned
	public $WkndAddPrice; //decimal(10,2) unsigned
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
	public function New_v4_Surcharges($ID,$NgtStartHour,$NgtEndHour,$NgtSurcharge,$WkndSurcharge,$NgtAddPrice,$WkndAddPrice){
		$this->ID = $ID;
		$this->NgtStartHour = $NgtStartHour;
		$this->NgtEndHour = $NgtEndHour;
		$this->NgtSurcharge = $NgtSurcharge;
		$this->WkndSurcharge = $WkndSurcharge;
		$this->NgtAddPrice = $NgtAddPrice;
		$this->WkndAddPrice = $WkndAddPrice;
	}

    /**
     * Load one row into var_class. To use the vars use for exemple echo $class->getVar_name; 
     *
     * @param key_table_type $key_row
     * 
     */
	public function getRow($key_row){
		$result = $this->connection->RunQuery("Select * from v4_Surcharges where OwnerID = \"$key_row\" ");
		if($result->num_rows < 1) return false;
		while($row = $result->fetch_array(MYSQLI_ASSOC)){
			$this->ID = $row["ID"];
			$this->OwnerID = $row["OwnerID"];
			$this->VehicleID = $row["VehicleID"];
			$this->NgtStartHour = $row["NgtStartHour"];
			$this->NgtEndHour = $row["NgtEndHour"];
			$this->NgtSurcharge = $row["NgtSurcharge"];
			$this->WkndSurcharge = $row["WkndSurcharge"];
			$this->NgtAddPrice = $row["NgtAddPrice"];
			$this->WkndAddPrice = $row["WkndAddPrice"];
		}
	}

    /**
     * Delete the row by using the key as arg
     *
     * @param key_table_type $key_row
     *
     */
	public function deleteRow($key_row){
		$this->connection->RunQuery("DELETE FROM v4_Surcharges WHERE OwnerID = $key_row");
	}

    /**
     * Update the active row table on table
     */
	public function saveRow(){
		$result = $this->connection->RunQuery("UPDATE v4_Surcharges set 
ID = '".$this->myreal_escape_string($this->ID)."', 
NgtStartHour = '".$this->myreal_escape_string($this->NgtStartHour)."', 
NgtEndHour = '".$this->myreal_escape_string($this->NgtEndHour)."', 
NgtSurcharge = '".$this->myreal_escape_string($this->NgtSurcharge)."', 
WkndSurcharge = '".$this->myreal_escape_string($this->WkndSurcharge)."', 
NgtAddPrice = '".$this->myreal_escape_string($this->NgtAddPrice)."', 
WkndAddPrice = '".$this->myreal_escape_string($this->WkndAddPrice)."' WHERE OwnerID = '".$this->OwnerID."'");
	return $result; 
}

    /**
     * Save the active var class as a new row on table
     */
	public function saveAsNew(){
		$this->connection->RunQuery("INSERT INTO v4_Surcharges (ID, NgtStartHour, NgtEndHour, NgtSurcharge, WkndSurcharge, NgtAddPrice, WkndAddPrice) values ('".$this->myreal_escape_string($this->ID)."', '".$this->myreal_escape_string($this->NgtStartHour)."', '".$this->myreal_escape_string($this->NgtEndHour)."', '".$this->myreal_escape_string($this->NgtSurcharge)."', '".$this->myreal_escape_string($this->WkndSurcharge)."', '".$this->myreal_escape_string($this->NgtAddPrice)."', '".$this->myreal_escape_string($this->WkndAddPrice)."')");
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
		$result = $this->connection->RunQuery("SELECT OwnerID from v4_Surcharges $where ORDER BY $column $order");
			while($row = $result->fetch_array(MYSQLI_ASSOC)){
				$keys[$i] = $row["OwnerID"];
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
	 * @return NgtStartHour - varchar(5)
	 */
	public function getNgtStartHour(){
		return $this->NgtStartHour;
	}

	/**
	 * @return NgtEndHour - varchar(5)
	 */
	public function getNgtEndHour(){
		return $this->NgtEndHour;
	}

	/**
	 * @return NgtSurcharge - int(2)
	 */
	public function getNgtSurcharge(){
		return $this->NgtSurcharge;
	}

	/**
	 * @return WkndSurcharge - int(2)
	 */
	public function getWkndSurcharge(){
		return $this->WkndSurcharge;
	}

	/**
	 * @return NgtAddPrice - decimal(10,2) unsigned
	 */
	public function getNgtAddPrice(){
		return $this->NgtAddPrice;
	}

	/**
	 * @return WkndAddPrice - decimal(10,2) unsigned
	 */
	public function getWkndAddPrice(){
		return $this->WkndAddPrice;
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
	 * @param Type: varchar(5)
	 */
	public function setNgtStartHour($NgtStartHour){
		$this->NgtStartHour = $NgtStartHour;
	}

	/**
	 * @param Type: varchar(5)
	 */
	public function setNgtEndHour($NgtEndHour){
		$this->NgtEndHour = $NgtEndHour;
	}

	/**
	 * @param Type: int(2)
	 */
	public function setNgtSurcharge($NgtSurcharge){
		$this->NgtSurcharge = $NgtSurcharge;
	}

	/**
	 * @param Type: int(2)
	 */
	public function setWkndSurcharge($WkndSurcharge){
		$this->WkndSurcharge = $WkndSurcharge;
	}

	/**
	 * @param Type: decimal(10,2) unsigned
	 */
	public function setNgtAddPrice($NgtAddPrice){
		$this->NgtAddPrice = $NgtAddPrice;
	}

	/**
	 * @param Type: decimal(10,2) unsigned
	 */
	public function setWkndAddPrice($WkndAddPrice){
		$this->WkndAddPrice = $WkndAddPrice;
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
			'NgtStartHour' => $this->getNgtStartHour(),
			'NgtEndHour' => $this->getNgtEndHour(),
			'NgtSurcharge' => $this->getNgtSurcharge(),
			'WkndSurcharge' => $this->getWkndSurcharge(),
			'NgtAddPrice' => $this->getNgtAddPrice(),
			'WkndAddPrice' => $this->getWkndAddPrice()		);
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
			'ID',			'OwnerID',			'VehicleID',			'NgtStartHour',			'NgtEndHour',			'NgtSurcharge',			'WkndSurcharge',			'NgtAddPrice',			'WkndAddPrice'		);
		return $fieldNames;
	}
    /**
     * Close mysql connection
     */
	public function endv4_Surcharges(){
		$this->connection->CloseMysql();
	}

}