<?
$_SESSION['AuthUserID']=$_SESSION['PermAuthUserID'];
$_SESSION['OwnerID'] = $_SESSION['AuthUserID'];
$_SESSION['AuthLevelID'] = ADMIN_USER;


$driverspage=array(
	'extras',
	'driverRoutes',
	'vehicles',
	'special',
	'specialtimes',
	'dateSettings',
	'prices',
	'new_v4_Vehicles',
	'new_v4_Extras',
	'new_v4_OffDuty',
	'newSpecial',
	'newSpecialTimes',
	'terminals',
	'users'
); 
if (isset($_SESSION['UseDriverID']) && $_SESSION['UseDriverID']>0 && in_array($activePage,$driverspage)) {
	$_SESSION['OwnerID'] = $_SESSION['UseDriverID'];
	$_SESSION['AuthUserID'] = $_SESSION['UseDriverID'];
	$_SESSION['AuthLevelID'] = DRIVER_USER;
}	

ob_start();

switch($activePage) {

	case 'login':
		require_once 'login.php'; 
		break;	
		
	case 'logout':
		require_once 'logout.php'; 
		break;

	case 'exchangeRate':
		require_once ROOT . '/cms/admin/exchangeRate.php';
		break;	
		
	case 'vatRate':
		require_once ROOT . '/cms/admin/vatRate.php';
		break;
		
	case 'refreshCache':
		require_once ROOT . '/cms/programs/refreshCache.php';
		break;

	case 'fixPlaces':
		require_once $modulesPath .'/v4_Places/v4_PlacesDelete.Fix.php'; 
		break;

	case 'fixRouteNames':
		require_once $modulesPath .'/v4_Routes/v4_Routes.UpdateNames.php'; 
		break;
		
	case 'fakeDriver':
		require_once 'copyFakeDriverPrices.php'; 
		break;

	case 'bookingFreeForm':
		require_once $modulesPath .'/booking/bookingFreeForm.php'; 
		break;

	case 'freeFormUpload':
		require_once $modulesPath .'/bookingFreeFormUpload.php'; 
		break;
		
	case 'booking': 
		if ($pathVars->size()>2) {	
			switch($pathVars->fetchByIndex($indexStart + 2)) {
				case 'step1':				
					require_once $modulesPath .'/booking/bookingStep1.php'; 
					break;					
				case 'step2':				
					require_once $modulesPath .'/booking/bookingStep2.php'; 
					break;		
				case 'step3': 
					require_once $modulesPath .'/booking/bookingStep3.php'; 
					break;	
				default:
					require_once $modulesPath .'/booking/bookingStep1.php';	
			}
		}	
		else require_once $modulesPath .'/booking/bookingStep1.php'; 
		break;		

	case 'transcs':  
		require_once 'transcalc/transCS.php'; 
		break;	
		
	case 'preFreeForm':
		require_once $modulesPath .'/preFreeForm.php'; 
		break;

	case 'driverReOrder':
		require_once $modulesPath .'/transfers/DriverReOrder.php'; 
		break;
		
	case 'invoices':
		require_once $modulesPath . '/v4_Invoices/v4_Invoices.List.php';
		break;

	case 'invc':
		require_once $modulesPath . '/v4_Invoices/v4_Invoices.List-1.php';
		break;

	case 'new_v4_Invoices':
		require_once $modulesPath . '/v4_Invoices/v4_Invoices.Edit.New.'.$_SESSION['GroupProfile'].'.php';
		break;

	case 'new_v4_Invoices2':
		require_once $modulesPath . '/v4_Invoices/v4_Invoices2.Edit.New.'.$_SESSION['GroupProfile'].'.php';
		break;
		
	case 'invoiceSum':
		require_once $modulesPath .'/reports/admin/invoiceCumulative.php'; 
		break;

	case 'invoiceSumAgent':
		require_once $modulesPath .'/reports/admin/invoiceCumulativeAgent.php'; 
		break;
	
	case 'agentsBalance':
		require_once $modulesPath .'/reports/admin/agentsBalanceCSV.php'; 
		break;
		
	case 'agentsBalanceCash':
		require_once $modulesPath .'/reports/admin/agentsBalanceCSVCash.php'; 
		break;
		
	case 'agentsWTransfers':
		require_once $modulesPath .'/reports/admin/agentsWithTransfers.php'; 
		break;

	case 'agentsWTransfers2':
		require_once $modulesPath .'/reports/admin/agentsWithTransfers2.php'; 
		break;
		
	case 'agentsWTransfersCash':
		require_once $modulesPath .'/reports/admin/agentsWithTransfersCash.php'; 
		break;
		
	case 'driversBalance':
		require_once $modulesPath .'/reports/admin/driversBalanceCSV.php'; 
		break;

	case 'driversBalanceCash':
		require_once $modulesPath .'/reports/admin/driversBalanceCSVCash.php'; 
		break;

	case 'driversWTransfers':
		require_once $modulesPath .'/reports/admin/driversWithTransfers.php'; 
		break;

	case 'driversWTransfersCash':
		require_once $modulesPath .'/reports/admin/driversWithTransfersCash.php'; 
		break;
		
	case 'profileEdit':
		require_once $modulesPath .'/users/userEditActive.'.$_SESSION['GroupProfile'].'.php'; 
		break;
		
	case 'dashboard': 
		require_once 'dashboard.php'; 
		break;

	case 'calendar': 
	    require_once $modulesPath . '/calendar/calendarPlugin.php';
		break;

	case 'editActiveTransfer': 
		require_once $modulesPath . '/transfers/editActiveTransfer.'.$_SESSION['GroupProfile'].'.php'; 
		break;
	
	case 'transfersList': 
		require_once $modulesPath .'/transfers/transfersList.php'; 
		break;
	case 'transfersListN': 
		require_once $modulesPath .'/transfers/transfersListN.php'; 
		break;
		
	case 'getTransfer': 
		require_once $modulesPath .'/transfers/getOrder.php'; 
		break;		
		
	case 'transfersReview': 
		require_once $modulesPath .'/transfersReview.php';
		break;
				
	case 'updatedTransfersList': 
		require_once $modulesPath .'/v4_OrderLog/v4_OrderLog.List.php';
		break;
	
	case 'users': 
		require_once $modulesPath . '/users/usersList.php'; 
		break;

	case 'setDriver': 
		require_once $modulesPath . '/users/setDriver.php'; 
		break;
		
	case 'newUser': 
		require_once $modulesPath . '/users/v4_AuthUsers.Edit.New.'.$_SESSION['GroupProfile'].'.php'; 
		break;
		
	case 'userEdit':
		require_once $modulesPath . '/users/usersEditForm.Admin.php';
		break;

	case 'quickEmail':
		require_once $modulesPath . '/quickEmail.php';
		break;



	case 'siteArticles':
		require_once $modulesPath . '/v4_Articles/v4_Articles.List.php';
		break;

	case 'sitePages':
		require_once $modulesPath . '/v4_Pages/v4_Pages.List.php';
		break;

	case 'newPage':
		require_once $modulesPath . '/v4_Pages/v4_Pages.Edit.New.Admin.php';
		break;
	case 'newArticle':
		require_once $modulesPath . '/v4_Articles/v4_Articles.Edit.New.Admin.php';
		break;
		
	case 'headerImages':
		require_once $modulesPath . '/header/headerImages.php';
		break;

	case 'routeReviews':
		require_once $modulesPath . '/v4_Survey/v4_Survey.List.php';
		break;
	case 'new_v4_Survey':
		require_once $modulesPath . '/v4_Survey/v4_Survey.Edit.New.Admin.php';
		break;

	case 'extras':	
		require_once $modulesPath . '/v4_Extras/v4_Extras.List.php';
		break;

	case 'new_v4_Extras':
		require_once $modulesPath . '/v4_Extras/v4_Extras.Edit.New.Admin.php';
		break;	

	case 'extraServices':
		require_once $modulesPath . '/v4_ExtrasMaster/v4_ExtrasMaster.List.php';
		break;
		
	case 'actions':
		require_once $modulesPath . '/v4_Actions/v4_Actions.List.php';
		break;		

	case 'new_v4_ExtrasMaster':
		require_once $modulesPath . '/v4_ExtrasMaster/v4_ExtrasMaster.Edit.New.Admin.php';
		break;
		
	case 'new_v4_Actions':
		require_once $modulesPath . '/v4_Actions/v4_ActionsNew.php';
		break;		

	case 'coInfo':
		require_once $modulesPath . '/v4_CoInfo/v4_CoInfo.List.php';
		break;			

	case 'coTexts':
		require_once $modulesPath . '/v4_CoTexts/v4_CoTexts.List.php';
		break;	

	case 'comments':
		require_once $modulesPath . '/v4_Comments/v4_Comments.List.php';
		break;	

	case 'commission': 
		require_once $modulesPath . '/users/commission.php'; 
		break;
		
	case 'drivers':
		require_once $modulesPath . '/v4_Drivers/v4_Drivers.List.php';
		break;	
		
	case 'driverRoutes':
		require_once $modulesPath . '/v4_DriverRoutes/v4_DriverRoutes.List.php';
		break;

	case 'vehicles':	
		require_once $modulesPath . '/v4_Vehicles/v4_Vehicles.List.php';
		break;
		
	case 'terminals':	
		require_once $modulesPath . '/v4_Terminals/v4_Terminals.List.php';
		break;		

	case 'new_v4_Vehicles':
		require_once $modulesPath . '/v4_Vehicles/v4_Vehicles.Edit.New.Admin.php';
		break;
		
	case 'new_v4_Terminals':
		require_once $modulesPath . '/v4_Terminals/v4_Terminals.Edit.New.php';
		break;		

	case 'daySettings':
		require_once $modulesPath . '/v4_DaySettings/v4_DaySettings.List.php';
		break;	

	case 'special':		
		require_once $modulesPath . '/v4_SpecialDates/v4_SpecialDates.List.php';
		break;	 
		
	case 'specialtimes':		
		require_once $modulesPath . '/v4_SpecialTimes/v4_SpecialTimes.List.php';
		break;	 
		
	case 'newSpecial':
		require_once $modulesPath . '/v4_SpecialDates/v4_SpecialDates.Edit.New.Driver.php';
		break;	
		
	case 'newSpecialTimes':
		require_once $modulesPath . '/v4_SpecialTimes/v4_SpecialTimes.Edit.New.Driver.php';
		break;	
		
	case 'new_v4_OffDuty':
		require_once $modulesPath . '/v4_OffDuty/v4_OffDuty.Edit.New.Driver.php';
		break;
		
	case 'daySettingsNew':
		require_once $modulesPath . '/v4_DaySettings/v4_DaySettings.Edit.New.Admin.php';
		break;	

	case 'dateSettings':	
		require_once $modulesPath . '/v4_OffDuty/v4_OffDuty.List.php';
		break;	

	// REPORTS
	case 'driversChart':
		require_once $modulesPath . '/reports/admin/driversChart.php';
		break;

	case 'tranRatio':
		require_once $modulesPath . '/reports/admin/transfersRatio.php';
		break;

	case 'incomeByMonth':
		require_once $modulesPath . '/reports/driver/incomeByMonth.php';
		break;

	case 'turnover':
		require_once $modulesPath . '/reports/admin/turnover.php';
		break;

	case 'promet':
		require_once $modulesPath . '/reports/admin/v4_promet.php';
		break;
	case 'promet2':
		require_once $modulesPath . '/reports/admin/prometByBookingDate.php';
		break;
	case 'agentOrders':
		require_once $modulesPath . '/reports/admin/v4_agentOrders.php';
		break;

	case 'netIncome':
		require_once $modulesPath . '/reports/admin/netincome.php';
		break;

	case 'taxiSiteOrdersBookingDate':
		require_once $modulesPath . '/reports/admin/reportTaxiSiteOrders.php';
		break;

	case 'priceList':
		require_once $modulesPath . '/reports/admin/priceList.php';
		break;

	case 'emailsForm':
		require_once $modulesPath . '/reports/clientReport/emailsForm.php';
		break;

	case 'emails':
		require_once $modulesPath . '/reports/clientReport/emails.php';
		break;

	case 'driversEmails':
		require_once $modulesPath . '/reports/clientReport/driversEmails.php';
		break;

	case 'driversEmailsActive':
		require_once $modulesPath . '/reports/clientReport/driversEmailsActive.php';
		break;

	case 'exportAgentEmails':
		require_once $modulesPath . '/reports/admin/exportAgentEmails.php';
		break;		

	case 'surveyReportForm':
		require_once $modulesPath . '/reports/survey/surveyReportForm.php';
		break;

	case 'surveyReport':
		require_once $modulesPath . '/reports/survey/surveyReport.php';
		break;

	case 'subHist':
		require_once $modulesPath . '/reports/admin/subdriverHistory.php';
		break;

	case 'timelineReview':
		require_once $modulesPath . '/reports/admin/timelineReview.php';
		break;
		
	// MISC
	case 'fileman':
		require_once 'fileManager.php';
		break;	

	case 'prices':	
		require_once $modulesPath .'/v4_Services/v4_Services.List.php';
		break;
 
	case 'routeprices':
		require_once $modulesPath .'/RoutePrices.php';
		break;		

	case 'coupons':
		require_once $modulesPath .'/v4_Coupons/v4_Coupons.List.php';
		break;

	case 'new_v4_Coupons':
		require_once $modulesPath .'/v4_Coupons/v4_Coupons.Edit.New.Admin.php';
		break;

	case 'pricesExport':
		require_once $modulesPath .'/v4_Services/v4_Services.Export.php';
		break;
		
	case 'pricesImport':
		require_once $modulesPath .'/v4_Services/v4_Services.Import.php';
		break;			

	case 'allPricesExport':
		require_once $modulesPath .'/v4_Services/v4_Services.Export.Netto_Brutto.php';
		break;

	case 'allPricesExport2':
		require_once $modulesPath .'/v4_Services/v4_Services.Export.Netto_Brutto.byPlace.php';
		break;

	case 'procedures':
	case 'tutorials':
	case 'documents':
		require_once $modulesPath .'/innerArticles.php'; 
		break;
		
	case 'requestResponse': 
		require_once $modulesPath .'/requestResponse.php';
		break;		
		
	default: 
		require_once 'dashboard.php'; 
		break;

		//echo '<div class="alert alert-danger"><i class="fa fa-warning"></i>'.PAGE_NOT_FOUND.'</div>'; break;
}
$output = ob_get_contents();
ob_end_clean();
//htmldecode($output);
$smarty->assign("page_render",$output);
