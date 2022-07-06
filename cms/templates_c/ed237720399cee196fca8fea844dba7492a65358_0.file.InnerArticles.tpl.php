<?php
/* Smarty version 3.1.32, created on 2019-10-09 09:44:16
  from '/home/jamtrans/laravel/public/cms.jamtransfer.com/cms/templates/InnerArticles.tpl' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.32',
  'unifunc' => 'content_5d9dabf0cac7b3_68131380',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    'ed237720399cee196fca8fea844dba7492a65358' => 
    array (
      0 => '/home/jamtrans/laravel/public/cms.jamtransfer.com/cms/templates/InnerArticles.tpl',
      1 => 1570088872,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_5d9dabf0cac7b3_68131380 (Smarty_Internal_Template $_smarty_tpl) {
?><!DOCTYPE html>

	<div class="container white">

	<?php
$__section_pom_0_loop = (is_array(@$_loop=$_smarty_tpl->tpl_vars['data']->value) ? count($_loop) : max(0, (int) $_loop));
$__section_pom_0_total = $__section_pom_0_loop;
$_smarty_tpl->tpl_vars['__smarty_section_pom'] = new Smarty_Variable(array());
if ($__section_pom_0_total !== 0) {
for ($__section_pom_0_iteration = 1, $_smarty_tpl->tpl_vars['__smarty_section_pom']->value['index'] = 0; $__section_pom_0_iteration <= $__section_pom_0_total; $__section_pom_0_iteration++, $_smarty_tpl->tpl_vars['__smarty_section_pom']->value['index']++){
?>
		<a  id="header" onclick="show(<?php echo $_smarty_tpl->tpl_vars['data']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_pom']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_pom']->value['index'] : null)]['id'];?>
);">
		
			<div class="row xbox-solid xbg-light-blue  pad1em listTile" 
			style="border-top:1px solid #eee;border-bottom:0px solid #eee">
				<h3><?php echo $_smarty_tpl->tpl_vars['data']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_pom']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_pom']->value['index'] : null)]['header'];?>
</h3>
			</div>
		</a>
		
		<div id="transferWrapper<?php echo $_smarty_tpl->tpl_vars['data']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_pom']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_pom']->value['index'] : null)]['id'];?>
" class="editFrame" style="display:none">
			<div id="inlineContent" class="row ">
				<div  class="xcol-md-12">
					<?php echo $_smarty_tpl->tpl_vars['data']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_pom']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_pom']->value['index'] : null)]['html'];?>

				</div>
			</div>
		</div>

	<?php
}
}
?>			 
    
	
	</div>
	
<?php echo '<script'; ?>
>	
function show(id) {
	id ="#transferWrapper"+id;
	if($(id).css('display') == 'none') $(id).show(500);
	else $(id).hide(500);

}
<?php echo '</script'; ?>
> <?php }
}
