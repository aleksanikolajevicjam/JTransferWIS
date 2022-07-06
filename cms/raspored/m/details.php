<?
$id         = $_REQUEST['id'];
$details    = $_SESSION['DETAILS'];

$task = $details[$id];

echo '<div class="ui-grid-a">';

if (count($task) > 0) {
	foreach ($task as $k => $v)
	{
		echo '<div class="ui-block-a" style="text-align:right;">';
		
		if ($v != '-') echo $k . ' :&nbsp;&nbsp; </div>'; 
		else echo '<hr/></div>';
		
		echo '<div class="ui-block-b"><b>';
		
		if ($v != '-') echo $v; else echo '<hr/>';
		echo '</b></div>';
	}
}
else echo '<div class="ui-block-a" style="text-align:right;">No data</div>';



echo '  <div class="ui-block-a"><br/><br/>
        <a href="index.php?option=menu" data-role="button" data-icon="home" data-theme="b" data-transition="slide" data-direction="reverse">Home</a>
        </div>';
echo '  <div class="ui-block-b"><br/><br/>
        <a href="index.php?option=finished&id='.$id.'" data-role="button" data-icon="check" data-theme="b" data-transition="slide">Finished</a>
        </div>';



echo '  <div class="ui-block-a"><br/><br/>
        <a href="index.php?option=nalog&id='.$id.'" data-role="button" data-icon="bars" data-theme="b" data-transition="flip">Putni nalog</a>
        </div>';
        
echo '  <div class="ui-block-b"><br/><br/>
        <a href="index.php?option=sign&paxname='.trim($task['Pax Name']).'&id='.$id.'" data-role="button" data-icon="info" data-theme="b" data-transition="flip">Welcome Sign</a>
        </div>';        

echo '  <div class="ui-block-b"><br/><br/>
        <a href="index.php?option=racun&id='.$id.'" data-role="button" data-icon="info" data-theme="b" data-transition="flip">Receipt</a>
        </div>';  

echo '</div>';

/*EOF*/

