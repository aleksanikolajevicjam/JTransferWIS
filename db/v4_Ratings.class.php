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

Class v4_Ratings {

	public $OwnerID; //int(10) unsigned
	public $Average; //decimal(10,1) unsigned
	public $Votes; //int(10) unsigned
	public $Overall; //decimal(10,1) unsigned
	public $Punct; //decimal(10,1) unsigned
	public $Respons; //decimal(10,1) unsigned
	public $Kind; //decimal(10,1) unsigned
	public $Vehicle; //decimal(10,1) unsigned
	public $Driver; //decimal(10,1) unsigned
	public $LastVote; //varchar(25)
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
	public function New_v4_Ratings($Average,$Votes,$Overall,$Punct,$Respons,$Kind,$Vehicle,$Driver,$LastVote){
		$this->Average = $Average;
		$this->Votes = $Votes;
		$this->Overall = $Overall;
		$this->Punct = $Punct;
		$this->Respons = $Respons;
		$this->Kind = $Kind;
		$this->Vehicle = $Vehicle;
		$this->Driver = $Driver;
		$this->LastVote = $LastVote;
	}

    /**
     * Load one row into var_class. To use the vars use for exemple echo $class->getVar_name; 
     *
     * @param key_table_type $key_row
     * 
     */
	public function getRow($key_row){
		$result = $this->connection->RunQuery("Select * from v4_Ratings where OwnerID = \"$key_row\" ");
		if($result->num_rows < 1) return false;
		while($row = $result->fetch_array(MYSQLI_ASSOC)){
			$this->OwnerID = $row["OwnerID"];
			$this->Average = $row["Average"];
			$this->Votes = $row["Votes"];
			$this->Overall = $row["Overall"];
			$this->Punct = $row["Punct"];
			$this->Respons = $row["Respons"];
			$this->Kind = $row["Kind"];
			$this->Vehicle = $row["Vehicle"];
			$this->Driver = $row["Driver"];
			$this->LastVote = $row["LastVote"];
		}
	}

    /**
     * Delete the row by using the key as arg
     *
     * @param key_table_type $key_row
     *
     */
	public function deleteRow($key_row){
		$this->connection->RunQuery("DELETE FROM v4_Ratings WHERE OwnerID = $key_row");
	}

    /**
     * Update the active row table on table
     */
	public function saveRow(){
		$result = $this->connection->RunQuery("UPDATE v4_Ratings set 
Average = '".$this->myreal_escape_string($this->Average)."', 
Votes = '".$this->myreal_escape_string($this->Votes)."', 
Overall = '".$this->myreal_escape_string($this->Overall)."', 
Punct = '".$this->myreal_escape_string($this->Punct)."', 
Respons = '".$this->myreal_escape_string($this->Respons)."', 
Kind = '".$this->myreal_escape_string($this->Kind)."', 
Vehicle = '".$this->myreal_escape_string($this->Vehicle)."', 
Driver = '".$this->myreal_escape_string($this->Driver)."', 
LastVote = '".$this->myreal_escape_string($this->LastVote)."' WHERE OwnerID = '".$this->OwnerID."'");
	return $result; 
}

    /**
     * Save the active var class as a new row on table
     */
	public function saveAsNew(){
		$this->connection->RunQuery("INSERT INTO v4_Ratings (Average, Votes, Overall, Punct, Respons, Kind, Vehicle, Driver, LastVote) values ('".$this->myreal_escape_string($this->Average)."', '".$this->myreal_escape_string($this->Votes)."', '".$this->myreal_escape_string($this->Overall)."', '".$this->myreal_escape_string($this->Punct)."', '".$this->myreal_escape_string($this->Respons)."', '".$this->myreal_escape_string($this->Kind)."', '".$this->myreal_escape_string($this->Vehicle)."', '".$this->myreal_escape_string($this->Driver)."', '".$this->myreal_escape_string($this->LastVote)."')");
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
		$result = $this->connection->RunQuery("SELECT OwnerID from v4_Ratings $where ORDER BY $column $order");
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
	 * @return Average - decimal(10,1) unsigned
	 */
	public function getAverage(){
		return $this->Average;
	}

	/**
	 * @return Votes - int(10) unsigned
	 */
	public function getVotes(){
		return $this->Votes;
	}

	/**
	 * @return Overall - decimal(10,1) unsigned
	 */
	public function getOverall(){
		return $this->Overall;
	}

	/**
	 * @return Punct - decimal(10,1) unsigned
	 */
	public function getPunct(){
		return $this->Punct;
	}

	/**
	 * @return Respons - decimal(10,1) unsigned
	 */
	public function getRespons(){
		return $this->Respons;
	}

	/**
	 * @return Kind - decimal(10,1) unsigned
	 */
	public function getKind(){
		return $this->Kind;
	}

	/**
	 * @return Vehicle - decimal(10,1) unsigned
	 */
	public function getVehicle(){
		return $this->Vehicle;
	}

	/**
	 * @return Driver - decimal(10,1) unsigned
	 */
	public function getDriver(){
		return $this->Driver;
	}

	/**
	 * @return LastVote - varchar(25)
	 */
	public function getLastVote(){
		return $this->LastVote;
	}

	/**
	 * @param Type: int(10) unsigned
	 */
	public function setOwnerID($OwnerID){
		$this->OwnerID = $OwnerID;
	}

	/**
	 * @param Type: decimal(10,1) unsigned
	 */
	public function setAverage($Average){
		$this->Average = $Average;
	}

	/**
	 * @param Type: int(10) unsigned
	 */
	public function setVotes($Votes){
		$this->Votes = $Votes;
	}

	/**
	 * @param Type: decimal(10,1) unsigned
	 */
	public function setOverall($Overall){
		$this->Overall = $Overall;
	}

	/**
	 * @param Type: decimal(10,1) unsigned
	 */
	public function setPunct($Punct){
		$this->Punct = $Punct;
	}

	/**
	 * @param Type: decimal(10,1) unsigned
	 */
	public function setRespons($Respons){
		$this->Respons = $Respons;
	}

	/**
	 * @param Type: decimal(10,1) unsigned
	 */
	public function setKind($Kind){
		$this->Kind = $Kind;
	}

	/**
	 * @param Type: decimal(10,1) unsigned
	 */
	public function setVehicle($Vehicle){
		$this->Vehicle = $Vehicle;
	}

	/**
	 * @param Type: decimal(10,1) unsigned
	 */
	public function setDriver($Driver){
		$this->Driver = $Driver;
	}

	/**
	 * @param Type: varchar(25)
	 */
	public function setLastVote($LastVote){
		$this->LastVote = $LastVote;
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
			'Average' => $this->getAverage(),
			'Votes' => $this->getVotes(),
			'Overall' => $this->getOverall(),
			'Punct' => $this->getPunct(),
			'Respons' => $this->getRespons(),
			'Kind' => $this->getKind(),
			'Vehicle' => $this->getVehicle(),
			'Driver' => $this->getDriver(),
			'LastVote' => $this->getLastVote()		);
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
			'OwnerID',			'Average',			'Votes',			'Overall',			'Punct',			'Respons',			'Kind',			'Vehicle',			'Driver',			'LastVote'		);
		return $fieldNames;
	}
    /**
     * Close mysql connection
     */
	public function endv4_Ratings(){
		$this->connection->CloseMysql();
	}

}