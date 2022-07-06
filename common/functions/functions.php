<?
#
# Popis funkcija u ovom file-u
#
# Zeljko Agic
#function start_tag($parser, $name, $attribs)
#function end_tag($parser, $name)
#function tag_contents($parser, $data)
#function create_order_key()
#function vsort($array, $id="id", $sort_ascending=true, $is_object_array = false)
#function checkCreditCardType($number)
#function validateCreditCardNumber($number)
#function selectMultiRows($query)
#function redirect($location)
#function delete_picture($filename)
#function mail_attachment($filename, $path, $mailto, $from_mail, $from_name, $replyto, $subject, $message)

# Bogasin Soic-Mirilovic
#function mail_attachmentx($filename, $path, $mailto, $from_mail, $from_name, $replyto, $subject, $message)
#function mail_html($mailto, $from_mail, $from_name, $replyto, $subject, $message)
#function alert_jam_operator($pg_response_code,$from_where)
#function ShowAll()
#function LookupCountry($id)
#function bogo_write_log($log_file, $what_to_write)
#function GetTerminalName($term_id)
#function GetDestName($dest_id)
#function GetCountryName($country_id)
#function GetCountryNameRU($country_id)
#function GetTermFromRID($route_id)
#function GetDestFromRID($route_id)
#function GetTerminalCountry($term_id)
#function GetDestCountry($term_id)
#function Show_Frontpage_Articles($lang)
#function Show_Newsflash($lang)
#function Show_OtherPages($lang, $stranica)
#function GetRIDFromServiceID($service_id)
#function GetVehicleIDFromServiceID($service_id)
#function GetVehicleName($vehicle_id)
#function AlignNumber($var, $len)
#function GetCountryDesc($country_id)
#function translateTexts($src_texts = array(), $src_lang, $dest_lang)
#function SloziPrijevod ($cijeli_tekst)
#function curPageURL()
#function Show_ThePage($lang,$menu_opt)
#function Check_Coupon($coupon)
#function LogUserStats($userid)
#function Show_Stats($userid)
#function Has_Routes ($id, $td)
#function YMD_to_DMY($date)
#function DMY_to_YMD($date)



#xml parser
function start_tag($parser, $name, $attribs)
{
	global $current_tag;
	$current_tag = $name;
}

#xml parser
function end_tag($parser, $name)
{
	global $current_tag;
	$current_tag = "";
}

# parser za sadrzaj - webteh povratak
function tag_contents($parser, $data)
{
	global $current_tag, $pg_response_code, $pg_errors, $pg_3dsecure_pareq, $pg_3dsecure_acs_url, $pg_3dsecure_order_id, $pg_response_message;

	if ( $current_tag == "RESPONSE-CODE" ) $pg_response_code = $data;
	else if ( $current_tag == "ERRORS" ) $pg_errors = true;
	else if ( $current_tag == "ACS-URL" ) $pg_3dsecure_acs_url = $data;
	else if ( $current_tag == "PAREQ" ) $pg_3dsecure_pareq = $data;
	else if ( $current_tag == "ORDER-ID" ) $pg_3dsecure_order_id = $data;
	else if ( $current_tag == "RESPONSE-MESSAGE" ) $pg_response_message = $data;

}

# kreira random broj narudzbe
function create_order_key()
{
	srand(time());
	$whichone1 = (rand()%10);
	$whichone2 = (rand()%10);
	$whichone3 = (rand()%10);
	$whichone4 = (rand()%10);
	$whichone5 = (rand()%10);
	$str = "";
	$str2 = "ABCDEFGHIJKLMNPQRSTUVWXYZ";
	for($i=0;$i<10;$i++)
	{
		$random = (rand()%10);
		$random2 = (rand()%11);
		$random3 = (rand()%27);
		if($i == $whichone1 || $i == $whichone2 || $i == $whichone3 || $i == $whichone4 || $i == $whichone5) $str .= $str2[$random3];
		else $str .= $random;
	}
	return $str;
}

 function vsort($array, $id="id", $sort_ascending=true, $is_object_array = false) {
        $temp_array = array();
        while(count($array)>0) {
            $lowest_id = 0;
            $index=0;
            if($is_object_array){
                foreach ($array as $item) {
                    if (isset($item->$id)) {
                                        if ($array[$lowest_id]->$id) {
                        if ($item->$id<$array[$lowest_id]->$id) {
                            $lowest_id = $index;
                        }
                        }
                                    }
                    $index++;
                }
            }else{
                foreach ($array as $item) {
                    if (isset($item[$id])) {
                        if ($array[$lowest_id][$id]) {
                        if ($item[$id]<$array[$lowest_id][$id]) {
                            $lowest_id = $index;
                        }
                        }
                                    }
                    $index++;
                }
            }
            $temp_array[] = $array[$lowest_id];
            $array = array_merge(array_slice($array, 0,$lowest_id), array_slice($array, $lowest_id+1));
        }
                if ($sort_ascending) {
            return $temp_array;
                } else {
                    return array_reverse($temp_array);
                }
    }

function checkCreditCardType($number)
{
	if(@ereg("^(5[1-5][0-9]{14})|(534000000[0-9]{9})", $number))
		return "MASTERCARD";
	//elseif(@ereg("^6011[0-9]{12}", $number))
		//return "Discover";
	elseif(@ereg("^(4[0-9]{12}([0-9]{3})?)|(435000000[0-9]{9})", $number))
		return "VISA";
	//elseif(@ereg("^3[0-9]{15}|(2131|1800)[0-9]{11}", $number))
		//return "Japan Credit Bureau (JCB)";
	elseif(@ereg("^(3[47][0-9]{13})|(341000000[0-9]{9})", $number))
		return "AMEX";
	//elseif(@ereg("^(2014|2149)[0-9]{11}", $number))
		//return "enRoute";
	//elseif(@ereg("^8699[0-9]{11}", $number))
		//return "Voyager";
	elseif(@ereg("^(3(0[0-5]|[68][0-9])[0-9]{11})|(360000000[0-9]{9})", $number))
		return "DINERS";
	else return FALSE;
}


