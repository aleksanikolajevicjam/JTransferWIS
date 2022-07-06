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

Class v4_yes_no {

	public $dn_broj; //tinyint(4)
	public $dn_slova; //varchar(5)
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
	public function New_v4_yes_no(){
	}

    /**
     * Load one row into var_class. To use the vars use for exemple echo $class->getVar_name; 
     *
     * @param key_table_type $key_row
     * 
     */
	public function getRow($key_row){
		$result = $this->connection->RunQuery("Select * from v4_yes_no where dn_broj = \"$key_row\" ");
		if($result->num_rows < 1) return false;
		while($row = $result->fetch_array(MYSQLI_ASSOC)){
			$this->dn_broj = $row["dn_broj"];
			$this->dn_slova = $row["dn_slova"];
		}
	}

    /**
     * Delete the row by using the key as arg
     *
     * @param key_table_type $key_row
     *
     */
	public function deleteRow($key_row){
		$this->connection->RunQuery("DELETE FROM v4_yes_no WHERE dn_broj = $key_row");
	}

    /**
     * Update the active row table on table
     */
	public function saveRow(){
		$result = $this->connection->RunQuery("UPDATE v4_yes_no set 
 WHERE dn_broj = '".$this->dn_broj."'");
	return $result; 
}

    /**
     * Save the active var class as a new row on table
     */
	public function saveAsNew(){
		$this->connection->RunQuery("INSERT INTO v4_yes_no () values ()");
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
		$result = $this->connection->RunQuery("SELECT dn_broj from v4_yes_no $where ORDER BY $column $order");
			while($row = $result->fetch_array(MYSQLI_ASSOC)){
				$keys[$i] = $row["dn_broj"];
				$i++;
			}
	return $keys;
	}

	/**
	 * @return dn_broj - tinyint(4)
	 */
	public function getdn_broj(){
		return $this->dn_broj;
	}

	/**
	 * @return dn_slova - varchar(5)
	 */
	public function getdn_slova(){
		return $this->dn_slova;
	}

	/**
	 * @param Type: tinyint(4)
	 */
	public function setdn_broj($dn_broj){
		$this->dn_broj = $dn_broj;
	}

	/**
	 * @param Type: varchar(5)
	 */
	public function setdn_slova($dn_slova){
		$this->dn_slova = $dn_slova;
	}

    /**
     * fieldValues - Load all fieldNames and fieldValues into Array. 
     *
     * @param 
     * 
     */
	public function fieldValues(){
		$fieldValues = array(
			'dn_broj' => $this->getdn_broj(),
			'dn_slova' => $this->getdn_slova()		);
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
			'dn_broj',			'dn_slova'		);
		return $fieldNames;
	}
    /**
     * Close mysql connection
     */
	public function endv4_yes_no(){
		$this->connection->CloseMysql();
	}

}