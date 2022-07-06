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

Class v4_CoTexts {

	public $ID; //int(10)
	public $language; //varchar(10)
	public $co_homepage; //text
	public $co_desc; //text
	public $co_terms; //text
	public $co_refund; //text
	public $co_privacy; //text
	public $co_howtobook; //text
	public $co_htmlblock; //text
	public $co_sideblock; //text
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
	public function New_v4_CoTexts($language,$co_homepage,$co_desc,$co_terms,$co_refund,$co_privacy,$co_howtobook,$co_htmlblock,$co_sideblock){
		$this->language = $language;
		$this->co_homepage = $co_homepage;
		$this->co_desc = $co_desc;
		$this->co_terms = $co_terms;
		$this->co_refund = $co_refund;
		$this->co_privacy = $co_privacy;
		$this->co_howtobook = $co_howtobook;
		$this->co_htmlblock = $co_htmlblock;
		$this->co_sideblock = $co_sideblock;
	}

    /**
     * Load one row into var_class. To use the vars use for exemple echo $class->getVar_name; 
     *
     * @param key_table_type $key_row
     * 
     */
	public function getRow($key_row){
		$result = $this->connection->RunQuery("Select * from v4_CoTexts where ID = \"$key_row\" ");
		if($result->num_rows < 1) return false;
		while($row = $result->fetch_array(MYSQLI_ASSOC)){
			$this->ID = $row["ID"];
			$this->language = $row["language"];
			$this->co_homepage = $row["co_homepage"];
			$this->co_desc = $row["co_desc"];
			$this->co_terms = $row["co_terms"];
			$this->co_refund = $row["co_refund"];
			$this->co_privacy = $row["co_privacy"];
			$this->co_howtobook = $row["co_howtobook"];
			$this->co_htmlblock = $row["co_htmlblock"];
			$this->co_sideblock = $row["co_sideblock"];
		}
	}

    /**
     * Delete the row by using the key as arg
     *
     * @param key_table_type $key_row
     *
     */
	public function deleteRow($key_row){
		$this->connection->RunQuery("DELETE FROM v4_CoTexts WHERE ID = $key_row");
	}

    /**
     * Update the active row table on table
     */
	public function saveRow(){
		$result = $this->connection->RunQuery("UPDATE v4_CoTexts set 
language = '".$this->myreal_escape_string($this->language)."', 
co_homepage = '".$this->myreal_escape_string($this->co_homepage)."', 
co_desc = '".$this->myreal_escape_string($this->co_desc)."', 
co_terms = '".$this->myreal_escape_string($this->co_terms)."', 
co_refund = '".$this->myreal_escape_string($this->co_refund)."', 
co_privacy = '".$this->myreal_escape_string($this->co_privacy)."', 
co_howtobook = '".$this->myreal_escape_string($this->co_howtobook)."', 
co_htmlblock = '".$this->myreal_escape_string($this->co_htmlblock)."', 
co_sideblock = '".$this->myreal_escape_string($this->co_sideblock)."' WHERE ID = '".$this->ID."'");
	return $result; 
}

    /**
     * Save the active var class as a new row on table
     */
	public function saveAsNew(){
		$this->connection->RunQuery("INSERT INTO v4_CoTexts (language, co_homepage, co_desc, co_terms, co_refund, co_privacy, co_howtobook, co_htmlblock, co_sideblock) values ('".$this->myreal_escape_string($this->language)."', '".$this->myreal_escape_string($this->co_homepage)."', '".$this->myreal_escape_string($this->co_desc)."', '".$this->myreal_escape_string($this->co_terms)."', '".$this->myreal_escape_string($this->co_refund)."', '".$this->myreal_escape_string($this->co_privacy)."', '".$this->myreal_escape_string($this->co_howtobook)."', '".$this->myreal_escape_string($this->co_htmlblock)."', '".$this->myreal_escape_string($this->co_sideblock)."')");
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
		$result = $this->connection->RunQuery("SELECT ID from v4_CoTexts $where ORDER BY $column $order");
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
	 * @return language - varchar(10)
	 */
	public function getlanguage(){
		return $this->language;
	}

	/**
	 * @return co_homepage - text
	 */
	public function getco_homepage(){
		return $this->co_homepage;
	}

	/**
	 * @return co_desc - text
	 */
	public function getco_desc(){
		return $this->co_desc;
	}

	/**
	 * @return co_terms - text
	 */
	public function getco_terms(){
		return $this->co_terms;
	}

	/**
	 * @return co_refund - text
	 */
	public function getco_refund(){
		return $this->co_refund;
	}

	/**
	 * @return co_privacy - text
	 */
	public function getco_privacy(){
		return $this->co_privacy;
	}

	/**
	 * @return co_howtobook - text
	 */
	public function getco_howtobook(){
		return $this->co_howtobook;
	}

	/**
	 * @return co_htmlblock - text
	 */
	public function getco_htmlblock(){
		return $this->co_htmlblock;
	}

	/**
	 * @return co_sideblock - text
	 */
	public function getco_sideblock(){
		return $this->co_sideblock;
	}

	/**
	 * @param Type: int(10)
	 */
	public function setID($ID){
		$this->ID = $ID;
	}

	/**
	 * @param Type: varchar(10)
	 */
	public function setlanguage($language){
		$this->language = $language;
	}

	/**
	 * @param Type: text
	 */
	public function setco_homepage($co_homepage){
		$this->co_homepage = $co_homepage;
	}

	/**
	 * @param Type: text
	 */
	public function setco_desc($co_desc){
		$this->co_desc = $co_desc;
	}

	/**
	 * @param Type: text
	 */
	public function setco_terms($co_terms){
		$this->co_terms = $co_terms;
	}

	/**
	 * @param Type: text
	 */
	public function setco_refund($co_refund){
		$this->co_refund = $co_refund;
	}

	/**
	 * @param Type: text
	 */
	public function setco_privacy($co_privacy){
		$this->co_privacy = $co_privacy;
	}

	/**
	 * @param Type: text
	 */
	public function setco_howtobook($co_howtobook){
		$this->co_howtobook = $co_howtobook;
	}

	/**
	 * @param Type: text
	 */
	public function setco_htmlblock($co_htmlblock){
		$this->co_htmlblock = $co_htmlblock;
	}

	/**
	 * @param Type: text
	 */
	public function setco_sideblock($co_sideblock){
		$this->co_sideblock = $co_sideblock;
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
			'language' => $this->getlanguage(),
			'co_homepage' => $this->getco_homepage(),
			'co_desc' => $this->getco_desc(),
			'co_terms' => $this->getco_terms(),
			'co_refund' => $this->getco_refund(),
			'co_privacy' => $this->getco_privacy(),
			'co_howtobook' => $this->getco_howtobook(),
			'co_htmlblock' => $this->getco_htmlblock(),
			'co_sideblock' => $this->getco_sideblock()		);
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
			'ID',			'language',			'co_homepage',			'co_desc',			'co_terms',			'co_refund',			'co_privacy',			'co_howtobook',			'co_htmlblock',			'co_sideblock'		);
		return $fieldNames;
	}
    /**
     * Close mysql connection
     */
	public function endv4_CoTexts(){
		$this->connection->CloseMysql();
	}

}