function validateCreditCardNumber($number)
{
# Double every second digit started at the right
$doubledNumber  = "";
$odd            = false;
for($i = strlen($number)-1; $i >=0; $i--)
{
    $doubledNumber .= ($odd) ? $number[$i]*2 : $number[$i];
    $odd            = !$odd;
}

# Add up each 'single' digit
$sum = 0;
for($i = 0; $i < strlen($doubledNumber); $i++)
    $sum += (int)$doubledNumber[$i];

# A valid number doesn't have a remainder after mod10\
# or equal to 0
return (($sum % 10 ==0) && ($sum != 0));
}

function selectMultiRows($query)
{
	if((@$result = mysql_query ($query))==FALSE)
	{
		echo "<strong>Error in query:</strong> <br>$query";
	}
	else
	{
		$count = 0;
		$data = array();

		while ($row = mysql_fetch_array($result))
		{
			$data[$count] = $row;
			$count++;
		}
		return $data;
	}
}

function redirect($location)
{
	header('Location: ./' . $location);
}

function delete_picture($filename)
{
	$return = @unlink($filename);
	var_dump($return);
}

// slanje maila s attachmentom u tekst modu
function mail_attachment($filename, $path, $mailto, $from_mail, $from_name, $replyto, $subject, $message) {
    $file = $path.$filename;
    $file_size = filesize($file);
    $handle = fopen($file, "r");
    $content = fread($handle, $file_size);
    fclose($handle);
    $content = chunk_split(base64_encode($content));
    $uid = md5(uniqid(time()));
    $name = basename($file);
    $header = "From: ".$from_name." <".$from_mail.">\r\n";
    $header .= "Reply-To: ".$replyto."\r\n";
    $header .= "MIME-Version: 1.0\r\n";
    $header .= "Content-Type: multipart/mixed; boundary=\"".$uid."\"\r\n\r\n";
    $header .= "This is a multi-part message in MIME format.\r\n";
    $header .= "--".$uid."\r\n";
    $header .= "Content-type:text/plain; charset=utf-8\r\n";
    $header .= "Content-Transfer-Encoding: 7bit\r\n\r\n";
    $header .= $message."\r\n\r\n";
    $header .= "--".$uid."\r\n";
    $header .= "Content-Type: application/octet-stream; name=\"".$filename."\"\r\n"; // use diff. tyoes here
    $header .= "Content-Transfer-Encoding: base64\r\n";
    $header .= "Content-Disposition: attachment; filename=\"".$filename."\"\r\n\r\n";
    $header .= $content."\r\n\r\n";
    $header .= "--".$uid."--";
    mail($mailto, $subject, "", $header);
}


// adaptacija gornje funkcije za slanje HTML-a
function mail_attachmentx($filename, $path, $mailto, $from_mail, $from_name, $replyto, $subject, $message) {
    $file = $path.$filename;
    $file_size = filesize($file);
    $handle = fopen($file, "r");
    $content = fread($handle, $file_size);
    fclose($handle);
    $content = chunk_split(base64_encode($content));
    $uid = md5(uniqid(time()));
    $name = basename($file);
    $header = "From: ".$from_name." <".$from_mail.">\r\n";
    $header .= "Reply-To: ".$replyto."\r\n";
    $header .= "MIME-Version: 1.0\r\n";
    $header .= "Content-Type: multipart/mixed; boundary=\"".$uid."\"\r\n\r\n";
    $header .= "This is a multi-part message in MIME format.\r\n";
    $header .= "--".$uid."\r\n";

    $header .= "Content-type:text/html; charset=utf-8\r\n";
    $header .= "Content-Transfer-Encoding: 8bit\r\n";
    $header .= $message."\n";
    $header .= "--".$uid."\n";
    $header .= "Content-Type: application/octet-stream; name=\"".$filename."\"\r\n"; // use diff. tyoes here
    $header .= "Content-Transfer-Encoding: base64\r\n";
    $header .= "Content-Disposition: attachment; filename=\"".$filename."\"\r\n\n";
    $header .= $content."\r\n";
    $header .= "--".$uid."--";
    mail($mailto, $subject, "", $header);
}


# adaptacija gornje funkcije za slanje HTML-a bez attachmenta
function mail_html($mailto, $from_mail, $from_name, $replyto, $subject, $message) {

    $header = "From: ".$from_name." <".$from_mail.">\r\n";
    $header .= "Reply-To: ".$replyto."\r\n";

    $header .= "MIME-Version: 1.0\r\n";
    $header .= "Content-type:text/html; charset=utf-8"."\r\n";


    return mail($mailto, $subject, $message, $header);
}



# prikaz sadrzaja svih sistemskih varijabli
# HttpRequestDetails.php
# Copyright (c) 2002 by Dr. Herong Yang, http://www.herongyang.com/

