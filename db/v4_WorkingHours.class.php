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

Class v4_WorkingHours {

	public $ID; //int(10)
	public $entryType; //varchar(255)
	public $SubDriverID; //int(10)
	public $forDate; //date
	public $dayNumber; //int(3)
	public $weekNumber; //int(2)
	public $monthNumber; //int(2)
	public $shifts; //int(2)
	public $startTime; //varchar(7)
	public $endTime; //varchar(7)
	public $pauzaStart; //varchar(7)
	public $pauzaEnd; //varchar(7)
	public $ukRedovno; //varchar(7)
	public $ukPauza; //varchar(7)
	public $ukNoc; //varchar(7)
	public $ukNedjelja; //varchar(7)
	public $ukPraznik; //varchar(7)
	public $ukupno; //varchar(7)
	public $Description; //varchar(255)
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
	public function New_v4_WorkingHours($entryType,$SubDriverID,$forDate,$dayNumber,$weekNumber,$monthNumber,$shifts,$startTime,$endTime,$pauzaStart,$pauzaEnd,$ukRedovno,$ukPauza,$ukNoc,$ukNedjelja,$ukPraznik,$ukupno,$Description){
		$this->entryType = $entryType;
		$this->SubDriverID = $SubDriverID;
		$this->forDate = $forDate;
		$this->dayNumber = $dayNumber;
		$this->weekNumber = $weekNumber;
		$this->monthNumber = $monthNumber;
		$this->shifts = $shifts;
		$this->startTime = $startTime;
		$this->endTime = $endTime;
		$this->pauzaStart = $pauzaStart;
		$this->pauzaEnd = $pauzaEnd;
		$this->ukRedovno = $ukRedovno;
		$this->ukPauza = $ukPauza;
		$this->ukNoc = $ukNoc;
		$this->ukNedjelja = $ukNedjelja;
		$this->ukPraznik = $ukPraznik;
		$this->ukupno = $ukupno;
		$this->Description = $Description;
	}

    /**
     * Load one row into var_class. To use the vars use for exemple echo $class->getVar_name; 
     *
     * @param key_table_type $key_row
     * 
     */
	public function getRow($key_row){
		$result = $this->connection->RunQuery("Select * from v4_WorkingHours where ID = \"$key_row\" ");
		if($result->num_rows < 1) return false;
		while($row = $result->fetch_array(MYSQLI_ASSOC)){
			$this->ID = $row["ID"];
			$this->entryType = $row["entryType"];
			$this->SubDriverID = $row["SubDriverID"];
			$this->forDate = $row["forDate"];
			$this->dayNumber = $row["dayNumber"];
			$this->weekNumber = $row["weekNumber"];
			$this->monthNumber = $row["monthNumber"];
			$this->shifts = $row["shifts"];
			$this->startTime = $row["startTime"];
			$this->endTime = $row["endTime"];
			$this->pauzaStart = $row["pauzaStart"];
			$this->pauzaEnd = $row["pauzaEnd"];
			$this->ukRedovno = $row["ukRedovno"];
			$this->ukPauza = $row["ukPauza"];
			$this->ukNoc = $row["ukNoc"];
			$this->ukNedjelja = $row["ukNedjelja"];
			$this->ukPraznik = $row["ukPraznik"];
			$this->ukupno = $row["ukupno"];
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
		$this->connection->RunQuery("DELETE FROM v4_WorkingHours WHERE ID = $key_row");
	}

    /**
     * Update the active row table on table
     */
	public function saveRow(){
		$result = $this->connection->RunQuery("UPDATE v4_WorkingHours set 
entryType = '".$this->myreal_escape_string($this->entryType)."', 
SubDriverID = '".$this->myreal_escape_string($this->SubDriverID)."', 
forDate = '".$this->myreal_escape_string($this->forDate)."', 
dayNumber = '".$this->myreal_escape_string($this->dayNumber)."', 
weekNumber = '".$this->myreal_escape_string($this->weekNumber)."', 
monthNumber = '".$this->myreal_escape_string($this->monthNumber)."', 
shifts = '".$this->myreal_escape_string($this->shifts)."', 
startTime = '".$this->myreal_escape_string($this->startTime)."', 
endTime = '".$this->myreal_escape_string($this->endTime)."', 
pauzaStart = '".$this->myreal_escape_string($this->pauzaStart)."', 
pauzaEnd = '".$this->myreal_escape_string($this->pauzaEnd)."', 
ukRedovno = '".$this->myreal_escape_string($this->ukRedovno)."', 
ukPauza = '".$this->myreal_escape_string($this->ukPauza)."', 
ukNoc = '".$this->myreal_escape_string($this->ukNoc)."', 
ukNedjelja = '".$this->myreal_escape_string($this->ukNedjelja)."', 
ukPraznik = '".$this->myreal_escape_string($this->ukPraznik)."', 
ukupno = '".$this->myreal_escape_string($this->ukupno)."', 
Description = '".$this->myreal_escape_string($this->Description)."' WHERE ID = '".$this->ID."'");
	return $result; 
}

    /**
     * Save the active var class as a new row on table
     */
	public function saveAsNew(){
		$this->connection->RunQuery("INSERT INTO v4_WorkingHours (entryType, SubDriverID, forDate, dayNumber, weekNumber, monthNumber, shifts, startTime, endTime, pauzaStart, pauzaEnd, ukRedovno, ukPauza, ukNoc, ukNedjelja, ukPraznik, ukupno, Description) values ('".$this->myreal_escape_string($this->entryType)."', '".$this->myreal_escape_string($this->SubDriverID)."', '".$this->myreal_escape_string($this->forDate)."', '".$this->myreal_escape_string($this->dayNumber)."', '".$this->myreal_escape_string($this->weekNumber)."', '".$this->myreal_escape_string($this->monthNumber)."', '".$this->myreal_escape_string($this->shifts)."', '".$this->myreal_escape_string($this->startTime)."', '".$this->myreal_escape_string($this->endTime)."', '".$this->myreal_escape_string($this->pauzaStart)."', '".$this->myreal_escape_string($this->pauzaEnd)."', '".$this->myreal_escape_string($this->ukRedovno)."', '".$this->myreal_escape_string($this->ukPauza)."', '".$this->myreal_escape_string($this->ukNoc)."', '".$this->myreal_escape_string($this->ukNedjelja)."', '".$this->myreal_escape_string($this->ukPraznik)."', '".$this->myreal_escape_string($this->ukupno)."', '".$this->myreal_escape_string($this->Description)."')");
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
		$result = $this->connection->RunQuery("SELECT ID from v4_WorkingHours $where ORDER BY $column $order");
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
	 * @return entryType - varchar(255)
	 */
	public function getentryType(){
		return $this->entryType;
	}

	/**
	 * @return SubDriverID - int(10)
	 */
	public function getSubDriverID(){
		return $this->SubDriverID;
	}

	/**
	 * @return forDate - date
	 */
	public function getforDate(){
		return $this->forDate;
	}

	/**
	 * @return dayNumber - int(3)
	 */
	public function getdayNumber(){
		return $this->dayNumber;
	}

	/**
	 * @return weekNumber - int(2)
	 */
	public function getweekNumber(){
		return $this->weekNumber;
	}

	/**
	 * @return monthNumber - int(2)
	 */
	public function getmonthNumber(){
		return $this->monthNumber;
	}

	/**
	 * @return shifts - int(2)
	 */
	public function getshifts(){
		return $this->shifts;
	}

	/**
	 * @return startTime - varchar(7)
	 */
	public function getstartTime(){
		return $this->startTime;
	}

	/**
	 * @return endTime - varchar(7)
	 */
	public function getendTime(){
		return $this->endTime;
	}

	/**
	 * @return pauzaStart - varchar(7)
	 */
	public function getpauzaStart(){
		return $this->pauzaStart;
	}

	/**
	 * @return pauzaEnd - varchar(7)
	 */
	public function getpauzaEnd(){
		return $this->pauzaEnd;
	}

	/**
	 * @return ukRedovno - varchar(7)
	 */
	public function getukRedovno(){
		return $this->ukRedovno;
	}

	/**
	 * @return ukPauza - varchar(7)
	 */
	public function getukPauza(){
		return $this->ukPauza;
	}

	/**
	 * @return ukNoc - varchar(7)
	 */
	public function getukNoc(){
		return $this->ukNoc;
	}

	/**
	 * @return ukNedjelja - varchar(7)
	 */
	public function getukNedjelja(){
		return $this->ukNedjelja;
	}

	/**
	 * @return ukPraznik - varchar(7)
	 */
	public function getukPraznik(){
		return $this->ukPraznik;
	}

	/**
	 * @return ukupno - varchar(7)
	 */
	public function getukupno(){
		return $this->ukupno;
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
	 * @param Type: varchar(255)
	 */
	public function setentryType($entryType){
		$this->entryType = $entryType;
	}

	/**
	 * @param Type: int(10)
	 */
	public function setSubDriverID($SubDriverID){
		$this->SubDriverID = $SubDriverID;
	}

	/**
	 * @param Type: date
	 */
	public function setforDate($forDate){
		$this->forDate = $forDate;
	}

	/**
	 * @param Type: int(3)
	 */
	public function setdayNumber($dayNumber){
		$this->dayNumber = $dayNumber;
	}

	/**
	 * @param Type: int(2)
	 */
	public function setweekNumber($weekNumber){
		$this->weekNumber = $weekNumber;
	}

	/**
	 * @param Type: int(2)
	 */
	public function setmonthNumber($monthNumber){
		$this->monthNumber = $monthNumber;
	}

	/**
	 * @param Type: int(2)
	 */
	public function setshifts($shifts){
		$this->shifts = $shifts;
	}

	/**
	 * @param Type: varchar(7)
	 */
	public function setstartTime($startTime){
		$this->startTime = $startTime;
	}

	/**
	 * @param Type: varchar(7)
	 */
	public function setendTime($endTime){
		$this->endTime = $endTime;
	}

	/**
	 * @param Type: varchar(7)
	 */
	public function setpauzaStart($pauzaStart){
		$this->pauzaStart = $pauzaStart;
	}

	/**
	 * @param Type: varchar(7)
	 */
	public function setpauzaEnd($pauzaEnd){
		$this->pauzaEnd = $pauzaEnd;
	}

	/**
	 * @param Type: varchar(7)
	 */
	public function setukRedovno($ukRedovno){
		$this->ukRedovno = $ukRedovno;
	}

	/**
	 * @param Type: varchar(7)
	 */
	public function setukPauza($ukPauza){
		$this->ukPauza = $ukPauza;
	}

	/**
	 * @param Type: varchar(7)
	 */
	public function setukNoc($ukNoc){
		$this->ukNoc = $ukNoc;
	}

	/**
	 * @param Type: varchar(7)
	 */
	public function setukNedjelja($ukNedjelja){
		$this->ukNedjelja = $ukNedjelja;
	}

	/**
	 * @param Type: varchar(7)
	 */
	public function setukPraznik($ukPraznik){
		$this->ukPraznik = $ukPraznik;
	}

	/**
	 * @param Type: varchar(7)
	 */
	public function setukupno($ukupno){
		$this->ukupno = $ukupno;
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
			'entryType' => $this->getentryType(),
			'SubDriverID' => $this->getSubDriverID(),
			'forDate' => $this->getforDate(),
			'dayNumber' => $this->getdayNumber(),
			'weekNumber' => $this->getweekNumber(),
			'monthNumber' => $this->getmonthNumber(),
			'shifts' => $this->getshifts(),
			'startTime' => $this->getstartTime(),
			'endTime' => $this->getendTime(),
			'pauzaStart' => $this->getpauzaStart(),
			'pauzaEnd' => $this->getpauzaEnd(),
			'ukRedovno' => $this->getukRedovno(),
			'ukPauza' => $this->getukPauza(),
			'ukNoc' => $this->getukNoc(),
			'ukNedjelja' => $this->getukNedjelja(),
			'ukPraznik' => $this->getukPraznik(),
			'ukupno' => $this->getukupno(),
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
			'ID',			'entryType',			'SubDriverID',			'forDate',			'dayNumber',			'weekNumber',			'monthNumber',			'shifts',			'startTime',			'endTime',			'pauzaStart',			'pauzaEnd',			'ukRedovno',			'ukPauza',			'ukNoc',			'ukNedjelja',			'ukPraznik',			'ukupno',			'Description'		);
		return $fieldNames;
	}
    /**
     * Close mysql connection
     */
	public function endv4_WorkingHours(){
		$this->connection->CloseMysql();
	}

}