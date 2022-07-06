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

Class v4_Settings {

	public $id; //int(10) unsigned
	public $userid; //int(10) unsigned
	public $setkey; //varchar(100)
	public $setval; //varchar(100)
	public $settype; //varchar(255)
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
	public function New_v4_Settings($userid,$setkey,$setval,$settype){
		$this->userid = $userid;
		$this->setkey = $setkey;
		$this->setval = $setval;
		$this->settype = $settype;
	}

    /**
     * Load one row into var_class. To use the vars use for exemple echo $class->getVar_name; 
     *
     * @param key_table_type $key_row
     * 
     */
	public function getRow($key_row){
		$result = $this->connection->RunQuery("Select * from v4_Settings where id = \"$key_row\" ");
		if($result->num_rows < 1) return false;
		while($row = $result->fetch_array(MYSQLI_ASSOC)){
			$this->id = $row["id"];
			$this->userid = $row["userid"];
			$this->setkey = $row["setkey"];
			$this->setval = $row["setval"];
			$this->settype = $row["settype"];
		}
	}

    /**
     * Delete the row by using the key as arg
     *
     * @param key_table_type $key_row
     *
     */
	public function deleteRow($key_row){
		$this->connection->RunQuery("DELETE FROM v4_Settings WHERE id = $key_row");
	}

    /**
     * Update the active row table on table
     */
	public function saveRow(){
		$result = $this->connection->RunQuery("UPDATE v4_Settings set 
userid = '".$this->myreal_escape_string($this->userid)."', 
setkey = '".$this->myreal_escape_string($this->setkey)."', 
setval = '".$this->myreal_escape_string($this->setval)."', 
settype = '".$this->myreal_escape_string($this->settype)."' WHERE id = '".$this->id."'");
	return $result; 
}

    /**
     * Save the active var class as a new row on table
     */
	public function saveAsNew(){
		$this->connection->RunQuery("INSERT INTO v4_Settings (userid, setkey, setval, settype) values ('".$this->myreal_escape_string($this->userid)."', '".$this->myreal_escape_string($this->setkey)."', '".$this->myreal_escape_string($this->setval)."', '".$this->myreal_escape_string($this->settype)."')");
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
		$result = $this->connection->RunQuery("SELECT id from v4_Settings $where ORDER BY $column $order");
			while($row = $result->fetch_array(MYSQLI_ASSOC)){
				$keys[$i] = $row["id"];
				$i++;
			}
	return $keys;
	}

	/**
	 * @return id - int(10) unsigned
	 */
	public function getid(){
		return $this->id;
	}

	/**
	 * @return userid - int(10) unsigned
	 */
	public function getuserid(){
		return $this->userid;
	}

	/**
	 * @return setkey - varchar(100)
	 */
	public function getsetkey(){
		return $this->setkey;
	}

	/**
	 * @return setval - varchar(100)
	 */
	public function getsetval(){
		return $this->setval;
	}

	/**
	 * @return settype - varchar(255)
	 */
	public function getsettype(){
		return $this->settype;
	}

	/**
	 * @param Type: int(10) unsigned
	 */
	public function setid($id){
		$this->id = $id;
	}

	/**
	 * @param Type: int(10) unsigned
	 */
	public function setuserid($userid){
		$this->userid = $userid;
	}

	/**
	 * @param Type: varchar(100)
	 */
	public function setsetkey($setkey){
		$this->setkey = $setkey;
	}

	/**
	 * @param Type: varchar(100)
	 */
	public function setsetval($setval){
		$this->setval = $setval;
	}

	/**
	 * @param Type: varchar(255)
	 */
	public function setsettype($settype){
		$this->settype = $settype;
	}

    /**
     * fieldValues - Load all fieldNames and fieldValues into Array. 
     *
     * @param 
     * 
     */
	public function fieldValues(){
		$fieldValues = array(
			'id' => $this->getid(),
			'userid' => $this->getuserid(),
			'setkey' => $this->getsetkey(),
			'setval' => $this->getsetval(),
			'settype' => $this->getsettype()		);
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
			'id',			'userid',			'setkey',			'setval',			'settype'		);
		return $fieldNames;
	}
    /**
     * Close mysql connection
     */
	public function endv4_Settings(){
		$this->connection->CloseMysql();
	}

}