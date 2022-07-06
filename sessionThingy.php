<?
/*
if ( $parts = parse_url( $_SERVER['HTTP_REFERER'] ) ) {
    //echo $parts[ "scheme" ] . "://" . $parts[ "host" ];
}
session_set_cookie_params('3600','/','.' . $parts['host'], false, true); 
*/
	@session_start();
