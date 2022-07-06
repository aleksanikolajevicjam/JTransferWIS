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

Class v4_CoInfo {

	public $ID; //int(10)
	public $co_name; //varchar(255)
	public $co_address; //text
	public $co_tel; //varchar(255)
	public $co_fax; //varchar(255)
	public $co_city; //varchar(255)
	public $co_country; //varchar(255)
	public $co_zip; //varchar(255)
	public $co_email; //varchar(255)
	public $co_taxno; //varchar(255)
	public $co_bank; //varchar(255)
	public $co_accountno; //varchar(255)
	public $co_iban; //varchar(255)
	public $co_swift; //varchar(255)
	public $co_domestictax; //decimal(6,2)
	public $co_foreigntax; //decimal(6,2)
	public $co_eurinfo; //text
	public $co_paymentinfo; //text
	public $co_facebook; //varchar(255)
	public $co_twitter; //varchar(255)
	public $co_linkedin; //varchar(255)
	public $co_youtube; //varchar(255)
	public $co_googleplus; //varchar(255)
	public $co_todo; //text
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
	public function New_v4_CoInfo($co_name,$co_address,$co_tel,$co_fax,$co_city,$co_country,$co_zip,$co_email,$co_taxno,$co_bank,$co_accountno,$co_iban,$co_swift,$co_domestictax,$co_foreigntax,$co_eurinfo,$co_paymentinfo,$co_facebook,$co_twitter,$co_linkedin,$co_youtube,$co_googleplus,$co_todo){
		$this->co_name = $co_name;
		$this->co_address = $co_address;
		$this->co_tel = $co_tel;
		$this->co_fax = $co_fax;
		$this->co_city = $co_city;
		$this->co_country = $co_country;
		$this->co_zip = $co_zip;
		$this->co_email = $co_email;
		$this->co_taxno = $co_taxno;
		$this->co_bank = $co_bank;
		$this->co_accountno = $co_accountno;
		$this->co_iban = $co_iban;
		$this->co_swift = $co_swift;
		$this->co_domestictax = $co_domestictax;
		$this->co_foreigntax = $co_foreigntax;
		$this->co_eurinfo = $co_eurinfo;
		$this->co_paymentinfo = $co_paymentinfo;
		$this->co_facebook = $co_facebook;
		$this->co_twitter = $co_twitter;
		$this->co_linkedin = $co_linkedin;
		$this->co_youtube = $co_youtube;
		$this->co_googleplus = $co_googleplus;
		$this->co_todo = $co_todo;
	}

    /**
     * Load one row into var_class. To use the vars use for exemple echo $class->getVar_name; 
     *
     * @param key_table_type $key_row
     * 
     */
	public function getRow($key_row){
		$result = $this->connection->RunQuery("Select * from v4_CoInfo where ID = \"$key_row\" ");
		if($result->num_rows < 1) return false;
		while($row = $result->fetch_array(MYSQLI_ASSOC)){
			$this->ID = $row["ID"];
			$this->co_name = $row["co_name"];
			$this->co_address = $row["co_address"];
			$this->co_tel = $row["co_tel"];
			$this->co_fax = $row["co_fax"];
			$this->co_city = $row["co_city"];
			$this->co_country = $row["co_country"];
			$this->co_zip = $row["co_zip"];
			$this->co_email = $row["co_email"];
			$this->co_taxno = $row["co_taxno"];
			$this->co_bank = $row["co_bank"];
			$this->co_accountno = $row["co_accountno"];
			$this->co_iban = $row["co_iban"];
			$this->co_swift = $row["co_swift"];
			$this->co_domestictax = $row["co_domestictax"];
			$this->co_foreigntax = $row["co_foreigntax"];
			$this->co_eurinfo = $row["co_eurinfo"];
			$this->co_paymentinfo = $row["co_paymentinfo"];
			$this->co_facebook = $row["co_facebook"];
			$this->co_twitter = $row["co_twitter"];
			$this->co_linkedin = $row["co_linkedin"];
			$this->co_youtube = $row["co_youtube"];
			$this->co_googleplus = $row["co_googleplus"];
			$this->co_todo = $row["co_todo"];
		}
	}

    /**
     * Delete the row by using the key as arg
     *
     * @param key_table_type $key_row
     *
     */
	public function deleteRow($key_row){
		$this->connection->RunQuery("DELETE FROM v4_CoInfo WHERE ID = $key_row");
	}

    /**
     * Update the active row table on table
     */
	public function saveRow(){
		$result = $this->connection->RunQuery("UPDATE v4_CoInfo set 
co_name = '".$this->myreal_escape_string($this->co_name)."', 
co_address = '".$this->myreal_escape_string($this->co_address)."', 
co_tel = '".$this->myreal_escape_string($this->co_tel)."', 
co_fax = '".$this->myreal_escape_string($this->co_fax)."', 
co_city = '".$this->myreal_escape_string($this->co_city)."', 
co_country = '".$this->myreal_escape_string($this->co_country)."', 
co_zip = '".$this->myreal_escape_string($this->co_zip)."', 
co_email = '".$this->myreal_escape_string($this->co_email)."', 
co_taxno = '".$this->myreal_escape_string($this->co_taxno)."', 
co_bank = '".$this->myreal_escape_string($this->co_bank)."', 
co_accountno = '".$this->myreal_escape_string($this->co_accountno)."', 
co_iban = '".$this->myreal_escape_string($this->co_iban)."', 
co_swift = '".$this->myreal_escape_string($this->co_swift)."', 
co_domestictax = '".$this->myreal_escape_string($this->co_domestictax)."', 
co_foreigntax = '".$this->myreal_escape_string($this->co_foreigntax)."', 
co_eurinfo = '".$this->myreal_escape_string($this->co_eurinfo)."', 
co_paymentinfo = '".$this->myreal_escape_string($this->co_paymentinfo)."', 
co_facebook = '".$this->myreal_escape_string($this->co_facebook)."', 
co_twitter = '".$this->myreal_escape_string($this->co_twitter)."', 
co_linkedin = '".$this->myreal_escape_string($this->co_linkedin)."', 
co_youtube = '".$this->myreal_escape_string($this->co_youtube)."', 
co_googleplus = '".$this->myreal_escape_string($this->co_googleplus)."', 
co_todo = '".$this->myreal_escape_string($this->co_todo)."' WHERE ID = '".$this->ID."'");
	return $result; 
}

    /**
     * Save the active var class as a new row on table
     */
	public function saveAsNew(){
		$this->connection->RunQuery("INSERT INTO v4_CoInfo (co_name, co_address, co_tel, co_fax, co_city, co_country, co_zip, co_email, co_taxno, co_bank, co_accountno, co_iban, co_swift, co_domestictax, co_foreigntax, co_eurinfo, co_paymentinfo, co_facebook, co_twitter, co_linkedin, co_youtube, co_googleplus, co_todo) values ('".$this->myreal_escape_string($this->co_name)."', '".$this->myreal_escape_string($this->co_address)."', '".$this->myreal_escape_string($this->co_tel)."', '".$this->myreal_escape_string($this->co_fax)."', '".$this->myreal_escape_string($this->co_city)."', '".$this->myreal_escape_string($this->co_country)."', '".$this->myreal_escape_string($this->co_zip)."', '".$this->myreal_escape_string($this->co_email)."', '".$this->myreal_escape_string($this->co_taxno)."', '".$this->myreal_escape_string($this->co_bank)."', '".$this->myreal_escape_string($this->co_accountno)."', '".$this->myreal_escape_string($this->co_iban)."', '".$this->myreal_escape_string($this->co_swift)."', '".$this->myreal_escape_string($this->co_domestictax)."', '".$this->myreal_escape_string($this->co_foreigntax)."', '".$this->myreal_escape_string($this->co_eurinfo)."', '".$this->myreal_escape_string($this->co_paymentinfo)."', '".$this->myreal_escape_string($this->co_facebook)."', '".$this->myreal_escape_string($this->co_twitter)."', '".$this->myreal_escape_string($this->co_linkedin)."', '".$this->myreal_escape_string($this->co_youtube)."', '".$this->myreal_escape_string($this->co_googleplus)."', '".$this->myreal_escape_string($this->co_todo)."')");
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
		$result = $this->connection->RunQuery("SELECT ID from v4_CoInfo $where ORDER BY $column $order");
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
	 * @return co_name - varchar(255)
	 */
	public function getco_name(){
		return $this->co_name;
	}

	/**
	 * @return co_address - text
	 */
	public function getco_address(){
		return $this->co_address;
	}

	/**
	 * @return co_tel - varchar(255)
	 */
	public function getco_tel(){
		return $this->co_tel;
	}

	/**
	 * @return co_fax - varchar(255)
	 */
	public function getco_fax(){
		return $this->co_fax;
	}

	/**
	 * @return co_city - varchar(255)
	 */
	public function getco_city(){
		return $this->co_city;
	}

	/**
	 * @return co_country - varchar(255)
	 */
	public function getco_country(){
		return $this->co_country;
	}

	/**
	 * @return co_zip - varchar(255)
	 */
	public function getco_zip(){
		return $this->co_zip;
	}

	/**
	 * @return co_email - varchar(255)
	 */
	public function getco_email(){
		return $this->co_email;
	}

	/**
	 * @return co_taxno - varchar(255)
	 */
	public function getco_taxno(){
		return $this->co_taxno;
	}

	/**
	 * @return co_bank - varchar(255)
	 */
	public function getco_bank(){
		return $this->co_bank;
	}

	/**
	 * @return co_accountno - varchar(255)
	 */
	public function getco_accountno(){
		return $this->co_accountno;
	}

	/**
	 * @return co_iban - varchar(255)
	 */
	public function getco_iban(){
		return $this->co_iban;
	}

	/**
	 * @return co_swift - varchar(255)
	 */
	public function getco_swift(){
		return $this->co_swift;
	}

	/**
	 * @return co_domestictax - decimal(6,2)
	 */
	public function getco_domestictax(){
		return $this->co_domestictax;
	}

	/**
	 * @return co_foreigntax - decimal(6,2)
	 */
	public function getco_foreigntax(){
		return $this->co_foreigntax;
	}

	/**
	 * @return co_eurinfo - text
	 */
	public function getco_eurinfo(){
		return $this->co_eurinfo;
	}

	/**
	 * @return co_paymentinfo - text
	 */
	public function getco_paymentinfo(){
		return $this->co_paymentinfo;
	}

	/**
	 * @return co_facebook - varchar(255)
	 */
	public function getco_facebook(){
		return $this->co_facebook;
	}

	/**
	 * @return co_twitter - varchar(255)
	 */
	public function getco_twitter(){
		return $this->co_twitter;
	}

	/**
	 * @return co_linkedin - varchar(255)
	 */
	public function getco_linkedin(){
		return $this->co_linkedin;
	}

	/**
	 * @return co_youtube - varchar(255)
	 */
	public function getco_youtube(){
		return $this->co_youtube;
	}

	/**
	 * @return co_googleplus - varchar(255)
	 */
	public function getco_googleplus(){
		return $this->co_googleplus;
	}

	/**
	 * @return co_todo - text
	 */
	public function getco_todo(){
		return $this->co_todo;
	}

	/**
	 * @param Type: int(10)
	 */
	public function setID($ID){
		$this->ID = $ID;
	}

	/**
	 * @param Type: varchar(255)
	 */
	public function setco_name($co_name){
		$this->co_name = $co_name;
	}

	/**
	 * @param Type: text
	 */
	public function setco_address($co_address){
		$this->co_address = $co_address;
	}

	/**
	 * @param Type: varchar(255)
	 */
	public function setco_tel($co_tel){
		$this->co_tel = $co_tel;
	}

	/**
	 * @param Type: varchar(255)
	 */
	public function setco_fax($co_fax){
		$this->co_fax = $co_fax;
	}

	/**
	 * @param Type: varchar(255)
	 */
	public function setco_city($co_city){
		$this->co_city = $co_city;
	}

	/**
	 * @param Type: varchar(255)
	 */
	public function setco_country($co_country){
		$this->co_country = $co_country;
	}

	/**
	 * @param Type: varchar(255)
	 */
	public function setco_zip($co_zip){
		$this->co_zip = $co_zip;
	}

	/**
	 * @param Type: varchar(255)
	 */
	public function setco_email($co_email){
		$this->co_email = $co_email;
	}

	/**
	 * @param Type: varchar(255)
	 */
	public function setco_taxno($co_taxno){
		$this->co_taxno = $co_taxno;
	}

	/**
	 * @param Type: varchar(255)
	 */
	public function setco_bank($co_bank){
		$this->co_bank = $co_bank;
	}

	/**
	 * @param Type: varchar(255)
	 */
	public function setco_accountno($co_accountno){
		$this->co_accountno = $co_accountno;
	}

	/**
	 * @param Type: varchar(255)
	 */
	public function setco_iban($co_iban){
		$this->co_iban = $co_iban;
	}

	/**
	 * @param Type: varchar(255)
	 */
	public function setco_swift($co_swift){
		$this->co_swift = $co_swift;
	}

	/**
	 * @param Type: decimal(6,2)
	 */
	public function setco_domestictax($co_domestictax){
		$this->co_domestictax = $co_domestictax;
	}

	/**
	 * @param Type: decimal(6,2)
	 */
	public function setco_foreigntax($co_foreigntax){
		$this->co_foreigntax = $co_foreigntax;
	}

	/**
	 * @param Type: text
	 */
	public function setco_eurinfo($co_eurinfo){
		$this->co_eurinfo = $co_eurinfo;
	}

	/**
	 * @param Type: text
	 */
	public function setco_paymentinfo($co_paymentinfo){
		$this->co_paymentinfo = $co_paymentinfo;
	}

	/**
	 * @param Type: varchar(255)
	 */
	public function setco_facebook($co_facebook){
		$this->co_facebook = $co_facebook;
	}

	/**
	 * @param Type: varchar(255)
	 */
	public function setco_twitter($co_twitter){
		$this->co_twitter = $co_twitter;
	}

	/**
	 * @param Type: varchar(255)
	 */
	public function setco_linkedin($co_linkedin){
		$this->co_linkedin = $co_linkedin;
	}

	/**
	 * @param Type: varchar(255)
	 */
	public function setco_youtube($co_youtube){
		$this->co_youtube = $co_youtube;
	}

	/**
	 * @param Type: varchar(255)
	 */
	public function setco_googleplus($co_googleplus){
		$this->co_googleplus = $co_googleplus;
	}

	/**
	 * @param Type: text
	 */
	public function setco_todo($co_todo){
		$this->co_todo = $co_todo;
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
			'co_name' => $this->getco_name(),
			'co_address' => $this->getco_address(),
			'co_tel' => $this->getco_tel(),
			'co_fax' => $this->getco_fax(),
			'co_city' => $this->getco_city(),
			'co_country' => $this->getco_country(),
			'co_zip' => $this->getco_zip(),
			'co_email' => $this->getco_email(),
			'co_taxno' => $this->getco_taxno(),
			'co_bank' => $this->getco_bank(),
			'co_accountno' => $this->getco_accountno(),
			'co_iban' => $this->getco_iban(),
			'co_swift' => $this->getco_swift(),
			'co_domestictax' => $this->getco_domestictax(),
			'co_foreigntax' => $this->getco_foreigntax(),
			'co_eurinfo' => $this->getco_eurinfo(),
			'co_paymentinfo' => $this->getco_paymentinfo(),
			'co_facebook' => $this->getco_facebook(),
			'co_twitter' => $this->getco_twitter(),
			'co_linkedin' => $this->getco_linkedin(),
			'co_youtube' => $this->getco_youtube(),
			'co_googleplus' => $this->getco_googleplus(),
			'co_todo' => $this->getco_todo()		);
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
			'ID',			'co_name',			'co_address',			'co_tel',			'co_fax',			'co_city',			'co_country',			'co_zip',			'co_email',			'co_taxno',			'co_bank',			'co_accountno',			'co_iban',			'co_swift',			'co_domestictax',			'co_foreigntax',			'co_eurinfo',			'co_paymentinfo',			'co_facebook',			'co_twitter',			'co_linkedin',			'co_youtube',			'co_googleplus',			'co_todo'		);
		return $fieldNames;
	}
    /**
     * Close mysql connection
     */
	public function endv4_CoInfo(){
		$this->connection->CloseMysql();
	}

}