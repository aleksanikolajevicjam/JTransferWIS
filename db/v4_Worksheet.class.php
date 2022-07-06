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

Class v4_Worksheet {

	public $WSID; //int(10) unsigned
	public $OwnerID; //int(10) unsigned
	public $MyDriverID; //varchar(255)
	public $DriverSignature; //varchar(32)
	public $WSDate; //varchar(12)
	public $WSTime; //varchar(5)
	public $FromDate; //varchar(12)
	public $ToDate; //varchar(12)
	public $CashWithdrawn; //decimal(10,2) unsigned
	public $CashDeposit; //decimal(10,2) unsigned
	public $KmOut; //int(10) unsigned
	public $KmIn; //int(10) unsigned
	public $Notes; //text
	public $Status; //tinyint(1)
	public $LastChange; //timestamp
	public $connection;

	public function v4_Worksheet(){
		$this->connection = new DataBaseMysql();
	}	public function myreal_escape_string($string){
		return $this->connection->real_escape_string($string);
	}

    /**
     * New object to the class. Don´t forget to save this new object "as new" by using the function $class->saveAsNew(); 
     *
     */
	public function New_v4_Worksheet($OwnerID,$MyDriverID,$DriverSignature,$WSDate,$WSTime,$FromDate,$ToDate,$CashWithdrawn,$CashDeposit,$KmOut,$KmIn,$Notes,$Status,$LastChange){
		$this->OwnerID = $OwnerID;
		$this->MyDriverID = $MyDriverID;
		$this->DriverSignature = $DriverSignature;
		$this->WSDate = $WSDate;
		$this->WSTime = $WSTime;
		$this->FromDate = $FromDate;
		$this->ToDate = $ToDate;
		$this->CashWithdrawn = $CashWithdrawn;
		$this->CashDeposit = $CashDeposit;
		$this->KmOut = $KmOut;
		$this->KmIn = $KmIn;
		$this->Notes = $Notes;
		$this->Status = $Status;
		$this->LastChange = $LastChange;
	}

    /**
     * Load one row into var_class. To use the vars use for exemple echo $class->getVar_name; 
     *
     * @param key_table_type $key_row
     * 
     */
	public function getRow($key_row){
		$result = $this->connection->RunQuery("Select * from v4_Worksheet where WSID = \"$key_row\" ");
		if($result->num_rows < 1) return false;
		while($row = $result->fetch_array(MYSQLI_ASSOC)){
			$this->WSID = $row["WSID"];
			$this->OwnerID = $row["OwnerID"];
			$this->MyDriverID = $row["MyDriverID"];
			$this->DriverSignature = $row["DriverSignature"];
			$this->WSDate = $row["WSDate"];
			$this->WSTime = $row["WSTime"];
			$this->FromDate = $row["FromDate"];
			$this->ToDate = $row["ToDate"];
			$this->CashWithdrawn = $row["CashWithdrawn"];
			$this->CashDeposit = $row["CashDeposit"];
			$this->KmOut = $row["KmOut"];
			$this->KmIn = $row["KmIn"];
			$this->Notes = $row["Notes"];
			$this->Status = $row["Status"];
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
		$this->connection->RunQuery("DELETE FROM v4_Worksheet WHERE WSID = $key_row");
	}

    /**
     * Update the active row table on table
     */
	public function saveRow(){
		$result = $this->connection->RunQuery("UPDATE v4_Worksheet set 
OwnerID = '".$this->myreal_escape_string($this->OwnerID)."', 
MyDriverID = '".$this->myreal_escape_string($this->MyDriverID)."', 
DriverSignature = '".$this->myreal_escape_string($this->DriverSignature)."', 
WSDate = '".$this->myreal_escape_string($this->WSDate)."', 
WSTime = '".$this->myreal_escape_string($this->WSTime)."', 
FromDate = '".$this->myreal_escape_string($this->FromDate)."', 
ToDate = '".$this->myreal_escape_string($this->ToDate)."', 
CashWithdrawn = '".$this->myreal_escape_string($this->CashWithdrawn)."', 
CashDeposit = '".$this->myreal_escape_string($this->CashDeposit)."', 
KmOut = '".$this->myreal_escape_string($this->KmOut)."', 
KmIn = '".$this->myreal_escape_string($this->KmIn)."', 
Notes = '".$this->myreal_escape_string($this->Notes)."', 
Status = '".$this->myreal_escape_string($this->Status)."', 
LastChange = '".$this->myreal_escape_string($this->LastChange)."' WHERE WSID = '".$this->WSID."'");
	return $result; 
}

    /**
     * Save the active var class as a new row on table
     */
	public function saveAsNew(){
		$this->connection->RunQuery("INSERT INTO v4_Worksheet (OwnerID, MyDriverID, DriverSignature, WSDate, WSTime, FromDate, ToDate, CashWithdrawn, CashDeposit, KmOut, KmIn, Notes, Status, LastChange) values ('".$this->myreal_escape_string($this->OwnerID)."', '".$this->myreal_escape_string($this->MyDriverID)."', '".$this->myreal_escape_string($this->DriverSignature)."', '".$this->myreal_escape_string($this->WSDate)."', '".$this->myreal_escape_string($this->WSTime)."', '".$this->myreal_escape_string($this->FromDate)."', '".$this->myreal_escape_string($this->ToDate)."', '".$this->myreal_escape_string($this->CashWithdrawn)."', '".$this->myreal_escape_string($this->CashDeposit)."', '".$this->myreal_escape_string($this->KmOut)."', '".$this->myreal_escape_string($this->KmIn)."', '".$this->myreal_escape_string($this->Notes)."', '".$this->myreal_escape_string($this->Status)."', '".$this->myreal_escape_string($this->LastChange)."')");
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
		$result = $this->connection->RunQuery("SELECT WSID from v4_Worksheet $where ORDER BY $column $order");
			while($row = $result->fetch_array(MYSQLI_ASSOC)){
				$keys[$i] = $row["WSID"];
				$i++;
			}
	return $keys;
	}

	/**
	 * @return WSID - int(10) unsigned
	 */
	public function getWSID(){
		return $this->WSID;
	}

	/**
	 * @return OwnerID - int(10) unsigned
	 */
	public function getOwnerID(){
		return $this->OwnerID;
	}

	/**
	 * @return MyDriverID - varchar(255)
	 */
	public function getMyDriverID(){
		return $this->MyDriverID;
	}

	/**
	 * @return DriverSignature - varchar(32)
	 */
	public function getDriverSignature(){
		return $this->DriverSignature;
	}

	/**
	 * @return WSDate - varchar(12)
	 */
	public function getWSDate(){
		return $this->WSDate;
	}

	/**
	 * @return WSTime - varchar(5)
	 */
	public function getWSTime(){
		return $this->WSTime;
	}

	/**
	 * @return FromDate - varchar(12)
	 */
	public function getFromDate(){
		return $this->FromDate;
	}

	/**
	 * @return ToDate - varchar(12)
	 */
	public function getToDate(){
		return $this->ToDate;
	}

	/**
	 * @return CashWithdrawn - decimal(10,2) unsigned
	 */
	public function getCashWithdrawn(){
		return $this->CashWithdrawn;
	}

	/**
	 * @return CashDeposit - decimal(10,2) unsigned
	 */
	public function getCashDeposit(){
		return $this->CashDeposit;
	}

	/**
	 * @return KmOut - int(10) unsigned
	 */
	public function getKmOut(){
		return $this->KmOut;
	}

	/**
	 * @return KmIn - int(10) unsigned
	 */
	public function getKmIn(){
		return $this->KmIn;
	}

	/**
	 * @return Notes - text
	 */
	public function getNotes(){
		return $this->Notes;
	}

	/**
	 * @return Status - tinyint(1)
	 */
	public function getStatus(){
		return $this->Status;
	}

	/**
	 * @return LastChange - timestamp
	 */
	public function getLastChange(){
		return $this->LastChange;
	}

	/**
	 * @param Type: int(10) unsigned
	 */
	public function setWSID($WSID){
		$this->WSID = $WSID;
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
	public function setMyDriverID($MyDriverID){
		$this->MyDriverID = $MyDriverID;
	}

	/**
	 * @param Type: varchar(32)
	 */
	public function setDriverSignature($DriverSignature){
		$this->DriverSignature = $DriverSignature;
	}

	/**
	 * @param Type: varchar(12)
	 */
	public function setWSDate($WSDate){
		$this->WSDate = $WSDate;
	}

	/**
	 * @param Type: varchar(5)
	 */
	public function setWSTime($WSTime){
		$this->WSTime = $WSTime;
	}

	/**
	 * @param Type: varchar(12)
	 */
	public function setFromDate($FromDate){
		$this->FromDate = $FromDate;
	}

	/**
	 * @param Type: varchar(12)
	 */
	public function setToDate($ToDate){
		$this->ToDate = $ToDate;
	}

	/**
	 * @param Type: decimal(10,2) unsigned
	 */
	public function setCashWithdrawn($CashWithdrawn){
		$this->CashWithdrawn = $CashWithdrawn;
	}

	/**
	 * @param Type: decimal(10,2) unsigned
	 */
	public function setCashDeposit($CashDeposit){
		$this->CashDeposit = $CashDeposit;
	}

	/**
	 * @param Type: int(10) unsigned
	 */
	public function setKmOut($KmOut){
		$this->KmOut = $KmOut;
	}

	/**
	 * @param Type: int(10) unsigned
	 */
	public function setKmIn($KmIn){
		$this->KmIn = $KmIn;
	}

	/**
	 * @param Type: text
	 */
	public function setNotes($Notes){
		$this->Notes = $Notes;
	}

	/**
	 * @param Type: tinyint(1)
	 */
	public function setStatus($Status){
		$this->Status = $Status;
	}

	/**
	 * @param Type: timestamp
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
			'WSID' => $this->getWSID(),
			'OwnerID' => $this->getOwnerID(),
			'MyDriverID' => $this->getMyDriverID(),
			'DriverSignature' => $this->getDriverSignature(),
			'WSDate' => $this->getWSDate(),
			'WSTime' => $this->getWSTime(),
			'FromDate' => $this->getFromDate(),
			'ToDate' => $this->getToDate(),
			'CashWithdrawn' => $this->getCashWithdrawn(),
			'CashDeposit' => $this->getCashDeposit(),
			'KmOut' => $this->getKmOut(),
			'KmIn' => $this->getKmIn(),
			'Notes' => $this->getNotes(),
			'Status' => $this->getStatus(),
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
			'WSID',			'OwnerID',			'MyDriverID',			'DriverSignature',			'WSDate',			'WSTime',			'FromDate',			'ToDate',			'CashWithdrawn',			'CashDeposit',			'KmOut',			'KmIn',			'Notes',			'Status',			'LastChange'		);
		return $fieldNames;
	}
    /**
     * Close mysql connection
     */
	public function endv4_Worksheet(){
		$this->connection->CloseMysql();
	}

}