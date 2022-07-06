<?
error_reporting(0);
$file = $_GET['file'];

$path  = '../i/';
$path2 = $path . 'thumbnail/';

unlink($path.$file);
unlink($path2.$file);

echo 'Deleted';
