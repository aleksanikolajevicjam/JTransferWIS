<?
session_start();

require_once '/home/jamtrans/public_html/db/db.class.php';
$db = new DataBaseMysql();

$sql = 'SELECT * FROM v4_ExchangeRate WHERE Name = "EUR"';
$rEur = $db->RunQuery($sql);
$Eur = $rEur->fetch_assoc();

$sql = 'SELECT * FROM v4_ExchangeRate ';
$sql .= 'WHERE Name = "HRK" OR Name = "USD" OR Name = "GBP" OR Name = "CHF"';

$r = $db->RunQuery($sql);
?>


<div class="container white">
    <h3>Calculator</h3>
    
    <div style="text-align:center;margin-top:36px;font-size:large">
        <input id="ExchangeValue" type="number" step="0.01" placeholder="0" onkeyup="updateER()" style="width:10em">

        <select id="ExchangeCurrency" onchange="updateER()">
            <option value="1">HRK</option>
        <? while ($row = $r->fetch_assoc()) { ?>
            <option value="<?= $row['Average'] ?>"><?= $row['Name'] ?></option>
        <? } ?>
        </select>
        = <span id="ExchangeResult" style="font-size:20px">0</span> EUR
        <div id="ExchangeRate" style="font-size:small;margin-top:24px"></div>
    </div>
</div>

<script>
function updateER () {
    value = document.getElementById("ExchangeValue").value;
    rate = document.getElementById("ExchangeCurrency").value;
    result = value * rate;
    eur = result / <?= $Eur['Average'] ?>;
    document.getElementById("ExchangeResult").innerHTML = eur.toFixed(2);
    document.getElementById("ExchangeRate").innerHTML = "exchange rate = " + (rate / <?= $Eur['Average'] ?>).toFixed(4);
}
</script>
