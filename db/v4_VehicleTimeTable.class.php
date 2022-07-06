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

Class v4_VehicleTimeTable {

	public $OwnerID; //int(10) unsigned
	public $WSID; //int(10) unsigned
	public $VehicleID; //int(10) unsigned
	public $TaskID; //int(10) unsigned
	public $TaskDesc; //varchar(255)
	public $TaskDetails; //text
	public $Extras; //text
	public $MyDriver; //varchar(100)
	public $StartDate; //date
	public $StartTime; //varchar(12)
	public $FlightNo; //varchar(20)
	public $FlightTime; //varchar(20)
	public $PickupDate; //date
	public $PickupTime; //varchar(12)
	public $PickupName; //varchar(255)
	public $PickupPlace; //varchar(255)
	public $PickupAddress; //varchar(255)
	public $DropName; //varchar(255)
	public $DropPlace; //varchar(255)
	public $DropAddress; //varchar(255)
	public $PaxName; //varchar(255)
	public $PaxGSM; //varchar(50)
	public $PaxNotes; //text
	public $AfterTask; //varchar(100)
	public $OrderDetailsID; //int(10) unsigned
	public $KmStart; //int(9) unsigned
	public $KmEnd; //int(9) unsigned
	public $Cash; //decimal(6,2) unsigned
	public $Status; //tinyint(2) unsigned
	public $Completition; //tinyint(2) unsigned
	public $DriverNotes; //text
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
	public function New_v4_VehicleTimeTable($OwnerID,$WSID,$VehicleID,$TaskDesc,$TaskDetails,$Extras,$MyDriver,$StartDate,$StartTime,$FlightNo,$FlightTime,$PickupDate,$PickupTime,$PickupName,$PickupPlace,$PickupAddress,$DropName,$DropPlace,$DropAddress,$PaxName,$PaxGSM,$PaxNotes,$AfterTask,$OrderDetailsID,$KmStart,$KmEnd,$Cash,$Status,$Completition,$DriverNotes){
		$this->OwnerID = $OwnerID;
		$this->WSID = $WSID;
		$this->VehicleID = $VehicleID;
		$this->TaskDesc = $TaskDesc;
		$this->TaskDetails = $TaskDetails;
		$this->Extras = $Extras;
		$this->MyDriver = $MyDriver;
		$this->StartDate = $StartDate;
		$this->StartTime = $StartTime;
		$this->FlightNo = $FlightNo;
		$this->FlightTime = $FlightTime;
		$this->PickupDate = $PickupDate;
		$this->PickupTime = $PickupTime;
		$this->PickupName = $PickupName;
		$this->PickupPlace = $PickupPlace;
		$this->PickupAddress = $PickupAddress;
		$this->DropName = $DropName;
		$this->DropPlace = $DropPlace;
		$this->DropAddress = $DropAddress;
		$this->PaxName = $PaxName;
		$this->PaxGSM = $PaxGSM;
		$this->PaxNotes = $PaxNotes;
		$this->AfterTask = $AfterTask;
		$this->OrderDetailsID = $OrderDetailsID;
		$this->KmStart = $KmStart;
		$this->KmEnd = $KmEnd;
		$this->Cash = $Cash;
		$this->Status = $Status;
		$this->Completition = $Completition;
		$this->DriverNotes = $DriverNotes;
	}

    /**
     * Load one row into var_class. To use the vars use for exemple echo $class->getVar_name; 
     *
     * @param key_table_type $key_row
     * 
     */
	public function getRow($key_row){
		$result = $this->connection->RunQuery("Select * from v4_VehicleTimeTable where TaskID = \"$key_row\" ");
		if($result->num_rows < 1) return false;
		while($row = $result->fetch_array(MYSQLI_ASSOC)){
			$this->OwnerID = $row["OwnerID"];
			$this->WSID = $row["WSID"];
			$this->VehicleID = $row["VehicleID"];
			$this->TaskID = $row["TaskID"];
			$this->TaskDesc = $row["TaskDesc"];
			$this->TaskDetails = $row["TaskDetails"];
			$this->Extras = $row["Extras"];
			$this->MyDriver = $row["MyDriver"];
			$this->StartDate = $row["StartDate"];
			$this->StartTime = $row["StartTime"];
			$this->FlightNo = $row["FlightNo"];
			$this->FlightTime = $row["FlightTime"];
			$this->PickupDate = $row["PickupDate"];
			$this->PickupTime = $row["PickupTime"];
			$this->PickupName = $row["PickupName"];
			$this->PickupPlace = $row["PickupPlace"];
			$this->PickupAddress = $row["PickupAddress"];
			$this->DropName = $row["DropName"];
			$this->DropPlace = $row["DropPlace"];
			$this->DropAddress = $row["DropAddress"];
			$this->PaxName = $row["PaxName"];
			$this->PaxGSM = $row["PaxGSM"];
			$this->PaxNotes = $row["PaxNotes"];
			$this->AfterTask = $row["AfterTask"];
			$this->OrderDetailsID = $row["OrderDetailsID"];
			$this->KmStart = $row["KmStart"];
			$this->KmEnd = $row["KmEnd"];
			$this->Cash = $row["Cash"];
			$this->Status = $row["Status"];
			$this->Completition = $row["Completition"];
			$this->DriverNotes = $row["DriverNotes"];
		}
	}

    /**
     * Delete the row by using the key as arg
     *
     * @param key_table_type $key_row
     *
     */
	public function deleteRow($key_row){
		$this->connection->RunQuery("DELETE FROM v4_VehicleTimeTable WHERE TaskID = $key_row");
	}

    /**
     * Update the active row table on table
     */
	public function saveRow(){
		$result = $this->connection->RunQuery("UPDATE v4_VehicleTimeTable set 
OwnerID = '".$this->myreal_escape_string($this->OwnerID)."', 
WSID = '".$this->myreal_escape_string($this->WSID)."', 
VehicleID = '".$this->myreal_escape_string($this->VehicleID)."', 
TaskDesc = '".$this->myreal_escape_string($this->TaskDesc)."', 
TaskDetails = '".$this->myreal_escape_string($this->TaskDetails)."', 
Extras = '".$this->myreal_escape_string($this->Extras)."', 
MyDriver = '".$this->myreal_escape_string($this->MyDriver)."', 
StartDate = '".$this->myreal_escape_string($this->StartDate)."', 
StartTime = '".$this->myreal_escape_string($this->StartTime)."', 
FlightNo = '".$this->myreal_escape_string($this->FlightNo)."', 
FlightTime = '".$this->myreal_escape_string($this->FlightTime)."', 
PickupDate = '".$this->myreal_escape_string($this->PickupDate)."', 
PickupTime = '".$this->myreal_escape_string($this->PickupTime)."', 
PickupName = '".$this->myreal_escape_string($this->PickupName)."', 
PickupPlace = '".$this->myreal_escape_string($this->PickupPlace)."', 
PickupAddress = '".$this->myreal_escape_string($this->PickupAddress)."', 
DropName = '".$this->myreal_escape_string($this->DropName)."', 
DropPlace = '".$this->myreal_escape_string($this->DropPlace)."', 
DropAddress = '".$this->myreal_escape_string($this->DropAddress)."', 
PaxName = '".$this->myreal_escape_string($this->PaxName)."', 
PaxGSM = '".$this->myreal_escape_string($this->PaxGSM)."', 
PaxNotes = '".$this->myreal_escape_string($this->PaxNotes)."', 
AfterTask = '".$this->myreal_escape_string($this->AfterTask)."', 
OrderDetailsID = '".$this->myreal_escape_string($this->OrderDetailsID)."', 
KmStart = '".$this->myreal_escape_string($this->KmStart)."', 
KmEnd = '".$this->myreal_escape_string($this->KmEnd)."', 
Cash = '".$this->myreal_escape_string($this->Cash)."', 
Status = '".$this->myreal_escape_string($this->Status)."', 
Completition = '".$this->myreal_escape_string($this->Completition)."', 
DriverNotes = '".$this->myreal_escape_string($this->DriverNotes)."' WHERE TaskID = '".$this->TaskID."'");
	return $result; 
}

    /**
     * Save the active var class as a new row on table
     */
	public function saveAsNew(){
		$this->connection->RunQuery("INSERT INTO v4_VehicleTimeTable (OwnerID, WSID, VehicleID, TaskDesc, TaskDetails, Extras, MyDriver, StartDate, StartTime, FlightNo, FlightTime, PickupDate, PickupTime, PickupName, PickupPlace, PickupAddress, DropName, DropPlace, DropAddress, PaxName, PaxGSM, PaxNotes, AfterTask, OrderDetailsID, KmStart, KmEnd, Cash, Status, Completition, DriverNotes) values ('".$this->myreal_escape_string($this->OwnerID)."', '".$this->myreal_escape_string($this->WSID)."', '".$this->myreal_escape_string($this->VehicleID)."', '".$this->myreal_escape_string($this->TaskDesc)."', '".$this->myreal_escape_string($this->TaskDetails)."', '".$this->myreal_escape_string($this->Extras)."', '".$this->myreal_escape_string($this->MyDriver)."', '".$this->myreal_escape_string($this->StartDate)."', '".$this->myreal_escape_string($this->StartTime)."', '".$this->myreal_escape_string($this->FlightNo)."', '".$this->myreal_escape_string($this->FlightTime)."', '".$this->myreal_escape_string($this->PickupDate)."', '".$this->myreal_escape_string($this->PickupTime)."', '".$this->myreal_escape_string($this->PickupName)."', '".$this->myreal_escape_string($this->PickupPlace)."', '".$this->myreal_escape_string($this->PickupAddress)."', '".$this->myreal_escape_string($this->DropName)."', '".$this->myreal_escape_string($this->DropPlace)."', '".$this->myreal_escape_string($this->DropAddress)."', '".$this->myreal_escape_string($this->PaxName)."', '".$this->myreal_escape_string($this->PaxGSM)."', '".$this->myreal_escape_string($this->PaxNotes)."', '".$this->myreal_escape_string($this->AfterTask)."', '".$this->myreal_escape_string($this->OrderDetailsID)."', '".$this->myreal_escape_string($this->KmStart)."', '".$this->myreal_escape_string($this->KmEnd)."', '".$this->myreal_escape_string($this->Cash)."', '".$this->myreal_escape_string($this->Status)."', '".$this->myreal_escape_string($this->Completition)."', '".$this->myreal_escape_string($this->DriverNotes)."')");
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
		$result = $this->connection->RunQuery("SELECT TaskID from v4_VehicleTimeTable $where ORDER BY $column $order");
			while($row = $result->fetch_array(MYSQLI_ASSOC)){
				$keys[$i] = $row["TaskID"];
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
	 * @return WSID - int(10) unsigned
	 */
	public function getWSID(){
		return $this->WSID;
	}

	/**
	 * @return VehicleID - int(10) unsigned
	 */
	public function getVehicleID(){
		return $this->VehicleID;
	}

	/**
	 * @return TaskID - int(10) unsigned
	 */
	public function getTaskID(){
		return $this->TaskID;
	}

	/**
	 * @return TaskDesc - varchar(255)
	 */
	public function getTaskDesc(){
		return $this->TaskDesc;
	}

	/**
	 * @return TaskDetails - text
	 */
	public function getTaskDetails(){
		return $this->TaskDetails;
	}

	/**
	 * @return Extras - text
	 */
	public function getExtras(){
		return $this->Extras;
	}

	/**
	 * @return MyDriver - varchar(100)
	 */
	public function getMyDriver(){
		return $this->MyDriver;
	}

	/**
	 * @return StartDate - date
	 */
	public function getStartDate(){
		return $this->StartDate;
	}

	/**
	 * @return StartTime - varchar(12)
	 */
	public function getStartTime(){
		return $this->StartTime;
	}

	/**
	 * @return FlightNo - varchar(20)
	 */
	public function getFlightNo(){
		return $this->FlightNo;
	}

	/**
	 * @return FlightTime - varchar(20)
	 */
	public function getFlightTime(){
		return $this->FlightTime;
	}

	/**
	 * @return PickupDate - date
	 */
	public function getPickupDate(){
		return $this->PickupDate;
	}

	/**
	 * @return PickupTime - varchar(12)
	 */
	public function getPickupTime(){
		return $this->PickupTime;
	}

	/**
	 * @return PickupName - varchar(255)
	 */
	public function getPickupName(){
		return $this->PickupName;
	}

	/**
	 * @return PickupPlace - varchar(255)
	 */
	public function getPickupPlace(){
		return $this->PickupPlace;
	}

	/**
	 * @return PickupAddress - varchar(255)
	 */
	public function getPickupAddress(){
		return $this->PickupAddress;
	}

	/**
	 * @return DropName - varchar(255)
	 */
	public function getDropName(){
		return $this->DropName;
	}

	/**
	 * @return DropPlace - varchar(255)
	 */
	public function getDropPlace(){
		return $this->DropPlace;
	}

	/**
	 * @return DropAddress - varchar(255)
	 */
	public function getDropAddress(){
		return $this->DropAddress;
	}

	/**
	 * @return PaxName - varchar(255)
	 */
	public function getPaxName(){
		return $this->PaxName;
	}

	/**
	 * @return PaxGSM - varchar(50)
	 */
	public function getPaxGSM(){
		return $this->PaxGSM;
	}

	/**
	 * @return PaxNotes - text
	 */
	public function getPaxNotes(){
		return $this->PaxNotes;
	}

	/**
	 * @return AfterTask - varchar(100)
	 */
	public function getAfterTask(){
		return $this->AfterTask;
	}

	/**
	 * @return OrderDetailsID - int(10) unsigned
	 */
	public function getOrderDetailsID(){
		return $this->OrderDetailsID;
	}

	/**
	 * @return KmStart - int(9) unsigned
	 */
	public function getKmStart(){
		return $this->KmStart;
	}

	/**
	 * @return KmEnd - int(9) unsigned
	 */
	public function getKmEnd(){
		return $this->KmEnd;
	}

	/**
	 * @return Cash - decimal(6,2) unsigned
	 */
	public function getCash(){
		return $this->Cash;
	}

	/**
	 * @return Status - tinyint(2) unsigned
	 */
	public function getStatus(){
		return $this->Status;
	}

	/**
	 * @return Completition - tinyint(2) unsigned
	 */
	public function getCompletition(){
		return $this->Completition;
	}

	/**
	 * @return DriverNotes - text
	 */
	public function getDriverNotes(){
		return $this->DriverNotes;
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
	public function setWSID($WSID){
		$this->WSID = $WSID;
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
	public function setTaskID($TaskID){
		$this->TaskID = $TaskID;
	}

	/**
	 * @param Type: varchar(255)
	 */
	public function setTaskDesc($TaskDesc){
		$this->TaskDesc = $TaskDesc;
	}

	/**
	 * @param Type: text
	 */
	public function setTaskDetails($TaskDetails){
		$this->TaskDetails = $TaskDetails;
	}

	/**
	 * @param Type: text
	 */
	public function setExtras($Extras){
		$this->Extras = $Extras;
	}

	/**
	 * @param Type: varchar(100)
	 */
	public function setMyDriver($MyDriver){
		$this->MyDriver = $MyDriver;
	}

	/**
	 * @param Type: date
	 */
	public function setStartDate($StartDate){
		$this->StartDate = $StartDate;
	}

	/**
	 * @param Type: varchar(12)
	 */
	public function setStartTime($StartTime){
		$this->StartTime = $StartTime;
	}

	/**
	 * @param Type: varchar(20)
	 */
	public function setFlightNo($FlightNo){
		$this->FlightNo = $FlightNo;
	}

	/**
	 * @param Type: varchar(20)
	 */
	public function setFlightTime($FlightTime){
		$this->FlightTime = $FlightTime;
	}

	/**
	 * @param Type: date
	 */
	public function setPickupDate($PickupDate){
		$this->PickupDate = $PickupDate;
	}

	/**
	 * @param Type: varchar(12)
	 */
	public function setPickupTime($PickupTime){
		$this->PickupTime = $PickupTime;
	}

	/**
	 * @param Type: varchar(255)
	 */
	public function setPickupName($PickupName){
		$this->PickupName = $PickupName;
	}

	/**
	 * @param Type: varchar(255)
	 */
	public function setPickupPlace($PickupPlace){
		$this->PickupPlace = $PickupPlace;
	}

	/**
	 * @param Type: varchar(255)
	 */
	public function setPickupAddress($PickupAddress){
		$this->PickupAddress = $PickupAddress;
	}

	/**
	 * @param Type: varchar(255)
	 */
	public function setDropName($DropName){
		$this->DropName = $DropName;
	}

	/**
	 * @param Type: varchar(255)
	 */
	public function setDropPlace($DropPlace){
		$this->DropPlace = $DropPlace;
	}

	/**
	 * @param Type: varchar(255)
	 */
	public function setDropAddress($DropAddress){
		$this->DropAddress = $DropAddress;
	}

	/**
	 * @param Type: varchar(255)
	 */
	public function setPaxName($PaxName){
		$this->PaxName = $PaxName;
	}

	/**
	 * @param Type: varchar(50)
	 */
	public function setPaxGSM($PaxGSM){
		$this->PaxGSM = $PaxGSM;
	}

	/**
	 * @param Type: text
	 */
	public function setPaxNotes($PaxNotes){
		$this->PaxNotes = $PaxNotes;
	}

	/**
	 * @param Type: varchar(100)
	 */
	public function setAfterTask($AfterTask){
		$this->AfterTask = $AfterTask;
	}

	/**
	 * @param Type: int(10) unsigned
	 */
	public function setOrderDetailsID($OrderDetailsID){
		$this->OrderDetailsID = $OrderDetailsID;
	}

	/**
	 * @param Type: int(9) unsigned
	 */
	public function setKmStart($KmStart){
		$this->KmStart = $KmStart;
	}

	/**
	 * @param Type: int(9) unsigned
	 */
	public function setKmEnd($KmEnd){
		$this->KmEnd = $KmEnd;
	}

	/**
	 * @param Type: decimal(6,2) unsigned
	 */
	public function setCash($Cash){
		$this->Cash = $Cash;
	}

	/**
	 * @param Type: tinyint(2) unsigned
	 */
	public function setStatus($Status){
		$this->Status = $Status;
	}

	/**
	 * @param Type: tinyint(2) unsigned
	 */
	public function setCompletition($Completition){
		$this->Completition = $Completition;
	}

	/**
	 * @param Type: text
	 */
	public function setDriverNotes($DriverNotes){
		$this->DriverNotes = $DriverNotes;
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
			'WSID' => $this->getWSID(),
			'VehicleID' => $this->getVehicleID(),
			'TaskID' => $this->getTaskID(),
			'TaskDesc' => $this->getTaskDesc(),
			'TaskDetails' => $this->getTaskDetails(),
			'Extras' => $this->getExtras(),
			'MyDriver' => $this->getMyDriver(),
			'StartDate' => $this->getStartDate(),
			'StartTime' => $this->getStartTime(),
			'FlightNo' => $this->getFlightNo(),
			'FlightTime' => $this->getFlightTime(),
			'PickupDate' => $this->getPickupDate(),
			'PickupTime' => $this->getPickupTime(),
			'PickupName' => $this->getPickupName(),
			'PickupPlace' => $this->getPickupPlace(),
			'PickupAddress' => $this->getPickupAddress(),
			'DropName' => $this->getDropName(),
			'DropPlace' => $this->getDropPlace(),
			'DropAddress' => $this->getDropAddress(),
			'PaxName' => $this->getPaxName(),
			'PaxGSM' => $this->getPaxGSM(),
			'PaxNotes' => $this->getPaxNotes(),
			'AfterTask' => $this->getAfterTask(),
			'OrderDetailsID' => $this->getOrderDetailsID(),
			'KmStart' => $this->getKmStart(),
			'KmEnd' => $this->getKmEnd(),
			'Cash' => $this->getCash(),
			'Status' => $this->getStatus(),
			'Completition' => $this->getCompletition(),
			'DriverNotes' => $this->getDriverNotes()		);
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
			'OwnerID',			'WSID',			'VehicleID',			'TaskID',			'TaskDesc',			'TaskDetails',			'Extras',			'MyDriver',			'StartDate',			'StartTime',			'FlightNo',			'FlightTime',			'PickupDate',			'PickupTime',			'PickupName',			'PickupPlace',			'PickupAddress',			'DropName',			'DropPlace',			'DropAddress',			'PaxName',			'PaxGSM',			'PaxNotes',			'AfterTask',			'OrderDetailsID',			'KmStart',			'KmEnd',			'Cash',			'Status',			'Completition',			'DriverNotes'		);
		return $fieldNames;
	}
    /**
     * Close mysql connection
     */
	public function endv4_VehicleTimeTable(){
		$this->connection->CloseMysql();
	}

}