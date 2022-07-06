<?
/*
 * CRON JOB za periodicno praznjenje OrderDetailsTemp i OrderMasterTemp
 */
$root='/home/jamtrans/laravel/public/cms.jamtransfer.com';
require_once $root . '/db/db.class.php';

// nalazenje max id-ja
$db = new DataBaseMysql();
$sql  = "SELECT max(`DetailsID`) as max FROM `v4_OrderDetailsTempT` ";
$r = $db->RunQuery($sql);
$d = $r->fetch_object();
$max=$d->max;
// skup podataka iz v4_OrderDetailsTemp za insertovanje u v4_OrderDetailsTempT
$sql2 = "SELECT * FROM `v4_OrderDetailsTemp` WHERE `DetailsID`>".$max."";
//Insertovanje 
$sql3 = "INSERT INTO `v4_OrderDetailsTempT`(`SiteID`, `DetailsID`, `OrderID`, `TNo`, `UserID`, `UserLevelID`, `AgentID`, `CustomerID`, `TransferStatus`, `OrderDate`, `TaxidoComm`, `ServiceID`, `RouteID`, `FlightNo`, `FlightTime`, `PaxName`, `PickupID`, `PickupName`, `PickupPlace`, `PickupAddress`, `PickupDate`, `PickupTime`, `PickupNotes`, `DropID`, `DropName`, `DropPlace`, `DropAddress`, `DropNotes`, `PriceClassID`, `DetailPrice`, `DriversPrice`, `Discount`, `ExtraCharge`, `PaymentMethod`, `PaymentStatus`, `PayNow`, `PayLater`, `InvoiceAmount`, `ProvisionAmount`, `PaxNo`, `VehiclesNo`, `VehicleType`, `VehicleID`, `DriverID`, `DriverName`, `DriverEmail`, `DriverTel`, `DriverConfStatus`, `DriverConfDate`, `DriverConfTime`, `DriverNotes`, `DriverPayment`, `DriverPaymentAmt`, `Rated`, `DriverPickupDate`, `DriverPickupTime`, `SubDriver`, `Car`, `SubDriver2`, `Car2`, `SubDriver3`, `Car3`, `SubPickupDate`, `SubPickupTime`, `SubFlightNo`, `SubFlightTime`, `TransferDuration`, `PDFFile`, `Extras`, `SubDriverNote`, `StaffNote`, `InvoiceNumber`, `InvoiceDate`, `DriverInvoiceNumber`, `DriverInvoiceDate`, `CashIn`, `FinalNote`, `SubFinalNote`) ".$sql2;

$r3 = $db->RunQuery($sql3);
// nalazenje max id-ja
$sql4 = "SELECT max(`MOrderID`) as max2 FROM `v4_OrdersMasterTempT` ";

$r4 = $db->RunQuery($sql4);
$d4 = $r4->fetch_object();
$max2=$d4->max2;
// skup podataka iz v4_OrderMasterTemp za insertovanje u v4_OrderMasterTempT
$sql5 = "SELECT * FROM `v4_OrdersMasterTemp` WHERE `MOrderID`>".$max2.""; 
//Insertovanje 
$sql6 = "INSERT INTO `v4_OrdersMasterTempT`(`SiteID`, `MOrderKey`, `MOrderID`, `MOrderStatus`, `MOrderType`, `MOrderDate`, `MOrderTime`, `MUserID`, `MUserLevelID`, `MTransferPrice`, `MDriverExtrasPrice`, `MProvision`, `MExtrasPrice`, `MOrderPriceEUR`, `MEurToCurrencyRate`, `MOrderCurrencyPrice`, `MOrderCurrency`, `MPaymentMethod`, `MPaymentStatus`, `MPayNow`, `MPayLater`, `MInvoiceAmount`, `MAgentCommision`, `MCustomerID`, `MPaxFirstName`, `MPaxLastName`, `MPaxTel`, `MPaxEmail`, `MCardType`, `MCardFirstName`, `MCardLastName`, `MCardEmail`, `MCardTel`, `MCardAddress`, `MCardCity`, `MCardZip`, `MCardCountry`, `MCardNumber`, `MCardCVD`, `MCardExpDate`, `MConfirmFile`, `MCancelFile`, `MChangeFile`, `MSubscribe`, `MAcceptTerms`, `MSendEmail`, `MEmailSentDate`, `MCustomerIP`, `MOrderLang`, `ConfirmationSent`) " . $sql5;

$r6 = $db->RunQuery($sql6);
// minimalnog id-ja u poslednjih mesec dana u v4_OrdersMasterTemp 
$sql7 = "SELECT min(`MOrderID`) as min FROM `v4_OrdersMasterTemp` WHERE `MOrderDate`=CURDATE()-INTERVAL 1 MONTH order by `MOrderTime`";

$r7 = $db->RunQuery($sql7);
$d7 = $r7->fetch_object();
$min=$d7->min;
// brisanje starijeg od mesec dana
$sql8 = "DELETE FROM `v4_OrdersMasterTemp` WHERE `MOrderID`<".$min."";

$r8 = $db->RunQuery($sql8);
// minimalnog id-ja u poslednjih mesec dana u v4_OrdersDetailsTemp 
$sql9 = "SELECT min(`DetailsID`) as min2 FROM `v4_OrderDetailsTemp` WHERE `OrderDate`=CURDATE()-INTERVAL 1 MONTH";

$r9 = $db->RunQuery($sql9);
$d9 = $r9->fetch_object();
$min2=$d9->min2;
// brisanje starijeg od mesec dana
$sql10 = "DELETE FROM `v4_OrderDetailsTemp` WHERE `DetailsID`<".$min2."";

$r10 = $db->RunQuery($sql10);
 