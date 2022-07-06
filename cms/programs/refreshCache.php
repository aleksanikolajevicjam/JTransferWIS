<?
//writeProgress("Job Started: ".date("Y-m-d H:i:s")."\n");
$jobStarted = 'Job Started: '. date("Y-m-d H:i:s");

$cacheDir = ROOT.'/cache';
$cacheCount = 0;

echo '<div class="container">';
echo '<h1>Refresh Cache</h1><br>';
//echo '<p>Cache folder: <small>'.$cacheDir.'</small></p>';

echo '<p><small>';
foreach(glob($cacheDir.'/airports*.json') as $file) {
	//echo 'Deleting: '.$file.'<br>';
	unlink($file);
	$cacheCount++;
}
foreach(glob($cacheDir.'/countries*.json') as $file) {
	//echo 'Deleting: '.$file.'<br>';
	unlink($file);
	$cacheCount++;
}
echo '</small></p>';

echo $cacheCount.' cache files deleted. 
<br>IMPORTANT: Go to site and open Airports and Countries options in all languages.</p>';
/*
// refreshing some of the cache
$_SESSION['language'] = 'en';
require_once ROOT.'/m/getCountries.php';
require_once ROOT.'/m/getAirports.php';

$_SESSION['language'] = 'ru';
require_once ROOT.'/m/getCountries.php';
require_once ROOT.'/m/getAirports.php';

$_SESSION['language'] = $_SESSION['cmsLang'];

echo '<p>Refreshed countries and airports</p>';
*/
echo '</div>';

