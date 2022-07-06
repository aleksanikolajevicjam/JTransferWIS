<?php
require_once 'db.class.php';

Class v4_Flights {

	public $FlightID; 
	public $DetailsID;
	public $FlightNo; 
	public $FlightStatID; 
	public $FromAirP; 
	public $Departure; 
	public $ToAirP; 
	public $Arrival; 

	function __construct(){
		$this->connection = new DataBaseMysql();
	}	public function myreal_escape_string($string){
		return $this->connection->real_escape_string($string);
	}

    /**
     * New object to the class. Don´t forget to save this new object "as new" by using the function $class->saveAsNew(); 
     *
     */
	public function New_v4_Flights($DetailsID,$FlightNo,$FlightStatID,$FromAirP,$Departure,$ToAirP,$Arrival){
		$this->DetailsID = $DetailsID;
		$this->FlightNo = $FlightNo;
		$this->FlightStatID = $FlightStatID;
		$this->FromAirP = $FromAirP;
		$this->Departure = $Departure;
		$this->ToAirP = $ToAirP;
		$this->Arrival = $Arrival;
	}

    /**
     * Load one row into var_class. To use the vars use for exemple echo $class->getVar_name; 
     *
     * @param key_table_type $key_row
     * 
     */
	public function getRow($key_row){
		$result = $this->connection->RunQuery("Select * from v4_Flights where FlightID = \"$key_row\" ");
		if($result->num_rows < 1) return false;
		while($row = $result->fetch_array(MYSQLI_ASSOC)){
			$this->FlightID = $row["FlightID"];
			$this->DetailsID = $row["DetailsID"];
			$this->FlightNo = $row["FlightNo"];
			$this->FlightStatID = $row["FlightStatID"];
			$this->FromAirP = $row["FromAirP"];
			$this->Departure = $row["Departure"];
			$this->ToAirP = $row["ToAirP"];
			$this->Arrival = $row["Arrival"];
		}
	}

    /**
     * Delete the row by using the key as arg
     *
     * @param key_table_type $key_row
     *
     */
	public function deleteRow($key_row){
		$this->connection->RunQuery("DELETE FROM v4_Flights WHERE FlightID = $key_row");
	}

    /**
     * Update the active row table on table
     */
	public function saveRow(){
		$result = $this->connection->RunQuery("UPDATE v4_Flights set 
DetailsID = '".$this->myreal_escape_string($this->DetailsID)."', 
FlightNo = '".$this->myreal_escape_string($this->FlightNo)."', 
FlightStatID = '".$this->myreal_escape_string($this->FlightStatID)."', 
FromAirP = '".$this->myreal_escape_string($this->FromAirP)."', 
Departure = '".$this->myreal_escape_string($this->Departure)."', 
ToAirP = '".$this->myreal_escape_string($this->ToAirP)."', 
Arrival = '".$this->myreal_escape_string($this->Arrival)."' WHERE FlightID = '".$this->FlightID."'");
	return $result; 
}

    /**
     * Save the active var class as a new row on table
     */
	public function saveAsNew(){
		$this->connection->RunQuery("INSERT INTO v4_Flights (
			DetailsID, 
			FlightNo, 
			FlightStatID, 
			FromAirP,
			Departure, 
			ToAirP,
			Arrival
		) values (
		'".$this->myreal_escape_string($this->DetailsID)."', 
		'".$this->myreal_escape_string($this->FlightNo)."', 
		'".$this->myreal_escape_string($this->FlightStatID)."', 
		'".$this->myreal_escape_string($this->FromAirP)."', 
		'".$this->myreal_escape_string($this->Departure)."',
		'".$this->myreal_escape_string($this->ToAirP)."',
		'".$this->myreal_escape_string($this->Arrival)."')");
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
		$result = $this->connection->RunQuery("SELECT FlightID from v4_Flights $where ORDER BY $column $order");
			while($row = $result->fetch_array(MYSQLI_ASSOC)){
				$keys[$i] = $row["FlightID"];
				$i++;
			}
	return $keys;
	}

	/**
	 * @return FlightID - int(10) unsigned
	 */
	public function getFlightID(){
		return $this->FlightID;
	}

	/**
	 * @return DetailsID - int(10) unsigned
	 */
	public function getDetailsID(){
		return $this->DetailsID;
	}

	/**
	 * @return FlightNo - int(10) unsigned
	 */
	public function getFlightNo(){
		return $this->FlightNo;
	}

	/**
	 * @return FlightStatID - text
	 */
	public function getFlightStatID(){
		return $this->FlightStatID;
	}

	/**
	 * @return FromAirP - int(10) unsigned
	 */
	public function getFromAirP(){
		return $this->FromAirP;
	}	
	/**
	 * @return Departure - int(10) unsigned
	 */
	public function getDeparture(){
		return $this->Departure;
	}

	/**
	 * @return ToAirP - tinyint(4)
	 */
	public function getToAirP(){
		return $this->ToAirP;
	}

	/**
	 * @return Arrival - tinyint(4)
	 */
	public function getArrival(){
		return $this->Arrival;
	}

	/**
	 * @param Type: int(10) unsigned
	 */
	public function setFlightID($FlightID){
		$this->FlightID = $FlightID;
	}

	/**
	 * @param Type: int(10) unsigned
	 */
	public function setDetailsID($DetailsID){
		$this->DetailsID = $DetailsID;
	}

	/**
	 * @param Type: int(10) unsigned
	 */
	public function setFlightNo($FlightNo){
		$this->FlightNo = $FlightNo;
	}

	/**
	 * @param Type: text
	 */
	public function setFlightStatID($FlightStatID){
		$this->FlightStatID = $FlightStatID;
	}

	/**
	 * @param Type: int(10) unsigned
	 */
	public function setFromAirP($FromAirP){
		$this->FromAirP = $FromAirP;
	}	
	/**
	 * @param Type: int(10) unsigned
	 */
	public function setDeparture($Departure){
		$this->Departure = $Departure;
	}

	/**
	 * @param Type: tinyint(4)
	 */
	public function setToAirP($ToAirP){
		$this->ToAirP = $ToAirP;
	}

	/**
	 * @param Type: tinyint(4)
	 */
	public function setArrival($Arrival){
		$this->Arrival = $Arrival;
	}
	
    /**
     * fieldValues - Load all fieldNames and fieldValues into Array. 
     *
     * @param 
     * 
     */
	public function fieldValues(){
		$fieldValues = array(
			'FlightID' => $this->getFlightID(),
			'DetailsID' => $this->getDetailsID(),
			'FlightNo' => $this->getFlightNo(),
			'FlightStatID' => $this->getFlightStatID(),
			'FromAirP' => $this->getFromAirP(),
			'Departure' => $this->getDeparture(),
			'ToAirP' => $this->getToAirP(),		
			'Arrival' => $this->getArrival()		);
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
			'FlightID',			'DetailsID',			'FlightNo',			'FlightStatID',			'FromAirP',			'FromAirP',		'ToAirP',		'Arrival'		);
		return $fieldNames;
	}
    /**
     * Close mysql connection
     */
	public function endv4_Flights(){
		$this->connection->CloseMysql();
	}

}