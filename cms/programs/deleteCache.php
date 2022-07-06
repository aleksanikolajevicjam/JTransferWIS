<?
// AJAX poziv iz cms.jquery.js za individualni country ili location

$type = $_REQUEST["type"];
$id = $_REQUEST["id"];
$cacheDir = ROOT.'/cache/';
$count = 0;

if ($type == 1) $places = "fromPlaces";		// iz countries
else if ($type == 2) $places = "toPlaces*";	// iz locations
else die ("Error with type");

foreach (glob ($cacheDir . $places . $id . '*.json') as $file) {
	unlink($file);
	$count++;
}

echo "FILES DELETED: ".$count;
return $count;

