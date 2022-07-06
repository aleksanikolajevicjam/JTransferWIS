<?
require_once '../../../../db/db.class.php';

$db = new DataBaseMysql();

$sql = "DELETE FROM v4_ExchangeRate WHERE ID = " . $_POST['ID'] . ";";
$r = $db->RunQuery($sql);

header('Location: https://www.jamtransfer.com/cms/index.php?p=exchangeRate');
