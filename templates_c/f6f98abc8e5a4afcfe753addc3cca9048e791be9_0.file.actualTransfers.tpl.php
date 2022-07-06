<?php
/* Smarty version 3.1.32, created on 2022-06-28 08:55:36
  from 'C:\xampp\htdocs\jamtransfer\plugins\Dashboard\templates\actualTransfers.tpl' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.32',
  'unifunc' => 'content_62baa5e88fcc92_98463014',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    'f6f98abc8e5a4afcfe753addc3cca9048e791be9' => 
    array (
      0 => 'C:\\xampp\\htdocs\\jamtransfer\\plugins\\Dashboard\\templates\\actualTransfers.tpl',
      1 => 1656399308,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_62baa5e88fcc92_98463014 (Smarty_Internal_Template $_smarty_tpl) {
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
            <i class="fa fa-road"></i>
            <h3 class="box-title">Actual transfers <?php echo $_smarty_tpl->tpl_vars['timeStart']->value;?>
 - <?php echo $_smarty_tpl->tpl_vars['timeEnd']->value;?>
 (<?php echo $_smarty_tpl->tpl_vars['today']->value;?>
)</h3>
		</div>	
	<div class="box-body">	
		<?php echo $_smarty_tpl->tpl_vars['data']->value;?>

	</div>
<?php echo '<script'; ?>
>

	$(".mytooltip").popover({trigger:'hover', html:true, placement:'bottom'});

<?php echo '</script'; ?>
><?php }
}
