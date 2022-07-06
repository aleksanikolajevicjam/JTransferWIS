<?php
/* Smarty version 3.1.32, created on 2019-10-09 09:52:40
  from '/home/jamtrans/laravel/public/cms.jamtransfer.com/cms/templates/RoutePrices.tpl' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.32',
  'unifunc' => 'content_5d9dade851ed20_57917517',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '41c49d9cac2ad85149a380f2dea4bc90d8198b5b' => 
    array (
      0 => '/home/jamtrans/laravel/public/cms.jamtransfer.com/cms/templates/RoutePrices.tpl',
      1 => 1570088872,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_5d9dade851ed20_57917517 (Smarty_Internal_Template $_smarty_tpl) {
$_smarty_tpl->_checkPlugins(array(0=>array('file'=>'/home/jamtrans/laravel/public/cms.jamtransfer.com/common/libs/plugins/function.html_table_advanced.php','function'=>'smarty_function_html_table_advanced',),));
?>
<div class="table-responsive">
		   <div id="content">
					<?php echo smarty_function_html_table_advanced(array('caption'=>$_smarty_tpl->tpl_vars['caption']->value,'filter'=>$_smarty_tpl->tpl_vars['filter']->value,'cnt_all_rows'=>$_smarty_tpl->tpl_vars['tbl_all_rows_count']->value,'browseString'=>$_smarty_tpl->tpl_vars['tbl_browseString']->value,'cnt_rows'=>$_smarty_tpl->tpl_vars['tbl_row_count']->value,'rowOffset'=>$_smarty_tpl->tpl_vars['tbl_offset']->value,'tr_attr'=>$_smarty_tpl->tpl_vars['tbl_tr_attributes']->value,'td_attr'=>$_smarty_tpl->tpl_vars['tbl_td_attributes']->value,'loop'=>$_smarty_tpl->tpl_vars['tbl_content']->value,'cols'=>$_smarty_tpl->tpl_vars['tbl_cols_count']->value,'tableheader'=>$_smarty_tpl->tpl_vars['tbl_header']->value,'table_attr'=>'cellspacing=0 class="index" id="normal"'),$_smarty_tpl);?>


			</div>
</div>	
    <?php }
}
