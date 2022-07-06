<?
session_start();

require_once '../config.php';
require_once('../lng/' . $_SESSION['lng'] . '_config.php');
require_once '../../c/db.class.php';
require_once '../../c/tc_OrderDetails.class.php';

$d = new tc_OrderDetails();

$ID = $_REQUEST['DetailsID'];

$d->getRow($ID);

$s = $d->getTransferStatus()

?>
        <label><?= NEW_STATUS ?></label>
        <select name="newStatus">
            <option value="1" <?= $s == '1' ? 'selected':'';?>><?= $StatusDescription[1]; ?></option>
            <option value="2" <?= $s == '2' ? 'selected':'';?>><?= $StatusDescription[2]; ?></option>
            <option value="3" <?= $s == '3' ? 'selected':'';?>><?= $StatusDescription[3]; ?></option>
            <option value="4" <?= $s == '4' ? 'selected':'';?>><?= $StatusDescription[4]; ?></option>
            <option value="5" <?= $s == '5' ? 'selected':'';?>><?= $StatusDescription[5]; ?></option>
            <option value="6" <?= $s == '6' ? 'selected':'';?>><?= $StatusDescription[6]; ?></option>
            <option value="7" <?= $s == '7' ? 'selected':'';?>><?= $StatusDescription[7]; ?></option>
        </select>
        
        <label><?= NOTES ?></label>
        <textarea name="changeDesc" rows="7" class="span4"><?= $d->getDriverNotes(); ?></textarea>

