<?    
$url='https://geocode.xyz/'.$_REQUEST['place'].'?json=1';
$json = file_get_contents($url);   
$obj = json_decode($json,true);

$longt=$obj['longt'];
$latt=$obj['latt'];

echo "LONGITUDE:".$longt;
echo "<br>";
echo "LATITUDE:".$latt;

