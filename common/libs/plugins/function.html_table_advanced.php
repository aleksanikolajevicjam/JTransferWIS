<?php
/**
 * Smarty plugin
 * @package Smarty
 * @subpackage plugins
 */


/**
 * Smarty {html_table_advanced} function plugin
 *
 * Type:     function<br>
 * Name:   html_table_advanced<br>
 * Date:     Feb 17, 2003<br>
 * Purpose:  make an html table from an array of data<br>
 * Input:<br>
 *         - loop = array to loop through
 *         - cols = number of columns
 *         - rows = number of rows
 *         - table_attr = table attributes
 *         - tr_attr = table row attributes (arrays are cycled)
 *         - td_attr = table cell attributes (arrays are cycled)
 *         - trailpad = value to pad trailing cells with
 *         - vdir = vertical direction (default: "down", means top-to-bottom)
 *         - hdir = horizontal direction (default: "right", means left-to-right)
 *         - inn4116er = inner loop (default "cols": print $loop line by line,
 *                   $loop will be printed column by column otherwise)
 *          - cnt_rows = broj redova koji se odjednom prikazuju na ekranu
 *          - rowOffset = pomeraj koji se prosledjuje kao parametar
 *          - message = poruka koja se ispisuje u donjoj kontroli
 *          - browseString = string koji omogucava normalno kretanje kroz stranice
 *
 * Examples:
 * <pre>
 * {table loop=$data}
 * {table loop=$data cols=4 tr_attr='"bgcolor=red"'}
 * {table loop=$data cols=4 tr_attr=$colors}
 * </pre>
 * @author   Monte Ohrt <monte@ispi.net> zidane <ivank@fon.bg.ac.yu>
 * @version  1.1

 * @param array
 * @param Smarty
 * @return string
 */

 function smarty_function_html_table_advanced($params, &$smarty)
{
    global $LanguageArray;
	$table_attr = 'border="0"';
    $cap_attr = ''; //caption tag
    $tr_attr = '';
    $td_attr = '';
    $cols = 3;
    $rows = 3;
    $trailpad = '&nbsp;';
    $vdir = 'down';
    $hdir = 'right';
    $inner = 'cols';

    //dodao ivan
    $cnt_all_rows = 0;
    $cnt_rows = 10; //broji koliko na jednoj stranici ima rezultata
    $rowOffset = 0; // govori koliki je pomeraj
    $message =  $LanguageArray["value"]["PLG_PAGER_SHOWED"]; //ispisuje poruku u dnu stranice "kategorija je prikazano"
    $browseString = ""; //string za pretragu koji se koristi za pravljenje linka
    
    //$script_name= $PHP_SELF;
    if (!isset($params['loop'])) {
        $smarty->trigger_error("html_table_advanced: missing 'loop' parameter");
        return;
    }

    foreach ($params as $_key=>$_value) {
        switch ($_key) {
            case 'loop':
                $$_key = (array)$_value;
                break;

            case 'cols':
            case 'rows':
                $$_key = (int)$_value;
                break;

            case 'table_attr':
            case 'trailpad':
            case 'hdir':
            case 'vdir':
            case 'inner':
                $$_key = (string)$_value;
                break;

            case 'tr_attr':
            case 'td_attr':
                $$_key = $_value;
                break;
            //dodao ivan
            case 'cnt_all_rows':
                $$_key = (int)$_value;
                break;
            case 'cnt_rows':
                $$_key = (int)$_value;
                break;
            case 'rowOffset':
               $$_key = (int)$_value;
                break;
            case 'message':
                $$_key = (string)$_value;
                break;
            case 'scriptName':
                $$_key = (string)$_value;
                break;
			case 'browseString':
				$$_key = (string)$_value;
                break;
			case 'tableheader':
				$$_key =(string)$_value;
			case 'caption':
				$$_key =(string)$_value;
			break;
			case 'exportlinks':
				$$_key =(string)$_value;
			break;
			case 'filter':
				$$_key =(string)$_value;
			break;
		//dodao ivan
        }
    }
	
    $loop_count_all = $params["cnt_all_rows"]*$params["cols"];

    // ostatak prikazujemo na ekranu
    $loop_count = count($loop);
    if (empty($params['rows'])) {
        /* no rows specified */
        //menjano da bi se prikaz ogranicio na zeljeni
        $rows = ceil($loop_count/$cols);
        if($rows > $cnt_rows) $rows = $cnt_rows;
    } elseif (empty($params['cols'])) {
        if (!empty($params['rows'])) {
            /* no cols specified, but rows */
            $cols = ceil($loop_count/$rows);
        }
    }

    $output = "<table class='table table-striped table-bordered table-hover dataTables-example dataTable' $table_attr>\n";
    if(count($params["tableheader"]) != 0)
    {
    	$output .= "<caption>".$params["caption"]."</caption>";
    	
    	if($params["exportlinks"] == "true")
    	{
			$output .= "<div class='excel_export' style='float:right;font-size: 90%;font-weight: bold;padding:0px 10px 3px 10px;margin:0px;text-align:left;'> <a style='color: black;text-decoration: none;' href='excel_export.php'><img src='../images/excel.png' border='0'> ".$LanguageArray["value"]["COMMON_EXPORT_EXCEL"]."</a> | <a style='color: black;text-decoration: none;' href='#'><img src='../images/pdf.png' border='0'> ".$LanguageArray["value"]["COMMON_EXPORT_PDF"]."</a> </div>";
    	}
		if(!($params["filter"] == ""))
    	{
    		$output .= $params["filter"];
    	}
    }
	if (count($params["tableheader"]) != 0){
		$output .= "<thead><tr class='header'>";
		foreach ($params["tableheader"] as $head)
			$output .= "<th >".$head."</th>";
		$output .= "</tr></thead>";
	}
	
    for ($r=0; $r<$rows; $r++) {
        $output .= "<tr" . smarty_function_html_table_advanced_cycle('tr', $tr_attr, $r) . ">\n";
        $rx =  ($vdir == 'down') ? $r*$cols : ($rows-1-$r)*$cols;
		
        for ($c=0; $c<$cols; $c++) {
            $x =  ($hdir == 'right') ? $rx+$c : $rx+$cols-1-$c;
            if ($inner!='cols') {
                /* shuffle x to loop over rows*/
                $x = floor($x/$cols) + ($x%$cols)*$rows;
            }

            if ($x<$loop_count) {
                $output .= "<td" . smarty_function_html_table_advanced_cycle('td', $td_attr, $c) . ">" . $loop[$x] . "</td>\n";
            } else {
                $output .= "<td" . smarty_function_html_table_advanced_cycle('td', $td_attr, $c) . ">$trailpad</td>\n";
            }
        }
        $output .= "</tr>\n";
    }
    $output .= "</table>\n";

    if($loop_count_all > $cnt_rows*$cols)
    {
	 	  $strana = ceil($loop_count_all / ($cnt_rows*$cols));
    	// deo koda koji iscrtava kontrolu za kretanje kroz vise stranica
          $previousOffset = $rowOffset - $cnt_rows*$cols;
          $nextOffset = $rowOffset + $cnt_rows*$cols;
		
          $output .= "<div class='dataTables_info'>";
          $output .= $LanguageArray["value"]["PLG_PAGER_PAGES"] . ($rowOffset/$cols + 1) . "-" .  ($rows + $rowOffset/$cols ) . $LanguageArray["value"]["PLG_PAGER_FROM"];
    	  $output .= $loop_count_all/$cols." " . $message ." \n";
		  $output .= "</div>";
	
		$output .= "<div class='dataTables_paginate paging_simple_numbers' id='DataTables_Table_0_paginate'>";
		$output .= "<ul class='pagination'>";     	
     if ($rowOffset > 0)
       $output .= " "."\n\t<li class='paginate_button previous'><a href=\"" . $scriptName .
            "?offset=" . rawurlencode($previousOffset) ."&" .
            $browseString ."\">" . $LanguageArray["value"]["PLG_PAGER_BACK"] . "</a></li> ";
     else
       $output .= " "."<li class='paginate_button previous disabled'><a href='#'>" . $LanguageArray["value"]["PLG_PAGER_BACK"] . "</a></li>";

     for($x=0, $page=1;
         $x<$loop_count_all;
         $x+=$cnt_rows*$cols, $page++)
        if ($x < $rowOffset ||
            $x > ($rowOffset + $cnt_rows - 1))
           $output .= "<li class='paginate_button'><a href=\"" . $scriptName .
                "?offset=" . rawurlencode($x)."&". $browseString .
                "\">" . $page  . "</a></li> ";
           else
         
    //       $output .= "<li>" .$page  . "</li>" ;

     if ($loop_count_all > $nextOffset)
       $output .= "\n\t<li class='paginate_button next'><a href=\"" . $scriptName .
            "?offset=" . rawurlencode($nextOffset) ."&". $browseString .
            "\">" . $LanguageArray["value"]["PLG_PAGER_FORWARD"] . "</a></li> ";
     else
       $output .= " "."<li class='paginate_button next disabled'><a href='#'>" . $LanguageArray["value"]["PLG_PAGER_FORWARD"]. "</a></li>";
 	
	$output .= "</ul>";
	$output .= "</div>";
    }
    else 
    {
    	$output .= "<div id='pager'>TOTAL: ".$loop_count_all/$cols."</div>";
    }
    // kraj dela koda koji iscrtava kontrolu za kretanje kroz vise stranica

    return $output;
}

function smarty_function_html_table_advanced_cycle($name, $var, $no) {
    if(!is_array($var)) {
        $ret = $var;
    } else {
        $ret = $var[$no % count($var)];
    }

    return ($ret) ? ' '.$ret : '';
}

/* vim: set expandtab: */

?>