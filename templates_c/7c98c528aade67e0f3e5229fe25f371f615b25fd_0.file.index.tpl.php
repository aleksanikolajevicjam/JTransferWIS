<?php
/* Smarty version 3.1.32, created on 2022-05-12 07:59:53
  from 'c:\wamp\www\jamtransfer\plugins\PriceRules\templates\index.tpl' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.32',
  'unifunc' => 'content_627cbe7930de05_91063369',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '7c98c528aade67e0f3e5229fe25f371f615b25fd' => 
    array (
      0 => 'c:\\wamp\\www\\jamtransfer\\plugins\\PriceRules\\templates\\index.tpl',
      1 => 1652099525,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_627cbe7930de05_91063369 (Smarty_Internal_Template $_smarty_tpl) {
?><form id="" class="form " method="post">	
	<div class="box-body ">
        <div class="row">
			<div class="col-md-12">

						<input type="hidden" name="ID" id="ID" class="w100" value="<?php echo $_smarty_tpl->tpl_vars['ID']->value;?>
" >
						<input type="hidden" name="rulesType" id="rulesType" class="w100" value="<?php echo $_REQUEST['rulesType'];?>
" >
						<input type="hidden" name="OwnerID" id="OwnerID" class="w100" value="<?php echo $_SESSION['UseDriverID'];?>
" >
						<?php if ($_REQUEST['rulesType'] == 'rutes') {?> <input type="hidden" name="DriverRouteID" id="DriverRouteID" class="w100" value="<?php echo $_REQUEST['item'];?>
" readonly><?php }?>
						<?php if ($_REQUEST['rulesType'] == 'vehicles') {?> <input type="hidden" name="VehicleID" id="VehicleID" class="w100" value="<?php echo $_REQUEST['item'];?>
" readonly><?php }?>
						<?php if ($_REQUEST['rulesType'] == 'services') {?> <input type="hidden" name="ServiceID" id="ServiceID" class="w100" value="<?php echo $_REQUEST['item'];?>
" readonly><?php }?>


				<div class="row alert alert-info">
					<div class="col-md-2">
						<label for="NightStart"><?php echo $_smarty_tpl->tpl_vars['NIGHTSTART']->value;?>
</label>
						<input type="text" name="NightStart" id="NightStart" class="w100 timepicker" value="<?php echo $_smarty_tpl->tpl_vars['NightStart']->value;?>
" >
					</div>
					<div class="col-md-2">
						<label for="NightEnd"><?php echo $_smarty_tpl->tpl_vars['NIGHTEND']->value;?>
</label>
						<input type="text" name="NightEnd" id="NightEnd" class="w100 timepicker" value="<?php echo $_smarty_tpl->tpl_vars['NightEnd']->value;?>
" >
					</div>
					<div class="col-md-2">
						<label for="NightPercent"><?php echo $_smarty_tpl->tpl_vars['NIGHTPERCENT']->value;?>
</label>
						<input type="text" name="NightPercent" id="NightPercent" class="w100" value="<?php echo $_smarty_tpl->tpl_vars['NightPercent']->value;?>
" >
					</div>
					<div class="col-md-2">
						<label for="NightAmount"><?php echo $_smarty_tpl->tpl_vars['NIGHTAMOUNT']->value;?>
</label>
						<input type="text" name="NightAmount" id="NightAmount" class="w100" value="<?php echo $_smarty_tpl->tpl_vars['NightAmount']->value;?>
" >
					</div>
				</div>

				<div class="row alert alert-warning">
					<div class="col-md-2">
						<label for="MonPercent"><?php echo $_smarty_tpl->tpl_vars['MONPERCENT']->value;?>
</label>
						<input type="text" name="MonPercent" id="MonPercent" class="w50" value="<?php echo $_smarty_tpl->tpl_vars['MonPercent']->value;?>
" >
						<label for="MonAmount"><?php echo $_smarty_tpl->tpl_vars['MONAMOUNT']->value;?>
</label>
						<input type="text" name="MonAmount" id="MonAmount" class="w50" value="<?php echo $_smarty_tpl->tpl_vars['MonAmount']->value;?>
" >
					</div>
					<div class="col-md-2">
						<label for="TuePercent"><?php echo $_smarty_tpl->tpl_vars['TUEPERCENT']->value;?>
</label>
						<input type="text" name="TuePercent" id="TuePercent" class="w50" value="<?php echo $_smarty_tpl->tpl_vars['TuePercent']->value;?>
" >
						<label for="TueAmount"><?php echo $_smarty_tpl->tpl_vars['TUEAMOUNT']->value;?>
</label>
						<input type="text" name="TueAmount" id="TueAmount" class="w50" value="<?php echo $_smarty_tpl->tpl_vars['TueAmount']->value;?>
" >
					</div>
					<div class="col-md-2">
						<label for="WedPercent"><?php echo $_smarty_tpl->tpl_vars['WEDPERCENT']->value;?>
</label>
						<input type="text" name="WedPercent" id="WedPercent" class="w50" value="<?php echo $_smarty_tpl->tpl_vars['WedPercent']->value;?>
" >
						<label for="WedAmount"><?php echo $_smarty_tpl->tpl_vars['WEDAMOUNT']->value;?>
</label>
						<input type="text" name="WedAmount" id="WedAmount" class="w50" value="<?php echo $_smarty_tpl->tpl_vars['WedAmount']->value;?>
" >
					</div>
					<div class="col-md-2">
						<label for="ThuPercent"><?php echo $_smarty_tpl->tpl_vars['THUPERCENT']->value;?>
</label>
						<input type="text" name="ThuPercent" id="ThuPercent" class="w50" value="<?php echo $_smarty_tpl->tpl_vars['ThuPercent']->value;?>
" >
						<label for="ThuAmount"><?php echo $_smarty_tpl->tpl_vars['THUAMOUNT']->value;?>
</label>
						<input type="text" name="ThuAmount" id="ThuAmount" class="w50" value="<?php echo $_smarty_tpl->tpl_vars['ThuAmount']->value;?>
" >
					</div>
					<div class="col-md-2">
						<label for="FriPercent"><?php echo $_smarty_tpl->tpl_vars['FRIPERCENT']->value;?>
</label>
						<input type="text" name="FriPercent" id="FriPercent" class="w50" value="<?php echo $_smarty_tpl->tpl_vars['FriPercent']->value;?>
" >
						<label for="FriAmount"><?php echo $_smarty_tpl->tpl_vars['FRIAMOUNT']->value;?>
</label>
						<input type="text" name="FriAmount" id="FriAmount" class="w50" value="<?php echo $_smarty_tpl->tpl_vars['FriAmount']->value;?>
" >
					</div>
					<div class="col-md-2">
						<label for="SatPercent"><?php echo $_smarty_tpl->tpl_vars['SATPERCENT']->value;?>
</label>
						<input type="text" name="SatPercent" id="SatPercent" class="w50" value="<?php echo $_smarty_tpl->tpl_vars['SatPercent']->value;?>
" >
						<label for="SatAmount"><?php echo $_smarty_tpl->tpl_vars['SATAMOUNT']->value;?>
</label>
						<input type="text" name="SatAmount" id="SatAmount" class="w50" value="<?php echo $_smarty_tpl->tpl_vars['SatAmount']->value;?>
" >
					</div>
					<div class="col-md-2">
						<label for="SunPercent"><?php echo $_smarty_tpl->tpl_vars['SUNPERCENT']->value;?>
</label>
						<input type="text" name="SunPercent" id="SunPercent" class="w50" value="<?php echo $_smarty_tpl->tpl_vars['SunPercent']->value;?>
" >
						<label for="SunAmount"><?php echo $_smarty_tpl->tpl_vars['SUNAMOUNT']->value;?>
</label>
						<input type="text" name="SunAmount" id="SunAmount" class="w50" value="<?php echo $_smarty_tpl->tpl_vars['SunAmount']->value;?>
" >
					</div>
				</div>

				<div class="row box box-info alert">
					<div class="col-md-2">
						<label for="S1Start"><?php echo $_smarty_tpl->tpl_vars['S1START']->value;?>
</label>
						<input type="text" name="S1Start" id="S1Start" class="w100 datepicker" value="<?php echo $_smarty_tpl->tpl_vars['S1Start']->value;?>
" >
					</div>
					<div class="col-md-2">
						<label for="S1End"><?php echo $_smarty_tpl->tpl_vars['S1END']->value;?>
</label>
						<input type="text" name="S1End" id="S1End" class="w100 datepicker" value="<?php echo $_smarty_tpl->tpl_vars['S1End']->value;?>
" >
					</div>
					<div class="col-md-1">
						<label for="S1Percent"><?php echo $_smarty_tpl->tpl_vars['S1PERCENT']->value;?>
</label>
						<input type="text" name="S1Percent" id="S1Percent" class="w100" value="<?php echo $_smarty_tpl->tpl_vars['S1Percent']->value;?>
" >
					</div>
					<div class="col-md-1"> 
						&nbsp;
					</div>	-					
					<div class="col-md-2">
						<label for="S2Start"><?php echo $_smarty_tpl->tpl_vars['S2START']->value;?>
</label>
						<input type="text" name="S2Start" id="S2Start" class="w100 datepicker" value="<?php echo $_smarty_tpl->tpl_vars['S2Start']->value;?>
" >
					</div>
					<div class="col-md-2">
						<label for="S2End"><?php echo $_smarty_tpl->tpl_vars['S2END']->value;?>
</label>
						<input type="text" name="S2End" id="S2End" class="w100 datepicker" value="<?php echo $_smarty_tpl->tpl_vars['S2End']->value;?>
" >
					</div>
					<div class="col-md-1">
						<label for="S2Percent"><?php echo $_smarty_tpl->tpl_vars['S2PERCENT']->value;?>
</label>
						<input type="text" name="S2Percent" id="S2Percent" class="w100" value="<?php echo $_smarty_tpl->tpl_vars['S2Percent']->value;?>
" >
					</div>
					<div class="col-md-1"> 
						&nbsp;
					</div>					
				</div>

				<div class="row box box-warning alert">
					<div class="col-md-2">
						<label for="S3Start"><?php echo $_smarty_tpl->tpl_vars['S3START']->value;?>
</label>
						<input type="text" name="S3Start" id="S3Start" class="w100 datepicker" value="<?php echo $_smarty_tpl->tpl_vars['S3Start']->value;?>
" >
					</div>
					<div class="col-md-2">
						<label for="S3End"><?php echo $_smarty_tpl->tpl_vars['S3END']->value;?>
</label>
						<input type="text" name="S3End" id="S3End" class="w100 datepicker" value="<?php echo $_smarty_tpl->tpl_vars['S3End']->value;?>
" >
					</div>
					<div class="col-md-1">
						<label for="S3Percent"><?php echo $_smarty_tpl->tpl_vars['S3PERCENT']->value;?>
</label>
						<input type="text" name="S3Percent" id="S3Percent" class="w100" value="<?php echo $_smarty_tpl->tpl_vars['S3Percent']->value;?>
" >
					</div>
					<div class="col-md-1"> 
						&nbsp;
					</div>						
					<div class="col-md-2">
						<label for="S4Start"><?php echo $_smarty_tpl->tpl_vars['S4START']->value;?>
</label>
						<input type="text" name="S4Start" id="S4Start" class="w100 datepicker" value="<?php echo $_smarty_tpl->tpl_vars['S4Start']->value;?>
" >
					</div>
					<div class="col-md-2">
						<label for="S4End"><?php echo $_smarty_tpl->tpl_vars['S4END']->value;?>
</label>
						<input type="text" name="S4End" id="S4End" class="w100 datepicker" value="<?php echo $_smarty_tpl->tpl_vars['S4End']->value;?>
" >
					</div>
					<div class="col-md-1">
						<label for="S4Percent"><?php echo $_smarty_tpl->tpl_vars['S4PERCENT']->value;?>
</label>
						<input type="text" name="S4Percent" id="S4Percent" class="w100" value="<?php echo $_smarty_tpl->tpl_vars['S4Percent']->value;?>
" >
					</div>
					<div class="col-md-1"> 
						&nbsp;
					</div>						
				</div>
				
				<div class="row box alert">
					<div class="col-md-2">
						<label for="S5Start"><?php echo $_smarty_tpl->tpl_vars['S5START']->value;?>
</label>
						<input type="text" name="S5Start" id="S5Start" class="w100 datepicker" value="<?php echo $_smarty_tpl->tpl_vars['S5Start']->value;?>
" >
					</div>
					<div class="col-md-2">
						<label for="S5End"><?php echo $_smarty_tpl->tpl_vars['S5END']->value;?>
</label>
						<input type="text" name="S5End" id="S5End" class="w100 datepicker" value="<?php echo $_smarty_tpl->tpl_vars['S5End']->value;?>
" >
					</div>
					<div class="col-md-1">
						<label for="S5Percent"><?php echo $_smarty_tpl->tpl_vars['S5PERCENT']->value;?>
</label>
						<input type="text" name="S5Percent" id="S5Percent" class="w100" value="<?php echo $_smarty_tpl->tpl_vars['S5Percent']->value;?>
" >
					</div>
					<div class="col-md-1"> 
						&nbsp;
					</div>	
					<div class="col-md-2">
						<label for="S6Start"><?php echo $_smarty_tpl->tpl_vars['S6START']->value;?>
</label>
						<input type="text" name="S6Start" id="S6Start" class="w100 datepicker" value="<?php echo $_smarty_tpl->tpl_vars['S6Start']->value;?>
" >
					</div>
					<div class="col-md-2">
						<label for="S6End"><?php echo $_smarty_tpl->tpl_vars['S6END']->value;?>
</label>
						<input type="text" name="S6End" id="S6End" class="w100 datepicker" value="<?php echo $_smarty_tpl->tpl_vars['S6End']->value;?>
" >
					</div>
					<div class="col-md-1">
						<label for="S6Percent"><?php echo $_smarty_tpl->tpl_vars['S6PERCENT']->value;?>
</label>
						<input type="text" name="S6Percent" id="S6Percent" class="w100" value="<?php echo $_smarty_tpl->tpl_vars['S6Percent']->value;?>
" >
					</div>
					<div class="col-md-1"> 
						&nbsp;
					</div>						
				</div>
				
				<div class="row box alert">
					<div class="col-md-2">
						<label for="S7Start"><?php echo $_smarty_tpl->tpl_vars['S7START']->value;?>
</label>
						<input type="text" name="S7Start" id="S7Start" class="w100 datepicker" value="<?php echo $_smarty_tpl->tpl_vars['S7Start']->value;?>
" >
					</div>
					<div class="col-md-2">
						<label for="S7End"><?php echo $_smarty_tpl->tpl_vars['S7END']->value;?>
</label>
						<input type="text" name="S7End" id="S7End" class="w100 datepicker" value="<?php echo $_smarty_tpl->tpl_vars['S7End']->value;?>
" >
					</div>
					<div class="col-md-1">
						<label for="S7Percent"><?php echo $_smarty_tpl->tpl_vars['S7PERCENT']->value;?>
</label>
						<input type="text" name="S7Percent" id="S7Percent" class="w100" value="<?php echo $_smarty_tpl->tpl_vars['S7Percent']->value;?>
" >
					</div>
					<div class="col-md-1"> 
						&nbsp;
					</div>	
					<div class="col-md-2">
						<label for="S8Start"><?php echo $_smarty_tpl->tpl_vars['S8START']->value;?>
</label>
						<input type="text" name="S8Start" id="S8Start" class="w100 datepicker" value="<?php echo $_smarty_tpl->tpl_vars['S8Start']->value;?>
" >
					</div>
					<div class="col-md-2">
						<label for="S8End"><?php echo $_smarty_tpl->tpl_vars['S8END']->value;?>
</label>
						<input type="text" name="S8End" id="S8End" class="w100 datepicker" value="<?php echo $_smarty_tpl->tpl_vars['S8End']->value;?>
" >
					</div>
					<div class="col-md-1">
						<label for="S8Percent"><?php echo $_smarty_tpl->tpl_vars['S8PERCENT']->value;?>
</label>
						<input type="text" name="S8Percent" id="S8Percent" class="w100" value="<?php echo $_smarty_tpl->tpl_vars['S8Percent']->value;?>
" >
					</div>
					<div class="col-md-1"> 
						&nbsp;
					</div>						
				</div>
				
				<div class="row box alert">
					<div class="col-md-2">
						<label for="S9Start"><?php echo $_smarty_tpl->tpl_vars['S9START']->value;?>
</label>
						<input type="text" name="S9Start" id="S9Start" class="w100 datepicker" value="<?php echo $_smarty_tpl->tpl_vars['S9Start']->value;?>
" >
					</div>
					<div class="col-md-2">
						<label for="S9End"><?php echo $_smarty_tpl->tpl_vars['S9END']->value;?>
</label>
						<input type="text" name="S9End" id="S9End" class="w100 datepicker" value="<?php echo $_smarty_tpl->tpl_vars['S9End']->value;?>
" >
					</div>
					<div class="col-md-1">
						<label for="S9Percent"><?php echo $_smarty_tpl->tpl_vars['S9PERCENT']->value;?>
</label>
						<input type="text" name="S9Percent" id="S9Percent" class="w100" value="<?php echo $_smarty_tpl->tpl_vars['S9Percent']->value;?>
" >
					</div>
					<div class="col-md-1"> 
						&nbsp;
					</div>	
					<div class="col-md-2">
						<label for="S10Start"><?php echo $_smarty_tpl->tpl_vars['S10START']->value;?>
</label>
						<input type="text" name="S10Start" id="S10Start" class="w100 datepicker" value="<?php echo $_smarty_tpl->tpl_vars['S10Start']->value;?>
" >
					</div>
					<div class="col-md-2">
						<label for="S10End"><?php echo $_smarty_tpl->tpl_vars['S10END']->value;?>
</label>
						<input type="text" name="S10End" id="S10End" class="w100 datepicker" value="<?php echo $_smarty_tpl->tpl_vars['S10End']->value;?>
" >
					</div>
					<div class="col-md-1">
						<label for="S10Percent"><?php echo $_smarty_tpl->tpl_vars['S10PERCENT']->value;?>
</label>
						<input type="text" name="S10Percent" id="S10Percent" class="w100" value="<?php echo $_smarty_tpl->tpl_vars['S10Percent']->value;?>
" >
					</div>
					<div class="col-md-1"> 
						&nbsp;
					</div>						
				</div>					
			</div>
	    </div>
</form>
<?php }
}