function ShowAll()
{
#
   print "<pre>\n";
   print "\nSadrzaj \$_GET:\n";
   foreach ($_GET as $k => $v) {
      print "   $k = $v\n";
   }
#
   print "\nSadrzaj \$_POST:\n";
   foreach ($_POST as $k => $v) {
      print "   $k = $v\n";
   }
#
   print "\nSadrzaj \$_COOKIE:\n";
   foreach ($_COOKIE as $k => $v) {
      print "   $k = $v\n";
   }
#
   print "\nSadrzaj \$_REQUEST:\n";
   foreach ($_REQUEST as $k => $v) {
      print "   $k = $v\n";
   }
#
   print "\nSadrzaj \$_SERVER:\n";
   foreach ($_SERVER as $k => $v) {
      print "   $k = $v\n";
   }
#
   print "\nSadrzaj \$_SESSION:\n";
   foreach ($_SESSION as $k => $v) {
      print "   $k = $v\n";
   }
   print "</pre>\n";

}

# vraca ime drzave na osnovu id
function LookupCountry($id)
{

$query_Recordset1 = "SELECT * FROM ".DB_PREFIX."Countries WHERE CountryID = '". $id. "' ORDER BY CountryName ASC";
$Recordset1 = mysql_query($query_Recordset1) or die(mysql_error());
$row_Recordset1 = mysql_fetch_assoc($Recordset1);
#dodano zbog ruskog
//  if ($_SESSION['lang'] == 'ru') return $row_Recordset1['CountryNameRU'];
#
return $row_Recordset1['CountryName'];
}


# upis u log
function bogo_write_log($log_file, $what_to_write)
{
$log_entry = "\n".date("d.m.Y H:i:s").' '.$what_to_write."\n";
$fh = fopen($log_file, 'a') or die("can't open file");
fwrite($fh, $log_entry);
fclose($fh);
}

# vraca ime terminala
function GetTerminalName($term_id)
{

$query_Recordset1 = "SELECT * FROM ".DB_PREFIX."Places WHERE PlaceID = '".$term_id."'";

$Recordset1 = mysql_query($query_Recordset1) or die(mysql_error());
$row_Recordset1 = mysql_fetch_assoc($Recordset1);
$totalRows_Recordset1 = mysql_num_rows($Recordset1);
#dodano zbog ruskog
  if (isset($_SESSION['lang']) &&  $_SESSION['lang'] == 'ru')
  return $row_Recordset1['TermNameRU'];
#
return $row_Recordset1['PlaceNameEN'];
}


# vraca ime destinacije
function GetDestName($dest_id)
{
$query_Recordset1 = "SELECT * FROM ".DB_PREFIX."Places WHERE PlaceID = '".$dest_id."'";

$Recordset1 = mysql_query($query_Recordset1) or die(mysql_error());
$row_Recordset1 = mysql_fetch_assoc($Recordset1);
$totalRows_Recordset1 = mysql_num_rows($Recordset1);
#dodano zbog ruskog
  if (isset($_SESSION['lang']) && $_SESSION['lang'] == 'ru')
  return $row_Recordset1['DestNameRU'];
#
return $row_Recordset1['PlaceNameEN'];
}


# vraca ime drzave
function GetCountryName($country_id)
{
$query_Recordset1 = "SELECT * FROM ".DB_PREFIX."Countries WHERE CountryID = '".$country_id."'";

$Recordset1 = mysql_query($query_Recordset1) or die(mysql_error());
$row_Recordset1 = mysql_fetch_assoc($Recordset1);
$totalRows_Recordset1 = mysql_num_rows($Recordset1);

#dodano zbog ruskog
#  if ($_SESSION['lang'] == 'ru') return $row_Recordset1['CountryNameRU'];
#
return $row_Recordset1['CountryName'];
}

# vraca ime drzave na ruskom
function GetCountryNameRU($country_id)
{
$query_Recordset1 = "SELECT * FROM ".DB_PREFIX."Countries WHERE CountryID = '".$country_id."'";

$Recordset1 = mysql_query($query_Recordset1) or die(mysql_error());
$row_Recordset1 = mysql_fetch_assoc($Recordset1);
$totalRows_Recordset1 = mysql_num_rows($Recordset1);

#dodano zbog ruskog
#
return $row_Recordset1['CountryNameRU'];
}

# vraca ime terminala ako je poznat routeId
function GetTermFromRID($route_id)
{
$query_Recordset1 = "SELECT FromID FROM ".DB_PREFIX."Routes WHERE RouteID = '".$route_id."'";

$Recordset1 = mysql_query($query_Recordset1) or die(mysql_error());
$row_Recordset1 = mysql_fetch_assoc($Recordset1);
$totalRows_Recordset1 = mysql_num_rows($Recordset1);

return $row_Recordset1['FromID'];
}


# vraca ime destinacije preko Route_Id
function GetDestFromRID($route_id)
{
$query_Recordset1 = "SELECT ToID FROM ".DB_PREFIX."Routes WHERE RouteID = '".$route_id."'";

$Recordset1 = mysql_query($query_Recordset1) or die(mysql_error());
$row_Recordset1 = mysql_fetch_assoc($Recordset1);
$totalRows_Recordset1 = mysql_num_rows($Recordset1);


return $row_Recordset1['ToID'];
}



# Ispis teksta na naslovnicu
function Show_Frontpage_Articles($lang)
{
		# Uzima tekstove za Naslovnicu iz db ovisno o jeziku stranice
		$sql = "SELECT * FROM b_article WHERE b_article.art_published = 1 AND b_article.art_frontpage > 0 AND b_article.art_lang ='".$lang."' ORDER BY b_article.art_order";
		$res = mysql_query($sql) or die(mysql_error());
		$article = mysql_fetch_assoc($res);

		do
		{
			# Ispis teksta na naslovnicu - naslov i tekst
			echo '<div class="news">';
			echo '<h4 class="news_title">'.$article['art_title'].'</h4><br />';
			echo '<div class="news_text" style="color: #000">'.$article['art_text'].'</div>';
			echo '</div><br /><br /><br />';

		}
		while ($article = mysql_fetch_assoc($res)); # i tako za svaki tekst

		  $rows = mysql_num_rows($res);
		  if($rows > 0)
		  {
			  mysql_data_seek($res, 0);
			  $article = mysql_fetch_assoc($res);
		  }
}


