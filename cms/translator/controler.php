<?
switch($activePage) {

	case 'countries':
		require_once $modulesPath . '/v4_Countries/v4_Countries.List.php';
		break;

	case 'extraServices':
		require_once $modulesPath . '/v4_ExtrasMaster/v4_ExtrasMaster.List.php';
		break;

	case 'sitePages':
		require_once $modulesPath . '/v4_Pages/v4_Pages.List.php';
		break;
		
	case 'placeTypes':
		require_once $modulesPath . '/v4_PlaceTypes/v4_PlaceTypes.List.php';
		break;
		
	case 'places':
		require_once $modulesPath . '/v4_Places/v4_Places.List.php';
		break;
		
	case 'vehicleTypes':
		require_once $modulesPath . '/v4_VehicleTypes/v4_VehicleTypes.List.php';
		break;
		
	case 'articles':
		require_once $modulesPath . '/v4_Articles/v4_Articles.List.php';
		break;
		
	case 'newArticle':
		require_once $modulesPath . '/v4_Articles/v4_Articles.Edit.New.Translator.php';
		break;

	case 'policiesEN':
		require_once $modulesPath .'/v4_Policies/v4_Policies_EN.List.php';
		break;

	case 'policiesRU':
		require_once $modulesPath .'/v4_Policies/v4_Policies_RU.List.php';
		break;

	case 'policiesFR':
		require_once $modulesPath .'/v4_Policies/v4_Policies_FR.List.php';
		break;

	case 'policiesDE':
		require_once $modulesPath .'/v4_Policies/v4_Policies_DE.List.php';
		break;

	case 'policiesIT':
		require_once $modulesPath .'/v4_Policies/v4_Policies_IT.List.php';
		break;
		
	case 'profileEdit':
		require_once $modulesPath .'/users/userEditActive.'.$_SESSION['GroupProfile'].'.php'; 
		break;

	case 'labels':
		require_once $modulesPath . '/v4_Labels/v4_Labels.List.php';
		break;
		
	case 'new_v4_Labels':
		require_once $modulesPath . '/v4_Labels/v4_Labels.Edit.New.Translator.php';
		break;	
		

	// -- visak
	case 'dashboard': 
		require_once 'dashboard.php'; 
		break;
	
	default:
		echo '<div class="alert alert-danger">';
		echo '<i class="fa fa-warning"></i>'.PAGE_NOT_FOUND.'</div>';
		break;
}

