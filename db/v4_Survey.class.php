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

Class v4_Survey {

	public $ID; //int(11)
	public $Date; //date
	public $OrderID; //int(11)
	public $RouteID; //int(11)
	public $UserEmail; //varchar(255)
	public $UserName; //varchar(100)
	public $Comment; //text
	public $ScoreService; //int(11)
	public $ScoreDriver; //int(11)
	public $ScoreClean; //int(11)
	public $ScoreValue; //int(11)
	public $ScoreWebsite; //int(11)
	public $ScoreTotal; //float
	public $DriverOnTime; //int(11)
	public $Recommend; //int(11)
	public $BookAgain; //int(11)
	public $Approved; //int(11)
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
	public function New_v4_Survey($Date,$OrderID,$RouteID,$UserEmail,$UserName,$Comment,$ScoreService,$ScoreDriver,$ScoreClean,$ScoreValue,$ScoreWebsite,$ScoreTotal,$DriverOnTime,$Recommend,$BookAgain,$Approved){
		$this->Date = $Date;
		$this->OrderID = $OrderID;
		$this->RouteID = $RouteID;
		$this->UserEmail = $UserEmail;
		$this->UserName = $UserName;
		$this->Comment = $Comment;
		$this->ScoreService = $ScoreService;
		$this->ScoreDriver = $ScoreDriver;
		$this->ScoreClean = $ScoreClean;
		$this->ScoreValue = $ScoreValue;
		$this->ScoreWebsite = $ScoreWebsite;
		$this->ScoreTotal = $ScoreTotal;
		$this->DriverOnTime = $DriverOnTime;
		$this->Recommend = $Recommend;
		$this->BookAgain = $BookAgain;
		$this->Approved = $Approved;
	}

    /**
     * Load one row into var_class. To use the vars use for exemple echo $class->getVar_name; 
     *
     * @param key_table_type $key_row
     * 
     */
	public function getRow($key_row){
		$result = $this->connection->RunQuery("Select * from v4_Survey where ID = \"$key_row\" ");
		if($result->num_rows < 1) return false;
		while($row = $result->fetch_array(MYSQLI_ASSOC)){
			$this->ID = $row["ID"];
			$this->Date = $row["Date"];
			$this->OrderID = $row["OrderID"];
			$this->RouteID = $row["RouteID"];
			$this->UserEmail = $row["UserEmail"];
			$this->UserName = $row["UserName"];
			$this->Comment = $row["Comment"];
			$this->ScoreService = $row["ScoreService"];
			$this->ScoreDriver = $row["ScoreDriver"];
			$this->ScoreClean = $row["ScoreClean"];
			$this->ScoreValue = $row["ScoreValue"];
			$this->ScoreWebsite = $row["ScoreWebsite"];
			$this->ScoreTotal = $row["ScoreTotal"];
			$this->DriverOnTime = $row["DriverOnTime"];
			$this->Recommend = $row["Recommend"];
			$this->BookAgain = $row["BookAgain"];
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
		$this->connection->RunQuery("DELETE FROM v4_Survey WHERE ID = $key_row");
	}

    /**
     * Update the active row table on table
     */
	public function saveRow(){
		$result = $this->connection->RunQuery("UPDATE v4_Survey set 
Date = '".$this->myreal_escape_string($this->Date)."', 
OrderID = '".$this->myreal_escape_string($this->OrderID)."', 
RouteID = '".$this->myreal_escape_string($this->RouteID)."', 
UserEmail = '".$this->myreal_escape_string($this->UserEmail)."', 
UserName = '".$this->myreal_escape_string($this->UserName)."', 
Comment = '".$this->myreal_escape_string($this->Comment)."', 
ScoreService = '".$this->myreal_escape_string($this->ScoreService)."', 
ScoreDriver = '".$this->myreal_escape_string($this->ScoreDriver)."', 
ScoreClean = '".$this->myreal_escape_string($this->ScoreClean)."', 
ScoreValue = '".$this->myreal_escape_string($this->ScoreValue)."', 
ScoreWebsite = '".$this->myreal_escape_string($this->ScoreWebsite)."', 
ScoreTotal = '".$this->myreal_escape_string($this->ScoreTotal)."', 
DriverOnTime = '".$this->myreal_escape_string($this->DriverOnTime)."', 
Recommend = '".$this->myreal_escape_string($this->Recommend)."', 
BookAgain = '".$this->myreal_escape_string($this->BookAgain)."', 
Approved = '".$this->myreal_escape_string($this->Approved)."' WHERE ID = '".$this->ID."'");
	return $result; 
}

    /**
     * Save the active var class as a new row on table
     */
	public function saveAsNew(){
		$this->connection->RunQuery("INSERT INTO v4_Survey (Date, OrderID, RouteID, UserEmail, UserName, Comment, ScoreService, ScoreDriver, ScoreClean, ScoreValue, ScoreWebsite, ScoreTotal, DriverOnTime, Recommend, BookAgain, Approved) values ('".$this->myreal_escape_string($this->Date)."', '".$this->myreal_escape_string($this->OrderID)."', '".$this->myreal_escape_string($this->RouteID)."', '".$this->myreal_escape_string($this->UserEmail)."', '".$this->myreal_escape_string($this->UserName)."', '".$this->myreal_escape_string($this->Comment)."', '".$this->myreal_escape_string($this->ScoreService)."', '".$this->myreal_escape_string($this->ScoreDriver)."', '".$this->myreal_escape_string($this->ScoreClean)."', '".$this->myreal_escape_string($this->ScoreValue)."', '".$this->myreal_escape_string($this->ScoreWebsite)."', '".$this->myreal_escape_string($this->ScoreTotal)."', '".$this->myreal_escape_string($this->DriverOnTime)."', '".$this->myreal_escape_string($this->Recommend)."', '".$this->myreal_escape_string($this->BookAgain)."', '".$this->myreal_escape_string($this->Approved)."')");
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
		$result = $this->connection->RunQuery("SELECT ID from v4_Survey $where ORDER BY $column $order");
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
	 * @return Date - date
	 */
	public function getDate(){
		return $this->Date;
	}

	/**
	 * @return OrderID - int(11)
	 */
	public function getOrderID(){
		return $this->OrderID;
	}

	/**
	 * @return RouteID - int(11)
	 */
	public function getRouteID(){
		return $this->RouteID;
	}

	/**
	 * @return UserEmail - varchar(255)
	 */
	public function getUserEmail(){
		return $this->UserEmail;
	}

	/**
	 * @return UserName - varchar(100)
	 */
	public function getUserName(){
		return $this->UserName;
	}

	/**
	 * @return Comment - text
	 */
	public function getComment(){
		return $this->Comment;
	}

	/**
	 * @return ScoreService - int(11)
	 */
	public function getScoreService(){
		return $this->ScoreService;
	}

	/**
	 * @return ScoreDriver - int(11)
	 */
	public function getScoreDriver(){
		return $this->ScoreDriver;
	}

	/**
	 * @return ScoreClean - int(11)
	 */
	public function getScoreClean(){
		return $this->ScoreClean;
	}

	/**
	 * @return ScoreValue - int(11)
	 */
	public function getScoreValue(){
		return $this->ScoreValue;
	}

	/**
	 * @return ScoreWebsite - int(11)
	 */
	public function getScoreWebsite(){
		return $this->ScoreWebsite;
	}

	/**
	 * @return ScoreTotal - float
	 */
	public function getScoreTotal(){
		return $this->ScoreTotal;
	}

	/**
	 * @return DriverOnTime - int(11)
	 */
	public function getDriverOnTime(){
		return $this->DriverOnTime;
	}

	/**
	 * @return Recommend - int(11)
	 */
	public function getRecommend(){
		return $this->Recommend;
	}

	/**
	 * @return BookAgain - int(11)
	 */
	public function getBookAgain(){
		return $this->BookAgain;
	}

	/**
	 * @return Approved - int(11)
	 */
	public function getApproved(){
		return $this->Approved;
	}

	/**
	 * @param Type: int(11)
	 */
	public function setID($ID){
		$this->ID = $ID;
	}

	/**
	 * @param Type: date
	 */
	public function setDate($Date){
		$this->Date = $Date;
	}

	/**
	 * @param Type: int(11)
	 */
	public function setOrderID($OrderID){
		$this->OrderID = $OrderID;
	}

	/**
	 * @param Type: int(11)
	 */
	public function setRouteID($RouteID){
		$this->RouteID = $RouteID;
	}

	/**
	 * @param Type: varchar(255)
	 */
	public function setUserEmail($UserEmail){
		$this->UserEmail = $UserEmail;
	}

	/**
	 * @param Type: varchar(100)
	 */
	public function setUserName($UserName){
		$this->UserName = $UserName;
	}

	/**
	 * @param Type: text
	 */
	public function setComment($Comment){
		$this->Comment = $Comment;
	}

	/**
	 * @param Type: int(11)
	 */
	public function setScoreService($ScoreService){
		$this->ScoreService = $ScoreService;
	}

	/**
	 * @param Type: int(11)
	 */
	public function setScoreDriver($ScoreDriver){
		$this->ScoreDriver = $ScoreDriver;
	}

	/**
	 * @param Type: int(11)
	 */
	public function setScoreClean($ScoreClean){
		$this->ScoreClean = $ScoreClean;
	}

	/**
	 * @param Type: int(11)
	 */
	public function setScoreValue($ScoreValue){
		$this->ScoreValue = $ScoreValue;
	}

	/**
	 * @param Type: int(11)
	 */
	public function setScoreWebsite($ScoreWebsite){
		$this->ScoreWebsite = $ScoreWebsite;
	}

	/**
	 * @param Type: float
	 */
	public function setScoreTotal($ScoreTotal){
		$this->ScoreTotal = $ScoreTotal;
	}

	/**
	 * @param Type: int(11)
	 */
	public function setDriverOnTime($DriverOnTime){
		$this->DriverOnTime = $DriverOnTime;
	}

	/**
	 * @param Type: int(11)
	 */
	public function setRecommend($Recommend){
		$this->Recommend = $Recommend;
	}

	/**
	 * @param Type: int(11)
	 */
	public function setBookAgain($BookAgain){
		$this->BookAgain = $BookAgain;
	}

	/**
	 * @param Type: int(11)
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
			'Date' => $this->getDate(),
			'OrderID' => $this->getOrderID(),
			'RouteID' => $this->getRouteID(),
			'UserEmail' => $this->getUserEmail(),
			'UserName' => $this->getUserName(),
			'Comment' => $this->getComment(),
			'ScoreService' => $this->getScoreService(),
			'ScoreDriver' => $this->getScoreDriver(),
			'ScoreClean' => $this->getScoreClean(),
			'ScoreValue' => $this->getScoreValue(),
			'ScoreWebsite' => $this->getScoreWebsite(),
			'ScoreTotal' => $this->getScoreTotal(),
			'DriverOnTime' => $this->getDriverOnTime(),
			'Recommend' => $this->getRecommend(),
			'BookAgain' => $this->getBookAgain(),
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
			'ID',			'Date',			'OrderID',			'RouteID',			'UserEmail',			'UserName',			'Comment',			'ScoreService',			'ScoreDriver',			'ScoreClean',			'ScoreValue',			'ScoreWebsite',			'ScoreTotal',			'DriverOnTime',			'Recommend',			'BookAgain',			'Approved'		);
		return $fieldNames;
	}
    /**
     * Close mysql connection
     */
	public function endv4_Survey(){
		$this->connection->CloseMysql();
	}

}