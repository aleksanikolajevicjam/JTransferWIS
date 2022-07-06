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

Class v4_InvoiceDetails {

	public $ID; //int(11)
	public $DetailsID; //int(10)
	public $InvoiceNumber; //varchar(255)
	public $Description; //text
	public $Qty; //int(5)
	public $Price; //decimal(10,2)
	public $SubTotal; //decimal(10,2)
	public $Changed; //timestamp
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
	public function New_v4_InvoiceDetails($DetailsID,$InvoiceNumber,$Description,$Qty,$Price,$SubTotal,$Changed){
		$this->DetailsID = $DetailsID;
		$this->InvoiceNumber = $InvoiceNumber;
		$this->Description = $Description;
		$this->Qty = $Qty;
		$this->Price = $Price;
		$this->SubTotal = $SubTotal;
		$this->Changed = $Changed;
	}

    /**
     * Load one row into var_class. To use the vars use for exemple echo $class->getVar_name; 
     *
     * @param key_table_type $key_row
     * 
     */
	public function getRow($key_row){
		$result = $this->connection->RunQuery("Select * from v4_InvoiceDetails where ID = \"$key_row\" ");
		if($result->num_rows < 1) return false;
		while($row = $result->fetch_array(MYSQLI_ASSOC)){
			$this->ID = $row["ID"];
			$this->DetailsID = $row["DetailsID"];
			$this->InvoiceNumber = $row["InvoiceNumber"];
			$this->Description = $row["Description"];
			$this->Qty = $row["Qty"];
			$this->Price = $row["Price"];
			$this->SubTotal = $row["SubTotal"];
			$this->Changed = $row["Changed"];
		}
	}

    /**
     * Delete the row by using the key as arg
     *
     * @param key_table_type $key_row
     *
     */
	public function deleteRow($key_row){
		$this->connection->RunQuery("DELETE FROM v4_InvoiceDetails WHERE ID = $key_row");
	}

    /**
     * Update the active row table on table
     */
	public function saveRow(){
		$result = $this->connection->RunQuery("UPDATE v4_InvoiceDetails set 
DetailsID = '".$this->myreal_escape_string($this->DetailsID)."', 
InvoiceNumber = '".$this->myreal_escape_string($this->InvoiceNumber)."', 
Description = '".$this->myreal_escape_string($this->Description)."', 
Qty = '".$this->myreal_escape_string($this->Qty)."', 
Price = '".$this->myreal_escape_string($this->Price)."', 
SubTotal = '".$this->myreal_escape_string($this->SubTotal)."', 
Changed = '".$this->myreal_escape_string($this->Changed)."' WHERE ID = '".$this->ID."'");
	return $result; 
}

    /**
     * Save the active var class as a new row on table
     */
	public function saveAsNew(){
		$this->connection->RunQuery("INSERT INTO v4_InvoiceDetails (DetailsID, InvoiceNumber, Description, Qty, Price, SubTotal, Changed) values ('".$this->myreal_escape_string($this->DetailsID)."', '".$this->myreal_escape_string($this->InvoiceNumber)."', '".$this->myreal_escape_string($this->Description)."', '".$this->myreal_escape_string($this->Qty)."', '".$this->myreal_escape_string($this->Price)."', '".$this->myreal_escape_string($this->SubTotal)."', '".$this->myreal_escape_string($this->Changed)."')");
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
		$result = $this->connection->RunQuery("SELECT ID from v4_InvoiceDetails $where ORDER BY $column $order");
			while($row = $result->fetch_array(MYSQLI_ASSOC)){
				$keys[$i] = $row["ID"];
				$i++;
			}
	return $keys;
	}

	/**
	 * @return ID - int(11)
	 */
	public function getID(){
		return $this->ID;
	}

	/**
	 * @return DetailsID - int(10)
	 */
	public function getDetailsID(){
		return $this->DetailsID;
	}

	/**
	 * @return InvoiceNumber - varchar(255)
	 */
	public function getInvoiceNumber(){
		return $this->InvoiceNumber;
	}

	/**
	 * @return Description - text
	 */
	public function getDescription(){
		return $this->Description;
	}

	/**
	 * @return Qty - int(5)
	 */
	public function getQty(){
		return $this->Qty;
	}

	/**
	 * @return Price - decimal(10,2)
	 */
	public function getPrice(){
		return $this->Price;
	}

	/**
	 * @return SubTotal - decimal(10,2)
	 */
	public function getSubTotal(){
		return $this->SubTotal;
	}

	/**
	 * @return Changed - timestamp
	 */
	public function getChanged(){
		return $this->Changed;
	}

	/**
	 * @param Type: int(11)
	 */
	public function setID($ID){
		$this->ID = $ID;
	}

	/**
	 * @param Type: int(10)
	 */
	public function setDetailsID($DetailsID){
		$this->DetailsID = $DetailsID;
	}

	/**
	 * @param Type: varchar(255)
	 */
	public function setInvoiceNumber($InvoiceNumber){
		$this->InvoiceNumber = $InvoiceNumber;
	}

	/**
	 * @param Type: text
	 */
	public function setDescription($Description){
		$this->Description = $Description;
	}

	/**
	 * @param Type: int(5)
	 */
	public function setQty($Qty){
		$this->Qty = $Qty;
	}

	/**
	 * @param Type: decimal(10,2)
	 */
	public function setPrice($Price){
		$this->Price = $Price;
	}

	/**
	 * @param Type: decimal(10,2)
	 */
	public function setSubTotal($SubTotal){
		$this->SubTotal = $SubTotal;
	}

	/**
	 * @param Type: timestamp
	 */
	public function setChanged($Changed){
		$this->Changed = $Changed;
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
			'DetailsID' => $this->getDetailsID(),
			'InvoiceNumber' => $this->getInvoiceNumber(),
			'Description' => $this->getDescription(),
			'Qty' => $this->getQty(),
			'Price' => $this->getPrice(),
			'SubTotal' => $this->getSubTotal(),
			'Changed' => $this->getChanged()		);
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
			'ID',			'DetailsID',			'InvoiceNumber',			'Description',			'Qty',			'Price',			'SubTotal',			'Changed'		);
		return $fieldNames;
	}
    /**
     * Close mysql connection
     */
	public function endv4_InvoiceDetails(){
		$this->connection->CloseMysql();
	}

}