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

Class v4_VehicleEquipmentList {

	public $ID; //int(10)
	public $OwnerID; //int(10)
	public $ListID; //int(11)
	public $Datum; //varchar(10)
	public $VehicleID; //varchar(255)
	public $Description; //varchar(255)
	public $connection;

	public function v4_VehicleEquipmentList(){
		$this->connection = new DataBaseMysql();
	}	
	public function myreal_escape_string($string){
		return $this->connection->real_escape_string($string);
	}

    /**
     * New object to the class. Don´t forget to save this new object "as new" by using the function $class->saveAsNew(); 
     *
     */
	public function New_v4_VehicleEquipmentList($ID,$OwnerID,$ListID,$Datum,$VehicleID,$Description){
		$this->ID = $ID;
		$this->OwnerID = $OwnerID;
		$this->ListID = $ListID;
		$this->Datum = $Datum;
		$this->VehicleID = $VehicleID;
		$this->Description = $Description;
	}

    /**
     * Load one row into var_class. To use the vars use for exemple echo $class->getVar_name; 
     *
     * @param key_table_type $key_row
     * 
     */
	public function getRow($key_row){
		$result = $this->connection->RunQuery("Select * from v4_VehicleEquipmentList where ID = \"$key_row\" ");
		if($result->num_rows < 1) return false;
		while($row = $result->fetch_array(MYSQLI_ASSOC)){
			$this->ID = $row["ID"];
			$this->OwnerID = $row["OwnerID"];
			$this->ListID = $row["ListID"];
			$this->Datum = $row["Datum"];
			$this->VehicleID = $row["VehicleID"];			
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
		$this->connection->RunQuery("DELETE FROM v4_VehicleEquipmentList WHERE ID = $key_row");
	}

    /**
     * Update the active row table on table
     */
	public function saveRow(){

 
		$result = $this->connection->RunQuery("UPDATE v4_VehicleEquipmentList set 
		ID = '".$this->myreal_escape_string($this->ID)."', 
		OwnerID = '".$this->myreal_escape_string($this->OwnerID)."', 
		ListID = '".$this->myreal_escape_string($this->ListID)."', 
		Datum = '".$this->myreal_escape_string($this->Datum)."', 
		VehicleID = '".$this->myreal_escape_string($this->VehicleID)."', 
		Description = '".$this->myreal_escape_string($this->Description)."'
		 WHERE ID = '".$this->ID."'");
	return $result; 
}

    /**
     * Save the active var class as a new row on table
     */
	public function saveAsNew(){
		$this->connection->RunQuery("INSERT INTO v4_VehicleEquipmentList 
		(
		ID, 
		OwnerID, 
		ListID, 
		Datum, 
		VehicleID, 
		Description
		) values ('
		".$this->myreal_escape_string($this->ID)."',
		'".$this->myreal_escape_string($this->OwnerID)."',
		'".$this->myreal_escape_string($this->ListID)."',
		'".$this->myreal_escape_string($this->Datum)."',
		'".$this->myreal_escape_string($this->VehicleID)."',		
		'".$this->myreal_escape_string($this->Description)."'
		)");
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
		$result = $this->connection->RunQuery("SELECT ID from v4_VehicleEquipmentList $where ORDER BY $column $order");
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
	 * @return OwnerID - int(10)
	 */
	public function getOwnerID(){
		return $this->OwnerID;
	}

	/**
	 * @return ListID - int(11)
	 */
	public function getListID(){
		return $this->ListID;
	}

	/**
	 * @return Datum - varchar(10)
	 */
	public function getDatum(){
		return $this->Datum;
	}


	/**
	 * @return VehicleID - varchar(255)
	 */
	public function getVehicleID(){
		return $this->VehicleID;
	}
	
	/**
	 * @return Description - varchar(255)
	 */
	public function getDescription(){
		return $this->Description;
	}


	/**
	 * @param Type: int(10)
	 */
	public function setID($ID){
		$this->ID = $ID;
	}

	/**
	 * @param Type: int(10)
	 */
	public function setOwnerID($OwnerID){
		$this->OwnerID = $OwnerID;
	}

	/**
	 * @param Type: int(11)
	 */
	public function setListID($ListID){
		$this->ListID = $ListID;
	}

	/**
	 * @param Type: varchar(10)
	 */
	public function setDatum($Datum){
		$this->Datum = $Datum;
	}

	/**
	 * @param Type: varchar(255)
	 */
	public function setVehicleID($VehicleID){
		$this->VehicleID = $VehicleID;
	}
	
	/**
	 * @param Type: varchar(255)
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
			'ListID' => $this->getListID(),
			'Datum' => $this->getDatum(),
			'VehicleID' => $this->getVehicleID(),	
			'Description' => $this->getDescription()	
			);
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
			'ID',			'OwnerID',			'ListID',			'Datum',			'VehicleID',		'Description'		);
		return $fieldNames;
	}
    /**
     * Close mysql connection
     */
	public function endv4_VehicleEquipmentList(){
		$this->connection->CloseMysql();
	}

}