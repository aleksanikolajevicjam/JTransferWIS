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

Class v4_Langs {

	public $lang_short; //varchar(2)
	public $language; //varchar(20)
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
	public function New_v4_Langs($lang_short,$language){
		$this->lang_short = $lang_short;
		$this->language = $language;
	}

    /**
     * Load one row into var_class. To use the vars use for exemple echo $class->getVar_name; 
     *
     * @param key_table_type $key_row
     * 
     */
	public function getRow($key_row){
		$result = $this->connection->RunQuery("Select * from v4_Langs where lang_short = \"$key_row\" ");
		if($result->num_rows < 1) return false;
		while($row = $result->fetch_array(MYSQLI_ASSOC)){
			$this->lang_short = $row["lang_short"];
			$this->language = $row["language"];
		}
	}

    /**
     * Delete the row by using the key as arg
     *
     * @param key_table_type $key_row
     *
     */
	public function deleteRow($key_row){
		$this->connection->RunQuery("DELETE FROM v4_Langs WHERE lang_short = $key_row");
	}

    /**
     * Update the active row table on table
     */
	public function saveRow(){
		$result = $this->connection->RunQuery("UPDATE v4_Langs set 
lang_short = '".$this->myreal_escape_string($this->lang_short)."', 
language = '".$this->myreal_escape_string($this->language)."' WHERE lang_short = '".$this->lang_short."'");
	return $result; 
}

    /**
     * Save the active var class as a new row on table
     */
	public function saveAsNew(){
		$this->connection->RunQuery("INSERT INTO v4_Langs (lang_short, language) values ('".$this->myreal_escape_string($this->lang_short)."', '".$this->myreal_escape_string($this->language)."')");
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
		$result = $this->connection->RunQuery("SELECT lang_short from v4_Langs $where ORDER BY $column $order");
			while($row = $result->fetch_array(MYSQLI_ASSOC)){
				$keys[$i] = $row["lang_short"];
				$i++;
			}
	return $keys;
	}

	/**
	 * @return lang_short - varchar(2)
	 */
	public function getlang_short(){
		return $this->lang_short;
	}

	/**
	 * @return language - varchar(20)
	 */
	public function getlanguage(){
		return $this->language;
	}

	/**
	 * @param Type: varchar(2)
	 */
	public function setlang_short($lang_short){
		$this->lang_short = $lang_short;
	}

	/**
	 * @param Type: varchar(20)
	 */
	public function setlanguage($language){
		$this->language = $language;
	}

    /**
     * fieldValues - Load all fieldNames and fieldValues into Array. 
     *
     * @param 
     * 
     */
	public function fieldValues(){
		$fieldValues = array(
			'lang_short' => $this->getlang_short(),
			'language' => $this->getlanguage()		);
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
			'lang_short',			'language'		);
		return $fieldNames;
	}
    /**
     * Close mysql connection
     */
	public function endv4_Langs(){
		$this->connection->CloseMysql();
	}

}