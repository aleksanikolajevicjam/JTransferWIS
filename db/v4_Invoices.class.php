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

Class v4_Invoices {

	public $ID; //int(10)
	public $UserID; //int(10)
	public $Type; //int(2)
	public $StartDate; //date
	public $EndDate; //date
	public $InvoiceNumber; //varchar(255)
	public $InvoiceDate; //date
	public $DueDate; //date
	public $SumPrice; //decimal(10,2)
	public $SumSubtotal; //decimal(10,2)
	public $CommPrice; //decimal(10,2)
	public $CommSubtotal; //decimal(10,2)
	public $TotalPriceEUR; //decimal(10,2)
	public $TotalSubTotalEUR; //decimal(10,2)
	public $VATNotApp; //decimal(10,2)
	public $VATBaseTotal; //decimal(10,2)
	public $VATtotal; //decimal(10,2)
	public $GrandTotal; //decimal(10,2)
	public $CreatedBy; //int(10)
	public $CreatedDate; //date
	public $Note; //text
	public $PaymentDate; //date
	public $PaymentAmtEUR; //decimal(10,2)
	public $Status; //tinyint(4)
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
	public function New_v4_Invoices($UserID,$Type,$StartDate,$EndDate,$InvoiceNumber,$InvoiceDate,$DueDate,$SumPrice,$SumSubtotal,$CommPrice,$CommSubtotal,$TotalPriceEUR,$TotalSubTotalEUR,$VATNotApp,$VATBaseTotal,$VATtotal,$GrandTotal,$CreatedBy,$CreatedDate,$Note,$PaymentDate,$PaymentAmtEUR,$Status){
		$this->UserID = $UserID;
		$this->Type = $Type;
		$this->StartDate = $StartDate;
		$this->EndDate = $EndDate;
		$this->InvoiceNumber = $InvoiceNumber;
		$this->InvoiceDate = $InvoiceDate;
		$this->DueDate = $DueDate;
		$this->SumPrice = $SumPrice;
		$this->SumSubtotal = $SumSubtotal;
		$this->CommPrice = $CommPrice;
		$this->CommSubtotal = $CommSubtotal;
		$this->TotalPriceEUR = $TotalPriceEUR;
		$this->TotalSubTotalEUR = $TotalSubTotalEUR;
		$this->VATNotApp = $VATNotApp;
		$this->VATBaseTotal = $VATBaseTotal;
		$this->VATtotal = $VATtotal;
		$this->GrandTotal = $GrandTotal;
		$this->CreatedBy = $CreatedBy;
		$this->CreatedDate = $CreatedDate;
		$this->Note = $Note;
		$this->PaymentDate = $PaymentDate;
		$this->PaymentAmtEUR = $PaymentAmtEUR;
		$this->Status = $Status;
	}

    /**
     * Load one row into var_class. To use the vars use for exemple echo $class->getVar_name; 
     *
     * @param key_table_type $key_row
     * 
     */
	public function getRow($key_row){
		$result = $this->connection->RunQuery("Select * from v4_Invoices where ID = \"$key_row\" ");
		if($result->num_rows < 1) return false;
		while($row = $result->fetch_array(MYSQLI_ASSOC)){
			$this->ID = $row["ID"];
			$this->UserID = $row["UserID"];
			$this->Type = $row["Type"];
			$this->StartDate = $row["StartDate"];
			$this->EndDate = $row["EndDate"];
			$this->InvoiceNumber = $row["InvoiceNumber"];
			$this->InvoiceDate = $row["InvoiceDate"];
			$this->DueDate = $row["DueDate"];
			$this->SumPrice = $row["SumPrice"];
			$this->SumSubtotal = $row["SumSubtotal"];
			$this->CommPrice = $row["CommPrice"];
			$this->CommSubtotal = $row["CommSubtotal"];
			$this->TotalPriceEUR = $row["TotalPriceEUR"];
			$this->TotalSubTotalEUR = $row["TotalSubTotalEUR"];
			$this->VATNotApp = $row["VATNotApp"];
			$this->VATBaseTotal = $row["VATBaseTotal"];
			$this->VATtotal = $row["VATtotal"];
			$this->GrandTotal = $row["GrandTotal"];
			$this->CreatedBy = $row["CreatedBy"];
			$this->CreatedDate = $row["CreatedDate"];
			$this->Note = $row["Note"];
			$this->PaymentDate = $row["PaymentDate"];
			$this->PaymentAmtEUR = $row["PaymentAmtEUR"];
			$this->Status = $row["Status"];
		}
	}

    /**
     * Delete the row by using the key as arg
     *
     * @param key_table_type $key_row
     *
     */
	public function deleteRow($key_row){
		$this->connection->RunQuery("DELETE FROM v4_Invoices WHERE ID = $key_row");
	}

    /**
     * Update the active row table on table
     */
	public function saveRow(){
		$result = $this->connection->RunQuery("UPDATE v4_Invoices set 
UserID = '".$this->myreal_escape_string($this->UserID)."', 
Type = '".$this->myreal_escape_string($this->Type)."', 
StartDate = '".$this->myreal_escape_string($this->StartDate)."', 
EndDate = '".$this->myreal_escape_string($this->EndDate)."', 
InvoiceNumber = '".$this->myreal_escape_string($this->InvoiceNumber)."', 
InvoiceDate = '".$this->myreal_escape_string($this->InvoiceDate)."', 
DueDate = '".$this->myreal_escape_string($this->DueDate)."', 
SumPrice = '".$this->myreal_escape_string($this->SumPrice)."', 
SumSubtotal = '".$this->myreal_escape_string($this->SumSubtotal)."', 
CommPrice = '".$this->myreal_escape_string($this->CommPrice)."', 
CommSubtotal = '".$this->myreal_escape_string($this->CommSubtotal)."', 
TotalPriceEUR = '".$this->myreal_escape_string($this->TotalPriceEUR)."', 
TotalSubTotalEUR = '".$this->myreal_escape_string($this->TotalSubTotalEUR)."', 
VATNotApp = '".$this->myreal_escape_string($this->VATNotApp)."', 
VATBaseTotal = '".$this->myreal_escape_string($this->VATBaseTotal)."', 
VATtotal = '".$this->myreal_escape_string($this->VATtotal)."', 
GrandTotal = '".$this->myreal_escape_string($this->GrandTotal)."', 
CreatedBy = '".$this->myreal_escape_string($this->CreatedBy)."', 
CreatedDate = '".$this->myreal_escape_string($this->CreatedDate)."', 
Note = '".$this->myreal_escape_string($this->Note)."', 
PaymentDate = '".$this->myreal_escape_string($this->PaymentDate)."', 
PaymentAmtEUR = '".$this->myreal_escape_string($this->PaymentAmtEUR)."', 
Status = '".$this->myreal_escape_string($this->Status)."' WHERE ID = '".$this->ID."'");
	return $result; 
}

    /**
     * Save the active var class as a new row on table
     */
	public function saveAsNew(){
		$this->connection->RunQuery("INSERT INTO v4_Invoices (UserID, Type, StartDate, EndDate, InvoiceNumber, InvoiceDate, DueDate, SumPrice, SumSubtotal, CommPrice, CommSubtotal, TotalPriceEUR, TotalSubTotalEUR, VATNotApp, VATBaseTotal, VATtotal, GrandTotal, CreatedBy, CreatedDate, Note, PaymentDate, PaymentAmtEUR, Status) values ('".$this->myreal_escape_string($this->UserID)."', '".$this->myreal_escape_string($this->Type)."', '".$this->myreal_escape_string($this->StartDate)."', '".$this->myreal_escape_string($this->EndDate)."', '".$this->myreal_escape_string($this->InvoiceNumber)."', '".$this->myreal_escape_string($this->InvoiceDate)."', '".$this->myreal_escape_string($this->DueDate)."', '".$this->myreal_escape_string($this->SumPrice)."', '".$this->myreal_escape_string($this->SumSubtotal)."', '".$this->myreal_escape_string($this->CommPrice)."', '".$this->myreal_escape_string($this->CommSubtotal)."', '".$this->myreal_escape_string($this->TotalPriceEUR)."', '".$this->myreal_escape_string($this->TotalSubTotalEUR)."', '".$this->myreal_escape_string($this->VATNotApp)."', '".$this->myreal_escape_string($this->VATBaseTotal)."', '".$this->myreal_escape_string($this->VATtotal)."', '".$this->myreal_escape_string($this->GrandTotal)."', '".$this->myreal_escape_string($this->CreatedBy)."', '".$this->myreal_escape_string($this->CreatedDate)."', '".$this->myreal_escape_string($this->Note)."', '".$this->myreal_escape_string($this->PaymentDate)."', '".$this->myreal_escape_string($this->PaymentAmtEUR)."', '".$this->myreal_escape_string($this->Status)."')");
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
		$result = $this->connection->RunQuery("SELECT ID from v4_Invoices $where ORDER BY $column $order");
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
	 * @return UserID - int(10)
	 */
	public function getUserID(){
		return $this->UserID;
	}

	/**
	 * @return Type - int(2)
	 */
	public function getType(){
		return $this->Type;
	}

	/**
	 * @return StartDate - date
	 */
	public function getStartDate(){
		return $this->StartDate;
	}

	/**
	 * @return EndDate - date
	 */
	public function getEndDate(){
		return $this->EndDate;
	}

	/**
	 * @return InvoiceNumber - varchar(255)
	 */
	public function getInvoiceNumber(){
		return $this->InvoiceNumber;
	}

	/**
	 * @return InvoiceDate - date
	 */
	public function getInvoiceDate(){
		return $this->InvoiceDate;
	}

	/**
	 * @return DueDate - date
	 */
	public function getDueDate(){
		return $this->DueDate;
	}

	/**
	 * @return SumPrice - decimal(10,2)
	 */
	public function getSumPrice(){
		return $this->SumPrice;
	}

	/**
	 * @return SumSubtotal - decimal(10,2)
	 */
	public function getSumSubtotal(){
		return $this->SumSubtotal;
	}

	/**
	 * @return CommPrice - decimal(10,2)
	 */
	public function getCommPrice(){
		return $this->CommPrice;
	}

	/**
	 * @return CommSubtotal - decimal(10,2)
	 */
	public function getCommSubtotal(){
		return $this->CommSubtotal;
	}

	/**
	 * @return TotalPriceEUR - decimal(10,2)
	 */
	public function getTotalPriceEUR(){
		return $this->TotalPriceEUR;
	}

	/**
	 * @return TotalSubTotalEUR - decimal(10,2)
	 */
	public function getTotalSubTotalEUR(){
		return $this->TotalSubTotalEUR;
	}

	/**
	 * @return VATNotApp - decimal(10,2)
	 */
	public function getVATNotApp(){
		return $this->VATNotApp;
	}

	/**
	 * @return VATBaseTotal - decimal(10,2)
	 */
	public function getVATBaseTotal(){
		return $this->VATBaseTotal;
	}

	/**
	 * @return VATtotal - decimal(10,2)
	 */
	public function getVATtotal(){
		return $this->VATtotal;
	}

	/**
	 * @return GrandTotal - decimal(10,2)
	 */
	public function getGrandTotal(){
		return $this->GrandTotal;
	}

	/**
	 * @return CreatedBy - int(10)
	 */
	public function getCreatedBy(){
		return $this->CreatedBy;
	}

	/**
	 * @return CreatedDate - date
	 */
	public function getCreatedDate(){
		return $this->CreatedDate;
	}

	/**
	 * @return Note - text
	 */
	public function getNote(){
		return $this->Note;
	}

	/**
	 * @return PaymentDate - date
	 */
	public function getPaymentDate(){
		return $this->PaymentDate;
	}

	/**
	 * @return PaymentAmtEUR - decimal(10,2)
	 */
	public function getPaymentAmtEUR(){
		return $this->PaymentAmtEUR;
	}

	/**
	 * @return Status - tinyint(4)
	 */
	public function getStatus(){
		return $this->Status;
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
	public function setUserID($UserID){
		$this->UserID = $UserID;
	}

	/**
	 * @param Type: int(2)
	 */
	public function setType($Type){
		$this->Type = $Type;
	}

	/**
	 * @param Type: date
	 */
	public function setStartDate($StartDate){
		$this->StartDate = $StartDate;
	}

	/**
	 * @param Type: date
	 */
	public function setEndDate($EndDate){
		$this->EndDate = $EndDate;
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
	public function setInvoiceDate($InvoiceDate){
		$this->InvoiceDate = $InvoiceDate;
	}

	/**
	 * @param Type: date
	 */
	public function setDueDate($DueDate){
		$this->DueDate = $DueDate;
	}

	/**
	 * @param Type: decimal(10,2)
	 */
	public function setSumPrice($SumPrice){
		$this->SumPrice = $SumPrice;
	}

	/**
	 * @param Type: decimal(10,2)
	 */
	public function setSumSubtotal($SumSubtotal){
		$this->SumSubtotal = $SumSubtotal;
	}

	/**
	 * @param Type: decimal(10,2)
	 */
	public function setCommPrice($CommPrice){
		$this->CommPrice = $CommPrice;
	}

	/**
	 * @param Type: decimal(10,2)
	 */
	public function setCommSubtotal($CommSubtotal){
		$this->CommSubtotal = $CommSubtotal;
	}

	/**
	 * @param Type: decimal(10,2)
	 */
	public function setTotalPriceEUR($TotalPriceEUR){
		$this->TotalPriceEUR = $TotalPriceEUR;
	}

	/**
	 * @param Type: decimal(10,2)
	 */
	public function setTotalSubTotalEUR($TotalSubTotalEUR){
		$this->TotalSubTotalEUR = $TotalSubTotalEUR;
	}

	/**
	 * @param Type: decimal(10,2)
	 */
	public function setVATNotApp($VATNotApp){
		$this->VATNotApp = $VATNotApp;
	}

	/**
	 * @param Type: decimal(10,2)
	 */
	public function setVATBaseTotal($VATBaseTotal){
		$this->VATBaseTotal = $VATBaseTotal;
	}

	/**
	 * @param Type: decimal(10,2)
	 */
	public function setVATtotal($VATtotal){
		$this->VATtotal = $VATtotal;
	}

	/**
	 * @param Type: decimal(10,2)
	 */
	public function setGrandTotal($GrandTotal){
		$this->GrandTotal = $GrandTotal;
	}

	/**
	 * @param Type: int(10)
	 */
	public function setCreatedBy($CreatedBy){
		$this->CreatedBy = $CreatedBy;
	}

	/**
	 * @param Type: date
	 */
	public function setCreatedDate($CreatedDate){
		$this->CreatedDate = $CreatedDate;
	}

	/**
	 * @param Type: text
	 */
	public function setNote($Note){
		$this->Note = $Note;
	}

	/**
	 * @param Type: date
	 */
	public function setPaymentDate($PaymentDate){
		$this->PaymentDate = $PaymentDate;
	}

	/**
	 * @param Type: decimal(10,2)
	 */
	public function setPaymentAmtEUR($PaymentAmtEUR){
		$this->PaymentAmtEUR = $PaymentAmtEUR;
	}

	/**
	 * @param Type: tinyint(4)
	 */
	public function setStatus($Status){
		$this->Status = $Status;
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
			'UserID' => $this->getUserID(),
			'Type' => $this->getType(),
			'StartDate' => $this->getStartDate(),
			'EndDate' => $this->getEndDate(),
			'InvoiceNumber' => $this->getInvoiceNumber(),
			'InvoiceDate' => $this->getInvoiceDate(),
			'DueDate' => $this->getDueDate(),
			'SumPrice' => $this->getSumPrice(),
			'SumSubtotal' => $this->getSumSubtotal(),
			'CommPrice' => $this->getCommPrice(),
			'CommSubtotal' => $this->getCommSubtotal(),
			'TotalPriceEUR' => $this->getTotalPriceEUR(),
			'TotalSubTotalEUR' => $this->getTotalSubTotalEUR(),
			'VATNotApp' => $this->getVATNotApp(),
			'VATBaseTotal' => $this->getVATBaseTotal(),
			'VATtotal' => $this->getVATtotal(),
			'GrandTotal' => $this->getGrandTotal(),
			'CreatedBy' => $this->getCreatedBy(),
			'CreatedDate' => $this->getCreatedDate(),
			'Note' => $this->getNote(),
			'PaymentDate' => $this->getPaymentDate(),
			'PaymentAmtEUR' => $this->getPaymentAmtEUR(),
			'Status' => $this->getStatus()		);
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
			'ID',			'UserID',			'Type',			'StartDate',			'EndDate',			'InvoiceNumber',			'InvoiceDate',			'DueDate',			'SumPrice',			'SumSubtotal',			'CommPrice',			'CommSubtotal',			'TotalPriceEUR',			'TotalSubTotalEUR',			'VATNotApp',			'VATBaseTotal',			'VATtotal',			'GrandTotal',			'CreatedBy',			'CreatedDate',			'Note',			'PaymentDate',			'PaymentAmtEUR',			'Status'		);
		return $fieldNames;
	}
    /**
     * Close mysql connection
     */
	public function endv4_Invoices(){
		$this->connection->CloseMysql();
	}

}