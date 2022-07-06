<?
	
	
	switch($activePage) {
		case 'printAgentVoucher':
			require_once $modulesPath .'/transfers/printAgentVoucher.php'; 
			break;
					
		case 'profileEdit':
			require_once $modulesPath .'/users/userEditActive.'.$_SESSION['GroupProfile'].'.php'; 
			break;
			
		case 'dashboard': 
			require_once 'dashboard.php'; 
			break;
			
		case 'booking': 
			require_once 't/booking2.php'; 
			break;
			
		case 'bookingOld': 
			require_once 't/booking2Old.php'; 
			break;
			
		case 'final': 
			require_once 't/final.php'; 
			break;

		case 'freeForm':
			require_once $modulesPath .'/bookingFreeForm.php'; 
			break;
		
		case 'agentPayment': 
			require_once 't/payment.php'; 
			break;
			
		case 'agentThankyou': 
			require_once 't/thankyou.php'; 
			break;

		case 'booking2': 
			require_once 't/booking2.php'; 
			break;
			
		case 'final2': 
			require_once 't/final2.tpl'; 
			break;

		case 'agentPayment2': 
			require_once 't/payment2.php'; 
			break;
			
		case 'agentThankyou2': 
			require_once 't/thankyou2.php'; 
			break;
			
		case 'editActiveTransfer': 
			require_once $modulesPath . '/transfers/editActiveTransfer.'.$_SESSION['GroupProfile'].'.php'; 
			break;
		
		case 'transfersList': 
			require_once $modulesPath .'/transfers/transfersList.php'; 
			break;
		
		case 'usersList': 
			require_once $modulesPath . '/users/usersList.php'; 
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

		case 'countries':
			require_once $modulesPath . '/v4_Countries/v4_Countries.List.php';
			break;

		case 'siteArticles':
			require_once $modulesPath . '/v4_Articles/v4_Articles.List.php';
			break;

		case 'sitePages':
			require_once $modulesPath . '/v4_Pages/v4_Pages.List.php';
			break;

		case 'newArticle':
			require_once $modulesPath . '/v4_Articles/v4_Articles.Edit.New.Admin.php';
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

		case 'fileman':
			require_once 'fileManager.php';
			break;	

		case 'prices':
			require_once $modulesPath .'/v4_Services/v4_Services.List.php';
			break;	

		default: echo '<div class="alert alert-danger"><i class="fa fa-warning"></i>'.PAGE_NOT_FOUND.'</div>'; break;
	}
