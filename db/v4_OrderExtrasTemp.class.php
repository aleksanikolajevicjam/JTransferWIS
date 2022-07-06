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

Class v4_OrderExtrasTemp {

	public $ID; //int(10) unsigned
	public $OwnerID; //int(10) unsigned
	public $OrderDetailsID; //int(10) unsigned
	public $ServiceID; //int(10) unsigned
	public $ServiceName; //varchar(255)
	public $Provision; //decimal(10,2)
	public $DriverPrice; //decimal(10,2)
	public $Price; //decimal(10,2) unsigned
	public $Qty; //int(5) unsigned
	public $DriverPriceSum; //decimal(10,2)
	public $Sum; //decimal(10,2) unsigned
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
	public function New_v4_OrderExtrasTemp($OwnerID,$OrderDetailsID,$ServiceID,$ServiceName,$Provision,$DriverPrice,$Price,$Qty,$DriverPriceSum,$Sum){
		$this->OwnerID = $OwnerID;
		$this->OrderDetailsID = $OrderDetailsID;
		$this->ServiceID = $ServiceID;
		$this->ServiceName = $ServiceName;
		$this->Provision = $Provision;
		$this->DriverPrice = $DriverPrice;
		$this->Price = $Price;
		$this->Qty = $Qty;
		$this->DriverPriceSum = $DriverPriceSum;
		$this->Sum = $Sum;
	}

    /**
     * Load one row into var_class. To use the vars use for exemple echo $class->getVar_name; 
     *
     * @param key_table_type $key_row
     * 
     */
	public function getRow($key_row){
		$result = $this->connection->RunQuery("Select * from v4_OrderExtrasTemp where ID = \"$key_row\" ");
		if($result->num_rows < 1) return false;
		while($row = $result->fetch_array(MYSQLI_ASSOC)){
			$this->ID = $row["ID"];
			$this->OwnerID = $row["OwnerID"];
			$this->OrderDetailsID = $row["OrderDetailsID"];
			$this->ServiceID = $row["ServiceID"];
			$this->ServiceName = $row["ServiceName"];
			$this->Provision = $row["Provision"];
			$this->DriverPrice = $row["DriverPrice"];
			$this->Price = $row["Price"];
			$this->Qty = $row["Qty"];
			$this->DriverPriceSum = $row["DriverPriceSum"];
			$this->Sum = $row["Sum"];
		}
	}

    /**
     * Delete the row by using the key as arg
     *
     * @param key_table_type $key_row
     *
     */
	public function deleteRow($key_row){
		$this->connection->RunQuery("DELETE FROM v4_OrderExtrasTemp WHERE ID = $key_row");
	}

    /**
     * Update the active row table on table
     */
	public function saveRow(){
		$result = $this->connection->RunQuery("UPDATE v4_OrderExtrasTemp set 
OwnerID = '".$this->myreal_escape_string($this->OwnerID)."', 
OrderDetailsID = '".$this->myreal_escape_string($this->OrderDetailsID)."', 
ServiceID = '".$this->myreal_escape_string($this->ServiceID)."', 
ServiceName = '".$this->myreal_escape_string($this->ServiceName)."', 
Provision = '".$this->myreal_escape_string($this->Provision)."', 
DriverPrice = '".$this->myreal_escape_string($this->DriverPrice)."', 
Price = '".$this->myreal_escape_string($this->Price)."', 
Qty = '".$this->myreal_escape_string($this->Qty)."', 
DriverPriceSum = '".$this->myreal_escape_string($this->DriverPriceSum)."', 
Sum = '".$this->myreal_escape_string($this->Sum)."' WHERE ID = '".$this->ID."'");
	return $result; 
}

    /**
     * Save the active var class as a new row on table
     */
	public function saveAsNew(){
		$this->connection->RunQuery("INSERT INTO v4_OrderExtrasTemp (OwnerID, OrderDetailsID, ServiceID, ServiceName, Provision, DriverPrice, Price, Qty, DriverPriceSum, Sum) values ('".$this->myreal_escape_string($this->OwnerID)."', '".$this->myreal_escape_string($this->OrderDetailsID)."', '".$this->myreal_escape_string($this->ServiceID)."', '".$this->myreal_escape_string($this->ServiceName)."', '".$this->myreal_escape_string($this->Provision)."', '".$this->myreal_escape_string($this->DriverPrice)."', '".$this->myreal_escape_string($this->Price)."', '".$this->myreal_escape_string($this->Qty)."', '".$this->myreal_escape_string($this->DriverPriceSum)."', '".$this->myreal_escape_string($this->Sum)."')");
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
		$result = $this->connection->RunQuery("SELECT ID from v4_OrderExtrasTemp $where ORDER BY $column $order");
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
	 * @return OwnerID - int(10) unsigned
	 */
	public function getOwnerID(){
		return $this->OwnerID;
	}

	/**
	 * @return OrderDetailsID - int(10) unsigned
	 */
	public function getOrderDetailsID(){
		return $this->OrderDetailsID;
	}

	/**
	 * @return ServiceID - int(10) unsigned
	 */
	public function getServiceID(){
		return $this->ServiceID;
	}

	/**
	 * @return ServiceName - varchar(255)
	 */
	public function getServiceName(){
		return $this->ServiceName;
	}

	/**
	 * @return Provision - decimal(10,2)
	 */
	public function getProvision(){
		return $this->Provision;
	}

	/**
	 * @return DriverPrice - decimal(10,2)
	 */
	public function getDriverPrice(){
		return $this->DriverPrice;
	}

	/**
	 * @return Price - decimal(10,2) unsigned
	 */
	public function getPrice(){
		return $this->Price;
	}

	/**
	 * @return Qty - int(5) unsigned
	 */
	public function getQty(){
		return $this->Qty;
	}

	/**
	 * @return DriverPriceSum - decimal(10,2)
	 */
	public function getDriverPriceSum(){
		return $this->DriverPriceSum;
	}

	/**
	 * @return Sum - decimal(10,2) unsigned
	 */
	public function getSum(){
		return $this->Sum;
	}

	/**
	 * @param Type: int(10) unsigned
	 */
	public function setID($ID){
		$this->ID = $ID;
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
	public function setOrderDetailsID($OrderDetailsID){
		$this->OrderDetailsID = $OrderDetailsID;
	}

	/**
	 * @param Type: int(10) unsigned
	 */
	public function setServiceID($ServiceID){
		$this->ServiceID = $ServiceID;
	}

	/**
	 * @param Type: varchar(255)
	 */
	public function setServiceName($ServiceName){
		$this->ServiceName = $ServiceName;
	}

	/**
	 * @param Type: decimal(10,2)
	 */
	public function setProvision($Provision){
		$this->Provision = $Provision;
	}

	/**
	 * @param Type: decimal(10,2)
	 */
	public function setDriverPrice($DriverPrice){
		$this->DriverPrice = $DriverPrice;
	}

	/**
	 * @param Type: decimal(10,2) unsigned
	 */
	public function setPrice($Price){
		$this->Price = $Price;
	}

	/**
	 * @param Type: int(5) unsigned
	 */
	public function setQty($Qty){
		$this->Qty = $Qty;
	}

	/**
	 * @param Type: decimal(10,2)
	 */
	public function setDriverPriceSum($DriverPriceSum){
		$this->DriverPriceSum = $DriverPriceSum;
	}

	/**
	 * @param Type: decimal(10,2) unsigned
	 */
	public function setSum($Sum){
		$this->Sum = $Sum;
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
			'OwnerID' => $this->getOwnerID(),
			'OrderDetailsID' => $this->getOrderDetailsID(),
			'ServiceID' => $this->getServiceID(),
			'ServiceName' => $this->getServiceName(),
			'Provision' => $this->getProvision(),
			'DriverPrice' => $this->getDriverPrice(),
			'Price' => $this->getPrice(),
			'Qty' => $this->getQty(),
			'DriverPriceSum' => $this->getDriverPriceSum(),
			'Sum' => $this->getSum()		);
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
			'ID',			'OwnerID',			'OrderDetailsID',			'ServiceID',			'ServiceName',			'Provision',			'DriverPrice',			'Price',			'Qty',			'DriverPriceSum',			'Sum'		);
		return $fieldNames;
	}
    /**
     * Close mysql connection
     */
	public function endv4_OrderExtrasTemp(){
		$this->connection->CloseMysql();
	}

}