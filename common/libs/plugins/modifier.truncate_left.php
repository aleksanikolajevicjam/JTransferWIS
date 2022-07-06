<?php

/**
* Smarty truncate_left modifier plugin
*
* Type:     modifier<br />
* Name:     truncate_left<br />
* Purpose:  truncates left hand side of a string
* @link: none
* @param string
* @param integer
* @param string
* @return string
*/

function smarty_modifier_truncate_left($string, $left=1) {

$string = substr($string, $left);

return $string;

}
?>