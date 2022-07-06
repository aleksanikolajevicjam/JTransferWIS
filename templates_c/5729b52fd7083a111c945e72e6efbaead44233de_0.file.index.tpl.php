<?php
/* Smarty version 3.1.32, created on 2022-07-05 10:56:52
  from 'C:\xampp\htdocs\jamtransfer\plugins\BookingAdmin\templates\index.tpl' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.32',
  'unifunc' => 'content_62c3fcd4471e87_79783977',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '5729b52fd7083a111c945e72e6efbaead44233de' => 
    array (
      0 => 'C:\\xampp\\htdocs\\jamtransfer\\plugins\\BookingAdmin\\templates\\index.tpl',
      1 => 1657011222,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_62c3fcd4471e87_79783977 (Smarty_Internal_Template $_smarty_tpl) {
?><div
  style="
    background: transparent url('./i/header/112.jpg') center fixed;
    background-size: cover;
    margin-top: -20px !important;
  "
>
  <br />
  <div
    class="container pad1em"
    style="
      background-color: rgba(70, 79, 96, 0.75);
      border: 1px solid #000;
      border-radius: 6px;
    "
  >
    <div class="row">
      <div class="col s12 xucase center white-text">
        <h3>ADMINISTRATION <?php echo $_smarty_tpl->tpl_vars['BOOKING']->value;?>
</h3>
        <p class="divider clearfix"></p>
      </div>
      <div class="col s12 xgrey xlighten-3">
        <br />
        <form
          action=""
          id="bookingForm"
          name="bookingForm"
          method="POST"
          enctype="multipart/form-data"
          onsubmit="return validateBookingForm();"
        >
    <input type="hidden" id="pleaseSelect" value="<?php echo $_smarty_tpl->tpl_vars['PLEASE_SELECT']->value;?>
">
    <input type="hidden" id="loading" value="<?php echo $_smarty_tpl->tpl_vars['LOADING']->value;?>
">
    <div class="col l6 s12">
        <label for="AuthUserIDe"><i class="fa fa-globe"></i>Book as <strong>Agent</strong></label><br>
        <div>
            <select name="AgentID" id="AgentID" class="xchosen-select browser-default" value='<?php echo $_smarty_tpl->tpl_vars['AgentID']->value;?>
'>
                <option value="0"> --- </option>
                <?php
$__section_index_0_loop = (is_array(@$_loop=$_smarty_tpl->tpl_vars['agents']->value) ? count($_loop) : max(0, (int) $_loop));
$__section_index_0_total = $__section_index_0_loop;
$_smarty_tpl->tpl_vars['__smarty_section_index'] = new Smarty_Variable(array());
if ($__section_index_0_total !== 0) {
for ($__section_index_0_iteration = 1, $_smarty_tpl->tpl_vars['__smarty_section_index']->value['index'] = 0; $__section_index_0_iteration <= $__section_index_0_total; $__section_index_0_iteration++, $_smarty_tpl->tpl_vars['__smarty_section_index']->value['index']++){
?>
                        <option value="<?php echo $_smarty_tpl->tpl_vars['agents']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_index']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_index']->value['index'] : null)]['AuthUserID'];?>
"><?php echo $_smarty_tpl->tpl_vars['agents']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_index']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_index']->value['index'] : null)]['AuthUserCompany'];?>
</option>
                <?php
}
}
?>
            </select>
        </div>
    </div>
    </form>
      </div>
    </div>
  </div>
</div>
<?php }
}
