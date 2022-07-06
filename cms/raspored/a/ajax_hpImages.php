<?
error_reporting(0);

session_start();

require_once '../f/db_funcs.php';
require_once '../data.php';
require_once('../lng/' . $_SESSION['lng'] . '_config.php');

//echo '<pre>'; print_r($_FILES); echo '</pre>';


$uploadDir = '../../hpimages';
$imgDir = 'hpimages';

@mkdir($uploadDir,0755);


foreach($_FILES as $file) { 
            $n = $file['name']; 
            $s = $file['size'];
            $t = $file['tmp_name'];  
            if (!$n) continue; 
            //echo "File: $n ($t bytes)"; 
            if(file_exists($t)) 
            {
                copy($t, $uploadDir.'/'.$n);
                //echo substr(sprintf('%o', fileperms($uploadDir)), -4);
                //echo '<img src="'.$imgDir.'/'.$n.'" style="max-width:120px;max-height:120px;"/>';
            }
            
            else echo '<script> alert("'.ERROR.'");</script>';
        }	

# Init vars

$ownerID = $_SESSION['OwnerID'];

if ( isset($_REQUEST['ID']) )     $ID        = $_REQUEST['ID'];

if ( isset($_REQUEST['Action']) ) $action     = $_REQUEST['Action'];


$msg = COMPLETED;


if ($action == 'update' and (trim($n) != '') )
{
   
    $data = array();
    
    if (trim($n) != '') $data['Image'] = $n;
    
    $where = " ID=".$ID;
    
    $updated = XUpdate('tc_hpimages', $data, $where);
    
    if ($updated) $msg = CHANGES_SAVED;
    else 
    {
        echo '<div class="alert alert-error">' . ERROR .  '</div><br/>';
        die;
    }
}

if ($action == 'delete')
{
    # Delete from Vehicles
    XDelete('tc_hpimages','ID='.$ID);

}


if ($action == 'new' and (trim($n) != '') ) 
{

   
    # Insert to Vehicles
        
    $data = array(
            'Image' => $n
    );
    
    $imgID = XInsert('tc_hpimages',$data);



}

echo '<div class="alert alert-success">' . $msg . '</div><br/>';
