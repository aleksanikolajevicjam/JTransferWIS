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

Class v4_DriverPrices {

	public $DriverID; //int(10) unsigned
	public $FromName; //varchar(255)
	public $FromNameEN; //varchar(255)
	public $FromNameRU; //varchar(255)
	public $FromNameFR; //varchar(255)
	public $FromNameDE; //varchar(255)
	public $FromNameIT; //varchar(255)
	public $TerminalID; //int(10) unsigned
	public $ToName; //varchar(255)
	public $ToNameEN; //varchar(255)
	public $ToNameRU; //varchar(255)
	public $ToNameFR; //varchar(255)
	public $ToNameDE; //varchar(255)
	public $ToNameIT; //varchar(255)
	public $DestinationID; //int(10) unsigned
	public $RouteID; //int(10) unsigned
	public $VehicleTypeID; //int(10) unsigned
	public $SinglePrice; //decimal(10,2) unsigned
	public $ReturnPrice; //decimal(10,2) unsigned
	public $ID; //int(10) unsigned
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
	public function New_v4_DriverPrices($DriverID,$FromName,$FromNameEN,$FromNameRU,$FromNameFR,$FromNameDE,$FromNameIT,$TerminalID,$ToName,$ToNameEN,$ToNameRU,$ToNameFR,$ToNameDE,$ToNameIT,$DestinationID,$RouteID,$VehicleTypeID,$SinglePrice,$ReturnPrice){
		$this->DriverID = $DriverID;
		$this->FromName = $FromName;
		$this->FromNameEN = $FromNameEN;
		$this->FromNameRU = $FromNameRU;
		$this->FromNameFR = $FromNameFR;
		$this->FromNameDE = $FromNameDE;
		$this->FromNameIT = $FromNameIT;
		$this->TerminalID = $TerminalID;
		$this->ToName = $ToName;
		$this->ToNameEN = $ToNameEN;
		$this->ToNameRU = $ToNameRU;
		$this->ToNameFR = $ToNameFR;
		$this->ToNameDE = $ToNameDE;
		$this->ToNameIT = $ToNameIT;
		$this->DestinationID = $DestinationID;
		$this->RouteID = $RouteID;
		$this->VehicleTypeID = $VehicleTypeID;
		$this->SinglePrice = $SinglePrice;
		$this->ReturnPrice = $ReturnPrice;
	}

    /**
     * Load one row into var_class. To use the vars use for exemple echo $class->getVar_name; 
     *
     * @param key_table_type $key_row
     * 
     */
	public function getRow($key_row){
		$result = $this->connection->RunQuery("Select * from v4_DriverPrices where ID = \"$key_row\" ");
		if($result->num_rows < 1) return false;
		while($row = $result->fetch_array(MYSQLI_ASSOC)){
			$this->DriverID = $row["DriverID"];
			$this->FromName = $row["FromName"];
			$this->FromNameEN = $row["FromNameEN"];
			$this->FromNameRU = $row["FromNameRU"];
			$this->FromNameFR = $row["FromNameFR"];
			$this->FromNameDE = $row["FromNameDE"];
			$this->FromNameIT = $row["FromNameIT"];
			$this->TerminalID = $row["TerminalID"];
			$this->ToName = $row["ToName"];
			$this->ToNameEN = $row["ToNameEN"];
			$this->ToNameRU = $row["ToNameRU"];
			$this->ToNameFR = $row["ToNameFR"];
			$this->ToNameDE = $row["ToNameDE"];
			$this->ToNameIT = $row["ToNameIT"];
			$this->DestinationID = $row["DestinationID"];
			$this->RouteID = $row["RouteID"];
			$this->VehicleTypeID = $row["VehicleTypeID"];
			$this->SinglePrice = $row["SinglePrice"];
			$this->ReturnPrice = $row["ReturnPrice"];
			$this->ID = $row["ID"];
		}
	}

    /**
     * Delete the row by using the key as arg
     *
     * @param key_table_type $key_row
     *
     */
	public function deleteRow($key_row){
		$this->connection->RunQuery("DELETE FROM v4_DriverPrices WHERE ID = $key_row");
	}

    /**
     * Update the active row table on table
     */
	public function saveRow(){
		$result = $this->connection->RunQuery("UPDATE v4_DriverPrices set 
DriverID = '".$this->myreal_escape_string($this->DriverID)."', 
FromName = '".$this->myreal_escape_string($this->FromName)."', 
FromNameEN = '".$this->myreal_escape_string($this->FromNameEN)."', 
FromNameRU = '".$this->myreal_escape_string($this->FromNameRU)."', 
FromNameFR = '".$this->myreal_escape_string($this->FromNameFR)."', 
FromNameDE = '".$this->myreal_escape_string($this->FromNameDE)."', 
FromNameIT = '".$this->myreal_escape_string($this->FromNameIT)."', 
TerminalID = '".$this->myreal_escape_string($this->TerminalID)."', 
ToName = '".$this->myreal_escape_string($this->ToName)."', 
ToNameEN = '".$this->myreal_escape_string($this->ToNameEN)."', 
ToNameRU = '".$this->myreal_escape_string($this->ToNameRU)."', 
ToNameFR = '".$this->myreal_escape_string($this->ToNameFR)."', 
ToNameDE = '".$this->myreal_escape_string($this->ToNameDE)."', 
ToNameIT = '".$this->myreal_escape_string($this->ToNameIT)."', 
DestinationID = '".$this->myreal_escape_string($this->DestinationID)."', 
RouteID = '".$this->myreal_escape_string($this->RouteID)."', 
VehicleTypeID = '".$this->myreal_escape_string($this->VehicleTypeID)."', 
SinglePrice = '".$this->myreal_escape_string($this->SinglePrice)."', 
ReturnPrice = '".$this->myreal_escape_string($this->ReturnPrice)."', 
 WHERE ID = '".$this->ID."'");
	return $result; 
}

    /**
     * Save the active var class as a new row on table
     */
	public function saveAsNew(){
		$this->connection->RunQuery("INSERT INTO v4_DriverPrices (DriverID, FromName, FromNameEN, FromNameRU, FromNameFR, FromNameDE, FromNameIT, TerminalID, ToName, ToNameEN, ToNameRU, ToNameFR, ToNameDE, ToNameIT, DestinationID, RouteID, VehicleTypeID, SinglePrice, ReturnPrice, ) values ('".$this->myreal_escape_string($this->DriverID)."', '".$this->myreal_escape_string($this->FromName)."', '".$this->myreal_escape_string($this->FromNameEN)."', '".$this->myreal_escape_string($this->FromNameRU)."', '".$this->myreal_escape_string($this->FromNameFR)."', '".$this->myreal_escape_string($this->FromNameDE)."', '".$this->myreal_escape_string($this->FromNameIT)."', '".$this->myreal_escape_string($this->TerminalID)."', '".$this->myreal_escape_string($this->ToName)."', '".$this->myreal_escape_string($this->ToNameEN)."', '".$this->myreal_escape_string($this->ToNameRU)."', '".$this->myreal_escape_string($this->ToNameFR)."', '".$this->myreal_escape_string($this->ToNameDE)."', '".$this->myreal_escape_string($this->ToNameIT)."', '".$this->myreal_escape_string($this->DestinationID)."', '".$this->myreal_escape_string($this->RouteID)."', '".$this->myreal_escape_string($this->VehicleTypeID)."', '".$this->myreal_escape_string($this->SinglePrice)."', '".$this->myreal_escape_string($this->ReturnPrice)."', )");
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
		$result = $this->connection->RunQuery("SELECT ID from v4_DriverPrices $where ORDER BY $column $order");
			while($row = $result->fetch_array(MYSQLI_ASSOC)){
				$keys[$i] = $row["ID"];
				$i++;
			}
	return $keys;
	}

	/**
	 * @return DriverID - int(10) unsigned
	 */
	public function getDriverID(){
		return $this->DriverID;
	}

	/**
	 * @return FromName - varchar(255)
	 */
	public function getFromName(){
		return $this->FromName;
	}

	/**
	 * @return FromNameEN - varchar(255)
	 */
	public function getFromNameEN(){
		return $this->FromNameEN;
	}

	/**
	 * @return FromNameRU - varchar(255)
	 */
	public function getFromNameRU(){
		return $this->FromNameRU;
	}

	/**
	 * @return FromNameFR - varchar(255)
	 */
	public function getFromNameFR(){
		return $this->FromNameFR;
	}

	/**
	 * @return FromNameDE - varchar(255)
	 */
	public function getFromNameDE(){
		return $this->FromNameDE;
	}

	/**
	 * @return FromNameIT - varchar(255)
	 */
	public function getFromNameIT(){
		return $this->FromNameIT;
	}

	/**
	 * @return TerminalID - int(10) unsigned
	 */
	public function getTerminalID(){
		return $this->TerminalID;
	}

	/**
	 * @return ToName - varchar(255)
	 */
	public function getToName(){
		return $this->ToName;
	}

	/**
	 * @return ToNameEN - varchar(255)
	 */
	public function getToNameEN(){
		return $this->ToNameEN;
	}

	/**
	 * @return ToNameRU - varchar(255)
	 */
	public function getToNameRU(){
		return $this->ToNameRU;
	}

	/**
	 * @return ToNameFR - varchar(255)
	 */
	public function getToNameFR(){
		return $this->ToNameFR;
	}

	/**
	 * @return ToNameDE - varchar(255)
	 */
	public function getToNameDE(){
		return $this->ToNameDE;
	}

	/**
	 * @return ToNameIT - varchar(255)
	 */
	public function getToNameIT(){
		return $this->ToNameIT;
	}

	/**
	 * @return DestinationID - int(10) unsigned
	 */
	public function getDestinationID(){
		return $this->DestinationID;
	}

	/**
	 * @return RouteID - int(10) unsigned
	 */
	public function getRouteID(){
		return $this->RouteID;
	}

	/**
	 * @return VehicleTypeID - int(10) unsigned
	 */
	public function getVehicleTypeID(){
		return $this->VehicleTypeID;
	}

	/**
	 * @return SinglePrice - decimal(10,2) unsigned
	 */
	public function getSinglePrice(){
		return $this->SinglePrice;
	}

	/**
	 * @return ReturnPrice - decimal(10,2) unsigned
	 */
	public function getReturnPrice(){
		return $this->ReturnPrice;
	}

	/**
	 * @return ID - int(10) unsigned
	 */
	public function getID(){
		return $this->ID;
	}

	/**
	 * @param Type: int(10) unsigned
	 */
	public function setDriverID($DriverID){
		$this->DriverID = $DriverID;
	}

	/**
	 * @param Type: varchar(255)
	 */
	public function setFromName($FromName){
		$this->FromName = $FromName;
	}

	/**
	 * @param Type: varchar(255)
	 */
	public function setFromNameEN($FromNameEN){
		$this->FromNameEN = $FromNameEN;
	}

	/**
	 * @param Type: varchar(255)
	 */
	public function setFromNameRU($FromNameRU){
		$this->FromNameRU = $FromNameRU;
	}

	/**
	 * @param Type: varchar(255)
	 */
	public function setFromNameFR($FromNameFR){
		$this->FromNameFR = $FromNameFR;
	}

	/**
	 * @param Type: varchar(255)
	 */
	public function setFromNameDE($FromNameDE){
		$this->FromNameDE = $FromNameDE;
	}

	/**
	 * @param Type: varchar(255)
	 */
	public function setFromNameIT($FromNameIT){
		$this->FromNameIT = $FromNameIT;
	}

	/**
	 * @param Type: int(10) unsigned
	 */
	public function setTerminalID($TerminalID){
		$this->TerminalID = $TerminalID;
	}

	/**
	 * @param Type: varchar(255)
	 */
	public function setToName($ToName){
		$this->ToName = $ToName;
	}

	/**
	 * @param Type: varchar(255)
	 */
	public function setToNameEN($ToNameEN){
		$this->ToNameEN = $ToNameEN;
	}

	/**
	 * @param Type: varchar(255)
	 */
	public function setToNameRU($ToNameRU){
		$this->ToNameRU = $ToNameRU;
	}

	/**
	 * @param Type: varchar(255)
	 */
	public function setToNameFR($ToNameFR){
		$this->ToNameFR = $ToNameFR;
	}

	/**
	 * @param Type: varchar(255)
	 */
	public function setToNameDE($ToNameDE){
		$this->ToNameDE = $ToNameDE;
	}

	/**
	 * @param Type: varchar(255)
	 */
	public function setToNameIT($ToNameIT){
		$this->ToNameIT = $ToNameIT;
	}

	/**
	 * @param Type: int(10) unsigned
	 */
	public function setDestinationID($DestinationID){
		$this->DestinationID = $DestinationID;
	}

	/**
	 * @param Type: int(10) unsigned
	 */
	public function setRouteID($RouteID){
		$this->RouteID = $RouteID;
	}

	/**
	 * @param Type: int(10) unsigned
	 */
	public function setVehicleTypeID($VehicleTypeID){
		$this->VehicleTypeID = $VehicleTypeID;
	}

	/**
	 * @param Type: decimal(10,2) unsigned
	 */
	public function setSinglePrice($SinglePrice){
		$this->SinglePrice = $SinglePrice;
	}

	/**
	 * @param Type: decimal(10,2) unsigned
	 */
	public function setReturnPrice($ReturnPrice){
		$this->ReturnPrice = $ReturnPrice;
	}

	/**
	 * @param Type: int(10) unsigned
	 */
	public function setID($ID){
		$this->ID = $ID;
	}

    /**
     * fieldValues - Load all fieldNames and fieldValues into Array. 
     *
     * @param 
     * 
     */
	public function fieldValues(){
		$fieldValues = array(
			'DriverID' => $this->getDriverID(),
			'FromName' => $this->getFromName(),
			'FromNameEN' => $this->getFromNameEN(),
			'FromNameRU' => $this->getFromNameRU(),
			'FromNameFR' => $this->getFromNameFR(),
			'FromNameDE' => $this->getFromNameDE(),
			'FromNameIT' => $this->getFromNameIT(),
			'TerminalID' => $this->getTerminalID(),
			'ToName' => $this->getToName(),
			'ToNameEN' => $this->getToNameEN(),
			'ToNameRU' => $this->getToNameRU(),
			'ToNameFR' => $this->getToNameFR(),
			'ToNameDE' => $this->getToNameDE(),
			'ToNameIT' => $this->getToNameIT(),
			'DestinationID' => $this->getDestinationID(),
			'RouteID' => $this->getRouteID(),
			'VehicleTypeID' => $this->getVehicleTypeID(),
			'SinglePrice' => $this->getSinglePrice(),
			'ReturnPrice' => $this->getReturnPrice(),
			'ID' => $this->getID()		);
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
			'DriverID',			'FromName',			'FromNameEN',			'FromNameRU',			'FromNameFR',			'FromNameDE',			'FromNameIT',			'TerminalID',			'ToName',			'ToNameEN',			'ToNameRU',			'ToNameFR',			'ToNameDE',			'ToNameIT',			'DestinationID',			'RouteID',			'VehicleTypeID',			'SinglePrice',			'ReturnPrice',			'ID'		);
		return $fieldNames;
	}
    /**
     * Close mysql connection
     */
	public function endv4_DriverPrices(){
		$this->connection->CloseMysql();
	}

}