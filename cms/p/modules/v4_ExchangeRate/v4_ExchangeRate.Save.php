<?
require_once '../../../../db/db.class.php';

$db = new DataBaseMysql();

for ($i = 0; $i < count($_POST['ID']); $i++) {
        $sql = "UPDATE v4_ExchangeRate SET Average = " . $_POST['EUR'][$i] . " WHERE ID = " . $_POST['ID'][$i] . ";";
        //echo '<br>'.$sql;
        $r = $db->RunQuery($sql);
    }

header('Location: https://www.jamtransfer.com/cms/index.php?p=exchangeRate');
