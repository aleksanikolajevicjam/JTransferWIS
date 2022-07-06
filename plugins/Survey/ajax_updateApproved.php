<?
require_once 'Initial.php';

$ID = $_REQUEST["ID"];
$value = $_REQUEST["value"];

$su = new v4_Survey;

$su->getRow($ID);
$su->setApproved($value);
$result = $su->saveRow();


if ($result) echo $value;
else echo 'Error';

