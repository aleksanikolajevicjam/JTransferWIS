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

Class v4_Equipment {

	public $ID; //int(10)
	public $DisplayOrder; //int(4)
	public $Active; //int(4)	
	public $Title; //varchar(255)
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
	public function New_v4_Equipment($ID,$DisplayOrder,$Active,$Title){
		$this->ID = $ID;
		$this->DisplayOrder = $DisplayOrder;
		$this->Active = $Active;		
		$this->Title = $Title;
	}

    /**
     * Load one row into var_class. To use the vars use for exemple echo $class->getVar_name; 
     *
     * @param key_table_type $key_row
     * 
     */
	public function getRow($key_row){
		$result = $this->connection->RunQuery("Select * from v4_Equipment where ID = \"$key_row\" ");
		if($result->num_rows < 1) return false;
		while($row = $result->fetch_array(MYSQLI_ASSOC)){
			$this->ID = $row["ID"];
			$this->DisplayOrder = $row["DisplayOrder"];
			$this->Active = $row["Active"];			
			$this->Title = $row["Title"];
		}
	}

    /**
     * Delete the row by using the key as arg
     *
     * @param key_table_type $key_row
     *
     */
	public function deleteRow($key_row){
		$this->connection->RunQuery("DELETE FROM v4_Equipment WHERE ID = $key_row");
	}

    /**
     * Update the active row table on table
     */
	public function saveRow(){
		$result = $this->connection->RunQuery("UPDATE v4_Equipment set 
ID = '".$this->myreal_escape_string($this->ID)."', 
DisplayOrder = '".$this->myreal_escape_string($this->DisplayOrder)."', 
Active = '".$this->myreal_escape_string($this->Active)."', 
Title = '".$this->myreal_escape_string($this->Title)."'
 WHERE ID = '".$this->ID."'");
	return $result; 
}

    /**
     * Save the active var class as a new row on table
     */
	public function saveAsNew(){
		$this->connection->RunQuery("INSERT INTO v4_Equipment (ID, DisplayOrder, Active, Title) values ('".$this->myreal_escape_string($this->ID)."',
		'".$this->myreal_escape_string($this->DisplayOrder)."',
		'".$this->myreal_escape_string($this->Active)."',		
		'".$this->myreal_escape_string($this->Title)."')");
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
		$result = $this->connection->RunQuery("SELECT ID from v4_Equipment $where ORDER BY $column $order");
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
	 * @return DisplayOrder - int(4)
	 */
	public function getDisplayOrder(){
		return $this->DisplayOrder;
	}

	/**
	 * @return Active - int(4)
	 */
	public function getActive(){
		return $this->Active;
	}
	
	/**
	 * @return Title - varchar(255)
	 */
	public function getTitle(){
		return $this->Title;
	}


	
	/**
	 * @param Type: int(10)
	 */
	public function setID($ID){
		$this->ID = $ID;
	}

	/**
	 * @param Type: int(4)
	 */
	public function setDisplayOrder($DisplayOrder){
		$this->DisplayOrder = $DisplayOrder;
	}

	/**
	 * @param Type: int(4)
	 */
	public function setActive($Active){
		$this->Active = $Active;
	}
	
	/**
	 * @param Type: varchar(255)
	 */
	public function setTitle($Title){
		$this->Title = $Title;
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
			'DisplayOrder' => $this->getDisplayOrder(),
			'Active' => $this->getActive(),			
			'Title' => $this->getTitle()		);
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
			'ID',			'DisplayOrder',		'Active',			'Title'	);
		return $fieldNames;
	}
    /**
     * Close mysql connection
     */
	public function endv4_Equipment(){
		$this->connection->CloseMysql();
	}

}