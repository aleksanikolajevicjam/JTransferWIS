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

Class v4_Routes {

	public $OwnerID; //int(10) unsigned
	public $RouteID; //int(10) unsigned
	public $FromID; //int(10) unsigned
	public $ToID; //int(10) unsigned
	public $Approved; //tinyint(1)
	public $RouteName; //varchar(255)
	public $RouteNameEN; //varchar(255)
	public $RouteNameRU; //varchar(255)
	public $RouteNameFR; //varchar(255)
	public $RouteNameDE; //varchar(255)
	public $RouteNameIT; //varchar(255)
	public $RouteNameSE; //varchar(255)
	public $RouteNameNO; //varchar(255)
	public $RouteNameES; //varchar(255)
	public $RouteNameNL; //varchar(255)
	public $Km; //int(5) unsigned
	public $Duration; //int(5) unsigned
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
	public function New_v4_Routes($OwnerID,$FromID,$ToID,$Approved,$RouteName,$RouteNameEN,$RouteNameRU,$RouteNameFR,$RouteNameDE,$RouteNameIT,$RouteNameSE,$RouteNameNO,$RouteNameES,$RouteNameNL,$Km,$Duration){
		$this->OwnerID = $OwnerID;
		$this->FromID = $FromID;
		$this->ToID = $ToID;
		$this->Approved = $Approved;
		$this->RouteName = $RouteName;
		$this->RouteNameEN = $RouteNameEN;
		$this->RouteNameRU = $RouteNameRU;
		$this->RouteNameFR = $RouteNameFR;
		$this->RouteNameDE = $RouteNameDE;
		$this->RouteNameIT = $RouteNameIT;
		$this->RouteNameSE = $RouteNameSE;
		$this->RouteNameNO = $RouteNameNO;
		$this->RouteNameES = $RouteNameES;
		$this->RouteNameNL = $RouteNameNL;
		$this->Km = $Km;
		$this->Duration = $Duration;
	}

    /**
     * Load one row into var_class. To use the vars use for exemple echo $class->getVar_name; 
     *
     * @param key_table_type $key_row
     * 
     */
	public function getRow($key_row){
		$result = $this->connection->RunQuery("Select * from v4_Routes where RouteID = \"$key_row\" ");
		if($result->num_rows < 1) return false;
		while($row = $result->fetch_array(MYSQLI_ASSOC)){
			$this->OwnerID = $row["OwnerID"];
			$this->RouteID = $row["RouteID"];
			$this->FromID = $row["FromID"];
			$this->ToID = $row["ToID"];
			$this->Approved = $row["Approved"];
			$this->RouteName = $row["RouteName"];
			$this->RouteNameEN = $row["RouteNameEN"];
			$this->RouteNameRU = $row["RouteNameRU"];
			$this->RouteNameFR = $row["RouteNameFR"];
			$this->RouteNameDE = $row["RouteNameDE"];
			$this->RouteNameIT = $row["RouteNameIT"];
			$this->RouteNameSE = $row["RouteNameSE"];
			$this->RouteNameNO = $row["RouteNameNO"];
			$this->RouteNameES = $row["RouteNameES"];
			$this->RouteNameNL = $row["RouteNameNL"];
			$this->Km = $row["Km"];
			$this->Duration = $row["Duration"];
		}
	}

    /**
     * Delete the row by using the key as arg
     *
     * @param key_table_type $key_row
     *
     */
	public function deleteRow($key_row){
		$this->connection->RunQuery("DELETE FROM v4_Routes WHERE RouteID = $key_row");
	}

    /**
     * Update the active row table on table
     */
	public function saveRow(){
		$result = $this->connection->RunQuery("UPDATE v4_Routes set 
OwnerID = '".$this->myreal_escape_string($this->OwnerID)."', 
FromID = '".$this->myreal_escape_string($this->FromID)."', 
ToID = '".$this->myreal_escape_string($this->ToID)."', 
Approved = '".$this->myreal_escape_string($this->Approved)."', 
RouteName = '".$this->myreal_escape_string($this->RouteName)."', 
RouteNameEN = '".$this->myreal_escape_string($this->RouteNameEN)."', 
RouteNameRU = '".$this->myreal_escape_string($this->RouteNameRU)."', 
RouteNameFR = '".$this->myreal_escape_string($this->RouteNameFR)."', 
RouteNameDE = '".$this->myreal_escape_string($this->RouteNameDE)."', 
RouteNameIT = '".$this->myreal_escape_string($this->RouteNameIT)."', 
RouteNameSE = '".$this->myreal_escape_string($this->RouteNameSE)."', 
RouteNameNO = '".$this->myreal_escape_string($this->RouteNameNO)."', 
RouteNameES = '".$this->myreal_escape_string($this->RouteNameES)."', 
RouteNameNL = '".$this->myreal_escape_string($this->RouteNameNL)."', 
Km = '".$this->myreal_escape_string($this->Km)."', 
Duration = '".$this->myreal_escape_string($this->Duration)."' WHERE RouteID = '".$this->RouteID."'");
	return $result; 
}

    /**
     * Save the active var class as a new row on table
     */
	public function saveAsNew(){
		$this->connection->RunQuery("INSERT INTO v4_Routes (OwnerID, FromID, ToID, Approved, RouteName, RouteNameEN, RouteNameRU, RouteNameFR, RouteNameDE, RouteNameIT, RouteNameSE, RouteNameNO, RouteNameES, RouteNameNL, Km, Duration) values ('".$this->myreal_escape_string($this->OwnerID)."', '".$this->myreal_escape_string($this->FromID)."', '".$this->myreal_escape_string($this->ToID)."', '".$this->myreal_escape_string($this->Approved)."', '".$this->myreal_escape_string($this->RouteName)."', '".$this->myreal_escape_string($this->RouteNameEN)."', '".$this->myreal_escape_string($this->RouteNameRU)."', '".$this->myreal_escape_string($this->RouteNameFR)."', '".$this->myreal_escape_string($this->RouteNameDE)."', '".$this->myreal_escape_string($this->RouteNameIT)."', '".$this->myreal_escape_string($this->RouteNameSE)."', '".$this->myreal_escape_string($this->RouteNameNO)."', '".$this->myreal_escape_string($this->RouteNameES)."', '".$this->myreal_escape_string($this->RouteNameNL)."', '".$this->myreal_escape_string($this->Km)."', '".$this->myreal_escape_string($this->Duration)."')");
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
		$result = $this->connection->RunQuery("SELECT RouteID from v4_Routes $where ORDER BY $column $order");
			while($row = $result->fetch_array(MYSQLI_ASSOC)){
				$keys[$i] = $row["RouteID"];
				$i++;
			}
	return $keys;
	}

	/**
	 * @return OwnerID - int(10) unsigned
	 */
	public function getOwnerID(){
		return $this->OwnerID;
	}

	/**
	 * @return RouteID - int(10) unsigned
	 */
	public function getRouteID(){
		return $this->RouteID;
	}

	/**
	 * @return FromID - int(10) unsigned
	 */
	public function getFromID(){
		return $this->FromID;
	}

	/**
	 * @return ToID - int(10) unsigned
	 */
	public function getToID(){
		return $this->ToID;
	}

	/**
	 * @return Approved - tinyint(1)
	 */
	public function getApproved(){
		return $this->Approved;
	}

	/**
	 * @return RouteName - varchar(255)
	 */
	public function getRouteName(){
		return $this->RouteName;
	}

	/**
	 * @return RouteNameEN - varchar(255)
	 */
	public function getRouteNameEN(){
		return $this->RouteNameEN;
	}

	/**
	 * @return RouteNameRU - varchar(255)
	 */
	public function getRouteNameRU(){
		return $this->RouteNameRU;
	}

	/**
	 * @return RouteNameFR - varchar(255)
	 */
	public function getRouteNameFR(){
		return $this->RouteNameFR;
	}

	/**
	 * @return RouteNameDE - varchar(255)
	 */
	public function getRouteNameDE(){
		return $this->RouteNameDE;
	}

	/**
	 * @return RouteNameIT - varchar(255)
	 */
	public function getRouteNameIT(){
		return $this->RouteNameIT;
	}

	/**
	 * @return RouteNameSE - varchar(255)
	 */
	public function getRouteNameSE(){
		return $this->RouteNameSE;
	}

	/**
	 * @return RouteNameNO - varchar(255)
	 */
	public function getRouteNameNO(){
		return $this->RouteNameNO;
	}

	/**
	 * @return RouteNameES - varchar(255)
	 */
	public function getRouteNameES(){
		return $this->RouteNameES;
	}

	/**
	 * @return RouteNameNL - varchar(255)
	 */
	public function getRouteNameNL(){
		return $this->RouteNameNL;
	}

	/**
	 * @return Km - int(5) unsigned
	 */
	public function getKm(){
		return $this->Km;
	}

	/**
	 * @return Duration - int(5) unsigned
	 */
	public function getDuration(){
		return $this->Duration;
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
	public function setRouteID($RouteID){
		$this->RouteID = $RouteID;
	}

	/**
	 * @param Type: int(10) unsigned
	 */
	public function setFromID($FromID){
		$this->FromID = $FromID;
	}

	/**
	 * @param Type: int(10) unsigned
	 */
	public function setToID($ToID){
		$this->ToID = $ToID;
	}

	/**
	 * @param Type: tinyint(1)
	 */
	public function setApproved($Approved){
		$this->Approved = $Approved;
	}

	/**
	 * @param Type: varchar(255)
	 */
	public function setRouteName($RouteName){
		$this->RouteName = $RouteName;
	}

	/**
	 * @param Type: varchar(255)
	 */
	public function setRouteNameEN($RouteNameEN){
		$this->RouteNameEN = $RouteNameEN;
	}

	/**
	 * @param Type: varchar(255)
	 */
	public function setRouteNameRU($RouteNameRU){
		$this->RouteNameRU = $RouteNameRU;
	}

	/**
	 * @param Type: varchar(255)
	 */
	public function setRouteNameFR($RouteNameFR){
		$this->RouteNameFR = $RouteNameFR;
	}

	/**
	 * @param Type: varchar(255)
	 */
	public function setRouteNameDE($RouteNameDE){
		$this->RouteNameDE = $RouteNameDE;
	}

	/**
	 * @param Type: varchar(255)
	 */
	public function setRouteNameIT($RouteNameIT){
		$this->RouteNameIT = $RouteNameIT;
	}

	/**
	 * @param Type: varchar(255)
	 */
	public function setRouteNameSE($RouteNameSE){
		$this->RouteNameSE = $RouteNameSE;
	}

	/**
	 * @param Type: varchar(255)
	 */
	public function setRouteNameNO($RouteNameNO){
		$this->RouteNameNO = $RouteNameNO;
	}

	/**
	 * @param Type: varchar(255)
	 */
	public function setRouteNameES($RouteNameES){
		$this->RouteNameES = $RouteNameES;
	}

	/**
	 * @param Type: varchar(255)
	 */
	public function setRouteNameNL($RouteNameNL){
		$this->RouteNameNL = $RouteNameNL;
	}

	/**
	 * @param Type: int(5) unsigned
	 */
	public function setKm($Km){
		$this->Km = $Km;
	}

	/**
	 * @param Type: int(5) unsigned
	 */
	public function setDuration($Duration){
		$this->Duration = $Duration;
	}

    /**
     * fieldValues - Load all fieldNames and fieldValues into Array. 
     *
     * @param 
     * 
     */
	public function fieldValues(){
		$fieldValues = array(
			'OwnerID' => $this->getOwnerID(),
			'RouteID' => $this->getRouteID(),
			'FromID' => $this->getFromID(),
			'ToID' => $this->getToID(),
			'Approved' => $this->getApproved(),
			'RouteName' => $this->getRouteName(),
			'RouteNameEN' => $this->getRouteNameEN(),
			'RouteNameRU' => $this->getRouteNameRU(),
			'RouteNameFR' => $this->getRouteNameFR(),
			'RouteNameDE' => $this->getRouteNameDE(),
			'RouteNameIT' => $this->getRouteNameIT(),
			'RouteNameSE' => $this->getRouteNameSE(),
			'RouteNameNO' => $this->getRouteNameNO(),
			'RouteNameES' => $this->getRouteNameES(),
			'RouteNameNL' => $this->getRouteNameNL(),
			'Km' => $this->getKm(),
			'Duration' => $this->getDuration()		);
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
			'OwnerID',			'RouteID',			'FromID',			'ToID',			'Approved',			'RouteName',			'RouteNameEN',			'RouteNameRU',			'RouteNameFR',			'RouteNameDE',			'RouteNameIT',			'RouteNameSE',			'RouteNameNO',			'RouteNameES',			'RouteNameNL',			'Km',			'Duration'		);
		return $fieldNames;
	}
    /**
     * Close mysql connection
     */
	public function endv4_Routes(){
		$this->connection->CloseMysql();
	}

}