# Ispis tekstova u Newsflash rubriku
function Show_Newsflash($lang)
{
		# Uzima tekstove za Newsflash - bira one koji nisu za naslovnicu, a objavljeni su
		$sql = "SELECT * FROM b_article WHERE b_article.art_published = 1 AND b_article.art_frontpage  = 0 AND b_article.art_lang ='".$lang."'ORDER BY b_article.art_frontpage, b_article.art_order";
		$res = mysql_query($sql) or die(mysql_error());
		$row = mysql_fetch_assoc($res);


		do {
			if (($row['art_frontpage'] == 0) and ($row['art_page'] == 'newsflash')) # ako nisu na naslovnici
			{
			echo '<div>';
			//echo '<li>';
			echo '<h4 class="newsflash_title">'.$row['art_title'].'</h4><br />';
			echo '<div class="newsflash_text">'.$row['art_text'].'</div>';
			//echo '</li>';
			echo '</div>';
			}
		}
		while ($row = mysql_fetch_assoc($res));

		  $rows = mysql_num_rows($res);

		  if($rows > 0)
		  {
			  mysql_data_seek($res, 0);
			  $row = mysql_fetch_assoc($res);
		  }
return true;
}




# Ispis tekstova na ostale stranice
function Show_OtherPages($lang, $stranica)
{
		# Uzima tekstove za ostale stranice - bira one koji nisu za naslovnicu, a objavljeni su
		$sql = "SELECT * FROM b_article WHERE b_article.art_published = 1 AND b_article.art_frontpage  = 0 AND b_article.art_lang ='".$lang."'ORDER BY b_article.art_frontpage";
		$res = mysql_query($sql) or die(mysql_error());
		$row = mysql_fetch_assoc($res);


		do {
			if (($row['art_frontpage'] == 0) and ($row['art_page'] == $stranica))# ako nisu na naslovnici
			{
			echo '<div>';
			//echo '<li>';
			echo '<h4 class="news_title">'.$row['art_title'].'</h4><br />';
			echo '<div class="news_text">'.$row['art_text'].'</div>';
			//echo '</li>';
			echo '</div>';

			}
		}
		while ($row = mysql_fetch_assoc($res));

		  $rows = mysql_num_rows($res);

		  if($rows > 0)
		  {
			  mysql_data_seek($res, 0);
			  $row = mysql_fetch_assoc($res);
		  }
return true;
}




# vraca Route_Id preko ServiceID
function GetRIDFromServiceID($service_id)
{
$query_Recordset1 = "SELECT RouteID FROM ".DB_PREFIX."Services WHERE ServiceID = '".$service_id."'";

$Recordset1 = mysql_query($query_Recordset1) or die(mysql_error());
$row_Recordset1 = mysql_fetch_assoc($Recordset1);
$totalRows_Recordset1 = mysql_num_rows($Recordset1);

return $row_Recordset1['RouteID'];
}




# vraca VehicleTypeID preko ServiceID
function GetVehicleIDFromServiceID($service_id)
{
$query_Recordset1 = "SELECT *
					 FROM ".DB_PREFIX."Services
					 WHERE ServiceID = '".$service_id."'
					 "
					 ;

$Recordset1 = mysql_query($query_Recordset1) or die(mysql_error());
$row_Recordset1 = mysql_fetch_assoc($Recordset1);
$totalRows_Recordset1 = mysql_num_rows($Recordset1);

return $row_Recordset1['VehicleTypeID'];
}

# vraca VehicleTypeName preko VehicleID
function GetVehicleName($vehicle_id)
{
$query_Recordset1 = "SELECT *
					 FROM ".DB_PREFIX."VehicleTypes
					 WHERE VehicleTypeID = '".$vehicle_id."'
					 "
					 ;

$Recordset1 = mysql_query($query_Recordset1) or die(mysql_error());
$row_Recordset1 = mysql_fetch_assoc($Recordset1);
$totalRows_Recordset1 = mysql_num_rows($Recordset1);

return $row_Recordset1['VehicleTypeName'];
}


# Poravnavanje udesno za iznose npr. cijene i sl.
# var je iznos, a len je duzina vracenog stringa
function AlignNumber($var, $len)
{
$return_var = '**********'.sprintf("%01.2f",$var);
return substr($return_var,$len);

}

# vraca opis drzave
function GetCountryDesc($country_id)
{
$query_Recordset1 = "SELECT * FROM ".DB_PREFIX."Countries WHERE CountryID = '".$country_id."'";

$Recordset1 = mysql_query($query_Recordset1) or die(mysql_error());
$row_Recordset1 = mysql_fetch_assoc($Recordset1);
$totalRows_Recordset1 = mysql_num_rows($Recordset1);

return $row_Recordset1['CountryDesc'];
}




