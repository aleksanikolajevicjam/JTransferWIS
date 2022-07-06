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

Class v4_Articles {

	public $ID; //int(10) unsigned
	public $Language; //varchar(255)
	public $Page; //varchar(255)
	public $Position; //int(2) unsigned
	public $HTMLBefore; //varchar(255)
	public $HTMLAfter; //varchar(255)
	public $Classes; //varchar(255)
	public $Title; //varchar(255)
	public $Article; //mediumtext
	public $Published; //tinyint(1)
	public $LastChange; //timestamp
	public $UserID; //int(11)
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
	public function New_v4_Articles($Language,$Page,$Position,$HTMLBefore,$HTMLAfter,$Classes,$Title,$Article,$Published,$LastChange,$UserID){
		$this->Language = $Language;
		$this->Page = $Page;
		$this->Position = $Position;
		$this->HTMLBefore = $HTMLBefore;
		$this->HTMLAfter = $HTMLAfter;
		$this->Classes = $Classes;
		$this->Title = $Title;
		$this->Article = $Article;
		$this->Published = $Published;
		$this->LastChange = $LastChange;
		$this->UserID = $UserID;
	}

    /**
     * Load one row into var_class. To use the vars use for exemple echo $class->getVar_name; 
     *
     * @param key_table_type $key_row
     * 
     */
	public function getRow($key_row){
		$result = $this->connection->RunQuery("Select * from v4_Articles where ID = \"$key_row\" ");
		if($result->num_rows < 1) return false;
		while($row = $result->fetch_array(MYSQLI_ASSOC)){
			$this->ID = $row["ID"];
			$this->Language = $row["Language"];
			$this->Page = $row["Page"];
			$this->Position = $row["Position"];
			$this->HTMLBefore = $row["HTMLBefore"];
			$this->HTMLAfter = $row["HTMLAfter"];
			$this->Classes = $row["Classes"];
			$this->Title = $row["Title"];
			$this->Article = $this->connection->real_escape_string($row["Article"]);
			$this->Published = $row["Published"];
			$this->LastChange = $row["LastChange"];
			$this->UserID = $row["UserID"];
		}
	}

    /**
     * Delete the row by using the key as arg
     *
     * @param key_table_type $key_row
     *
     */
	public function deleteRow($key_row){
		$this->connection->RunQuery("DELETE FROM v4_Articles WHERE ID = $key_row");
	}

    /**
     * Update the active row table on table
     */
	public function saveRow(){
		$result = $this->connection->RunQuery("UPDATE v4_Articles set 
Language = '".$this->myreal_escape_string($this->Language)."', 
Page = '".$this->myreal_escape_string($this->Page)."', 
Position = '".$this->myreal_escape_string($this->Position)."', 
HTMLBefore = '".$this->myreal_escape_string($this->HTMLBefore)."', 
HTMLAfter = '".$this->myreal_escape_string($this->HTMLAfter)."', 
Classes = '".$this->myreal_escape_string($this->Classes)."', 
Title = '".$this->myreal_escape_string($this->Title)."', 
Article = '".$this->myreal_escape_string($this->Article)."', 
Published = '".$this->myreal_escape_string($this->Published)."', 
LastChange = '".$this->myreal_escape_string($this->LastChange)."', 
UserID = '".$this->myreal_escape_string($this->UserID)."' WHERE ID = '".$this->ID."'");
	return $result; 
}

    /**
     * Save the active var class as a new row on table
     */
	public function saveAsNew(){
		$this->connection->RunQuery("INSERT INTO v4_Articles (Language, Page, Position, HTMLBefore, HTMLAfter, Classes, Title, Article, Published, LastChange, UserID) values ('".$this->myreal_escape_string($this->Language)."', '".$this->myreal_escape_string($this->Page)."', '".$this->myreal_escape_string($this->Position)."', '".$this->myreal_escape_string($this->HTMLBefore)."', '".$this->myreal_escape_string($this->HTMLAfter)."', '".$this->myreal_escape_string($this->Classes)."', '".$this->myreal_escape_string($this->Title)."', '".$this->myreal_escape_string($this->Article)."', '".$this->myreal_escape_string($this->Published)."', '".$this->myreal_escape_string($this->LastChange)."', '".$this->myreal_escape_string($this->UserID)."')");
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
		$result = $this->connection->RunQuery("SELECT ID from v4_Articles $where ORDER BY $column $order");
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
	 * @return Language - varchar(255)
	 */
	public function getLanguage(){
		return $this->Language;
	}

	/**
	 * @return Page - varchar(255)
	 */
	public function getPage(){
		return $this->Page;
	}

	/**
	 * @return Position - int(2) unsigned
	 */
	public function getPosition(){
		return $this->Position;
	}

	/**
	 * @return HTMLBefore - varchar(255)
	 */
	public function getHTMLBefore(){
		return $this->HTMLBefore;
	}

	/**
	 * @return HTMLAfter - varchar(255)
	 */
	public function getHTMLAfter(){
		return $this->HTMLAfter;
	}

	/**
	 * @return Classes - varchar(255)
	 */
	public function getClasses(){
		return $this->Classes;
	}

	/**
	 * @return Title - varchar(255)
	 */
	public function getTitle(){
		return $this->Title;
	}

	/**
	 * @return Article - mediumtext
	 */
	public function getArticle(){
		return $this->Article;
	}

	/**
	 * @return Published - tinyint(1)
	 */
	public function getPublished(){
		return $this->Published;
	}

	/**
	 * @return LastChange - timestamp
	 */
	public function getLastChange(){
		return $this->LastChange;
	}

	/**
	 * @return UserID - int(11)
	 */
	public function getUserID(){
		return $this->UserID;
	}

	/**
	 * @param Type: int(10) unsigned
	 */
	public function setID($ID){
		$this->ID = $ID;
	}

	/**
	 * @param Type: varchar(255)
	 */
	public function setLanguage($Language){
		$this->Language = $Language;
	}

	/**
	 * @param Type: varchar(255)
	 */
	public function setPage($Page){
		$this->Page = $Page;
	}

	/**
	 * @param Type: int(2) unsigned
	 */
	public function setPosition($Position){
		$this->Position = $Position;
	}

	/**
	 * @param Type: varchar(255)
	 */
	public function setHTMLBefore($HTMLBefore){
		$this->HTMLBefore = $HTMLBefore;
	}

	/**
	 * @param Type: varchar(255)
	 */
	public function setHTMLAfter($HTMLAfter){
		$this->HTMLAfter = $HTMLAfter;
	}

	/**
	 * @param Type: varchar(255)
	 */
	public function setClasses($Classes){
		$this->Classes = $Classes;
	}

	/**
	 * @param Type: varchar(255)
	 */
	public function setTitle($Title){
		$this->Title = $Title;
	}

	/**
	 * @param Type: mediumtext
	 */
	public function setArticle($Article){
		$this->Article = $Article;
	}

	/**
	 * @param Type: tinyint(1)
	 */
	public function setPublished($Published){
		$this->Published = $Published;
	}

	/**
	 * @param Type: timestamp
	 */
	public function setLastChange($LastChange){
		$this->LastChange = $LastChange;
	}

	/**
	 * @param Type: int(11)
	 */
	public function setUserID($UserID){
		$this->UserID = $UserID;
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
			'Language' => $this->getLanguage(),
			'Page' => $this->getPage(),
			'Position' => $this->getPosition(),
			'HTMLBefore' => $this->getHTMLBefore(),
			'HTMLAfter' => $this->getHTMLAfter(),
			'Classes' => $this->getClasses(),
			'Title' => $this->getTitle(),
			'Article' => $this->getArticle(),
			'Published' => $this->getPublished(),
			'LastChange' => $this->getLastChange(),
			'UserID' => $this->getUserID()		);
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
			'ID',			'Language',			'Page',			'Position',			'HTMLBefore',			'HTMLAfter',			'Classes',			'Title',			'Article',			'Published',			'LastChange',			'UserID'		);
		return $fieldNames;
	}
    /**
     * Close mysql connection
     */
	public function endv4_Articles(){
		$this->connection->CloseMysql();
	}

}
