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

Class v4_VehicleTypes {

	public $VehicleTypeID; //int(10) unsigned
	public $VehicleTypeName; //varchar(100)
	public $VehicleTypeNameEN; //varchar(100)
	public $VehicleTypeNameRU; //varchar(255)
	public $VehicleTypeNameFR; //varchar(255)
	public $VehicleTypeNameDE; //varchar(255)
	public $VehicleTypeNameIT; //varchar(100)
	public $VehicleTypeNameSE; //varchar(255)
	public $VehicleTypeNameNO; //varchar(255)
	public $VehicleTypeNameES; //varchar(255)
	public $VehicleTypeNameNL; //varchar(255)
	public $Min; //int(10) unsigned
	public $Max; //int(10) unsigned
	public $VehicleClass; //int(5) unsigned
	public $Description; //text
	public $DescriptionEN; //text
	public $DescriptionRU; //text
	public $DescriptionFR; //text
	public $DescriptionDE; //text
	public $DescriptionIT; //text
	public $DescriptionSE; //varchar(255)
	public $DescriptionNO; //varchar(255)
	public $DescriptionES; //varchar(255)
	public $DescriptionNL; //varchar(255)
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
	public function New_v4_VehicleTypes($VehicleTypeName,$VehicleTypeNameEN,$VehicleTypeNameRU,$VehicleTypeNameFR,$VehicleTypeNameDE,$VehicleTypeNameIT,$VehicleTypeNameSE,$VehicleTypeNameNO,$VehicleTypeNameES,$VehicleTypeNameNL,$Min,$Max,$VehicleClass,$Description,$DescriptionEN,$DescriptionRU,$DescriptionFR,$DescriptionDE,$DescriptionIT,$DescriptionSE,$DescriptionNO,$DescriptionES,$DescriptionNL){
		$this->VehicleTypeName = $VehicleTypeName;
		$this->VehicleTypeNameEN = $VehicleTypeNameEN;
		$this->VehicleTypeNameRU = $VehicleTypeNameRU;
		$this->VehicleTypeNameFR = $VehicleTypeNameFR;
		$this->VehicleTypeNameDE = $VehicleTypeNameDE;
		$this->VehicleTypeNameIT = $VehicleTypeNameIT;
		$this->VehicleTypeNameSE = $VehicleTypeNameSE;
		$this->VehicleTypeNameNO = $VehicleTypeNameNO;
		$this->VehicleTypeNameES = $VehicleTypeNameES;
		$this->VehicleTypeNameNL = $VehicleTypeNameNL;
		$this->Min = $Min;
		$this->Max = $Max;
		$this->VehicleClass = $VehicleClass;
		$this->Description = $Description;
		$this->DescriptionEN = $DescriptionEN;
		$this->DescriptionRU = $DescriptionRU;
		$this->DescriptionFR = $DescriptionFR;
		$this->DescriptionDE = $DescriptionDE;
		$this->DescriptionIT = $DescriptionIT;
		$this->DescriptionSE = $DescriptionSE;
		$this->DescriptionNO = $DescriptionNO;
		$this->DescriptionES = $DescriptionES;
		$this->DescriptionNL = $DescriptionNL;
	}

    /**
     * Load one row into var_class. To use the vars use for exemple echo $class->getVar_name; 
     *
     * @param key_table_type $key_row
     * 
     */
	public function getRow($key_row){
		$result = $this->connection->RunQuery("Select * from v4_VehicleTypes where VehicleTypeID = \"$key_row\" ");
		if($result->num_rows < 1) return false;
		while($row = $result->fetch_array(MYSQLI_ASSOC)){
			$this->VehicleTypeID = $row["VehicleTypeID"];
			$this->VehicleTypeName = $row["VehicleTypeName"];
			$this->VehicleTypeNameEN = $row["VehicleTypeNameEN"];
			$this->VehicleTypeNameRU = $row["VehicleTypeNameRU"];
			$this->VehicleTypeNameFR = $row["VehicleTypeNameFR"];
			$this->VehicleTypeNameDE = $row["VehicleTypeNameDE"];
			$this->VehicleTypeNameIT = $row["VehicleTypeNameIT"];
			$this->VehicleTypeNameSE = $row["VehicleTypeNameSE"];
			$this->VehicleTypeNameNO = $row["VehicleTypeNameNO"];
			$this->VehicleTypeNameES = $row["VehicleTypeNameES"];
			$this->VehicleTypeNameNL = $row["VehicleTypeNameNL"];
			$this->Min = $row["Min"];
			$this->Max = $row["Max"];
			$this->VehicleClass = $row["VehicleClass"];
			$this->Description = $row["Description"];
			$this->DescriptionEN = $row["DescriptionEN"];
			$this->DescriptionRU = $row["DescriptionRU"];
			$this->DescriptionFR = $row["DescriptionFR"];
			$this->DescriptionDE = $row["DescriptionDE"];
			$this->DescriptionIT = $row["DescriptionIT"];
			$this->DescriptionSE = $row["DescriptionSE"];
			$this->DescriptionNO = $row["DescriptionNO"];
			$this->DescriptionES = $row["DescriptionES"];
			$this->DescriptionNL = $row["DescriptionNL"];
		}
	}

    /**
     * Delete the row by using the key as arg
     *
     * @param key_table_type $key_row
     *
     */
	public function deleteRow($key_row){
		$this->connection->RunQuery("DELETE FROM v4_VehicleTypes WHERE VehicleTypeID = $key_row");
	}

    /**
     * Update the active row table on table
     */
	public function saveRow(){
		$result = $this->connection->RunQuery("UPDATE v4_VehicleTypes set 
VehicleTypeName = '".$this->myreal_escape_string($this->VehicleTypeName)."', 
VehicleTypeNameEN = '".$this->myreal_escape_string($this->VehicleTypeNameEN)."', 
VehicleTypeNameRU = '".$this->myreal_escape_string($this->VehicleTypeNameRU)."', 
VehicleTypeNameFR = '".$this->myreal_escape_string($this->VehicleTypeNameFR)."', 
VehicleTypeNameDE = '".$this->myreal_escape_string($this->VehicleTypeNameDE)."', 
VehicleTypeNameIT = '".$this->myreal_escape_string($this->VehicleTypeNameIT)."', 
VehicleTypeNameSE = '".$this->myreal_escape_string($this->VehicleTypeNameSE)."', 
VehicleTypeNameNO = '".$this->myreal_escape_string($this->VehicleTypeNameNO)."', 
VehicleTypeNameES = '".$this->myreal_escape_string($this->VehicleTypeNameES)."', 
VehicleTypeNameNL = '".$this->myreal_escape_string($this->VehicleTypeNameNL)."', 
Min = '".$this->myreal_escape_string($this->Min)."', 
Max = '".$this->myreal_escape_string($this->Max)."', 
VehicleClass = '".$this->myreal_escape_string($this->VehicleClass)."', 
Description = '".$this->myreal_escape_string($this->Description)."', 
DescriptionEN = '".$this->myreal_escape_string($this->DescriptionEN)."', 
DescriptionRU = '".$this->myreal_escape_string($this->DescriptionRU)."', 
DescriptionFR = '".$this->myreal_escape_string($this->DescriptionFR)."', 
DescriptionDE = '".$this->myreal_escape_string($this->DescriptionDE)."', 
DescriptionIT = '".$this->myreal_escape_string($this->DescriptionIT)."', 
DescriptionSE = '".$this->myreal_escape_string($this->DescriptionSE)."', 
DescriptionNO = '".$this->myreal_escape_string($this->DescriptionNO)."', 
DescriptionES = '".$this->myreal_escape_string($this->DescriptionES)."', 
DescriptionNL = '".$this->myreal_escape_string($this->DescriptionNL)."' WHERE VehicleTypeID = '".$this->VehicleTypeID."'");
	return $result; 
}

    /**
     * Save the active var class as a new row on table
     */
	public function saveAsNew(){
		$this->connection->RunQuery("INSERT INTO v4_VehicleTypes (VehicleTypeName, VehicleTypeNameEN, VehicleTypeNameRU, VehicleTypeNameFR, VehicleTypeNameDE, VehicleTypeNameIT, VehicleTypeNameSE, VehicleTypeNameNO, VehicleTypeNameES, VehicleTypeNameNL, Min, Max, VehicleClass, Description, DescriptionEN, DescriptionRU, DescriptionFR, DescriptionDE, DescriptionIT, DescriptionSE, DescriptionNO, DescriptionES, DescriptionNL) values ('".$this->myreal_escape_string($this->VehicleTypeName)."', '".$this->myreal_escape_string($this->VehicleTypeNameEN)."', '".$this->myreal_escape_string($this->VehicleTypeNameRU)."', '".$this->myreal_escape_string($this->VehicleTypeNameFR)."', '".$this->myreal_escape_string($this->VehicleTypeNameDE)."', '".$this->myreal_escape_string($this->VehicleTypeNameIT)."', '".$this->myreal_escape_string($this->VehicleTypeNameSE)."', '".$this->myreal_escape_string($this->VehicleTypeNameNO)."', '".$this->myreal_escape_string($this->VehicleTypeNameES)."', '".$this->myreal_escape_string($this->VehicleTypeNameNL)."', '".$this->myreal_escape_string($this->Min)."', '".$this->myreal_escape_string($this->Max)."', '".$this->myreal_escape_string($this->VehicleClass)."', '".$this->myreal_escape_string($this->Description)."', '".$this->myreal_escape_string($this->DescriptionEN)."', '".$this->myreal_escape_string($this->DescriptionRU)."', '".$this->myreal_escape_string($this->DescriptionFR)."', '".$this->myreal_escape_string($this->DescriptionDE)."', '".$this->myreal_escape_string($this->DescriptionIT)."', '".$this->myreal_escape_string($this->DescriptionSE)."', '".$this->myreal_escape_string($this->DescriptionNO)."', '".$this->myreal_escape_string($this->DescriptionES)."', '".$this->myreal_escape_string($this->DescriptionNL)."')");
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
		$result = $this->connection->RunQuery("SELECT VehicleTypeID from v4_VehicleTypes $where ORDER BY $column $order");
			while($row = $result->fetch_array(MYSQLI_ASSOC)){
				$keys[$i] = $row["VehicleTypeID"];
				$i++;
			}
	return $keys;
	}

	/**
	 * @return VehicleTypeID - int(10) unsigned
	 */
	public function getVehicleTypeID(){
		return $this->VehicleTypeID;
	}

	/**
	 * @return VehicleTypeName - varchar(100)
	 */
	public function getVehicleTypeName(){
		return $this->VehicleTypeName;
	}

	/**
	 * @return VehicleTypeNameEN - varchar(100)
	 */
	public function getVehicleTypeNameEN(){
		return $this->VehicleTypeNameEN;
	}

	/**
	 * @return VehicleTypeNameRU - varchar(255)
	 */
	public function getVehicleTypeNameRU(){
		return $this->VehicleTypeNameRU;
	}

	/**
	 * @return VehicleTypeNameFR - varchar(255)
	 */
	public function getVehicleTypeNameFR(){
		return $this->VehicleTypeNameFR;
	}

	/**
	 * @return VehicleTypeNameDE - varchar(255)
	 */
	public function getVehicleTypeNameDE(){
		return $this->VehicleTypeNameDE;
	}

	/**
	 * @return VehicleTypeNameIT - varchar(100)
	 */
	public function getVehicleTypeNameIT(){
		return $this->VehicleTypeNameIT;
	}

	/**
	 * @return VehicleTypeNameSE - varchar(255)
	 */
	public function getVehicleTypeNameSE(){
		return $this->VehicleTypeNameSE;
	}

	/**
	 * @return VehicleTypeNameNO - varchar(255)
	 */
	public function getVehicleTypeNameNO(){
		return $this->VehicleTypeNameNO;
	}

	/**
	 * @return VehicleTypeNameES - varchar(255)
	 */
	public function getVehicleTypeNameES(){
		return $this->VehicleTypeNameES;
	}

	/**
	 * @return VehicleTypeNameNL - varchar(255)
	 */
	public function getVehicleTypeNameNL(){
		return $this->VehicleTypeNameNL;
	}

	/**
	 * @return Min - int(10) unsigned
	 */
	public function getMin(){
		return $this->Min;
	}

	/**
	 * @return Max - int(10) unsigned
	 */
	public function getMax(){
		return $this->Max;
	}

	/**
	 * @return VehicleClass - int(5) unsigned
	 */
	public function getVehicleClass(){
		return $this->VehicleClass;
	}

	/**
	 * @return Description - text
	 */
	public function getDescription(){
		return $this->Description;
	}

	/**
	 * @return DescriptionEN - text
	 */
	public function getDescriptionEN(){
		return $this->DescriptionEN;
	}

	/**
	 * @return DescriptionRU - text
	 */
	public function getDescriptionRU(){
		return $this->DescriptionRU;
	}

	/**
	 * @return DescriptionFR - text
	 */
	public function getDescriptionFR(){
		return $this->DescriptionFR;
	}

	/**
	 * @return DescriptionDE - text
	 */
	public function getDescriptionDE(){
		return $this->DescriptionDE;
	}

	/**
	 * @return DescriptionIT - text
	 */
	public function getDescriptionIT(){
		return $this->DescriptionIT;
	}

	/**
	 * @return DescriptionSE - varchar(255)
	 */
	public function getDescriptionSE(){
		return $this->DescriptionSE;
	}

	/**
	 * @return DescriptionNO - varchar(255)
	 */
	public function getDescriptionNO(){
		return $this->DescriptionNO;
	}

	/**
	 * @return DescriptionES - varchar(255)
	 */
	public function getDescriptionES(){
		return $this->DescriptionES;
	}

	/**
	 * @return DescriptionNL - varchar(255)
	 */
	public function getDescriptionNL(){
		return $this->DescriptionNL;
	}

	/**
	 * @param Type: int(10) unsigned
	 */
	public function setVehicleTypeID($VehicleTypeID){
		$this->VehicleTypeID = $VehicleTypeID;
	}

	/**
	 * @param Type: varchar(100)
	 */
	public function setVehicleTypeName($VehicleTypeName){
		$this->VehicleTypeName = $VehicleTypeName;
	}

	/**
	 * @param Type: varchar(100)
	 */
	public function setVehicleTypeNameEN($VehicleTypeNameEN){
		$this->VehicleTypeNameEN = $VehicleTypeNameEN;
	}

	/**
	 * @param Type: varchar(255)
	 */
	public function setVehicleTypeNameRU($VehicleTypeNameRU){
		$this->VehicleTypeNameRU = $VehicleTypeNameRU;
	}

	/**
	 * @param Type: varchar(255)
	 */
	public function setVehicleTypeNameFR($VehicleTypeNameFR){
		$this->VehicleTypeNameFR = $VehicleTypeNameFR;
	}

	/**
	 * @param Type: varchar(255)
	 */
	public function setVehicleTypeNameDE($VehicleTypeNameDE){
		$this->VehicleTypeNameDE = $VehicleTypeNameDE;
	}

	/**
	 * @param Type: varchar(100)
	 */
	public function setVehicleTypeNameIT($VehicleTypeNameIT){
		$this->VehicleTypeNameIT = $VehicleTypeNameIT;
	}

	/**
	 * @param Type: varchar(255)
	 */
	public function setVehicleTypeNameSE($VehicleTypeNameSE){
		$this->VehicleTypeNameSE = $VehicleTypeNameSE;
	}

	/**
	 * @param Type: varchar(255)
	 */
	public function setVehicleTypeNameNO($VehicleTypeNameNO){
		$this->VehicleTypeNameNO = $VehicleTypeNameNO;
	}

	/**
	 * @param Type: varchar(255)
	 */
	public function setVehicleTypeNameES($VehicleTypeNameES){
		$this->VehicleTypeNameES = $VehicleTypeNameES;
	}

	/**
	 * @param Type: varchar(255)
	 */
	public function setVehicleTypeNameNL($VehicleTypeNameNL){
		$this->VehicleTypeNameNL = $VehicleTypeNameNL;
	}

	/**
	 * @param Type: int(10) unsigned
	 */
	public function setMin($Min){
		$this->Min = $Min;
	}

	/**
	 * @param Type: int(10) unsigned
	 */
	public function setMax($Max){
		$this->Max = $Max;
	}

	/**
	 * @param Type: int(5) unsigned
	 */
	public function setVehicleClass($VehicleClass){
		$this->VehicleClass = $VehicleClass;
	}

	/**
	 * @param Type: text
	 */
	public function setDescription($Description){
		$this->Description = $Description;
	}

	/**
	 * @param Type: text
	 */
	public function setDescriptionEN($DescriptionEN){
		$this->DescriptionEN = $DescriptionEN;
	}

	/**
	 * @param Type: text
	 */
	public function setDescriptionRU($DescriptionRU){
		$this->DescriptionRU = $DescriptionRU;
	}

	/**
	 * @param Type: text
	 */
	public function setDescriptionFR($DescriptionFR){
		$this->DescriptionFR = $DescriptionFR;
	}

	/**
	 * @param Type: text
	 */
	public function setDescriptionDE($DescriptionDE){
		$this->DescriptionDE = $DescriptionDE;
	}

	/**
	 * @param Type: text
	 */
	public function setDescriptionIT($DescriptionIT){
		$this->DescriptionIT = $DescriptionIT;
	}

	/**
	 * @param Type: varchar(255)
	 */
	public function setDescriptionSE($DescriptionSE){
		$this->DescriptionSE = $DescriptionSE;
	}

	/**
	 * @param Type: varchar(255)
	 */
	public function setDescriptionNO($DescriptionNO){
		$this->DescriptionNO = $DescriptionNO;
	}

	/**
	 * @param Type: varchar(255)
	 */
	public function setDescriptionES($DescriptionES){
		$this->DescriptionES = $DescriptionES;
	}

	/**
	 * @param Type: varchar(255)
	 */
	public function setDescriptionNL($DescriptionNL){
		$this->DescriptionNL = $DescriptionNL;
	}

    /**
     * fieldValues - Load all fieldNames and fieldValues into Array. 
     *
     * @param 
     * 
     */
	public function fieldValues(){
		$fieldValues = array(
			'VehicleTypeID' => $this->getVehicleTypeID(),
			'VehicleTypeName' => $this->getVehicleTypeName(),
			'VehicleTypeNameEN' => $this->getVehicleTypeNameEN(),
			'VehicleTypeNameRU' => $this->getVehicleTypeNameRU(),
			'VehicleTypeNameFR' => $this->getVehicleTypeNameFR(),
			'VehicleTypeNameDE' => $this->getVehicleTypeNameDE(),
			'VehicleTypeNameIT' => $this->getVehicleTypeNameIT(),
			'VehicleTypeNameSE' => $this->getVehicleTypeNameSE(),
			'VehicleTypeNameNO' => $this->getVehicleTypeNameNO(),
			'VehicleTypeNameES' => $this->getVehicleTypeNameES(),
			'VehicleTypeNameNL' => $this->getVehicleTypeNameNL(),
			'Min' => $this->getMin(),
			'Max' => $this->getMax(),
			'VehicleClass' => $this->getVehicleClass(),
			'Description' => $this->getDescription(),
			'DescriptionEN' => $this->getDescriptionEN(),
			'DescriptionRU' => $this->getDescriptionRU(),
			'DescriptionFR' => $this->getDescriptionFR(),
			'DescriptionDE' => $this->getDescriptionDE(),
			'DescriptionIT' => $this->getDescriptionIT(),
			'DescriptionSE' => $this->getDescriptionSE(),
			'DescriptionNO' => $this->getDescriptionNO(),
			'DescriptionES' => $this->getDescriptionES(),
			'DescriptionNL' => $this->getDescriptionNL()		);
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
			'VehicleTypeID',			'VehicleTypeName',			'VehicleTypeNameEN',			'VehicleTypeNameRU',			'VehicleTypeNameFR',			'VehicleTypeNameDE',			'VehicleTypeNameIT',			'VehicleTypeNameSE',			'VehicleTypeNameNO',			'VehicleTypeNameES',			'VehicleTypeNameNL',			'Min',			'Max',			'VehicleClass',			'Description',			'DescriptionEN',			'DescriptionRU',			'DescriptionFR',			'DescriptionDE',			'DescriptionIT',			'DescriptionSE',			'DescriptionNO',			'DescriptionES',			'DescriptionNL'		);
		return $fieldNames;
	}
    /**
     * Close mysql connection
     */
	public function endv4_VehicleTypes(){
		$this->connection->CloseMysql();
	}

}