<?php /* Smarty version Smarty-3.1.15, created on 2014-06-11 00:28:08
         compiled from "/Users/bclin087/Desktop/KidsDNA/Web/webpage/osadmin/include/template/panel/group_modify.tpl" */ ?>
<?php /*%%SmartyHeaderCode:329500005539732189ff3f0-06898436%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'd6aa960cd3025933fb2dd04bfefbd536299bec0c' => 
    array (
      0 => '/Users/bclin087/Desktop/KidsDNA/Web/webpage/osadmin/include/template/panel/group_modify.tpl',
      1 => 1382249386,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '329500005539732189ff3f0-06898436',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'osadmin_action_alert' => 0,
    'osadmin_quick_note' => 0,
    'group' => 0,
    'osadmin_action_confirm' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.15',
  'unifunc' => 'content_53973218a3fa12_70874653',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_53973218a3fa12_70874653')) {function content_53973218a3fa12_70874653($_smarty_tpl) {?><?php echo $_smarty_tpl->getSubTemplate ("header.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>

<?php echo $_smarty_tpl->getSubTemplate ("navibar.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>

<?php echo $_smarty_tpl->getSubTemplate ("sidebar.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>

<!-- START 以上内容不需更改，保证该TPL页内的标签匹配即可 -->
<?php echo $_smarty_tpl->tpl_vars['osadmin_action_alert']->value;?>

<?php echo $_smarty_tpl->tpl_vars['osadmin_quick_note']->value;?>

    
<div class="well">
    <ul class="nav nav-tabs">
      <li class="active"><a href="#home" data-toggle="tab">请填写账号组资料</a></li>
    </ul>	
	
	<div id="myTabContent" class="tab-content">
		  <div class="tab-pane active in" id="home">

           <form id="tab" method="post" action="">
				<label>账号组名称</label>
				<input type="text" name="group_name" value="<?php echo $_smarty_tpl->tpl_vars['group']->value['group_name'];?>
" class="input-xlarge" required="true" autofocus="true" >
				<label>描述</label>
				<textarea name="group_desc" rows="3" class="input-xlarge"><?php echo $_smarty_tpl->tpl_vars['group']->value['group_desc'];?>
</textarea>
				<div class="btn-toolbar">
					<button type="submit" class="btn btn-primary"><strong>提交</strong></button>
				</div>
			</form>
        </div>
    </div>
</div>	
<!---操作的确认层，相当于javascript:confirm函数--->
<?php echo $_smarty_tpl->tpl_vars['osadmin_action_confirm']->value;?>


<!-- END 以下内容不需更改，请保证该TPL页内的标签匹配即可 -->
<?php echo $_smarty_tpl->getSubTemplate ("footer.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>
<?php }} ?>
