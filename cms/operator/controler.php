<?
switch($activePage) {

	case 'printVoucherOperator':
		require_once $modulesPath .'/transfers/printVoucherOperator.php'; 
		break;

	case 'freeForm':
		require_once $modulesPath .'/bookingFreeForm.php'; 
		break;

	case 'booking': 
		require_once 't/bookingAdmin.php'; 
		break;			
		
	case 'invoice':
		require_once $modulesPath .'/invoiceTemplate.php'; 
		break;
	case 'invoiceSum':
		require_once $modulesPath .'/invoiceCumulative.php'; 
		break;

	case 'driversBalance':
		require_once $modulesPath .'/reports/admin/driversBalanceCSV.php'; 
		break;

	case 'driversWTransfers':
		require_once $modulesPath .'/reports/admin/driversWithTransfers.php'; 
		break;
		
	case 'profileEdit':
		require_once $modulesPath .'/users/userEditActive.'.$_SESSION['GroupProfile'].'.php'; 
		break;
		
	case 'dashboard': 
		require_once 'dashboard.php'; 
		break;
		
	case 'calendar': 
	    require_once $modulesPath . '/calendarPlugin.php';
		break;			
	
	case 'editActiveTransfer': 
		require_once $modulesPath . '/transfers/editActiveTransfer.'.$_SESSION['GroupProfile'].'.php'; 
		break;
	
	case 'transfersList': 
		require_once $modulesPath .'/transfers/transfersList.php'; 
		break;
		
	case 'booking': 
		require_once 't/bookingAdmin.php'; 
		break;	
		
	case 'final': 
		require_once 't/finalAdmin.php'; 
		break;

	case 'final2': 
		require_once 't/finalAdmin2.php'; 
		break;
		
	case 'users': 
		require_once $modulesPath . '/users/usersList.php'; 
		break;

	case 'newUser': 
		require_once $modulesPath . '/users/v4_AuthUsers.Edit.New.'.$_SESSION['GroupProfile'].'.php'; 
		break;
		
	case 'userEdit':
		require_once $modulesPath . '/users/usersEditForm.'.$_SESSION['GroupProfile'].'.php';
		break;

	case 'quickEmail':
		require_once $modulesPath . '/quickEmail.php';
		break;

	case 'countries':
		require_once $modulesPath . '/v4_Countries/v4_Countries.List.php';
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

	case 'new_v4_Routes':
		require_once $modulesPath . '/v4_Routes/v4_Routes.Edit.New.Admin.php';
		break;			
	case 'new_v4_Places':
		require_once $modulesPath . '/v4_Places/v4_Places.Edit.New.Admin.php';
		break;	
	case 'new_v4_PlaceTypes':
		require_once $modulesPath . '/v4_PlaceTypes/v4_PlaceTypes.Edit.New.Admin.php';
		break;	
		
	case 'newArticle':
		require_once $modulesPath . '/v4_Articles/v4_Articles.Edit.New.Admin.php';
		break;
		
	case 'headerImages':
		require_once $modulesPath . '/header/headerImages.php';
		break;
		
	case 'locations':
		require_once $modulesPath . '/v4_Places/v4_Places.List.php';
		break;

	case 'locationTypes':
		require_once $modulesPath . '/v4_PlaceTypes/v4_PlaceTypes.List.php';
		break;

	case 'routes':
		require_once $modulesPath . '/v4_Routes/v4_Routes.List.php';
		break;

	case 'extras':
		require_once $modulesPath . '/v4_Extras/v4_Extras.List.php';
		break;

	case 'new_v4_Extras':
		require_once $modulesPath . '/v4_Extras/v4_Extras.Edit.New.Admin.php';
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

	case 'drivers':
		require_once $modulesPath . '/v4_Drivers/v4_Drivers.List.php';
		break;	
		
	case 'driverRoutes':
		require_once $modulesPath . '/v4_DriverRoutes/v4_DriverRoutes.List.php';
		break;	

	case 'vehicles':
		require_once $modulesPath . '/v4_Vehicles/v4_Vehicles.List.php';
		break;	

	case 'daySettings':
		require_once $modulesPath . '/v4_DaySettings/v4_DaySettings.List.php';
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

	case 'emailsForm':
		require_once $modulesPath . '/reports/clientReport/emailsForm.php';
		break;

	case 'emails':
		require_once $modulesPath . '/reports/clientReport/emails.php';
		break;

	// MISC
	case 'fileman':
		require_once 'fileManager.php';
		break;	

	case 'prices':
		require_once $modulesPath .'/v4_Services/v4_Services.List.php';
		break;	

	case 'pricesExport':
		require_once $modulesPath .'/v4_Services/v4_Services.Export.php';
		break;
		
	case 'pricesImport':
		require_once $modulesPath .'/v4_Services/v4_Services.Import.php';
		break;			
	
	default: echo '<div class="alert alert-danger"><i class="fa fa-warning"></i>'.PAGE_NOT_FOUND.'</div>'; break;
}

