<?
//error_reporting(E_PARSE);
require_once ROOT.'/f/f.php';
require_once ROOT.'/db/db.class.php';

$db = new DataBaseMysql();
$r = $db->RunQuery("SELECT * FROM v4_ExchangeRate ORDER BY ID ASC");


?>
<div class="container">
	<h1><?= EXCHANGE_RATE ?></h1>
	
    <br>All rates in EUR
    <div style="text-align:center;margin-top:12px">
        <?
            echo '<form method="post" action="/cms/p/modules/v4_ExchangeRate/v4_ExchangeRate.Save.php" id="SaveCurrency">';
            foreach ($r as $row) {

                echo '<br>';
                echo $row['Name'];
				echo ' <input type="hidden" name="ID[]" value="' . $row['ID'] . '">';
				echo ' <input type="number" step="0.001" name="EUR[]" value="' . $row['Average'] . '">';
				echo ' <input type="button" class="btn btn-danger" onclick="submitDelete(' . $row['ID'] . ')" value="' . DELETE . '">';
            }
            
            echo '</form>';
        ?>
        <br>
        <input class="btn btn-primary" type="submit" form="SaveCurrency" value="<?= SAVE ?>">
    </div>
    
    <form action="/cms/p/modules/v4_ExchangeRate/v4_ExchangeRate.Delete.php" method="POST" id="DeleteCurrency">
        <input type="hidden" name="ID" id="deleteID" value="">
    </form>
    
    <form action="/cms/p/modules/v4_ExchangeRate/v4_ExchangeRate.Add.php" method="POST" style="text-align:center;margin-top:36px;">
        <?= NNEW ?>:
        <input type="text" name="Currency" placeholder="Currency">
        <input type="number" name="EUR" step="0.001" placeholder="Value">
        <input class="btn btn-info" type="submit" value="<?=ADD?>">
    </form>
</div>

<script>
function submitDelete (id) {
        document.getElementById("deleteID").value = id;
        document.getElementById("DeleteCurrency").submit();
    }
</script>
