<?
define('DB_NAME', 'jamtrans_touradria');
//define('DB_USER', 'jamtrans_cezar');
define('DB_USER', 'jamtrans_cms');

//define('DB_PASSWORD', '3WLRAFu;E_!F');
define('DB_PASSWORD', '~5%OuH{etSL)');


define('DB_HOST', 'localhost');
$con = mysqli_connect(DB_HOST,DB_USER,DB_PASSWORD,DB_NAME);


function convertTime($ts, $dformat = '%d.%m.%Y', $sformat = '%Y-%m-%d') {
	extract(strptime($ts,$sformat));
	return strftime($dformat,mktime(
		                          intval($tm_hour),
		                          intval($tm_min),
		                          intval($tm_sec),
		                          intval($tm_mon)+1,
		                          intval($tm_mday),
		                          intval($tm_year)+1900
		                        ));
}

