<?php /* Smarty version Smarty-3.1.15, created on 2014-06-11 00:44:30
         compiled from "/Users/bclin087/Desktop/KidsDNA/Web/webpage/osadmin/include/template/panel/module_modify.tpl" */ ?>
<?php /*%%SmartyHeaderCode:1854581019539735ee7fbce6-39598972%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '1a8533156cc7c0af42ef108f364c7747f34969f6' => 
    array (
      0 => '/Users/bclin087/Desktop/KidsDNA/Web/webpage/osadmin/include/template/panel/module_modify.tpl',
      1 => 1400740992,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '1854581019539735ee7fbce6-39598972',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'osadmin_action_alert' => 0,
    'osadmin_quick_note' => 0,
    'module' => 0,
    'module_online_optioins' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.15',
  'unifunc' => 'content_539735ee85df17_68457021',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_539735ee85df17_68457021')) {function content_539735ee85df17_68457021($_smarty_tpl) {?><?php if (!is_callable('smarty_function_html_options')) include '/Users/bclin087/Desktop/KidsDNA/Web/webpage/osadmin/include/config/../../include/lib/Smarty/plugins/function.html_options.php';
?><?php echo $_smarty_tpl->getSubTemplate ("header.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>

<?php echo $_smarty_tpl->getSubTemplate ("navibar.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>

<?php echo $_smarty_tpl->getSubTemplate ("sidebar.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>

<!-- START 以上内容不需更改，保证该TPL页内的标签匹配即可 -->

<?php echo $_smarty_tpl->tpl_vars['osadmin_action_alert']->value;?>

<?php echo $_smarty_tpl->tpl_vars['osadmin_quick_note']->value;?>

<div class="well">
    <ul class="nav nav-tabs">
      <li class="active"><a href="#home" data-toggle="tab">请填写菜单模块资料</a></li>
    </ul>	
	
	<div id="myTabContent" class="tab-content">
		  <div class="tab-pane active in" id="home">

           <form id="tab" method="post" action="">
				<label>模块名称</label>
				<input type="text" name="module_name" value="<?php echo $_smarty_tpl->tpl_vars['module']->value['module_name'];?>
" class="input-xlarge" required="true" autofocus="true">
				<label>模块链接</label>
				<input type="text" name="module_url" value="<?php echo $_smarty_tpl->tpl_vars['module']->value['module_url'];?>
" class="input-xlarge" required="true">
				<label>模块图标</label>
				<div style="width:20px;padding-bottom:5px">
					<a class="icon" style="width:20px;line-height:2em;">
					<i id="icon_preview" class="<?php echo $_smarty_tpl->tpl_vars['module']->value['module_icon'];?>
"></i></a>
				</div>
				<input type="text" readonly value="<?php echo $_smarty_tpl->tpl_vars['module']->value['module_icon'];?>
" name="module_icon" id="icon_id" style="width:180px" >
				<a id="icon_select" class="btn btn-info" style="vertical-align:top" >更改图标</a>
				<!--- 选择图标层--->			
				<?php echo $_smarty_tpl->getSubTemplate ("panel/icon_select.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>

				<!--- 选择图标层 结束--->
				
				<label>模块排序数字(数字越小越靠前)</label>
				<input type="text" name="module_sort" value="<?php echo $_smarty_tpl->tpl_vars['module']->value['module_sort'];?>
" class="input-xlarge" >
				<label>是否有效</label>
				<?php if ($_smarty_tpl->tpl_vars['module']->value['module_id']==1) {?>
				<?php echo smarty_function_html_options(array('name'=>'online','id'=>"DropDownTimezone",'class'=>"input-xlarge",'options'=>$_smarty_tpl->tpl_vars['module_online_optioins']->value,'disabled'=>"true",'selected'=>$_smarty_tpl->tpl_vars['module']->value['online']),$_smarty_tpl);?>

				<?php } else { ?>
				<?php echo smarty_function_html_options(array('name'=>'online','id'=>"DropDownTimezone",'class'=>"input-xlarge",'options'=>$_smarty_tpl->tpl_vars['module_online_optioins']->value,'selected'=>$_smarty_tpl->tpl_vars['module']->value['online']),$_smarty_tpl);?>

				<?php }?>
				<label>描述</label>
				<textarea name="module_desc" rows="3" class="input-xlarge"><?php echo $_smarty_tpl->tpl_vars['module']->value['module_desc'];?>
</textarea>
				<div class="btn-toolbar">
					<button type="submit" class="btn btn-primary"><strong>提交</strong></button>
				</div>
			</form>
        </div>
    </div>
</div>
<script>
$('#icon_select').click(function(){			
	$('#myModal').modal({
		backdrop:true,
		keyboard:true,
		show:true
    });	
});

$('.icon').click(function(){
		var obj=$(this);
		$('#icon_preview').removeClass().addClass(obj.text());
		$('#icon_id').val(obj.text());
		$('#myModal').modal('toggle');
});
</script>
<!-- END 以下内容不需更改，请保证该TPL页内的标签匹配即可 -->
<?php echo $_smarty_tpl->getSubTemplate ("footer.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>
<?php }} ?>
