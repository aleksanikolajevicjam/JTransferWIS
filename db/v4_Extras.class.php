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

Class v4_Extras {

	public $ID; //int(10) unsigned
	public $OwnerID; //int(10) unsigned
	public $ServiceID; //int(10)
	public $Service; //varchar(255)
	public $ServiceEN; //varchar(255)
	public $ServiceRU; //varchar(255)
	public $ServiceFR; //varchar(255)
	public $ServiceDE; //varchar(255)
	public $ServiceIT; //varchar(255)
	public $ServiceSE; //varchar(255)
	public $ServiceNO; //varchar(255)
	public $ServiceES; //varchar(255)
	public $ServiceNL; //varchar(255)
	public $DriverPrice; //decimal(10,2)
	public $Provision; //decimal(10,2)
	public $Price; //decimal(10,2)
	public $Description; //text
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
	public function New_v4_Extras($OwnerID,$ServiceID,$Service,$ServiceEN,$ServiceRU,$ServiceFR,$ServiceDE,$ServiceIT,$ServiceSE,$ServiceNO,$ServiceES,$ServiceNL,$DriverPrice,$Provision,$Price,$Description){
		$this->OwnerID = $OwnerID;
		$this->ServiceID = $ServiceID;
		$this->Service = $Service;
		$this->ServiceEN = $ServiceEN;
		$this->ServiceRU = $ServiceRU;
		$this->ServiceFR = $ServiceFR;
		$this->ServiceDE = $ServiceDE;
		$this->ServiceIT = $ServiceIT;
		$this->ServiceSE = $ServiceSE;
		$this->ServiceNO = $ServiceNO;
		$this->ServiceES = $ServiceES;
		$this->ServiceNL = $ServiceNL;
		$this->DriverPrice = $DriverPrice;
		$this->Provision = $Provision;
		$this->Price = $Price;
		$this->Description = $Description;
	}

    /**
     * Load one row into var_class. To use the vars use for exemple echo $class->getVar_name; 
     *
     * @param key_table_type $key_row
     * 
     */
	public function getRow($key_row){
		$result = $this->connection->RunQuery("Select * from v4_Extras where ID = \"$key_row\" ");
		if($result->num_rows < 1) return false;
		while($row = $result->fetch_array(MYSQLI_ASSOC)){
			$this->ID = $row["ID"];
			$this->OwnerID = $row["OwnerID"];
			$this->ServiceID = $row["ServiceID"];
			$this->Service = $row["Service"];
			$this->ServiceEN = $row["ServiceEN"];
			$this->ServiceRU = $row["ServiceRU"];
			$this->ServiceFR = $row["ServiceFR"];
			$this->ServiceDE = $row["ServiceDE"];
			$this->ServiceIT = $row["ServiceIT"];
			$this->ServiceSE = $row["ServiceSE"];
			$this->ServiceNO = $row["ServiceNO"];
			$this->ServiceES = $row["ServiceES"];
			$this->ServiceNL = $row["ServiceNL"];
			$this->DriverPrice = $row["DriverPrice"];
			$this->Provision = $row["Provision"];
			$this->Price = $row["Price"];
			$this->Description = $row["Description"];
		}
	}

    /**
     * Delete the row by using the key as arg
     *
     * @param key_table_type $key_row
     *
     */
	public function deleteRow($key_row){
		$this->connection->RunQuery("DELETE FROM v4_Extras WHERE ID = $key_row");
	}

    /**
     * Update the active row table on table
     */
	public function saveRow(){
		$result = $this->connection->RunQuery("UPDATE v4_Extras set 
OwnerID = '".$this->myreal_escape_string($this->OwnerID)."', 
ServiceID = '".$this->myreal_escape_string($this->ServiceID)."', 
Service = '".$this->myreal_escape_string($this->Service)."', 
ServiceEN = '".$this->myreal_escape_string($this->ServiceEN)."', 
ServiceRU = '".$this->myreal_escape_string($this->ServiceRU)."', 
ServiceFR = '".$this->myreal_escape_string($this->ServiceFR)."', 
ServiceDE = '".$this->myreal_escape_string($this->ServiceDE)."', 
ServiceIT = '".$this->myreal_escape_string($this->ServiceIT)."', 
ServiceSE = '".$this->myreal_escape_string($this->ServiceSE)."', 
ServiceNO = '".$this->myreal_escape_string($this->ServiceNO)."', 
ServiceES = '".$this->myreal_escape_string($this->ServiceES)."', 
ServiceNL = '".$this->myreal_escape_string($this->ServiceNL)."', 
DriverPrice = '".$this->myreal_escape_string($this->DriverPrice)."', 
Provision = '".$this->myreal_escape_string($this->Provision)."', 
Price = '".$this->myreal_escape_string($this->Price)."', 
Description = '".$this->myreal_escape_string($this->Description)."' WHERE ID = '".$this->ID."'");
	return $result; 
}

    /**
     * Save the active var class as a new row on table
     */
	public function saveAsNew(){
		$this->connection->RunQuery("INSERT INTO v4_Extras (OwnerID, ServiceID, Service, ServiceEN, ServiceRU, ServiceFR, ServiceDE, ServiceIT, ServiceSE, ServiceNO, ServiceES, ServiceNL, DriverPrice, Provision, Price, Description) values ('".$this->myreal_escape_string($this->OwnerID)."', '".$this->myreal_escape_string($this->ServiceID)."', '".$this->myreal_escape_string($this->Service)."', '".$this->myreal_escape_string($this->ServiceEN)."', '".$this->myreal_escape_string($this->ServiceRU)."', '".$this->myreal_escape_string($this->ServiceFR)."', '".$this->myreal_escape_string($this->ServiceDE)."', '".$this->myreal_escape_string($this->ServiceIT)."', '".$this->myreal_escape_string($this->ServiceSE)."', '".$this->myreal_escape_string($this->ServiceNO)."', '".$this->myreal_escape_string($this->ServiceES)."', '".$this->myreal_escape_string($this->ServiceNL)."', '".$this->myreal_escape_string($this->DriverPrice)."', '".$this->myreal_escape_string($this->Provision)."', '".$this->myreal_escape_string($this->Price)."', '".$this->myreal_escape_string($this->Description)."')");
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
		$result = $this->connection->RunQuery("SELECT ID from v4_Extras $where ORDER BY $column $order");
			while($row = $result->fetch_array(MYSQLI_ASSOC)){
				$keys[$i] = $row["ID"];
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
	 * @return ServiceID - int(10)
	 */
	public function getServiceID(){
		return $this->ServiceID;
	}

	/**
	 * @return Service - varchar(255)
	 */
	public function getService(){
		return $this->Service;
	}

	/**
	 * @return ServiceEN - varchar(255)
	 */
	public function getServiceEN(){
		return $this->ServiceEN;
	}

	/**
	 * @return ServiceRU - varchar(255)
	 */
	public function getServiceRU(){
		return $this->ServiceRU;
	}

	/**
	 * @return ServiceFR - varchar(255)
	 */
	public function getServiceFR(){
		return $this->ServiceFR;
	}

	/**
	 * @return ServiceDE - varchar(255)
	 */
	public function getServiceDE(){
		return $this->ServiceDE;
	}

	/**
	 * @return ServiceIT - varchar(255)
	 */
	public function getServiceIT(){
		return $this->ServiceIT;
	}

	/**
	 * @return ServiceSE - varchar(255)
	 */
	public function getServiceSE(){
		return $this->ServiceSE;
	}

	/**
	 * @return ServiceNO - varchar(255)
	 */
	public function getServiceNO(){
		return $this->ServiceNO;
	}

	/**
	 * @return ServiceES - varchar(255)
	 */
	public function getServiceES(){
		return $this->ServiceES;
	}

	/**
	 * @return ServiceNL - varchar(255)
	 */
	public function getServiceNL(){
		return $this->ServiceNL;
	}

	/**
	 * @return DriverPrice - decimal(10,2)
	 */
	public function getDriverPrice(){
		return $this->DriverPrice;
	}

	/**
	 * @return Provision - decimal(10,2)
	 */
	public function getProvision(){
		return $this->Provision;
	}

	/**
	 * @return Price - decimal(10,2)
	 */
	public function getPrice(){
		return $this->Price;
	}

	/**
	 * @return Description - text
	 */
	public function getDescription(){
		return $this->Description;
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
	 * @param Type: int(10)
	 */
	public function setServiceID($ServiceID){
		$this->ServiceID = $ServiceID;
	}

	/**
	 * @param Type: varchar(255)
	 */
	public function setService($Service){
		$this->Service = $Service;
	}

	/**
	 * @param Type: varchar(255)
	 */
	public function setServiceEN($ServiceEN){
		$this->ServiceEN = $ServiceEN;
	}

	/**
	 * @param Type: varchar(255)
	 */
	public function setServiceRU($ServiceRU){
		$this->ServiceRU = $ServiceRU;
	}

	/**
	 * @param Type: varchar(255)
	 */
	public function setServiceFR($ServiceFR){
		$this->ServiceFR = $ServiceFR;
	}

	/**
	 * @param Type: varchar(255)
	 */
	public function setServiceDE($ServiceDE){
		$this->ServiceDE = $ServiceDE;
	}

	/**
	 * @param Type: varchar(255)
	 */
	public function setServiceIT($ServiceIT){
		$this->ServiceIT = $ServiceIT;
	}

	/**
	 * @param Type: varchar(255)
	 */
	public function setServiceSE($ServiceSE){
		$this->ServiceSE = $ServiceSE;
	}

	/**
	 * @param Type: varchar(255)
	 */
	public function setServiceNO($ServiceNO){
		$this->ServiceNO = $ServiceNO;
	}

	/**
	 * @param Type: varchar(255)
	 */
	public function setServiceES($ServiceES){
		$this->ServiceES = $ServiceES;
	}

	/**
	 * @param Type: varchar(255)
	 */
	public function setServiceNL($ServiceNL){
		$this->ServiceNL = $ServiceNL;
	}

	/**
	 * @param Type: decimal(10,2)
	 */
	public function setDriverPrice($DriverPrice){
		$this->DriverPrice = $DriverPrice;
	}

	/**
	 * @param Type: decimal(10,2)
	 */
	public function setProvision($Provision){
		$this->Provision = $Provision;
	}

	/**
	 * @param Type: decimal(10,2)
	 */
	public function setPrice($Price){
		$this->Price = $Price;
	}

	/**
	 * @param Type: text
	 */
	public function setDescription($Description){
		$this->Description = $Description;
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
			'ServiceID' => $this->getServiceID(),
			'Service' => $this->getService(),
			'ServiceEN' => $this->getServiceEN(),
			'ServiceRU' => $this->getServiceRU(),
			'ServiceFR' => $this->getServiceFR(),
			'ServiceDE' => $this->getServiceDE(),
			'ServiceIT' => $this->getServiceIT(),
			'ServiceSE' => $this->getServiceSE(),
			'ServiceNO' => $this->getServiceNO(),
			'ServiceES' => $this->getServiceES(),
			'ServiceNL' => $this->getServiceNL(),
			'DriverPrice' => $this->getDriverPrice(),
			'Provision' => $this->getProvision(),
			'Price' => $this->getPrice(),
			'Description' => $this->getDescription()		);
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
			'ID',			'OwnerID',			'ServiceID',			'Service',			'ServiceEN',			'ServiceRU',			'ServiceFR',			'ServiceDE',			'ServiceIT',			'ServiceSE',			'ServiceNO',			'ServiceES',			'ServiceNL',			'DriverPrice',			'Provision',			'Price',			'Description'		);
		return $fieldNames;
	}
    /**
     * Close mysql connection
     */
	public function endv4_Extras(){
		$this->connection->CloseMysql();
	}

}