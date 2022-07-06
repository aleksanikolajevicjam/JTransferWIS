<?
session_start();

require_once $_SERVER['DOCUMENT_ROOT'] . '/db/db.class.php';
$db = new DataBaseMysql();

$sql = 'SELECT * FROM v4_ExchangeRate WHERE Name = "EUR"';
$rEur = $db->RunQuery($sql);
$Eur = $rEur->fetch_assoc();

$sql = 'SELECT * FROM v4_ExchangeRate ';
$sql .= 'WHERE Name = "HRK" OR Name = "USD" OR Name = "GBP" OR Name = "CHF"';
$r = $db->RunQuery($sql);
$r2 = $db->RunQuery($sql);
?>


<div class="container white">
    <h3>Calculator</h3>
    
    <div style="text-align:center;margin-top:36px;font-size:large">
        <input id="ExchangeValue" type="number" step="0.01" placeholder="0" onkeyup="updateER()" style="width:5em" >

        <select id="ExchangeCurrency" onchange="updateER()">
            <option value="1">HRK</option>
        <? while ($row = $r->fetch_assoc()) { ?>
            <option value="<?= $row['Buy'] ?>"><?= $row['Name'] ?></option>
        <? } ?>
        </select>
        = <span id="ExchangeResult" style="font-size:20px">0</span> EUR
        <div id="ExchangeRate" style="font-size:small;margin-top:24px"></div>
		
		
		<br>
		
		
        <input id="ExchangeValue2" type="number" step="0.01" placeholder="0" onkeyup="updateER2()" style="width:5em">		
		EUR
		= <span id="ExchangeResult2" style="font-size:20px">0</span> 
        <select id="ExchangeCurrency2" onchange="updateER2()">
            <option value="1">HRK</option>
        <? while ($row = $r2->fetch_assoc()) { ?>
            <option value="<?= $row['Buy'] ?>"><?= $row['Name'] ?></option>
        <? } ?>
        </select>
        <div id="ExchangeRate2" style="font-size:small;margin-top:24px"></div>

		
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
function updateER2 () {
    value = document.getElementById("ExchangeValue2").value;
    rate = document.getElementById("ExchangeCurrency2").value;
    result = value / rate;
    val = result * <?= $Eur['Average'] ?>;
    document.getElementById("ExchangeResult2").innerHTML = val.toFixed(2);
    document.getElementById("ExchangeRate2").innerHTML = "exchange rate = " + ((<?= $Eur['Average'] ?>)/rate).toFixed(4) ;
}
</script>
