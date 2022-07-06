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

Class v4_OrderLog {

	public $ID; //int(11) unsigned
	public $ShowToCustomer; //tinyint(1)
	public $OrderID; //int(10) unsigned
	public $DetailsID; //int(10) unsigned
	public $UserID; //int(10) unsigned
	public $Icon; //varchar(255)
	public $Action; //varchar(255)
	public $Title; //varchar(255)
	public $Description; //text
	public $DateAdded; //date
	public $TimeAdded; //time
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
	public function New_v4_OrderLog($ShowToCustomer,$OrderID,$DetailsID,$UserID,$Icon,$Action,$Title,$Description,$DateAdded,$TimeAdded){
		$this->ShowToCustomer = $ShowToCustomer;
		$this->OrderID = $OrderID;
		$this->DetailsID = $DetailsID;
		$this->UserID = $UserID;
		$this->Icon = $Icon;
		$this->Action = $Action;
		$this->Title = $Title;
		$this->Description = $Description;
		$this->DateAdded = $DateAdded;
		$this->TimeAdded = $TimeAdded;
	}

    /**
     * Load one row into var_class. To use the vars use for exemple echo $class->getVar_name; 
     *
     * @param key_table_type $key_row
     * 
     */
	public function getRow($key_row){
		$result = $this->connection->RunQuery("Select * from v4_OrderLog where ID = \"$key_row\" ");
		if($result->num_rows < 1) return false;
		while($row = $result->fetch_array(MYSQLI_ASSOC)){
			$this->ID = $row["ID"];
			$this->ShowToCustomer = $row["ShowToCustomer"];
			$this->OrderID = $row["OrderID"];
			$this->DetailsID = $row["DetailsID"];
			$this->UserID = $row["UserID"];
			$this->Icon = $row["Icon"];
			$this->Action = $row["Action"];
			$this->Title = $row["Title"];
			$this->Description = $row["Description"];
			$this->DateAdded = $row["DateAdded"];
			$this->TimeAdded = $row["TimeAdded"];
		}
	}

    /**
     * Delete the row by using the key as arg
     *
     * @param key_table_type $key_row
     *
     */
	public function deleteRow($key_row){
		$this->connection->RunQuery("DELETE FROM v4_OrderLog WHERE ID = $key_row");
	}

    /**
     * Update the active row table on table
     */
	public function saveRow(){
		$result = $this->connection->RunQuery("UPDATE v4_OrderLog set 
ShowToCustomer = '".$this->myreal_escape_string($this->ShowToCustomer)."', 
OrderID = '".$this->myreal_escape_string($this->OrderID)."', 
DetailsID = '".$this->myreal_escape_string($this->DetailsID)."', 
UserID = '".$this->myreal_escape_string($this->UserID)."', 
Icon = '".$this->myreal_escape_string($this->Icon)."', 
Action = '".$this->myreal_escape_string($this->Action)."', 
Title = '".$this->myreal_escape_string($this->Title)."', 
Description = '".$this->myreal_escape_string($this->Description)."', 
DateAdded = '".$this->myreal_escape_string($this->DateAdded)."', 
TimeAdded = '".$this->myreal_escape_string($this->TimeAdded)."' WHERE ID = '".$this->ID."'");
	return $result; 
}

    /**
     * Save the active var class as a new row on table
     */
	public function saveAsNew(){
		$this->connection->RunQuery("INSERT INTO v4_OrderLog (ShowToCustomer, OrderID, DetailsID, UserID, Icon, Action, Title, Description, DateAdded, TimeAdded) values ('".$this->myreal_escape_string($this->ShowToCustomer)."', '".$this->myreal_escape_string($this->OrderID)."', '".$this->myreal_escape_string($this->DetailsID)."', '".$this->myreal_escape_string($this->UserID)."', '".$this->myreal_escape_string($this->Icon)."', '".$this->myreal_escape_string($this->Action)."', '".$this->myreal_escape_string($this->Title)."', '".$this->myreal_escape_string($this->Description)."', '".$this->myreal_escape_string($this->DateAdded)."', '".$this->myreal_escape_string($this->TimeAdded)."')");
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
		$result = $this->connection->RunQuery("SELECT ID from v4_OrderLog $where ORDER BY $column $order");
			while($row = $result->fetch_array(MYSQLI_ASSOC)){
				$keys[$i] = $row["ID"];
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
	 * @return ShowToCustomer - tinyint(1)
	 */
	public function getShowToCustomer(){
		return $this->ShowToCustomer;
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
	 * @return Title - varchar(255)
	 */
	public function getTitle(){
		return $this->Title;
	}

	/**
	 * @return Description - text
	 */
	public function getDescription(){
		return $this->Description;
	}

	/**
	 * @return DateAdded - date
	 */
	public function getDateAdded(){
		return $this->DateAdded;
	}

	/**
	 * @return TimeAdded - time
	 */
	public function getTimeAdded(){
		return $this->TimeAdded;
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
	public function setShowToCustomer($ShowToCustomer){
		$this->ShowToCustomer = $ShowToCustomer;
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
	public function setTitle($Title){
		$this->Title = $Title;
	}

	/**
	 * @param Type: text
	 */
	public function setDescription($Description=null){
		$this->Description = $Description;
	}

	/**
	 * @param Type: date
	 */
	public function setDateAdded($DateAdded){
		$this->DateAdded = $DateAdded;
	}

	/**
	 * @param Type: time
	 */
	public function setTimeAdded($TimeAdded){
		$this->TimeAdded = $TimeAdded;
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
			'ShowToCustomer' => $this->getShowToCustomer(),
			'OrderID' => $this->getOrderID(),
			'DetailsID' => $this->getDetailsID(),
			'UserID' => $this->getUserID(),
			'Icon' => $this->getIcon(),
			'Action' => $this->getAction(),
			'Title' => $this->getTitle(),
			'Description' => $this->getDescription(),
			'DateAdded' => $this->getDateAdded(),
			'TimeAdded' => $this->getTimeAdded()		);
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
			'ID',			'ShowToCustomer',			'OrderID',			'DetailsID',			'UserID',			'Icon',			'Action',			'Title',			'Description',			'DateAdded',			'TimeAdded'		);
		return $fieldNames;
	}
    /**
     * Close mysql connection
     */
	public function endv4_OrderLog(){
		$this->connection->CloseMysql();
	}

}