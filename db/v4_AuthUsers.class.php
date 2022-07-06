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

Class v4_AuthUsers {

	public $AuthUserID; //int(10) unsigned
	public $AuthLevelID; //int(10) unsigned
	public $Terminal; //varchar(255)
	public $Country; //varchar(5)
	public $ReturnDiscount; //decimal(6,2)
	public $Provision; //int(11)
	public $AuthUserRealName; //varchar(100)
	public $AuthUserName; //varchar(32)
	public $AuthUserCompany; //varchar(100)
	public $DriverID; //int(11)
	public $BrandName; //varchar(255)
	public $ContactPerson; //varchar(255)
	public $AuthUserCompanyMB; //varchar(200)
	public $AuthCoAddress; //text
	public $City; //varchar(255)
	public $Zip; //varchar(255)
	public $CountryName; //varchar(255)
	public $CountryID; //tinyint(4)
	public $AuthUserTel; //varchar(50)
	public $AuthUserMob; //varchar(50)
	public $EmergencyPhone; //varchar(255)
	public $AuthUserFax; //varchar(50)
	public $AuthUserMail; //varchar(200)
	public $AuthUserCoDesc; //text
	public $AuthUserNote; //text
	public $AuthUserNote1; //text	
	public $AccountBank; //varchar(255)
	public $AccountOwner; //varchar(255)
	public $SWIFT; //varchar(255)
	public $IBAN; //varchar(34)
	public $AuthUserPass; //varchar(32)
	public $AuthUserCompanyWeb; //varchar(500)
	public $AuthUserFacebook; //varchar(255)
	public $AuthUserTwitter; //varchar(255)
	public $AuthUserLinkedIn; //varchar(255)
	public $AuthUserGooglePlus; //varchar(255)
	public $DateAdded; //date
	public $LastVisited; //timestamp
	public $Image; //varchar(255)
	public $Temp_pass; //varchar(55)
	public $Temp_pass_active; //tinyint(1)
	public $Level_access; //int(11)
	public $Random_key; //varchar(32)
	public $ContractFile; //varchar(255)
	public $ContractDate; //varchar(15)
	public $ContractSignature; //varchar(255)
	public $DBImage; //mediumblob
	public $DBImageType; //varchar(255)
	public $Language; //varchar(100)
	public $Active; //int(11)
	public $AcceptedPayment; //int(2)
	public $R1Low; //int(5)
	public $R1Hi; //int(5)
	public $R1Percent; //decimal(6,2)
	public $R2Low; //int(5)
	public $R2Hi; //int(5)
	public $R2Percent; //decimal(6,2)
	public $R3Low; //int(5)
	public $R3Hi; //int(5)
	public $R3Percent; //decimal(6,2)
	public $PR1Low; //int(5)
	public $PR1Hi; //int(5)
	public $PR1Percent; //decimal(6,2)
	public $PR2Low; //int(5)
	public $PR2Hi; //int(5)
	public $PR2Percent; //decimal(6,2)
	public $PR3Low; //int(5)
	public $PR3Hi; //int(5)
	public $PR3Percent; //decimal(6,2)
	public $FR1Low; //int(5)
	public $FR1Hi; //int(5)
	public $FR1Percent; //decimal(6,2)
	public $FR2Low; //int(5)
	public $FR2Hi; //int(5)
	public $FR2Percent; //decimal(6,2)
	public $FR3Low; //int(5)
	public $FR3Hi; //int(5)
	public $FR3Percent; //decimal(6,2)
	public $NoteToDriver; //varchar(255)
	public $Balance; //int(11)
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
	public function New_v4_AuthUsers($AuthLevelID,$Terminal,$Country,$ReturnDiscount,$Provision,$AuthUserRealName,$AuthUserName,$AuthUserCompany,$DriverID,$BrandName,$ContactPerson,$AuthUserCompanyMB,$AuthCoAddress,$City,$Zip,$CountryName,$CountryID,$AuthUserTel,$AuthUserMob,$EmergencyPhone,$AuthUserFax,$AuthUserMail,$AuthUserCoDesc,$AuthUserNote,$AuthUserNote1,$AccountBank,$AccountOwner,$SWIFT,$IBAN,$AuthUserPass,$AuthUserCompanyWeb,$AuthUserFacebook,$AuthUserTwitter,$AuthUserLinkedIn,$AuthUserGooglePlus,$DateAdded,$LastVisited,$Image,$Temp_pass,$Temp_pass_active,$Level_access,$Random_key,$ContractFile,$ContractDate,$ContractSignature,$DBImage,$DBImageType,$Language,$Active,$AcceptedPayment,$R1Low,$R1Hi,$R1Percent,$R2Low,$R2Hi,$R2Percent,$R3Low,$R3Hi,$R3Percent,$PR1Low,$PR1Hi,$PR1Percent,$PR2Low,$PR2Hi,$PR2Percent,$PR3Low,$PR3Hi,$PR3Percent,$FR1Low,$FR1Hi,$FR1Percent,$FR2Low,$FR2Hi,$FR2Percent,$FR3Low,$FR3Hi,$FR3Percent,$NoteToDriver,$Balance){
		$this->AuthLevelID = $AuthLevelID;
		$this->Terminal = $Terminal;
		$this->Country = $Country;
		$this->ReturnDiscount = $ReturnDiscount;
		$this->Provision = $Provision;
		$this->AuthUserRealName = $AuthUserRealName;
		$this->AuthUserName = $AuthUserName;
		$this->AuthUserCompany = $AuthUserCompany;
		$this->DriverID = $DriverID;
		$this->BrandName = $BrandName;
		$this->ContactPerson = $ContactPerson;
		$this->AuthUserCompanyMB = $AuthUserCompanyMB;
		$this->AuthCoAddress = $AuthCoAddress;
		$this->City = $City;
		$this->Zip = $Zip;
		$this->CountryName = $CountryName;
		$this->CountryID = $CountryID;
		$this->AuthUserTel = $AuthUserTel;
		$this->AuthUserMob = $AuthUserMob;
		$this->EmergencyPhone = $EmergencyPhone;
		$this->AuthUserFax = $AuthUserFax;
		$this->AuthUserMail = $AuthUserMail;
		$this->AuthUserCoDesc = $AuthUserCoDesc;
		$this->AuthUserNote = $AuthUserNote;
		$this->AuthUserNote1 = $AuthUserNote1;		
		$this->AccountBank = $AccountBank;
		$this->AccountOwner = $AccountOwner;
		$this->SWIFT = $SWIFT;
		$this->IBAN = $IBAN;
		$this->AuthUserPass = $AuthUserPass;
		$this->AuthUserCompanyWeb = $AuthUserCompanyWeb;
		$this->AuthUserFacebook = $AuthUserFacebook;
		$this->AuthUserTwitter = $AuthUserTwitter;
		$this->AuthUserLinkedIn = $AuthUserLinkedIn;
		$this->AuthUserGooglePlus = $AuthUserGooglePlus;
		$this->DateAdded = $DateAdded;
		$this->LastVisited = $LastVisited;
		$this->Image = $Image;
		$this->Temp_pass = $Temp_pass;
		$this->Temp_pass_active = $Temp_pass_active;
		$this->Level_access = $Level_access;
		$this->Random_key = $Random_key;
		$this->ContractFile = $ContractFile;
		$this->ContractDate = $ContractDate;
		$this->ContractSignature = $ContractSignature;
		$this->DBImage = $DBImage;
		$this->DBImageType = $DBImageType;
		$this->Language = $Language;
		$this->Active = $Active;
		$this->AcceptedPayment = $AcceptedPayment;
		$this->R1Low = $R1Low;
		$this->R1Hi = $R1Hi;
		$this->R1Percent = $R1Percent;
		$this->R2Low = $R2Low;
		$this->R2Hi = $R2Hi;
		$this->R2Percent = $R2Percent;
		$this->R3Low = $R3Low;
		$this->R3Hi = $R3Hi;
		$this->R3Percent = $R3Percent;
		$this->PR1Low = $PR1Low;
		$this->PR1Hi = $PR1Hi;
		$this->PR1Percent = $PR1Percent;
		$this->PR2Low = $PR2Low;
		$this->PR2Hi = $PR2Hi;
		$this->PR2Percent = $PR2Percent;
		$this->PR3Low = $PR3Low;
		$this->PR3Hi = $PR3Hi;
		$this->PR3Percent = $PR3Percent;
		$this->FR1Low = $FR1Low;
		$this->FR1Hi = $FR1Hi;
		$this->FR1Percent = $FR1Percent;
		$this->FR2Low = $FR2Low;
		$this->FR2Hi = $FR2Hi;
		$this->FR2Percent = $FR2Percent;
		$this->FR3Low = $FR3Low;
		$this->FR3Hi = $FR3Hi;
		$this->FR3Percent = $FR3Percent;
		$this->NoteToDriver = $NoteToDriver;
		$this->Balance = $Balance;
	}

    /**
     * Load one row into var_class. To use the vars use for exemple echo $class->getVar_name; 
     *
     * @param key_table_type $key_row
     * 
     */
	public function getRow($key_row){
		$result = $this->connection->RunQuery("Select * from v4_AuthUsers where AuthUserID = \"$key_row\" ");
		if($result->num_rows < 1) return false;
		while($row = $result->fetch_array(MYSQLI_ASSOC)){
			$this->AuthUserID = $row["AuthUserID"];
			$this->AuthLevelID = $row["AuthLevelID"];
			$this->Terminal = $row["Terminal"];
			$this->Country = $row["Country"];
			$this->ReturnDiscount = $row["ReturnDiscount"];
			$this->Provision = $row["Provision"];
			$this->AuthUserRealName = $row["AuthUserRealName"];
			$this->AuthUserName = $row["AuthUserName"];
			$this->AuthUserCompany = $row["AuthUserCompany"];
			$this->DriverID = $row["DriverID"];
			$this->BrandName = $row["BrandName"];
			$this->ContactPerson = $row["ContactPerson"];
			$this->AuthUserCompanyMB = $row["AuthUserCompanyMB"];
			$this->AuthCoAddress = $row["AuthCoAddress"];
			$this->City = $row["City"];
			$this->Zip = $row["Zip"];
			$this->CountryName = $row["CountryName"];
			$this->CountryID = $row["CountryID"];
			$this->AuthUserTel = $row["AuthUserTel"];
			$this->AuthUserMob = $row["AuthUserMob"];
			$this->EmergencyPhone = $row["EmergencyPhone"];
			$this->AuthUserFax = $row["AuthUserFax"];
			$this->AuthUserMail = $row["AuthUserMail"];
			$this->AuthUserCoDesc = $row["AuthUserCoDesc"];
			$this->AuthUserNote = $row["AuthUserNote"];
			$this->AuthUserNote1 = $row["AuthUserNote1"];			
			$this->AccountBank = $row["AccountBank"];
			$this->AccountOwner = $row["AccountOwner"];
			$this->SWIFT = $row["SWIFT"];
			$this->IBAN = $row["IBAN"];
			$this->AuthUserPass = $row["AuthUserPass"];
			$this->AuthUserCompanyWeb = $row["AuthUserCompanyWeb"];
			$this->AuthUserFacebook = $row["AuthUserFacebook"];
			$this->AuthUserTwitter = $row["AuthUserTwitter"];
			$this->AuthUserLinkedIn = $row["AuthUserLinkedIn"];
			$this->AuthUserGooglePlus = $row["AuthUserGooglePlus"];
			$this->DateAdded = $row["DateAdded"];
			$this->LastVisited = $row["LastVisited"];
			$this->Image = $row["Image"];
			$this->Temp_pass = $row["Temp_pass"];
			$this->Temp_pass_active = $row["Temp_pass_active"];
			$this->Level_access = $row["Level_access"];
			$this->Random_key = $row["Random_key"];
			$this->ContractFile = $row["ContractFile"];
			$this->ContractDate = $row["ContractDate"];
			$this->ContractSignature = $row["ContractSignature"];
			$this->DBImage = $row["DBImage"];
			$this->DBImageType = $row["DBImageType"];
			$this->Language = $row["Language"];
			$this->Active = $row["Active"];
			$this->AcceptedPayment = $row["AcceptedPayment"];
			$this->R1Low = $row["R1Low"];
			$this->R1Hi = $row["R1Hi"];
			$this->R1Percent = $row["R1Percent"];
			$this->R2Low = $row["R2Low"];
			$this->R2Hi = $row["R2Hi"];
			$this->R2Percent = $row["R2Percent"];
			$this->R3Low = $row["R3Low"];
			$this->R3Hi = $row["R3Hi"];
			$this->R3Percent = $row["R3Percent"];
			$this->PR1Low = $row["PR1Low"];
			$this->PR1Hi = $row["PR1Hi"];
			$this->PR1Percent = $row["PR1Percent"];
			$this->PR2Low = $row["PR2Low"];
			$this->PR2Hi = $row["PR2Hi"];
			$this->PR2Percent = $row["PR2Percent"];
			$this->PR3Low = $row["PR3Low"];
			$this->PR3Hi = $row["PR3Hi"];
			$this->PR3Percent = $row["PR3Percent"];
			$this->FR1Low = $row["FR1Low"];
			$this->FR1Hi = $row["FR1Hi"];
			$this->FR1Percent = $row["FR1Percent"];
			$this->FR2Low = $row["FR2Low"];
			$this->FR2Hi = $row["FR2Hi"];
			$this->FR2Percent = $row["FR2Percent"];
			$this->FR3Low = $row["FR3Low"];
			$this->FR3Hi = $row["FR3Hi"];
			$this->FR3Percent = $row["FR3Percent"];
			$this->NoteToDriver = $row["NoteToDriver"];
			$this->Balance = $row["Balance"];
		}
	}

    /**
     * Delete the row by using the key as arg
     *
     * @param key_table_type $key_row
     *
     */
	public function deleteRow($key_row){
		$this->connection->RunQuery("DELETE FROM v4_AuthUsers WHERE AuthUserID = $key_row");
	}

    /**
     * Update the active row table on table
     */
	public function saveRow(){
		$result = $this->connection->RunQuery("UPDATE v4_AuthUsers set 
AuthLevelID = '".$this->myreal_escape_string($this->AuthLevelID)."', 
Terminal = '".$this->myreal_escape_string($this->Terminal)."', 
Country = '".$this->myreal_escape_string($this->Country)."', 
ReturnDiscount = '".$this->myreal_escape_string($this->ReturnDiscount)."', 
Provision = '".$this->myreal_escape_string($this->Provision)."', 
AuthUserRealName = '".$this->myreal_escape_string($this->AuthUserRealName)."', 
AuthUserName = '".$this->myreal_escape_string($this->AuthUserName)."', 
AuthUserCompany = '".$this->myreal_escape_string($this->AuthUserCompany)."', 
DriverID = '".$this->myreal_escape_string($this->DriverID)."', 
BrandName = '".$this->myreal_escape_string($this->BrandName)."', 
ContactPerson = '".$this->myreal_escape_string($this->ContactPerson)."', 
AuthUserCompanyMB = '".$this->myreal_escape_string($this->AuthUserCompanyMB)."', 
AuthCoAddress = '".$this->myreal_escape_string($this->AuthCoAddress)."', 
City = '".$this->myreal_escape_string($this->City)."', 
Zip = '".$this->myreal_escape_string($this->Zip)."', 
CountryName = '".$this->myreal_escape_string($this->CountryName)."', 
CountryID = '".$this->myreal_escape_string($this->CountryID)."', 
AuthUserTel = '".$this->myreal_escape_string($this->AuthUserTel)."', 
AuthUserMob = '".$this->myreal_escape_string($this->AuthUserMob)."', 
EmergencyPhone = '".$this->myreal_escape_string($this->EmergencyPhone)."', 
AuthUserFax = '".$this->myreal_escape_string($this->AuthUserFax)."', 
AuthUserMail = '".$this->myreal_escape_string($this->AuthUserMail)."', 
AuthUserCoDesc = '".$this->myreal_escape_string($this->AuthUserCoDesc)."', 
AuthUserNote = '".$this->myreal_escape_string($this->AuthUserNote)."', 
AuthUserNote1 = '".$this->myreal_escape_string($this->AuthUserNote1)."', 
AccountBank = '".$this->myreal_escape_string($this->AccountBank)."', 
AccountOwner = '".$this->myreal_escape_string($this->AccountOwner)."', 
SWIFT = '".$this->myreal_escape_string($this->SWIFT)."', 
IBAN = '".$this->myreal_escape_string($this->IBAN)."', 
AuthUserPass = '".$this->myreal_escape_string($this->AuthUserPass)."', 
AuthUserCompanyWeb = '".$this->myreal_escape_string($this->AuthUserCompanyWeb)."', 
AuthUserFacebook = '".$this->myreal_escape_string($this->AuthUserFacebook)."', 
AuthUserTwitter = '".$this->myreal_escape_string($this->AuthUserTwitter)."', 
AuthUserLinkedIn = '".$this->myreal_escape_string($this->AuthUserLinkedIn)."', 
AuthUserGooglePlus = '".$this->myreal_escape_string($this->AuthUserGooglePlus)."', 
DateAdded = '".$this->myreal_escape_string($this->DateAdded)."', 
LastVisited = '".$this->myreal_escape_string($this->LastVisited)."', 
Image = '".$this->myreal_escape_string($this->Image)."', 
Temp_pass = '".$this->myreal_escape_string($this->Temp_pass)."', 
Temp_pass_active = '".$this->myreal_escape_string($this->Temp_pass_active)."', 
Level_access = '".$this->myreal_escape_string($this->Level_access)."', 
Random_key = '".$this->myreal_escape_string($this->Random_key)."', 
ContractFile = '".$this->myreal_escape_string($this->ContractFile)."', 
ContractDate = '".$this->myreal_escape_string($this->ContractDate)."', 
ContractSignature = '".$this->myreal_escape_string($this->ContractSignature)."', 
DBImage = '".$this->myreal_escape_string($this->DBImage)."', 
DBImageType = '".$this->myreal_escape_string($this->DBImageType)."', 
Language = '".$this->myreal_escape_string($this->Language)."', 
Active = '".$this->myreal_escape_string($this->Active)."', 
AcceptedPayment = '".$this->myreal_escape_string($this->AcceptedPayment)."', 
R1Low = '".$this->myreal_escape_string($this->R1Low)."', 
R1Hi = '".$this->myreal_escape_string($this->R1Hi)."', 
R1Percent = '".$this->myreal_escape_string($this->R1Percent)."', 
R2Low = '".$this->myreal_escape_string($this->R2Low)."', 
R2Hi = '".$this->myreal_escape_string($this->R2Hi)."', 
R2Percent = '".$this->myreal_escape_string($this->R2Percent)."', 
R3Low = '".$this->myreal_escape_string($this->R3Low)."', 
R3Hi = '".$this->myreal_escape_string($this->R3Hi)."', 
R3Percent = '".$this->myreal_escape_string($this->R3Percent)."', 
PR1Low = '".$this->myreal_escape_string($this->PR1Low)."', 
PR1Hi = '".$this->myreal_escape_string($this->PR1Hi)."', 
PR1Percent = '".$this->myreal_escape_string($this->PR1Percent)."', 
PR2Low = '".$this->myreal_escape_string($this->PR2Low)."', 
PR2Hi = '".$this->myreal_escape_string($this->PR2Hi)."', 
PR2Percent = '".$this->myreal_escape_string($this->PR2Percent)."', 
PR3Low = '".$this->myreal_escape_string($this->PR3Low)."', 
PR3Hi = '".$this->myreal_escape_string($this->PR3Hi)."', 
PR3Percent = '".$this->myreal_escape_string($this->PR3Percent)."', 
FR1Low = '".$this->myreal_escape_string($this->FR1Low)."', 
FR1Hi = '".$this->myreal_escape_string($this->FR1Hi)."', 
FR1Percent = '".$this->myreal_escape_string($this->FR1Percent)."', 
FR2Low = '".$this->myreal_escape_string($this->FR2Low)."', 
FR2Hi = '".$this->myreal_escape_string($this->FR2Hi)."', 
FR2Percent = '".$this->myreal_escape_string($this->FR2Percent)."', 
FR3Low = '".$this->myreal_escape_string($this->FR3Low)."', 
FR3Hi = '".$this->myreal_escape_string($this->FR3Hi)."', 
FR3Percent = '".$this->myreal_escape_string($this->FR3Percent)."',
NoteToDriver = '".$this->myreal_escape_string($this->NoteToDriver)."', 
Balance = '".$this->myreal_escape_string($this->Balance)."' WHERE AuthUserID = '".$this->AuthUserID."'");
	return $result; 
}

    /**
     * Save the active var class as a new row on table
     */
	public function saveAsNew(){
		$this->connection->RunQuery("INSERT INTO v4_AuthUsers (AuthLevelID, Terminal, Country, ReturnDiscount, Provision, AuthUserRealName, AuthUserName, AuthUserCompany, DriverID, BrandName, ContactPerson, AuthUserCompanyMB, AuthCoAddress, City, Zip, CountryName, CountryID, AuthUserTel, AuthUserMob, EmergencyPhone, AuthUserFax, AuthUserMail, AuthUserCoDesc, AuthUserNote, AuthUserNote1, AccountBank, AccountOwner, SWIFT, IBAN, AuthUserPass, AuthUserCompanyWeb, AuthUserFacebook, AuthUserTwitter, AuthUserLinkedIn, AuthUserGooglePlus, DateAdded, LastVisited, Image, Temp_pass, Temp_pass_active, Level_access, Random_key, ContractFile, ContractDate, ContractSignature, DBImage, DBImageType, Language, Active, AcceptedPayment, R1Low, R1Hi, R1Percent, R2Low, R2Hi, R2Percent, R3Low, R3Hi, R3Percent, PR1Low, PR1Hi, PR1Percent, PR2Low, PR2Hi, PR2Percent, PR3Low, PR3Hi, PR3Percent, FR1Low, FR1Hi, FR1Percent, FR2Low, FR2Hi, FR2Percent, FR3Low, FR3Hi, FR3Percent, NoteToDriver, Balance) values ('".$this->myreal_escape_string($this->AuthLevelID)."', '".$this->myreal_escape_string($this->Terminal)."', '".$this->myreal_escape_string($this->Country)."', '".$this->myreal_escape_string($this->ReturnDiscount)."', '".$this->myreal_escape_string($this->Provision)."', '".$this->myreal_escape_string($this->AuthUserRealName)."', '".$this->myreal_escape_string($this->AuthUserName)."', '".$this->myreal_escape_string($this->AuthUserCompany)."', '".$this->myreal_escape_string($this->DriverID)."', '".$this->myreal_escape_string($this->BrandName)."', '".$this->myreal_escape_string($this->ContactPerson)."', '".$this->myreal_escape_string($this->AuthUserCompanyMB)."', '".$this->myreal_escape_string($this->AuthCoAddress)."', '".$this->myreal_escape_string($this->City)."', '".$this->myreal_escape_string($this->Zip)."', '".$this->myreal_escape_string($this->CountryName)."', '".$this->myreal_escape_string($this->CountryID)."', '".$this->myreal_escape_string($this->AuthUserTel)."', '".$this->myreal_escape_string($this->AuthUserMob)."', '".$this->myreal_escape_string($this->EmergencyPhone)."', '".$this->myreal_escape_string($this->AuthUserFax)."', '".$this->myreal_escape_string($this->AuthUserMail)."', '".$this->myreal_escape_string($this->AuthUserCoDesc)."','".$this->myreal_escape_string($this->AuthUserNote)."','".$this->myreal_escape_string($this->AuthUserNote1)."','".$this->myreal_escape_string($this->AccountBank)."', '".$this->myreal_escape_string($this->AccountOwner)."', '".$this->myreal_escape_string($this->SWIFT)."', '".$this->myreal_escape_string($this->IBAN)."', '".$this->myreal_escape_string($this->AuthUserPass)."', '".$this->myreal_escape_string($this->AuthUserCompanyWeb)."', '".$this->myreal_escape_string($this->AuthUserFacebook)."', '".$this->myreal_escape_string($this->AuthUserTwitter)."', '".$this->myreal_escape_string($this->AuthUserLinkedIn)."', '".$this->myreal_escape_string($this->AuthUserGooglePlus)."', '".$this->myreal_escape_string($this->DateAdded)."', '".$this->myreal_escape_string($this->LastVisited)."', '".$this->myreal_escape_string($this->Image)."', '".$this->myreal_escape_string($this->Temp_pass)."', '".$this->myreal_escape_string($this->Temp_pass_active)."', '".$this->myreal_escape_string($this->Level_access)."', '".$this->myreal_escape_string($this->Random_key)."', '".$this->myreal_escape_string($this->ContractFile)."', '".$this->myreal_escape_string($this->ContractDate)."', '".$this->myreal_escape_string($this->ContractSignature)."', '".$this->myreal_escape_string($this->DBImage)."', '".$this->myreal_escape_string($this->DBImageType)."', '".$this->myreal_escape_string($this->Language)."', '".$this->myreal_escape_string($this->Active)."', '".$this->myreal_escape_string($this->AcceptedPayment)."', '".$this->myreal_escape_string($this->R1Low)."', '".$this->myreal_escape_string($this->R1Hi)."', '".$this->myreal_escape_string($this->R1Percent)."', '".$this->myreal_escape_string($this->R2Low)."', '".$this->myreal_escape_string($this->R2Hi)."', '".$this->myreal_escape_string($this->R2Percent)."', '".$this->myreal_escape_string($this->R3Low)."', '".$this->myreal_escape_string($this->R3Hi)."', '".$this->myreal_escape_string($this->R3Percent)."', '".$this->myreal_escape_string($this->PR1Low)."', '".$this->myreal_escape_string($this->PR1Hi)."', '".$this->myreal_escape_string($this->PR1Percent)."', '".$this->myreal_escape_string($this->PR2Low)."', '".$this->myreal_escape_string($this->PR2Hi)."', '".$this->myreal_escape_string($this->PR2Percent)."', '".$this->myreal_escape_string($this->PR3Low)."', '".$this->myreal_escape_string($this->PR3Hi)."', '".$this->myreal_escape_string($this->PR3Percent)."', '".$this->myreal_escape_string($this->FR1Low)."', '".$this->myreal_escape_string($this->FR1Hi)."', '".$this->myreal_escape_string($this->FR1Percent)."', '".$this->myreal_escape_string($this->FR2Low)."', '".$this->myreal_escape_string($this->FR2Hi)."', '".$this->myreal_escape_string($this->FR2Percent)."', '".$this->myreal_escape_string($this->FR3Low)."', '".$this->myreal_escape_string($this->FR3Hi)."', '".$this->myreal_escape_string($this->FR3Percent)."', '".$this->myreal_escape_string($this->NoteToDriver)."', '".$this->myreal_escape_string($this->Balance)."')");
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
		$result = $this->connection->RunQuery("SELECT AuthUserID from v4_AuthUsers $where ORDER BY $column $order");
			while($row = $result->fetch_array(MYSQLI_ASSOC)){
				$keys[$i] = $row["AuthUserID"];
				$i++;
			}
	return $keys;
	}

	/**
	 * @return AuthUserID - int(10) unsigned
	 */
	public function getAuthUserID(){
		return $this->AuthUserID;
	}

	/**
	 * @return AuthLevelID - int(10) unsigned
	 */
	public function getAuthLevelID(){
		return $this->AuthLevelID;
	}

	/**
	 * @return Terminal - varchar(255)
	 */
	public function getTerminal(){
		return $this->Terminal;
	}

	/**
	 * @return Country - varchar(5)
	 */
	public function getCountry(){
		return $this->Country;
	}

	/**
	 * @return ReturnDiscount - decimal(6,2)
	 */
	public function getReturnDiscount(){
		return $this->ReturnDiscount;
	}

	/**
	 * @return Provision - int(11)
	 */
	public function getProvision(){
		return $this->Provision;
	}

	/**
	 * @return AuthUserRealName - varchar(100)
	 */
	public function getAuthUserRealName(){
		return $this->AuthUserRealName;
	}

	/**
	 * @return AuthUserName - varchar(32)
	 */
	public function getAuthUserName(){
		return $this->AuthUserName;
	}

	/**
	 * @return AuthUserCompany - varchar(100)
	 */
	public function getAuthUserCompany(){
		return $this->AuthUserCompany;
	}

	/**
	 * @return DriverID - int(11)
	 */
	public function getDriverID(){
		return $this->DriverID;
	}

	/**
	 * @return BrandName - varchar(255)
	 */
	public function getBrandName(){
		return $this->BrandName;
	}

	/**
	 * @return ContactPerson - varchar(255)
	 */
	public function getContactPerson(){
		return $this->ContactPerson;
	}

	/**
	 * @return AuthUserCompanyMB - varchar(200)
	 */
	public function getAuthUserCompanyMB(){
		return $this->AuthUserCompanyMB;
	}

	/**
	 * @return AuthCoAddress - text
	 */
	public function getAuthCoAddress(){
		return $this->AuthCoAddress;
	}

	/**
	 * @return City - varchar(255)
	 */
	public function getCity(){
		return $this->City;
	}

	/**
	 * @return Zip - varchar(255)
	 */
	public function getZip(){
		return $this->Zip;
	}

	/**
	 * @return CountryName - varchar(255)
	 */
	public function getCountryName(){
		return $this->CountryName;
	}

	/**
	 * @return CountryID - tinyint(4)
	 */
	public function getCountryID(){
		return $this->CountryID;
	}

	/**
	 * @return AuthUserTel - varchar(50)
	 */
	public function getAuthUserTel(){
		return $this->AuthUserTel;
	}

	/**
	 * @return AuthUserMob - varchar(50)
	 */
	public function getAuthUserMob(){
		return $this->AuthUserMob;
	}

	/**
	 * @return EmergencyPhone - varchar(255)
	 */
	public function getEmergencyPhone(){
		return $this->EmergencyPhone;
	}

	/**
	 * @return AuthUserFax - varchar(50)
	 */
	public function getAuthUserFax(){
		return $this->AuthUserFax;
	}

	/**
	 * @return AuthUserMail - varchar(200)
	 */
	public function getAuthUserMail(){
		return $this->AuthUserMail;
	}

	/**
	 * @return AuthUserCoDesc - text
	 */
	public function getAuthUserCoDesc(){
		return $this->AuthUserCoDesc;
	}

	/**
	 * @return AuthUserNote - text
	 */
	public function getAuthUserNote(){
		return $this->AuthUserNote;
	}

	/**
	 * @return AuthUserNote1 - text
	 */
	public function getAuthUserNote1(){
		return $this->AuthUserNote1;
	}
	
	/**
	 * @return AccountBank - varchar(255)
	 */
	public function getAccountBank(){
		return $this->AccountBank;
	}

	/**
	 * @return AccountOwner - varchar(255)
	 */
	public function getAccountOwner(){
		return $this->AccountOwner;
	}

	/**
	 * @return SWIFT - varchar(255)
	 */
	public function getSWIFT(){
		return $this->SWIFT;
	}

	/**
	 * @return IBAN - varchar(34)
	 */
	public function getIBAN(){
		return $this->IBAN;
	}

	/**
	 * @return AuthUserPass - varchar(32)
	 */
	public function getAuthUserPass(){
		return $this->AuthUserPass;
	}

	/**
	 * @return AuthUserCompanyWeb - varchar(500)
	 */
	public function getAuthUserCompanyWeb(){
		return $this->AuthUserCompanyWeb;
	}

	/**
	 * @return AuthUserFacebook - varchar(255)
	 */
	public function getAuthUserFacebook(){
		return $this->AuthUserFacebook;
	}

	/**
	 * @return AuthUserTwitter - varchar(255)
	 */
	public function getAuthUserTwitter(){
		return $this->AuthUserTwitter;
	}

	/**
	 * @return AuthUserLinkedIn - varchar(255)
	 */
	public function getAuthUserLinkedIn(){
		return $this->AuthUserLinkedIn;
	}

	/**
	 * @return AuthUserGooglePlus - varchar(255)
	 */
	public function getAuthUserGooglePlus(){
		return $this->AuthUserGooglePlus;
	}

	/**
	 * @return DateAdded - date
	 */
	public function getDateAdded(){
		return $this->DateAdded;
	}

	/**
	 * @return LastVisited - timestamp
	 */
	public function getLastVisited(){
		return $this->LastVisited;
	}

	/**
	 * @return Image - varchar(255)
	 */
	public function getImage(){
		return $this->Image;
	}

	/**
	 * @return Temp_pass - varchar(55)
	 */
	public function getTemp_pass(){
		return $this->Temp_pass;
	}

	/**
	 * @return Temp_pass_active - tinyint(1)
	 */
	public function getTemp_pass_active(){
		return $this->Temp_pass_active;
	}

	/**
	 * @return Level_access - int(11)
	 */
	public function getLevel_access(){
		return $this->Level_access;
	}

	/**
	 * @return Random_key - varchar(32)
	 */
	public function getRandom_key(){
		return $this->Random_key;
	}

	/**
	 * @return ContractFile - varchar(255)
	 */
	public function getContractFile(){
		return $this->ContractFile;
	}

	/**
	 * @return ContractDate - varchar(15)
	 */
	public function getContractDate(){
		return $this->ContractDate;
	}

	/**
	 * @return ContractSignature - varchar(255)
	 */
	public function getContractSignature(){
		return $this->ContractSignature;
	}

	/**
	 * @return DBImage - mediumblob
	 */
	public function getDBImage(){
		return $this->DBImage;
	}

	/**
	 * @return DBImageType - varchar(255)
	 */
	public function getDBImageType(){
		return $this->DBImageType;
	}

	/**
	 * @return Language - varchar(100)
	 */
	public function getLanguage(){
		return $this->Language;
	}

	/**
	 * @return Active - int(11)
	 */
	public function getActive(){
		return $this->Active;
	}

	/**
	 * @return AcceptedPayment - int(2)
	 */
	public function getAcceptedPayment(){
		return $this->AcceptedPayment;
	}

	/**
	 * @return R1Low - int(5)
	 */
	public function getR1Low(){
		return $this->R1Low;
	}

	/**
	 * @return R1Hi - int(5)
	 */
	public function getR1Hi(){
		return $this->R1Hi;
	}

	/**
	 * @return R1Percent - decimal(6,2)
	 */
	public function getR1Percent(){
		return $this->R1Percent;
	}

	/**
	 * @return R2Low - int(5)
	 */
	public function getR2Low(){
		return $this->R2Low;
	}

	/**
	 * @return R2Hi - int(5)
	 */
	public function getR2Hi(){
		return $this->R2Hi;
	}

	/**
	 * @return R2Percent - decimal(6,2)
	 */
	public function getR2Percent(){
		return $this->R2Percent;
	}

	/**
	 * @return R3Low - int(5)
	 */
	public function getR3Low(){
		return $this->R3Low;
	}

	/**
	 * @return R3Hi - int(5)
	 */
	public function getR3Hi(){
		return $this->R3Hi;
	}

	/**
	 * @return R3Percent - decimal(6,2)
	 */
	public function getR3Percent(){
		return $this->R3Percent;
	}

	/**
	 * @return PR1Low - int(5)
	 */
	public function getPR1Low(){
		return $this->PR1Low;
	}

	/**
	 * @return PR1Hi - int(5)
	 */
	public function getPR1Hi(){
		return $this->PR1Hi;
	}

	/**
	 * @return PR1Percent - decimal(6,2)
	 */
	public function getPR1Percent(){
		return $this->PR1Percent;
	}

	/**
	 * @return PR2Low - int(5)
	 */
	public function getPR2Low(){
		return $this->PR2Low;
	}

	/**
	 * @return PR2Hi - int(5)
	 */
	public function getPR2Hi(){
		return $this->PR2Hi;
	}

	/**
	 * @return PR2Percent - decimal(6,2)
	 */
	public function getPR2Percent(){
		return $this->PR2Percent;
	}

	/**
	 * @return PR3Low - int(5)
	 */
	public function getPR3Low(){
		return $this->PR3Low;
	}

	/**
	 * @return PR3Hi - int(5)
	 */
	public function getPR3Hi(){
		return $this->PR3Hi;
	}

	/**
	 * @return PR3Percent - decimal(6,2)
	 */
	public function getPR3Percent(){
		return $this->PR3Percent;
	}

	/**
	 * @return FR1Low - int(5)
	 */
	public function getFR1Low(){
		return $this->FR1Low;
	}

	/**
	 * @return FR1Hi - int(5)
	 */
	public function getFR1Hi(){
		return $this->FR1Hi;
	}

	/**
	 * @return FR1Percent - decimal(6,2)
	 */
	public function getFR1Percent(){
		return $this->FR1Percent;
	}

	/**
	 * @return FR2Low - int(5)
	 */
	public function getFR2Low(){
		return $this->FR2Low;
	}

	/**
	 * @return FR2Hi - int(5)
	 */
	public function getFR2Hi(){
		return $this->FR2Hi;
	}

	/**
	 * @return FR2Percent - decimal(6,2)
	 */
	public function getFR2Percent(){
		return $this->FR2Percent;
	}

	/**
	 * @return FR3Low - int(5)
	 */
	public function getFR3Low(){
		return $this->FR3Low;
	}

	/**
	 * @return FR3Hi - int(5)
	 */
	public function getFR3Hi(){
		return $this->FR3Hi;
	}

	/**
	 * @return FR3Percent - decimal(6,2)
	 */
	public function getFR3Percent(){
		return $this->FR3Percent;
	}

	/**
	 * @return FR3Percent - decimal(6,2)
	 */
	public function getNoteToDriver(){
		return $this->NoteToDriver;
	}

	/**
	 * @return FR3Percent - decimal(6,2)
	 */
	public function getBalance(){
		return $this->Balance;
	}

	/**
	 * @param Type: int(10) unsigned
	 */
	public function setAuthUserID($AuthUserID){
		$this->AuthUserID = $AuthUserID;
	}

	/**
	 * @param Type: int(10) unsigned
	 */
	public function setAuthLevelID($AuthLevelID){
		$this->AuthLevelID = $AuthLevelID;
	}

	/**
	 * @param Type: varchar(255)
	 */
	public function setTerminal($Terminal){
		$this->Terminal = $Terminal;
	}

	/**
	 * @param Type: varchar(5)
	 */
	public function setCountry($Country){
		$this->Country = $Country;
	}

	/**
	 * @param Type: decimal(6,2)
	 */
	public function setReturnDiscount($ReturnDiscount){
		$this->ReturnDiscount = $ReturnDiscount;
	}

	/**
	 * @param Type: int(11)
	 */
	public function setProvision($Provision){
		$this->Provision = $Provision;
	}

	/**
	 * @param Type: varchar(100)
	 */
	public function setAuthUserRealName($AuthUserRealName){
		$this->AuthUserRealName = $AuthUserRealName;
	}

	/**
	 * @param Type: varchar(32)
	 */
	public function setAuthUserName($AuthUserName){
		$this->AuthUserName = $AuthUserName;
	}

	/**
	 * @param Type: varchar(100)
	 */
	public function setAuthUserCompany($AuthUserCompany){
		$this->AuthUserCompany = $AuthUserCompany;
	}

	/**
	 * @param Type: int(11)
	 */
	public function setDriverID($DriverID){
		$this->DriverID = $DriverID;
	}

	/**
	 * @param Type: varchar(255)
	 */
	public function setBrandName($BrandName){
		$this->BrandName = $BrandName;
	}

	/**
	 * @param Type: varchar(255)
	 */
	public function setContactPerson($ContactPerson){
		$this->ContactPerson = $ContactPerson;
	}

	/**
	 * @param Type: varchar(200)
	 */
	public function setAuthUserCompanyMB($AuthUserCompanyMB){
		$this->AuthUserCompanyMB = $AuthUserCompanyMB;
	}

	/**
	 * @param Type: text
	 */
	public function setAuthCoAddress($AuthCoAddress){
		$this->AuthCoAddress = $AuthCoAddress;
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
	public function setZip($Zip){
		$this->Zip = $Zip;
	}

	/**
	 * @param Type: varchar(255)
	 */
	public function setCountryName($CountryName){
		$this->CountryName = $CountryName;
	}

	/**
	 * @param Type: tinyint(4)
	 */
	public function setCountryID($CountryID){
		$this->CountryID = $CountryID;
	}

	/**
	 * @param Type: varchar(50)
	 */
	public function setAuthUserTel($AuthUserTel){
		$this->AuthUserTel = $AuthUserTel;
	}

	/**
	 * @param Type: varchar(50)
	 */
	public function setAuthUserMob($AuthUserMob){
		$this->AuthUserMob = $AuthUserMob;
	}

	/**
	 * @param Type: varchar(255)
	 */
	public function setEmergencyPhone($EmergencyPhone){
		$this->EmergencyPhone = $EmergencyPhone;
	}

	/**
	 * @param Type: varchar(50)
	 */
	public function setAuthUserFax($AuthUserFax){
		$this->AuthUserFax = $AuthUserFax;
	}

	/**
	 * @param Type: varchar(200)
	 */
	public function setAuthUserMail($AuthUserMail){
		$this->AuthUserMail = $AuthUserMail;
	}

	/**
	 * @param Type: text
	 */
	public function setAuthUserCoDesc($AuthUserCoDesc){
		$this->AuthUserCoDesc = $AuthUserCoDesc;
	}

	/**
	 * @param Type: text
	 */
	public function setAuthUserNote($AuthUserNote){
		$this->AuthUserNote = $AuthUserNote;
	}

	/**
	 * @param Type: text
	 */
	public function setAuthUserNote1($AuthUserNote1){
		$this->AuthUserNote1 = $AuthUserNote1;
	}
	
	/**
	 * @param Type: varchar(255)
	 */
	public function setAccountBank($AccountBank){
		$this->AccountBank = $AccountBank;
	}

	/**
	 * @param Type: varchar(255)
	 */
	public function setAccountOwner($AccountOwner){
		$this->AccountOwner = $AccountOwner;
	}

	/**
	 * @param Type: varchar(255)
	 */
	public function setSWIFT($SWIFT){
		$this->SWIFT = $SWIFT;
	}

	/**
	 * @param Type: varchar(34)
	 */
	public function setIBAN($IBAN){
		$this->IBAN = $IBAN;
	}

	/**
	 * @param Type: varchar(32)
	 */
	public function setAuthUserPass($AuthUserPass){
		$this->AuthUserPass = $AuthUserPass;
	}

	/**
	 * @param Type: varchar(500)
	 */
	public function setAuthUserCompanyWeb($AuthUserCompanyWeb){
		$this->AuthUserCompanyWeb = $AuthUserCompanyWeb;
	}

	/**
	 * @param Type: varchar(255)
	 */
	public function setAuthUserFacebook($AuthUserFacebook){
		$this->AuthUserFacebook = $AuthUserFacebook;
	}

	/**
	 * @param Type: varchar(255)
	 */
	public function setAuthUserTwitter($AuthUserTwitter){
		$this->AuthUserTwitter = $AuthUserTwitter;
	}

	/**
	 * @param Type: varchar(255)
	 */
	public function setAuthUserLinkedIn($AuthUserLinkedIn){
		$this->AuthUserLinkedIn = $AuthUserLinkedIn;
	}

	/**
	 * @param Type: varchar(255)
	 */
	public function setAuthUserGooglePlus($AuthUserGooglePlus){
		$this->AuthUserGooglePlus = $AuthUserGooglePlus;
	}

	/**
	 * @param Type: date
	 */
	public function setDateAdded($DateAdded){
		$this->DateAdded = $DateAdded;
	}

	/**
	 * @param Type: timestamp
	 */
	public function setLastVisited($LastVisited){
		$this->LastVisited = $LastVisited;
	}

	/**
	 * @param Type: varchar(255)
	 */
	public function setImage($Image){
		$this->Image = $Image;
	}

	/**
	 * @param Type: varchar(55)
	 */
	public function setTemp_pass($Temp_pass){
		$this->Temp_pass = $Temp_pass;
	}

	/**
	 * @param Type: tinyint(1)
	 */
	public function setTemp_pass_active($Temp_pass_active){
		$this->Temp_pass_active = $Temp_pass_active;
	}

	/**
	 * @param Type: int(11)
	 */
	public function setLevel_access($Level_access){
		$this->Level_access = $Level_access;
	}

	/**
	 * @param Type: varchar(32)
	 */
	public function setRandom_key($Random_key){
		$this->Random_key = $Random_key;
	}

	/**
	 * @param Type: varchar(255)
	 */
	public function setContractFile($ContractFile){
		$this->ContractFile = $ContractFile;
	}

	/**
	 * @param Type: varchar(15)
	 */
	public function setContractDate($ContractDate){
		$this->ContractDate = $ContractDate;
	}

	/**
	 * @param Type: varchar(255)
	 */
	public function setContractSignature($ContractSignature){
		$this->ContractSignature = $ContractSignature;
	}

	/**
	 * @param Type: mediumblob
	 */
	public function setDBImage($DBImage){
		$this->DBImage = $DBImage;
	}

	/**
	 * @param Type: varchar(255)
	 */
	public function setDBImageType($DBImageType){
		$this->DBImageType = $DBImageType;
	}

	/**
	 * @param Type: varchar(100)
	 */
	public function setLanguage($Language){
		$this->Language = $Language;
	}

	/**
	 * @param Type: int(11)
	 */
	public function setActive($Active){
		$this->Active = $Active;
	}

	/**
	 * @param Type: int(2)
	 */
	public function setAcceptedPayment($AcceptedPayment){
		$this->AcceptedPayment = $AcceptedPayment;
	}

	/**
	 * @param Type: int(5)
	 */
	public function setR1Low($R1Low){
		$this->R1Low = $R1Low;
	}

	/**
	 * @param Type: int(5)
	 */
	public function setR1Hi($R1Hi){
		$this->R1Hi = $R1Hi;
	}

	/**
	 * @param Type: decimal(6,2)
	 */
	public function setR1Percent($R1Percent){
		$this->R1Percent = $R1Percent;
	}

	/**
	 * @param Type: int(5)
	 */
	public function setR2Low($R2Low){
		$this->R2Low = $R2Low;
	}

	/**
	 * @param Type: int(5)
	 */
	public function setR2Hi($R2Hi){
		$this->R2Hi = $R2Hi;
	}

	/**
	 * @param Type: decimal(6,2)
	 */
	public function setR2Percent($R2Percent){
		$this->R2Percent = $R2Percent;
	}

	/**
	 * @param Type: int(5)
	 */
	public function setR3Low($R3Low){
		$this->R3Low = $R3Low;
	}

	/**
	 * @param Type: int(5)
	 */
	public function setR3Hi($R3Hi){
		$this->R3Hi = $R3Hi;
	}

	/**
	 * @param Type: decimal(6,2)
	 */
	public function setR3Percent($R3Percent){
		$this->R3Percent = $R3Percent;
	}

	/**
	 * @param Type: int(5)
	 */
	public function setPR1Low($PR1Low){
		$this->PR1Low = $PR1Low;
	}

	/**
	 * @param Type: int(5)
	 */
	public function setPR1Hi($PR1Hi){
		$this->PR1Hi = $PR1Hi;
	}

	/**
	 * @param Type: decimal(6,2)
	 */
	public function setPR1Percent($PR1Percent){
		$this->PR1Percent = $PR1Percent;
	}

	/**
	 * @param Type: int(5)
	 */
	public function setPR2Low($PR2Low){
		$this->PR2Low = $PR2Low;
	}

	/**
	 * @param Type: int(5)
	 */
	public function setPR2Hi($PR2Hi){
		$this->PR2Hi = $PR2Hi;
	}

	/**
	 * @param Type: decimal(6,2)
	 */
	public function setPR2Percent($PR2Percent){
		$this->PR2Percent = $PR2Percent;
	}

	/**
	 * @param Type: int(5)
	 */
	public function setPR3Low($PR3Low){
		$this->PR3Low = $PR3Low;
	}

	/**
	 * @param Type: int(5)
	 */
	public function setPR3Hi($PR3Hi){
		$this->PR3Hi = $PR3Hi;
	}

	/**
	 * @param Type: decimal(6,2)
	 */
	public function setPR3Percent($PR3Percent){
		$this->PR3Percent = $PR3Percent;
	}

	/**
	 * @param Type: int(5)
	 */
	public function setFR1Low($FR1Low){
		$this->FR1Low = $FR1Low;
	}

	/**
	 * @param Type: int(5)
	 */
	public function setFR1Hi($FR1Hi){
		$this->FR1Hi = $FR1Hi;
	}

	/**
	 * @param Type: decimal(6,2)
	 */
	public function setFR1Percent($FR1Percent){
		$this->FR1Percent = $FR1Percent;
	}

	/**
	 * @param Type: int(5)
	 */
	public function setFR2Low($FR2Low){
		$this->FR2Low = $FR2Low;
	}

	/**
	 * @param Type: int(5)
	 */
	public function setFR2Hi($FR2Hi){
		$this->FR2Hi = $FR2Hi;
	}

	/**
	 * @param Type: decimal(6,2)
	 */
	public function setFR2Percent($FR2Percent){
		$this->FR2Percent = $FR2Percent;
	}

	/**
	 * @param Type: int(5)
	 */
	public function setFR3Low($FR3Low){
		$this->FR3Low = $FR3Low;
	}

	/**
	 * @param Type: int(5)
	 */
	public function setFR3Hi($FR3Hi){
		$this->FR3Hi = $FR3Hi;
	}

	/**
	 * @param Type: decimal(6,2)
	 */
	public function setFR3Percent($FR3Percent){
		$this->FR3Percent = $FR3Percent;
	}

	/**
	 * @param Type: decimal(6,2)
	 */
	public function setNoteToDriver($NoteToDriver){
		$this->NoteToDriver = $NoteToDriver;
	}

	/**
	 * @param Type: decimal(6,2)
	 */
	public function setBalance($Balance){
		$this->Balance = $Balance;
	}

    /**
     * fieldValues - Load all fieldNames and fieldValues into Array. 
     *
     * @param 
     * 
     */
	public function fieldValues(){
		$fieldValues = array(
			'AuthUserID' => $this->getAuthUserID(),
			'AuthLevelID' => $this->getAuthLevelID(),
			'Terminal' => $this->getTerminal(),
			'Country' => $this->getCountry(),
			'ReturnDiscount' => $this->getReturnDiscount(),
			'Provision' => $this->getProvision(),
			'AuthUserRealName' => $this->getAuthUserRealName(),
			'AuthUserName' => $this->getAuthUserName(),
			'AuthUserCompany' => $this->getAuthUserCompany(),
			'DriverID' => $this->getDriverID(),
			'BrandName' => $this->getBrandName(),
			'ContactPerson' => $this->getContactPerson(),
			'AuthUserCompanyMB' => $this->getAuthUserCompanyMB(),
			'AuthCoAddress' => $this->getAuthCoAddress(),
			'City' => $this->getCity(),
			'Zip' => $this->getZip(),
			'CountryName' => $this->getCountryName(),
			'CountryID' => $this->getCountryID(),
			'AuthUserTel' => $this->getAuthUserTel(),
			'AuthUserMob' => $this->getAuthUserMob(),
			'EmergencyPhone' => $this->getEmergencyPhone(),
			'AuthUserFax' => $this->getAuthUserFax(),
			'AuthUserMail' => $this->getAuthUserMail(),
			'AuthUserCoDesc' => $this->getAuthUserCoDesc(),
			'AuthUserNote' => $this->getAuthUserNote(),
			'AuthUserNote1' => $this->getAuthUserNote1(),			
			'AccountBank' => $this->getAccountBank(),
			'AccountOwner' => $this->getAccountOwner(),
			'SWIFT' => $this->getSWIFT(),
			'IBAN' => $this->getIBAN(),
			'AuthUserPass' => $this->getAuthUserPass(),
			'AuthUserCompanyWeb' => $this->getAuthUserCompanyWeb(),
			'AuthUserFacebook' => $this->getAuthUserFacebook(),
			'AuthUserTwitter' => $this->getAuthUserTwitter(),
			'AuthUserLinkedIn' => $this->getAuthUserLinkedIn(),
			'AuthUserGooglePlus' => $this->getAuthUserGooglePlus(),
			'DateAdded' => $this->getDateAdded(),
			'LastVisited' => $this->getLastVisited(),
			'Image' => $this->getImage(),
			'Temp_pass' => $this->getTemp_pass(),
			'Temp_pass_active' => $this->getTemp_pass_active(),
			'Level_access' => $this->getLevel_access(),
			'Random_key' => $this->getRandom_key(),
			'ContractFile' => $this->getContractFile(),
			'ContractDate' => $this->getContractDate(),
			'ContractSignature' => $this->getContractSignature(),
			'DBImage' => $this->getDBImage(),
			'DBImageType' => $this->getDBImageType(),
			'Language' => $this->getLanguage(),
			'Active' => $this->getActive(),
			'AcceptedPayment' => $this->getAcceptedPayment(),
			'R1Low' => $this->getR1Low(),
			'R1Hi' => $this->getR1Hi(),
			'R1Percent' => $this->getR1Percent(),
			'R2Low' => $this->getR2Low(),
			'R2Hi' => $this->getR2Hi(),
			'R2Percent' => $this->getR2Percent(),
			'R3Low' => $this->getR3Low(),
			'R3Hi' => $this->getR3Hi(),
			'R3Percent' => $this->getR3Percent(),
			'PR1Low' => $this->getPR1Low(),
			'PR1Hi' => $this->getPR1Hi(),
			'PR1Percent' => $this->getPR1Percent(),
			'PR2Low' => $this->getPR2Low(),
			'PR2Hi' => $this->getPR2Hi(),
			'PR2Percent' => $this->getPR2Percent(),
			'PR3Low' => $this->getPR3Low(),
			'PR3Hi' => $this->getPR3Hi(),
			'PR3Percent' => $this->getPR3Percent(),
			'FR1Low' => $this->getFR1Low(),
			'FR1Hi' => $this->getFR1Hi(),
			'FR1Percent' => $this->getFR1Percent(),
			'FR2Low' => $this->getFR2Low(),
			'FR2Hi' => $this->getFR2Hi(),
			'FR2Percent' => $this->getFR2Percent(),
			'FR3Low' => $this->getFR3Low(),
			'FR3Hi' => $this->getFR3Hi(),
			'FR3Percent' => $this->getFR3Percent(),
			'NoteToDriver' => $this->getNoteToDriver(),
			'Balance' => $this->getBalance()		);
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
			'AuthUserID',			'AuthLevelID',			'Terminal',			'Country',			'ReturnDiscount',			'Provision',			'AuthUserRealName',			'AuthUserName',			'AuthUserCompany',			'DriverID',			'BrandName',			'ContactPerson',			'AuthUserCompanyMB',			'AuthCoAddress',			'City',			'Zip',			'CountryName',			'CountryID',			'AuthUserTel',			'AuthUserMob',			'EmergencyPhone',			'AuthUserFax',			'AuthUserMail',			'AuthUserCoDesc',			'AuthUserNote',			'AuthUserNote1',		'AccountBank',			'AccountOwner',			'SWIFT',			'IBAN',			'AuthUserPass',			'AuthUserCompanyWeb',			'AuthUserFacebook',			'AuthUserTwitter',			'AuthUserLinkedIn',			'AuthUserGooglePlus',			'DateAdded',			'LastVisited',			'Image',			'Temp_pass',			'Temp_pass_active',			'Level_access',			'Random_key',			'ContractFile',			'ContractDate',			'ContractSignature',			'DBImage',			'DBImageType',			'Language',			'Active',			'AcceptedPayment',			'R1Low',			'R1Hi',			'R1Percent',			'R2Low',			'R2Hi',			'R2Percent',			'R3Low',			'R3Hi',			'R3Percent',			'PR1Low',			'PR1Hi',			'PR1Percent',			'PR2Low',			'PR2Hi',			'PR2Percent',			'PR3Low',			'PR3Hi',			'PR3Percent',			'FR1Low',			'FR1Hi',			'FR1Percent',			'FR2Low',			'FR2Hi',			'FR2Percent',			'FR3Low',			'FR3Hi',			'FR3Percent',			'NoteToDriver',			'Balance'		);
		return $fieldNames;
	}
    /**
     * Close mysql connection
     */
	public function endv4_AuthUsers(){
		$this->connection->CloseMysql();
	}

}
