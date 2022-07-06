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

Class v4_Pages {

	public $ID; //int(10) unsigned
	public $Title; //varchar(255)
	public $TitleEN; //varchar(255)
	public $TitleRU; //varchar(255)
	public $TitleFR; //varchar(255)
	public $TitleDE; //varchar(255)
	public $TitleIT; //varchar(255)
	public $TitleSE; //varchar(255)
	public $TitleNO; //varchar(255)
	public $TitleES; //varchar(255)
	public $TitleNL; //varchar(255)
	public $Content; //longtext
	public $ContentEN; //longtext
	public $ContentRU; //longtext
	public $ContentFR; //longtext
	public $ContentDE; //longtext
	public $ContentIT; //longtext
	public $ContentSE; //longtext
	public $ContentNO; //longtext
	public $ContentES; //longtext
	public $ContentNL; //longtext
	public $MenuTitle; //varchar(255)
	public $MenuTitleEN; //varchar(255)
	public $MenuTitleRU; //varchar(255)
	public $MenuTitleFR; //varchar(255)
	public $MenuTitleDE; //varchar(255)
	public $MenuTitleIT; //varchar(255)
	public $MenuTitleSE; //varchar(255)
	public $MenuTitleNO; //varchar(255)
	public $MenuTitleES; //varchar(255)
	public $MenuTitleNL; //varchar(255)
	public $LastChange; //timestamp
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
	public function New_v4_Pages($Title,$TitleEN,$TitleRU,$TitleFR,$TitleDE,$TitleIT,$TitleSE,$TitleNO,$TitleES,$TitleNL,$Content,$ContentEN,$ContentRU,$ContentFR,$ContentDE,$ContentIT,$ContentSE,$ContentNO,$ContentES,$ContentNL,$MenuTitle,$MenuTitleEN,$MenuTitleRU,$MenuTitleFR,$MenuTitleDE,$MenuTitleIT,$MenuTitleSE,$MenuTitleNO,$MenuTitleES,$MenuTitleNL,$LastChange){
		$this->Title = $Title;
		$this->TitleEN = $TitleEN;
		$this->TitleRU = $TitleRU;
		$this->TitleFR = $TitleFR;
		$this->TitleDE = $TitleDE;
		$this->TitleIT = $TitleIT;
		$this->TitleSE = $TitleSE;
		$this->TitleNO = $TitleNO;
		$this->TitleES = $TitleES;
		$this->TitleNL = $TitleNL;
		$this->Content = $Content;
		$this->ContentEN = $ContentEN;
		$this->ContentRU = $ContentRU;
		$this->ContentFR = $ContentFR;
		$this->ContentDE = $ContentDE;
		$this->ContentIT = $ContentIT;
		$this->ContentSE = $ContentSE;
		$this->ContentNO = $ContentNO;
		$this->ContentES = $ContentES;
		$this->ContentNL = $ContentNL;
		$this->MenuTitle = $MenuTitle;
		$this->MenuTitleEN = $MenuTitleEN;
		$this->MenuTitleRU = $MenuTitleRU;
		$this->MenuTitleFR = $MenuTitleFR;
		$this->MenuTitleDE = $MenuTitleDE;
		$this->MenuTitleIT = $MenuTitleIT;
		$this->MenuTitleSE = $MenuTitleSE;
		$this->MenuTitleNO = $MenuTitleNO;
		$this->MenuTitleES = $MenuTitleES;
		$this->MenuTitleNL = $MenuTitleNL;
		$this->LastChange = $LastChange;
	}

    /**
     * Load one row into var_class. To use the vars use for exemple echo $class->getVar_name; 
     *
     * @param key_table_type $key_row
     * 
     */
	public function getRow($key_row){
		$result = $this->connection->RunQuery("Select * from v4_Pages where ID = \"$key_row\" ");
		if($result->num_rows < 1) return false;
		while($row = $result->fetch_array(MYSQLI_ASSOC)){
			$this->ID = $row["ID"];
			$this->Title = $row["Title"];
			$this->TitleEN = $row["TitleEN"];
			$this->TitleRU = $row["TitleRU"];
			$this->TitleFR = $row["TitleFR"];
			$this->TitleDE = $row["TitleDE"];
			$this->TitleIT = $row["TitleIT"];
			$this->TitleSE = $row["TitleSE"];
			$this->TitleNO = $row["TitleNO"];
			$this->TitleES = $row["TitleES"];
			$this->TitleNL = $row["TitleNL"];
			$this->Content = $row["Content"];
			$this->ContentEN = $row["ContentEN"];
			$this->ContentRU = $row["ContentRU"];
			$this->ContentFR = $row["ContentFR"];
			$this->ContentDE = $row["ContentDE"];
			$this->ContentIT = $row["ContentIT"];
			$this->ContentSE = $row["ContentSE"];
			$this->ContentNO = $row["ContentNO"];
			$this->ContentES = $row["ContentES"];
			$this->ContentNL = $row["ContentNL"];
			$this->MenuTitle = $row["MenuTitle"];
			$this->MenuTitleEN = $row["MenuTitleEN"];
			$this->MenuTitleRU = $row["MenuTitleRU"];
			$this->MenuTitleFR = $row["MenuTitleFR"];
			$this->MenuTitleDE = $row["MenuTitleDE"];
			$this->MenuTitleIT = $row["MenuTitleIT"];
			$this->MenuTitleSE = $row["MenuTitleSE"];
			$this->MenuTitleNO = $row["MenuTitleNO"];
			$this->MenuTitleES = $row["MenuTitleES"];
			$this->MenuTitleNL = $row["MenuTitleNL"];
			$this->LastChange = $row["LastChange"];
		}
	}

    /**
     * Delete the row by using the key as arg
     *
     * @param key_table_type $key_row
     *
     */
	public function deleteRow($key_row){
		$this->connection->RunQuery("DELETE FROM v4_Pages WHERE ID = $key_row");
	}

    /**
     * Update the active row table on table
     */
	public function saveRow(){
		$result = $this->connection->RunQuery("UPDATE v4_Pages set 
Title = '".$this->myreal_escape_string($this->Title)."', 
TitleEN = '".$this->myreal_escape_string($this->TitleEN)."', 
TitleRU = '".$this->myreal_escape_string($this->TitleRU)."', 
TitleFR = '".$this->myreal_escape_string($this->TitleFR)."', 
TitleDE = '".$this->myreal_escape_string($this->TitleDE)."', 
TitleIT = '".$this->myreal_escape_string($this->TitleIT)."', 
TitleSE = '".$this->myreal_escape_string($this->TitleSE)."', 
TitleNO = '".$this->myreal_escape_string($this->TitleNO)."', 
TitleES = '".$this->myreal_escape_string($this->TitleES)."', 
TitleNL = '".$this->myreal_escape_string($this->TitleNL)."', 
Content = '".$this->myreal_escape_string($this->Content)."', 
ContentEN = '".$this->myreal_escape_string($this->ContentEN)."', 
ContentRU = '".$this->myreal_escape_string($this->ContentRU)."', 
ContentFR = '".$this->myreal_escape_string($this->ContentFR)."', 
ContentDE = '".$this->myreal_escape_string($this->ContentDE)."', 
ContentIT = '".$this->myreal_escape_string($this->ContentIT)."', 
ContentSE = '".$this->myreal_escape_string($this->ContentSE)."', 
ContentNO = '".$this->myreal_escape_string($this->ContentNO)."', 
ContentES = '".$this->myreal_escape_string($this->ContentES)."', 
ContentNL = '".$this->myreal_escape_string($this->ContentNL)."', 
MenuTitle = '".$this->myreal_escape_string($this->MenuTitle)."', 
MenuTitleEN = '".$this->myreal_escape_string($this->MenuTitleEN)."', 
MenuTitleRU = '".$this->myreal_escape_string($this->MenuTitleRU)."', 
MenuTitleFR = '".$this->myreal_escape_string($this->MenuTitleFR)."', 
MenuTitleDE = '".$this->myreal_escape_string($this->MenuTitleDE)."', 
MenuTitleIT = '".$this->myreal_escape_string($this->MenuTitleIT)."', 
MenuTitleSE = '".$this->myreal_escape_string($this->MenuTitleSE)."', 
MenuTitleNO = '".$this->myreal_escape_string($this->MenuTitleNO)."', 
MenuTitleES = '".$this->myreal_escape_string($this->MenuTitleES)."', 
MenuTitleNL = '".$this->myreal_escape_string($this->MenuTitleNL)."', 
LastChange = '".$this->myreal_escape_string($this->LastChange)."' WHERE ID = '".$this->ID."'");
	return $result; 
}

    /**
     * Save the active var class as a new row on table
     */
	public function saveAsNew(){
		$this->connection->RunQuery("INSERT INTO v4_Pages (Title, TitleEN, TitleRU, TitleFR, TitleDE, TitleIT, TitleSE, TitleNO, TitleES, TitleNL, Content, ContentEN, ContentRU, ContentFR, ContentDE, ContentIT, ContentSE, ContentNO, ContentES, ContentNL, MenuTitle, MenuTitleEN, MenuTitleRU, MenuTitleFR, MenuTitleDE, MenuTitleIT, MenuTitleSE, MenuTitleNO, MenuTitleES, MenuTitleNL, LastChange) values ('".$this->myreal_escape_string($this->Title)."', '".$this->myreal_escape_string($this->TitleEN)."', '".$this->myreal_escape_string($this->TitleRU)."', '".$this->myreal_escape_string($this->TitleFR)."', '".$this->myreal_escape_string($this->TitleDE)."', '".$this->myreal_escape_string($this->TitleIT)."', '".$this->myreal_escape_string($this->TitleSE)."', '".$this->myreal_escape_string($this->TitleNO)."', '".$this->myreal_escape_string($this->TitleES)."', '".$this->myreal_escape_string($this->TitleNL)."', '".$this->myreal_escape_string($this->Content)."', '".$this->myreal_escape_string($this->ContentEN)."', '".$this->myreal_escape_string($this->ContentRU)."', '".$this->myreal_escape_string($this->ContentFR)."', '".$this->myreal_escape_string($this->ContentDE)."', '".$this->myreal_escape_string($this->ContentIT)."', '".$this->myreal_escape_string($this->ContentSE)."', '".$this->myreal_escape_string($this->ContentNO)."', '".$this->myreal_escape_string($this->ContentES)."', '".$this->myreal_escape_string($this->ContentNL)."', '".$this->myreal_escape_string($this->MenuTitle)."', '".$this->myreal_escape_string($this->MenuTitleEN)."', '".$this->myreal_escape_string($this->MenuTitleRU)."', '".$this->myreal_escape_string($this->MenuTitleFR)."', '".$this->myreal_escape_string($this->MenuTitleDE)."', '".$this->myreal_escape_string($this->MenuTitleIT)."', '".$this->myreal_escape_string($this->MenuTitleSE)."', '".$this->myreal_escape_string($this->MenuTitleNO)."', '".$this->myreal_escape_string($this->MenuTitleES)."', '".$this->myreal_escape_string($this->MenuTitleNL)."', '".$this->myreal_escape_string($this->LastChange)."')");
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
		$result = $this->connection->RunQuery("SELECT ID from v4_Pages $where ORDER BY $column $order");
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
	 * @return Title - varchar(255)
	 */
	public function getTitle(){
		return $this->Title;
	}

	/**
	 * @return TitleEN - varchar(255)
	 */
	public function getTitleEN(){
		return $this->TitleEN;
	}

	/**
	 * @return TitleRU - varchar(255)
	 */
	public function getTitleRU(){
		return $this->TitleRU;
	}

	/**
	 * @return TitleFR - varchar(255)
	 */
	public function getTitleFR(){
		return $this->TitleFR;
	}

	/**
	 * @return TitleDE - varchar(255)
	 */
	public function getTitleDE(){
		return $this->TitleDE;
	}

	/**
	 * @return TitleIT - varchar(255)
	 */
	public function getTitleIT(){
		return $this->TitleIT;
	}

	/**
	 * @return TitleSE - varchar(255)
	 */
	public function getTitleSE(){
		return $this->TitleSE;
	}

	/**
	 * @return TitleNO - varchar(255)
	 */
	public function getTitleNO(){
		return $this->TitleNO;
	}

	/**
	 * @return TitleES - varchar(255)
	 */
	public function getTitleES(){
		return $this->TitleES;
	}

	/**
	 * @return TitleNL - varchar(255)
	 */
	public function getTitleNL(){
		return $this->TitleNL;
	}

	/**
	 * @return Content - longtext
	 */
	public function getContent(){
		return $this->Content;
	}

	/**
	 * @return ContentEN - longtext
	 */
	public function getContentEN(){
		return $this->ContentEN;
	}

	/**
	 * @return ContentRU - longtext
	 */
	public function getContentRU(){
		return $this->ContentRU;
	}

	/**
	 * @return ContentFR - longtext
	 */
	public function getContentFR(){
		return $this->ContentFR;
	}

	/**
	 * @return ContentDE - longtext
	 */
	public function getContentDE(){
		return $this->ContentDE;
	}

	/**
	 * @return ContentIT - longtext
	 */
	public function getContentIT(){
		return $this->ContentIT;
	}

	/**
	 * @return ContentSE - longtext
	 */
	public function getContentSE(){
		return $this->ContentSE;
	}

	/**
	 * @return ContentNO - longtext
	 */
	public function getContentNO(){
		return $this->ContentNO;
	}

	/**
	 * @return ContentES - longtext
	 */
	public function getContentES(){
		return $this->ContentES;
	}

	/**
	 * @return ContentNL - longtext
	 */
	public function getContentNL(){
		return $this->ContentNL;
	}

	/**
	 * @return MenuTitle - varchar(255)
	 */
	public function getMenuTitle(){
		return $this->MenuTitle;
	}

	/**
	 * @return MenuTitleEN - varchar(255)
	 */
	public function getMenuTitleEN(){
		return $this->MenuTitleEN;
	}

	/**
	 * @return MenuTitleRU - varchar(255)
	 */
	public function getMenuTitleRU(){
		return $this->MenuTitleRU;
	}

	/**
	 * @return MenuTitleFR - varchar(255)
	 */
	public function getMenuTitleFR(){
		return $this->MenuTitleFR;
	}

	/**
	 * @return MenuTitleDE - varchar(255)
	 */
	public function getMenuTitleDE(){
		return $this->MenuTitleDE;
	}

	/**
	 * @return MenuTitleIT - varchar(255)
	 */
	public function getMenuTitleIT(){
		return $this->MenuTitleIT;
	}

	/**
	 * @return MenuTitleSE - varchar(255)
	 */
	public function getMenuTitleSE(){
		return $this->MenuTitleSE;
	}

	/**
	 * @return MenuTitleNO - varchar(255)
	 */
	public function getMenuTitleNO(){
		return $this->MenuTitleNO;
	}

	/**
	 * @return MenuTitleES - varchar(255)
	 */
	public function getMenuTitleES(){
		return $this->MenuTitleES;
	}

	/**
	 * @return MenuTitleNL - varchar(255)
	 */
	public function getMenuTitleNL(){
		return $this->MenuTitleNL;
	}

	/**
	 * @return LastChange - timestamp
	 */
	public function getLastChange(){
		return $this->LastChange;
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
	public function setTitle($Title){
		$this->Title = $Title;
	}

	/**
	 * @param Type: varchar(255)
	 */
	public function setTitleEN($TitleEN){
		$this->TitleEN = $TitleEN;
	}

	/**
	 * @param Type: varchar(255)
	 */
	public function setTitleRU($TitleRU){
		$this->TitleRU = $TitleRU;
	}

	/**
	 * @param Type: varchar(255)
	 */
	public function setTitleFR($TitleFR){
		$this->TitleFR = $TitleFR;
	}

	/**
	 * @param Type: varchar(255)
	 */
	public function setTitleDE($TitleDE){
		$this->TitleDE = $TitleDE;
	}

	/**
	 * @param Type: varchar(255)
	 */
	public function setTitleIT($TitleIT){
		$this->TitleIT = $TitleIT;
	}

	/**
	 * @param Type: varchar(255)
	 */
	public function setTitleSE($TitleSE){
		$this->TitleSE = $TitleSE;
	}

	/**
	 * @param Type: varchar(255)
	 */
	public function setTitleNO($TitleNO){
		$this->TitleNO = $TitleNO;
	}

	/**
	 * @param Type: varchar(255)
	 */
	public function setTitleES($TitleES){
		$this->TitleES = $TitleES;
	}

	/**
	 * @param Type: varchar(255)
	 */
	public function setTitleNL($TitleNL){
		$this->TitleNL = $TitleNL;
	}

	/**
	 * @param Type: longtext
	 */
	public function setContent($Content){
		$this->Content = $Content;
	}

	/**
	 * @param Type: longtext
	 */
	public function setContentEN($ContentEN){
		$this->ContentEN = $ContentEN;
	}

	/**
	 * @param Type: longtext
	 */
	public function setContentRU($ContentRU){
		$this->ContentRU = $ContentRU;
	}

	/**
	 * @param Type: longtext
	 */
	public function setContentFR($ContentFR){
		$this->ContentFR = $ContentFR;
	}

	/**
	 * @param Type: longtext
	 */
	public function setContentDE($ContentDE){
		$this->ContentDE = $ContentDE;
	}

	/**
	 * @param Type: longtext
	 */
	public function setContentIT($ContentIT){
		$this->ContentIT = $ContentIT;
	}

	/**
	 * @param Type: longtext
	 */
	public function setContentSE($ContentSE){
		$this->ContentSE = $ContentSE;
	}

	/**
	 * @param Type: longtext
	 */
	public function setContentNO($ContentNO){
		$this->ContentNO = $ContentNO;
	}

	/**
	 * @param Type: longtext
	 */
	public function setContentES($ContentES){
		$this->ContentES = $ContentES;
	}

	/**
	 * @param Type: longtext
	 */
	public function setContentNL($ContentNL){
		$this->ContentNL = $ContentNL;
	}

	/**
	 * @param Type: varchar(255)
	 */
	public function setMenuTitle($MenuTitle){
		$this->MenuTitle = $MenuTitle;
	}

	/**
	 * @param Type: varchar(255)
	 */
	public function setMenuTitleEN($MenuTitleEN){
		$this->MenuTitleEN = $MenuTitleEN;
	}

	/**
	 * @param Type: varchar(255)
	 */
	public function setMenuTitleRU($MenuTitleRU){
		$this->MenuTitleRU = $MenuTitleRU;
	}

	/**
	 * @param Type: varchar(255)
	 */
	public function setMenuTitleFR($MenuTitleFR){
		$this->MenuTitleFR = $MenuTitleFR;
	}

	/**
	 * @param Type: varchar(255)
	 */
	public function setMenuTitleDE($MenuTitleDE){
		$this->MenuTitleDE = $MenuTitleDE;
	}

	/**
	 * @param Type: varchar(255)
	 */
	public function setMenuTitleIT($MenuTitleIT){
		$this->MenuTitleIT = $MenuTitleIT;
	}

	/**
	 * @param Type: varchar(255)
	 */
	public function setMenuTitleSE($MenuTitleSE){
		$this->MenuTitleSE = $MenuTitleSE;
	}

	/**
	 * @param Type: varchar(255)
	 */
	public function setMenuTitleNO($MenuTitleNO){
		$this->MenuTitleNO = $MenuTitleNO;
	}

	/**
	 * @param Type: varchar(255)
	 */
	public function setMenuTitleES($MenuTitleES){
		$this->MenuTitleES = $MenuTitleES;
	}

	/**
	 * @param Type: varchar(255)
	 */
	public function setMenuTitleNL($MenuTitleNL){
		$this->MenuTitleNL = $MenuTitleNL;
	}

	/**
	 * @param Type: timestamp
	 */
	public function setLastChange($LastChange){
		$this->LastChange = $LastChange;
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
			'Title' => $this->getTitle(),
			'TitleEN' => $this->getTitleEN(),
			'TitleRU' => $this->getTitleRU(),
			'TitleFR' => $this->getTitleFR(),
			'TitleDE' => $this->getTitleDE(),
			'TitleIT' => $this->getTitleIT(),
			'TitleSE' => $this->getTitleSE(),
			'TitleNO' => $this->getTitleNO(),
			'TitleES' => $this->getTitleES(),
			'TitleNL' => $this->getTitleNL(),
			'Content' => $this->getContent(),
			'ContentEN' => $this->getContentEN(),
			'ContentRU' => $this->getContentRU(),
			'ContentFR' => $this->getContentFR(),
			'ContentDE' => $this->getContentDE(),
			'ContentIT' => $this->getContentIT(),
			'ContentSE' => $this->getContentSE(),
			'ContentNO' => $this->getContentNO(),
			'ContentES' => $this->getContentES(),
			'ContentNL' => $this->getContentNL(),
			'MenuTitle' => $this->getMenuTitle(),
			'MenuTitleEN' => $this->getMenuTitleEN(),
			'MenuTitleRU' => $this->getMenuTitleRU(),
			'MenuTitleFR' => $this->getMenuTitleFR(),
			'MenuTitleDE' => $this->getMenuTitleDE(),
			'MenuTitleIT' => $this->getMenuTitleIT(),
			'MenuTitleSE' => $this->getMenuTitleSE(),
			'MenuTitleNO' => $this->getMenuTitleNO(),
			'MenuTitleES' => $this->getMenuTitleES(),
			'MenuTitleNL' => $this->getMenuTitleNL(),
			'LastChange' => $this->getLastChange()		);
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
			'ID',			'Title',			'TitleEN',			'TitleRU',			'TitleFR',			'TitleDE',			'TitleIT',			'TitleSE',			'TitleNO',			'TitleES',			'TitleNL',			'Content',			'ContentEN',			'ContentRU',			'ContentFR',			'ContentDE',			'ContentIT',			'ContentSE',			'ContentNO',			'ContentES',			'ContentNL',			'MenuTitle',			'MenuTitleEN',			'MenuTitleRU',			'MenuTitleFR',			'MenuTitleDE',			'MenuTitleIT',			'MenuTitleSE',			'MenuTitleNO',			'MenuTitleES',			'MenuTitleNL',			'LastChange'		);
		return $fieldNames;
	}
    /**
     * Close mysql connection
     */
	public function endv4_Pages(){
		$this->connection->CloseMysql();
	}

}
