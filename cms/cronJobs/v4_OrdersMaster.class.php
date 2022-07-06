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
Class v4_OrdersMaster {

	public $SiteID; //int(3) unsigned
	public $MOrderKey; //varchar(100)
	public $MOrderID; //int(10) unsigned
	public $MOrderStatus; //tinyint(3) unsigned
	public $MOrderType; //tinyint(3) unsigned
	public $MOrderDate; //varchar(50)
	public $MOrderTime; //varchar(15)
	public $MUserID; //int(10) unsigned
	public $MUserLevelID; //tinyint(3) unsigned
	public $MTransferPrice; //decimal(10,2)
	public $MDriverExtrasPrice; //decimal(10,2)
	public $MProvision; //decimal(10,2)
	public $MExtrasPrice; //decimal(10,2)
	public $MOrderPriceEUR; //decimal(10,2) unsigned
	public $MEurToCurrencyRate; //decimal(10,6) unsigned
	public $MOrderCurrencyPrice; //decimal(10,2) unsigned
	public $MOrderCurrency; //varchar(6)
	public $MPaymentMethod; //tinyint(3) unsigned
	public $MPaymentStatus; //tinyint(3) unsigned
	public $MPayNow; //decimal(10,2) unsigned
	public $MPayLater; //decimal(10,2) unsigned
	public $MInvoiceAmount; //decimal(10,2) unsigned
	public $MAgentCommision; //decimal(10,2) unsigned
	public $MCustomerID; //int(10) unsigned
	public $MPaxFirstName; //varchar(100)
	public $MPaxLastName; //varchar(100)
	public $MPaxTel; //varchar(100)
	public $MPaxEmail; //varchar(100)
	public $MCardType; //varchar(100)
	public $MCardFirstName; //varchar(100)
	public $MCardLastName; //varchar(100)
	public $MCardEmail; //varchar(100)
	public $MCardTel; //varchar(50)
	public $MCardAddress; //varchar(100)
	public $MCardCity; //varchar(100)
	public $MCardZip; //varchar(50)
	public $MCardCountry; //varchar(100)
	public $MCardNumber; //varchar(20)
	public $MCardCVD; //varchar(5)
	public $MCardExpDate; //varchar(10)
	public $MConfirmFile; //varchar(100)
	public $MCancelFile; //varchar(100)
	public $MChangeFile; //varchar(100)
	public $MSubscribe; //tinyint(1)
	public $MAcceptTerms; //tinyint(1)
	public $MSendEmail; //tinyint(1)
	public $MEmailSentDate; //varchar(15)
	public $MCustomerIP; //varchar(255)
	public $MOrderLang; //varchar(5)
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
	public function New_v4_OrdersMaster($SiteID,$MOrderKey,$MOrderStatus,$MOrderType,$MOrderDate,$MOrderTime,$MUserID,$MUserLevelID,$MTransferPrice,$MDriverExtrasPrice,$MProvision,$MExtrasPrice,$MOrderPriceEUR,$MEurToCurrencyRate,$MOrderCurrencyPrice,$MOrderCurrency,$MPaymentMethod,$MPaymentStatus,$MPayNow,$MPayLater,$MInvoiceAmount,$MAgentCommision,$MCustomerID,$MPaxFirstName,$MPaxLastName,$MPaxTel,$MPaxEmail,$MCardType,$MCardFirstName,$MCardLastName,$MCardEmail,$MCardTel,$MCardAddress,$MCardCity,$MCardZip,$MCardCountry,$MCardNumber,$MCardCVD,$MCardExpDate,$MConfirmFile,$MCancelFile,$MChangeFile,$MSubscribe,$MAcceptTerms,$MSendEmail,$MEmailSentDate,$MCustomerIP,$MOrderLang){
		$this->SiteID = $SiteID;
		$this->MOrderKey = $MOrderKey;
		$this->MOrderStatus = $MOrderStatus;
		$this->MOrderType = $MOrderType;
		$this->MOrderDate = $MOrderDate;
		$this->MOrderTime = $MOrderTime;
		$this->MUserID = $MUserID;
		$this->MUserLevelID = $MUserLevelID;
		$this->MTransferPrice = $MTransferPrice;
		$this->MDriverExtrasPrice = $MDriverExtrasPrice;
		$this->MProvision = $MProvision;
		$this->MExtrasPrice = $MExtrasPrice;
		$this->MOrderPriceEUR = $MOrderPriceEUR;
		$this->MEurToCurrencyRate = $MEurToCurrencyRate;
		$this->MOrderCurrencyPrice = $MOrderCurrencyPrice;
		$this->MOrderCurrency = $MOrderCurrency;
		$this->MPaymentMethod = $MPaymentMethod;
		$this->MPaymentStatus = $MPaymentStatus;
		$this->MPayNow = $MPayNow;
		$this->MPayLater = $MPayLater;
		$this->MInvoiceAmount = $MInvoiceAmount;
		$this->MAgentCommision = $MAgentCommision;
		$this->MCustomerID = $MCustomerID;
		$this->MPaxFirstName = $MPaxFirstName;
		$this->MPaxLastName = $MPaxLastName;
		$this->MPaxTel = $MPaxTel;
		$this->MPaxEmail = $MPaxEmail;
		$this->MCardType = $MCardType;
		$this->MCardFirstName = $MCardFirstName;
		$this->MCardLastName = $MCardLastName;
		$this->MCardEmail = $MCardEmail;
		$this->MCardTel = $MCardTel;
		$this->MCardAddress = $MCardAddress;
		$this->MCardCity = $MCardCity;
		$this->MCardZip = $MCardZip;
		$this->MCardCountry = $MCardCountry;
		$this->MCardNumber = $MCardNumber;
		$this->MCardCVD = $MCardCVD;
		$this->MCardExpDate = $MCardExpDate;
		$this->MConfirmFile = $MConfirmFile;
		$this->MCancelFile = $MCancelFile;
		$this->MChangeFile = $MChangeFile;
		$this->MSubscribe = $MSubscribe;
		$this->MAcceptTerms = $MAcceptTerms;
		$this->MSendEmail = $MSendEmail;
		$this->MEmailSentDate = $MEmailSentDate;
		$this->MCustomerIP = $MCustomerIP;
		$this->MOrderLang = $MOrderLang;
	}

    /**
     * Load one row into var_class. To use the vars use for exemple echo $class->getVar_name; 
     *
     * @param key_table_type $key_row
     * 
     */
	public function getRow($key_row){
		$result = $this->connection->RunQuery("Select * from v4_OrdersMaster where MOrderID = \"$key_row\" ");
		if($result->num_rows < 1) return false;
		while($row = $result->fetch_array(MYSQLI_ASSOC)){
			$this->SiteID = $row["SiteID"];
			$this->MOrderKey = $row["MOrderKey"];
			$this->MOrderID = $row["MOrderID"];
			$this->MOrderStatus = $row["MOrderStatus"];
			$this->MOrderType = $row["MOrderType"];
			$this->MOrderDate = $row["MOrderDate"];
			$this->MOrderTime = $row["MOrderTime"];
			$this->MUserID = $row["MUserID"];
			$this->MUserLevelID = $row["MUserLevelID"];
			$this->MTransferPrice = $row["MTransferPrice"];
			$this->MDriverExtrasPrice = $row["MDriverExtrasPrice"];
			$this->MProvision = $row["MProvision"];
			$this->MExtrasPrice = $row["MExtrasPrice"];
			$this->MOrderPriceEUR = $row["MOrderPriceEUR"];
			$this->MEurToCurrencyRate = $row["MEurToCurrencyRate"];
			$this->MOrderCurrencyPrice = $row["MOrderCurrencyPrice"];
			$this->MOrderCurrency = $row["MOrderCurrency"];
			$this->MPaymentMethod = $row["MPaymentMethod"];
			$this->MPaymentStatus = $row["MPaymentStatus"];
			$this->MPayNow = $row["MPayNow"];
			$this->MPayLater = $row["MPayLater"];
			$this->MInvoiceAmount = $row["MInvoiceAmount"];
			$this->MAgentCommision = $row["MAgentCommision"];
			$this->MCustomerID = $row["MCustomerID"];
			$this->MPaxFirstName = $row["MPaxFirstName"];
			$this->MPaxLastName = $row["MPaxLastName"];
			$this->MPaxTel = $row["MPaxTel"];
			$this->MPaxEmail = $row["MPaxEmail"];
			$this->MCardType = $row["MCardType"];
			$this->MCardFirstName = $row["MCardFirstName"];
			$this->MCardLastName = $row["MCardLastName"];
			$this->MCardEmail = $row["MCardEmail"];
			$this->MCardTel = $row["MCardTel"];
			$this->MCardAddress = $row["MCardAddress"];
			$this->MCardCity = $row["MCardCity"];
			$this->MCardZip = $row["MCardZip"];
			$this->MCardCountry = $row["MCardCountry"];
			$this->MCardNumber = $row["MCardNumber"];
			$this->MCardCVD = $row["MCardCVD"];
			$this->MCardExpDate = $row["MCardExpDate"];
			$this->MConfirmFile = $row["MConfirmFile"];
			$this->MCancelFile = $row["MCancelFile"];
			$this->MChangeFile = $row["MChangeFile"];
			$this->MSubscribe = $row["MSubscribe"];
			$this->MAcceptTerms = $row["MAcceptTerms"];
			$this->MSendEmail = $row["MSendEmail"];
			$this->MEmailSentDate = $row["MEmailSentDate"];
			$this->MCustomerIP = $row["MCustomerIP"];
			$this->MOrderLang = $row["MOrderLang"];
		}
	}

    /**
     * Delete the row by using the key as arg
     *
     * @param key_table_type $key_row
     *
     */
	public function deleteRow($key_row){
		$this->connection->RunQuery("DELETE FROM v4_OrdersMaster WHERE MOrderID = $key_row");
	}

    /**
     * Update the active row table on table
     */
	public function saveRow(){
		$result = $this->connection->RunQuery("UPDATE v4_OrdersMaster set 
SiteID = '".$this->myreal_escape_string($this->SiteID)."', 
MOrderKey = '".$this->myreal_escape_string($this->MOrderKey)."', 
MOrderStatus = '".$this->myreal_escape_string($this->MOrderStatus)."', 
MOrderType = '".$this->myreal_escape_string($this->MOrderType)."', 
MOrderDate = '".$this->myreal_escape_string($this->MOrderDate)."', 
MOrderTime = '".$this->myreal_escape_string($this->MOrderTime)."', 
MUserID = '".$this->myreal_escape_string($this->MUserID)."', 
MUserLevelID = '".$this->myreal_escape_string($this->MUserLevelID)."', 
MTransferPrice = '".$this->myreal_escape_string($this->MTransferPrice)."', 
MDriverExtrasPrice = '".$this->myreal_escape_string($this->MDriverExtrasPrice)."', 
MProvision = '".$this->myreal_escape_string($this->MProvision)."', 
MExtrasPrice = '".$this->myreal_escape_string($this->MExtrasPrice)."', 
MOrderPriceEUR = '".$this->myreal_escape_string($this->MOrderPriceEUR)."', 
MEurToCurrencyRate = '".$this->myreal_escape_string($this->MEurToCurrencyRate)."', 
MOrderCurrencyPrice = '".$this->myreal_escape_string($this->MOrderCurrencyPrice)."', 
MOrderCurrency = '".$this->myreal_escape_string($this->MOrderCurrency)."', 
MPaymentMethod = '".$this->myreal_escape_string($this->MPaymentMethod)."', 
MPaymentStatus = '".$this->myreal_escape_string($this->MPaymentStatus)."', 
MPayNow = '".$this->myreal_escape_string($this->MPayNow)."', 
MPayLater = '".$this->myreal_escape_string($this->MPayLater)."', 
MInvoiceAmount = '".$this->myreal_escape_string($this->MInvoiceAmount)."', 
MAgentCommision = '".$this->myreal_escape_string($this->MAgentCommision)."', 
MCustomerID = '".$this->myreal_escape_string($this->MCustomerID)."', 
MPaxFirstName = '".$this->myreal_escape_string($this->MPaxFirstName)."', 
MPaxLastName = '".$this->myreal_escape_string($this->MPaxLastName)."', 
MPaxTel = '".$this->myreal_escape_string($this->MPaxTel)."', 
MPaxEmail = '".$this->myreal_escape_string($this->MPaxEmail)."', 
MCardType = '".$this->myreal_escape_string($this->MCardType)."', 
MCardFirstName = '".$this->myreal_escape_string($this->MCardFirstName)."', 
MCardLastName = '".$this->myreal_escape_string($this->MCardLastName)."', 
MCardEmail = '".$this->myreal_escape_string($this->MCardEmail)."', 
MCardTel = '".$this->myreal_escape_string($this->MCardTel)."', 
MCardAddress = '".$this->myreal_escape_string($this->MCardAddress)."', 
MCardCity = '".$this->myreal_escape_string($this->MCardCity)."', 
MCardZip = '".$this->myreal_escape_string($this->MCardZip)."', 
MCardCountry = '".$this->myreal_escape_string($this->MCardCountry)."', 
MCardNumber = '".$this->myreal_escape_string($this->MCardNumber)."', 
MCardCVD = '".$this->myreal_escape_string($this->MCardCVD)."', 
MCardExpDate = '".$this->myreal_escape_string($this->MCardExpDate)."', 
MConfirmFile = '".$this->myreal_escape_string($this->MConfirmFile)."', 
MCancelFile = '".$this->myreal_escape_string($this->MCancelFile)."', 
MChangeFile = '".$this->myreal_escape_string($this->MChangeFile)."', 
MSubscribe = '".$this->myreal_escape_string($this->MSubscribe)."', 
MAcceptTerms = '".$this->myreal_escape_string($this->MAcceptTerms)."', 
MSendEmail = '".$this->myreal_escape_string($this->MSendEmail)."', 
MEmailSentDate = '".$this->myreal_escape_string($this->MEmailSentDate)."', 
MCustomerIP = '".$this->myreal_escape_string($this->MCustomerIP)."', 
MOrderLang = '".$this->myreal_escape_string($this->MOrderLang)."' WHERE MOrderID = '".$this->MOrderID."'");
	return $result; 
}

    /**
     * Save the active var class as a new row on table
     */
	public function saveAsNew(){
		$this->connection->RunQuery("INSERT INTO v4_OrdersMaster (SiteID, MOrderKey, MOrderStatus, MOrderType, MOrderDate, MOrderTime, MUserID, MUserLevelID, MTransferPrice, MDriverExtrasPrice, MProvision, MExtrasPrice, MOrderPriceEUR, MEurToCurrencyRate, MOrderCurrencyPrice, MOrderCurrency, MPaymentMethod, MPaymentStatus, MPayNow, MPayLater, MInvoiceAmount, MAgentCommision, MCustomerID, MPaxFirstName, MPaxLastName, MPaxTel, MPaxEmail, MCardType, MCardFirstName, MCardLastName, MCardEmail, MCardTel, MCardAddress, MCardCity, MCardZip, MCardCountry, MCardNumber, MCardCVD, MCardExpDate, MConfirmFile, MCancelFile, MChangeFile, MSubscribe, MAcceptTerms, MSendEmail, MEmailSentDate, MCustomerIP, MOrderLang) values ('".$this->myreal_escape_string($this->SiteID)."', '".$this->myreal_escape_string($this->MOrderKey)."', '".$this->myreal_escape_string($this->MOrderStatus)."', '".$this->myreal_escape_string($this->MOrderType)."', '".$this->myreal_escape_string($this->MOrderDate)."', '".$this->myreal_escape_string($this->MOrderTime)."', '".$this->myreal_escape_string($this->MUserID)."', '".$this->myreal_escape_string($this->MUserLevelID)."', '".$this->myreal_escape_string($this->MTransferPrice)."', '".$this->myreal_escape_string($this->MDriverExtrasPrice)."', '".$this->myreal_escape_string($this->MProvision)."', '".$this->myreal_escape_string($this->MExtrasPrice)."', '".$this->myreal_escape_string($this->MOrderPriceEUR)."', '".$this->myreal_escape_string($this->MEurToCurrencyRate)."', '".$this->myreal_escape_string($this->MOrderCurrencyPrice)."', '".$this->myreal_escape_string($this->MOrderCurrency)."', '".$this->myreal_escape_string($this->MPaymentMethod)."', '".$this->myreal_escape_string($this->MPaymentStatus)."', '".$this->myreal_escape_string($this->MPayNow)."', '".$this->myreal_escape_string($this->MPayLater)."', '".$this->myreal_escape_string($this->MInvoiceAmount)."', '".$this->myreal_escape_string($this->MAgentCommision)."', '".$this->myreal_escape_string($this->MCustomerID)."', '".$this->myreal_escape_string($this->MPaxFirstName)."', '".$this->myreal_escape_string($this->MPaxLastName)."', '".$this->myreal_escape_string($this->MPaxTel)."', '".$this->myreal_escape_string($this->MPaxEmail)."', '".$this->myreal_escape_string($this->MCardType)."', '".$this->myreal_escape_string($this->MCardFirstName)."', '".$this->myreal_escape_string($this->MCardLastName)."', '".$this->myreal_escape_string($this->MCardEmail)."', '".$this->myreal_escape_string($this->MCardTel)."', '".$this->myreal_escape_string($this->MCardAddress)."', '".$this->myreal_escape_string($this->MCardCity)."', '".$this->myreal_escape_string($this->MCardZip)."', '".$this->myreal_escape_string($this->MCardCountry)."', '".$this->myreal_escape_string($this->MCardNumber)."', '".$this->myreal_escape_string($this->MCardCVD)."', '".$this->myreal_escape_string($this->MCardExpDate)."', '".$this->myreal_escape_string($this->MConfirmFile)."', '".$this->myreal_escape_string($this->MCancelFile)."', '".$this->myreal_escape_string($this->MChangeFile)."', '".$this->myreal_escape_string($this->MSubscribe)."', '".$this->myreal_escape_string($this->MAcceptTerms)."', '".$this->myreal_escape_string($this->MSendEmail)."', '".$this->myreal_escape_string($this->MEmailSentDate)."', '".$this->myreal_escape_string($this->MCustomerIP)."', '".$this->myreal_escape_string($this->MOrderLang)."')");
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
		$result = $this->connection->RunQuery("SELECT MOrderID from v4_OrdersMaster $where ORDER BY $column $order");
			while($row = $result->fetch_array(MYSQLI_ASSOC)){
				$keys[$i] = $row["MOrderID"];
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
	 * @return MOrderKey - varchar(100)
	 */
	public function getMOrderKey(){
		return $this->MOrderKey;
	}

	/**
	 * @return MOrderID - int(10) unsigned
	 */
	public function getMOrderID(){
		return $this->MOrderID;
	}

	/**
	 * @return MOrderStatus - tinyint(3) unsigned
	 */
	public function getMOrderStatus(){
		return $this->MOrderStatus;
	}

	/**
	 * @return MOrderType - tinyint(3) unsigned
	 */
	public function getMOrderType(){
		return $this->MOrderType;
	}

	/**
	 * @return MOrderDate - varchar(50)
	 */
	public function getMOrderDate(){
		return $this->MOrderDate;
	}

	/**
	 * @return MOrderTime - varchar(15)
	 */
	public function getMOrderTime(){
		return $this->MOrderTime;
	}

	/**
	 * @return MUserID - int(10) unsigned
	 */
	public function getMUserID(){
		return $this->MUserID;
	}

	/**
	 * @return MUserLevelID - tinyint(3) unsigned
	 */
	public function getMUserLevelID(){
		return $this->MUserLevelID;
	}

	/**
	 * @return MTransferPrice - decimal(10,2)
	 */
	public function getMTransferPrice(){
		return $this->MTransferPrice;
	}

	/**
	 * @return MDriverExtrasPrice - decimal(10,2)
	 */
	public function getMDriverExtrasPrice(){
		return $this->MDriverExtrasPrice;
	}

	/**
	 * @return MProvision - decimal(10,2)
	 */
	public function getMProvision(){
		return $this->MProvision;
	}

	/**
	 * @return MExtrasPrice - decimal(10,2)
	 */
	public function getMExtrasPrice(){
		return $this->MExtrasPrice;
	}

	/**
	 * @return MOrderPriceEUR - decimal(10,2) unsigned
	 */
	public function getMOrderPriceEUR(){
		return $this->MOrderPriceEUR;
	}

	/**
	 * @return MEurToCurrencyRate - decimal(10,6) unsigned
	 */
	public function getMEurToCurrencyRate(){
		return $this->MEurToCurrencyRate;
	}

	/**
	 * @return MOrderCurrencyPrice - decimal(10,2) unsigned
	 */
	public function getMOrderCurrencyPrice(){
		return $this->MOrderCurrencyPrice;
	}

	/**
	 * @return MOrderCurrency - varchar(6)
	 */
	public function getMOrderCurrency(){
		return $this->MOrderCurrency;
	}

	/**
	 * @return MPaymentMethod - tinyint(3) unsigned
	 */
	public function getMPaymentMethod(){
		return $this->MPaymentMethod;
	}

	/**
	 * @return MPaymentStatus - tinyint(3) unsigned
	 */
	public function getMPaymentStatus(){
		return $this->MPaymentStatus;
	}

	/**
	 * @return MPayNow - decimal(10,2) unsigned
	 */
	public function getMPayNow(){
		return $this->MPayNow;
	}

	/**
	 * @return MPayLater - decimal(10,2) unsigned
	 */
	public function getMPayLater(){
		return $this->MPayLater;
	}

	/**
	 * @return MInvoiceAmount - decimal(10,2) unsigned
	 */
	public function getMInvoiceAmount(){
		return $this->MInvoiceAmount;
	}

	/**
	 * @return MAgentCommision - decimal(10,2) unsigned
	 */
	public function getMAgentCommision(){
		return $this->MAgentCommision;
	}

	/**
	 * @return MCustomerID - int(10) unsigned
	 */
	public function getMCustomerID(){
		return $this->MCustomerID;
	}

	/**
	 * @return MPaxFirstName - varchar(100)
	 */
	public function getMPaxFirstName(){
		return $this->MPaxFirstName;
	}

	/**
	 * @return MPaxLastName - varchar(100)
	 */
	public function getMPaxLastName(){
		return $this->MPaxLastName;
	}

	/**
	 * @return MPaxTel - varchar(100)
	 */
	public function getMPaxTel(){
		return $this->MPaxTel;
	}

	/**
	 * @return MPaxEmail - varchar(100)
	 */
	public function getMPaxEmail(){
		return $this->MPaxEmail;
	}

	/**
	 * @return MCardType - varchar(100)
	 */
	public function getMCardType(){
		return $this->MCardType;
	}

	/**
	 * @return MCardFirstName - varchar(100)
	 */
	public function getMCardFirstName(){
		return $this->MCardFirstName;
	}

	/**
	 * @return MCardLastName - varchar(100)
	 */
	public function getMCardLastName(){
		return $this->MCardLastName;
	}

	/**
	 * @return MCardEmail - varchar(100)
	 */
	public function getMCardEmail(){
		return $this->MCardEmail;
	}

	/**
	 * @return MCardTel - varchar(50)
	 */
	public function getMCardTel(){
		return $this->MCardTel;
	}

	/**
	 * @return MCardAddress - varchar(100)
	 */
	public function getMCardAddress(){
		return $this->MCardAddress;
	}

	/**
	 * @return MCardCity - varchar(100)
	 */
	public function getMCardCity(){
		return $this->MCardCity;
	}

	/**
	 * @return MCardZip - varchar(50)
	 */
	public function getMCardZip(){
		return $this->MCardZip;
	}

	/**
	 * @return MCardCountry - varchar(100)
	 */
	public function getMCardCountry(){
		return $this->MCardCountry;
	}

	/**
	 * @return MCardNumber - varchar(20)
	 */
	public function getMCardNumber(){
		return $this->MCardNumber;
	}

	/**
	 * @return MCardCVD - varchar(5)
	 */
	public function getMCardCVD(){
		return $this->MCardCVD;
	}

	/**
	 * @return MCardExpDate - varchar(10)
	 */
	public function getMCardExpDate(){
		return $this->MCardExpDate;
	}

	/**
	 * @return MConfirmFile - varchar(100)
	 */
	public function getMConfirmFile(){
		return $this->MConfirmFile;
	}

	/**
	 * @return MCancelFile - varchar(100)
	 */
	public function getMCancelFile(){
		return $this->MCancelFile;
	}

	/**
	 * @return MChangeFile - varchar(100)
	 */
	public function getMChangeFile(){
		return $this->MChangeFile;
	}

	/**
	 * @return MSubscribe - tinyint(1)
	 */
	public function getMSubscribe(){
		return $this->MSubscribe;
	}

	/**
	 * @return MAcceptTerms - tinyint(1)
	 */
	public function getMAcceptTerms(){
		return $this->MAcceptTerms;
	}

	/**
	 * @return MSendEmail - tinyint(1)
	 */
	public function getMSendEmail(){
		return $this->MSendEmail;
	}

	/**
	 * @return MEmailSentDate - varchar(15)
	 */
	public function getMEmailSentDate(){
		return $this->MEmailSentDate;
	}

	/**
	 * @return MCustomerIP - varchar(255)
	 */
	public function getMCustomerIP(){
		return $this->MCustomerIP;
	}

	/**
	 * @return MOrderLang - varchar(5)
	 */
	public function getMOrderLang(){
		return $this->MOrderLang;
	}

	/**
	 * @param Type: int(3) unsigned
	 */
	public function setSiteID($SiteID){
		$this->SiteID = $SiteID;
	}

	/**
	 * @param Type: varchar(100)
	 */
	public function setMOrderKey($MOrderKey){
		$this->MOrderKey = $MOrderKey;
	}

	/**
	 * @param Type: int(10) unsigned
	 */
	public function setMOrderID($MOrderID){
		$this->MOrderID = $MOrderID;
	}

	/**
	 * @param Type: tinyint(3) unsigned
	 */
	public function setMOrderStatus($MOrderStatus){
		$this->MOrderStatus = $MOrderStatus;
	}

	/**
	 * @param Type: tinyint(3) unsigned
	 */
	public function setMOrderType($MOrderType){
		$this->MOrderType = $MOrderType;
	}

	/**
	 * @param Type: varchar(50)
	 */
	public function setMOrderDate($MOrderDate){
		$this->MOrderDate = $MOrderDate;
	}

	/**
	 * @param Type: varchar(15)
	 */
	public function setMOrderTime($MOrderTime){
		$this->MOrderTime = $MOrderTime;
	}

	/**
	 * @param Type: int(10) unsigned
	 */
	public function setMUserID($MUserID){
		$this->MUserID = $MUserID;
	}

	/**
	 * @param Type: tinyint(3) unsigned
	 */
	public function setMUserLevelID($MUserLevelID){
		$this->MUserLevelID = $MUserLevelID;
	}

	/**
	 * @param Type: decimal(10,2)
	 */
	public function setMTransferPrice($MTransferPrice){
		$this->MTransferPrice = $MTransferPrice;
	}

	/**
	 * @param Type: decimal(10,2)
	 */
	public function setMDriverExtrasPrice($MDriverExtrasPrice){
		$this->MDriverExtrasPrice = $MDriverExtrasPrice;
	}

	/**
	 * @param Type: decimal(10,2)
	 */
	public function setMProvision($MProvision){
		$this->MProvision = $MProvision;
	}

	/**
	 * @param Type: decimal(10,2)
	 */
	public function setMExtrasPrice($MExtrasPrice){
		$this->MExtrasPrice = $MExtrasPrice;
	}

	/**
	 * @param Type: decimal(10,2) unsigned
	 */
	public function setMOrderPriceEUR($MOrderPriceEUR){
		$this->MOrderPriceEUR = $MOrderPriceEUR;
	}

	/**
	 * @param Type: decimal(10,6) unsigned
	 */
	public function setMEurToCurrencyRate($MEurToCurrencyRate){
		$this->MEurToCurrencyRate = $MEurToCurrencyRate;
	}

	/**
	 * @param Type: decimal(10,2) unsigned
	 */
	public function setMOrderCurrencyPrice($MOrderCurrencyPrice){
		$this->MOrderCurrencyPrice = $MOrderCurrencyPrice;
	}

	/**
	 * @param Type: varchar(6)
	 */
	public function setMOrderCurrency($MOrderCurrency){
		$this->MOrderCurrency = $MOrderCurrency;
	}

	/**
	 * @param Type: tinyint(3) unsigned
	 */
	public function setMPaymentMethod($MPaymentMethod){
		$this->MPaymentMethod = $MPaymentMethod;
	}

	/**
	 * @param Type: tinyint(3) unsigned
	 */
	public function setMPaymentStatus($MPaymentStatus){
		$this->MPaymentStatus = $MPaymentStatus;
	}

	/**
	 * @param Type: decimal(10,2) unsigned
	 */
	public function setMPayNow($MPayNow){
		$this->MPayNow = $MPayNow;
	}

	/**
	 * @param Type: decimal(10,2) unsigned
	 */
	public function setMPayLater($MPayLater){
		$this->MPayLater = $MPayLater;
	}

	/**
	 * @param Type: decimal(10,2) unsigned
	 */
	public function setMInvoiceAmount($MInvoiceAmount){
		$this->MInvoiceAmount = $MInvoiceAmount;
	}

	/**
	 * @param Type: decimal(10,2) unsigned
	 */
	public function setMAgentCommision($MAgentCommision){
		$this->MAgentCommision = $MAgentCommision;
	}

	/**
	 * @param Type: int(10) unsigned
	 */
	public function setMCustomerID($MCustomerID){
		$this->MCustomerID = $MCustomerID;
	}

	/**
	 * @param Type: varchar(100)
	 */
	public function setMPaxFirstName($MPaxFirstName){
		$this->MPaxFirstName = $MPaxFirstName;
	}

	/**
	 * @param Type: varchar(100)
	 */
	public function setMPaxLastName($MPaxLastName){
		$this->MPaxLastName = $MPaxLastName;
	}

	/**
	 * @param Type: varchar(100)
	 */
	public function setMPaxTel($MPaxTel){
		$this->MPaxTel = $MPaxTel;
	}

	/**
	 * @param Type: varchar(100)
	 */
	public function setMPaxEmail($MPaxEmail){
		$this->MPaxEmail = $MPaxEmail;
	}

	/**
	 * @param Type: varchar(100)
	 */
	public function setMCardType($MCardType){
		$this->MCardType = $MCardType;
	}

	/**
	 * @param Type: varchar(100)
	 */
	public function setMCardFirstName($MCardFirstName){
		$this->MCardFirstName = $MCardFirstName;
	}

	/**
	 * @param Type: varchar(100)
	 */
	public function setMCardLastName($MCardLastName){
		$this->MCardLastName = $MCardLastName;
	}

	/**
	 * @param Type: varchar(100)
	 */
	public function setMCardEmail($MCardEmail){
		$this->MCardEmail = $MCardEmail;
	}

	/**
	 * @param Type: varchar(50)
	 */
	public function setMCardTel($MCardTel){
		$this->MCardTel = $MCardTel;
	}

	/**
	 * @param Type: varchar(100)
	 */
	public function setMCardAddress($MCardAddress){
		$this->MCardAddress = $MCardAddress;
	}

	/**
	 * @param Type: varchar(100)
	 */
	public function setMCardCity($MCardCity){
		$this->MCardCity = $MCardCity;
	}

	/**
	 * @param Type: varchar(50)
	 */
	public function setMCardZip($MCardZip){
		$this->MCardZip = $MCardZip;
	}

	/**
	 * @param Type: varchar(100)
	 */
	public function setMCardCountry($MCardCountry){
		$this->MCardCountry = $MCardCountry;
	}

	/**
	 * @param Type: varchar(20)
	 */
	public function setMCardNumber($MCardNumber){
		$this->MCardNumber = $MCardNumber;
	}

	/**
	 * @param Type: varchar(5)
	 */
	public function setMCardCVD($MCardCVD){
		$this->MCardCVD = $MCardCVD;
	}

	/**
	 * @param Type: varchar(10)
	 */
	public function setMCardExpDate($MCardExpDate){
		$this->MCardExpDate = $MCardExpDate;
	}

	/**
	 * @param Type: varchar(100)
	 */
	public function setMConfirmFile($MConfirmFile){
		$this->MConfirmFile = $MConfirmFile;
	}

	/**
	 * @param Type: varchar(100)
	 */
	public function setMCancelFile($MCancelFile){
		$this->MCancelFile = $MCancelFile;
	}

	/**
	 * @param Type: varchar(100)
	 */
	public function setMChangeFile($MChangeFile){
		$this->MChangeFile = $MChangeFile;
	}

	/**
	 * @param Type: tinyint(1)
	 */
	public function setMSubscribe($MSubscribe){
		$this->MSubscribe = $MSubscribe;
	}

	/**
	 * @param Type: tinyint(1)
	 */
	public function setMAcceptTerms($MAcceptTerms){
		$this->MAcceptTerms = $MAcceptTerms;
	}

	/**
	 * @param Type: tinyint(1)
	 */
	public function setMSendEmail($MSendEmail){
		$this->MSendEmail = $MSendEmail;
	}

	/**
	 * @param Type: varchar(15)
	 */
	public function setMEmailSentDate($MEmailSentDate){
		$this->MEmailSentDate = $MEmailSentDate;
	}

	/**
	 * @param Type: varchar(255)
	 */
	public function setMCustomerIP($MCustomerIP){
		$this->MCustomerIP = $MCustomerIP;
	}

	/**
	 * @param Type: varchar(5)
	 */
	public function setMOrderLang($MOrderLang){
		$this->MOrderLang = $MOrderLang;
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
			'MOrderKey' => $this->getMOrderKey(),
			'MOrderID' => $this->getMOrderID(),
			'MOrderStatus' => $this->getMOrderStatus(),
			'MOrderType' => $this->getMOrderType(),
			'MOrderDate' => $this->getMOrderDate(),
			'MOrderTime' => $this->getMOrderTime(),
			'MUserID' => $this->getMUserID(),
			'MUserLevelID' => $this->getMUserLevelID(),
			'MTransferPrice' => $this->getMTransferPrice(),
			'MDriverExtrasPrice' => $this->getMDriverExtrasPrice(),
			'MProvision' => $this->getMProvision(),
			'MExtrasPrice' => $this->getMExtrasPrice(),
			'MOrderPriceEUR' => $this->getMOrderPriceEUR(),
			'MEurToCurrencyRate' => $this->getMEurToCurrencyRate(),
			'MOrderCurrencyPrice' => $this->getMOrderCurrencyPrice(),
			'MOrderCurrency' => $this->getMOrderCurrency(),
			'MPaymentMethod' => $this->getMPaymentMethod(),
			'MPaymentStatus' => $this->getMPaymentStatus(),
			'MPayNow' => $this->getMPayNow(),
			'MPayLater' => $this->getMPayLater(),
			'MInvoiceAmount' => $this->getMInvoiceAmount(),
			'MAgentCommision' => $this->getMAgentCommision(),
			'MCustomerID' => $this->getMCustomerID(),
			'MPaxFirstName' => $this->getMPaxFirstName(),
			'MPaxLastName' => $this->getMPaxLastName(),
			'MPaxTel' => $this->getMPaxTel(),
			'MPaxEmail' => $this->getMPaxEmail(),
			'MCardType' => $this->getMCardType(),
			'MCardFirstName' => $this->getMCardFirstName(),
			'MCardLastName' => $this->getMCardLastName(),
			'MCardEmail' => $this->getMCardEmail(),
			'MCardTel' => $this->getMCardTel(),
			'MCardAddress' => $this->getMCardAddress(),
			'MCardCity' => $this->getMCardCity(),
			'MCardZip' => $this->getMCardZip(),
			'MCardCountry' => $this->getMCardCountry(),
			'MCardNumber' => $this->getMCardNumber(),
			'MCardCVD' => $this->getMCardCVD(),
			'MCardExpDate' => $this->getMCardExpDate(),
			'MConfirmFile' => $this->getMConfirmFile(),
			'MCancelFile' => $this->getMCancelFile(),
			'MChangeFile' => $this->getMChangeFile(),
			'MSubscribe' => $this->getMSubscribe(),
			'MAcceptTerms' => $this->getMAcceptTerms(),
			'MSendEmail' => $this->getMSendEmail(),
			'MEmailSentDate' => $this->getMEmailSentDate(),
			'MCustomerIP' => $this->getMCustomerIP(),
			'MOrderLang' => $this->getMOrderLang()		);
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
			'SiteID',			'MOrderKey',			'MOrderID',			'MOrderStatus',			'MOrderType',			'MOrderDate',			'MOrderTime',			'MUserID',			'MUserLevelID',			'MTransferPrice',			'MDriverExtrasPrice',			'MProvision',			'MExtrasPrice',			'MOrderPriceEUR',			'MEurToCurrencyRate',			'MOrderCurrencyPrice',			'MOrderCurrency',			'MPaymentMethod',			'MPaymentStatus',			'MPayNow',			'MPayLater',			'MInvoiceAmount',			'MAgentCommision',			'MCustomerID',			'MPaxFirstName',			'MPaxLastName',			'MPaxTel',			'MPaxEmail',			'MCardType',			'MCardFirstName',			'MCardLastName',			'MCardEmail',			'MCardTel',			'MCardAddress',			'MCardCity',			'MCardZip',			'MCardCountry',			'MCardNumber',			'MCardCVD',			'MCardExpDate',			'MConfirmFile',			'MCancelFile',			'MChangeFile',			'MSubscribe',			'MAcceptTerms',			'MSendEmail',			'MEmailSentDate',			'MCustomerIP',			'MOrderLang'		);
		return $fieldNames;
	}
    /**
     * Close mysql connection
     */
	public function endv4_OrdersMaster(){
		$this->connection->CloseMysql();
	}

}