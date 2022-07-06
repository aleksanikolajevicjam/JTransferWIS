<?
/* 
* Smarty plugin 
* ------------------------------------------------------------- 
* File:     modifier.round.php 
* Type:     modifier 
* Name:		round 
* Purpose:  rounds foat to an integer
* ------------------------------------------------------------- 
*/ 
function smarty_modifier_round($string) 
{ 
    return floor($string);
} 

?>