# funkcija za koristenje Google Translate API-ja - Server side translation
function translateTexts($src_texts = array(), $src_lang, $dest_lang){
  //postavi jezike i znak | izmedju
  $lang_pair = $src_lang.'|'.$dest_lang;

  $src_texts_query = "";

  // svaki element niza dodaj u zahtjev za prevodjenje
  foreach ($src_texts as $src_text){
    $src_texts_query .= "&q=".urlencode($src_text);
  }

  $url = "http://ajax.googleapis.com/ajax/services/language/translate?v=1.0".$src_texts_query."&langpair=".urlencode($lang_pair);

  // posalji curl zahtjev
  // referer je fiksno postavljen

  $ch = curl_init();
  curl_setopt($ch, CURLOPT_URL, $url);
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
  curl_setopt($ch, CURLOPT_REFERER, "http://www.jamtransfer.com");
  $body = curl_exec($ch);
  curl_close($ch);

  // obradi JSON string
  $json = json_decode($body, true);

  if ($json['responseStatus'] != 200){
    return false;
  }


  $results = $json['responseData'];

  $return_array = array();

  // stavi rezultate u niz
  foreach ($results as $result){
    if ($result['responseStatus'] == 200){
      $return_array[] = $result['responseData']['translatedText'];
    } else {
      $return_array[] = false;
    }
  }

  //vrati prevedeni tekst
  return $return_array;
}

# sjeckanje i spajanje prijevoda
function SloziPrijevod ($cijeli_tekst)
{
$eng_opis = $cijeli_tekst;
$tagovi = array('.jpg','.gif','.png');
$zamjene = array('.xyzpg','.xyzif','.xyzng');
$puni_opis = str_replace($tagovi, $zamjene,$cijeli_tekst);
# podjela na manje dijelove radi Google API ogranicenja
$dio_za_prijevod_1 = substr($puni_opis, 0, 1500);
$dio_za_prijevod_2 = substr($puni_opis, 1501, 3000);
$dio_za_prijevod_3 = substr($puni_opis, 3001, 4500);
/*$dio_za_prijevod_4 = substr($puni_opis, 5001, 6500);
$dio_za_prijevod_5 = substr($puni_opis, 6501, 8000);*/

#ako je tekst na engleskom, ne prevodi
if ($_SESSION['lang'] != 'en')
{

$opis_drzave_1 = translateTexts(array($dio_za_prijevod_1,''), 'en', $_SESSION['lang']);
$opis = $opis_drzave_1[0];


$opis_drzave_2 = translateTexts(array($dio_za_prijevod_2,''), 'en', $_SESSION['lang']);
$opis .= $opis_drzave_2[0];


$opis_drzave_3 = translateTexts(array($dio_za_prijevod_3,''), 'en', $_SESSION['lang']);
$opis .= $opis_drzave_3[0];
/*
$opis_drzave_4 = translateTexts(array($dio_za_prijevod_4,''), 'en', $_SESSION['lang']);
$opis .= $opis_drzave_4[0];

$opis_drzave_5 = translateTexts(array($dio_za_prijevod_5,''), 'en', $_SESSION['lang']);
$opis .= $opis_drzave_5[0];*/

$tagovi = array('.jpg','.gif','.png');
$zamjene = array('.xyzpg','.xyzif','.xyzng');
$opis = str_replace($zamjene,$tagovi, $opis);

}
else
{
	$opis = $eng_opis;
}

if ($opis == '') $opis = $eng_opis;
return $opis;
}


# vraca trenutnu stranicu
function curPageURL() {
 $pageURL = 'http';
 if ($_SERVER["HTTPS"] == "on") {$pageURL .= "s";}
 $pageURL .= "://";
 if ($_SERVER["SERVER_PORT"] != "80") {
  $pageURL .= $_SERVER["SERVER_NAME"].":".$_SERVER["SERVER_PORT"].$_SERVER["REQUEST_URI"];
 } else {
  $pageURL .= $_SERVER["SERVER_NAME"].$_SERVER["REQUEST_URI"];
 }

 return $pageURL;
}


# Ispis tekstova na ostale stranice
function Show_ThePage($lang,$menu_opt)
{
		# Uzima tekstove za ostale stranice - bira one koji nisu za naslovnicu, a objavljeni su
		$sql = "SELECT * FROM b_pages
				WHERE page = '".$menu_opt."'
				ORDER BY b_pages.page";
		$res = mysql_query($sql) or die(mysql_error());
		$row = mysql_fetch_assoc($res);

		if ($row['page'] != '')
		{
			Show_OtherPages($lang,$menu_opt);
		}
/*
		do {
			if (($row['art_frontpage'] == 0) and ($row['art_page'] == $stranica))# ako nisu na naslovnici
			{
			echo '<div>';
			//echo '<li>';
			echo '<h4 class="newsflash_title">'.$row['art_title'].'</h4><br />';
			echo '<div class="newsflash_text">'.$row['art_text'].'</div>';
			//echo '</li>';
			echo '</div>';
			}
		}
		while ($row = mysql_fetch_assoc($res));

		  $rows = mysql_num_rows($res);

		  if($rows > 0)
		  {
			  mysql_data_seek($res, 0);
			  $row = mysql_fetch_assoc($res);
		  }
*/
return true;
}

# vraca popust ako je valjni kupon
function Check_Coupon($coupon)
{
$query_Recordset1 = "SELECT *
					 FROM ".DB_PREFIX."Coupons
					 WHERE Code = '".$coupon."'
					 "
					 ;

$Recordset1 = mysql_query($query_Recordset1) or die(mysql_error());
$row_Recordset1 = mysql_fetch_assoc($Recordset1);
$totalRows_Recordset1 = mysql_num_rows($Recordset1);

return $row_Recordset1['Popust'];
}

# Logiranje posjeta po userima - partnerima
# ako pokusaj dodavanja novog sloga naleti na vec postojeci, povecava posjete za 1
# trik je u unique kljucu koji se sastoji od UserID+YearMonth
# time je izbjegnuto nekoliko if naredbi :)
function LogUserStats($userid)
{
$ym = date(Y).date(m);

$query = "INSERT INTO ".DB_PREFIX."Stats (UserID, YearMonth,Visits)
		VALUES (".$userid.",'".$ym."',1) ON DUPLICATE KEY UPDATE Visits=Visits+1";

$Recordset1 = mysql_query($query);

}

