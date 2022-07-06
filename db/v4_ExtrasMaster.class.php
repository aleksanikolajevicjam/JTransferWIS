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

Class v4_ExtrasMaster {

	public $ID; //int(10)
	public $DisplayOrder; //int(4)
	public $ServiceEN; //varchar(255)
	public $ServiceDE; //varchar(255)
	public $ServiceRU; //varchar(255)
	public $ServiceFR; //varchar(255)
	public $ServiceIT; //varchar(255)
	public $ServiceSE; //varchar(255)
	public $ServiceNO; //varchar(255)
	public $ServiceES; //varchar(255)
	public $ServiceNL; //varchar(255)
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
	public function New_v4_ExtrasMaster($DisplayOrder,$ServiceEN,$ServiceDE,$ServiceRU,$ServiceFR,$ServiceIT,$ServiceSE,$ServiceNO,$ServiceES,$ServiceNL){
		$this->DisplayOrder = $DisplayOrder;
		$this->ServiceEN = $ServiceEN;
		$this->ServiceDE = $ServiceDE;
		$this->ServiceRU = $ServiceRU;
		$this->ServiceFR = $ServiceFR;
		$this->ServiceIT = $ServiceIT;
		$this->ServiceSE = $ServiceSE;
		$this->ServiceNO = $ServiceNO;
		$this->ServiceES = $ServiceES;
		$this->ServiceNL = $ServiceNL;
	}

    /**
     * Load one row into var_class. To use the vars use for exemple echo $class->getVar_name; 
     *
     * @param key_table_type $key_row
     * 
     */
	public function getRow($key_row){
		$result = $this->connection->RunQuery("Select * from v4_ExtrasMaster where ID = \"$key_row\" ");
		if($result->num_rows < 1) return false;
		while($row = $result->fetch_array(MYSQLI_ASSOC)){
			$this->ID = $row["ID"];
			$this->DisplayOrder = $row["DisplayOrder"];
			$this->ServiceEN = $row["ServiceEN"];
			$this->ServiceDE = $row["ServiceDE"];
			$this->ServiceRU = $row["ServiceRU"];
			$this->ServiceFR = $row["ServiceFR"];
			$this->ServiceIT = $row["ServiceIT"];
			$this->ServiceSE = $row["ServiceSE"];
			$this->ServiceNO = $row["ServiceNO"];
			$this->ServiceES = $row["ServiceES"];
			$this->ServiceNL = $row["ServiceNL"];
		}
	}

    /**
     * Delete the row by using the key as arg
     *
     * @param key_table_type $key_row
     *
     */
	public function deleteRow($key_row){
		$this->connection->RunQuery("DELETE FROM v4_ExtrasMaster WHERE ID = $key_row");
	}

    /**
     * Update the active row table on table
     */
	public function saveRow(){
		$result = $this->connection->RunQuery("UPDATE v4_ExtrasMaster set 
DisplayOrder = '".$this->myreal_escape_string($this->DisplayOrder)."', 
ServiceEN = '".$this->myreal_escape_string($this->ServiceEN)."', 
ServiceDE = '".$this->myreal_escape_string($this->ServiceDE)."', 
ServiceRU = '".$this->myreal_escape_string($this->ServiceRU)."', 
ServiceFR = '".$this->myreal_escape_string($this->ServiceFR)."', 
ServiceIT = '".$this->myreal_escape_string($this->ServiceIT)."', 
ServiceSE = '".$this->myreal_escape_string($this->ServiceSE)."', 
ServiceNO = '".$this->myreal_escape_string($this->ServiceNO)."', 
ServiceES = '".$this->myreal_escape_string($this->ServiceES)."', 
ServiceNL = '".$this->myreal_escape_string($this->ServiceNL)."' WHERE ID = '".$this->ID."'");
	return $result; 
}

    /**
     * Save the active var class as a new row on table
     */
	public function saveAsNew(){
		$this->connection->RunQuery("INSERT INTO v4_ExtrasMaster (DisplayOrder, ServiceEN, ServiceDE, ServiceRU, ServiceFR, ServiceIT, ServiceSE, ServiceNO, ServiceES, ServiceNL) values ('".$this->myreal_escape_string($this->DisplayOrder)."', '".$this->myreal_escape_string($this->ServiceEN)."', '".$this->myreal_escape_string($this->ServiceDE)."', '".$this->myreal_escape_string($this->ServiceRU)."', '".$this->myreal_escape_string($this->ServiceFR)."', '".$this->myreal_escape_string($this->ServiceIT)."', '".$this->myreal_escape_string($this->ServiceSE)."', '".$this->myreal_escape_string($this->ServiceNO)."', '".$this->myreal_escape_string($this->ServiceES)."', '".$this->myreal_escape_string($this->ServiceNL)."')");
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
		$result = $this->connection->RunQuery("SELECT ID from v4_ExtrasMaster $where ORDER BY $column $order");
			while($row = $result->fetch_array(MYSQLI_ASSOC)){
				$keys[$i] = $row["ID"];
				$i++;
			}
	return $keys;
	}

	/**
	 * @return ID - int(10)
	 */
	public function getID(){
		return $this->ID;
	}

	/**
	 * @return DisplayOrder - int(4)
	 */
	public function getDisplayOrder(){
		return $this->DisplayOrder;
	}

	/**
	 * @return ServiceEN - varchar(255)
	 */
	public function getServiceEN(){
		return $this->ServiceEN;
	}

	/**
	 * @return ServiceDE - varchar(255)
	 */
	public function getServiceDE(){
		return $this->ServiceDE;
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
	 * @param Type: int(10)
	 */
	public function setID($ID){
		$this->ID = $ID;
	}

	/**
	 * @param Type: int(4)
	 */
	public function setDisplayOrder($DisplayOrder){
		$this->DisplayOrder = $DisplayOrder;
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
	public function setServiceDE($ServiceDE){
		$this->ServiceDE = $ServiceDE;
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
     * fieldValues - Load all fieldNames and fieldValues into Array. 
     *
     * @param 
     * 
     */
	public function fieldValues(){
		$fieldValues = array(
			'ID' => $this->getID(),
			'DisplayOrder' => $this->getDisplayOrder(),
			'ServiceEN' => $this->getServiceEN(),
			'ServiceDE' => $this->getServiceDE(),
			'ServiceRU' => $this->getServiceRU(),
			'ServiceFR' => $this->getServiceFR(),
			'ServiceIT' => $this->getServiceIT(),
			'ServiceSE' => $this->getServiceSE(),
			'ServiceNO' => $this->getServiceNO(),
			'ServiceES' => $this->getServiceES(),
			'ServiceNL' => $this->getServiceNL()		);
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
			'ID',			'DisplayOrder',			'ServiceEN',			'ServiceDE',			'ServiceRU',			'ServiceFR',			'ServiceIT',			'ServiceSE',			'ServiceNO',			'ServiceES',			'ServiceNL'		);
		return $fieldNames;
	}
    /**
     * Close mysql connection
     */
	public function endv4_ExtrasMaster(){
		$this->connection->CloseMysql();
	}

}