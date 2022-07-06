<?php
/* Smarty version 3.1.32, created on 2022-01-27 13:44:21
  from 'C:\wamp\www\jamtransfer\plugins\Calendar\templates\monthtransfers.tpl' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.32',
  'unifunc' => 'content_61f2a1b5ba4bf0_03201738',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '5ebc09ea4b1f0ee21360208ea0b6ee557773e62c' => 
    array (
      0 => 'C:\\wamp\\www\\jamtransfer\\plugins\\Calendar\\templates\\monthtransfers.tpl',
      1 => 1643291059,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_61f2a1b5ba4bf0_03201738 (Smarty_Internal_Template $_smarty_tpl) {
?><table width="99%" style="border:none;">
	<tr>
		<td align="center">
			<table id="calendarTable" width="100%" border="0" cellpadding="0" cellspacing="0"  class="table">
				<thead>
					<th style="width:14%; background:#FDB5B5"><strong><?php echo $_smarty_tpl->tpl_vars['dayNames']->value[0];?>
</strong></th>
					<th style="width:14%; background:#f2f2f2"><strong><?php echo $_smarty_tpl->tpl_vars['dayNames']->value[1];?>
</strong></th>
					<th style="width:14%; background:#f2f2f2"><strong><?php echo $_smarty_tpl->tpl_vars['dayNames']->value[2];?>
</strong></th>
					<th style="width:14%; background:#f2f2f2"><strong><?php echo $_smarty_tpl->tpl_vars['dayNames']->value[3];?>
</strong></th>
					<th style="width:14%; background:#f2f2f2"><strong><?php echo $_smarty_tpl->tpl_vars['dayNames']->value[4];?>
</strong></th>
					<th style="width:14%; background:#f2f2f2"><strong><?php echo $_smarty_tpl->tpl_vars['dayNames']->value[5];?>
</strong></th>
					<th style="width:14%; background:#ABF1A6"><strong><?php echo $_smarty_tpl->tpl_vars['dayNames']->value[6];?>
</strong></th>
				</thead>
				<?php
$__section_pom_0_loop = (is_array(@$_loop=$_smarty_tpl->tpl_vars['month_transfers']->value) ? count($_loop) : max(0, (int) $_loop));
$__section_pom_0_total = $__section_pom_0_loop;
$_smarty_tpl->tpl_vars['__smarty_section_pom'] = new Smarty_Variable(array());
if ($__section_pom_0_total !== 0) {
for ($__section_pom_0_iteration = 1, $_smarty_tpl->tpl_vars['__smarty_section_pom']->value['index'] = 0; $__section_pom_0_iteration <= $__section_pom_0_total; $__section_pom_0_iteration++, $_smarty_tpl->tpl_vars['__smarty_section_pom']->value['index']++){
?>
					<?php if ($_smarty_tpl->tpl_vars['month_transfers']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_pom']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_pom']->value['index'] : null)]['dayofweek'] == '0') {?> <tr><?php }?>
					<?php if ($_smarty_tpl->tpl_vars['month_transfers']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_pom']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_pom']->value['index'] : null)]['dayofweek'] == '-1') {?> <td></td>
					<?php } else { ?>
						<td valign="top" class="cal_cell" <?php echo $_smarty_tpl->tpl_vars['style']->value;?>
><div class="cal_days l"><b><?php echo $_smarty_tpl->tpl_vars['month_transfers']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_pom']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_pom']->value['index'] : null)]['nom'];?>

							</b></div><br /><small>
							<?php
$__section_pom2_1_loop = (is_array(@$_loop=$_smarty_tpl->tpl_vars['month_transfers']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_pom']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_pom']->value['index'] : null)]['transfers']) ? count($_loop) : max(0, (int) $_loop));
$__section_pom2_1_total = $__section_pom2_1_loop;
$_smarty_tpl->tpl_vars['__smarty_section_pom2'] = new Smarty_Variable(array());
if ($__section_pom2_1_total !== 0) {
for ($__section_pom2_1_iteration = 1, $_smarty_tpl->tpl_vars['__smarty_section_pom2']->value['index'] = 0; $__section_pom2_1_iteration <= $__section_pom2_1_total; $__section_pom2_1_iteration++, $_smarty_tpl->tpl_vars['__smarty_section_pom2']->value['index']++){
?>
								<?php if ($_smarty_tpl->tpl_vars['month_transfers']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_pom']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_pom']->value['index'] : null)]['transfers'][(isset($_smarty_tpl->tpl_vars['__smarty_section_pom2']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_pom2']->value['index'] : null)]['TransferStatus'] == '1') {?> <span class="text-blue"><i class="fa fa-circle-o"></i></span>
								<?php } elseif ($_smarty_tpl->tpl_vars['month_transfers']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_pom']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_pom']->value['index'] : null)]['transfers'][(isset($_smarty_tpl->tpl_vars['__smarty_section_pom2']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_pom2']->value['index'] : null)]['TransferStatus'] == '2') {?> <span class="text-orange"><i class="fa fa-circle-o"></i></span>
								<?php } elseif ($_smarty_tpl->tpl_vars['month_transfers']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_pom']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_pom']->value['index'] : null)]['transfers'][(isset($_smarty_tpl->tpl_vars['__smarty_section_pom2']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_pom2']->value['index'] : null)]['TransferStatus'] == '3') {?> <span style="color: #c00"><i class="fa fa-times-circle"></i></span>
								<?php } elseif ($_smarty_tpl->tpl_vars['month_transfers']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_pom']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_pom']->value['index'] : null)]['transfers'][(isset($_smarty_tpl->tpl_vars['__smarty_section_pom2']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_pom2']->value['index'] : null)]['TransferStatus'] == '4') {?> <span class="text-orange"><i class="fa fa-question-circle"></i></span>
								<?php } elseif ($_smarty_tpl->tpl_vars['month_transfers']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_pom']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_pom']->value['index'] : null)]['transfers'][(isset($_smarty_tpl->tpl_vars['__smarty_section_pom2']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_pom2']->value['index'] : null)]['TransferStatus'] == '5') {?> <span class="text-green"><i class="fa fa-check-circle"></i></span>
								<?php } else { ?> <span style="color: #c00"><i class="fa fa-question"></i></span> <?php }?>
							
								<?php if ($_smarty_tpl->tpl_vars['month_transfers']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_pom']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_pom']->value['index'] : null)]['transfers'][(isset($_smarty_tpl->tpl_vars['__smarty_section_pom2']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_pom2']->value['index'] : null)]['DriverConfStatus'] == '1') {?> <span style="color:#c00"><i class="fa fa-car"></i></span>
								<?php } elseif ($_smarty_tpl->tpl_vars['month_transfers']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_pom']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_pom']->value['index'] : null)]['transfers'][(isset($_smarty_tpl->tpl_vars['__smarty_section_pom2']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_pom2']->value['index'] : null)]['DriverConfStatus'] == '2') {?> <span class="text-orange"><i class="fa fa-info-circle"></i></span>
								<?php } elseif ($_smarty_tpl->tpl_vars['month_transfers']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_pom']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_pom']->value['index'] : null)]['transfers'][(isset($_smarty_tpl->tpl_vars['__smarty_section_pom2']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_pom2']->value['index'] : null)]['DriverConfStatus'] == '3') {?> <span class="text-blue"><i class="fa fa-car"></i></span>
								<?php } elseif ($_smarty_tpl->tpl_vars['month_transfers']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_pom']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_pom']->value['index'] : null)]['transfers'][(isset($_smarty_tpl->tpl_vars['__smarty_section_pom2']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_pom2']->value['index'] : null)]['DriverConfStatus'] == '4') {?> <span style="color:#c00"><i class="fa fa-thumbs-down"></i></span>
								<?php } elseif ($_smarty_tpl->tpl_vars['month_transfers']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_pom']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_pom']->value['index'] : null)]['transfers'][(isset($_smarty_tpl->tpl_vars['__smarty_section_pom2']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_pom2']->value['index'] : null)]['DriverConfStatus'] == '5') {?> <span style="color:#c00"><i class="fa fa-user-times"></i></span>
								<?php } elseif ($_smarty_tpl->tpl_vars['month_transfers']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_pom']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_pom']->value['index'] : null)]['transfers'][(isset($_smarty_tpl->tpl_vars['__smarty_section_pom2']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_pom2']->value['index'] : null)]['DriverConfStatus'] == '6') {?> <span style="color:#c00"><i class="fa fa-black-tie"></i></span>
								<?php } elseif ($_smarty_tpl->tpl_vars['month_transfers']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_pom']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_pom']->value['index'] : null)]['transfers'][(isset($_smarty_tpl->tpl_vars['__smarty_section_pom2']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_pom2']->value['index'] : null)]['DriverConfStatus'] == '7') {?> <span class="text-green"><i class="fa fa-check-square"></i></span>
								<?php } else {
}?>
								
								<?php echo $_smarty_tpl->tpl_vars['month_transfers']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_pom']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_pom']->value['index'] : null)]['transfers'][(isset($_smarty_tpl->tpl_vars['__smarty_section_pom2']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_pom2']->value['index'] : null)]['PickupTime'];?>
&rarr;
								<a href="editActiveTransfer/<?php echo $_smarty_tpl->tpl_vars['month_transfers']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_pom']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_pom']->value['index'] : null)]['transfers'][(isset($_smarty_tpl->tpl_vars['__smarty_section_pom2']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_pom2']->value['index'] : null)]['DetailsID'];?>
"
								title="<b><?php echo $_smarty_tpl->tpl_vars['month_transfers']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_pom']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_pom']->value['index'] : null)]['transfers'][(isset($_smarty_tpl->tpl_vars['__smarty_section_pom2']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_pom2']->value['index'] : null)]['OrderID'];?>
-<?php echo $_smarty_tpl->tpl_vars['month_transfers']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_pom']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_pom']->value['index'] : null)]['transfers'][(isset($_smarty_tpl->tpl_vars['__smarty_section_pom2']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_pom2']->value['index'] : null)]['TNo'];?>
 - <?php echo $_smarty_tpl->tpl_vars['month_transfers']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_pom']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_pom']->value['index'] : null)]['transfers'][(isset($_smarty_tpl->tpl_vars['__smarty_section_pom2']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_pom2']->value['index'] : null)]['PaxName'];?>
 </b>" 
								data-content="
									<br/><?php echo $_smarty_tpl->tpl_vars['FLIGHT_NO']->value;?>
: <?php echo $_smarty_tpl->tpl_vars['month_transfers']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_pom']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_pom']->value['index'] : null)]['transfers'][(isset($_smarty_tpl->tpl_vars['__smarty_section_pom2']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_pom2']->value['index'] : null)]['FlightNo'];?>

									<br><?php echo $_smarty_tpl->tpl_vars['FLIGHT_TIME']->value;?>
: <?php echo $_smarty_tpl->tpl_vars['month_transfers']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_pom']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_pom']->value['index'] : null)]['transfers'][(isset($_smarty_tpl->tpl_vars['__smarty_section_pom2']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_pom2']->value['index'] : null)]['FlightTime'];?>

									<br/><?php echo $_smarty_tpl->tpl_vars['FROM']->value;?>
: <?php echo $_smarty_tpl->tpl_vars['month_transfers']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_pom']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_pom']->value['index'] : null)]['transfers'][(isset($_smarty_tpl->tpl_vars['__smarty_section_pom2']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_pom2']->value['index'] : null)]['PickupName'];?>

									<br/><?php echo $_smarty_tpl->tpl_vars['TO']->value;?>
: <?php echo $_smarty_tpl->tpl_vars['month_transfers']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_pom']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_pom']->value['index'] : null)]['transfers'][(isset($_smarty_tpl->tpl_vars['__smarty_section_pom2']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_pom2']->value['index'] : null)]['DropName'];?>

									<br/><?php echo $_smarty_tpl->tpl_vars['DRIVER']->value;?>
: <?php echo $_smarty_tpl->tpl_vars['month_transfers']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_pom']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_pom']->value['index'] : null)]['transfers'][(isset($_smarty_tpl->tpl_vars['__smarty_section_pom2']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_pom2']->value['index'] : null)]['DriverName'];?>

									<br/><?php echo $_smarty_tpl->tpl_vars['TRANSFER_STATUS']->value;?>
: <?php ob_start();
echo $_smarty_tpl->tpl_vars['month_transfers']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_pom']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_pom']->value['index'] : null)]['transfers'][(isset($_smarty_tpl->tpl_vars['__smarty_section_pom2']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_pom2']->value['index'] : null)]['TransferStatus'];
$_prefixVariable1 = ob_get_clean();
echo $_smarty_tpl->tpl_vars['StatusDescription']->value[$_prefixVariable1];?>

									<br/><?php ob_start();
echo $_smarty_tpl->tpl_vars['month_transfers']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_pom']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_pom']->value['index'] : null)]['transfers'][(isset($_smarty_tpl->tpl_vars['__smarty_section_pom2']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_pom2']->value['index'] : null)]['DriverConfStatus'];
$_prefixVariable2 = ob_get_clean();
echo $_smarty_tpl->tpl_vars['DriverConfStatus']->value[$_prefixVariable2];?>

								" 
								class="mytooltip">
									<?php echo $_smarty_tpl->tpl_vars['month_transfers']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_pom']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_pom']->value['index'] : null)]['transfers'][(isset($_smarty_tpl->tpl_vars['__smarty_section_pom2']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_pom2']->value['index'] : null)]['OrderID'];?>
-<?php echo $_smarty_tpl->tpl_vars['month_transfers']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_pom']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_pom']->value['index'] : null)]['transfers'][(isset($_smarty_tpl->tpl_vars['__smarty_section_pom2']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_pom2']->value['index'] : null)]['TNo'];?>

								</a><br/>
							<?php
}
}
?>
							<br><small style="font-size:14px">No of transfers: <?php echo $_smarty_tpl->tpl_vars['month_transfers']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_pom']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_pom']->value['index'] : null)]['noOfTransfers'];?>
</small>
							</small></td>
					<?php }?>
					<?php if ($_smarty_tpl->tpl_vars['month_transfers']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_pom']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_pom']->value['index'] : null)]['dayofweek'] == '6') {?> </tr> <?php }?>
				<?php
}
}
?>
			</table>
		</td>
	</tr>
</table>
<div class="dashboard-legend">
	Transfer status:
	<ul>
		<i class="fa fa-circle-o text-blue"></i> Active |
		<i class="fa fa-circle-o text-orange"></i> Changed |
		<i class="fa fa-question-circle text-orange"></i> Temp |
		<i class="fa fa-times-circle" style="color:#c00"></i> Cancelled |
		<i class="fa fa-check-circle text-green"></i> Completed<br>
	</ul><br>
	Driver confirmation status:
	<ul>
		<i class="fa fa-car" style="color:#c00"></i> No driver |
		<i class="fa fa-info-circle text-orange"></i> Not Confirmed |
		<i class="fa fa-thumbs-up text-blue"></i> Confirmed |
		<i class="fa fa-car text-blue"></i> Ready |
		<i class="fa fa-thumbs-down" style="color:#c00"></i> Declined |
		<i class="fa fa-user-times" style="color:#c00"></i> No-show |
		<i class="fa fa-black-tie" style="color:#c00"></i> Driver error |
		<i class="fa fa-check-square text-green"></i> Completed
	</ul>
</div>

<?php echo '<script'; ?>
>

	$(".mytooltip").popover({trigger:'hover', html:true, placement:'bottom'});
	
<?php echo '</script'; ?>
><?php }
}