# Prikaz statistike po mjesecima
function Show_Stats($userid)
{

		$sql = "SELECT * FROM ".DB_PREFIX."Stats WHERE UserID ='".$userid."'ORDER BY YearMonth DESC";
		$res = mysql_query($sql) or die(mysql_error());
		$row = mysql_fetch_assoc($res);


		do {

			$year = substr($row['YearMonth'],0,4);
			$month = substr($row['YearMonth'],4,2);
			echo '<br /><div>';

			echo '<h4 class="newsflash_title">Year: '.$year.' Month: '.$month.' Visits: '.$row['Visits'].'</h4>';

			echo '</div>';

		}
		while ($row = mysql_fetch_assoc($res));

		  $rows = mysql_num_rows($res);

		  if($rows > 0)
		  {
			  mysql_data_seek($res, 0);
			  $row = mysql_fetch_assoc($res);
		  }
return true;
}


# Imaju li terminal ili destinacija rute
function Has_Routes ($id, $td)
{
if ($td == 'T') {
$query_Rec1 = "SELECT *
					 FROM ".DB_PREFIX."Routes
					 WHERE TerminalID = '".$id."'
					 "
					 ;
}
elseif ($td == 'D') {
$query_Rec1 = "SELECT *
					 FROM ".DB_PREFIX."Routes
					 WHERE DestinationID = '".$id."'
					 "
					 ;
}

$Rec1 = mysql_query($query_Rec1) or die(mysql_error());
$row_Rec1 = mysql_fetch_assoc($Rec1);
$totalRows_Rec1 = mysql_num_rows($Rec1);
echo $totalRows_Rec1;
if ($totalRows_Rec1 != 0) return true;
if ($totalRows_Rec1 == 0) return false;

}


# Pretvaranje formata datuma
function YMD_to_DMY($date)
{
$elementi = explode('-',$date);
$new_date = $elementi[2].'.'.$elementi[1].'.'.$elementi[0];
return $new_date;
}

# Pretvaranje formata datuma
function DMY_to_YMD($date)
{
$elementi = explode('.',$date);
$new_date = $elementi[2].'-'.$elementi[1].'-'.$elementi[0];
return $new_date;
}


# sort 2-d arraya
function subval_sort($a,$subkey) {
	foreach($a as $k=>$v) {
		$b[$k] = strtolower($v[$subkey]);
	}
	asort($b);
	foreach($b as $key=>$val) {
		$c[] = $a[$key];
	}
	return $c;
}


function decrypt($sData, $sKey='stvarisepolakovracajunamjesto'){
    $sResult = '';
    $sData   = decode_base64($sData);
    for($i=0;$i<strlen($sData);$i++){
        $sChar    = substr($sData, $i, 1);
        $sKeyChar = substr($sKey, ($i % strlen($sKey)) - 1, 1);
        $sChar    = chr(ord($sChar) - ord($sKeyChar));
        $sResult .= $sChar;
    }
    return $sResult;
}

function decode_base64($sData){
    $sBase64 = strtr($sData, '-_', '+/');
    return base64_decode($sBase64);
}


function login($goto_page)
{
global $_POST;
global $_SESSION;

if (!isset($_SESSION["logged"])) $_SESSION["logged"] = false;
if (!$_SESSION["logged"])
{
?>

<link rel="stylesheet" type="text/css" href="css/bogoMain.css" />
<br/><br/><br/><br/><br/><br/><br/><br/>
<div style="margin:0 auto;" class="dashboard_pannel">
<div class="dashboard_pannel_header">
JamManager&trade; Login</div>
<div class="dashboard_pannel_content">

<?

$login = "";
$password = "";
if (isset($_POST["login"])) $login = @$_POST["login"];
if (isset($_POST["password"])) $password = @$_POST["password"];

	if (($login != "") && ($password != ""))
	{
	require 'db.php';
	$sql = "select * from ".DB_PREFIX."AuthUsers where AuthUserName = '" .$login ."'";
	$res = mysql_query($sql) or die(mysql_error());
	$row = mysql_fetch_assoc($res);
	  //if (isset($row)) reset($row);

		if (isset($password) && (md5($password) == trim($row['AuthUserPass'])))
		{
			session_start();
			$_SESSION["logged"] = true;
			$_SESSION['AuthUserName'] = $row['AuthUserName'];
			$_SESSION['AuthUserID'] = $row['AuthUserID'];
			$_SESSION['AuthLevelID'] = $row['AuthLevelID'];

			header("Location: ".$goto_page);
		}
		else
		{
		?>
			<p>
			<b><font color="-1">Username or Password are incorrect.</font></b>
			</p>
	<?	}
	}
}
if (isset($_SESSION["logged"]) && (!$_SESSION["logged"]))
{
?>


	<form action="index.php" method="post">
		<table  border="0" cellspacing="1" cellpadding="4">
			<tr>
				<td>Username: </td>
				<td><input type="text" name="login" value="<?php echo $login ?>"></td>
			</tr>
			<tr>
				<td>Password: </td>
				<td><input type="password" name="password" value="<?php echo $password ?>"></td>
			</tr>
			<tr>
				<td></td><td align="right"><br /><input type="submit" name="action" value="Login"></td>
			</tr>
			<tr>
				<td></td><td align="right">
				<a href="JM_register.php">Register</a>
				</td>
			</tr>
			<tr>
				<td></td><td align="right">
				<a href="JM_forgetpass.php">Lost password?</a>
				</td>
			</tr>
		</table>
	</form>

</div>
</div>
<?
}

  if (!isset($_SESSION["logged"])) $_SESSION["logged"] = false;

  return $_SESSION["logged"];
}



