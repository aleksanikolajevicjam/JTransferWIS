<?
switch($activePage) {

	case 'dashboard':
		require_once 'dashboard.php';
		break;
	
	case 'profileEdit':
		require_once $modulesPath .'/users/userEditActive.'.$_SESSION['GroupProfile'].'.php'; 
		break;

	case 'countries':
		require_once $modulesPath . '/v4_Countries/v4_Countries.List.php';
		break;

	case 'new_v4_Countries':
		require_once $modulesPath . '/v4_Countries/v4_Countries.Edit.New.Admin.php';
		break;
	
	case 'locations':
		require_once $modulesPath . '/v4_Places/v4_Places.List.php';
		break;
	
	case 'new_v4_Places':
		require_once $modulesPath . '/v4_Places/v4_Places.Edit.New.Admin.php';
		break;

	case 'routes':
		require_once $modulesPath . '/v4_Routes/v4_Routes.List.php';
		break;

	case 'new_v4_Routes':
		require_once $modulesPath . '/v4_Routes/v4_Routes.Edit.New.Admin.php';
		break;

	case 'locationTypes':
		require_once $modulesPath . '/v4_PlaceTypes/v4_PlaceTypes.List.php';
		break;

	case 'new_v4_PlaceTypes':
		require_once $modulesPath . '/v4_PlaceTypes/v4_PlaceTypes.Edit.New.Admin.php';
		break;

	default: echo '<div class="alert alert-danger"><i class="fa fa-warning"></i>'.PAGE_NOT_FOUND.'</div>'; break;
}

