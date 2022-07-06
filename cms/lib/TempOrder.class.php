<?
/*
	$_SESSION koji dolazi u final.php
	=================================
	
	
Array
(
    [TEST] => 1
    [CMSLang] => en
    [AuthUserID] => 284
    [DriverID] => 284
    [InitialRequest] => /cms/index.php?p=final
    [timestamp] => 1445460684
    [UserName] => agentbogo
    [UserRealName] => bogo
    [UserCompany] => Samsung
    [OwnerID] => 69
    [AuthLevelID] => 2
    [MemberSince] => 2008-08-16
    [GroupProfile] => Agent
    [UserAuthorized] => 1
    [UserImage] => 
    [UserEmail] => bogo@jamtransfer.com
    [ID] => 1
    [co_name] => JamTransfer.com
    [co_address] => Call center Belgrade: +381 64 659 72 00 ( 09-20h CET ) 
    [co_tel] => +381 64 659 72 00 ( 09-20h CET )
    [co_fax] => 
    [co_city] => Split
    [co_country] => Croatia
    [co_zip] => 21000
    [co_email] => info@jamtransfer.com
    [co_facebook] => 
    [co_twitter] => 
    [co_linkedin] => 
    [co_youtube] => 
    [co_googleplus] => 
    [co_todo] => 
    [p] => final
    [PHPSESSID] => 42402ab958b8d1dad6c4162ceaf0540a
    [language] => en
    [Currency] => EUR
    [lastElement] => selectCar.php
    [fromParam] => 
    [toParam] => 
    [CountryID] => 55
    [FromID] => 200031
    [ToID] => 100009
    [transferDate] => 2015-10-27
    [transferTime] => 22:45
    [PaxNo] => 1
    [returnTransfer] => 0
    [returnDate] => 
    [returnTime] => 
    [DriverName] => 
    [VehicleID] => 13
    [VehicleName] => Max. 15 passengers
    [VehicleCapacity] => 15
    [ServiceID] => 1080
    [RouteID] => 41
    [Price] => 0
    [REFRESHED] => 
    [PickupAddress] => asdasd asd 
    [DropAddress] => asd asd asd 
    [PaxFirstName] => Bogasin
    [PaxLastName] => Soic-Mirilovic
    [PaxEmail] => bogo.split@gmail.com
    [PaxTel] => 123123123123123123
    [ExtraItems] => Array
        (
            [1] => 0
            [5] => 0
            [10] => 0
            [2] => 0
            [3] => 0
            [6] => 0
            [4] => 0
            [9] => 0
            [11] => 0
            [7] => 0
            [26] => 0
            [8] => 0
        )

    [ExtraSubtotals] => Array
        (
            [1] => 
            [5] => 
            [10] => 
            [2] => 
            [3] => 
            [6] => 
            [4] => 
            [9] => 
            [11] => 
            [7] => 
            [26] => 
            [8] => 
        )

    [ExtraServices] => Array
        (
            [1] => Baby stroller
            [5] => Bicycle
            [10] => Bouquet of red roses
            [2] => Child seat (0-1 yrs)
            [3] => Child seat (1-5 yrs)
            [6] => Extra lugagge
            [4] => Golf bag
            [9] => Musical instrument
            [11] => Natural water 0.5l
            [7] => Pet
            [26] => Sightseeing tour
            [8] => Wheelchair
        )

    [TotalPrice] => 0.00
    [OrderKey] => ITIMD-15735
    [countries] => Array
        (
            [2] => Albania
            [14] => Austria
            [55] => Croatia
            [58] => Czech Republic
            [67] => England
            [74] => Finland
            [75] => France
            [81] => Germany
            [96] => Hungary
            [104] => Italy
            [120] => Liechtenstein
            [124] => Macedonia
            [140] => Montenegro
            [179] => Scotland
            [181] => Serbia
            [186] => Slovakia
            [187] => Slovenia
            [205] => Switzerland
            [240] => Turkey
        )

)

*/
require_once ROOT . '/db/v4_OrdersMasterTemp.class.php';
require_once ROOT . '/db/v4_OrderDetailsTemp.class.php';

Class TempOrder {
	public $m;
	public $d;
	
	public function SaveDetailsTemp() {
		
		$m = new v4_OrdersMasterTemp();
		$d = new v4_OrderDetailsTemp();
		
		// za Master nemamo jos sve podatke, ali spremamo ono sto ima
		$m->setMOrderKey( $_SESSION['OrderKey'] );
		$m->setSiteID('2');
		$m->setMOrderStatus('1');
		$m->setMOrderDate(date("Y-m-d"));
		$m->setMOrderTime(date("H:i:s"));
		$m->setMUserID($_SESSION['AuthUserID']);
		$m->setMUserLevelID($_SESSION['AuthLevelID']);
		$m->setMOrderLang($_SESSION['CMSLang']);
		$MOrderID = $m->saveAsNew();
		echo $MOrderID;

		// za Details ima podataka
		$d->setSiteID('2');
		$d->setOrderID($MOrderID);
		$d->setUserID($_SESSION['AuthUserID']);
		$d->setUserLevelID($_SESSION['AuthLevelID']);
		if($_SESSION['GroupProfile'] == 'Agent') $d->setAgentID($_SESSION['AuthUserID']);
		$d->setTransferStatus('1');
		$d->setOrderDate(date("Y-m-d"));
		$d->setPickupID($_SESSION['FromID']);
		$d->setPickupDate($_SESSION['transferDate']);
		$d->setPickupTime($_SESSION['transferTime']);
		$d->setDropID($_SESSION['ToID']);
		$d->setPaxNo($_SESSION['PaxNo']);
		
		$d->saveAsNew();
		
	}
	
	
	
	# kreira random broj narudzbe
	public function create_order_key()
	{
		srand(time());
		$whichone1 = (rand()%10);
		$whichone2 = (rand()%10);
		$whichone3 = (rand()%10);
		$whichone4 = (rand()%10);
		$whichone5 = (rand()%10);
		$str = "";
		$str2 = "ABCDEFGHIJKLMNPQRSTUVWXYZ";
		for($i=0;$i<5;$i++)
		{
			$random = (rand()%10);
			$random2 = (rand()%11);
			$random3 = (rand()%25);
			if($i == $whichone1 || $i == $whichone2 || $i == $whichone3 || $i == $whichone4 || $i == $whichone5) 
				$str .= $str2[$random3];
			else {
				if ($random == 0) $random = 1;
				$str .= $str2[$random];
			}
		}
		return $str.$whichone1.$whichone2.$whichone3.$whichone4.$whichone5;
	}
}

