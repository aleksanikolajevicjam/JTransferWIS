<?php
/* Smarty version 3.1.32, created on 2022-06-08 11:24:02
  from 'C:\wamp\www\jamtransfer\plugins\Dashboard\templates\getUnfinishedPayment.tpl' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.32',
  'unifunc' => 'content_62a06ab279ff70_14527836',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    'e7b221fef6a0ace5f34bb1e1b711a169666c7321' => 
    array (
      0 => 'C:\\wamp\\www\\jamtransfer\\plugins\\Dashboard\\templates\\getUnfinishedPayment.tpl',
      1 => 1654680239,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_62a06ab279ff70_14527836 (Smarty_Internal_Template $_smarty_tpl) {
?>	<style>
		table {
			border: 1px solid black;
		}


		td, th {
			border: 1px solid black;
			text-align: center;
		}	
	</style>
    <div class="box box-info">
        <div class="box-header">
            <i class="fa fa-credit-card"></i>
            <h3 class="box-title">Unfinished online payment</h3>
		</div>	
		<div class="box-body">
	<table><tr><th>number_key</th><th>Name</th><th>Email</th><th>Time</th><th>EUR</th><!--<th>Status</th>!--></tr>
	<?php
$__section_index_0_loop = (is_array(@$_loop=$_smarty_tpl->tpl_vars['payments']->value) ? count($_loop) : max(0, (int) $_loop));
$__section_index_0_total = $__section_index_0_loop;
$_smarty_tpl->tpl_vars['__smarty_section_index'] = new Smarty_Variable(array());
if ($__section_index_0_total !== 0) {
for ($__section_index_0_iteration = 1, $_smarty_tpl->tpl_vars['__smarty_section_index']->value['index'] = 0; $__section_index_0_iteration <= $__section_index_0_total; $__section_index_0_iteration++, $_smarty_tpl->tpl_vars['__smarty_section_index']->value['index']++){
?>
	<tr>
		<td>&shy; <?php echo $_smarty_tpl->tpl_vars['payments']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_index']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_index']->value['index'] : null)]['MOrderKey'];?>
  </td>
		<td>&shy; <?php echo $_smarty_tpl->tpl_vars['payments']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_index']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_index']->value['index'] : null)]['MPaxFirstName'];?>
 <?php echo $_smarty_tpl->tpl_vars['payments']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_index']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_index']->value['index'] : null)]['MPaxLastName'];?>
 </td>
		<td>&shy; <?php echo $_smarty_tpl->tpl_vars['payments']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_index']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_index']->value['index'] : null)]['MPaxEmail'];?>
 </td>
		<td>&shy; <?php echo $_smarty_tpl->tpl_vars['payments']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_index']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_index']->value['index'] : null)]['MOrderDate'];?>
 <?php echo $_smarty_tpl->tpl_vars['payments']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_index']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_index']->value['index'] : null)]['MOrderTime'];?>
 </td>
		<td>&shy; <?php echo $_smarty_tpl->tpl_vars['payments']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_index']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_index']->value['index'] : null)]['MPayNow'];?>
 </td>
		<!--<td>&shy; <?php echo $_smarty_tpl->tpl_vars['payments']->value['MPaymentStatus'];?>
 </td>!-->
	</tr>			
	<?php
}
}
?>
	</table>
		</div>
	</div>	<?php }
}
