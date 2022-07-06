<?
/*
 * CRON JOB za dnevno dobavljanje tecajne liste sa hrvatske narodne banke
 * parsira se i sprema se u tablicu v4_ExchangeRate
 */

require_once 'db.class.php';
$db = new DataBaseMysql();


$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, "https://www.hnb.hr/tecajn/htecajn.htm");
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
$output = curl_exec($ch);
curl_close($ch);

# ovo splita niz kad nadje blankove [\s]+ i to bilo koji broj blankova
$niz = preg_split("/[\s]+/", $output);

# prvi element nam ne treba
unset($niz[0]);

# kreiranje multi arraya, za svaku valutu po jedan
$i = 1;

foreach ($niz as $key => $val) {
    if ($i > 4) {
        $i = 1;
        $valute[$name] = $valuta;
        $valuta = array();
    }

    if ($i == 1) {
        $code = substr($val,0,3);
        $name = substr($val,3,3);
        $unit = substr($val,6,3);

        $valuta['name'] = $name;
        $valuta['code'] = $code;
        $valuta['for']  = (int)$unit;
    }
    elseif ($i == 2) {
        $valuta['buy']= str_replace(',','.',$val);
    }
    elseif ($i== 3) {
        $valuta['avg']= str_replace(',','.',$val);
    }
    elseif ($i== 4) {
        $valuta['sel']= str_replace(',','.',$val);
    }

    $i++;
}

// ocisti tablicu od starih vrijednosti
$sql = 'TRUNCATE TABLE v4_ExchangeRate';
$r = $db->RunQuery($sql);

// unos u tablicu
foreach ($valute as $valuta) {
    $sql = 'INSERT INTO v4_ExchangeRate (Name, Code, Quantity, Buy, Average, Sell) ';
    $sql .= 'VALUES ("'.$valuta['name'].'","'.$valuta['code'].'",'.$valuta['for'].','.$valuta['buy'].','.$valuta['avg'].','.$valuta['sel'].')';
    $r = $db->RunQuery($sql);
}

/*function cron_test() {	
	$crontext = "Cron Run at ".date("r")." by ".$_SERVER['USER']."\n" ;
	$folder = substr($_SERVER['SCRIPT_FILENAME'],0,strrpos($_SERVER['SCRIPT_FILENAME'],"/")+1);
	$filename = $folder."cron_test.txt" ;
	$fp = fopen($filename,"a") or die("Open error!");
	fwrite($fp, $crontext) or die("Write error!");
	fclose($fp);
	echo "Wrote to ".$filename."\n\n" ;	
}*/