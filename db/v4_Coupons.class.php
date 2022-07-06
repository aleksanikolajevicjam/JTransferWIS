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

Class v4_Coupons {

	public $ID; //int(10)
	public $CreatorID; //int(10)
	public $Code; //varchar(50)
	public $Discount; //decimal(5,2)
	public $Description; //varchar255
	public $VehicleTypeID; //int(11)
	public $DriverID; //int(11)
	public $ValidFrom; //varchar(10)
	public $ValidTo; //varchar(10)
	public $TransferFromDate; //varchar(10)
	public $TransferToDate; //varchar(10)
	public $LimitLocationID; //int(10)
	public $WeekdaysOnly; //tinyint(1)
	public $ReturnOnly; //tinyint(1)
	public $Active; //tinyint(1)
	public $TimesUsed; //int(10)
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
	public function New_v4_Coupons($CreatorID,$Code,$Discount,$Description,$VehicleTypeID,$ValidFrom,$ValidTo,$TransferFromDate,$TransferToDate,$LimitLocationID,$WeekdaysOnly,$ReturnOnly,$Active,$TimesUsed){
		$this->CreatorID = $CreatorID;
		$this->Code = $Code;
		$this->Discount = $Discount;
		$this->Description = $Description;
		$this->VehicleTypeID = $VehicleTypeID;
		$this->DriverID = $DriverID;
		$this->ValidFrom = $ValidFrom;
		$this->ValidTo = $ValidTo;
		$this->TransferFromDate = $TransferFromDate;
		$this->TransferToDate = $TransferToDate;
		$this->LimitLocationID = $LimitLocationID;
		$this->WeekdaysOnly = $WeekdaysOnly;
		$this->ReturnOnly = $ReturnOnly;
		$this->Active = $Active;
		$this->TimesUsed = $TimesUsed;
	}

    /**
     * Load one row into var_class. To use the vars use for exemple echo $class->getVar_name; 
     *
     * @param key_table_type $key_row
     * 
     */
	public function getRow($key_row){
		$result = $this->connection->RunQuery("Select * from v4_Coupons where ID = \"$key_row\" ");
		if($result->num_rows < 1) return false;
		while($row = $result->fetch_array(MYSQLI_ASSOC)){
			$this->ID = $row["ID"];
			$this->CreatorID = $row["CreatorID"];
			$this->Code = $row["Code"];
			$this->Discount = $row["Discount"];
			$this->Description = $row["Description"];
			$this->VehicleTypeID = $row["VehicleTypeID"];
			$this->DriverID = $row["DriverID"];
			$this->ValidFrom = $row["ValidFrom"];
			$this->ValidTo = $row["ValidTo"];
			$this->TransferFromDate = $row["TransferFromDate"];
			$this->TransferToDate = $row["TransferToDate"];
			$this->LimitLocationID = $row["LimitLocationID"];
			$this->WeekdaysOnly = $row["WeekdaysOnly"];
			$this->ReturnOnly = $row["ReturnOnly"];
			$this->Active = $row["Active"];
			$this->TimesUsed = $row["TimesUsed"];
		}
	}

    /**
     * Delete the row by using the key as arg
     *
     * @param key_table_type $key_row
     *
     */
	public function deleteRow($key_row){
		$this->connection->RunQuery("DELETE FROM v4_Coupons WHERE ID = $key_row");
	}

    /**
     * Update the active row table on table
     */
	public function saveRow(){
		$result = $this->connection->RunQuery("UPDATE v4_Coupons set 
CreatorID = '".$this->myreal_escape_string($this->CreatorID)."', 
Code = '".$this->myreal_escape_string($this->Code)."', 
Discount = '".$this->myreal_escape_string($this->Discount)."', 
Description = '".$this->myreal_escape_string($this->Description)."', 
VehicleTypeID = '".$this->myreal_escape_string($this->VehicleTypeID)."', 
DriverID = '".$this->myreal_escape_string($this->DriverID)."', 
ValidFrom = '".$this->myreal_escape_string($this->ValidFrom)."', 
ValidTo = '".$this->myreal_escape_string($this->ValidTo)."', 
TransferFromDate = '".$this->myreal_escape_string($this->TransferFromDate)."', 
TransferToDate = '".$this->myreal_escape_string($this->TransferToDate)."', 
LimitLocationID = '".$this->myreal_escape_string($this->LimitLocationID)."', 
WeekdaysOnly = '".$this->myreal_escape_string($this->WeekdaysOnly)."', 
ReturnOnly = '".$this->myreal_escape_string($this->ReturnOnly)."', 
Active = '".$this->myreal_escape_string($this->Active)."', 
TimesUsed = '".$this->myreal_escape_string($this->TimesUsed)."' WHERE ID = '".$this->ID."'");
	return $result; 
}

    /**
     * Save the active var class as a new row on table
     */
	public function saveAsNew(){
		$this->connection->RunQuery("INSERT INTO v4_Coupons (CreatorID, Code, Discount, Description, VehicleTypeID, DriverID, ValidFrom, ValidTo, TransferFromDate, TransferToDate, LimitLocationID, WeekdaysOnly, ReturnOnly, Active, TimesUsed) values ('".$this->myreal_escape_string($this->CreatorID)."', '".$this->myreal_escape_string($this->Code)."', 
		'".$this->myreal_escape_string($this->Discount)."',
		'".$this->myreal_escape_string($this->Description)."',
		'".$this->myreal_escape_string($this->VehicleTypeID)."',
		'".$this->myreal_escape_string($this->DriverID)."',
		'".$this->myreal_escape_string($this->ValidFrom)."', '".$this->myreal_escape_string($this->ValidTo)."', '".$this->myreal_escape_string($this->TransferFromDate)."', '".$this->myreal_escape_string($this->TransferToDate)."', '".$this->myreal_escape_string($this->LimitLocationID)."', '".$this->myreal_escape_string($this->WeekdaysOnly)."', '".$this->myreal_escape_string($this->ReturnOnly)."', '".$this->myreal_escape_string($this->Active)."', '".$this->myreal_escape_string($this->TimesUsed)."')");
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
		$result = $this->connection->RunQuery("SELECT ID from v4_Coupons $where ORDER BY $column $order");
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
	 * @return CreatorID - int(10)
	 */
	public function getCreatorID(){
		return $this->CreatorID;
	}

	/**
	 * @return Code - varchar(50)
	 */
	public function getCode(){
		return $this->Code;
	}

	/**
	 * @return Discount - decimal(5,2)
	 */
	public function getDiscount(){
		return $this->Discount;
	}	
	
	/**
	 * @return Description - varchar (255)
	 */
	public function getDescription(){
		return $this->Description;
	}

	/**
	 * @return VehicleTypeID - int(11)
	 */
	public function getVehicleTypeID(){
		return $this->VehicleTypeID;
	}

	/**
	 * @return DriverID - int(11)
	 */
	public function getDriverID(){
		return $this->DriverID;
	} 
	
	/**
	 * @return ValidFrom - varchar(10)
	 */
	public function getValidFrom(){
		return $this->ValidFrom;
	}

	/**
	 * @return ValidTo - varchar(10)
	 */
	public function getValidTo(){
		return $this->ValidTo;
	}

	/**
	 * @return TransferFromDate - varchar(10)
	 */
	public function getTransferFromDate(){
		return $this->TransferFromDate;
	}

	/**
	 * @return TransferToDate - varchar(10)
	 */
	public function getTransferToDate(){
		return $this->TransferToDate;
	}

	/**
	 * @return LimitLocationID - int(10)
	 */
	public function getLimitLocationID(){
		return $this->LimitLocationID;
	}

	/**
	 * @return WeekdaysOnly - tinyint(1)
	 */
	public function getWeekdaysOnly(){
		return $this->WeekdaysOnly;
	}

	/**
	 * @return ReturnOnly - tinyint(1)
	 */
	public function getReturnOnly(){
		return $this->ReturnOnly;
	}

	/**
	 * @return Active - tinyint(1)
	 */
	public function getActive(){
		return $this->Active;
	}

	/**
	 * @return TimesUsed - int(10)
	 */
	public function getTimesUsed(){
		return $this->TimesUsed;
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
	public function setCreatorID($CreatorID){
		$this->CreatorID = $CreatorID;
	}

	/**
	 * @param Type: varchar(50)
	 */
	public function setCode($Code){
		$this->Code = $Code;
	}

	/**
	 * @param Type: decimal(5,2)
	 */
	public function setDiscount($Discount){
		$this->Discount = $Discount;
	}	
	
	/**
	 * @param Type: varchar(255)
	 */
	public function setDescription($Description){
		$this->Description = $Description;
	}	
	
	/**
	 * @param Type: int(11)
	 */
	public function setVehicleTypeID($VehicleTypeID){
		$this->VehicleTypeID = $VehicleTypeID;
	}

	/**
	 * @param Type: int(11)
	 */
	public function setDriverID($DriverID){
		$this->DriverID = $DriverID;
	}
	
	/**
	 * @param Type: varchar(10)
	 */
	public function setValidFrom($ValidFrom){
		$this->ValidFrom = $ValidFrom;
	}

	/**
	 * @param Type: varchar(10)
	 */
	public function setValidTo($ValidTo){
		$this->ValidTo = $ValidTo;
	}

	/**
	 * @param Type: varchar(10)
	 */
	public function setTransferFromDate($TransferFromDate){
		$this->TransferFromDate = $TransferFromDate;
	}

	/**
	 * @param Type: varchar(10)
	 */
	public function setTransferToDate($TransferToDate){
		$this->TransferToDate = $TransferToDate;
	}

	/**
	 * @param Type: int(10)
	 */
	public function setLimitLocationID($LimitLocationID){
		$this->LimitLocationID = $LimitLocationID;
	}

	/**
	 * @param Type: tinyint(1)
	 */
	public function setWeekdaysOnly($WeekdaysOnly){
		$this->WeekdaysOnly = $WeekdaysOnly;
	}

	/**
	 * @param Type: tinyint(1)
	 */
	public function setReturnOnly($ReturnOnly){
		$this->ReturnOnly = $ReturnOnly;
	}

	/**
	 * @param Type: tinyint(1)
	 */
	public function setActive($Active){
		$this->Active = $Active;
	}

	/**
	 * @param Type: int(10)
	 */
	public function setTimesUsed($TimesUsed){
		$this->TimesUsed = $TimesUsed;
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
			'CreatorID' => $this->getCreatorID(),
			'Code' => $this->getCode(),
			'Discount' => $this->getDiscount(),
			'Description' => $this->getDescription(),
			'VehicleTypeID' => $this->getVehicleTypeID(),
			'DriverID' => $this->getDriverID(),			
			'ValidFrom' => $this->getValidFrom(),
			'ValidTo' => $this->getValidTo(),
			'TransferFromDate' => $this->getTransferFromDate(),
			'TransferToDate' => $this->getTransferToDate(),
			'LimitLocationID' => $this->getLimitLocationID(),
			'WeekdaysOnly' => $this->getWeekdaysOnly(),
			'ReturnOnly' => $this->getReturnOnly(),
			'Active' => $this->getActive(),
			'TimesUsed' => $this->getTimesUsed()		);
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
			'ID',			'CreatorID',			'Code',			'Discount',			'Description',		'VehicleTypeID',			'DriverID',			'ValidFrom',			'ValidTo',			'TransferFromDate',			'TransferToDate',			'LimitLocationID',			'WeekdaysOnly',			'ReturnOnly',			'Active',			'TimesUsed'		);
		return $fieldNames;
	}
    /**
     * Close mysql connection
     */
	public function endv4_Coupons(){
		$this->connection->CloseMysql();
	}

}