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

Class v4_Drivers {

	public $SiteID; //int(3) unsigned
	public $DriverID; //int(5) unsigned
	public $Country; //varchar(5)
	public $Company; //varchar(255)
	public $Tel; //varchar(255)
	public $Fax; //varchar(255)
	public $City; //varchar(255)
	public $Terminal; //varchar(255)
	public $Account; //varchar(255)
	public $IBAN; //varchar(255)
	public $Active; //tinyint(4)
	public $Prezime; //varchar(20)
	public $Ime; //varchar(20)
	public $Email; //varchar(50)
	public $Opis; //text
	public $Discount; //decimal(5,2)
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
	public function New_v4_Drivers($SiteID,$Country,$Company,$Tel,$Fax,$City,$Terminal,$Account,$IBAN,$Active,$Prezime,$Ime,$Email,$Opis,$Discount){
		$this->SiteID = $SiteID;
		$this->Country = $Country;
		$this->Company = $Company;
		$this->Tel = $Tel;
		$this->Fax = $Fax;
		$this->City = $City;
		$this->Terminal = $Terminal;
		$this->Account = $Account;
		$this->IBAN = $IBAN;
		$this->Active = $Active;
		$this->Prezime = $Prezime;
		$this->Ime = $Ime;
		$this->Email = $Email;
		$this->Opis = $Opis;
		$this->Discount = $Discount;
	}

    /**
     * Load one row into var_class. To use the vars use for exemple echo $class->getVar_name; 
     *
     * @param key_table_type $key_row
     * 
     */
	public function getRow($key_row){
		$result = $this->connection->RunQuery("Select * from v4_Drivers where DriverID = \"$key_row\" ");
		if($result->num_rows < 1) return false;
		while($row = $result->fetch_array(MYSQLI_ASSOC)){
			$this->SiteID = $row["SiteID"];
			$this->DriverID = $row["DriverID"];
			$this->Country = $row["Country"];
			$this->Company = $row["Company"];
			$this->Tel = $row["Tel"];
			$this->Fax = $row["Fax"];
			$this->City = $row["City"];
			$this->Terminal = $row["Terminal"];
			$this->Account = $row["Account"];
			$this->IBAN = $row["IBAN"];
			$this->Active = $row["Active"];
			$this->Prezime = $row["Prezime"];
			$this->Ime = $row["Ime"];
			$this->Email = $row["Email"];
			$this->Opis = $row["Opis"];
			$this->Discount = $row["Discount"];
		}
	}

    /**
     * Delete the row by using the key as arg
     *
     * @param key_table_type $key_row
     *
     */
	public function deleteRow($key_row){
		$this->connection->RunQuery("DELETE FROM v4_Drivers WHERE DriverID = $key_row");
	}

    /**
     * Update the active row table on table
     */
	public function saveRow(){
		$result = $this->connection->RunQuery("UPDATE v4_Drivers set 
SiteID = '".$this->myreal_escape_string($this->SiteID)."', 
Country = '".$this->myreal_escape_string($this->Country)."', 
Company = '".$this->myreal_escape_string($this->Company)."', 
Tel = '".$this->myreal_escape_string($this->Tel)."', 
Fax = '".$this->myreal_escape_string($this->Fax)."', 
City = '".$this->myreal_escape_string($this->City)."', 
Terminal = '".$this->myreal_escape_string($this->Terminal)."', 
Account = '".$this->myreal_escape_string($this->Account)."', 
IBAN = '".$this->myreal_escape_string($this->IBAN)."', 
Active = '".$this->myreal_escape_string($this->Active)."', 
Prezime = '".$this->myreal_escape_string($this->Prezime)."', 
Ime = '".$this->myreal_escape_string($this->Ime)."', 
Email = '".$this->myreal_escape_string($this->Email)."', 
Opis = '".$this->myreal_escape_string($this->Opis)."', 
Discount = '".$this->myreal_escape_string($this->Discount)."' WHERE DriverID = '".$this->DriverID."'");
	return $result; 
}

    /**
     * Save the active var class as a new row on table
     */
	public function saveAsNew(){
		$this->connection->RunQuery("INSERT INTO v4_Drivers (SiteID, Country, Company, Tel, Fax, City, Terminal, Account, IBAN, Active, Prezime, Ime, Email, Opis, Discount) values ('".$this->myreal_escape_string($this->SiteID)."', '".$this->myreal_escape_string($this->Country)."', '".$this->myreal_escape_string($this->Company)."', '".$this->myreal_escape_string($this->Tel)."', '".$this->myreal_escape_string($this->Fax)."', '".$this->myreal_escape_string($this->City)."', '".$this->myreal_escape_string($this->Terminal)."', '".$this->myreal_escape_string($this->Account)."', '".$this->myreal_escape_string($this->IBAN)."', '".$this->myreal_escape_string($this->Active)."', '".$this->myreal_escape_string($this->Prezime)."', '".$this->myreal_escape_string($this->Ime)."', '".$this->myreal_escape_string($this->Email)."', '".$this->myreal_escape_string($this->Opis)."', '".$this->myreal_escape_string($this->Discount)."')");
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
		$result = $this->connection->RunQuery("SELECT DriverID from v4_Drivers $where ORDER BY $column $order");
			while($row = $result->fetch_array(MYSQLI_ASSOC)){
				$keys[$i] = $row["DriverID"];
				$i++;
			}
	return $keys;
	}

	/**
	 * @return SiteID - int(3) unsigned
	 */
	public function getSiteID(){
		return $this->SiteID;
	}

	/**
	 * @return DriverID - int(5) unsigned
	 */
	public function getDriverID(){
		return $this->DriverID;
	}

	/**
	 * @return Country - varchar(5)
	 */
	public function getCountry(){
		return $this->Country;
	}

	/**
	 * @return Company - varchar(255)
	 */
	public function getCompany(){
		return $this->Company;
	}

	/**
	 * @return Tel - varchar(255)
	 */
	public function getTel(){
		return $this->Tel;
	}

	/**
	 * @return Fax - varchar(255)
	 */
	public function getFax(){
		return $this->Fax;
	}

	/**
	 * @return City - varchar(255)
	 */
	public function getCity(){
		return $this->City;
	}

	/**
	 * @return Terminal - varchar(255)
	 */
	public function getTerminal(){
		return $this->Terminal;
	}

	/**
	 * @return Account - varchar(255)
	 */
	public function getAccount(){
		return $this->Account;
	}

	/**
	 * @return IBAN - varchar(255)
	 */
	public function getIBAN(){
		return $this->IBAN;
	}

	/**
	 * @return Active - tinyint(4)
	 */
	public function getActive(){
		return $this->Active;
	}

	/**
	 * @return Prezime - varchar(20)
	 */
	public function getPrezime(){
		return $this->Prezime;
	}

	/**
	 * @return Ime - varchar(20)
	 */
	public function getIme(){
		return $this->Ime;
	}

	/**
	 * @return Email - varchar(50)
	 */
	public function getEmail(){
		return $this->Email;
	}

	/**
	 * @return Opis - text
	 */
	public function getOpis(){
		return $this->Opis;
	}

	/**
	 * @return Discount - decimal(5,2)
	 */
	public function getDiscount(){
		return $this->Discount;
	}

	/**
	 * @param Type: int(3) unsigned
	 */
	public function setSiteID($SiteID){
		$this->SiteID = $SiteID;
	}

	/**
	 * @param Type: int(5) unsigned
	 */
	public function setDriverID($DriverID){
		$this->DriverID = $DriverID;
	}

	/**
	 * @param Type: varchar(5)
	 */
	public function setCountry($Country){
		$this->Country = $Country;
	}

	/**
	 * @param Type: varchar(255)
	 */
	public function setCompany($Company){
		$this->Company = $Company;
	}

	/**
	 * @param Type: varchar(255)
	 */
	public function setTel($Tel){
		$this->Tel = $Tel;
	}

	/**
	 * @param Type: varchar(255)
	 */
	public function setFax($Fax){
		$this->Fax = $Fax;
	}

	/**
	 * @param Type: varchar(255)
	 */
	public function setCity($City){
		$this->City = $City;
	}

	/**
	 * @param Type: varchar(255)
	 */
	public function setTerminal($Terminal){
		$this->Terminal = $Terminal;
	}

	/**
	 * @param Type: varchar(255)
	 */
	public function setAccount($Account){
		$this->Account = $Account;
	}

	/**
	 * @param Type: varchar(255)
	 */
	public function setIBAN($IBAN){
		$this->IBAN = $IBAN;
	}

	/**
	 * @param Type: tinyint(4)
	 */
	public function setActive($Active){
		$this->Active = $Active;
	}

	/**
	 * @param Type: varchar(20)
	 */
	public function setPrezime($Prezime){
		$this->Prezime = $Prezime;
	}

	/**
	 * @param Type: varchar(20)
	 */
	public function setIme($Ime){
		$this->Ime = $Ime;
	}

	/**
	 * @param Type: varchar(50)
	 */
	public function setEmail($Email){
		$this->Email = $Email;
	}

	/**
	 * @param Type: text
	 */
	public function setOpis($Opis){
		$this->Opis = $Opis;
	}

	/**
	 * @param Type: decimal(5,2)
	 */
	public function setDiscount($Discount){
		$this->Discount = $Discount;
	}

    /**
     * fieldValues - Load all fieldNames and fieldValues into Array. 
     *
     * @param 
     * 
     */
	public function fieldValues(){
		$fieldValues = array(
			'SiteID' => $this->getSiteID(),
			'DriverID' => $this->getDriverID(),
			'Country' => $this->getCountry(),
			'Company' => $this->getCompany(),
			'Tel' => $this->getTel(),
			'Fax' => $this->getFax(),
			'City' => $this->getCity(),
			'Terminal' => $this->getTerminal(),
			'Account' => $this->getAccount(),
			'IBAN' => $this->getIBAN(),
			'Active' => $this->getActive(),
			'Prezime' => $this->getPrezime(),
			'Ime' => $this->getIme(),
			'Email' => $this->getEmail(),
			'Opis' => $this->getOpis(),
			'Discount' => $this->getDiscount()		);
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
			'SiteID',			'DriverID',			'Country',			'Company',			'Tel',			'Fax',			'City',			'Terminal',			'Account',			'IBAN',			'Active',			'Prezime',			'Ime',			'Email',			'Opis',			'Discount'		);
		return $fieldNames;
	}
    /**
     * Close mysql connection
     */
	public function endv4_Drivers(){
		$this->connection->CloseMysql();
	}

}