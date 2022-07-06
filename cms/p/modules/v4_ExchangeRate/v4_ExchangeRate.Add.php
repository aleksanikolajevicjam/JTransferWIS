<?
require_once '../../../../db/db.class.php';

$db = new DataBaseMysql();
$r = $db->RunQuery("INSERT INTO v4_ExchangeRate (EUR, Currency) VALUES (" . $_POST['EUR'] . ", '" . $_POST['Currency'] . "');");

header('Location: https://www.jamtransfer.com/cms/index.php?p=exchangeRate');
