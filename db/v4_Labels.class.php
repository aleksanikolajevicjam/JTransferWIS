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

Class v4_Labels {

	public $LabelID; //int(10) unsigned
	public $Label; //varchar(255)
	public $LabelEN; //varchar(255)
	public $LabelRU; //varchar(255)
	public $LabelFR; //varchar(255)
	public $LabelDE; //varchar(255)
	public $LabelIT; //varchar(255)
	public $LabelSE; //varchar(255)
	public $LabelNO; //varchar(255)
	public $LabelES; //varchar(255)
	public $LabelNL; //varchar(255)
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
	public function New_v4_Labels($Label,$LabelEN,$LabelRU,$LabelFR,$LabelDE,$LabelIT,$LabelSE,$LabelNO,$LabelES,$LabelNL){
		$this->Label = $Label;
		$this->LabelEN = $LabelEN;
		$this->LabelRU = $LabelRU;
		$this->LabelFR = $LabelFR;
		$this->LabelDE = $LabelDE;
		$this->LabelIT = $LabelIT;
		$this->LabelSE = $LabelSE;
		$this->LabelNO = $LabelNO;
		$this->LabelES = $LabelES;
		$this->LabelNL = $LabelNL;
	}

    /**
     * Load one row into var_class. To use the vars use for exemple echo $class->getVar_name; 
     *
     * @param key_table_type $key_row
     * 
     */
	public function getRow($key_row){
		$result = $this->connection->RunQuery("Select * from v4_Labels where LabelID = \"$key_row\" ");
		if($result->num_rows < 1) return false;
		while($row = $result->fetch_array(MYSQLI_ASSOC)){
			$this->LabelID = $row["LabelID"];
			$this->Label = $row["Label"];
			$this->LabelEN = $row["LabelEN"];
			$this->LabelRU = $row["LabelRU"];
			$this->LabelFR = $row["LabelFR"];
			$this->LabelDE = $row["LabelDE"];
			$this->LabelIT = $row["LabelIT"];
			$this->LabelSE = $row["LabelSE"];
			$this->LabelNO = $row["LabelNO"];
			$this->LabelES = $row["LabelES"];
			$this->LabelNL = $row["LabelNL"];
		}
	}

    /**
     * Delete the row by using the key as arg
     *
     * @param key_table_type $key_row
     *
     */
	public function deleteRow($key_row){
		$this->connection->RunQuery("DELETE FROM v4_Labels WHERE LabelID = $key_row");
	}

    /**
     * Update the active row table on table
     */
	public function saveRow(){
		$result = $this->connection->RunQuery("UPDATE v4_Labels set 
Label = '".$this->myreal_escape_string($this->Label)."', 
LabelEN = '".$this->myreal_escape_string($this->LabelEN)."', 
LabelRU = '".$this->myreal_escape_string($this->LabelRU)."', 
LabelFR = '".$this->myreal_escape_string($this->LabelFR)."', 
LabelDE = '".$this->myreal_escape_string($this->LabelDE)."', 
LabelIT = '".$this->myreal_escape_string($this->LabelIT)."', 
LabelSE = '".$this->myreal_escape_string($this->LabelSE)."', 
LabelNO = '".$this->myreal_escape_string($this->LabelNO)."', 
LabelES = '".$this->myreal_escape_string($this->LabelES)."', 
LabelNL = '".$this->myreal_escape_string($this->LabelNL)."' WHERE LabelID = '".$this->LabelID."'");
	return $result; 
}

    /**
     * Save the active var class as a new row on table
     */
	public function saveAsNew(){
		$this->connection->RunQuery("INSERT INTO v4_Labels (Label, LabelEN, LabelRU, LabelFR, LabelDE, LabelIT, LabelSE, LabelNO, LabelES, LabelNL) values ('".$this->myreal_escape_string($this->Label)."', '".$this->myreal_escape_string($this->LabelEN)."', '".$this->myreal_escape_string($this->LabelRU)."', '".$this->myreal_escape_string($this->LabelFR)."', '".$this->myreal_escape_string($this->LabelDE)."', '".$this->myreal_escape_string($this->LabelIT)."', '".$this->myreal_escape_string($this->LabelSE)."', '".$this->myreal_escape_string($this->LabelNO)."', '".$this->myreal_escape_string($this->LabelES)."', '".$this->myreal_escape_string($this->LabelNL)."')");
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
		$result = $this->connection->RunQuery("SELECT LabelID from v4_Labels $where ORDER BY $column $order");
			while($row = $result->fetch_array(MYSQLI_ASSOC)){
				$keys[$i] = $row["LabelID"];
				$i++;
			}
	return $keys;
	}

	/**
	 * @return LabelID - int(10) unsigned
	 */
	public function getLabelID(){
		return $this->LabelID;
	}

	/**
	 * @return Label - varchar(255)
	 */
	public function getLabel(){
		return $this->Label;
	}

	/**
	 * @return LabelEN - varchar(255)
	 */
	public function getLabelEN(){
		return $this->LabelEN;
	}

	/**
	 * @return LabelRU - varchar(255)
	 */
	public function getLabelRU(){
		return $this->LabelRU;
	}

	/**
	 * @return LabelFR - varchar(255)
	 */
	public function getLabelFR(){
		return $this->LabelFR;
	}

	/**
	 * @return LabelDE - varchar(255)
	 */
	public function getLabelDE(){
		return $this->LabelDE;
	}

	/**
	 * @return LabelIT - varchar(255)
	 */
	public function getLabelIT(){
		return $this->LabelIT;
	}

	/**
	 * @return LabelSE - varchar(255)
	 */
	public function getLabelSE(){
		return $this->LabelSE;
	}

	/**
	 * @return LabelNO - varchar(255)
	 */
	public function getLabelNO(){
		return $this->LabelNO;
	}

	/**
	 * @return LabelES - varchar(255)
	 */
	public function getLabelES(){
		return $this->LabelES;
	}

	/**
	 * @return LabelNL - varchar(255)
	 */
	public function getLabelNL(){
		return $this->LabelNL;
	}

	/**
	 * @param Type: int(10) unsigned
	 */
	public function setLabelID($LabelID){
		$this->LabelID = $LabelID;
	}

	/**
	 * @param Type: varchar(255)
	 */
	public function setLabel($Label){
		$this->Label = $Label;
	}

	/**
	 * @param Type: varchar(255)
	 */
	public function setLabelEN($LabelEN){
		$this->LabelEN = $LabelEN;
	}

	/**
	 * @param Type: varchar(255)
	 */
	public function setLabelRU($LabelRU){
		$this->LabelRU = $LabelRU;
	}

	/**
	 * @param Type: varchar(255)
	 */
	public function setLabelFR($LabelFR){
		$this->LabelFR = $LabelFR;
	}

	/**
	 * @param Type: varchar(255)
	 */
	public function setLabelDE($LabelDE){
		$this->LabelDE = $LabelDE;
	}

	/**
	 * @param Type: varchar(255)
	 */
	public function setLabelIT($LabelIT){
		$this->LabelIT = $LabelIT;
	}

	/**
	 * @param Type: varchar(255)
	 */
	public function setLabelSE($LabelSE){
		$this->LabelSE = $LabelSE;
	}

	/**
	 * @param Type: varchar(255)
	 */
	public function setLabelNO($LabelNO){
		$this->LabelNO = $LabelNO;
	}

	/**
	 * @param Type: varchar(255)
	 */
	public function setLabelES($LabelES){
		$this->LabelES = $LabelES;
	}

	/**
	 * @param Type: varchar(255)
	 */
	public function setLabelNL($LabelNL){
		$this->LabelNL = $LabelNL;
	}

    /**
     * fieldValues - Load all fieldNames and fieldValues into Array. 
     *
     * @param 
     * 
     */
	public function fieldValues(){
		$fieldValues = array(
			'LabelID' => $this->getLabelID(),
			'Label' => $this->getLabel(),
			'LabelEN' => $this->getLabelEN(),
			'LabelRU' => $this->getLabelRU(),
			'LabelFR' => $this->getLabelFR(),
			'LabelDE' => $this->getLabelDE(),
			'LabelIT' => $this->getLabelIT(),
			'LabelSE' => $this->getLabelSE(),
			'LabelNO' => $this->getLabelNO(),
			'LabelES' => $this->getLabelES(),
			'LabelNL' => $this->getLabelNL()		);
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
			'LabelID',			'Label',			'LabelEN',			'LabelRU',			'LabelFR',			'LabelDE',			'LabelIT',			'LabelSE',			'LabelNO',			'LabelES',			'LabelNL'		);
		return $fieldNames;
	}
    /**
     * Close mysql connection
     */
	public function endv4_Labels(){
		$this->connection->CloseMysql();
	}

}