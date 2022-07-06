<?
switch ($activePage) {

	case 'dashboard': 
		require_once 'dashboard.php'; 
		break;

	case 'details':
		require_once 'details.php';
		break;

	case 'sign':
		require_once 'sign.php';
		break;

	case 'finished':
		require_once 'finished.php';
		break;

	case 'nalog':
		require_once 'nalog.php';
		break;

	case 'racun':
		require_once 'racun.php';
		break;

	case 'expenses':
		//if ($_SESSION['AuthUserID']==948) require_once 'expensesT.php';
		//else 
			require_once 'expenses.php';
		break;
		
	case 'expensesT':
		require_once 'expensesT.php';
		break;
	
	case 'activity':
		require_once 'activity.php';
		break;
		
	case 'check':
		require_once 'check.php';
		break;
		
	case 'calculator':
		require_once 'calculator.php';
		break;

	case 'calculatorT':
		require_once 'calculatorT.php';
		break;
		
	case 'summary':
		require_once 'saldo.php';
		break;
			
	case 'userReviews':
		require_once $modulesPath . '/v4_Survey/userReviews.Driver.php';
		break;

	case 'profileEdit':
		//require_once $modulesPath .'/users/userEditActive.'.$_SESSION['GroupProfile'].'.php'; 
		break;
	
	default:
		echo '<div class="alert alert-danger">';
		echo '<i class="fa fa-warning"></i>';
		echo PAGE_NOT_FOUND . '</div>';
		break;
}

