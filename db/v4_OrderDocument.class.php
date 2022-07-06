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

Class v4_OrderDocument {

	public $ID; //int(11) unsigned
	public $DocumentType; //tinyint(1)
	public $OrderID; //int(10) unsigned
	public $DetailsID; //int(10) unsigned
	public $UserID; //int(10) unsigned
	public $Icon; //varchar(255)
	public $Action; //varchar(255)
	public $DocumentCode; //varchar(255)
	public $Description; //text
	public $DocumentDate; //date
	public $IssueDate; //time
	public $connection;

	public function v4_OrderDocument(){
		$this->connection = new DataBaseMysql();
	}	public function myreal_escape_string($string){
		return $this->connection->real_escape_string($string);
	}

    /**
     * New object to the class. Don´t forget to save this new object "as new" by using the function $class->saveAsNew(); 
     *
     */
	public function New_v4_OrderDocument($ID,$DocumentType,$OrderID,$DetailsID,$UserID,$Icon,$Action,$DocumentCode,$Description,$DocumentDate,$IssueDate){
		$this->ID = $ID;
		$this->DocumentType = $DocumentType;
		$this->OrderID = $OrderID;
		$this->DetailsID = $DetailsID;
		$this->UserID = $UserID;
		$this->Icon = $Icon;
		$this->Action = $Action;
		$this->DocumentCode = $DocumentCode;
		$this->Description = $Description;
		$this->DocumentDate = $DocumentDate;
		$this->IssueDate = $IssueDate;
	}

    /**
     * Load one row into var_class. To use the vars use for exemple echo $class->getVar_name; 
     *
     * @param key_table_type $key_row
     * 
     */
	public function getRow($key_row){
		$result = $this->connection->RunQuery("Select * from v4_OrderDocument where ID = \"$key_row\" ");
		if($result->num_rows < 1) return false;
		while($row = $result->fetch_array(MYSQLI_ASSOC)){
			$this->ID = $row["ID"];
			$this->DocumentType = $row["DocumentType"];
			$this->OrderID = $row["OrderID"];
			$this->DetailsID = $row["DetailsID"];
			$this->UserID = $row["UserID"];
			$this->Icon = $row["Icon"];
			$this->Action = $row["Action"];
			$this->DocumentCode = $row["DocumentCode"];
			$this->Description = $row["Description"];
			$this->DocumentDate = $row["DocumentDate"];
			$this->IssueDate = $row["IssueDate"];
		}
	}

    /**
     * Delete the row by using the key as arg
     *
     * @param key_table_type $key_row
     *
     */
	public function deleteRow($key_row){
		$this->connection->RunQuery("DELETE FROM v4_OrderDocument WHERE ID = $key_row");
	}

    /**
     * Update the active row table on table
     */
	public function saveRow(){
		$result = $this->connection->RunQuery("UPDATE v4_OrderDocument set 
ID = '".$this->myreal_escape_string($this->ID)."', 
DocumentType = '".$this->myreal_escape_string($this->DocumentType)."', 
OrderID = '".$this->myreal_escape_string($this->OrderID)."', 
DetailsID = '".$this->myreal_escape_string($this->DetailsID)."', 
UserID = '".$this->myreal_escape_string($this->UserID)."', 
Icon = '".$this->myreal_escape_string($this->Icon)."', 
Action = '".$this->myreal_escape_string($this->Action)."', 
DocumentCode = '".$this->myreal_escape_string($this->DocumentCode)."', 
Description = '".$this->myreal_escape_string($this->Description)."', 
DocumentDate = '".$this->myreal_escape_string($this->DocumentDate)."', 
IssueDate = '".$this->myreal_escape_string($this->IssueDate)."' WHERE ID = '".$this->ID."'");
	return $result; 
}

    /**
     * Save the active var class as a new row on table
     */
	public function saveAsNew(){
		
		$this->connection->RunQuery("INSERT INTO v4_OrderDocument (ID, DocumentType, OrderID, DetailsID, UserID, Icon, Action, DocumentCode, Description, DocumentDate, IssueDate) values ('".$this->myreal_escape_string($this->ID)."', '".$this->myreal_escape_string($this->DocumentType)."', '".$this->myreal_escape_string($this->OrderID)."', '".$this->myreal_escape_string($this->DetailsID)."', '".$this->myreal_escape_string($this->UserID)."', '".$this->myreal_escape_string($this->Icon)."', '".$this->myreal_escape_string($this->Action)."', '".$this->myreal_escape_string($this->DocumentCode)."', '".$this->myreal_escape_string($this->Description)."', '".$this->myreal_escape_string($this->DocumentDate)."', '".$this->myreal_escape_string($this->IssueDate)."')");
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
		$result = $this->connection->RunQuery("SELECT ID from v4_OrderDocument $where ORDER BY $column $order ");
			while($row = $result->fetch_array(MYSQLI_ASSOC)){
				$keys[$i] = $row["ID"];
				$i++;
			}
	return $keys;
	}

    /**
     * Returns array of keys order by $column -> name of column $order -> desc or acs
     *
     * @param string $column
     * @param string $order
     */
	public function getKeysByMax($column, $order, $where = NULL, $group = NULL){
		$keys = array(); $i = 0;
		$result = $this->connection->RunQuery("SELECT max(ID) as max from v4_OrderDocument $where $group ORDER BY $column $order ");
			while($row = $result->fetch_array(MYSQLI_ASSOC)){
				$keys[$i] = $row["max"];
				$i++;
			}
	return $keys;
	}
	
	/**
	 * @return ID - int(11) unsigned
	 */
	public function getID(){
		return $this->ID;
	}

	/**
	 * @return DocumentType - tinyint(1)
	 */
	public function getDocumentType(){
		return $this->DocumentType;
	}

	/**
	 * @return OrderID - int(10) unsigned
	 */
	public function getOrderID(){
		return $this->OrderID;
	}

	/**
	 * @return DetailsID - int(10) unsigned
	 */
	public function getDetailsID(){
		return $this->DetailsID;
	}

	/**
	 * @return UserID - int(10) unsigned
	 */
	public function getUserID(){
		return $this->UserID;
	}

	/**
	 * @return Icon - varchar(255)
	 */
	public function getIcon(){
		return $this->Icon;
	}

	/**
	 * @return Action - varchar(255)
	 */
	public function getAction(){
		return $this->Action;
	}

	/**
	 * @return DocumentCode - varchar(255)
	 */
	public function getDocumentCode(){
		return $this->DocumentCode;
	}

	/**
	 * @return Description - text
	 */
	public function getDescription(){
		return $this->Description;
	}

	/**
	 * @return DocumentDate - date
	 */
	public function getDocumentDate(){
		return $this->DocumentDate;
	}

	/**
	 * @return IssueDate - time
	 */
	public function getIssueDate(){
		return $this->IssueDate;
	}

	/**
	 * @param Type: int(11) unsigned
	 */
	public function setID($ID){
		$this->ID = $ID;
	}

	/**
	 * @param Type: tinyint(1)
	 */
	public function setDocumentType($DocumentType){
		$this->DocumentType = $DocumentType;
	}

	/**
	 * @param Type: int(10) unsigned
	 */
	public function setOrderID($OrderID){
		$this->OrderID = $OrderID;
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
	public function setUserID($UserID){
		$this->UserID = $UserID;
	}

	/**
	 * @param Type: varchar(255)
	 */
	public function setIcon($Icon){
		$this->Icon = $Icon;
	}

	/**
	 * @param Type: varchar(255)
	 */
	public function setAction($Action){
		$this->Action = $Action;
	}

	/**
	 * @param Type: varchar(255)
	 */
	public function setDocumentCode($DocumentCode){
		$this->DocumentCode = $DocumentCode;
	}

	/**
	 * @param Type: text
	 */
	public function setDescription($Description){
		$this->Description = $Description;
	}

	/**
	 * @param Type: date
	 */
	public function setDocumentDate($DocumentDate){
		$this->DocumentDate = $DocumentDate;
	}

	/**
	 * @param Type: time
	 */
	public function setIssueDate($IssueDate){
		$this->IssueDate = $IssueDate;
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
			'DocumentType' => $this->getDocumentType(),
			'OrderID' => $this->getOrderID(),
			'DetailsID' => $this->getDetailsID(),
			'UserID' => $this->getUserID(),
			'Icon' => $this->getIcon(),
			'Action' => $this->getAction(),
			'DocumentCode' => $this->getDocumentCode(),
			'Description' => $this->getDescription(),
			'DocumentDate' => $this->getDocumentDate(),
			'IssueDate' => $this->getIssueDate()		);
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
			'ID',			'DocumentType',			'OrderID',			'DetailsID',			'UserID',			'Icon',			'Action',			'DocumentCode',			'Description',			'DocumentDate',			'IssueDate'		);
		return $fieldNames;
	}
    /**
     * Close mysql connection
     */
	public function endv4_OrderDocument(){
		$this->connection->CloseMysql();
	}

}