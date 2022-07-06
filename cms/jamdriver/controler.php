<?
switch($activePage) {
	
	case 'profileEdit':
		require_once $modulesPath .'/users/userEditActive.'.$_SESSION['GroupProfile'].'.php'; 
		break;
		
	case 'dashboard': 
		require_once 'dashboard.php'; 
		break;
	
	case 'editActiveTransfer': 
		require_once $modulesPath . '/transfers/editActiveTransfer.'.$_SESSION['GroupProfile'].'.php'; 
		break;
	
	case 'transfersList': 
		require_once $modulesPath .'/transfers/transfersList.php'; 
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


	case 'extras':
		require_once $modulesPath . '/v4_Extras/v4_Extras.List.php';
		break;

	case 'new_v4_Extras':
		require_once $modulesPath . '/v4_Extras/v4_Extras.Edit.New.Driver.php';
		break;

		
	case 'driverRoutes':
		require_once $modulesPath . '/v4_DriverRoutes/v4_DriverRoutes.List.php';
		break;	

	case 'new_v4_DriverRoutes':
		require_once $modulesPath . '/v4_DriverRoutes/v4_DriverRoutes.Edit.New.Driver.php';
		break;	

	case 'new_v4_Vehicles':
		require_once $modulesPath . '/v4_Vehicles/v4_Vehicles.Edit.New.Driver.php';
		break;	

	case 'vehicles':
		require_once $modulesPath . '/v4_Vehicles/v4_Vehicles.List.php';
		break;	


	case 'myVehicles':
		require_once $modulesPath . '/v4_MyVehicles/v4_MyVehicles.List.php';
		break;	
	case 'new_v4_MyVehicles':
		require_once $modulesPath . '/v4_MyVehicles/v4_MyVehicles.Edit.New.Driver.php';
		break;	

	case 'myDrivers':
		require_once $modulesPath . '/v4_MyDrivers/v4_MyDrivers.List.php';
		break;	
	case 'new_v4_MyDrivers':
		require_once $modulesPath . '/v4_MyDrivers/v4_MyDrivers.Edit.New.Driver.php';
		break;

	case 'newUser':
		require_once $modulesPath . '/users/v4_AuthUsers.Edit.New.Driver.php';
		break;


	case 'daySettings':
		require_once $modulesPath . '/v4_DaySettings/v4_DaySettings.List.php';
		break;	

	case 'daySettingsNew':
		require_once $modulesPath . '/v4_DaySettings/v4_DaySettings.Edit.New.Driver.php';
		break;	

	case 'dateSettings':
		require_once $modulesPath . '/v4_OffDuty/v4_OffDuty.List.php';
		break;	

	case 'special':
		require_once $modulesPath . '/v4_SpecialDates/v4_SpecialDates.List.php';
		break;			

	case 'newSpecial':
		require_once $modulesPath . '/v4_SpecialDates/v4_SpecialDates.Edit.New.Driver.php';
		break;			
		
	case 'new_v4_OffDuty':
		require_once $modulesPath . '/v4_OffDuty/v4_OffDuty.Edit.New.Driver.php';
		break;

	// TIMETABLE
	case 'timetableForm':
		require_once $modulesPath . '/timetable/timetableForm.php';
		break;

	case 'timetable':
		require_once $modulesPath . '/timetable/timetable.php';
		break;

	case 'v4_OrderDetails.List.php':
		require_once $modulesPath . '/timetable/v4_OrderDetails.List.php';
		break;

	case 'subdrivers':
		require_once $modulesPath . '/users/usersList.Driver.php';
		break;

	case 'timetableColumnView':
		require_once $modulesPath . '/timetable/timetableColumnView.php';
		break;

	case 'new_v4_SubDrivers':
		require_once $modulesPath . '/v4_SubDrivers/v4_SubDrivers.Edit.New.Driver.php';
		break;

	case 'subvehicles':
		require_once $modulesPath . '/v4_SubVehicles/v4_SubVehicles.List.php';
		break;

	case 'new_v4_SubVehicles':
		require_once $modulesPath . '/v4_SubVehicles/v4_SubVehicles.Edit.New.Driver.php';
		break;

	case 'subexpenses':
		require_once $modulesPath . '/v4_SubExpenses/v4_SubExpenses.List.php';
		break;

	case 'new_v4_SubExpenses':
		require_once $modulesPath . '/v4_SubExpenses/v4_SubExpenses.Edit.New.Driver.php';
		break;

	case 'expenses':
		require_once $modulesPath . '/v4_SubExpenses/expensesReportForm.php';
		break;

	case 'expensesReport':
		require_once $modulesPath . '/v4_SubExpenses/expensesReport.php';
		break;

	case 'expensesReportPrint':
		require_once $modulesPath . '/v4_SubExpenses/expensesReportPrint.php';
		break;

	case 'exchangeRate':
		require_once $modulesPath . '/v4_ExchangeRate/v4_ExchangeRate.List.php';
		break;

	// REPORTS
	case 'driversChart':
		require_once $modulesPath . '/reports/admin/driversChart.php';
		break;

	case 'incomeMonth':
		require_once $modulesPath . '/reports/driver/incomeByMonth.php';
		break;

	case 'userReviews':
		require_once $modulesPath . '/v4_Survey/userReviews.Driver.php';
		break;


	// MISC
	case 'fileman':
		require_once 'fileManager.php';
		break;	

	case 'prices':
		require_once $modulesPath .'/v4_Services/v4_Services.List.php';
		break;	

	case 'confirmation':
		require_once 'DriverConfirmation.php';
		break;	


	default: echo '<div class="alert alert-danger"><i class="fa fa-warning"></i>'.PAGE_NOT_FOUND.'</div>';
	break;
}

