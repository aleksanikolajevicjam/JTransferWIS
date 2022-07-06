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

Class v4_PlaceTypes {

	public $PlaceTypeID; //int(10) unsigned
	public $PlaceType; //varchar(255)
	public $PlaceTypeEN; //varchar(255)
	public $PlaceTypeRU; //varchar(255)
	public $PlaceTypeFR; //varchar(255)
	public $PlaceTypeDE; //varchar(255)
	public $PlaceTypeIT; //varchar(255)
	public $PlaceTypeSE; //varchar(255)
	public $PlaceTypeNO; //varchar(255)
	public $PlaceTypeES; //varchar(255)
	public $PlaceTypeNL; //varchar(255)
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
	public function New_v4_PlaceTypes($PlaceType,$PlaceTypeEN,$PlaceTypeRU,$PlaceTypeFR,$PlaceTypeDE,$PlaceTypeIT,$PlaceTypeSE,$PlaceTypeNO,$PlaceTypeES,$PlaceTypeNL){
		$this->PlaceType = $PlaceType;
		$this->PlaceTypeEN = $PlaceTypeEN;
		$this->PlaceTypeRU = $PlaceTypeRU;
		$this->PlaceTypeFR = $PlaceTypeFR;
		$this->PlaceTypeDE = $PlaceTypeDE;
		$this->PlaceTypeIT = $PlaceTypeIT;
		$this->PlaceTypeSE = $PlaceTypeSE;
		$this->PlaceTypeNO = $PlaceTypeNO;
		$this->PlaceTypeES = $PlaceTypeES;
		$this->PlaceTypeNL = $PlaceTypeNL;
	}

    /**
     * Load one row into var_class. To use the vars use for exemple echo $class->getVar_name; 
     *
     * @param key_table_type $key_row
     * 
     */
	public function getRow($key_row){
		$result = $this->connection->RunQuery("Select * from v4_PlaceTypes where PlaceTypeID = \"$key_row\" ");
		if($result->num_rows < 1) return false;
		while($row = $result->fetch_array(MYSQLI_ASSOC)){
			$this->PlaceTypeID = $row["PlaceTypeID"];
			$this->PlaceType = $row["PlaceType"];
			$this->PlaceTypeEN = $row["PlaceTypeEN"];
			$this->PlaceTypeRU = $row["PlaceTypeRU"];
			$this->PlaceTypeFR = $row["PlaceTypeFR"];
			$this->PlaceTypeDE = $row["PlaceTypeDE"];
			$this->PlaceTypeIT = $row["PlaceTypeIT"];
			$this->PlaceTypeSE = $row["PlaceTypeSE"];
			$this->PlaceTypeNO = $row["PlaceTypeNO"];
			$this->PlaceTypeES = $row["PlaceTypeES"];
			$this->PlaceTypeNL = $row["PlaceTypeNL"];
		}
	}

    /**
     * Delete the row by using the key as arg
     *
     * @param key_table_type $key_row
     *
     */
	public function deleteRow($key_row){
		$this->connection->RunQuery("DELETE FROM v4_PlaceTypes WHERE PlaceTypeID = $key_row");
	}

    /**
     * Update the active row table on table
     */
	public function saveRow(){
		$result = $this->connection->RunQuery("UPDATE v4_PlaceTypes set 
PlaceType = '".$this->myreal_escape_string($this->PlaceType)."', 
PlaceTypeEN = '".$this->myreal_escape_string($this->PlaceTypeEN)."', 
PlaceTypeRU = '".$this->myreal_escape_string($this->PlaceTypeRU)."', 
PlaceTypeFR = '".$this->myreal_escape_string($this->PlaceTypeFR)."', 
PlaceTypeDE = '".$this->myreal_escape_string($this->PlaceTypeDE)."', 
PlaceTypeIT = '".$this->myreal_escape_string($this->PlaceTypeIT)."', 
PlaceTypeSE = '".$this->myreal_escape_string($this->PlaceTypeSE)."', 
PlaceTypeNO = '".$this->myreal_escape_string($this->PlaceTypeNO)."', 
PlaceTypeES = '".$this->myreal_escape_string($this->PlaceTypeES)."', 
PlaceTypeNL = '".$this->myreal_escape_string($this->PlaceTypeNL)."' WHERE PlaceTypeID = '".$this->PlaceTypeID."'");
	return $result; 
}

    /**
     * Save the active var class as a new row on table
     */
	public function saveAsNew(){
		$this->connection->RunQuery("INSERT INTO v4_PlaceTypes (PlaceType, PlaceTypeEN, PlaceTypeRU, PlaceTypeFR, PlaceTypeDE, PlaceTypeIT, PlaceTypeSE, PlaceTypeNO, PlaceTypeES, PlaceTypeNL) values ('".$this->myreal_escape_string($this->PlaceType)."', '".$this->myreal_escape_string($this->PlaceTypeEN)."', '".$this->myreal_escape_string($this->PlaceTypeRU)."', '".$this->myreal_escape_string($this->PlaceTypeFR)."', '".$this->myreal_escape_string($this->PlaceTypeDE)."', '".$this->myreal_escape_string($this->PlaceTypeIT)."', '".$this->myreal_escape_string($this->PlaceTypeSE)."', '".$this->myreal_escape_string($this->PlaceTypeNO)."', '".$this->myreal_escape_string($this->PlaceTypeES)."', '".$this->myreal_escape_string($this->PlaceTypeNL)."')");
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
		$result = $this->connection->RunQuery("SELECT PlaceTypeID from v4_PlaceTypes $where ORDER BY $column $order");
			while($row = $result->fetch_array(MYSQLI_ASSOC)){
				$keys[$i] = $row["PlaceTypeID"];
				$i++;
			}
	return $keys;
	}

	/**
	 * @return PlaceTypeID - int(10) unsigned
	 */
	public function getPlaceTypeID(){
		return $this->PlaceTypeID;
	}

	/**
	 * @return PlaceType - varchar(255)
	 */
	public function getPlaceType(){
		return $this->PlaceType;
	}

	/**
	 * @return PlaceTypeEN - varchar(255)
	 */
	public function getPlaceTypeEN(){
		return $this->PlaceTypeEN;
	}

	/**
	 * @return PlaceTypeRU - varchar(255)
	 */
	public function getPlaceTypeRU(){
		return $this->PlaceTypeRU;
	}

	/**
	 * @return PlaceTypeFR - varchar(255)
	 */
	public function getPlaceTypeFR(){
		return $this->PlaceTypeFR;
	}

	/**
	 * @return PlaceTypeDE - varchar(255)
	 */
	public function getPlaceTypeDE(){
		return $this->PlaceTypeDE;
	}

	/**
	 * @return PlaceTypeIT - varchar(255)
	 */
	public function getPlaceTypeIT(){
		return $this->PlaceTypeIT;
	}

	/**
	 * @return PlaceTypeSE - varchar(255)
	 */
	public function getPlaceTypeSE(){
		return $this->PlaceTypeSE;
	}

	/**
	 * @return PlaceTypeNO - varchar(255)
	 */
	public function getPlaceTypeNO(){
		return $this->PlaceTypeNO;
	}

	/**
	 * @return PlaceTypeES - varchar(255)
	 */
	public function getPlaceTypeES(){
		return $this->PlaceTypeES;
	}

	/**
	 * @return PlaceTypeNL - varchar(255)
	 */
	public function getPlaceTypeNL(){
		return $this->PlaceTypeNL;
	}

	/**
	 * @param Type: int(10) unsigned
	 */
	public function setPlaceTypeID($PlaceTypeID){
		$this->PlaceTypeID = $PlaceTypeID;
	}

	/**
	 * @param Type: varchar(255)
	 */
	public function setPlaceType($PlaceType){
		$this->PlaceType = $PlaceType;
	}

	/**
	 * @param Type: varchar(255)
	 */
	public function setPlaceTypeEN($PlaceTypeEN){
		$this->PlaceTypeEN = $PlaceTypeEN;
	}

	/**
	 * @param Type: varchar(255)
	 */
	public function setPlaceTypeRU($PlaceTypeRU){
		$this->PlaceTypeRU = $PlaceTypeRU;
	}

	/**
	 * @param Type: varchar(255)
	 */
	public function setPlaceTypeFR($PlaceTypeFR){
		$this->PlaceTypeFR = $PlaceTypeFR;
	}

	/**
	 * @param Type: varchar(255)
	 */
	public function setPlaceTypeDE($PlaceTypeDE){
		$this->PlaceTypeDE = $PlaceTypeDE;
	}

	/**
	 * @param Type: varchar(255)
	 */
	public function setPlaceTypeIT($PlaceTypeIT){
		$this->PlaceTypeIT = $PlaceTypeIT;
	}

	/**
	 * @param Type: varchar(255)
	 */
	public function setPlaceTypeSE($PlaceTypeSE){
		$this->PlaceTypeSE = $PlaceTypeSE;
	}

	/**
	 * @param Type: varchar(255)
	 */
	public function setPlaceTypeNO($PlaceTypeNO){
		$this->PlaceTypeNO = $PlaceTypeNO;
	}

	/**
	 * @param Type: varchar(255)
	 */
	public function setPlaceTypeES($PlaceTypeES){
		$this->PlaceTypeES = $PlaceTypeES;
	}

	/**
	 * @param Type: varchar(255)
	 */
	public function setPlaceTypeNL($PlaceTypeNL){
		$this->PlaceTypeNL = $PlaceTypeNL;
	}

    /**
     * fieldValues - Load all fieldNames and fieldValues into Array. 
     *
     * @param 
     * 
     */
	public function fieldValues(){
		$fieldValues = array(
			'PlaceTypeID' => $this->getPlaceTypeID(),
			'PlaceType' => $this->getPlaceType(),
			'PlaceTypeEN' => $this->getPlaceTypeEN(),
			'PlaceTypeRU' => $this->getPlaceTypeRU(),
			'PlaceTypeFR' => $this->getPlaceTypeFR(),
			'PlaceTypeDE' => $this->getPlaceTypeDE(),
			'PlaceTypeIT' => $this->getPlaceTypeIT(),
			'PlaceTypeSE' => $this->getPlaceTypeSE(),
			'PlaceTypeNO' => $this->getPlaceTypeNO(),
			'PlaceTypeES' => $this->getPlaceTypeES(),
			'PlaceTypeNL' => $this->getPlaceTypeNL()		);
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
			'PlaceTypeID',			'PlaceType',			'PlaceTypeEN',			'PlaceTypeRU',			'PlaceTypeFR',			'PlaceTypeDE',			'PlaceTypeIT',			'PlaceTypeSE',			'PlaceTypeNO',			'PlaceTypeES',			'PlaceTypeNL'		);
		return $fieldNames;
	}
    /**
     * Close mysql connection
     */
	public function endv4_PlaceTypes(){
		$this->connection->CloseMysql();
	}

}