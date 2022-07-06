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

Class v4_DaySettings {

	public $ID; //int(10)
	public $OwnerID; //int(10)
	public $MonPercent; //decimal(5,2)
	public $MonAmount; //decimal(5,2)
	public $TuePercent; //decimal(5,2)
	public $TueAmount; //decimal(5,2)
	public $WedPercent; //decimal(5,2)
	public $WedAmount; //decimal(5,2)
	public $ThuPercent; //decimal(5,2)
	public $ThuAmount; //decimal(5,2)
	public $FriPercent; //decimal(5,2)
	public $FriAmount; //decimal(5,2)
	public $SatPercent; //decimal(5,2)
	public $SatAmount; //decimal(5,2)
	public $SunPercent; //decimal(5,2)
	public $SunAmount; //decimal(5,2)
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
	public function New_v4_DaySettings($OwnerID,$MonPercent,$MonAmount,$TuePercent,$TueAmount,$WedPercent,$WedAmount,$ThuPercent,$ThuAmount,$FriPercent,$FriAmount,$SatPercent,$SatAmount,$SunPercent,$SunAmount){
		$this->OwnerID = $OwnerID;
		$this->MonPercent = $MonPercent;
		$this->MonAmount = $MonAmount;
		$this->TuePercent = $TuePercent;
		$this->TueAmount = $TueAmount;
		$this->WedPercent = $WedPercent;
		$this->WedAmount = $WedAmount;
		$this->ThuPercent = $ThuPercent;
		$this->ThuAmount = $ThuAmount;
		$this->FriPercent = $FriPercent;
		$this->FriAmount = $FriAmount;
		$this->SatPercent = $SatPercent;
		$this->SatAmount = $SatAmount;
		$this->SunPercent = $SunPercent;
		$this->SunAmount = $SunAmount;
	}

    /**
     * Load one row into var_class. To use the vars use for exemple echo $class->getVar_name; 
     *
     * @param key_table_type $key_row
     * 
     */
	public function getRow($key_row){
		$result = $this->connection->RunQuery("Select * from v4_DaySettings where ID = \"$key_row\" ");
		if($result->num_rows < 1) return false;
		while($row = $result->fetch_array(MYSQLI_ASSOC)){
			$this->ID = $row["ID"];
			$this->OwnerID = $row["OwnerID"];
			$this->MonPercent = $row["MonPercent"];
			$this->MonAmount = $row["MonAmount"];
			$this->TuePercent = $row["TuePercent"];
			$this->TueAmount = $row["TueAmount"];
			$this->WedPercent = $row["WedPercent"];
			$this->WedAmount = $row["WedAmount"];
			$this->ThuPercent = $row["ThuPercent"];
			$this->ThuAmount = $row["ThuAmount"];
			$this->FriPercent = $row["FriPercent"];
			$this->FriAmount = $row["FriAmount"];
			$this->SatPercent = $row["SatPercent"];
			$this->SatAmount = $row["SatAmount"];
			$this->SunPercent = $row["SunPercent"];
			$this->SunAmount = $row["SunAmount"];
		}
	}

    /**
     * Delete the row by using the key as arg
     *
     * @param key_table_type $key_row
     *
     */
	public function deleteRow($key_row){
		$this->connection->RunQuery("DELETE FROM v4_DaySettings WHERE ID = $key_row");
	}

    /**
     * Update the active row table on table
     */
	public function saveRow(){
		$result = $this->connection->RunQuery("UPDATE v4_DaySettings set 
OwnerID = '".$this->myreal_escape_string($this->OwnerID)."', 
MonPercent = '".$this->myreal_escape_string($this->MonPercent)."', 
MonAmount = '".$this->myreal_escape_string($this->MonAmount)."', 
TuePercent = '".$this->myreal_escape_string($this->TuePercent)."', 
TueAmount = '".$this->myreal_escape_string($this->TueAmount)."', 
WedPercent = '".$this->myreal_escape_string($this->WedPercent)."', 
WedAmount = '".$this->myreal_escape_string($this->WedAmount)."', 
ThuPercent = '".$this->myreal_escape_string($this->ThuPercent)."', 
ThuAmount = '".$this->myreal_escape_string($this->ThuAmount)."', 
FriPercent = '".$this->myreal_escape_string($this->FriPercent)."', 
FriAmount = '".$this->myreal_escape_string($this->FriAmount)."', 
SatPercent = '".$this->myreal_escape_string($this->SatPercent)."', 
SatAmount = '".$this->myreal_escape_string($this->SatAmount)."', 
SunPercent = '".$this->myreal_escape_string($this->SunPercent)."', 
SunAmount = '".$this->myreal_escape_string($this->SunAmount)."' WHERE ID = '".$this->ID."'");
	return $result; 
}

    /**
     * Save the active var class as a new row on table
     */
	public function saveAsNew(){
		$this->connection->RunQuery("INSERT INTO v4_DaySettings (OwnerID, MonPercent, MonAmount, TuePercent, TueAmount, WedPercent, WedAmount, ThuPercent, ThuAmount, FriPercent, FriAmount, SatPercent, SatAmount, SunPercent, SunAmount) values ('".$this->myreal_escape_string($this->OwnerID)."', '".$this->myreal_escape_string($this->MonPercent)."', '".$this->myreal_escape_string($this->MonAmount)."', '".$this->myreal_escape_string($this->TuePercent)."', '".$this->myreal_escape_string($this->TueAmount)."', '".$this->myreal_escape_string($this->WedPercent)."', '".$this->myreal_escape_string($this->WedAmount)."', '".$this->myreal_escape_string($this->ThuPercent)."', '".$this->myreal_escape_string($this->ThuAmount)."', '".$this->myreal_escape_string($this->FriPercent)."', '".$this->myreal_escape_string($this->FriAmount)."', '".$this->myreal_escape_string($this->SatPercent)."', '".$this->myreal_escape_string($this->SatAmount)."', '".$this->myreal_escape_string($this->SunPercent)."', '".$this->myreal_escape_string($this->SunAmount)."')");
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
		$result = $this->connection->RunQuery("SELECT ID from v4_DaySettings $where ORDER BY $column $order");
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
	 * @return MonPercent - decimal(5,2)
	 */
	public function getMonPercent(){
		return $this->MonPercent;
	}

	/**
	 * @return MonAmount - decimal(5,2)
	 */
	public function getMonAmount(){
		return $this->MonAmount;
	}

	/**
	 * @return TuePercent - decimal(5,2)
	 */
	public function getTuePercent(){
		return $this->TuePercent;
	}

	/**
	 * @return TueAmount - decimal(5,2)
	 */
	public function getTueAmount(){
		return $this->TueAmount;
	}

	/**
	 * @return WedPercent - decimal(5,2)
	 */
	public function getWedPercent(){
		return $this->WedPercent;
	}

	/**
	 * @return WedAmount - decimal(5,2)
	 */
	public function getWedAmount(){
		return $this->WedAmount;
	}

	/**
	 * @return ThuPercent - decimal(5,2)
	 */
	public function getThuPercent(){
		return $this->ThuPercent;
	}

	/**
	 * @return ThuAmount - decimal(5,2)
	 */
	public function getThuAmount(){
		return $this->ThuAmount;
	}

	/**
	 * @return FriPercent - decimal(5,2)
	 */
	public function getFriPercent(){
		return $this->FriPercent;
	}

	/**
	 * @return FriAmount - decimal(5,2)
	 */
	public function getFriAmount(){
		return $this->FriAmount;
	}

	/**
	 * @return SatPercent - decimal(5,2)
	 */
	public function getSatPercent(){
		return $this->SatPercent;
	}

	/**
	 * @return SatAmount - decimal(5,2)
	 */
	public function getSatAmount(){
		return $this->SatAmount;
	}

	/**
	 * @return SunPercent - decimal(5,2)
	 */
	public function getSunPercent(){
		return $this->SunPercent;
	}

	/**
	 * @return SunAmount - decimal(5,2)
	 */
	public function getSunAmount(){
		return $this->SunAmount;
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
	 * @param Type: decimal(5,2)
	 */
	public function setMonPercent($MonPercent){
		$this->MonPercent = $MonPercent;
	}

	/**
	 * @param Type: decimal(5,2)
	 */
	public function setMonAmount($MonAmount){
		$this->MonAmount = $MonAmount;
	}

	/**
	 * @param Type: decimal(5,2)
	 */
	public function setTuePercent($TuePercent){
		$this->TuePercent = $TuePercent;
	}

	/**
	 * @param Type: decimal(5,2)
	 */
	public function setTueAmount($TueAmount){
		$this->TueAmount = $TueAmount;
	}

	/**
	 * @param Type: decimal(5,2)
	 */
	public function setWedPercent($WedPercent){
		$this->WedPercent = $WedPercent;
	}

	/**
	 * @param Type: decimal(5,2)
	 */
	public function setWedAmount($WedAmount){
		$this->WedAmount = $WedAmount;
	}

	/**
	 * @param Type: decimal(5,2)
	 */
	public function setThuPercent($ThuPercent){
		$this->ThuPercent = $ThuPercent;
	}

	/**
	 * @param Type: decimal(5,2)
	 */
	public function setThuAmount($ThuAmount){
		$this->ThuAmount = $ThuAmount;
	}

	/**
	 * @param Type: decimal(5,2)
	 */
	public function setFriPercent($FriPercent){
		$this->FriPercent = $FriPercent;
	}

	/**
	 * @param Type: decimal(5,2)
	 */
	public function setFriAmount($FriAmount){
		$this->FriAmount = $FriAmount;
	}

	/**
	 * @param Type: decimal(5,2)
	 */
	public function setSatPercent($SatPercent){
		$this->SatPercent = $SatPercent;
	}

	/**
	 * @param Type: decimal(5,2)
	 */
	public function setSatAmount($SatAmount){
		$this->SatAmount = $SatAmount;
	}

	/**
	 * @param Type: decimal(5,2)
	 */
	public function setSunPercent($SunPercent){
		$this->SunPercent = $SunPercent;
	}

	/**
	 * @param Type: decimal(5,2)
	 */
	public function setSunAmount($SunAmount){
		$this->SunAmount = $SunAmount;
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
			'MonPercent' => $this->getMonPercent(),
			'MonAmount' => $this->getMonAmount(),
			'TuePercent' => $this->getTuePercent(),
			'TueAmount' => $this->getTueAmount(),
			'WedPercent' => $this->getWedPercent(),
			'WedAmount' => $this->getWedAmount(),
			'ThuPercent' => $this->getThuPercent(),
			'ThuAmount' => $this->getThuAmount(),
			'FriPercent' => $this->getFriPercent(),
			'FriAmount' => $this->getFriAmount(),
			'SatPercent' => $this->getSatPercent(),
			'SatAmount' => $this->getSatAmount(),
			'SunPercent' => $this->getSunPercent(),
			'SunAmount' => $this->getSunAmount()		);
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
			'ID',			'OwnerID',			'MonPercent',			'MonAmount',			'TuePercent',			'TueAmount',			'WedPercent',			'WedAmount',			'ThuPercent',			'ThuAmount',			'FriPercent',			'FriAmount',			'SatPercent',			'SatAmount',			'SunPercent',			'SunAmount'		);
		return $fieldNames;
	}
    /**
     * Close mysql connection
     */
	public function endv4_DaySettings(){
		$this->connection->CloseMysql();
	}

}