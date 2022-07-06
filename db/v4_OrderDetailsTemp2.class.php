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

Class v4_OrderDetailsTemp {

	public $SiteID; //int(3)
	public $DetailsID; //int(10) unsigned
	public $OrderID; //int(10) unsigned
	public $TNo; //tinyint(4)
	public $UserID; //int(10)
	public $UserLevelID; //int(3)
	public $AgentID; //int(10)
	public $CustomerID; //int(10)
	public $TransferStatus; //tinyint(3) unsigned
	public $OrderDate; //varchar(10)
	public $TaxidoComm; //decimal(10,2) unsigned
	public $ServiceID; //int(10) unsigned
	public $RouteID; //int(10) unsigned
	public $FlightNo; //varchar(100)
	public $FlightTime; //varchar(15)
	public $PaxName; //varchar(255)
	public $PickupID; //int(10) unsigned
	public $PickupName; //varchar(100)
	public $PickupPlace; //varchar(100)
	public $PickupAddress; //varchar(100)
	public $PickupDate; //varchar(15)
	public $PickupTime; //varchar(15)
	public $PickupNotes; //text
	public $DropID; //int(10) unsigned
	public $DropName; //varchar(100)
	public $DropPlace; //varchar(100)
	public $DropAddress; //varchar(100)
	public $DropNotes; //text
	public $PriceClassID; //tinyint(3) unsigned
	public $DetailPrice; //decimal(10,2) unsigned
	public $DriversPrice; //decimal(10,2) unsigned
	public $Discount; //decimal(10,2) unsigned
	public $ExtraCharge; //decimal(10,2) unsigned
	public $PaymentMethod; //int(3)
	public $PaymentStatus; //int(3)
	public $PayNow; //decimal(10,2) unsigned
	public $PayLater; //decimal(10,2) unsigned
	public $InvoiceAmount; //decimal(10,2)
	public $ProvisionAmount; //decimal(10,2)
	public $PaxNo; //tinyint(3) unsigned
	public $VehiclesNo; //tinyint(3) unsigned
	public $VehicleType; //varchar(100)
	public $VehicleID; //int(10)
	public $DriverID; //int(10) unsigned
	public $DriverName; //varchar(100)
	public $DriverEmail; //varchar(255)
	public $DriverTel; //varchar(100)
	public $DriverConfStatus; //int(3)
	public $DriverConfDate; //varchar(15)
	public $DriverConfTime; //varchar(15)
	public $DriverNotes; //text
	public $DriverPayment; //int(3)
	public $DriverPaymentAmt; //decimal(10,2)
	public $Rated; //varchar(25)
	public $DriverPickupDate; //varchar(10)
	public $DriverPickupTime; //varchar(8)
	public $SubDriver; //int(10)
	public $Car; //int(10)
	public $SubDriver2; //int(10)
	public $Car2; //int(10)
	public $SubDriver3; //int(10)
	public $Car3; //int(10)
	public $SubPickupDate; //date
	public $SubPickupTime; //varchar(255)
	public $SubFlightNo; //varchar(255)
	public $SubFlightTime; //varchar(50)
	public $TransferDuration; //varchar(5)
	public $PDFFile; //varchar(255)
	public $Extras; //text
	public $SubDriverNote; //text
	public $StaffNote; //text
	public $InvoiceNumber; //varchar(255)
	public $InvoiceDate; //date
	public $DriverInvoiceNumber; //varchar(255)
	public $DriverInvoiceDate; //date
	public $CashIn; //decimal(10,2)
	public $FinalNote; //text
	public $SubFinalNote; //text
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
	public function New_v4_OrderDetailsTemp($SiteID,$OrderID,$TNo,$UserID,$UserLevelID,$AgentID,$CustomerID,$TransferStatus,$OrderDate,$TaxidoComm,$ServiceID,$RouteID,$FlightNo,$FlightTime,$PaxName,$PickupID,$PickupName,$PickupPlace,$PickupAddress,$PickupDate,$PickupTime,$PickupNotes,$DropID,$DropName,$DropPlace,$DropAddress,$DropNotes,$PriceClassID,$DetailPrice,$DriversPrice,$Discount,$ExtraCharge,$PaymentMethod,$PaymentStatus,$PayNow,$PayLater,$InvoiceAmount,$ProvisionAmount,$PaxNo,$VehiclesNo,$VehicleType,$VehicleID,$DriverID,$DriverName,$DriverEmail,$DriverTel,$DriverConfStatus,$DriverConfDate,$DriverConfTime,$DriverNotes,$DriverPayment,$DriverPaymentAmt,$Rated,$DriverPickupDate,$DriverPickupTime,$SubDriver,$Car,$SubDriver2,$Car2,$SubDriver3,$Car3,$SubPickupDate,$SubPickupTime,$SubFlightNo,$SubFlightTime,$TransferDuration,$PDFFile,$Extras,$SubDriverNote,$StaffNote,$InvoiceNumber,$InvoiceDate,$DriverInvoiceNumber,$DriverInvoiceDate,$CashIn,$FinalNote,$SubFinalNote){
		$this->SiteID = $SiteID;
		$this->OrderID = $OrderID;
		$this->TNo = $TNo;
		$this->UserID = $UserID;
		$this->UserLevelID = $UserLevelID;
		$this->AgentID = $AgentID;
		$this->CustomerID = $CustomerID;
		$this->TransferStatus = $TransferStatus;
		$this->OrderDate = $OrderDate;
		$this->TaxidoComm = $TaxidoComm;
		$this->ServiceID = $ServiceID;
		$this->RouteID = $RouteID;
		$this->FlightNo = $FlightNo;
		$this->FlightTime = $FlightTime;
		$this->PaxName = $PaxName;
		$this->PickupID = $PickupID;
		$this->PickupName = $PickupName;
		$this->PickupPlace = $PickupPlace;
		$this->PickupAddress = $PickupAddress;
		$this->PickupDate = $PickupDate;
		$this->PickupTime = $PickupTime;
		$this->PickupNotes = $PickupNotes;
		$this->DropID = $DropID;
		$this->DropName = $DropName;
		$this->DropPlace = $DropPlace;
		$this->DropAddress = $DropAddress;
		$this->DropNotes = $DropNotes;
		$this->PriceClassID = $PriceClassID;
		$this->DetailPrice = $DetailPrice;
		$this->DriversPrice = $DriversPrice;
		$this->Discount = $Discount;
		$this->ExtraCharge = $ExtraCharge;
		$this->PaymentMethod = $PaymentMethod;
		$this->PaymentStatus = $PaymentStatus;
		$this->PayNow = $PayNow;
		$this->PayLater = $PayLater;
		$this->InvoiceAmount = $InvoiceAmount;
		$this->ProvisionAmount = $ProvisionAmount;
		$this->PaxNo = $PaxNo;
		$this->VehiclesNo = $VehiclesNo;
		$this->VehicleType = $VehicleType;
		$this->VehicleID = $VehicleID;
		$this->DriverID = $DriverID;
		$this->DriverName = $DriverName;
		$this->DriverEmail = $DriverEmail;
		$this->DriverTel = $DriverTel;
		$this->DriverConfStatus = $DriverConfStatus;
		$this->DriverConfDate = $DriverConfDate;
		$this->DriverConfTime = $DriverConfTime;
		$this->DriverNotes = $DriverNotes;
		$this->DriverPayment = $DriverPayment;
		$this->DriverPaymentAmt = $DriverPaymentAmt;
		$this->Rated = $Rated;
		$this->DriverPickupDate = $DriverPickupDate;
		$this->DriverPickupTime = $DriverPickupTime;
		$this->SubDriver = $SubDriver;
		$this->Car = $Car;
		$this->SubDriver2 = $SubDriver2;
		$this->Car2 = $Car2;
		$this->SubDriver3 = $SubDriver3;
		$this->Car3 = $Car3;
		$this->SubPickupDate = $SubPickupDate;
		$this->SubPickupTime = $SubPickupTime;
		$this->SubFlightNo = $SubFlightNo;
		$this->SubFlightTime = $SubFlightTime;
		$this->TransferDuration = $TransferDuration;
		$this->PDFFile = $PDFFile;
		$this->Extras = $Extras;
		$this->SubDriverNote = $SubDriverNote;
		$this->StaffNote = $StaffNote;
		$this->InvoiceNumber = $InvoiceNumber;
		$this->InvoiceDate = $InvoiceDate;
		$this->DriverInvoiceNumber = $DriverInvoiceNumber;
		$this->DriverInvoiceDate = $DriverInvoiceDate;
		$this->CashIn = $CashIn;
		$this->FinalNote = $FinalNote;
		$this->SubFinalNote = $SubFinalNote;
	}

    /**
     * Load one row into var_class. To use the vars use for exemple echo $class->getVar_name; 
     *
     * @param key_table_type $key_row
     * 
     */
	public function getRow($key_row){
		$result = $this->connection->RunQuery("Select * from v4_OrderDetailsTemp where DetailsID = \"$key_row\" ");
		if($result->num_rows < 1) return false;
		while($row = $result->fetch_array(MYSQLI_ASSOC)){
			$this->SiteID = $row["SiteID"];
			$this->DetailsID = $row["DetailsID"];
			$this->OrderID = $row["OrderID"];
			$this->TNo = $row["TNo"];
			$this->UserID = $row["UserID"];
			$this->UserLevelID = $row["UserLevelID"];
			$this->AgentID = $row["AgentID"];
			$this->CustomerID = $row["CustomerID"];
			$this->TransferStatus = $row["TransferStatus"];
			$this->OrderDate = $row["OrderDate"];
			$this->TaxidoComm = $row["TaxidoComm"];
			$this->ServiceID = $row["ServiceID"];
			$this->RouteID = $row["RouteID"];
			$this->FlightNo = $row["FlightNo"];
			$this->FlightTime = $row["FlightTime"];
			$this->PaxName = $row["PaxName"];
			$this->PickupID = $row["PickupID"];
			$this->PickupName = $row["PickupName"];
			$this->PickupPlace = $row["PickupPlace"];
			$this->PickupAddress = $row["PickupAddress"];
			$this->PickupDate = $row["PickupDate"];
			$this->PickupTime = $row["PickupTime"];
			$this->PickupNotes = $row["PickupNotes"];
			$this->DropID = $row["DropID"];
			$this->DropName = $row["DropName"];
			$this->DropPlace = $row["DropPlace"];
			$this->DropAddress = $row["DropAddress"];
			$this->DropNotes = $row["DropNotes"];
			$this->PriceClassID = $row["PriceClassID"];
			$this->DetailPrice = $row["DetailPrice"];
			$this->DriversPrice = $row["DriversPrice"];
			$this->Discount = $row["Discount"];
			$this->ExtraCharge = $row["ExtraCharge"];
			$this->PaymentMethod = $row["PaymentMethod"];
			$this->PaymentStatus = $row["PaymentStatus"];
			$this->PayNow = $row["PayNow"];
			$this->PayLater = $row["PayLater"];
			$this->InvoiceAmount = $row["InvoiceAmount"];
			$this->ProvisionAmount = $row["ProvisionAmount"];
			$this->PaxNo = $row["PaxNo"];
			$this->VehiclesNo = $row["VehiclesNo"];
			$this->VehicleType = $row["VehicleType"];
			$this->VehicleID = $row["VehicleID"];
			$this->DriverID = $row["DriverID"];
			$this->DriverName = $row["DriverName"];
			$this->DriverEmail = $row["DriverEmail"];
			$this->DriverTel = $row["DriverTel"];
			$this->DriverConfStatus = $row["DriverConfStatus"];
			$this->DriverConfDate = $row["DriverConfDate"];
			$this->DriverConfTime = $row["DriverConfTime"];
			$this->DriverNotes = $row["DriverNotes"];
			$this->DriverPayment = $row["DriverPayment"];
			$this->DriverPaymentAmt = $row["DriverPaymentAmt"];
			$this->Rated = $row["Rated"];
			$this->DriverPickupDate = $row["DriverPickupDate"];
			$this->DriverPickupTime = $row["DriverPickupTime"];
			$this->SubDriver = $row["SubDriver"];
			$this->Car = $row["Car"];
			$this->SubDriver2 = $row["SubDriver2"];
			$this->Car2 = $row["Car2"];
			$this->SubDriver3 = $row["SubDriver3"];
			$this->Car3 = $row["Car3"];
			$this->SubPickupDate = $row["SubPickupDate"];
			$this->SubPickupTime = $row["SubPickupTime"];
			$this->SubFlightNo = $row["SubFlightNo"];
			$this->SubFlightTime = $row["SubFlightTime"];
			$this->TransferDuration = $row["TransferDuration"];
			$this->PDFFile = $row["PDFFile"];
			$this->Extras = $row["Extras"];
			$this->SubDriverNote = $row["SubDriverNote"];
			$this->StaffNote = $row["StaffNote"];
			$this->InvoiceNumber = $row["InvoiceNumber"];
			$this->InvoiceDate = $row["InvoiceDate"];
			$this->DriverInvoiceNumber = $row["DriverInvoiceNumber"];
			$this->DriverInvoiceDate = $row["DriverInvoiceDate"];
			$this->CashIn = $row["CashIn"];
			$this->FinalNote = $row["FinalNote"];
			$this->SubFinalNote = $row["SubFinalNote"];
		}
	}

    /**
     * Delete the row by using the key as arg
     *
     * @param key_table_type $key_row
     *
     */
	public function deleteRow($key_row){
		$this->connection->RunQuery("DELETE FROM v4_OrderDetailsTemp WHERE DetailsID = $key_row");
	}

    /**
     * Update the active row table on table
     */
	public function saveRow(){
		$result = $this->connection->RunQuery("UPDATE v4_OrderDetailsTemp set 
SiteID = '".$this->myreal_escape_string($this->SiteID)."', 
OrderID = '".$this->myreal_escape_string($this->OrderID)."', 
TNo = '".$this->myreal_escape_string($this->TNo)."', 
UserID = '".$this->myreal_escape_string($this->UserID)."', 
UserLevelID = '".$this->myreal_escape_string($this->UserLevelID)."', 
AgentID = '".$this->myreal_escape_string($this->AgentID)."', 
CustomerID = '".$this->myreal_escape_string($this->CustomerID)."', 
TransferStatus = '".$this->myreal_escape_string($this->TransferStatus)."', 
OrderDate = '".$this->myreal_escape_string($this->OrderDate)."', 
TaxidoComm = '".$this->myreal_escape_string($this->TaxidoComm)."', 
ServiceID = '".$this->myreal_escape_string($this->ServiceID)."', 
RouteID = '".$this->myreal_escape_string($this->RouteID)."', 
FlightNo = '".$this->myreal_escape_string($this->FlightNo)."', 
FlightTime = '".$this->myreal_escape_string($this->FlightTime)."', 
PaxName = '".$this->myreal_escape_string($this->PaxName)."', 
PickupID = '".$this->myreal_escape_string($this->PickupID)."', 
PickupName = '".$this->myreal_escape_string($this->PickupName)."', 
PickupPlace = '".$this->myreal_escape_string($this->PickupPlace)."', 
PickupAddress = '".$this->myreal_escape_string($this->PickupAddress)."', 
PickupDate = '".$this->myreal_escape_string($this->PickupDate)."', 
PickupTime = '".$this->myreal_escape_string($this->PickupTime)."', 
PickupNotes = '".$this->myreal_escape_string($this->PickupNotes)."', 
DropID = '".$this->myreal_escape_string($this->DropID)."', 
DropName = '".$this->myreal_escape_string($this->DropName)."', 
DropPlace = '".$this->myreal_escape_string($this->DropPlace)."', 
DropAddress = '".$this->myreal_escape_string($this->DropAddress)."', 
DropNotes = '".$this->myreal_escape_string($this->DropNotes)."', 
PriceClassID = '".$this->myreal_escape_string($this->PriceClassID)."', 
DetailPrice = '".$this->myreal_escape_string($this->DetailPrice)."', 
DriversPrice = '".$this->myreal_escape_string($this->DriversPrice)."', 
Discount = '".$this->myreal_escape_string($this->Discount)."', 
ExtraCharge = '".$this->myreal_escape_string($this->ExtraCharge)."', 
PaymentMethod = '".$this->myreal_escape_string($this->PaymentMethod)."', 
PaymentStatus = '".$this->myreal_escape_string($this->PaymentStatus)."', 
PayNow = '".$this->myreal_escape_string($this->PayNow)."', 
PayLater = '".$this->myreal_escape_string($this->PayLater)."', 
InvoiceAmount = '".$this->myreal_escape_string($this->InvoiceAmount)."', 
ProvisionAmount = '".$this->myreal_escape_string($this->ProvisionAmount)."', 
PaxNo = '".$this->myreal_escape_string($this->PaxNo)."', 
VehiclesNo = '".$this->myreal_escape_string($this->VehiclesNo)."', 
VehicleType = '".$this->myreal_escape_string($this->VehicleType)."', 
VehicleID = '".$this->myreal_escape_string($this->VehicleID)."', 
DriverID = '".$this->myreal_escape_string($this->DriverID)."', 
DriverName = '".$this->myreal_escape_string($this->DriverName)."', 
DriverEmail = '".$this->myreal_escape_string($this->DriverEmail)."', 
DriverTel = '".$this->myreal_escape_string($this->DriverTel)."', 
DriverConfStatus = '".$this->myreal_escape_string($this->DriverConfStatus)."', 
DriverConfDate = '".$this->myreal_escape_string($this->DriverConfDate)."', 
DriverConfTime = '".$this->myreal_escape_string($this->DriverConfTime)."', 
DriverNotes = '".$this->myreal_escape_string($this->DriverNotes)."', 
DriverPayment = '".$this->myreal_escape_string($this->DriverPayment)."', 
DriverPaymentAmt = '".$this->myreal_escape_string($this->DriverPaymentAmt)."', 
Rated = '".$this->myreal_escape_string($this->Rated)."', 
DriverPickupDate = '".$this->myreal_escape_string($this->DriverPickupDate)."', 
DriverPickupTime = '".$this->myreal_escape_string($this->DriverPickupTime)."', 
SubDriver = '".$this->myreal_escape_string($this->SubDriver)."', 
Car = '".$this->myreal_escape_string($this->Car)."', 
SubDriver2 = '".$this->myreal_escape_string($this->SubDriver2)."', 
Car2 = '".$this->myreal_escape_string($this->Car2)."', 
SubDriver3 = '".$this->myreal_escape_string($this->SubDriver3)."', 
Car3 = '".$this->myreal_escape_string($this->Car3)."', 
SubPickupDate = '".$this->myreal_escape_string($this->SubPickupDate)."', 
SubPickupTime = '".$this->myreal_escape_string($this->SubPickupTime)."', 
SubFlightNo = '".$this->myreal_escape_string($this->SubFlightNo)."', 
SubFlightTime = '".$this->myreal_escape_string($this->SubFlightTime)."', 
TransferDuration = '".$this->myreal_escape_string($this->TransferDuration)."', 
PDFFile = '".$this->myreal_escape_string($this->PDFFile)."', 
Extras = '".$this->myreal_escape_string($this->Extras)."', 
SubDriverNote = '".$this->myreal_escape_string($this->SubDriverNote)."', 
StaffNote = '".$this->myreal_escape_string($this->StaffNote)."', 
InvoiceNumber = '".$this->myreal_escape_string($this->InvoiceNumber)."', 
InvoiceDate = '".$this->myreal_escape_string($this->InvoiceDate)."', 
DriverInvoiceNumber = '".$this->myreal_escape_string($this->DriverInvoiceNumber)."', 
DriverInvoiceDate = '".$this->myreal_escape_string($this->DriverInvoiceDate)."', 
CashIn = '".$this->myreal_escape_string($this->CashIn)."', 
FinalNote = '".$this->myreal_escape_string($this->FinalNote)."', 
SubFinalNote = '".$this->myreal_escape_string($this->SubFinalNote)."' WHERE DetailsID = '".$this->DetailsID."'");
	return $result; 
}

    /**
     * Save the active var class as a new row on table
     */
	public function saveAsNew(){
		$this->connection->RunQuery("INSERT INTO v4_OrderDetailsTemp (SiteID, OrderID, TNo, UserID, UserLevelID, AgentID, CustomerID, TransferStatus, OrderDate, TaxidoComm, ServiceID, RouteID, FlightNo, FlightTime, PaxName, PickupID, PickupName, PickupPlace, PickupAddress, PickupDate, PickupTime, PickupNotes, DropID, DropName, DropPlace, DropAddress, DropNotes, PriceClassID, DetailPrice, DriversPrice, Discount, ExtraCharge, PaymentMethod, PaymentStatus, PayNow, PayLater, InvoiceAmount, ProvisionAmount, PaxNo, VehiclesNo, VehicleType, VehicleID, DriverID, DriverName, DriverEmail, DriverTel, DriverConfStatus, DriverConfDate, DriverConfTime, DriverNotes, DriverPayment, DriverPaymentAmt, Rated, DriverPickupDate, DriverPickupTime, SubDriver, Car, SubDriver2, Car2, SubDriver3, Car3, SubPickupDate, SubPickupTime, SubFlightNo, SubFlightTime, TransferDuration, PDFFile, Extras, SubDriverNote, StaffNote, InvoiceNumber, InvoiceDate, DriverInvoiceNumber, DriverInvoiceDate, CashIn, FinalNote, SubFinalNote) values ('".$this->myreal_escape_string($this->SiteID)."', '".$this->myreal_escape_string($this->OrderID)."', '".$this->myreal_escape_string($this->TNo)."', '".$this->myreal_escape_string($this->UserID)."', '".$this->myreal_escape_string($this->UserLevelID)."', '".$this->myreal_escape_string($this->AgentID)."', '".$this->myreal_escape_string($this->CustomerID)."', '".$this->myreal_escape_string($this->TransferStatus)."', '".$this->myreal_escape_string($this->OrderDate)."', '".$this->myreal_escape_string($this->TaxidoComm)."', '".$this->myreal_escape_string($this->ServiceID)."', '".$this->myreal_escape_string($this->RouteID)."', '".$this->myreal_escape_string($this->FlightNo)."', '".$this->myreal_escape_string($this->FlightTime)."', '".$this->myreal_escape_string($this->PaxName)."', '".$this->myreal_escape_string($this->PickupID)."', '".$this->myreal_escape_string($this->PickupName)."', '".$this->myreal_escape_string($this->PickupPlace)."', '".$this->myreal_escape_string($this->PickupAddress)."', '".$this->myreal_escape_string($this->PickupDate)."', '".$this->myreal_escape_string($this->PickupTime)."', '".$this->myreal_escape_string($this->PickupNotes)."', '".$this->myreal_escape_string($this->DropID)."', '".$this->myreal_escape_string($this->DropName)."', '".$this->myreal_escape_string($this->DropPlace)."', '".$this->myreal_escape_string($this->DropAddress)."', '".$this->myreal_escape_string($this->DropNotes)."', '".$this->myreal_escape_string($this->PriceClassID)."', '".$this->myreal_escape_string($this->DetailPrice)."', '".$this->myreal_escape_string($this->DriversPrice)."', '".$this->myreal_escape_string($this->Discount)."', '".$this->myreal_escape_string($this->ExtraCharge)."', '".$this->myreal_escape_string($this->PaymentMethod)."', '".$this->myreal_escape_string($this->PaymentStatus)."', '".$this->myreal_escape_string($this->PayNow)."', '".$this->myreal_escape_string($this->PayLater)."', '".$this->myreal_escape_string($this->InvoiceAmount)."', '".$this->myreal_escape_string($this->ProvisionAmount)."', '".$this->myreal_escape_string($this->PaxNo)."', '".$this->myreal_escape_string($this->VehiclesNo)."', '".$this->myreal_escape_string($this->VehicleType)."', '".$this->myreal_escape_string($this->VehicleID)."', '".$this->myreal_escape_string($this->DriverID)."', '".$this->myreal_escape_string($this->DriverName)."', '".$this->myreal_escape_string($this->DriverEmail)."', '".$this->myreal_escape_string($this->DriverTel)."', '".$this->myreal_escape_string($this->DriverConfStatus)."', '".$this->myreal_escape_string($this->DriverConfDate)."', '".$this->myreal_escape_string($this->DriverConfTime)."', '".$this->myreal_escape_string($this->DriverNotes)."', '".$this->myreal_escape_string($this->DriverPayment)."', '".$this->myreal_escape_string($this->DriverPaymentAmt)."', '".$this->myreal_escape_string($this->Rated)."', '".$this->myreal_escape_string($this->DriverPickupDate)."', '".$this->myreal_escape_string($this->DriverPickupTime)."', '".$this->myreal_escape_string($this->SubDriver)."', '".$this->myreal_escape_string($this->Car)."', '".$this->myreal_escape_string($this->SubDriver2)."', '".$this->myreal_escape_string($this->Car2)."', '".$this->myreal_escape_string($this->SubDriver3)."', '".$this->myreal_escape_string($this->Car3)."', '".$this->myreal_escape_string($this->SubPickupDate)."', '".$this->myreal_escape_string($this->SubPickupTime)."', '".$this->myreal_escape_string($this->SubFlightNo)."', '".$this->myreal_escape_string($this->SubFlightTime)."', '".$this->myreal_escape_string($this->TransferDuration)."', '".$this->myreal_escape_string($this->PDFFile)."', '".$this->myreal_escape_string($this->Extras)."', '".$this->myreal_escape_string($this->SubDriverNote)."', '".$this->myreal_escape_string($this->StaffNote)."', '".$this->myreal_escape_string($this->InvoiceNumber)."', '".$this->myreal_escape_string($this->InvoiceDate)."', '".$this->myreal_escape_string($this->DriverInvoiceNumber)."', '".$this->myreal_escape_string($this->DriverInvoiceDate)."', '".$this->myreal_escape_string($this->CashIn)."', '".$this->myreal_escape_string($this->FinalNote)."', '".$this->myreal_escape_string($this->SubFinalNote)."')");
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
		$result = $this->connection->RunQuery("SELECT DetailsID from v4_OrderDetailsTemp $where ORDER BY $column $order");
			while($row = $result->fetch_array(MYSQLI_ASSOC)){
				$keys[$i] = $row["DetailsID"];
				$i++;
			}
	return $keys;
	}

	public function getKeysByNoSort($where = NULL){
		$keys = array(); $i = 0;
		$result = $this->connection->RunQuery("SELECT DetailsID from v4_OrderDetailsTemp $where");
			while($row = $result->fetch_array(MYSQLI_ASSOC)){
				$keys[$i] = $row["DetailsID"];
				$i++;
			}
	return $keys;
	}
	
	/**
	 * @return SiteID - int(3)
	 */
	public function getSiteID(){
		return $this->SiteID;
	}

	/**
	 * @return DetailsID - int(10) unsigned
	 */
	public function getDetailsID(){
		return $this->DetailsID;
	}

	/**
	 * @return OrderID - int(10) unsigned
	 */
	public function getOrderID(){
		return $this->OrderID;
	}

	/**
	 * @return TNo - tinyint(4)
	 */
	public function getTNo(){
		return $this->TNo;
	}

	/**
	 * @return UserID - int(10)
	 */
	public function getUserID(){
		return $this->UserID;
	}

	/**
	 * @return UserLevelID - int(3)
	 */
	public function getUserLevelID(){
		return $this->UserLevelID;
	}

	/**
	 * @return AgentID - int(10)
	 */
	public function getAgentID(){
		return $this->AgentID;
	}

	/**
	 * @return CustomerID - int(10)
	 */
	public function getCustomerID(){
		return $this->CustomerID;
	}

	/**
	 * @return TransferStatus - tinyint(3) unsigned
	 */
	public function getTransferStatus(){
		return $this->TransferStatus;
	}

	/**
	 * @return OrderDate - varchar(10)
	 */
	public function getOrderDate(){
		return $this->OrderDate;
	}

	/**
	 * @return TaxidoComm - decimal(10,2) unsigned
	 */
	public function getTaxidoComm(){
		return $this->TaxidoComm;
	}

	/**
	 * @return ServiceID - int(10) unsigned
	 */
	public function getServiceID(){
		return $this->ServiceID;
	}

	/**
	 * @return RouteID - int(10) unsigned
	 */
	public function getRouteID(){
		return $this->RouteID;
	}

	/**
	 * @return FlightNo - varchar(100)
	 */
	public function getFlightNo(){
		return $this->FlightNo;
	}

	/**
	 * @return FlightTime - varchar(15)
	 */
	public function getFlightTime(){
		return $this->FlightTime;
	}

	/**
	 * @return PaxName - varchar(255)
	 */
	public function getPaxName(){
		return $this->PaxName;
	}

	/**
	 * @return PickupID - int(10) unsigned
	 */
	public function getPickupID(){
		return $this->PickupID;
	}

	/**
	 * @return PickupName - varchar(100)
	 */
	public function getPickupName(){
		return $this->PickupName;
	}

	/**
	 * @return PickupPlace - varchar(100)
	 */
	public function getPickupPlace(){
		return $this->PickupPlace;
	}

	/**
	 * @return PickupAddress - varchar(100)
	 */
	public function getPickupAddress(){
		return $this->PickupAddress;
	}

	/**
	 * @return PickupDate - varchar(15)
	 */
	public function getPickupDate(){
		return $this->PickupDate;
	}

	/**
	 * @return PickupTime - varchar(15)
	 */
	public function getPickupTime(){
		return $this->PickupTime;
	}

	/**
	 * @return PickupNotes - text
	 */
	public function getPickupNotes(){
		return $this->PickupNotes;
	}

	/**
	 * @return DropID - int(10) unsigned
	 */
	public function getDropID(){
		return $this->DropID;
	}

	/**
	 * @return DropName - varchar(100)
	 */
	public function getDropName(){
		return $this->DropName;
	}

	/**
	 * @return DropPlace - varchar(100)
	 */
	public function getDropPlace(){
		return $this->DropPlace;
	}

	/**
	 * @return DropAddress - varchar(100)
	 */
	public function getDropAddress(){
		return $this->DropAddress;
	}

	/**
	 * @return DropNotes - text
	 */
	public function getDropNotes(){
		return $this->DropNotes;
	}

	/**
	 * @return PriceClassID - tinyint(3) unsigned
	 */
	public function getPriceClassID(){
		return $this->PriceClassID;
	}

	/**
	 * @return DetailPrice - decimal(10,2) unsigned
	 */
	public function getDetailPrice(){
		return $this->DetailPrice;
	}

	/**
	 * @return DriversPrice - decimal(10,2) unsigned
	 */
	public function getDriversPrice(){
		return $this->DriversPrice;
	}

	/**
	 * @return Discount - decimal(10,2) unsigned
	 */
	public function getDiscount(){
		return $this->Discount;
	}

	/**
	 * @return ExtraCharge - decimal(10,2) unsigned
	 */
	public function getExtraCharge(){
		return $this->ExtraCharge;
	}

	/**
	 * @return PaymentMethod - int(3)
	 */
	public function getPaymentMethod(){
		return $this->PaymentMethod;
	}

	/**
	 * @return PaymentStatus - int(3)
	 */
	public function getPaymentStatus(){
		return $this->PaymentStatus;
	}

	/**
	 * @return PayNow - decimal(10,2) unsigned
	 */
	public function getPayNow(){
		return $this->PayNow;
	}

	/**
	 * @return PayLater - decimal(10,2) unsigned
	 */
	public function getPayLater(){
		return $this->PayLater;
	}

	/**
	 * @return InvoiceAmount - decimal(10,2)
	 */
	public function getInvoiceAmount(){
		return $this->InvoiceAmount;
	}

	/**
	 * @return ProvisionAmount - decimal(10,2)
	 */
	public function getProvisionAmount(){
		return $this->ProvisionAmount;
	}

	/**
	 * @return PaxNo - tinyint(3) unsigned
	 */
	public function getPaxNo(){
		return $this->PaxNo;
	}

	/**
	 * @return VehiclesNo - tinyint(3) unsigned
	 */
	public function getVehiclesNo(){
		return $this->VehiclesNo;
	}

	/**
	 * @return VehicleType - varchar(100)
	 */
	public function getVehicleType(){
		return $this->VehicleType;
	}

	/**
	 * @return VehicleID - int(10)
	 */
	public function getVehicleID(){
		return $this->VehicleID;
	}

	/**
	 * @return DriverID - int(10) unsigned
	 */
	public function getDriverID(){
		return $this->DriverID;
	}

	/**
	 * @return DriverName - varchar(100)
	 */
	public function getDriverName(){
		return $this->DriverName;
	}

	/**
	 * @return DriverEmail - varchar(255)
	 */
	public function getDriverEmail(){
		return $this->DriverEmail;
	}

	/**
	 * @return DriverTel - varchar(100)
	 */
	public function getDriverTel(){
		return $this->DriverTel;
	}

	/**
	 * @return DriverConfStatus - int(3)
	 */
	public function getDriverConfStatus(){
		return $this->DriverConfStatus;
	}

	/**
	 * @return DriverConfDate - varchar(15)
	 */
	public function getDriverConfDate(){
		return $this->DriverConfDate;
	}

	/**
	 * @return DriverConfTime - varchar(15)
	 */
	public function getDriverConfTime(){
		return $this->DriverConfTime;
	}

	/**
	 * @return DriverNotes - text
	 */
	public function getDriverNotes(){
		return $this->DriverNotes;
	}

	/**
	 * @return DriverPayment - int(3)
	 */
	public function getDriverPayment(){
		return $this->DriverPayment;
	}

	/**
	 * @return DriverPaymentAmt - decimal(10,2)
	 */
	public function getDriverPaymentAmt(){
		return $this->DriverPaymentAmt;
	}

	/**
	 * @return Rated - varchar(25)
	 */
	public function getRated(){
		return $this->Rated;
	}

	/**
	 * @return DriverPickupDate - varchar(10)
	 */
	public function getDriverPickupDate(){
		return $this->DriverPickupDate;
	}

	/**
	 * @return DriverPickupTime - varchar(8)
	 */
	public function getDriverPickupTime(){
		return $this->DriverPickupTime;
	}

	/**
	 * @return SubDriver - int(10)
	 */
	public function getSubDriver(){
		return $this->SubDriver;
	}

	/**
	 * @return Car - int(10)
	 */
	public function getCar(){
		return $this->Car;
	}

	/**
	 * @return SubDriver2 - int(10)
	 */
	public function getSubDriver2(){
		return $this->SubDriver2;
	}

	/**
	 * @return Car2 - int(10)
	 */
	public function getCar2(){
		return $this->Car2;
	}

	/**
	 * @return SubDriver3 - int(10)
	 */
	public function getSubDriver3(){
		return $this->SubDriver3;
	}

	/**
	 * @return Car3 - int(10)
	 */
	public function getCar3(){
		return $this->Car3;
	}

	/**
	 * @return SubPickupDate - date
	 */
	public function getSubPickupDate(){
		return $this->SubPickupDate;
	}

	/**
	 * @return SubPickupTime - varchar(255)
	 */
	public function getSubPickupTime(){
		return $this->SubPickupTime;
	}

	/**
	 * @return SubFlightNo - varchar(255)
	 */
	public function getSubFlightNo(){
		return $this->SubFlightNo;
	}

	/**
	 * @return SubFlightTime - varchar(50)
	 */
	public function getSubFlightTime(){
		return $this->SubFlightTime;
	}

	/**
	 * @return TransferDuration - varchar(5)
	 */
	public function getTransferDuration(){
		return $this->TransferDuration;
	}

	/**
	 * @return PDFFile - varchar(255)
	 */
	public function getPDFFile(){
		return $this->PDFFile;
	}

	/**
	 * @return Extras - text
	 */
	public function getExtras(){
		return $this->Extras;
	}

	/**
	 * @return SubDriverNote - text
	 */
	public function getSubDriverNote(){
		return $this->SubDriverNote;
	}

	/**
	 * @return StaffNote - text
	 */
	public function getStaffNote(){
		return $this->StaffNote;
	}

	/**
	 * @return InvoiceNumber - varchar(255)
	 */
	public function getInvoiceNumber(){
		return $this->InvoiceNumber;
	}

	/**
	 * @return InvoiceDate - date
	 */
	public function getInvoiceDate(){
		return $this->InvoiceDate;
	}

	/**
	 * @return DriverInvoiceNumber - varchar(255)
	 */
	public function getDriverInvoiceNumber(){
		return $this->DriverInvoiceNumber;
	}

	/**
	 * @return DriverInvoiceDate - date
	 */
	public function getDriverInvoiceDate(){
		return $this->DriverInvoiceDate;
	}

	/**
	 * @return CashIn - decimal(10,2)
	 */
	public function getCashIn(){
		return $this->CashIn;
	}

	/**
	 * @return FinalNote - text
	 */
	public function getFinalNote(){
		return $this->FinalNote;
	}

	/**
	 * @return SubFinalNote - text
	 */
	public function getSubFinalNote(){
		return $this->SubFinalNote;
	}

	/**
	 * @param Type: int(3)
	 */
	public function setSiteID($SiteID){
		$this->SiteID = $SiteID;
	}

	/**
	 * @param Type: int(10) unsigned
	 */
	public function setDetailsID($DetailsID){
		$this->DetailsID = $DetailsID;
	}

	/**
	 * @param Type: int(10) unsigned
	 */
	public function setOrderID($OrderID){
		$this->OrderID = $OrderID;
	}

	/**
	 * @param Type: tinyint(4)
	 */
	public function setTNo($TNo){
		$this->TNo = $TNo;
	}

	/**
	 * @param Type: int(10)
	 */
	public function setUserID($UserID){
		$this->UserID = $UserID;
	}

	/**
	 * @param Type: int(3)
	 */
	public function setUserLevelID($UserLevelID){
		$this->UserLevelID = $UserLevelID;
	}

	/**
	 * @param Type: int(10)
	 */
	public function setAgentID($AgentID){
		$this->AgentID = $AgentID;
	}

	/**
	 * @param Type: int(10)
	 */
	public function setCustomerID($CustomerID){
		$this->CustomerID = $CustomerID;
	}

	/**
	 * @param Type: tinyint(3) unsigned
	 */
	public function setTransferStatus($TransferStatus){
		$this->TransferStatus = $TransferStatus;
	}

	/**
	 * @param Type: varchar(10)
	 */
	public function setOrderDate($OrderDate){
		$this->OrderDate = $OrderDate;
	}

	/**
	 * @param Type: decimal(10,2) unsigned
	 */
	public function setTaxidoComm($TaxidoComm){
		$this->TaxidoComm = $TaxidoComm;
	}

	/**
	 * @param Type: int(10) unsigned
	 */
	public function setServiceID($ServiceID){
		$this->ServiceID = $ServiceID;
	}

	/**
	 * @param Type: int(10) unsigned
	 */
	public function setRouteID($RouteID){
		$this->RouteID = $RouteID;
	}

	/**
	 * @param Type: varchar(100)
	 */
	public function setFlightNo($FlightNo){
		$this->FlightNo = $FlightNo;
	}

	/**
	 * @param Type: varchar(15)
	 */
	public function setFlightTime($FlightTime){
		$this->FlightTime = $FlightTime;
	}

	/**
	 * @param Type: varchar(255)
	 */
	public function setPaxName($PaxName){
		$this->PaxName = $PaxName;
	}

	/**
	 * @param Type: int(10) unsigned
	 */
	public function setPickupID($PickupID){
		$this->PickupID = $PickupID;
	}

	/**
	 * @param Type: varchar(100)
	 */
	public function setPickupName($PickupName){
		$this->PickupName = $PickupName;
	}

	/**
	 * @param Type: varchar(100)
	 */
	public function setPickupPlace($PickupPlace){
		$this->PickupPlace = $PickupPlace;
	}

	/**
	 * @param Type: varchar(100)
	 */
	public function setPickupAddress($PickupAddress){
		$this->PickupAddress = $PickupAddress;
	}

	/**
	 * @param Type: varchar(15)
	 */
	public function setPickupDate($PickupDate){
		$this->PickupDate = $PickupDate;
	}

	/**
	 * @param Type: varchar(15)
	 */
	public function setPickupTime($PickupTime){
		$this->PickupTime = $PickupTime;
	}

	/**
	 * @param Type: text
	 */
	public function setPickupNotes($PickupNotes){
		$this->PickupNotes = $PickupNotes;
	}

	/**
	 * @param Type: int(10) unsigned
	 */
	public function setDropID($DropID){
		$this->DropID = $DropID;
	}

	/**
	 * @param Type: varchar(100)
	 */
	public function setDropName($DropName){
		$this->DropName = $DropName;
	}

	/**
	 * @param Type: varchar(100)
	 */
	public function setDropPlace($DropPlace){
		$this->DropPlace = $DropPlace;
	}

	/**
	 * @param Type: varchar(100)
	 */
	public function setDropAddress($DropAddress){
		$this->DropAddress = $DropAddress;
	}

	/**
	 * @param Type: text
	 */
	public function setDropNotes($DropNotes){
		$this->DropNotes = $DropNotes;
	}

	/**
	 * @param Type: tinyint(3) unsigned
	 */
	public function setPriceClassID($PriceClassID){
		$this->PriceClassID = $PriceClassID;
	}

	/**
	 * @param Type: decimal(10,2) unsigned
	 */
	public function setDetailPrice($DetailPrice){
		$this->DetailPrice = $DetailPrice;
	}

	/**
	 * @param Type: decimal(10,2) unsigned
	 */
	public function setDriversPrice($DriversPrice){
		$this->DriversPrice = $DriversPrice;
	}

	/**
	 * @param Type: decimal(10,2) unsigned
	 */
	public function setDiscount($Discount){
		$this->Discount = $Discount;
	}

	/**
	 * @param Type: decimal(10,2) unsigned
	 */
	public function setExtraCharge($ExtraCharge){
		$this->ExtraCharge = $ExtraCharge;
	}

	/**
	 * @param Type: int(3)
	 */
	public function setPaymentMethod($PaymentMethod){
		$this->PaymentMethod = $PaymentMethod;
	}

	/**
	 * @param Type: int(3)
	 */
	public function setPaymentStatus($PaymentStatus){
		$this->PaymentStatus = $PaymentStatus;
	}

	/**
	 * @param Type: decimal(10,2) unsigned
	 */
	public function setPayNow($PayNow){
		$this->PayNow = $PayNow;
	}

	/**
	 * @param Type: decimal(10,2) unsigned
	 */
	public function setPayLater($PayLater){
		$this->PayLater = $PayLater;
	}

	/**
	 * @param Type: decimal(10,2)
	 */
	public function setInvoiceAmount($InvoiceAmount){
		$this->InvoiceAmount = $InvoiceAmount;
	}

	/**
	 * @param Type: decimal(10,2)
	 */
	public function setProvisionAmount($ProvisionAmount){
		$this->ProvisionAmount = $ProvisionAmount;
	}

	/**
	 * @param Type: tinyint(3) unsigned
	 */
	public function setPaxNo($PaxNo){
		$this->PaxNo = $PaxNo;
	}

	/**
	 * @param Type: tinyint(3) unsigned
	 */
	public function setVehiclesNo($VehiclesNo){
		$this->VehiclesNo = $VehiclesNo;
	}

	/**
	 * @param Type: varchar(100)
	 */
	public function setVehicleType($VehicleType){
		$this->VehicleType = $VehicleType;
	}

	/**
	 * @param Type: int(10)
	 */
	public function setVehicleID($VehicleID){
		$this->VehicleID = $VehicleID;
	}

	/**
	 * @param Type: int(10) unsigned
	 */
	public function setDriverID($DriverID){
		$this->DriverID = $DriverID;
	}

	/**
	 * @param Type: varchar(100)
	 */
	public function setDriverName($DriverName){
		$this->DriverName = $DriverName;
	}

	/**
	 * @param Type: varchar(255)
	 */
	public function setDriverEmail($DriverEmail){
		$this->DriverEmail = $DriverEmail;
	}

	/**
	 * @param Type: varchar(100)
	 */
	public function setDriverTel($DriverTel){
		$this->DriverTel = $DriverTel;
	}

	/**
	 * @param Type: int(3)
	 */
	public function setDriverConfStatus($DriverConfStatus){
		$this->DriverConfStatus = $DriverConfStatus;
	}

	/**
	 * @param Type: varchar(15)
	 */
	public function setDriverConfDate($DriverConfDate){
		$this->DriverConfDate = $DriverConfDate;
	}

	/**
	 * @param Type: varchar(15)
	 */
	public function setDriverConfTime($DriverConfTime){
		$this->DriverConfTime = $DriverConfTime;
	}

	/**
	 * @param Type: text
	 */
	public function setDriverNotes($DriverNotes){
		$this->DriverNotes = $DriverNotes;
	}

	/**
	 * @param Type: int(3)
	 */
	public function setDriverPayment($DriverPayment){
		$this->DriverPayment = $DriverPayment;
	}

	/**
	 * @param Type: decimal(10,2)
	 */
	public function setDriverPaymentAmt($DriverPaymentAmt){
		$this->DriverPaymentAmt = $DriverPaymentAmt;
	}

	/**
	 * @param Type: varchar(25)
	 */
	public function setRated($Rated){
		$this->Rated = $Rated;
	}

	/**
	 * @param Type: varchar(10)
	 */
	public function setDriverPickupDate($DriverPickupDate){
		$this->DriverPickupDate = $DriverPickupDate;
	}

	/**
	 * @param Type: varchar(8)
	 */
	public function setDriverPickupTime($DriverPickupTime){
		$this->DriverPickupTime = $DriverPickupTime;
	}

	/**
	 * @param Type: int(10)
	 */
	public function setSubDriver($SubDriver){
		$this->SubDriver = $SubDriver;
	}

	/**
	 * @param Type: int(10)
	 */
	public function setCar($Car){
		$this->Car = $Car;
	}

	/**
	 * @param Type: int(10)
	 */
	public function setSubDriver2($SubDriver2){
		$this->SubDriver2 = $SubDriver2;
	}

	/**
	 * @param Type: int(10)
	 */
	public function setCar2($Car2){
		$this->Car2 = $Car2;
	}

	/**
	 * @param Type: int(10)
	 */
	public function setSubDriver3($SubDriver3){
		$this->SubDriver3 = $SubDriver3;
	}

	/**
	 * @param Type: int(10)
	 */
	public function setCar3($Car3){
		$this->Car3 = $Car3;
	}

	/**
	 * @param Type: date
	 */
	public function setSubPickupDate($SubPickupDate){
		$this->SubPickupDate = $SubPickupDate;
	}

	/**
	 * @param Type: varchar(255)
	 */
	public function setSubPickupTime($SubPickupTime){
		$this->SubPickupTime = $SubPickupTime;
	}

	/**
	 * @param Type: varchar(255)
	 */
	public function setSubFlightNo($SubFlightNo){
		$this->SubFlightNo = $SubFlightNo;
	}

	/**
	 * @param Type: varchar(50)
	 */
	public function setSubFlightTime($SubFlightTime){
		$this->SubFlightTime = $SubFlightTime;
	}

	/**
	 * @param Type: varchar(5)
	 */
	public function setTransferDuration($TransferDuration){
		$this->TransferDuration = $TransferDuration;
	}

	/**
	 * @param Type: varchar(255)
	 */
	public function setPDFFile($PDFFile){
		$this->PDFFile = $PDFFile;
	}

	/**
	 * @param Type: text
	 */
	public function setExtras($Extras){
		$this->Extras = $Extras;
	}

	/**
	 * @param Type: text
	 */
	public function setSubDriverNote($SubDriverNote){
		$this->SubDriverNote = $SubDriverNote;
	}

	/**
	 * @param Type: text
	 */
	public function setStaffNote($StaffNote){
		$this->StaffNote = $StaffNote;
	}

	/**
	 * @param Type: varchar(255)
	 */
	public function setInvoiceNumber($InvoiceNumber){
		$this->InvoiceNumber = $InvoiceNumber;
	}

	/**
	 * @param Type: date
	 */
	public function setInvoiceDate($InvoiceDate){
		$this->InvoiceDate = $InvoiceDate;
	}

	/**
	 * @param Type: varchar(255)
	 */
	public function setDriverInvoiceNumber($DriverInvoiceNumber){
		$this->DriverInvoiceNumber = $DriverInvoiceNumber;
	}

	/**
	 * @param Type: date
	 */
	public function setDriverInvoiceDate($DriverInvoiceDate){
		$this->DriverInvoiceDate = $DriverInvoiceDate;
	}

	/**
	 * @param Type: decimal(10,2)
	 */
	public function setCashIn($CashIn){
		$this->CashIn = $CashIn;
	}

	/**
	 * @param Type: text
	 */
	public function setFinalNote($FinalNote){
		$this->FinalNote = $FinalNote;
	}

	/**
	 * @param Type: text
	 */
	public function setSubFinalNote($SubFinalNote){
		$this->SubFinalNote = $SubFinalNote;
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
			'DetailsID' => $this->getDetailsID(),
			'OrderID' => $this->getOrderID(),
			'TNo' => $this->getTNo(),
			'UserID' => $this->getUserID(),
			'UserLevelID' => $this->getUserLevelID(),
			'AgentID' => $this->getAgentID(),
			'CustomerID' => $this->getCustomerID(),
			'TransferStatus' => $this->getTransferStatus(),
			'OrderDate' => $this->getOrderDate(),
			'TaxidoComm' => $this->getTaxidoComm(),
			'ServiceID' => $this->getServiceID(),
			'RouteID' => $this->getRouteID(),
			'FlightNo' => $this->getFlightNo(),
			'FlightTime' => $this->getFlightTime(),
			'PaxName' => $this->getPaxName(),
			'PickupID' => $this->getPickupID(),
			'PickupName' => $this->getPickupName(),
			'PickupPlace' => $this->getPickupPlace(),
			'PickupAddress' => $this->getPickupAddress(),
			'PickupDate' => $this->getPickupDate(),
			'PickupTime' => $this->getPickupTime(),
			'PickupNotes' => $this->getPickupNotes(),
			'DropID' => $this->getDropID(),
			'DropName' => $this->getDropName(),
			'DropPlace' => $this->getDropPlace(),
			'DropAddress' => $this->getDropAddress(),
			'DropNotes' => $this->getDropNotes(),
			'PriceClassID' => $this->getPriceClassID(),
			'DetailPrice' => $this->getDetailPrice(),
			'DriversPrice' => $this->getDriversPrice(),
			'Discount' => $this->getDiscount(),
			'ExtraCharge' => $this->getExtraCharge(),
			'PaymentMethod' => $this->getPaymentMethod(),
			'PaymentStatus' => $this->getPaymentStatus(),
			'PayNow' => $this->getPayNow(),
			'PayLater' => $this->getPayLater(),
			'InvoiceAmount' => $this->getInvoiceAmount(),
			'ProvisionAmount' => $this->getProvisionAmount(),
			'PaxNo' => $this->getPaxNo(),
			'VehiclesNo' => $this->getVehiclesNo(),
			'VehicleType' => $this->getVehicleType(),
			'VehicleID' => $this->getVehicleID(),
			'DriverID' => $this->getDriverID(),
			'DriverName' => $this->getDriverName(),
			'DriverEmail' => $this->getDriverEmail(),
			'DriverTel' => $this->getDriverTel(),
			'DriverConfStatus' => $this->getDriverConfStatus(),
			'DriverConfDate' => $this->getDriverConfDate(),
			'DriverConfTime' => $this->getDriverConfTime(),
			'DriverNotes' => $this->getDriverNotes(),
			'DriverPayment' => $this->getDriverPayment(),
			'DriverPaymentAmt' => $this->getDriverPaymentAmt(),
			'Rated' => $this->getRated(),
			'DriverPickupDate' => $this->getDriverPickupDate(),
			'DriverPickupTime' => $this->getDriverPickupTime(),
			'SubDriver' => $this->getSubDriver(),
			'Car' => $this->getCar(),
			'SubDriver2' => $this->getSubDriver2(),
			'Car2' => $this->getCar2(),
			'SubDriver3' => $this->getSubDriver3(),
			'Car3' => $this->getCar3(),
			'SubPickupDate' => $this->getSubPickupDate(),
			'SubPickupTime' => $this->getSubPickupTime(),
			'SubFlightNo' => $this->getSubFlightNo(),
			'SubFlightTime' => $this->getSubFlightTime(),
			'TransferDuration' => $this->getTransferDuration(),
			'PDFFile' => $this->getPDFFile(),
			'Extras' => $this->getExtras(),
			'SubDriverNote' => $this->getSubDriverNote(),
			'StaffNote' => $this->getStaffNote(),
			'InvoiceNumber' => $this->getInvoiceNumber(),
			'InvoiceDate' => $this->getInvoiceDate(),
			'DriverInvoiceNumber' => $this->getDriverInvoiceNumber(),
			'DriverInvoiceDate' => $this->getDriverInvoiceDate(),
			'CashIn' => $this->getCashIn(),
			'FinalNote' => $this->getFinalNote(),
			'SubFinalNote' => $this->getSubFinalNote()		);
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
			'SiteID',			'DetailsID',			'OrderID',			'TNo',			'UserID',			'UserLevelID',			'AgentID',			'CustomerID',			'TransferStatus',			'OrderDate',			'TaxidoComm',			'ServiceID',			'RouteID',			'FlightNo',			'FlightTime',			'PaxName',			'PickupID',			'PickupName',			'PickupPlace',			'PickupAddress',			'PickupDate',			'PickupTime',			'PickupNotes',			'DropID',			'DropName',			'DropPlace',			'DropAddress',			'DropNotes',			'PriceClassID',			'DetailPrice',			'DriversPrice',			'Discount',			'ExtraCharge',			'PaymentMethod',			'PaymentStatus',			'PayNow',			'PayLater',			'InvoiceAmount',			'ProvisionAmount',			'PaxNo',			'VehiclesNo',			'VehicleType',			'VehicleID',			'DriverID',			'DriverName',			'DriverEmail',			'DriverTel',			'DriverConfStatus',			'DriverConfDate',			'DriverConfTime',			'DriverNotes',			'DriverPayment',			'DriverPaymentAmt',			'Rated',			'DriverPickupDate',			'DriverPickupTime',			'SubDriver',			'Car',			'SubDriver2',			'Car2',			'SubDriver3',			'Car3',			'SubPickupDate',			'SubPickupTime',			'SubFlightNo',			'SubFlightTime',			'TransferDuration',			'PDFFile',			'Extras',			'SubDriverNote',			'StaffNote',			'InvoiceNumber',			'InvoiceDate',			'DriverInvoiceNumber',			'DriverInvoiceDate',			'CashIn',			'FinalNote',			'SubFinalNote'		);
		return $fieldNames;
	}
    /**
     * Close mysql connection
     */
	public function endv4_OrderDetailsTemp(){
		$this->connection->CloseMysql();
	}

}