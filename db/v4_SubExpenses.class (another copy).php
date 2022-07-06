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

Class v4_SubExpenses {

	public $ID; //int(10)
	public $OwnerID; //int(10)
	public $DriverID; //int(11)
	public $Datum; //varchar(10)
	public $Expense; //varchar(255)
	public $Description; //varchar(255)
	public $Amount; //decimal(10,2)
	public $Card; //int(11)
    public $CurrencyID; //int(11)
    public $Note; //varchar(255)
	public $connection;

	public function v4_SubExpenses(){
		$this->connection = new DataBaseMysql();
	}	public function myreal_escape_string($string){
		return $this->connection->real_escape_string($string);
	}

    /**
     * New object to the class. Don´t forget to save this new object "as new" by using the function $class->saveAsNew(); 
     *
     */
	public function New_v4_SubExpenses($OwnerID,$DriverID,$Datum,$Expense,$Description,$Amount,$Card){
		$this->OwnerID = $OwnerID;
		$this->DriverID = $DriverID;
		$this->Datum = $Datum;
		$this->Expense = $Expense;
		$this->Description = $Description;
		$this->Amount = $Amount;
		$this->Card = $Card;
		$this->CurrencyID = $CurrencyID;
		$this->Note = $Note;
	}

    /**
     * Load one row into var_class. To use the vars use for exemple echo $class->getVar_name; 
     *
     * @param key_table_type $key_row
     * 
     */
	public function getRow($key_row){
		$result = $this->connection->RunQuery("Select * from v4_SubExpenses where ID = \"$key_row\" ");
		if($result->num_rows < 1) return false;
		while($row = $result->fetch_array(MYSQLI_ASSOC)){
			$this->ID = $row["ID"];
			$this->OwnerID = $row["OwnerID"];
			$this->DriverID = $row["DriverID"];
			$this->Datum = $row["Datum"];
			$this->Expense = $row["Expense"];
			$this->Description = $row["Description"];
			$this->Amount = $row["Amount"];
			$this->Card = $row["Card"];
			$this->CurrencyID = $row["CurrencyID"];
			$this->Note = $row["Note"];
		}
	}

    /**
     * Delete the row by using the key as arg
     *
     * @param key_table_type $key_row
     *
     */
	public function deleteRow($key_row){
		$this->connection->RunQuery("DELETE FROM v4_SubExpenses WHERE ID = $key_row");
	}

    /**
     * Update the active row table on table
     */
	public function saveRow(){
		$result = $this->connection->RunQuery("UPDATE v4_SubExpenses set 
OwnerID = '".$this->myreal_escape_string($this->OwnerID)."', 
DriverID = '".$this->myreal_escape_string($this->DriverID)."', 
Datum = '".$this->myreal_escape_string($this->Datum)."', 
Expense = '".$this->myreal_escape_string($this->Expense)."', 
Description = '".$this->myreal_escape_string($this->Description)."', 
Amount = '".$this->myreal_escape_string($this->Amount)."', 
Card = '".$this->myreal_escape_string($this->Card)."', 
CurrencyID = '".$this->myreal_escape_string($this->CurrencyID)."', 
Note = '".$this->myreal_escape_string($this->Note)."' WHERE ID = '".$this->ID."'");
	return $result; 
}

    /**
     * Save the active var class as a new row on table
     */
	public function saveAsNew(){
		$this->connection->RunQuery("INSERT INTO v4_SubExpenses (OwnerID, DriverID, Datum, Expense, Description, Amount, Card, CurrencyID, Note) values ('".$this->myreal_escape_string($this->OwnerID)."', '".$this->myreal_escape_string($this->DriverID)."', '".$this->myreal_escape_string($this->Datum)."', '".$this->myreal_escape_string($this->Expense)."', '".$this->myreal_escape_string($this->Description)."', '".$this->myreal_escape_string($this->Amount)."', '".$this->myreal_escape_string($this->Card)."', '".$this->myreal_escape_string($this->CurrencyID)."', '".$this->myreal_escape_string($this->Note)."')");
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
		$result = $this->connection->RunQuery("SELECT ID from v4_SubExpenses $where ORDER BY $column $order");
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
	 * @return DriverID - int(11)
	 */
	public function getDriverID(){
		return $this->DriverID;
	}

	/**
	 * @return Datum - varchar(10)
	 */
	public function getDatum(){
		return $this->Datum;
	}

	/**
	 * @return Expense - varchar(255)
	 */
	public function getExpense(){
		return $this->Expense;
	}

	/**
	 * @return Description - varchar(255)
	 */
	public function getDescription(){
		return $this->Description;
	}

	/**
	 * @return Amount - decimal(10,2)
	 */
	public function getAmount(){
		return $this->Amount;
	}

	/**
	 * @return Card - int(11)
	 */
	public function getCard(){
		return $this->Card;
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
	 * @param Type: int(11)
	 */
	public function setDriverID($DriverID){
		$this->DriverID = $DriverID;
	}

	/**
	 * @param Type: varchar(10)
	 */
	public function setDatum($Datum){
		$this->Datum = $Datum;
	}

	/**
	 * @param Type: varchar(255)
	 */
	public function setExpense($Expense){
		$this->Expense = $Expense;
	}

	/**
	 * @param Type: varchar(255)
	 */
	public function setDescription($Description){
		$this->Description = $Description;
	}

	/**
	 * @param Type: decimal(10,2)
	 */
	public function setAmount($Amount){
		$this->Amount = $Amount;
	}

	/**
	 * @param Type: int(11)
	 */
	public function setCard($Card){
		$this->Card = $Card;
	}

	/**
	 * @param Type: int(11)
	 */
	public function setCurrencyID($CurrencyID){
		$this->CurrencyID = $CurrencyID;
	}

	/**
	 * @param Type: varchar(255)
	 */
	public function setNote($Note){
		$this->Note = $Note;
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
			'DriverID' => $this->getDriverID(),
			'Datum' => $this->getDatum(),
			'Expense' => $this->getExpense(),
			'Description' => $this->getDescription(),
			'Amount' => $this->getAmount(),
			'Card' => $this->getCard(),
            'CurrencyID' => $this->getCurrencyID(),
            'Note' => $this->getNote()		);
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
			'ID',			'OwnerID',			'DriverID',			'Datum',			'Expense',			'Description',			'Amount',			'Card',			'CurrencyID',			'Note'		);
		return $fieldNames;
	}
    /**
     * Close mysql connection
     */
	public function endv4_SubExpenses(){
		$this->connection->CloseMysql();
	}

}
