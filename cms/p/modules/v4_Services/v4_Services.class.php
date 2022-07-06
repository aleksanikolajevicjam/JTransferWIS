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
require_once '../../../../db/db.class.php';

Class v4_Services {

	public $OwnerID; //int(10) unsigned
	public $ServiceID; //int(10) unsigned
	public $RouteID; //int(10) unsigned
	public $VehicleID; //int(10) unsigned
	public $VehicleTypeID; //int(10) unsigned
	public $VehicleAvailable; //tinyint(1) unsigned
	public $Correction; //decimal(10,2)
	public $ServicePrice1; //decimal(10,0)
	public $ServicePrice2; //decimal(10,0)
	public $ServicePrice3; //decimal(10,0)
	public $Discount; //decimal(10,0)
	public $ServiceETA; //int(11)
	public $Active; //tinyint(1)
	public $LastChange; //varchar(50)
	public $connection;

	public function v4_Services(){
		$this->connection = new DataBaseMysql();
	}	public function myreal_escape_string($string){
		return $this->connection->real_escape_string($string);
	}

    /**
     * New object to the class. Don´t forget to save this new object "as new" by using the function $class->saveAsNew(); 
     *
     */
	public function New_v4_Services($OwnerID,$RouteID,$VehicleID,$VehicleTypeID,$VehicleAvailable,$Correction,$ServicePrice1,$ServicePrice2,$ServicePrice3,$Discount,$ServiceETA,$Active,$LastChange){
		$this->OwnerID = $OwnerID;
		$this->RouteID = $RouteID;
		$this->VehicleID = $VehicleID;
		$this->VehicleTypeID = $VehicleTypeID;
		$this->VehicleAvailable = $VehicleAvailable;
		$this->Correction = $Correction;
		$this->ServicePrice1 = $ServicePrice1;
		$this->ServicePrice2 = $ServicePrice2;
		$this->ServicePrice3 = $ServicePrice3;
		$this->Discount = $Discount;
		$this->ServiceETA = $ServiceETA;
		$this->Active = $Active;
		$this->LastChange = $LastChange;
	}

    /**
     * Load one row into var_class. To use the vars use for exemple echo $class->getVar_name; 
     *
     * @param key_table_type $key_row
     * 
     */
	public function getRow($key_row){
		$result = $this->connection->RunQuery("Select * from v4_Services where ServiceID = \"$key_row\" ");
		if($result->num_rows < 1) return false;
		while($row = $result->fetch_array(MYSQLI_ASSOC)){
			$this->OwnerID = $row["OwnerID"];
			$this->ServiceID = $row["ServiceID"];
			$this->RouteID = $row["RouteID"];
			$this->VehicleID = $row["VehicleID"];
			$this->VehicleTypeID = $row["VehicleTypeID"];
			$this->VehicleAvailable = $row["VehicleAvailable"];
			$this->Correction = $row["Correction"];
			$this->ServicePrice1 = $row["ServicePrice1"];
			$this->ServicePrice2 = $row["ServicePrice2"];
			$this->ServicePrice3 = $row["ServicePrice3"];
			$this->Discount = $row["Discount"];
			$this->ServiceETA = $row["ServiceETA"];
			$this->Active = $row["Active"];
			$this->LastChange = $row["LastChange"];
		}
	}

    /**
     * Delete the row by using the key as arg
     *
     * @param key_table_type $key_row
     *
     */
	public function deleteRow($key_row){
		$this->connection->RunQuery("DELETE FROM v4_Services WHERE ServiceID = $key_row");
	}

    /**
     * Update the active row table on table
     */
	public function saveRow(){
		$result = $this->connection->RunQuery("UPDATE v4_Services set OwnerID = \"$this->OwnerID\", RouteID = \"$this->RouteID\", VehicleID = \"$this->VehicleID\", VehicleTypeID = \"$this->VehicleTypeID\", VehicleAvailable = \"$this->VehicleAvailable\", Correction = \"$this->Correction\", ServicePrice1 = \"$this->ServicePrice1\", ServicePrice2 = \"$this->ServicePrice2\", ServicePrice3 = \"$this->ServicePrice3\", Discount = \"$this->Discount\", ServiceETA = \"$this->ServiceETA\", Active = \"$this->Active\", LastChange = \"$this->LastChange\" where ServiceID = \"$this->ServiceID\"");
	return $result; 
}

    /**
     * Save the active var class as a new row on table
     */
	public function saveAsNew(){
		$this->connection->RunQuery("Insert into v4_Services (OwnerID, RouteID, VehicleID, VehicleTypeID, VehicleAvailable, Correction, ServicePrice1, ServicePrice2, ServicePrice3, Discount, ServiceETA, Active, LastChange) values (\"$this->OwnerID\", \"$this->RouteID\", \"$this->VehicleID\", \"$this->VehicleTypeID\", \"$this->VehicleAvailable\", \"$this->Correction\", \"$this->ServicePrice1\", \"$this->ServicePrice2\", \"$this->ServicePrice3\", \"$this->Discount\", \"$this->ServiceETA\", \"$this->Active\", \"$this->LastChange\")");
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
		$result = $this->connection->RunQuery("SELECT ServiceID from v4_Services $where ORDER BY $column $order");
			while($row = $result->fetch_array(MYSQLI_ASSOC)){
				$keys[$i] = $row["ServiceID"];
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
	 * @return ServiceID - int(10) unsigned
	 */
	public function getServiceID(){
		return $this->ServiceID;
	}

	/**
	 * @return RouteID - int(10) unsigned
	 */
	public function getRouteID(){
		return $this->RouteID;
	}

	/**
	 * @return VehicleID - int(10) unsigned
	 */
	public function getVehicleID(){
		return $this->VehicleID;
	}

	/**
	 * @return VehicleTypeID - int(10) unsigned
	 */
	public function getVehicleTypeID(){
		return $this->VehicleTypeID;
	}

	/**
	 * @return VehicleAvailable - tinyint(1) unsigned
	 */
	public function getVehicleAvailable(){
		return $this->VehicleAvailable;
	}

	/**
	 * @return Correction - decimal(10,2)
	 */
	public function getCorrection(){
		return $this->Correction;
	}

	/**
	 * @return ServicePrice1 - decimal(10,0)
	 */
	public function getServicePrice1(){
		return $this->ServicePrice1;
	}

	/**
	 * @return ServicePrice2 - decimal(10,0)
	 */
	public function getServicePrice2(){
		return $this->ServicePrice2;
	}

	/**
	 * @return ServicePrice3 - decimal(10,0)
	 */
	public function getServicePrice3(){
		return $this->ServicePrice3;
	}

	/**
	 * @return Discount - decimal(10,0)
	 */
	public function getDiscount(){
		return $this->Discount;
	}

	/**
	 * @return ServiceETA - int(11)
	 */
	public function getServiceETA(){
		return $this->ServiceETA;
	}

	/**
	 * @return Active - tinyint(1)
	 */
	public function getActive(){
		return $this->Active;
	}

	/**
	 * @return LastChange - varchar(50)
	 */
	public function getLastChange(){
		return $this->LastChange;
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
	public function setServiceID($ServiceID){
		$this->ServiceID = $ServiceID;
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
	public function setVehicleID($VehicleID){
		$this->VehicleID = $VehicleID;
	}

	/**
	 * @param Type: int(10) unsigned
	 */
	public function setVehicleTypeID($VehicleTypeID){
		$this->VehicleTypeID = $VehicleTypeID;
	}

	/**
	 * @param Type: tinyint(1) unsigned
	 */
	public function setVehicleAvailable($VehicleAvailable){
		$this->VehicleAvailable = $VehicleAvailable;
	}

	/**
	 * @param Type: decimal(10,2)
	 */
	public function setCorrection($Correction){
		$this->Correction = $Correction;
	}

	/**
	 * @param Type: decimal(10,0)
	 */
	public function setServicePrice1($ServicePrice1){
		$this->ServicePrice1 = $ServicePrice1;
	}

	/**
	 * @param Type: decimal(10,0)
	 */
	public function setServicePrice2($ServicePrice2){
		$this->ServicePrice2 = $ServicePrice2;
	}

	/**
	 * @param Type: decimal(10,0)
	 */
	public function setServicePrice3($ServicePrice3){
		$this->ServicePrice3 = $ServicePrice3;
	}

	/**
	 * @param Type: decimal(10,0)
	 */
	public function setDiscount($Discount){
		$this->Discount = $Discount;
	}

	/**
	 * @param Type: int(11)
	 */
	public function setServiceETA($ServiceETA){
		$this->ServiceETA = $ServiceETA;
	}

	/**
	 * @param Type: tinyint(1)
	 */
	public function setActive($Active){
		$this->Active = $Active;
	}

	/**
	 * @param Type: varchar(50)
	 */
	public function setLastChange($LastChange){
		$this->LastChange = $LastChange;
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
			'ServiceID' => $this->getServiceID(),
			'RouteID' => $this->getRouteID(),
			'VehicleID' => $this->getVehicleID(),
			'VehicleTypeID' => $this->getVehicleTypeID(),
			'VehicleAvailable' => $this->getVehicleAvailable(),
			'Correction' => $this->getCorrection(),
			'ServicePrice1' => $this->getServicePrice1(),
			'ServicePrice2' => $this->getServicePrice2(),
			'ServicePrice3' => $this->getServicePrice3(),
			'Discount' => $this->getDiscount(),
			'ServiceETA' => $this->getServiceETA(),
			'Active' => $this->getActive(),
			'LastChange' => $this->getLastChange()		);
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
			'OwnerID',			'ServiceID',			'RouteID',			'VehicleID',			'VehicleTypeID',			'VehicleAvailable',			'Correction',			'ServicePrice1',			'ServicePrice2',			'ServicePrice3',			'Discount',			'ServiceETA',			'Active',			'LastChange'		);
		return $fieldNames;
	}
    /**
     * Close mysql connection
     */
	public function endv4_Services(){
		$this->connection->CloseMysql();
	}

}
