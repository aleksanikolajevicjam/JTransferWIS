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

Class v4_Vehicles {

	public $VehicleID; //int(10) unsigned
	public $OwnerID; //int(10) unsigned
	public $VehicleName; //varchar(255)
	public $VehicleTypeID; //int(10) unsigned
	public $SurCategory; //smallint(3)
	public $SurID; //int(10)
	public $PriceKm; //decimal(6,2) unsigned
	public $ReturnDiscount; //int(3) unsigned
	public $VehicleDescription; //text
	public $VehicleCapacity; //int(10) unsigned
	public $VehicleImage; //varchar(255)
	public $VehicleImage2; //varchar(255)
	public $VehicleImage3; //varchar(255)
	public $VehicleImage4; //varchar(255)
	public $AirCondition; //tinyint(1)
	public $ChildSeat; //tinyint(1)
	public $Music; //tinyint(1)
	public $TV; //tinyint(1)
	public $GPS; //tinyint(1)
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
	public function New_v4_Vehicles($OwnerID,$VehicleName,$VehicleTypeID,$SurCategory,$SurID,$PriceKm,$ReturnDiscount,$VehicleDescription,$VehicleCapacity,$VehicleImage,$VehicleImage2,$VehicleImage3,$VehicleImage4,$AirCondition,$ChildSeat,$Music,$TV,$GPS){
		$this->OwnerID = $OwnerID;
		$this->VehicleName = $VehicleName;
		$this->VehicleTypeID = $VehicleTypeID;
		$this->SurCategory = $SurCategory;
		$this->SurID = $SurID;
		$this->PriceKm = $PriceKm;
		$this->ReturnDiscount = $ReturnDiscount;
		$this->VehicleDescription = $VehicleDescription;
		$this->VehicleCapacity = $VehicleCapacity;
		$this->VehicleImage = $VehicleImage;
		$this->VehicleImage2 = $VehicleImage2;
		$this->VehicleImage3 = $VehicleImage3;
		$this->VehicleImage4 = $VehicleImage4;
		$this->AirCondition = $AirCondition;
		$this->ChildSeat = $ChildSeat;
		$this->Music = $Music;
		$this->TV = $TV;
		$this->GPS = $GPS;
	}

    /**
     * Load one row into var_class. To use the vars use for exemple echo $class->getVar_name; 
     *
     * @param key_table_type $key_row
     * 
     */
	public function getRow($key_row){
		$result = $this->connection->RunQuery("Select * from v4_Vehicles where VehicleID = \"$key_row\" ");
		if($result->num_rows < 1) return false;
		while($row = $result->fetch_array(MYSQLI_ASSOC)){
			$this->VehicleID = $row["VehicleID"];
			$this->OwnerID = $row["OwnerID"];
			$this->VehicleName = $row["VehicleName"];
			$this->VehicleTypeID = $row["VehicleTypeID"];
			$this->SurCategory = $row["SurCategory"];
			$this->SurID = $row["SurID"];
			$this->PriceKm = $row["PriceKm"];
			$this->ReturnDiscount = $row["ReturnDiscount"];
			$this->VehicleDescription = $row["VehicleDescription"];
			$this->VehicleCapacity = $row["VehicleCapacity"];
			$this->VehicleImage = $row["VehicleImage"];
			$this->VehicleImage2 = $row["VehicleImage2"];
			$this->VehicleImage3 = $row["VehicleImage3"];
			$this->VehicleImage4 = $row["VehicleImage4"];
			$this->AirCondition = $row["AirCondition"];
			$this->ChildSeat = $row["ChildSeat"];
			$this->Music = $row["Music"];
			$this->TV = $row["TV"];
			$this->GPS = $row["GPS"];
		}
	}

    /**
     * Delete the row by using the key as arg
     *
     * @param key_table_type $key_row
     *
     */
	public function deleteRow($key_row){
		$this->connection->RunQuery("DELETE FROM v4_Vehicles WHERE VehicleID = $key_row");
	}

    /**
     * Update the active row table on table
     */
	public function saveRow(){
		$result = $this->connection->RunQuery("UPDATE v4_Vehicles set 
OwnerID = '".$this->myreal_escape_string($this->OwnerID)."', 
VehicleName = '".$this->myreal_escape_string($this->VehicleName)."', 
VehicleTypeID = '".$this->myreal_escape_string($this->VehicleTypeID)."', 
SurCategory = '".$this->myreal_escape_string($this->SurCategory)."', 
SurID = '".$this->myreal_escape_string($this->SurID)."', 
PriceKm = '".$this->myreal_escape_string($this->PriceKm)."', 
ReturnDiscount = '".$this->myreal_escape_string($this->ReturnDiscount)."', 
VehicleDescription = '".$this->myreal_escape_string($this->VehicleDescription)."', 
VehicleCapacity = '".$this->myreal_escape_string($this->VehicleCapacity)."', 
VehicleImage = '".$this->myreal_escape_string($this->VehicleImage)."', 
VehicleImage2 = '".$this->myreal_escape_string($this->VehicleImage2)."', 
VehicleImage3 = '".$this->myreal_escape_string($this->VehicleImage3)."', 
VehicleImage4 = '".$this->myreal_escape_string($this->VehicleImage4)."', 
AirCondition = '".$this->myreal_escape_string($this->AirCondition)."', 
ChildSeat = '".$this->myreal_escape_string($this->ChildSeat)."', 
Music = '".$this->myreal_escape_string($this->Music)."', 
TV = '".$this->myreal_escape_string($this->TV)."', 
GPS = '".$this->myreal_escape_string($this->GPS)."' WHERE VehicleID = '".$this->VehicleID."'");
	return $result; 
}

    /**
     * Save the active var class as a new row on table
     */
	public function saveAsNew(){
		$this->connection->RunQuery("INSERT INTO v4_Vehicles (OwnerID, VehicleName, VehicleTypeID, SurCategory, SurID, PriceKm, ReturnDiscount, VehicleDescription, VehicleCapacity, VehicleImage, VehicleImage2, VehicleImage3, VehicleImage4, AirCondition, ChildSeat, Music, TV, GPS) values ('".$this->myreal_escape_string($this->OwnerID)."', '".$this->myreal_escape_string($this->VehicleName)."', '".$this->myreal_escape_string($this->VehicleTypeID)."', '".$this->myreal_escape_string($this->SurCategory)."', '".$this->myreal_escape_string($this->SurID)."', '".$this->myreal_escape_string($this->PriceKm)."', '".$this->myreal_escape_string($this->ReturnDiscount)."', '".$this->myreal_escape_string($this->VehicleDescription)."', '".$this->myreal_escape_string($this->VehicleCapacity)."', '".$this->myreal_escape_string($this->VehicleImage)."', '".$this->myreal_escape_string($this->VehicleImage2)."', '".$this->myreal_escape_string($this->VehicleImage3)."', '".$this->myreal_escape_string($this->VehicleImage4)."', '".$this->myreal_escape_string($this->AirCondition)."', '".$this->myreal_escape_string($this->ChildSeat)."', '".$this->myreal_escape_string($this->Music)."', '".$this->myreal_escape_string($this->TV)."', '".$this->myreal_escape_string($this->GPS)."')");
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
		$result = $this->connection->RunQuery("SELECT VehicleID from v4_Vehicles $where ORDER BY $column $order");
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
	 * @return VehicleName - varchar(255)
	 */
	public function getVehicleName(){
		return $this->VehicleName;
	}

	/**
	 * @return VehicleTypeID - int(10) unsigned
	 */
	public function getVehicleTypeID(){
		return $this->VehicleTypeID;
	}

	/**
	 * @return SurCategory - smallint(3)
	 */
	public function getSurCategory(){
		return $this->SurCategory;
	}

	/**
	 * @return SurID - int(10)
	 */
	public function getSurID(){
		return $this->SurID;
	}

	/**
	 * @return PriceKm - decimal(6,2) unsigned
	 */
	public function getPriceKm(){
		return $this->PriceKm;
	}

	/**
	 * @return ReturnDiscount - int(3) unsigned
	 */
	public function getReturnDiscount(){
		return $this->ReturnDiscount;
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
	 * @return VehicleImage - varchar(255)
	 */
	public function getVehicleImage(){
		return $this->VehicleImage;
	}

	/**
	 * @return VehicleImage2 - varchar(255)
	 */
	public function getVehicleImage2(){
		return $this->VehicleImage2;
	}

	/**
	 * @return VehicleImage3 - varchar(255)
	 */
	public function getVehicleImage3(){
		return $this->VehicleImage3;
	}

	/**
	 * @return VehicleImage4 - varchar(255)
	 */
	public function getVehicleImage4(){
		return $this->VehicleImage4;
	}

	/**
	 * @return AirCondition - tinyint(1)
	 */
	public function getAirCondition(){
		return $this->AirCondition;
	}

	/**
	 * @return ChildSeat - tinyint(1)
	 */
	public function getChildSeat(){
		return $this->ChildSeat;
	}

	/**
	 * @return Music - tinyint(1)
	 */
	public function getMusic(){
		return $this->Music;
	}

	/**
	 * @return TV - tinyint(1)
	 */
	public function getTV(){
		return $this->TV;
	}

	/**
	 * @return GPS - tinyint(1)
	 */
	public function getGPS(){
		return $this->GPS;
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
	 * @param Type: varchar(255)
	 */
	public function setVehicleName($VehicleName){
		$this->VehicleName = $VehicleName;
	}

	/**
	 * @param Type: int(10) unsigned
	 */
	public function setVehicleTypeID($VehicleTypeID){
		$this->VehicleTypeID = $VehicleTypeID;
	}

	/**
	 * @param Type: smallint(3)
	 */
	public function setSurCategory($SurCategory){
		$this->SurCategory = $SurCategory;
	}

	/**
	 * @param Type: int(10)
	 */
	public function setSurID($SurID){
		$this->SurID = $SurID;
	}

	/**
	 * @param Type: decimal(6,2) unsigned
	 */
	public function setPriceKm($PriceKm){
		$this->PriceKm = $PriceKm;
	}

	/**
	 * @param Type: int(3) unsigned
	 */
	public function setReturnDiscount($ReturnDiscount){
		$this->ReturnDiscount = $ReturnDiscount;
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
	 * @param Type: varchar(255)
	 */
	public function setVehicleImage($VehicleImage){
		$this->VehicleImage = $VehicleImage;
	}

	/**
	 * @param Type: varchar(255)
	 */
	public function setVehicleImage2($VehicleImage2){
		$this->VehicleImage2 = $VehicleImage2;
	}

	/**
	 * @param Type: varchar(255)
	 */
	public function setVehicleImage3($VehicleImage3){
		$this->VehicleImage3 = $VehicleImage3;
	}

	/**
	 * @param Type: varchar(255)
	 */
	public function setVehicleImage4($VehicleImage4){
		$this->VehicleImage4 = $VehicleImage4;
	}

	/**
	 * @param Type: tinyint(1)
	 */
	public function setAirCondition($AirCondition){
		$this->AirCondition = $AirCondition;
	}

	/**
	 * @param Type: tinyint(1)
	 */
	public function setChildSeat($ChildSeat){
		$this->ChildSeat = $ChildSeat;
	}

	/**
	 * @param Type: tinyint(1)
	 */
	public function setMusic($Music){
		$this->Music = $Music;
	}

	/**
	 * @param Type: tinyint(1)
	 */
	public function setTV($TV){
		$this->TV = $TV;
	}

	/**
	 * @param Type: tinyint(1)
	 */
	public function setGPS($GPS){
		$this->GPS = $GPS;
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
			'VehicleName' => $this->getVehicleName(),
			'VehicleTypeID' => $this->getVehicleTypeID(),
			'SurCategory' => $this->getSurCategory(),
			'SurID' => $this->getSurID(),
			'PriceKm' => $this->getPriceKm(),
			'ReturnDiscount' => $this->getReturnDiscount(),
			'VehicleDescription' => $this->getVehicleDescription(),
			'VehicleCapacity' => $this->getVehicleCapacity(),
			'VehicleImage' => $this->getVehicleImage(),
			'VehicleImage2' => $this->getVehicleImage2(),
			'VehicleImage3' => $this->getVehicleImage3(),
			'VehicleImage4' => $this->getVehicleImage4(),
			'AirCondition' => $this->getAirCondition(),
			'ChildSeat' => $this->getChildSeat(),
			'Music' => $this->getMusic(),
			'TV' => $this->getTV(),
			'GPS' => $this->getGPS()		);
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
			'VehicleID',			'OwnerID',			'VehicleName',			'VehicleTypeID',			'SurCategory',			'SurID',			'PriceKm',			'ReturnDiscount',			'VehicleDescription',			'VehicleCapacity',			'VehicleImage',			'VehicleImage2',			'VehicleImage3',			'VehicleImage4',			'AirCondition',			'ChildSeat',			'Music',			'TV',			'GPS'		);
		return $fieldNames;
	}
    /**
     * Close mysql connection
     */
	public function endv4_Vehicles(){
		$this->connection->CloseMysql();
	}

}