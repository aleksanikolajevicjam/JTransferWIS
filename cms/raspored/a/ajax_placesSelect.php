<?
session_start();

require_once '../../c/db.class.php';
require_once '../../c/tc_places.class.php';

require_once('../lng/' . $_SESSION['lng'] . '_config.php');

$p = new tc_places();

$fld = $_REQUEST['FieldName'];
$SpanID = $_REQUEST['SpanID'];
$tmpfld = 'T'.$fld;

$places = '';

$pk = $p->getKeysBy('PlaceNameEN','asc',' WHERE PlaceActive = 1');

$places .= '<select id="'.$tmpfld.'" name="'.$tmpfld.'" onchange="putValue'.$fld .'();">
            <option value="0">'. PLEASE_SELECT . '</option>';


foreach ($pk as $n => $id)
{
    $p->getRow($id);
    $places .= '<option value="'.$id.'">'.$p->getPlaceNameEN().'</option>';
    
}
$places .= '</select>';

echo $places;

?>

<script type="text/javascript">
$("#<?= $tmpfld ?>").click();

function putValue<?= $fld ?>()
{    
    var txt = $("#<?= $tmpfld ?> option:selected").text();
    $("#<?= $fld ?>").val(txt); 
    $("#<?= $tmpfld ?>").remove();
    $("#<?= $fld ?>").show().trigger('change'); 
    $("#<?= $SpanID ?>").show();
}    
</script>


