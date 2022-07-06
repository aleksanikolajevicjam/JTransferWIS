<?
$date = '01.01.2014'; 
echo date("Y-m-d", strtotime($date));

die();
$content = '<br>New message:' . date("H:i:s");
/*
$fp = fopen('file.txt', 'a');

     fseek($fp, 0, SEEK_SET); //MOVES THE CURSOR 0 PLACES FROM START OF THE FILE
    fwrite($fp, $content . "\n");

    fclose($fp);
*/

prepend($content,'file.txt');    
    
 function prepend($string, $filename) {
  $context = stream_context_create();
  $fp = fopen($filename, 'r', 1, $context);
  $tmpname = md5($string);
  file_put_contents($tmpname, $string ."\n");
  file_put_contents($tmpname, $fp, FILE_APPEND);
  fclose($fp);
  unlink($filename);
  rename($tmpname, $filename);
}
