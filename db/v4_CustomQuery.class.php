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

Class v4_CustomQuery {

	public $ID; //int(10)
	public $customName; //varchar(255)
	public $customMail; //varchar(255)
	public $customFrom; //varchar(255)
	public $customTo; //varchar(255)
	public $customPDate; //varchar(12)
	public $customPTime; //varchar(5)
	public $customPAddress; //varchar(255)
	public $customDropoff; //varchar(255)
	public $customPax; //int(3)
	public $customVehicle; //varchar(255)
	public $customBabySeats; //int(3)
	public $customChildSeats; //int(3)
	public $customExtras; //varchar(255)
	public $customNotes; //varchar(255)
	public $DateSent; //varchar(12)
	public $TimeSent; //varchar(12)
	public $Status; //int(2)
	public $Reply; //text
	public $ReplyUserID; //int(10)
	public $ReplyDate; //varchar(12)
	public $ReplyTime; //varchar(12)
	public $AssignedDriverID; //int(10)
	public $ConvertToBooking; //tinyint(1)
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
	public function New_v4_CustomQuery($customName,$customMail,$customFrom,$customTo,$customPDate,$customPTime,$customPAddress,$customDropoff,$customPax,$customVehicle,$customBabySeats,$customChildSeats,$customExtras,$customNotes,$DateSent,$TimeSent,$Status,$Reply,$ReplyUserID,$ReplyDate,$ReplyTime,$AssignedDriverID,$ConvertToBooking){
		$this->customName = $customName;
		$this->customMail = $customMail;
		$this->customFrom = $customFrom;
		$this->customTo = $customTo;
		$this->customPDate = $customPDate;
		$this->customPTime = $customPTime;
		$this->customPAddress = $customPAddress;
		$this->customDropoff = $customDropoff;
		$this->customPax = $customPax;
		$this->customVehicle = $customVehicle;
		$this->customBabySeats = $customBabySeats;
		$this->customChildSeats = $customChildSeats;
		$this->customExtras = $customExtras;
		$this->customNotes = $customNotes;
		$this->DateSent = $DateSent;
		$this->TimeSent = $TimeSent;
		$this->Status = $Status;
		$this->Reply = $Reply;
		$this->ReplyUserID = $ReplyUserID;
		$this->ReplyDate = $ReplyDate;
		$this->ReplyTime = $ReplyTime;
		$this->AssignedDriverID = $AssignedDriverID;
		$this->ConvertToBooking = $ConvertToBooking;
	}

    /**
     * Load one row into var_class. To use the vars use for exemple echo $class->getVar_name; 
     *
     * @param key_table_type $key_row
     * 
     */
	public function getRow($key_row){
		$result = $this->connection->RunQuery("Select * from v4_CustomQuery where ID = \"$key_row\" ");
		if($result->num_rows < 1) return false;
		while($row = $result->fetch_array(MYSQLI_ASSOC)){
			$this->ID = $row["ID"];
			$this->customName = $row["customName"];
			$this->customMail = $row["customMail"];
			$this->customFrom = $row["customFrom"];
			$this->customTo = $row["customTo"];
			$this->customPDate = $row["customPDate"];
			$this->customPTime = $row["customPTime"];
			$this->customPAddress = $row["customPAddress"];
			$this->customDropoff = $row["customDropoff"];
			$this->customPax = $row["customPax"];
			$this->customVehicle = $row["customVehicle"];
			$this->customBabySeats = $row["customBabySeats"];
			$this->customChildSeats = $row["customChildSeats"];
			$this->customExtras = $row["customExtras"];
			$this->customNotes = $row["customNotes"];
			$this->DateSent = $row["DateSent"];
			$this->TimeSent = $row["TimeSent"];
			$this->Status = $row["Status"];
			$this->Reply = $row["Reply"];
			$this->ReplyUserID = $row["ReplyUserID"];
			$this->ReplyDate = $row["ReplyDate"];
			$this->ReplyTime = $row["ReplyTime"];
			$this->AssignedDriverID = $row["AssignedDriverID"];
			$this->ConvertToBooking = $row["ConvertToBooking"];
		}
	}

    /**
     * Delete the row by using the key as arg
     *
     * @param key_table_type $key_row
     *
     */
	public function deleteRow($key_row){
		$this->connection->RunQuery("DELETE FROM v4_CustomQuery WHERE ID = $key_row");
	}

    /**
     * Update the active row table on table
     */
	public function saveRow(){
		$result = $this->connection->RunQuery("UPDATE v4_CustomQuery set 
customName = '".$this->myreal_escape_string($this->customName)."', 
customMail = '".$this->myreal_escape_string($this->customMail)."', 
customFrom = '".$this->myreal_escape_string($this->customFrom)."', 
customTo = '".$this->myreal_escape_string($this->customTo)."', 
customPDate = '".$this->myreal_escape_string($this->customPDate)."', 
customPTime = '".$this->myreal_escape_string($this->customPTime)."', 
customPAddress = '".$this->myreal_escape_string($this->customPAddress)."', 
customDropoff = '".$this->myreal_escape_string($this->customDropoff)."', 
customPax = '".$this->myreal_escape_string($this->customPax)."', 
customVehicle = '".$this->myreal_escape_string($this->customVehicle)."', 
customBabySeats = '".$this->myreal_escape_string($this->customBabySeats)."', 
customChildSeats = '".$this->myreal_escape_string($this->customChildSeats)."', 
customExtras = '".$this->myreal_escape_string($this->customExtras)."', 
customNotes = '".$this->myreal_escape_string($this->customNotes)."', 
DateSent = '".$this->myreal_escape_string($this->DateSent)."', 
TimeSent = '".$this->myreal_escape_string($this->TimeSent)."', 
Status = '".$this->myreal_escape_string($this->Status)."', 
Reply = '".$this->myreal_escape_string($this->Reply)."', 
ReplyUserID = '".$this->myreal_escape_string($this->ReplyUserID)."', 
ReplyDate = '".$this->myreal_escape_string($this->ReplyDate)."', 
ReplyTime = '".$this->myreal_escape_string($this->ReplyTime)."', 
AssignedDriverID = '".$this->myreal_escape_string($this->AssignedDriverID)."', 
ConvertToBooking = '".$this->myreal_escape_string($this->ConvertToBooking)."' WHERE ID = '".$this->ID."'");
	return $result; 
}

    /**
     * Save the active var class as a new row on table
     */
	public function saveAsNew(){
		$this->connection->RunQuery("INSERT INTO v4_CustomQuery (customName, customMail, customFrom, customTo, customPDate, customPTime, customPAddress, customDropoff, customPax, customVehicle, customBabySeats, customChildSeats, customExtras, customNotes, DateSent, TimeSent, Status, Reply, ReplyUserID, ReplyDate, ReplyTime, AssignedDriverID, ConvertToBooking) values ('".$this->myreal_escape_string($this->customName)."', '".$this->myreal_escape_string($this->customMail)."', '".$this->myreal_escape_string($this->customFrom)."', '".$this->myreal_escape_string($this->customTo)."', '".$this->myreal_escape_string($this->customPDate)."', '".$this->myreal_escape_string($this->customPTime)."', '".$this->myreal_escape_string($this->customPAddress)."', '".$this->myreal_escape_string($this->customDropoff)."', '".$this->myreal_escape_string($this->customPax)."', '".$this->myreal_escape_string($this->customVehicle)."', '".$this->myreal_escape_string($this->customBabySeats)."', '".$this->myreal_escape_string($this->customChildSeats)."', '".$this->myreal_escape_string($this->customExtras)."', '".$this->myreal_escape_string($this->customNotes)."', '".$this->myreal_escape_string($this->DateSent)."', '".$this->myreal_escape_string($this->TimeSent)."', '".$this->myreal_escape_string($this->Status)."', '".$this->myreal_escape_string($this->Reply)."', '".$this->myreal_escape_string($this->ReplyUserID)."', '".$this->myreal_escape_string($this->ReplyDate)."', '".$this->myreal_escape_string($this->ReplyTime)."', '".$this->myreal_escape_string($this->AssignedDriverID)."', '".$this->myreal_escape_string($this->ConvertToBooking)."')");
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
		$result = $this->connection->RunQuery("SELECT ID from v4_CustomQuery $where ORDER BY $column $order");
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
	 * @return customName - varchar(255)
	 */
	public function getcustomName(){
		return $this->customName;
	}

	/**
	 * @return customMail - varchar(255)
	 */
	public function getcustomMail(){
		return $this->customMail;
	}

	/**
	 * @return customFrom - varchar(255)
	 */
	public function getcustomFrom(){
		return $this->customFrom;
	}

	/**
	 * @return customTo - varchar(255)
	 */
	public function getcustomTo(){
		return $this->customTo;
	}

	/**
	 * @return customPDate - varchar(12)
	 */
	public function getcustomPDate(){
		return $this->customPDate;
	}

	/**
	 * @return customPTime - varchar(5)
	 */
	public function getcustomPTime(){
		return $this->customPTime;
	}

	/**
	 * @return customPAddress - varchar(255)
	 */
	public function getcustomPAddress(){
		return $this->customPAddress;
	}

	/**
	 * @return customDropoff - varchar(255)
	 */
	public function getcustomDropoff(){
		return $this->customDropoff;
	}

	/**
	 * @return customPax - int(3)
	 */
	public function getcustomPax(){
		return $this->customPax;
	}

	/**
	 * @return customVehicle - varchar(255)
	 */
	public function getcustomVehicle(){
		return $this->customVehicle;
	}

	/**
	 * @return customBabySeats - int(3)
	 */
	public function getcustomBabySeats(){
		return $this->customBabySeats;
	}

	/**
	 * @return customChildSeats - int(3)
	 */
	public function getcustomChildSeats(){
		return $this->customChildSeats;
	}

	/**
	 * @return customExtras - varchar(255)
	 */
	public function getcustomExtras(){
		return $this->customExtras;
	}

	/**
	 * @return customNotes - varchar(255)
	 */
	public function getcustomNotes(){
		return $this->customNotes;
	}

	/**
	 * @return DateSent - varchar(12)
	 */
	public function getDateSent(){
		return $this->DateSent;
	}

	/**
	 * @return TimeSent - varchar(12)
	 */
	public function getTimeSent(){
		return $this->TimeSent;
	}

	/**
	 * @return Status - int(2)
	 */
	public function getStatus(){
		return $this->Status;
	}

	/**
	 * @return Reply - text
	 */
	public function getReply(){
		return $this->Reply;
	}

	/**
	 * @return ReplyUserID - int(10)
	 */
	public function getReplyUserID(){
		return $this->ReplyUserID;
	}

	/**
	 * @return ReplyDate - varchar(12)
	 */
	public function getReplyDate(){
		return $this->ReplyDate;
	}

	/**
	 * @return ReplyTime - varchar(12)
	 */
	public function getReplyTime(){
		return $this->ReplyTime;
	}

	/**
	 * @return AssignedDriverID - int(10)
	 */
	public function getAssignedDriverID(){
		return $this->AssignedDriverID;
	}

	/**
	 * @return ConvertToBooking - tinyint(1)
	 */
	public function getConvertToBooking(){
		return $this->ConvertToBooking;
	}

	/**
	 * @param Type: int(10)
	 */
	public function setID($ID){
		$this->ID = $ID;
	}

	/**
	 * @param Type: varchar(255)
	 */
	public function setcustomName($customName){
		$this->customName = $customName;
	}

	/**
	 * @param Type: varchar(255)
	 */
	public function setcustomMail($customMail){
		$this->customMail = $customMail;
	}

	/**
	 * @param Type: varchar(255)
	 */
	public function setcustomFrom($customFrom){
		$this->customFrom = $customFrom;
	}

	/**
	 * @param Type: varchar(255)
	 */
	public function setcustomTo($customTo){
		$this->customTo = $customTo;
	}

	/**
	 * @param Type: varchar(12)
	 */
	public function setcustomPDate($customPDate){
		$this->customPDate = $customPDate;
	}

	/**
	 * @param Type: varchar(5)
	 */
	public function setcustomPTime($customPTime){
		$this->customPTime = $customPTime;
	}

	/**
	 * @param Type: varchar(255)
	 */
	public function setcustomPAddress($customPAddress){
		$this->customPAddress = $customPAddress;
	}

	/**
	 * @param Type: varchar(255)
	 */
	public function setcustomDropoff($customDropoff){
		$this->customDropoff = $customDropoff;
	}

	/**
	 * @param Type: int(3)
	 */
	public function setcustomPax($customPax){
		$this->customPax = $customPax;
	}

	/**
	 * @param Type: varchar(255)
	 */
	public function setcustomVehicle($customVehicle){
		$this->customVehicle = $customVehicle;
	}

	/**
	 * @param Type: int(3)
	 */
	public function setcustomBabySeats($customBabySeats){
		$this->customBabySeats = $customBabySeats;
	}

	/**
	 * @param Type: int(3)
	 */
	public function setcustomChildSeats($customChildSeats){
		$this->customChildSeats = $customChildSeats;
	}

	/**
	 * @param Type: varchar(255)
	 */
	public function setcustomExtras($customExtras){
		$this->customExtras = $customExtras;
	}

	/**
	 * @param Type: varchar(255)
	 */
	public function setcustomNotes($customNotes){
		$this->customNotes = $customNotes;
	}

	/**
	 * @param Type: varchar(12)
	 */
	public function setDateSent($DateSent){
		$this->DateSent = $DateSent;
	}

	/**
	 * @param Type: varchar(12)
	 */
	public function setTimeSent($TimeSent){
		$this->TimeSent = $TimeSent;
	}

	/**
	 * @param Type: int(2)
	 */
	public function setStatus($Status){
		$this->Status = $Status;
	}

	/**
	 * @param Type: text
	 */
	public function setReply($Reply){
		$this->Reply = $Reply;
	}

	/**
	 * @param Type: int(10)
	 */
	public function setReplyUserID($ReplyUserID){
		$this->ReplyUserID = $ReplyUserID;
	}

	/**
	 * @param Type: varchar(12)
	 */
	public function setReplyDate($ReplyDate){
		$this->ReplyDate = $ReplyDate;
	}

	/**
	 * @param Type: varchar(12)
	 */
	public function setReplyTime($ReplyTime){
		$this->ReplyTime = $ReplyTime;
	}

	/**
	 * @param Type: int(10)
	 */
	public function setAssignedDriverID($AssignedDriverID){
		$this->AssignedDriverID = $AssignedDriverID;
	}

	/**
	 * @param Type: tinyint(1)
	 */
	public function setConvertToBooking($ConvertToBooking){
		$this->ConvertToBooking = $ConvertToBooking;
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
			'customName' => $this->getcustomName(),
			'customMail' => $this->getcustomMail(),
			'customFrom' => $this->getcustomFrom(),
			'customTo' => $this->getcustomTo(),
			'customPDate' => $this->getcustomPDate(),
			'customPTime' => $this->getcustomPTime(),
			'customPAddress' => $this->getcustomPAddress(),
			'customDropoff' => $this->getcustomDropoff(),
			'customPax' => $this->getcustomPax(),
			'customVehicle' => $this->getcustomVehicle(),
			'customBabySeats' => $this->getcustomBabySeats(),
			'customChildSeats' => $this->getcustomChildSeats(),
			'customExtras' => $this->getcustomExtras(),
			'customNotes' => $this->getcustomNotes(),
			'DateSent' => $this->getDateSent(),
			'TimeSent' => $this->getTimeSent(),
			'Status' => $this->getStatus(),
			'Reply' => $this->getReply(),
			'ReplyUserID' => $this->getReplyUserID(),
			'ReplyDate' => $this->getReplyDate(),
			'ReplyTime' => $this->getReplyTime(),
			'AssignedDriverID' => $this->getAssignedDriverID(),
			'ConvertToBooking' => $this->getConvertToBooking()		);
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
			'ID',			'customName',			'customMail',			'customFrom',			'customTo',			'customPDate',			'customPTime',			'customPAddress',			'customDropoff',			'customPax',			'customVehicle',			'customBabySeats',			'customChildSeats',			'customExtras',			'customNotes',			'DateSent',			'TimeSent',			'Status',			'Reply',			'ReplyUserID',			'ReplyDate',			'ReplyTime',			'AssignedDriverID',			'ConvertToBooking'		);
		return $fieldNames;
	}
    /**
     * Close mysql connection
     */
	public function endv4_CustomQuery(){
		$this->connection->CloseMysql();
	}

}