function test_mail_html($mailto, $from_mail, $from_name, $replyto, $subject, $message)
{
//error_reporting(E_ALL);
//error_reporting(E_STRICT);

date_default_timezone_set('Europe/Zagreb');

require_once('class.phpmailer.php');
include("class.smtp.php"); // optional, gets called from within class.phpmailer.php if not already loaded

$mail             = new PHPMailer();

//$body             = file_get_contents('contents.html');
//$body             = eregi_replace("[\]",'',$body);

$mail->IsSMTP(); // telling the class to use SMTP
$mail->Host       = "mail.jamtransfer.com"; // SMTP server
//$mail->SMTPDebug  = 2;                     // enables SMTP debug information (for testing)
                                           // 1 = errors and messages
                                           // 2 = messages only
$mail->SMTPAuth   = true;                  // enable SMTP authentication
$mail->SMTPSecure = "ssl";                 // sets the prefix to the servier
$mail->Host       = "smtp.gmail.com";      // sets GMAIL as the SMTP server
$mail->Port       = 465;                   // set the SMTP port for the GMAIL server
$mail->Username   = "bogo.split@gmail.com";  // GMAIL username
$mail->Password   = "soicbogo";            // GMAIL password

$mail->SetFrom($from_mail, $from_name);

$mail->AddReplyTo($replyto,$from_name);

$mail->Subject    = $subject;

$mail->AltBody    = "To view the message, please use an HTML compatible email viewer!"; // optional, comment out and test

$mail->MsgHTML($message);

//$address = "bogo@jamtransfer.com";
$mail->AddAddress($mailto);

//$mail->AddAttachment("images/phpmailer.gif");      // attachment
//$mail->AddAttachment("images/phpmailer_mini.gif"); // attachment

return $mail->Send();
/*
if(!$mail->Send()) {
  echo "Mailer Error: " . $mail->ErrorInfo;
} else {
  echo "Message sent!";
}
*/

}

#*************
# Login Paket
#*************
function checkUnique($table, $field, $compared)
{
	$query = mysql_query('SELECT  '.mysql_real_escape_string($field).' FROM '.mysql_real_escape_string($table).' WHERE "'.mysql_real_escape_string($field).'" = "'.mysql_real_escape_string($compared).'"');
	if(mysql_num_rows($query)==0)
	{
		return TRUE;
	}
	else {
		return FALSE;
	}
}


function random_string($type = 'alnum', $len = 8)
{
	switch($type)
	{
		case 'alnum'	:
		case 'numeric'	:
		case 'nozero'	:

				switch ($type)
				{
					case 'alnum'	:	$pool = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
						break;
					case 'numeric'	:	$pool = '0123456789';
						break;
					case 'nozero'	:	$pool = '123456789';
						break;
				}

				$str = '';
				for ($i=0; $i < $len; $i++)
				{
					$str .= substr($pool, mt_rand(0, strlen($pool) -1), 1);
				}
				return $str;
		  break;
		case 'unique' : return md5(uniqid(mt_rand()));
		  break;
	}
}


function valid_email($str)
{
return ( ! preg_match("/^([a-z0-9\+_\-]+)(\.[a-z0-9\+_\-]+)*@([a-z0-9\-]+\.)+[a-z]{2,6}$/ix", $str)) ? FALSE : TRUE;
}

function valid_url($str)
{
	return ( ! preg_match('/^(http|https|ftp):\/\/([A-Z0-9][A-Z0-9_-]*(?:\.[A-Z0-9][A-Z0-9_-]*)+):?(\d+)?\/?/i', $str)) ? FALSE : TRUE;
}

# Kraj Login Paketa


function showWindow($title, $content, $add_style=NULL)
{
echo '
<div class="dashboard_pannel_wrapper center_me">
    <div class="dashboard_pannel">
    	<div class="dashboard_pannel_header">';
        	echo $title;

echo '
      	</div>
    	<div class="dashboard_pannel_content">';
        echo $content;
echo '
     	</div>
    </div>
</div>';
}

function alertBox($message)
{
    echo '
    <script>alert("'.$message.'");</script>
    ';
}

function sendSysMsg($toUserType, $title, $body, $toUserID=NULL)
{
    $data = array(
        'ID' => '',
        'Msg' => $title,
        'Body' => $body,
        'UserLevel' => $toUserType,
        'UserID' => $toUserID,
        'DateTime' => date("Y-m-d H:i:s")
    );
    XInsert(DB_PREFIX.'Messages',$data);
}



function GetCustomerInfo($detailID)
{

	$qryd = "SELECT * FROM ".DB_PREFIX."OrderDetails
			WHERE DetailsID = ".$detailID;
	$resd = mysql_query($qryd) or die(mysql_error());
	$d 	  = mysql_fetch_object($resd);


	$qrym = "SELECT * FROM ".DB_PREFIX."OrdersMaster
			WHERE OrderID = ".$d->OrderID;
	$resm = mysql_query($qrym) or die(mysql_error());
	$m 	  = mysql_fetch_assoc($resm);
	
	return $m;
}


function clrVal($val)
	{
		# ovo je trik koji sprjecava da se stalno dodaju slashes
		
		if (get_magic_quotes_gpc()) {
        return stripslashes($val);
	    } else {
        return $val;
    	}

	}


