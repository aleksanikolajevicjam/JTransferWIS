<div class="container white">
<?
	ini_set('display_errors', 1);
	ini_set('log_errors', 1);
	ini_set('error_log', dirname(__FILE__) . '/error_log.txt');
	error_reporting(E_ALL);


require_once ROOT.'/db/v4_Articles.class.php';

$art = new v4_Articles();
$where = "WHERE Page = '".$activePage."'";
$a = $art->getKeysBy('Position', 'ASC', $where); 
$idarc='';
if (!isset($help)) $help='';
if( count($a) > 0) {
    foreach($a as $nn => $id) {
	    $art->getRow($id);
		$t_arr=explode("/",$art->getTitle());
		$title=$t_arr[0];
		if (count($t_arr)==2) {
			$page=$t_arr[1];
			if ($page!=$help) $display="display:none";
			else {
				$display="";	
				$idarc=$art->getID();
			}	
		}
		else $display="display:none";	
		?>
		<a  id="header<?= $art->getID() ?>" onclick="show(<?=$art->getID()?>);">
		
			<div class="row xbox-solid xbg-light-blue  pad1em listTile" 
			style="border-top:1px solid #eee;border-bottom:0px solid #eee">
				<h3><?= $title ?></h3>
			</div>
		</a>
		
		<div id="transferWrapper<?= $art->getID() ?>" class="editFrame" style="<?= $display ?>">
			<div id="inlineContent" class="row ">
				<div  class="xcol-md-12">
					<?= html_entity_decode($art->getArticle()) ?>
				</div>
			</div>
		</div>		
		<?
    }
}  
?>
</div>
<span id='idarc'><?=$idarc ?></span>
	
<script>	
$(document).ready(function() {
    var idarc=$('#idarc').text();
	var headerarc='header'+idarc;
	document.getElementById(headerarc).scrollIntoView( {behavior: "smooth" } );
});
function show(id) {
	id ="#transferWrapper"+id;
	if($(id).css('display') == 'none') $(id).show(500);
	else $(id).hide(500);
}
</script> 