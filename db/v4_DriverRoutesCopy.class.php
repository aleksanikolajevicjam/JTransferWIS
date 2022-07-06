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

Class v4_DriverRoutesCopy {

	public $ID; //int(10) unsigned
	public $SiteID; //int(3)
	public $OwnerID; //int(10) unsigned
	public $RouteID; //int(10) unsigned
	public $Active; //tinyint(1)
	public $Approved; //tinyint(1)
	public $RouteName; //varchar(255)
	public $OneToTwo; //tinyint(1)
	public $TwoToOne; //tinyint(1)
	public $SurCategory; //smallint(3)
	public $SurID; //int(10)
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
	public function New_v4_DriverRoutesCopy($SiteID,$OwnerID,$RouteID,$Active,$Approved,$RouteName,$OneToTwo,$TwoToOne,$SurCategory,$SurID){
		$this->SiteID = $SiteID;
		$this->OwnerID = $OwnerID;
		$this->RouteID = $RouteID;
		$this->Active = $Active;
		$this->Approved = $Approved;
		$this->RouteName = $RouteName;
		$this->OneToTwo = $OneToTwo;
		$this->TwoToOne = $TwoToOne;
		$this->SurCategory = $SurCategory;
		$this->SurID = $SurID;
	}

    /**
     * Load one row into var_class. To use the vars use for exemple echo $class->getVar_name; 
     *
     * @param key_table_type $key_row
     * 
     */
	public function getRow($key_row){
		$result = $this->connection->RunQuery("Select * from v4_DriverRoutesCopy where ID = \"$key_row\" ");
		if($result->num_rows < 1) return false;
		while($row = $result->fetch_array(MYSQLI_ASSOC)){
			$this->ID = $row["ID"];
			$this->SiteID = $row["SiteID"];
			$this->OwnerID = $row["OwnerID"];
			$this->RouteID = $row["RouteID"];
			$this->Active = $row["Active"];
			$this->Approved = $row["Approved"];
			$this->RouteName = $row["RouteName"];
			$this->OneToTwo = $row["OneToTwo"];
			$this->TwoToOne = $row["TwoToOne"];
			$this->SurCategory = $row["SurCategory"];
			$this->SurID = $row["SurID"];
		}
	}

    /**
     * Delete the row by using the key as arg
     *
     * @param key_table_type $key_row
     *
     */
	public function deleteRow($key_row){
		$this->connection->RunQuery("DELETE FROM v4_DriverRoutesCopy WHERE ID = $key_row");
	}

    /**
     * Update the active row table on table
     */
	public function saveRow(){
		$result = $this->connection->RunQuery("UPDATE v4_DriverRoutesCopy set 
SiteID = '".$this->myreal_escape_string($this->SiteID)."', 
OwnerID = '".$this->myreal_escape_string($this->OwnerID)."', 
RouteID = '".$this->myreal_escape_string($this->RouteID)."', 
Active = '".$this->myreal_escape_string($this->Active)."', 
Approved = '".$this->myreal_escape_string($this->Approved)."', 
RouteName = '".$this->myreal_escape_string($this->RouteName)."', 
OneToTwo = '".$this->myreal_escape_string($this->OneToTwo)."', 
TwoToOne = '".$this->myreal_escape_string($this->TwoToOne)."', 
SurCategory = '".$this->myreal_escape_string($this->SurCategory)."', 
SurID = '".$this->myreal_escape_string($this->SurID)."' WHERE ID = '".$this->ID."'");
	return $result; 
}

    /**
     * Save the active var class as a new row on table
     */
	public function saveAsNew(){
		$this->connection->RunQuery("INSERT INTO v4_DriverRoutesCopy (SiteID, OwnerID, RouteID, Active, Approved, RouteName, OneToTwo, TwoToOne, SurCategory, SurID) values ('".$this->myreal_escape_string($this->SiteID)."', '".$this->myreal_escape_string($this->OwnerID)."', '".$this->myreal_escape_string($this->RouteID)."', '".$this->myreal_escape_string($this->Active)."', '".$this->myreal_escape_string($this->Approved)."', '".$this->myreal_escape_string($this->RouteName)."', '".$this->myreal_escape_string($this->OneToTwo)."', '".$this->myreal_escape_string($this->TwoToOne)."', '".$this->myreal_escape_string($this->SurCategory)."', '".$this->myreal_escape_string($this->SurID)."')");
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
		$result = $this->connection->RunQuery("SELECT ID from v4_DriverRoutesCopy $where ORDER BY $column $order");
			while($row = $result->fetch_array(MYSQLI_ASSOC)){
				$keys[$i] = $row["ID"];
				$i++;
			}
	return $keys;
	}

	/**
	 * @return ID - int(10) unsigned
	 */
	public function getID(){
		return $this->ID;
	}

	/**
	 * @return SiteID - int(3)
	 */
	public function getSiteID(){
		return $this->SiteID;
	}

	/**
	 * @return OwnerID - int(10) unsigned
	 */
	public function getOwnerID(){
		return $this->OwnerID;
	}

	/**
	 * @return RouteID - int(10) unsigned
	 */
	public function getRouteID(){
		return $this->RouteID;
	}

	/**
	 * @return Active - tinyint(1)
	 */
	public function getActive(){
		return $this->Active;
	}

	/**
	 * @return Approved - tinyint(1)
	 */
	public function getApproved(){
		return $this->Approved;
	}

	/**
	 * @return RouteName - varchar(255)
	 */
	public function getRouteName(){
		return $this->RouteName;
	}

	/**
	 * @return OneToTwo - tinyint(1)
	 */
	public function getOneToTwo(){
		return $this->OneToTwo;
	}

	/**
	 * @return TwoToOne - tinyint(1)
	 */
	public function getTwoToOne(){
		return $this->TwoToOne;
	}

	/**
	 * @return SurCategory - smallint(3)
	 */
	public function getSurCategory(){
		return $this->SurCategory;
	}

	/**
	 * @return SurID - int(10)
	 */
	public function getSurID(){
		return $this->SurID;
	}

	/**
	 * @param Type: int(10) unsigned
	 */
	public function setID($ID){
		$this->ID = $ID;
	}

	/**
	 * @param Type: int(3)
	 */
	public function setSiteID($SiteID){
		$this->SiteID = $SiteID;
	}

	/**
	 * @param Type: int(10) unsigned
	 */
	public function setOwnerID($OwnerID){
		$this->OwnerID = $OwnerID;
	}

	/**
	 * @param Type: int(10) unsigned
	 */
	public function setRouteID($RouteID){
		$this->RouteID = $RouteID;
	}

	/**
	 * @param Type: tinyint(1)
	 */
	public function setActive($Active){
		$this->Active = $Active;
	}

	/**
	 * @param Type: tinyint(1)
	 */
	public function setApproved($Approved){
		$this->Approved = $Approved;
	}

	/**
	 * @param Type: varchar(255)
	 */
	public function setRouteName($RouteName){
		$this->RouteName = $RouteName;
	}

	/**
	 * @param Type: tinyint(1)
	 */
	public function setOneToTwo($OneToTwo){
		$this->OneToTwo = $OneToTwo;
	}

	/**
	 * @param Type: tinyint(1)
	 */
	public function setTwoToOne($TwoToOne){
		$this->TwoToOne = $TwoToOne;
	}

	/**
	 * @param Type: smallint(3)
	 */
	public function setSurCategory($SurCategory){
		$this->SurCategory = $SurCategory;
	}

	/**
	 * @param Type: int(10)
	 */
	public function setSurID($SurID){
		$this->SurID = $SurID;
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
			'SiteID' => $this->getSiteID(),
			'OwnerID' => $this->getOwnerID(),
			'RouteID' => $this->getRouteID(),
			'Active' => $this->getActive(),
			'Approved' => $this->getApproved(),
			'RouteName' => $this->getRouteName(),
			'OneToTwo' => $this->getOneToTwo(),
			'TwoToOne' => $this->getTwoToOne(),
			'SurCategory' => $this->getSurCategory(),
			'SurID' => $this->getSurID()		);
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
			'ID',			'SiteID',			'OwnerID',			'RouteID',			'Active',			'Approved',			'RouteName',			'OneToTwo',			'TwoToOne',			'SurCategory',			'SurID'		);
		return $fieldNames;
	}
    /**
     * Close mysql connection
     */
	public function endv4_DriverRoutesCopy(){
		$this->connection->CloseMysql();
	}

}