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

Class v4_Policies_IT {

	public $OwnerID; //int(10) unsigned
	public $DateChanged; //text
	public $BookingAdvance; //int(3) unsigned
	public $DeclineTime; //int(3) unsigned
	public $CancelDays; //int(2) unsigned
	public $CancelCharge; //int(2) unsigned
	public $Deposit; //int(3) unsigned
	public $AMEX; //tinyint(1)
	public $Visa; //tinyint(1)
	public $MasterCard; //tinyint(1)
	public $Diners; //tinyint(1)
	public $MeetingGeneral; //text
	public $MeetingAirport; //text
	public $MeetingFerry; //text
	public $MeetingBus; //text
	public $MeetingTrain; //text
	public $Locked; //tinyint(1) unsigned
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
	public function New_v4_Policies_IT($DateChanged,$BookingAdvance,$DeclineTime,$CancelDays,$CancelCharge,$Deposit,$AMEX,$Visa,$MasterCard,$Diners,$MeetingGeneral,$MeetingAirport,$MeetingFerry,$MeetingBus,$MeetingTrain,$Locked){
		$this->DateChanged = $DateChanged;
		$this->BookingAdvance = $BookingAdvance;
		$this->DeclineTime = $DeclineTime;
		$this->CancelDays = $CancelDays;
		$this->CancelCharge = $CancelCharge;
		$this->Deposit = $Deposit;
		$this->AMEX = $AMEX;
		$this->Visa = $Visa;
		$this->MasterCard = $MasterCard;
		$this->Diners = $Diners;
		$this->MeetingGeneral = $MeetingGeneral;
		$this->MeetingAirport = $MeetingAirport;
		$this->MeetingFerry = $MeetingFerry;
		$this->MeetingBus = $MeetingBus;
		$this->MeetingTrain = $MeetingTrain;
		$this->Locked = $Locked;
	}

    /**
     * Load one row into var_class. To use the vars use for exemple echo $class->getVar_name; 
     *
     * @param key_table_type $key_row
     * 
     */
	public function getRow($key_row){
		$result = $this->connection->RunQuery("Select * from v4_Policies_IT where OwnerID = \"$key_row\" ");
		if($result->num_rows < 1) return false;
		while($row = $result->fetch_array(MYSQLI_ASSOC)){
			$this->OwnerID = $row["OwnerID"];
			$this->DateChanged = $row["DateChanged"];
			$this->BookingAdvance = $row["BookingAdvance"];
			$this->DeclineTime = $row["DeclineTime"];
			$this->CancelDays = $row["CancelDays"];
			$this->CancelCharge = $row["CancelCharge"];
			$this->Deposit = $row["Deposit"];
			$this->AMEX = $row["AMEX"];
			$this->Visa = $row["Visa"];
			$this->MasterCard = $row["MasterCard"];
			$this->Diners = $row["Diners"];
			$this->MeetingGeneral = $row["MeetingGeneral"];
			$this->MeetingAirport = $row["MeetingAirport"];
			$this->MeetingFerry = $row["MeetingFerry"];
			$this->MeetingBus = $row["MeetingBus"];
			$this->MeetingTrain = $row["MeetingTrain"];
			$this->Locked = $row["Locked"];
		}
	}

    /**
     * Delete the row by using the key as arg
     *
     * @param key_table_type $key_row
     *
     */
	public function deleteRow($key_row){
		$this->connection->RunQuery("DELETE FROM v4_Policies_IT WHERE OwnerID = $key_row");
	}

    /**
     * Update the active row table on table
     */
	public function saveRow(){
		$result = $this->connection->RunQuery("UPDATE v4_Policies_IT set 
DateChanged = '".$this->myreal_escape_string($this->DateChanged)."', 
BookingAdvance = '".$this->myreal_escape_string($this->BookingAdvance)."', 
DeclineTime = '".$this->myreal_escape_string($this->DeclineTime)."', 
CancelDays = '".$this->myreal_escape_string($this->CancelDays)."', 
CancelCharge = '".$this->myreal_escape_string($this->CancelCharge)."', 
Deposit = '".$this->myreal_escape_string($this->Deposit)."', 
AMEX = '".$this->myreal_escape_string($this->AMEX)."', 
Visa = '".$this->myreal_escape_string($this->Visa)."', 
MasterCard = '".$this->myreal_escape_string($this->MasterCard)."', 
Diners = '".$this->myreal_escape_string($this->Diners)."', 
MeetingGeneral = '".$this->myreal_escape_string($this->MeetingGeneral)."', 
MeetingAirport = '".$this->myreal_escape_string($this->MeetingAirport)."', 
MeetingFerry = '".$this->myreal_escape_string($this->MeetingFerry)."', 
MeetingBus = '".$this->myreal_escape_string($this->MeetingBus)."', 
MeetingTrain = '".$this->myreal_escape_string($this->MeetingTrain)."', 
Locked = '".$this->myreal_escape_string($this->Locked)."' WHERE OwnerID = '".$this->OwnerID."'");
	return $result; 
}

    /**
     * Save the active var class as a new row on table
     */
	public function saveAsNew(){
		$this->connection->RunQuery("INSERT INTO v4_Policies_IT (DateChanged, BookingAdvance, DeclineTime, CancelDays, CancelCharge, Deposit, AMEX, Visa, MasterCard, Diners, MeetingGeneral, MeetingAirport, MeetingFerry, MeetingBus, MeetingTrain, Locked) values ('".$this->myreal_escape_string($this->DateChanged)."', '".$this->myreal_escape_string($this->BookingAdvance)."', '".$this->myreal_escape_string($this->DeclineTime)."', '".$this->myreal_escape_string($this->CancelDays)."', '".$this->myreal_escape_string($this->CancelCharge)."', '".$this->myreal_escape_string($this->Deposit)."', '".$this->myreal_escape_string($this->AMEX)."', '".$this->myreal_escape_string($this->Visa)."', '".$this->myreal_escape_string($this->MasterCard)."', '".$this->myreal_escape_string($this->Diners)."', '".$this->myreal_escape_string($this->MeetingGeneral)."', '".$this->myreal_escape_string($this->MeetingAirport)."', '".$this->myreal_escape_string($this->MeetingFerry)."', '".$this->myreal_escape_string($this->MeetingBus)."', '".$this->myreal_escape_string($this->MeetingTrain)."', '".$this->myreal_escape_string($this->Locked)."')");
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
		$result = $this->connection->RunQuery("SELECT OwnerID from v4_Policies_IT $where ORDER BY $column $order");
			while($row = $result->fetch_array(MYSQLI_ASSOC)){
				$keys[$i] = $row["OwnerID"];
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
	 * @return DateChanged - text
	 */
	public function getDateChanged(){
		return $this->DateChanged;
	}

	/**
	 * @return BookingAdvance - int(3) unsigned
	 */
	public function getBookingAdvance(){
		return $this->BookingAdvance;
	}

	/**
	 * @return DeclineTime - int(3) unsigned
	 */
	public function getDeclineTime(){
		return $this->DeclineTime;
	}

	/**
	 * @return CancelDays - int(2) unsigned
	 */
	public function getCancelDays(){
		return $this->CancelDays;
	}

	/**
	 * @return CancelCharge - int(2) unsigned
	 */
	public function getCancelCharge(){
		return $this->CancelCharge;
	}

	/**
	 * @return Deposit - int(3) unsigned
	 */
	public function getDeposit(){
		return $this->Deposit;
	}

	/**
	 * @return AMEX - tinyint(1)
	 */
	public function getAMEX(){
		return $this->AMEX;
	}

	/**
	 * @return Visa - tinyint(1)
	 */
	public function getVisa(){
		return $this->Visa;
	}

	/**
	 * @return MasterCard - tinyint(1)
	 */
	public function getMasterCard(){
		return $this->MasterCard;
	}

	/**
	 * @return Diners - tinyint(1)
	 */
	public function getDiners(){
		return $this->Diners;
	}

	/**
	 * @return MeetingGeneral - text
	 */
	public function getMeetingGeneral(){
		return $this->MeetingGeneral;
	}

	/**
	 * @return MeetingAirport - text
	 */
	public function getMeetingAirport(){
		return $this->MeetingAirport;
	}

	/**
	 * @return MeetingFerry - text
	 */
	public function getMeetingFerry(){
		return $this->MeetingFerry;
	}

	/**
	 * @return MeetingBus - text
	 */
	public function getMeetingBus(){
		return $this->MeetingBus;
	}

	/**
	 * @return MeetingTrain - text
	 */
	public function getMeetingTrain(){
		return $this->MeetingTrain;
	}

	/**
	 * @return Locked - tinyint(1) unsigned
	 */
	public function getLocked(){
		return $this->Locked;
	}

	/**
	 * @param Type: int(10) unsigned
	 */
	public function setOwnerID($OwnerID){
		$this->OwnerID = $OwnerID;
	}

	/**
	 * @param Type: text
	 */
	public function setDateChanged($DateChanged){
		$this->DateChanged = $DateChanged;
	}

	/**
	 * @param Type: int(3) unsigned
	 */
	public function setBookingAdvance($BookingAdvance){
		$this->BookingAdvance = $BookingAdvance;
	}

	/**
	 * @param Type: int(3) unsigned
	 */
	public function setDeclineTime($DeclineTime){
		$this->DeclineTime = $DeclineTime;
	}

	/**
	 * @param Type: int(2) unsigned
	 */
	public function setCancelDays($CancelDays){
		$this->CancelDays = $CancelDays;
	}

	/**
	 * @param Type: int(2) unsigned
	 */
	public function setCancelCharge($CancelCharge){
		$this->CancelCharge = $CancelCharge;
	}

	/**
	 * @param Type: int(3) unsigned
	 */
	public function setDeposit($Deposit){
		$this->Deposit = $Deposit;
	}

	/**
	 * @param Type: tinyint(1)
	 */
	public function setAMEX($AMEX){
		$this->AMEX = $AMEX;
	}

	/**
	 * @param Type: tinyint(1)
	 */
	public function setVisa($Visa){
		$this->Visa = $Visa;
	}

	/**
	 * @param Type: tinyint(1)
	 */
	public function setMasterCard($MasterCard){
		$this->MasterCard = $MasterCard;
	}

	/**
	 * @param Type: tinyint(1)
	 */
	public function setDiners($Diners){
		$this->Diners = $Diners;
	}

	/**
	 * @param Type: text
	 */
	public function setMeetingGeneral($MeetingGeneral){
		$this->MeetingGeneral = $MeetingGeneral;
	}

	/**
	 * @param Type: text
	 */
	public function setMeetingAirport($MeetingAirport){
		$this->MeetingAirport = $MeetingAirport;
	}

	/**
	 * @param Type: text
	 */
	public function setMeetingFerry($MeetingFerry){
		$this->MeetingFerry = $MeetingFerry;
	}

	/**
	 * @param Type: text
	 */
	public function setMeetingBus($MeetingBus){
		$this->MeetingBus = $MeetingBus;
	}

	/**
	 * @param Type: text
	 */
	public function setMeetingTrain($MeetingTrain){
		$this->MeetingTrain = $MeetingTrain;
	}

	/**
	 * @param Type: tinyint(1) unsigned
	 */
	public function setLocked($Locked){
		$this->Locked = $Locked;
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
			'DateChanged' => $this->getDateChanged(),
			'BookingAdvance' => $this->getBookingAdvance(),
			'DeclineTime' => $this->getDeclineTime(),
			'CancelDays' => $this->getCancelDays(),
			'CancelCharge' => $this->getCancelCharge(),
			'Deposit' => $this->getDeposit(),
			'AMEX' => $this->getAMEX(),
			'Visa' => $this->getVisa(),
			'MasterCard' => $this->getMasterCard(),
			'Diners' => $this->getDiners(),
			'MeetingGeneral' => $this->getMeetingGeneral(),
			'MeetingAirport' => $this->getMeetingAirport(),
			'MeetingFerry' => $this->getMeetingFerry(),
			'MeetingBus' => $this->getMeetingBus(),
			'MeetingTrain' => $this->getMeetingTrain(),
			'Locked' => $this->getLocked()		);
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
			'OwnerID',			'DateChanged',			'BookingAdvance',			'DeclineTime',			'CancelDays',			'CancelCharge',			'Deposit',			'AMEX',			'Visa',			'MasterCard',			'Diners',			'MeetingGeneral',			'MeetingAirport',			'MeetingFerry',			'MeetingBus',			'MeetingTrain',			'Locked'		);
		return $fieldNames;
	}
    /**
     * Close mysql connection
     */
	public function endv4_Policies_IT(){
		$this->connection->CloseMysql();
	}

}