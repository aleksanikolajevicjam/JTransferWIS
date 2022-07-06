<?

$root='/home/jamtrans/laravel/public/cms.jamtransfer.com';

require_once $root . '/db/db.class.php';
require_once $root . '/db/v4_OrdersMaster.class.php';
require_once $root . '/db/v4_OrderDetails.class.php';

$db = new DataBaseMysql();
$om = new v4_OrdersMaster();
$od = new v4_OrderDetails();

# echo 'START sending survey';

