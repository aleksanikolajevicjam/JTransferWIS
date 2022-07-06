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

Class v4_Places {

	public $PlaceID; //int(10) unsigned
	public $PlaceCountry; //int(10) unsigned
	public $CountryNameEN; //varchar(255)
	public $PlaceNameEN; //varchar(255)
	public $PlaceNameSEO; //varchar(255)
	public $PlaceNameRU; //varchar(255)
	public $PlaceNameFR; //varchar(255)
	public $PlaceNameDE; //varchar(255)
	public $PlaceNameIT; //varchar(255)
	public $PlaceNameSE; //varchar(255)
	public $PlaceNameNO; //varchar(255)
	public $PlaceNameES; //varchar(255)
	public $PlaceNameNL; //varchar(255)
	public $PlaceType; //tinyint(4) unsigned
	public $PlaceCity; //varchar(100)
	public $PlaceAddress; //varchar(255)
	public $PlaceDesc; //text
	public $PlaceDescEN; //text
	public $PlaceDescRU; //text
	public $PlaceDescFR; //text
	public $PlaceDescDE; //text
	public $PlaceDescIT; //text
	public $PlaceDescSE; //text
	public $PlaceDescNO; //text
	public $PlaceDescES; //text
	public $PlaceDescNL; //text
	public $Image; //varchar(255)
	public $Island; //tinyint(1)
	public $PlaceActive; //int(3)
	public $Longitude; //decimal(9.2)
	public $Latitude; //decimal(9.2)
	public $Elevation; //decimal(9.2)
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
	public function New_v4_Places($PlaceCountry,$CountryNameEN,$PlaceNameEN,$PlaceNameSEO,$PlaceNameRU,$PlaceNameFR,$PlaceNameDE,$PlaceNameIT,$PlaceNameSE,$PlaceNameNO,$PlaceNameES,$PlaceNameNL,$PlaceType,$PlaceCity,$PlaceAddress,$PlaceDesc,$PlaceDescEN,$PlaceDescRU,$PlaceDescFR,$PlaceDescDE,$PlaceDescIT,$PlaceDescSE,$PlaceDescNO,$PlaceDescES,$PlaceDescNL,$Image,$Island,$PlaceActive,$Longitude,$Latitude,$Elevation){
		$this->PlaceCountry = $PlaceCountry;
		$this->CountryNameEN = $CountryNameEN;
		$this->PlaceNameEN = $PlaceNameEN;
		$this->PlaceNameSEO = $PlaceNameSEO;
		$this->PlaceNameRU = $PlaceNameRU;
		$this->PlaceNameFR = $PlaceNameFR;
		$this->PlaceNameDE = $PlaceNameDE;
		$this->PlaceNameIT = $PlaceNameIT;
		$this->PlaceNameSE = $PlaceNameSE;
		$this->PlaceNameNO = $PlaceNameNO;
		$this->PlaceNameES = $PlaceNameES;
		$this->PlaceNameNL = $PlaceNameNL;
		$this->PlaceType = $PlaceType;
		$this->PlaceCity = $PlaceCity;
		$this->PlaceAddress = $PlaceAddress;
		$this->PlaceDesc = $PlaceDesc;
		$this->PlaceDescEN = $PlaceDescEN;
		$this->PlaceDescRU = $PlaceDescRU;
		$this->PlaceDescFR = $PlaceDescFR;
		$this->PlaceDescDE = $PlaceDescDE;
		$this->PlaceDescIT = $PlaceDescIT;
		$this->PlaceDescSE = $PlaceDescSE;
		$this->PlaceDescNO = $PlaceDescNO;
		$this->PlaceDescES = $PlaceDescES;
		$this->PlaceDescNL = $PlaceDescNL;
		$this->Image = $Image;
		$this->Island = $Island;
		$this->PlaceActive = $PlaceActive;
		$this->Longitude = $Longitude;
		$this->Latitude = $Latitude;
		$this->Elevation = $Elevation;
	}

    /**
     * Load one row into var_class. To use the vars use for exemple echo $class->getVar_name; 
     *
     * @param key_table_type $key_row
     * 
     */
	public function getRow($key_row){
		$result = $this->connection->RunQuery("Select * from v4_Places where PlaceID = \"$key_row\" ");
		if($result->num_rows < 1) return false;
		while($row = $result->fetch_array(MYSQLI_ASSOC)){
			$this->PlaceID = $row["PlaceID"];
			$this->PlaceCountry = $row["PlaceCountry"];
			$this->CountryNameEN = $row["CountryNameEN"];
			$this->PlaceNameEN = $row["PlaceNameEN"];
			$this->PlaceNameSEO = $row["PlaceNameSEO"];
			$this->PlaceNameRU = $row["PlaceNameRU"];
			$this->PlaceNameFR = $row["PlaceNameFR"];
			$this->PlaceNameDE = $row["PlaceNameDE"];
			$this->PlaceNameIT = $row["PlaceNameIT"];
			$this->PlaceNameSE = $row["PlaceNameSE"];
			$this->PlaceNameNO = $row["PlaceNameNO"];
			$this->PlaceNameES = $row["PlaceNameES"];
			$this->PlaceNameNL = $row["PlaceNameNL"];
			$this->PlaceType = $row["PlaceType"];
			$this->PlaceCity = $row["PlaceCity"];
			$this->PlaceAddress = $row["PlaceAddress"];
			$this->PlaceDesc = $row["PlaceDesc"];
			$this->PlaceDescEN = $row["PlaceDescEN"];
			$this->PlaceDescRU = $row["PlaceDescRU"];
			$this->PlaceDescFR = $row["PlaceDescFR"];
			$this->PlaceDescDE = $row["PlaceDescDE"];
			$this->PlaceDescIT = $row["PlaceDescIT"];
			$this->PlaceDescSE = $row["PlaceDescSE"];
			$this->PlaceDescNO = $row["PlaceDescNO"];
			$this->PlaceDescES = $row["PlaceDescES"];
			$this->PlaceDescNL = $row["PlaceDescNL"];
			$this->Image = $row["Image"];
			$this->Island = $row["Island"];
			$this->PlaceActive = $row["PlaceActive"];
			$this->Longitude = $row["Longitude"];
			$this->Latitude = $row["Latitude"];
			$this->Elevation = $row["Elevation"];
		}
	}

    /**
     * Delete the row by using the key as arg
     *
     * @param key_table_type $key_row
     *
     */
	public function deleteRow($key_row){
		$this->connection->RunQuery("DELETE FROM v4_Places WHERE PlaceID = $key_row");
	}

    /**
     * Update the active row table on table
     */
	public function saveRow(){
		$result = $this->connection->RunQuery("UPDATE v4_Places set 
PlaceCountry = '".$this->myreal_escape_string($this->PlaceCountry)."', 
CountryNameEN = '".$this->myreal_escape_string($this->CountryNameEN)."', 
PlaceNameEN = '".$this->myreal_escape_string($this->PlaceNameEN)."', 
PlaceNameSEO = '".$this->myreal_escape_string($this->PlaceNameSEO)."', 
PlaceNameRU = '".$this->myreal_escape_string($this->PlaceNameRU)."', 
PlaceNameFR = '".$this->myreal_escape_string($this->PlaceNameFR)."', 
PlaceNameDE = '".$this->myreal_escape_string($this->PlaceNameDE)."', 
PlaceNameIT = '".$this->myreal_escape_string($this->PlaceNameIT)."', 
PlaceNameSE = '".$this->myreal_escape_string($this->PlaceNameSE)."', 
PlaceNameNO = '".$this->myreal_escape_string($this->PlaceNameNO)."', 
PlaceNameES = '".$this->myreal_escape_string($this->PlaceNameES)."', 
PlaceNameNL = '".$this->myreal_escape_string($this->PlaceNameNL)."', 
PlaceType = '".$this->myreal_escape_string($this->PlaceType)."', 
PlaceCity = '".$this->myreal_escape_string($this->PlaceCity)."', 
PlaceAddress = '".$this->myreal_escape_string($this->PlaceAddress)."', 
PlaceDesc = '".$this->myreal_escape_string($this->PlaceDesc)."', 
PlaceDescEN = '".$this->myreal_escape_string($this->PlaceDescEN)."', 
PlaceDescRU = '".$this->myreal_escape_string($this->PlaceDescRU)."', 
PlaceDescFR = '".$this->myreal_escape_string($this->PlaceDescFR)."', 
PlaceDescDE = '".$this->myreal_escape_string($this->PlaceDescDE)."', 
PlaceDescIT = '".$this->myreal_escape_string($this->PlaceDescIT)."', 
PlaceDescSE = '".$this->myreal_escape_string($this->PlaceDescSE)."', 
PlaceDescNO = '".$this->myreal_escape_string($this->PlaceDescNO)."', 
PlaceDescES = '".$this->myreal_escape_string($this->PlaceDescES)."', 
PlaceDescNL = '".$this->myreal_escape_string($this->PlaceDescNL)."', 
Image = '".$this->myreal_escape_string($this->Image)."', 
Island = '".$this->myreal_escape_string($this->Island)."', 
PlaceActive = '".$this->myreal_escape_string($this->PlaceActive)."', 
Longitude = '".$this->myreal_escape_string($this->Longitude)."', 
Latitude = '".$this->myreal_escape_string($this->Latitude)."', 
Elevation = '".$this->myreal_escape_string($this->Elevation)."' WHERE PlaceID = '".$this->PlaceID."'");
	return $result; 
}

    /**
     * Save the active var class as a new row on table
     */
	public function saveAsNew(){
		$this->connection->RunQuery("INSERT INTO v4_Places (PlaceCountry, CountryNameEN, PlaceNameEN, PlaceNameSEO, PlaceNameRU, PlaceNameFR, PlaceNameDE, PlaceNameIT, PlaceNameSE, PlaceNameNO, PlaceNameES, PlaceNameNL, PlaceType, PlaceCity, PlaceAddress, PlaceDesc, PlaceDescEN, PlaceDescRU, PlaceDescFR, PlaceDescDE, PlaceDescIT, PlaceDescSE, PlaceDescNO, PlaceDescES, PlaceDescNL, Image, Island, PlaceActive, Longitude, Latitude, Elevation) values ('".$this->myreal_escape_string($this->PlaceCountry)."', '".$this->myreal_escape_string($this->CountryNameEN)."', '".$this->myreal_escape_string($this->PlaceNameEN)."', '".$this->myreal_escape_string($this->PlaceNameSEO)."', '".$this->myreal_escape_string($this->PlaceNameRU)."', '".$this->myreal_escape_string($this->PlaceNameFR)."', '".$this->myreal_escape_string($this->PlaceNameDE)."', '".$this->myreal_escape_string($this->PlaceNameIT)."', '".$this->myreal_escape_string($this->PlaceNameSE)."', '".$this->myreal_escape_string($this->PlaceNameNO)."', '".$this->myreal_escape_string($this->PlaceNameES)."', '".$this->myreal_escape_string($this->PlaceNameNL)."', '".$this->myreal_escape_string($this->PlaceType)."', '".$this->myreal_escape_string($this->PlaceCity)."', '".$this->myreal_escape_string($this->PlaceAddress)."', '".$this->myreal_escape_string($this->PlaceDesc)."', '".$this->myreal_escape_string($this->PlaceDescEN)."', '".$this->myreal_escape_string($this->PlaceDescRU)."', '".$this->myreal_escape_string($this->PlaceDescFR)."', '".$this->myreal_escape_string($this->PlaceDescDE)."', '".$this->myreal_escape_string($this->PlaceDescIT)."', '".$this->myreal_escape_string($this->PlaceDescSE)."', '".$this->myreal_escape_string($this->PlaceDescNO)."', '".$this->myreal_escape_string($this->PlaceDescES)."', '".$this->myreal_escape_string($this->PlaceDescNL)."', '".$this->myreal_escape_string($this->Image)."', '".$this->myreal_escape_string($this->Island)."','".$this->myreal_escape_string($this->PlaceActive)."',
		'".$this->myreal_escape_string($this->Longitude)."',
		'".$this->myreal_escape_string($this->Latitude)."',
		'".$this->myreal_escape_string($this->Elevation)."')");
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
		$result = $this->connection->RunQuery("SELECT PlaceID from v4_Places $where ORDER BY $column $order");
			while($row = $result->fetch_array(MYSQLI_ASSOC)){
				$keys[$i] = $row["PlaceID"];
				$i++;
			}
	return $keys;
	}

	/**
	 * @return PlaceID - int(10) unsigned
	 */
	public function getPlaceID(){
		return $this->PlaceID;
	}

	/**
	 * @return PlaceCountry - int(10) unsigned
	 */
	public function getPlaceCountry(){
		return $this->PlaceCountry;
	}

	/**
	 * @return CountryNameEN - varchar(255)
	 */
	public function getCountryNameEN(){
		return $this->CountryNameEN;
	}

	/**
	 * @return PlaceNameEN - varchar(255)
	 */
	public function getPlaceNameEN(){
		return $this->PlaceNameEN;
	}

	/**
	 * @return PlaceNameSEO - varchar(255)
	 */
	public function getPlaceNameSEO(){
		return $this->PlaceNameSEO;
	}

	/**
	 * @return PlaceNameRU - varchar(255)
	 */
	public function getPlaceNameRU(){
		return $this->PlaceNameRU;
	}

	/**
	 * @return PlaceNameFR - varchar(255)
	 */
	public function getPlaceNameFR(){
		return $this->PlaceNameFR;
	}

	/**
	 * @return PlaceNameDE - varchar(255)
	 */
	public function getPlaceNameDE(){
		return $this->PlaceNameDE;
	}

	/**
	 * @return PlaceNameIT - varchar(255)
	 */
	public function getPlaceNameIT(){
		return $this->PlaceNameIT;
	}

	/**
	 * @return PlaceNameSE - varchar(255)
	 */
	public function getPlaceNameSE(){
		return $this->PlaceNameSE;
	}

	/**
	 * @return PlaceNameNO - varchar(255)
	 */
	public function getPlaceNameNO(){
		return $this->PlaceNameNO;
	}

	/**
	 * @return PlaceNameES - varchar(255)
	 */
	public function getPlaceNameES(){
		return $this->PlaceNameES;
	}

	/**
	 * @return PlaceNameNL - varchar(255)
	 */
	public function getPlaceNameNL(){
		return $this->PlaceNameNL;
	}

	/**
	 * @return PlaceType - tinyint(4) unsigned
	 */
	public function getPlaceType(){
		return $this->PlaceType;
	}

	/**
	 * @return PlaceCity - varchar(100)
	 */
	public function getPlaceCity(){
		return $this->PlaceCity;
	}

	/**
	 * @return PlaceAddress - varchar(255)
	 */
	public function getPlaceAddress(){
		return $this->PlaceAddress;
	}

	/**
	 * @return PlaceDesc - text
	 */
	public function getPlaceDesc(){
		return $this->PlaceDesc;
	}

	/**
	 * @return PlaceDescEN - text
	 */
	public function getPlaceDescEN(){
		return $this->PlaceDescEN;
	}

	/**
	 * @return PlaceDescRU - text
	 */
	public function getPlaceDescRU(){
		return $this->PlaceDescRU;
	}

	/**
	 * @return PlaceDescFR - text
	 */
	public function getPlaceDescFR(){
		return $this->PlaceDescFR;
	}

	/**
	 * @return PlaceDescDE - text
	 */
	public function getPlaceDescDE(){
		return $this->PlaceDescDE;
	}

	/**
	 * @return PlaceDescIT - text
	 */
	public function getPlaceDescIT(){
		return $this->PlaceDescIT;
	}

	/**
	 * @return PlaceDescSE - text
	 */
	public function getPlaceDescSE(){
		return $this->PlaceDescSE;
	}

	/**
	 * @return PlaceDescNO - text
	 */
	public function getPlaceDescNO(){
		return $this->PlaceDescNO;
	}

	/**
	 * @return PlaceDescES - text
	 */
	public function getPlaceDescES(){
		return $this->PlaceDescES;
	}

	/**
	 * @return PlaceDescNL - text
	 */
	public function getPlaceDescNL(){
		return $this->PlaceDescNL;
	}

	/**
	 * @return Image - varchar(255)
	 */
	public function getImage(){
		return $this->Image;
	}

	/**
	 * @return Island - tinyint(1)
	 */
	public function getIsland(){
		return $this->Island;
	}

	/**
	 * @return PlaceActive - int(3)
	 */
	public function getPlaceActive(){
		return $this->PlaceActive;
	}

	/**
	 * @return Longitude - dec(9.5)
	 */
	public function getLongitude(){
		return $this->Longitude;
	}
	
	/**
	 * @return Latitude - dec(9.5)
	 */
	public function getLatitude(){
		return $this->Latitude;
	}	
	
	/**
	 * @return Elevation - dec(9.5)
	 */
	public function getElevation(){
		return $this->Elevation;
	}	
	
	/**
	 * @param Type: int(10) unsigned
	 */
	public function setPlaceID($PlaceID){
		$this->PlaceID = $PlaceID;
	}

	/**
	 * @param Type: int(10) unsigned
	 */
	public function setPlaceCountry($PlaceCountry){
		$this->PlaceCountry = $PlaceCountry;
	}

	/**
	 * @param Type: varchar(255)
	 */
	public function setCountryNameEN($CountryNameEN){
		$this->CountryNameEN = $CountryNameEN;
	}

	/**
	 * @param Type: varchar(255)
	 */
	public function setPlaceNameEN($PlaceNameEN){
		$this->PlaceNameEN = $PlaceNameEN;
	}

	/**
	 * @param Type: varchar(255)
	 */
	public function setPlaceNameSEO($PlaceNameSEO){
		$this->PlaceNameSEO = $PlaceNameSEO;
	}

	/**
	 * @param Type: varchar(255)
	 */
	public function setPlaceNameRU($PlaceNameRU){
		$this->PlaceNameRU = $PlaceNameRU;
	}

	/**
	 * @param Type: varchar(255)
	 */
	public function setPlaceNameFR($PlaceNameFR){
		$this->PlaceNameFR = $PlaceNameFR;
	}

	/**
	 * @param Type: varchar(255)
	 */
	public function setPlaceNameDE($PlaceNameDE){
		$this->PlaceNameDE = $PlaceNameDE;
	}

	/**
	 * @param Type: varchar(255)
	 */
	public function setPlaceNameIT($PlaceNameIT){
		$this->PlaceNameIT = $PlaceNameIT;
	}

	/**
	 * @param Type: varchar(255)
	 */
	public function setPlaceNameSE($PlaceNameSE){
		$this->PlaceNameSE = $PlaceNameSE;
	}

	/**
	 * @param Type: varchar(255)
	 */
	public function setPlaceNameNO($PlaceNameNO){
		$this->PlaceNameNO = $PlaceNameNO;
	}

	/**
	 * @param Type: varchar(255)
	 */
	public function setPlaceNameES($PlaceNameES){
		$this->PlaceNameES = $PlaceNameES;
	}

	/**
	 * @param Type: varchar(255)
	 */
	public function setPlaceNameNL($PlaceNameNL){
		$this->PlaceNameNL = $PlaceNameNL;
	}

	/**
	 * @param Type: tinyint(4) unsigned
	 */
	public function setPlaceType($PlaceType){
		$this->PlaceType = $PlaceType;
	}

	/**
	 * @param Type: varchar(100)
	 */
	public function setPlaceCity($PlaceCity){
		$this->PlaceCity = $PlaceCity;
	}

	/**
	 * @param Type: varchar(255)
	 */
	public function setPlaceAddress($PlaceAddress){
		$this->PlaceAddress = $PlaceAddress;
	}

	/**
	 * @param Type: text
	 */
	public function setPlaceDesc($PlaceDesc){
		$this->PlaceDesc = $PlaceDesc;
	}

	/**
	 * @param Type: text
	 */
	public function setPlaceDescEN($PlaceDescEN){
		$this->PlaceDescEN = $PlaceDescEN;
	}

	/**
	 * @param Type: text
	 */
	public function setPlaceDescRU($PlaceDescRU){
		$this->PlaceDescRU = $PlaceDescRU;
	}

	/**
	 * @param Type: text
	 */
	public function setPlaceDescFR($PlaceDescFR){
		$this->PlaceDescFR = $PlaceDescFR;
	}

	/**
	 * @param Type: text
	 */
	public function setPlaceDescDE($PlaceDescDE){
		$this->PlaceDescDE = $PlaceDescDE;
	}

	/**
	 * @param Type: text
	 */
	public function setPlaceDescIT($PlaceDescIT){
		$this->PlaceDescIT = $PlaceDescIT;
	}

	/**
	 * @param Type: text
	 */
	public function setPlaceDescSE($PlaceDescSE){
		$this->PlaceDescSE = $PlaceDescSE;
	}

	/**
	 * @param Type: text
	 */
	public function setPlaceDescNO($PlaceDescNO){
		$this->PlaceDescNO = $PlaceDescNO;
	}

	/**
	 * @param Type: text
	 */
	public function setPlaceDescES($PlaceDescES){
		$this->PlaceDescES = $PlaceDescES;
	}

	/**
	 * @param Type: text
	 */
	public function setPlaceDescNL($PlaceDescNL){
		$this->PlaceDescNL = $PlaceDescNL;
	}

	/**
	 * @param Type: varchar(255)
	 */
	public function setImage($Image){
		$this->Image = $Image;
	}

	/**
	 * @param Type: tinyint(1)
	 */
	public function setIsland($Island){
		$this->Island = $Island;
	}

	/**
	 * @param Type: int(3)
	 */
	public function setPlaceActive($PlaceActive){
		$this->PlaceActive = $PlaceActive;
	}

	/**
	 * @param Type: dec(9.5)
	 */
	public function setLongitude($Longitude){
		$this->Longitude = $Longitude;
	}
	
	/**
	 * @param Type: dec(9.5)
	 */
	public function setLatitude($Latitude){
		$this->Latitude = $Latitude;
	}
	
	/**
	 * @param Type: dec(9.5)
	 */
	public function setElevation($Elevation){
		$this->Elevation = $Elevation;
	}
	
    /**
     * fieldValues - Load all fieldNames and fieldValues into Array. 
     *
     * @param 
     * 
     */
	public function fieldValues(){
		$fieldValues = array(
			'PlaceID' => $this->getPlaceID(),
			'PlaceCountry' => $this->getPlaceCountry(),
			'CountryNameEN' => $this->getCountryNameEN(),
			'PlaceNameEN' => $this->getPlaceNameEN(),
			'PlaceNameSEO' => $this->getPlaceNameSEO(),
			'PlaceNameRU' => $this->getPlaceNameRU(),
			'PlaceNameFR' => $this->getPlaceNameFR(),
			'PlaceNameDE' => $this->getPlaceNameDE(),
			'PlaceNameIT' => $this->getPlaceNameIT(),
			'PlaceNameSE' => $this->getPlaceNameSE(),
			'PlaceNameNO' => $this->getPlaceNameNO(),
			'PlaceNameES' => $this->getPlaceNameES(),
			'PlaceNameNL' => $this->getPlaceNameNL(),
			'PlaceType' => $this->getPlaceType(),
			'PlaceCity' => $this->getPlaceCity(),
			'PlaceAddress' => $this->getPlaceAddress(),
			'PlaceDesc' => $this->getPlaceDesc(),
			'PlaceDescEN' => $this->getPlaceDescEN(),
			'PlaceDescRU' => $this->getPlaceDescRU(),
			'PlaceDescFR' => $this->getPlaceDescFR(),
			'PlaceDescDE' => $this->getPlaceDescDE(),
			'PlaceDescIT' => $this->getPlaceDescIT(),
			'PlaceDescSE' => $this->getPlaceDescSE(),
			'PlaceDescNO' => $this->getPlaceDescNO(),
			'PlaceDescES' => $this->getPlaceDescES(),
			'PlaceDescNL' => $this->getPlaceDescNL(),
			'Image' => $this->getImage(),
			'Island' => $this->getIsland(),
			'PlaceActive' => $this->getPlaceActive(),
			'Longitude' => $this->getLongitude(),
			'Latitude' => $this->getLatitude(),			
			'Elevation' => $this->getElevation()		);
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
			'PlaceID',			'PlaceCountry',			'CountryNameEN',			'PlaceNameEN',			'PlaceNameSEO',			'PlaceNameRU',			'PlaceNameFR',			'PlaceNameDE',			'PlaceNameIT',			'PlaceNameSE',			'PlaceNameNO',			'PlaceNameES',			'PlaceNameNL',			'PlaceType',			'PlaceCity',			'PlaceAddress',			'PlaceDesc',			'PlaceDescEN',			'PlaceDescRU',			'PlaceDescFR',			'PlaceDescDE',			'PlaceDescIT',			'PlaceDescSE',			'PlaceDescNO',			'PlaceDescES',			'PlaceDescNL',			'Image',			'Island',			'PlaceActive',		'Longitude',		'Latitude',			'Elevation'		);
		return $fieldNames;
	}
    /**
     * Close mysql connection
     */
	public function endv4_Places(){
		$this->connection->CloseMysql();
	}

}