function GetRouteKm($routeid)
{
	$row = mysql_fetch_assoc( mysql_query( "SELECT Km FROM ".DB_PREFIX."Routes WHERE RouteID = '{$routeid}'" ) );
	return $row['Km'];
}




function showExtrasTable($detailsID,$ownerID)
{
	$q = "	SELECT * FROM ".DB_PREFIX."OrderExtras 
			WHERE OrderDetailsID = '{$detailsID}' 
			AND OwnerID = '{$ownerID}' 
			ORDER BY ServiceID ASC
			";
	$r = mysql_query($q) or die(mysql_error());
	
	$output = '';
	
	if (mysql_num_rows($r) > 0)
	{
		$output = '<hr/>Extras<hr/><table width="100%"><tr>
					<thead>
					<td>Service</td>
					<td>Price</td>
					<td>Qty</td>
					<td>Amount</td>
					</thead></tr>';
		
		while ($s = mysql_fetch_object($r))
		{
			$output .= '<tr><td>' . $s->ServiceName . '</td>';
			$output .= '<td>' . $s->Price . '</td>';
			$output .= '<td>' . $s->Qty . '</td>';
			$output .= '<td>' . $s->Sum .'</td></tr>';
		}
		
		$output .= '</table><hr/>';
	}
	
	return $output;
}


function showExtrasWorksheet($detailsID,$ownerID)
{
	$q = "	SELECT * FROM ".DB_PREFIX."OrderExtras 
			WHERE OrderDetailsID = '{$detailsID}' 
			AND OwnerID = '{$ownerID}' 
			ORDER BY ServiceID ASC
			";
	$r = mysql_query($q) or die(mysql_error());
	
	$output = '';
	
	if (mysql_num_rows($r) > 0)
	{
		$output = EXTRAS.':<br/><table width="100%" style="font-size: 11px;"><tr>';
		
		while ($s = mysql_fetch_object($r))
		{
			$output .= '<tr><td>' . $s->ServiceName . '</td>';
			$output .= '<td>' . $s->Qty . '</td>';
		}
		
		$output .= '</table><hr/>';
	}
	
	return $output;
}

function UserRealName($id)
{
	$q = "SELECT * FROM ".DB_PREFIX."AuthUsers WHERE AuthUserID = '{$id}'";
	$r = mysql_query($q);
	$u = mysql_fetch_object($r);
	
	return $u->AuthUserRealName;
}

function GetCarName($id)
{
	$q = "SELECT * FROM ".DB_PREFIX."Vehicles WHERE OwnerID = ".$_SESSION['AuthUserID']. 
		" AND VehicleID = ".$id;
	$w = mysql_query($q) or die(mysql_error());
	$r = mysql_fetch_assoc($w);
	return $r['VehicleName'];
}



function showCommision($user, $endDate, $startDate = '')
{
    
    # deklarirano u R_allCommision.php
    global $i, $paidComm, $unpaidComm;
    
    if ($startDate == '') $startDate = date("Y-m-d", strtotime("-1 month"));
    if ($endDate == '') $endDate = date("Y-m-d");
    $subTotal = 0;

    $q1  = "SELECT * FROM ".DB_PREFIX."OrderDetails ";
    $q1 .= "WHERE DriverID = '{$user}' ";
    $q1 .= "AND TransferStatus >= 7 ";
    $q1 .= "AND PickupDate >= '{$startDate}'";
    $q1 .= "AND PickupDate <= '{$endDate}'";

    $w = mysql_query($q1) or die( mysql_error() . ' OrderDetails');

    # ako vozac ima transfere
    if (mysql_num_rows($w) ) {
    
       
        
        echo '<hr/><h3>Driver: '. UserRealName($user) . ' ID:' . $user . '</h3>';
        echo '<table width="100%" colpadding="4" border="0">';
        echo '<thead>';
        echo '<tr>';
        echo '<td style="border-bottom:1px solid black"><b>Transfer Number</b></td>';
        echo '<td style="border-bottom:1px solid black"><b>Transfer Date</b></td>';
        echo '<td style="border-bottom:1px solid black"><b>Commision</b></td>';
        echo '<td style="border-bottom:1px solid black"><b>Payment Status</b></td>';
        echo '</tr>';
        echo '</thead>';

        while ($od = mysql_fetch_object($w))
        {
            # za svaki transfer pojedinog vozaca
            echo '<tr>';
            echo '<td>' . $od->DetailsID . '</td><td>' . $od->PickupDate . '</td><td>';
            echo $od->TaxidoComm . ' EUR' . '</td>';
            echo '<td>';
            echo '<div id="upd'.$i.'">';
            if ( $od->TransferStatus == '8') echo 'Paid'; 
            else {
                echo 'Not Paid';
                echo '<input type="hidden" id="detailsID'.$i.'" value="'.$od->DetailsID.'" />';
                echo '&nbsp;&nbsp;&nbsp;<input type="button" class="my_button"
                id="setPaid'.$i.'" value="&larr; Set to Paid" 
                onclick="setPaid('.$i.')"/>';
                //echo $i;
            }
            echo '</div>';
            echo '</td>';
            echo '</tr>';
            
            if ( $od->TransferStatus == '7') $unpaidComm += $od->TaxidoComm;
            if ( $od->TransferStatus == '8') $paidComm += $od->TaxidoComm;
            
            $subTotal += $od->TaxidoComm;
            
            $i++;
        }
        echo '<td></td><td></td><td>';
        echo '<hr/><b>' . number_format($subTotal,2) . ' EUR</b>' . '</td><td></td>';
        echo '</table>';
    }
    
    return $subTotal;
}
#
#KRAJ SVIH FUNKCIJA
#

