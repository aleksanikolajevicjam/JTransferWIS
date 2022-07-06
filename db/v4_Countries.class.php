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

Class v4_Countries {

	public $CountryID; //int(10) unsigned
	public $CountryName; //varchar(100)
	public $CountryNameEN; //varchar(100)
	public $CountryNameRU; //varchar(255)
	public $CountryNameFR; //varchar(255)
	public $CountryNameDE; //varchar(255)
	public $CountryNameIT; //varchar(255)
	public $CountryNameSE; //varchar(255)
	public $CountryNameNO; //varchar(255)
	public $CountryNameES; //varchar(255)
	public $CountryNameNL; //varchar(255)
	public $CountryDesc; //text
	public $CountryDescEN; //text
	public $CountryDescRU; //text
	public $CountryDescFR; //text
	public $CountryDescDE; //text
	public $CountryDescIT; //text
	public $CountryDescSE; //text
	public $CountryDescNO; //text
	public $CountryDescES; //text
	public $CountryDescNL; //text
	public $CountryISO; //varchar(5)
	public $CountryCode; //varchar(5)
	public $CountryCode3; //varchar(5)
	public $PhonePrefix; //varchar(5)
	public $Currency; //varchar(5)
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
	public function New_v4_Countries($CountryName,$CountryNameEN,$CountryNameRU,$CountryNameFR,$CountryNameDE,$CountryNameIT,$CountryNameSE,$CountryNameNO,$CountryNameES,$CountryNameNL,$CountryDesc,$CountryDescEN,$CountryDescRU,$CountryDescFR,$CountryDescDE,$CountryDescIT,$CountryDescSE,$CountryDescNO,$CountryDescES,$CountryDescNL,$CountryISO,$CountryCode,$CountryCode3,$PhonePrefix,$Currency){
		$this->CountryName = $CountryName;
		$this->CountryNameEN = $CountryNameEN;
		$this->CountryNameRU = $CountryNameRU;
		$this->CountryNameFR = $CountryNameFR;
		$this->CountryNameDE = $CountryNameDE;
		$this->CountryNameIT = $CountryNameIT;
		$this->CountryNameSE = $CountryNameSE;
		$this->CountryNameNO = $CountryNameNO;
		$this->CountryNameES = $CountryNameES;
		$this->CountryNameNL = $CountryNameNL;
		$this->CountryDesc = $CountryDesc;
		$this->CountryDescEN = $CountryDescEN;
		$this->CountryDescRU = $CountryDescRU;
		$this->CountryDescFR = $CountryDescFR;
		$this->CountryDescDE = $CountryDescDE;
		$this->CountryDescIT = $CountryDescIT;
		$this->CountryDescSE = $CountryDescSE;
		$this->CountryDescNO = $CountryDescNO;
		$this->CountryDescES = $CountryDescES;
		$this->CountryDescNL = $CountryDescNL;
		$this->CountryISO = $CountryISO;
		$this->CountryCode = $CountryCode;
		$this->CountryCode3 = $CountryCode3;
		$this->PhonePrefix = $PhonePrefix;
		$this->Currency = $Currency;
	}

    /**
     * Load one row into var_class. To use the vars use for exemple echo $class->getVar_name; 
     *
     * @param key_table_type $key_row
     * 
     */
	public function getRow($key_row){
		$result = $this->connection->RunQuery("Select * from v4_Countries where CountryID = \"$key_row\" ");
		if($result->num_rows < 1) return false;
		while($row = $result->fetch_array(MYSQLI_ASSOC)){
			$this->CountryID = $row["CountryID"];
			$this->CountryName = $row["CountryName"];
			$this->CountryNameEN = $row["CountryNameEN"];
			$this->CountryNameRU = $row["CountryNameRU"];
			$this->CountryNameFR = $row["CountryNameFR"];
			$this->CountryNameDE = $row["CountryNameDE"];
			$this->CountryNameIT = $row["CountryNameIT"];
			$this->CountryNameSE = $row["CountryNameSE"];
			$this->CountryNameNO = $row["CountryNameNO"];
			$this->CountryNameES = $row["CountryNameES"];
			$this->CountryNameNL = $row["CountryNameNL"];
			$this->CountryDesc = $row["CountryDesc"];
			$this->CountryDescEN = $row["CountryDescEN"];
			$this->CountryDescRU = $row["CountryDescRU"];
			$this->CountryDescFR = $row["CountryDescFR"];
			$this->CountryDescDE = $row["CountryDescDE"];
			$this->CountryDescIT = $row["CountryDescIT"];
			$this->CountryDescSE = $row["CountryDescSE"];
			$this->CountryDescNO = $row["CountryDescNO"];
			$this->CountryDescES = $row["CountryDescES"];
			$this->CountryDescNL = $row["CountryDescNL"];
			$this->CountryISO = $row["CountryISO"];
			$this->CountryCode = $row["CountryCode"];
			$this->CountryCode3 = $row["CountryCode3"];
			$this->PhonePrefix = $row["PhonePrefix"];
			$this->Currency = $row["Currency"];
		}
	}

    /**
     * Delete the row by using the key as arg
     *
     * @param key_table_type $key_row
     *
     */
	public function deleteRow($key_row){
		$this->connection->RunQuery("DELETE FROM v4_Countries WHERE CountryID = $key_row");
	}

    /**
     * Update the active row table on table
     */
	public function saveRow(){
		$result = $this->connection->RunQuery("UPDATE v4_Countries set 
CountryName = '".$this->myreal_escape_string($this->CountryName)."', 
CountryNameEN = '".$this->myreal_escape_string($this->CountryNameEN)."', 
CountryNameRU = '".$this->myreal_escape_string($this->CountryNameRU)."', 
CountryNameFR = '".$this->myreal_escape_string($this->CountryNameFR)."', 
CountryNameDE = '".$this->myreal_escape_string($this->CountryNameDE)."', 
CountryNameIT = '".$this->myreal_escape_string($this->CountryNameIT)."', 
CountryNameSE = '".$this->myreal_escape_string($this->CountryNameSE)."', 
CountryNameNO = '".$this->myreal_escape_string($this->CountryNameNO)."', 
CountryNameES = '".$this->myreal_escape_string($this->CountryNameES)."', 
CountryNameNL = '".$this->myreal_escape_string($this->CountryNameNL)."', 
CountryDesc = '".$this->myreal_escape_string($this->CountryDesc)."', 
CountryDescEN = '".$this->myreal_escape_string($this->CountryDescEN)."', 
CountryDescRU = '".$this->myreal_escape_string($this->CountryDescRU)."', 
CountryDescFR = '".$this->myreal_escape_string($this->CountryDescFR)."', 
CountryDescDE = '".$this->myreal_escape_string($this->CountryDescDE)."', 
CountryDescIT = '".$this->myreal_escape_string($this->CountryDescIT)."', 
CountryDescSE = '".$this->myreal_escape_string($this->CountryDescSE)."', 
CountryDescNO = '".$this->myreal_escape_string($this->CountryDescNO)."', 
CountryDescES = '".$this->myreal_escape_string($this->CountryDescES)."', 
CountryDescNL = '".$this->myreal_escape_string($this->CountryDescNL)."', 
CountryISO = '".$this->myreal_escape_string($this->CountryISO)."', 
CountryCode = '".$this->myreal_escape_string($this->CountryCode)."', 
CountryCode3 = '".$this->myreal_escape_string($this->CountryCode3)."', 
PhonePrefix = '".$this->myreal_escape_string($this->PhonePrefix)."', 
Currency = '".$this->myreal_escape_string($this->Currency)."' WHERE CountryID = '".$this->CountryID."'");
	return $result; 
}

    /**
     * Save the active var class as a new row on table
     */
	public function saveAsNew(){
		$this->connection->RunQuery("INSERT INTO v4_Countries (CountryName, CountryNameEN, CountryNameRU, CountryNameFR, CountryNameDE, CountryNameIT, CountryNameSE, CountryNameNO, CountryNameES, CountryNameNL, CountryDesc, CountryDescEN, CountryDescRU, CountryDescFR, CountryDescDE, CountryDescIT, CountryDescSE, CountryDescNO, CountryDescES, CountryDescNL, CountryISO, CountryCode, CountryCode3, PhonePrefix, Currency) values ('".$this->myreal_escape_string($this->CountryName)."', '".$this->myreal_escape_string($this->CountryNameEN)."', '".$this->myreal_escape_string($this->CountryNameRU)."', '".$this->myreal_escape_string($this->CountryNameFR)."', '".$this->myreal_escape_string($this->CountryNameDE)."', '".$this->myreal_escape_string($this->CountryNameIT)."', '".$this->myreal_escape_string($this->CountryNameSE)."', '".$this->myreal_escape_string($this->CountryNameNO)."', '".$this->myreal_escape_string($this->CountryNameES)."', '".$this->myreal_escape_string($this->CountryNameNL)."', '".$this->myreal_escape_string($this->CountryDesc)."', '".$this->myreal_escape_string($this->CountryDescEN)."', '".$this->myreal_escape_string($this->CountryDescRU)."', '".$this->myreal_escape_string($this->CountryDescFR)."', '".$this->myreal_escape_string($this->CountryDescDE)."', '".$this->myreal_escape_string($this->CountryDescIT)."', '".$this->myreal_escape_string($this->CountryDescSE)."', '".$this->myreal_escape_string($this->CountryDescNO)."', '".$this->myreal_escape_string($this->CountryDescES)."', '".$this->myreal_escape_string($this->CountryDescNL)."', '".$this->myreal_escape_string($this->CountryISO)."', '".$this->myreal_escape_string($this->CountryCode)."', '".$this->myreal_escape_string($this->CountryCode3)."', '".$this->myreal_escape_string($this->PhonePrefix)."', '".$this->myreal_escape_string($this->Currency)."')");
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
		$result = $this->connection->RunQuery("SELECT CountryID from v4_Countries $where ORDER BY $column $order");
			while($row = $result->fetch_array(MYSQLI_ASSOC)){
				$keys[$i] = $row["CountryID"];
				$i++;
			}
	return $keys;
	}

	/**
	 * @return CountryID - int(10) unsigned
	 */
	public function getCountryID(){
		return $this->CountryID;
	}

	/**
	 * @return CountryName - varchar(100)
	 */
	public function getCountryName(){
		return $this->CountryName;
	}

	/**
	 * @return CountryNameEN - varchar(100)
	 */
	public function getCountryNameEN(){
		return $this->CountryNameEN;
	}

	/**
	 * @return CountryNameRU - varchar(255)
	 */
	public function getCountryNameRU(){
		return $this->CountryNameRU;
	}

	/**
	 * @return CountryNameFR - varchar(255)
	 */
	public function getCountryNameFR(){
		return $this->CountryNameFR;
	}

	/**
	 * @return CountryNameDE - varchar(255)
	 */
	public function getCountryNameDE(){
		return $this->CountryNameDE;
	}

	/**
	 * @return CountryNameIT - varchar(255)
	 */
	public function getCountryNameIT(){
		return $this->CountryNameIT;
	}

	/**
	 * @return CountryNameSE - varchar(255)
	 */
	public function getCountryNameSE(){
		return $this->CountryNameSE;
	}

	/**
	 * @return CountryNameNO - varchar(255)
	 */
	public function getCountryNameNO(){
		return $this->CountryNameNO;
	}

	/**
	 * @return CountryNameES - varchar(255)
	 */
	public function getCountryNameES(){
		return $this->CountryNameES;
	}

	/**
	 * @return CountryNameNL - varchar(255)
	 */
	public function getCountryNameNL(){
		return $this->CountryNameNL;
	}

	/**
	 * @return CountryDesc - text
	 */
	public function getCountryDesc(){
		return $this->CountryDesc;
	}

	/**
	 * @return CountryDescEN - text
	 */
	public function getCountryDescEN(){
		return $this->CountryDescEN;
	}

	/**
	 * @return CountryDescRU - text
	 */
	public function getCountryDescRU(){
		return $this->CountryDescRU;
	}

	/**
	 * @return CountryDescFR - text
	 */
	public function getCountryDescFR(){
		return $this->CountryDescFR;
	}

	/**
	 * @return CountryDescDE - text
	 */
	public function getCountryDescDE(){
		return $this->CountryDescDE;
	}

	/**
	 * @return CountryDescIT - text
	 */
	public function getCountryDescIT(){
		return $this->CountryDescIT;
	}

	/**
	 * @return CountryDescSE - text
	 */
	public function getCountryDescSE(){
		return $this->CountryDescSE;
	}

	/**
	 * @return CountryDescNO - text
	 */
	public function getCountryDescNO(){
		return $this->CountryDescNO;
	}

	/**
	 * @return CountryDescES - text
	 */
	public function getCountryDescES(){
		return $this->CountryDescES;
	}

	/**
	 * @return CountryDescNL - text
	 */
	public function getCountryDescNL(){
		return $this->CountryDescNL;
	}

	/**
	 * @return CountryISO - varchar(5)
	 */
	public function getCountryISO(){
		return $this->CountryISO;
	}

	/**
	 * @return CountryCode - varchar(5)
	 */
	public function getCountryCode(){
		return $this->CountryCode;
	}

	/**
	 * @return CountryCode3 - varchar(5)
	 */
	public function getCountryCode3(){
		return $this->CountryCode3;
	}

	/**
	 * @return PhonePrefix - varchar(5)
	 */
	public function getPhonePrefix(){
		return $this->PhonePrefix;
	}

	/**
	 * @return Currency - varchar(5)
	 */
	public function getCurrency(){
		return $this->Currency;
	}

	/**
	 * @param Type: int(10) unsigned
	 */
	public function setCountryID($CountryID){
		$this->CountryID = $CountryID;
	}

	/**
	 * @param Type: varchar(100)
	 */
	public function setCountryName($CountryName){
		$this->CountryName = $CountryName;
	}

	/**
	 * @param Type: varchar(100)
	 */
	public function setCountryNameEN($CountryNameEN){
		$this->CountryNameEN = $CountryNameEN;
	}

	/**
	 * @param Type: varchar(255)
	 */
	public function setCountryNameRU($CountryNameRU){
		$this->CountryNameRU = $CountryNameRU;
	}

	/**
	 * @param Type: varchar(255)
	 */
	public function setCountryNameFR($CountryNameFR){
		$this->CountryNameFR = $CountryNameFR;
	}

	/**
	 * @param Type: varchar(255)
	 */
	public function setCountryNameDE($CountryNameDE){
		$this->CountryNameDE = $CountryNameDE;
	}

	/**
	 * @param Type: varchar(255)
	 */
	public function setCountryNameIT($CountryNameIT){
		$this->CountryNameIT = $CountryNameIT;
	}

	/**
	 * @param Type: varchar(255)
	 */
	public function setCountryNameSE($CountryNameSE){
		$this->CountryNameSE = $CountryNameSE;
	}

	/**
	 * @param Type: varchar(255)
	 */
	public function setCountryNameNO($CountryNameNO){
		$this->CountryNameNO = $CountryNameNO;
	}

	/**
	 * @param Type: varchar(255)
	 */
	public function setCountryNameES($CountryNameES){
		$this->CountryNameES = $CountryNameES;
	}

	/**
	 * @param Type: varchar(255)
	 */
	public function setCountryNameNL($CountryNameNL){
		$this->CountryNameNL = $CountryNameNL;
	}

	/**
	 * @param Type: text
	 */
	public function setCountryDesc($CountryDesc){
		$this->CountryDesc = $CountryDesc;
	}

	/**
	 * @param Type: text
	 */
	public function setCountryDescEN($CountryDescEN){
		$this->CountryDescEN = $CountryDescEN;
	}

	/**
	 * @param Type: text
	 */
	public function setCountryDescRU($CountryDescRU){
		$this->CountryDescRU = $CountryDescRU;
	}

	/**
	 * @param Type: text
	 */
	public function setCountryDescFR($CountryDescFR){
		$this->CountryDescFR = $CountryDescFR;
	}

	/**
	 * @param Type: text
	 */
	public function setCountryDescDE($CountryDescDE){
		$this->CountryDescDE = $CountryDescDE;
	}

	/**
	 * @param Type: text
	 */
	public function setCountryDescIT($CountryDescIT){
		$this->CountryDescIT = $CountryDescIT;
	}

	/**
	 * @param Type: text
	 */
	public function setCountryDescSE($CountryDescSE){
		$this->CountryDescSE = $CountryDescSE;
	}

	/**
	 * @param Type: text
	 */
	public function setCountryDescNO($CountryDescNO){
		$this->CountryDescNO = $CountryDescNO;
	}

	/**
	 * @param Type: text
	 */
	public function setCountryDescES($CountryDescES){
		$this->CountryDescES = $CountryDescES;
	}

	/**
	 * @param Type: text
	 */
	public function setCountryDescNL($CountryDescNL){
		$this->CountryDescNL = $CountryDescNL;
	}

	/**
	 * @param Type: varchar(5)
	 */
	public function setCountryISO($CountryISO){
		$this->CountryISO = $CountryISO;
	}

	/**
	 * @param Type: varchar(5)
	 */
	public function setCountryCode($CountryCode){
		$this->CountryCode = $CountryCode;
	}

	/**
	 * @param Type: varchar(5)
	 */
	public function setCountryCode3($CountryCode3){
		$this->CountryCode3 = $CountryCode3;
	}

	/**
	 * @param Type: varchar(5)
	 */
	public function setPhonePrefix($PhonePrefix){
		$this->PhonePrefix = $PhonePrefix;
	}

	/**
	 * @param Type: varchar(5)
	 */
	public function setCurrency($Currency){
		$this->Currency = $Currency;
	}

    /**
     * fieldValues - Load all fieldNames and fieldValues into Array. 
     *
     * @param 
     * 
     */
	public function fieldValues(){
		$fieldValues = array(
			'CountryID' => $this->getCountryID(),
			'CountryName' => $this->getCountryName(),
			'CountryNameEN' => $this->getCountryNameEN(),
			'CountryNameRU' => $this->getCountryNameRU(),
			'CountryNameFR' => $this->getCountryNameFR(),
			'CountryNameDE' => $this->getCountryNameDE(),
			'CountryNameIT' => $this->getCountryNameIT(),
			'CountryNameSE' => $this->getCountryNameSE(),
			'CountryNameNO' => $this->getCountryNameNO(),
			'CountryNameES' => $this->getCountryNameES(),
			'CountryNameNL' => $this->getCountryNameNL(),
			'CountryDesc' => $this->getCountryDesc(),
			'CountryDescEN' => $this->getCountryDescEN(),
			'CountryDescRU' => $this->getCountryDescRU(),
			'CountryDescFR' => $this->getCountryDescFR(),
			'CountryDescDE' => $this->getCountryDescDE(),
			'CountryDescIT' => $this->getCountryDescIT(),
			'CountryDescSE' => $this->getCountryDescSE(),
			'CountryDescNO' => $this->getCountryDescNO(),
			'CountryDescES' => $this->getCountryDescES(),
			'CountryDescNL' => $this->getCountryDescNL(),
			'CountryISO' => $this->getCountryISO(),
			'CountryCode' => $this->getCountryCode(),
			'CountryCode3' => $this->getCountryCode3(),
			'PhonePrefix' => $this->getPhonePrefix(),
			'Currency' => $this->getCurrency()		);
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
			'CountryID',			'CountryName',			'CountryNameEN',			'CountryNameRU',			'CountryNameFR',			'CountryNameDE',			'CountryNameIT',			'CountryNameSE',			'CountryNameNO',			'CountryNameES',			'CountryNameNL',			'CountryDesc',			'CountryDescEN',			'CountryDescRU',			'CountryDescFR',			'CountryDescDE',			'CountryDescIT',			'CountryDescSE',			'CountryDescNO',			'CountryDescES',			'CountryDescNL',			'CountryISO',			'CountryCode',			'CountryCode3',			'PhonePrefix',			'Currency'		);
		return $fieldNames;
	}
    /**
     * Close mysql connection
     */
	public function endv4_Countries(){
		$this->connection->CloseMysql();
	}

}