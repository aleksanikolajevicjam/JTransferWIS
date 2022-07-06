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

Class v4_InvoicesMaster {

	public $ID; //int(10)
	public $InvoiceNumber; //varchar(255)
	public $DateCreated; //date
	public $DueDate; //date
	public $PartnerID; //int(10)
	public $Instructions; //text
	public $Subtotal; //decimal(10,2)
	public $TaxPercent; //decimal(10,2)
	public $TaxAmount; //decimal(10,2)
	public $Total; //decimal(10,2)
	public $Currency; //varchar(4)
	public $EURToCurrency; //decimal(10,2)
	public $SubtotalEUR; //decimal(10,2)
	public $TaxAmountEUR; //decimal(10,2)
	public $TotalEUR; //decimal(10,2)
	public $Status; //int(3)
	public $CreatorID; //int(10)
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
	public function New_v4_InvoicesMaster($InvoiceNumber,$DateCreated,$DueDate,$PartnerID,$Instructions,$Subtotal,$TaxPercent,$TaxAmount,$Total,$Currency,$EURToCurrency,$SubtotalEUR,$TaxAmountEUR,$TotalEUR,$Status,$CreatorID){
		$this->InvoiceNumber = $InvoiceNumber;
		$this->DateCreated = $DateCreated;
		$this->DueDate = $DueDate;
		$this->PartnerID = $PartnerID;
		$this->Instructions = $Instructions;
		$this->Subtotal = $Subtotal;
		$this->TaxPercent = $TaxPercent;
		$this->TaxAmount = $TaxAmount;
		$this->Total = $Total;
		$this->Currency = $Currency;
		$this->EURToCurrency = $EURToCurrency;
		$this->SubtotalEUR = $SubtotalEUR;
		$this->TaxAmountEUR = $TaxAmountEUR;
		$this->TotalEUR = $TotalEUR;
		$this->Status = $Status;
		$this->CreatorID = $CreatorID;
	}

    /**
     * Load one row into var_class. To use the vars use for exemple echo $class->getVar_name; 
     *
     * @param key_table_type $key_row
     * 
     */
	public function getRow($key_row){
		$result = $this->connection->RunQuery("Select * from v4_InvoicesMaster where ID = \"$key_row\" ");
		if($result->num_rows < 1) return false;
		while($row = $result->fetch_array(MYSQLI_ASSOC)){
			$this->ID = $row["ID"];
			$this->InvoiceNumber = $row["InvoiceNumber"];
			$this->DateCreated = $row["DateCreated"];
			$this->DueDate = $row["DueDate"];
			$this->PartnerID = $row["PartnerID"];
			$this->Instructions = $row["Instructions"];
			$this->Subtotal = $row["Subtotal"];
			$this->TaxPercent = $row["TaxPercent"];
			$this->TaxAmount = $row["TaxAmount"];
			$this->Total = $row["Total"];
			$this->Currency = $row["Currency"];
			$this->EURToCurrency = $row["EURToCurrency"];
			$this->SubtotalEUR = $row["SubtotalEUR"];
			$this->TaxAmountEUR = $row["TaxAmountEUR"];
			$this->TotalEUR = $row["TotalEUR"];
			$this->Status = $row["Status"];
			$this->CreatorID = $row["CreatorID"];
		}
	}

    /**
     * Delete the row by using the key as arg
     *
     * @param key_table_type $key_row
     *
     */
	public function deleteRow($key_row){
		$this->connection->RunQuery("DELETE FROM v4_InvoicesMaster WHERE ID = $key_row");
	}

    /**
     * Update the active row table on table
     */
	public function saveRow(){
		$result = $this->connection->RunQuery("UPDATE v4_InvoicesMaster set 
InvoiceNumber = '".$this->myreal_escape_string($this->InvoiceNumber)."', 
DateCreated = '".$this->myreal_escape_string($this->DateCreated)."', 
DueDate = '".$this->myreal_escape_string($this->DueDate)."', 
PartnerID = '".$this->myreal_escape_string($this->PartnerID)."', 
Instructions = '".$this->myreal_escape_string($this->Instructions)."', 
Subtotal = '".$this->myreal_escape_string($this->Subtotal)."', 
TaxPercent = '".$this->myreal_escape_string($this->TaxPercent)."', 
TaxAmount = '".$this->myreal_escape_string($this->TaxAmount)."', 
Total = '".$this->myreal_escape_string($this->Total)."', 
Currency = '".$this->myreal_escape_string($this->Currency)."', 
EURToCurrency = '".$this->myreal_escape_string($this->EURToCurrency)."', 
SubtotalEUR = '".$this->myreal_escape_string($this->SubtotalEUR)."', 
TaxAmountEUR = '".$this->myreal_escape_string($this->TaxAmountEUR)."', 
TotalEUR = '".$this->myreal_escape_string($this->TotalEUR)."', 
Status = '".$this->myreal_escape_string($this->Status)."', 
CreatorID = '".$this->myreal_escape_string($this->CreatorID)."' WHERE ID = '".$this->ID."'");
	return $result; 
}

    /**
     * Save the active var class as a new row on table
     */
	public function saveAsNew(){
		$this->connection->RunQuery("INSERT INTO v4_InvoicesMaster (InvoiceNumber, DateCreated, DueDate, PartnerID, Instructions, Subtotal, TaxPercent, TaxAmount, Total, Currency, EURToCurrency, SubtotalEUR, TaxAmountEUR, TotalEUR, Status, CreatorID) values ('".$this->myreal_escape_string($this->InvoiceNumber)."', '".$this->myreal_escape_string($this->DateCreated)."', '".$this->myreal_escape_string($this->DueDate)."', '".$this->myreal_escape_string($this->PartnerID)."', '".$this->myreal_escape_string($this->Instructions)."', '".$this->myreal_escape_string($this->Subtotal)."', '".$this->myreal_escape_string($this->TaxPercent)."', '".$this->myreal_escape_string($this->TaxAmount)."', '".$this->myreal_escape_string($this->Total)."', '".$this->myreal_escape_string($this->Currency)."', '".$this->myreal_escape_string($this->EURToCurrency)."', '".$this->myreal_escape_string($this->SubtotalEUR)."', '".$this->myreal_escape_string($this->TaxAmountEUR)."', '".$this->myreal_escape_string($this->TotalEUR)."', '".$this->myreal_escape_string($this->Status)."', '".$this->myreal_escape_string($this->CreatorID)."')");
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
		$result = $this->connection->RunQuery("SELECT ID from v4_InvoicesMaster $where ORDER BY $column $order");
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
	 * @return InvoiceNumber - varchar(255)
	 */
	public function getInvoiceNumber(){
		return $this->InvoiceNumber;
	}

	/**
	 * @return DateCreated - date
	 */
	public function getDateCreated(){
		return $this->DateCreated;
	}

	/**
	 * @return DueDate - date
	 */
	public function getDueDate(){
		return $this->DueDate;
	}

	/**
	 * @return PartnerID - int(10)
	 */
	public function getPartnerID(){
		return $this->PartnerID;
	}

	/**
	 * @return Instructions - text
	 */
	public function getInstructions(){
		return $this->Instructions;
	}

	/**
	 * @return Subtotal - decimal(10,2)
	 */
	public function getSubtotal(){
		return $this->Subtotal;
	}

	/**
	 * @return TaxPercent - decimal(10,2)
	 */
	public function getTaxPercent(){
		return $this->TaxPercent;
	}

	/**
	 * @return TaxAmount - decimal(10,2)
	 */
	public function getTaxAmount(){
		return $this->TaxAmount;
	}

	/**
	 * @return Total - decimal(10,2)
	 */
	public function getTotal(){
		return $this->Total;
	}

	/**
	 * @return Currency - varchar(4)
	 */
	public function getCurrency(){
		return $this->Currency;
	}

	/**
	 * @return EURToCurrency - decimal(10,2)
	 */
	public function getEURToCurrency(){
		return $this->EURToCurrency;
	}

	/**
	 * @return SubtotalEUR - decimal(10,2)
	 */
	public function getSubtotalEUR(){
		return $this->SubtotalEUR;
	}

	/**
	 * @return TaxAmountEUR - decimal(10,2)
	 */
	public function getTaxAmountEUR(){
		return $this->TaxAmountEUR;
	}

	/**
	 * @return TotalEUR - decimal(10,2)
	 */
	public function getTotalEUR(){
		return $this->TotalEUR;
	}

	/**
	 * @return Status - int(3)
	 */
	public function getStatus(){
		return $this->Status;
	}

	/**
	 * @return CreatorID - int(10)
	 */
	public function getCreatorID(){
		return $this->CreatorID;
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
	public function setInvoiceNumber($InvoiceNumber){
		$this->InvoiceNumber = $InvoiceNumber;
	}

	/**
	 * @param Type: date
	 */
	public function setDateCreated($DateCreated){
		$this->DateCreated = $DateCreated;
	}

	/**
	 * @param Type: date
	 */
	public function setDueDate($DueDate){
		$this->DueDate = $DueDate;
	}

	/**
	 * @param Type: int(10)
	 */
	public function setPartnerID($PartnerID){
		$this->PartnerID = $PartnerID;
	}

	/**
	 * @param Type: text
	 */
	public function setInstructions($Instructions){
		$this->Instructions = $Instructions;
	}

	/**
	 * @param Type: decimal(10,2)
	 */
	public function setSubtotal($Subtotal){
		$this->Subtotal = $Subtotal;
	}

	/**
	 * @param Type: decimal(10,2)
	 */
	public function setTaxPercent($TaxPercent){
		$this->TaxPercent = $TaxPercent;
	}

	/**
	 * @param Type: decimal(10,2)
	 */
	public function setTaxAmount($TaxAmount){
		$this->TaxAmount = $TaxAmount;
	}

	/**
	 * @param Type: decimal(10,2)
	 */
	public function setTotal($Total){
		$this->Total = $Total;
	}

	/**
	 * @param Type: varchar(4)
	 */
	public function setCurrency($Currency){
		$this->Currency = $Currency;
	}

	/**
	 * @param Type: decimal(10,2)
	 */
	public function setEURToCurrency($EURToCurrency){
		$this->EURToCurrency = $EURToCurrency;
	}

	/**
	 * @param Type: decimal(10,2)
	 */
	public function setSubtotalEUR($SubtotalEUR){
		$this->SubtotalEUR = $SubtotalEUR;
	}

	/**
	 * @param Type: decimal(10,2)
	 */
	public function setTaxAmountEUR($TaxAmountEUR){
		$this->TaxAmountEUR = $TaxAmountEUR;
	}

	/**
	 * @param Type: decimal(10,2)
	 */
	public function setTotalEUR($TotalEUR){
		$this->TotalEUR = $TotalEUR;
	}

	/**
	 * @param Type: int(3)
	 */
	public function setStatus($Status){
		$this->Status = $Status;
	}

	/**
	 * @param Type: int(10)
	 */
	public function setCreatorID($CreatorID){
		$this->CreatorID = $CreatorID;
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
			'InvoiceNumber' => $this->getInvoiceNumber(),
			'DateCreated' => $this->getDateCreated(),
			'DueDate' => $this->getDueDate(),
			'PartnerID' => $this->getPartnerID(),
			'Instructions' => $this->getInstructions(),
			'Subtotal' => $this->getSubtotal(),
			'TaxPercent' => $this->getTaxPercent(),
			'TaxAmount' => $this->getTaxAmount(),
			'Total' => $this->getTotal(),
			'Currency' => $this->getCurrency(),
			'EURToCurrency' => $this->getEURToCurrency(),
			'SubtotalEUR' => $this->getSubtotalEUR(),
			'TaxAmountEUR' => $this->getTaxAmountEUR(),
			'TotalEUR' => $this->getTotalEUR(),
			'Status' => $this->getStatus(),
			'CreatorID' => $this->getCreatorID()		);
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
			'ID',			'InvoiceNumber',			'DateCreated',			'DueDate',			'PartnerID',			'Instructions',			'Subtotal',			'TaxPercent',			'TaxAmount',			'Total',			'Currency',			'EURToCurrency',			'SubtotalEUR',			'TaxAmountEUR',			'TotalEUR',			'Status',			'CreatorID'		);
		return $fieldNames;
	}
    /**
     * Close mysql connection
     */
	public function endv4_InvoicesMaster(){
		$this->connection->CloseMysql();
	}

}