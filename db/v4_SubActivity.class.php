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

Class v4_SubActivity {

	public $ID; //int(10)
	public $OwnerID; //int(10)
	public $DriverID; //int(11)
	public $Datum; //varchar(10)
	public $Vreme; //varchar(10)
	public $Expense; //varchar(255)
	public $VehicleID; //varchar(255)
	public $Description; //varchar(255)
	public $Note; //varchar(255)	
	public $DocumentImage; //varchar(255)
	public $ActionImage; //varchar(255)	
	public $ListID; //varchar(255)		
	public $Approved; //tinyint(1)
	public $connection;

	public function v4_SubActivity(){
		$this->connection = new DataBaseMysql();
	}	
	public function myreal_escape_string($string){
		return $this->connection->real_escape_string($string);
	}

    /**
     * New object to the class. Don´t forget to save this new object "as new" by using the function $class->saveAsNew(); 
     *
     */
	public function New_v4_SubActivity($ID,$OwnerID,$DriverID,$Datum,$Vreme,$Expense,$VehicleID,$Description,$Note,$DocumentImage,$ActionImage,$ListID,$Approved){
		$this->ID = $ID;
		$this->OwnerID = $OwnerID;
		$this->DriverID = $DriverID;
		$this->Datum = $Datum;
		$this->Vreme = $Vreme;
		$this->Expense = $Expense;
		$this->VehicleID = $VehicleID;
		$this->Description = $Description;
		$this->Note = $Note;
		$this->DocumentImage = $DocumentImage;
		$this->ActionImage = $ActionImage;
		$this->ListID = $ListID;		
		$this->Approved = $Approved;
	}

    /**
     * Load one row into var_class. To use the vars use for exemple echo $class->getVar_name; 
     *
     * @param key_table_type $key_row
     * 
     */
	public function getRow($key_row){
		$result = $this->connection->RunQuery("Select * from v4_SubActivity where ID = \"$key_row\" ");
		if($result->num_rows < 1) return false;
		while($row = $result->fetch_array(MYSQLI_ASSOC)){
			$this->ID = $row["ID"];
			$this->OwnerID = $row["OwnerID"];
			$this->DriverID = $row["DriverID"];
			$this->Datum = $row["Datum"];
			$this->Vreme = $row["Vreme"];			
			$this->Expense = $row["Expense"];
			$this->VehicleID = $row["VehicleID"];			
			$this->Description = $row["Description"];
			$this->Note = $row["Note"];
			$this->DocumentImage = $row["DocumentImage"];
			$this->ActionImage = $row["ActionImage"];
			$this->ListID = $row["ListID"];			
			$this->Approved = $row["Approved"];
		}
	}

    /**
     * Delete the row by using the key as arg
     *
     * @param key_table_type $key_row
     *
     */
	public function deleteRow($key_row){
		$this->connection->RunQuery("DELETE FROM v4_SubActivity WHERE ID = $key_row");
	}

    /**
     * Update the active row table on table
     */
	public function saveRow(){
		$result = $this->connection->RunQuery("UPDATE v4_SubActivity set 
ID = '".$this->myreal_escape_string($this->ID)."', 
OwnerID = '".$this->myreal_escape_string($this->OwnerID)."', 
DriverID = '".$this->myreal_escape_string($this->DriverID)."', 
Datum = '".$this->myreal_escape_string($this->Datum)."', 
Vreme = '".$this->myreal_escape_string($this->Vreme)."', 
Expense = '".$this->myreal_escape_string($this->Expense)."', 
VehicleID = '".$this->myreal_escape_string($this->VehicleID)."', 
Description = '".$this->myreal_escape_string($this->Description)."', 
Note = '".$this->myreal_escape_string($this->Note)."', 
DocumentImage = '".$this->myreal_escape_string($this->DocumentImage)."', 
ActionImage = '".$this->myreal_escape_string($this->ActionImage)."', 
ListID = '".$this->myreal_escape_string($this->ListID)."', 
Approved = '".$this->myreal_escape_string($this->Approved)."' WHERE ID = '".$this->ID."'");
	return $result; 
}

    /**
     * Save the active var class as a new row on table
     */
	public function saveAsNew(){
		$this->connection->RunQuery("INSERT INTO v4_SubActivity 
		(
		ID, 
		OwnerID, 
		DriverID, 
		Datum, 
		Vreme, 
		Expense, 
		VehicleID, 
		Description,
		Note, 
		DocumentImage,
		ActionImage,
		ListID,		
		Approved
		) values ('
		".$this->myreal_escape_string($this->ID)."',
		'".$this->myreal_escape_string($this->OwnerID)."',
		'".$this->myreal_escape_string($this->DriverID)."',
		'".$this->myreal_escape_string($this->Datum)."',
		'".$this->myreal_escape_string($this->Vreme)."',
		'".$this->myreal_escape_string($this->Expense)."',
		'".$this->myreal_escape_string($this->VehicleID)."',		
		'".$this->myreal_escape_string($this->Description)."',
		'".$this->myreal_escape_string($this->Note)."',
		'".$this->myreal_escape_string($this->DocumentImage)."',
		'".$this->myreal_escape_string($this->ActionImage)."',	
		'".$this->myreal_escape_string($this->ListID)."',				
		'".$this->myreal_escape_string($this->Approved)."'
		)");
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
		$result = $this->connection->RunQuery("SELECT ID from v4_SubActivity $where ORDER BY $column $order");
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
	 * @return Vreme - varchar(10)
	 */
	public function getVreme(){
		return $this->Vreme;
	}
	
	/**
	 * @return Expense - varchar(255)
	 */
	public function getExpense(){
		return $this->Expense;
	}

	/**
	 * @return VehicleID - varchar(255)
	 */
	public function getVehicleID(){
		return $this->VehicleID;
	}
	
	/**
	 * @return Description - varchar(255)
	 */
	public function getDescription(){
		return $this->Description;
	}

	/**
	 * @return Note - varchar(255)
	 */
	public function getNote(){
		return $this->Note;
	}

	/**
	 * @return DocumentImage - varchar(255)
	 */
	public function getDocumentImage(){
		return $this->DocumentImage;
	}

	/**
	 * @return ActionImage - varchar(255)
	 */
	public function getActionImage(){
		return $this->ActionImage;
	}

	/**
	 * @return ListID - varchar(255)
	 */
	public function getListID(){
		return $this->ListID;
	}
	
	/**
	 * @return Approved - tinyint(1)
	 */
	public function getApproved(){
		return $this->Approved;
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
	 * @param Type: varchar(10)
	 */
	public function setVreme($Vreme){
		$this->Vreme = $Vreme;
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
	public function setVehicleID($VehicleID){
		$this->VehicleID = $VehicleID;
	}
	
	/**
	 * @param Type: varchar(255)
	 */
	public function setDescription($Description){
		$this->Description = $Description;
	}

	/**
	 * @param Type: varchar(255)
	 */
	public function setNote($Note){
		$this->Note = $Note;
	}

	/**
	 * @param Type: varchar(255)
	 */
	public function setDocumentImage($DocumentImage){
		$this->DocumentImage = $DocumentImage;
	}

	/**
	 * @param Type: varchar(255)
	 */
	public function setActionImage($ActionImage){
		$this->ActionImage = $ActionImage;
	}
	
	/**
	 * @param Type: varchar(255)
	 */
	public function setListID($ListID){
		$this->ListID = $ListID;
	}
	
	/**
	 * @param Type: tinyint(1)
	 */
	public function setApproved($Approved){
		$this->Approved = $Approved;
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
			'Vreme' => $this->getVreme(),
			'Expense' => $this->getExpense(),
			'VehicleID' => $this->getVehicleID(),	
			'Description' => $this->getDescription(),
			'Note' => $this->getNote(),
			'DocumentImage' => $this->getDocumentImage(),
			'ActionImage' => $this->getActionImage(),	
			'ListID' => $this->getListID(),						
			'Approved' => $this->getApproved()		);
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
			'ID',			'OwnerID',			'DriverID',			'Datum',			'Vreme',		'Expense',			'VehicleID',			'Description',			'Note',			'DocumentImage',			'ActionImage',			'ListID',			'Approved'		);
		return $fieldNames;
	}
    /**
     * Close mysql connection
     */
	public function endv4_SubActivity(){
		$this->connection->CloseMysql();
	}

}