<?php
/* Smarty version 3.1.32, created on 2022-07-04 10:08:42
  from 'c:\wamp\www\jamtransfer\plugins\Orders\templates\index.tpl' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.32',
  'unifunc' => 'content_62c2bc2a6694f9_04276800',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '27e0ab1f6053050eab99845097abf46bf67cff77' => 
    array (
      0 => 'c:\\wamp\\www\\jamtransfer\\plugins\\Orders\\templates\\index.tpl',
      1 => 1656929316,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_62c2bc2a6694f9_04276800 (Smarty_Internal_Template $_smarty_tpl) {
$_smarty_tpl->_checkPlugins(array(0=>array('file'=>'C:\\wamp\\www\\jamtransfer\\common\\libs\\plugins\\function.html_table_advanced.php','function'=>'smarty_function_html_table_advanced',),));
?><div class="ibox float-e-margins">
	<div class="ibox-title">
		
		<div class="ibox-tools">
			<a class="collapse-link">
					<i class="fa fa-chevron-up"></i>
			</a>
			<a class="fullscreen-link">
                <i class="fa fa-expand"></i>
            </a>

			<a class="close-link">
				<i class="fa fa-times"></i>
			</a>
		</div>
	</div>
	<div class="ibox-content">
		<div class="table-responsive">
		   <div id="content">
	   
				<?php echo smarty_function_html_table_advanced(array('filter'=>$_smarty_tpl->tpl_vars['filter']->value,'browseString'=>$_smarty_tpl->tpl_vars['tbl_browseString']->value,'scriptName'=>$_smarty_tpl->tpl_vars['scriptName']->value,'cnt_rows'=>$_smarty_tpl->tpl_vars['tbl_row_count']->value,'rowOffset'=>$_smarty_tpl->tpl_vars['tbl_offset']->value,'tr_attr'=>$_smarty_tpl->tpl_vars['tbl_tr_attributes']->value,'td_attr'=>$_smarty_tpl->tpl_vars['tbl_td_attributes']->value,'loop'=>$_smarty_tpl->tpl_vars['tbl_content']->value,'cols'=>$_smarty_tpl->tpl_vars['tbl_cols_count']->value,'tableheader'=>$_smarty_tpl->tpl_vars['tbl_header']->value,'table_attr'=>'cellspacing=0 class="index" id="normal"','message'=>$_smarty_tpl->tpl_vars['poruka']->value),$_smarty_tpl);?>

			</div>
		</div>	
	</div>
</div><?php }
}
