<?php
/* Smarty version 3.1.32, created on 2022-06-07 07:08:13
  from 'C:\wamp\www\jamtransfer\plugins\Dashboard\templates\index.tpl' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.32',
  'unifunc' => 'content_629ef95d329966_86133204',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    'ddb67b082158075505a379af233d3a56934c5839' => 
    array (
      0 => 'C:\\wamp\\www\\jamtransfer\\plugins\\Dashboard\\templates\\index.tpl',
      1 => 1654585321,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
    'file:emptyRow.tpl' => 1,
  ),
),false)) {
function content_629ef95d329966_86133204 (Smarty_Internal_Template $_smarty_tpl) {
?>
					smallBoxes
					<?php $_smarty_tpl->_subTemplateRender("file:emptyRow.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, false);
?> 			

					<div class="row">
						<section class="col-lg-6 xconnectedSortable"> 
							getOrder
						</section><!-- /.Left col -->
						<section class="col-lg-6 xconnectedSortable"> 
							getUnfinishedPayment
						</section>
					</div>	
                    <div class="row">
                        <section class="col-lg-6 xconnectedSortable"> 
							actualTransfers
                        </section>
                        <section class="col-lg-6 xconnectedSortable">
							quickEmail
                        </section>
                    </div>		
                    <div class="row">
                        <section class="col-lg-6 xconnectedSortable"> 
							todo
                        </section>
                        <section class="col-lg-6 xconnectedSortable">
                        </section>
                    </div>	        
<?php }
}
