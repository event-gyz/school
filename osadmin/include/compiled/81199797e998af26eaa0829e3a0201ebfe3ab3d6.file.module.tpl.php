<?php /* Smarty version Smarty-3.1.15, created on 2017-12-19 15:58:27
         compiled from "F:\PHPSTUDY\PHPTutorial\WWW\school\osadmin\include\template\panel\module.tpl" */ ?>
<?php /*%%SmartyHeaderCode:173075a37a751975c59-34263040%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '81199797e998af26eaa0829e3a0201ebfe3ab3d6' => 
    array (
      0 => 'F:\\PHPSTUDY\\PHPTutorial\\WWW\\school\\osadmin\\include\\template\\panel\\module.tpl',
      1 => 1513670301,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '173075a37a751975c59-34263040',
  'function' => 
  array (
  ),
  'version' => 'Smarty-3.1.15',
  'unifunc' => 'content_5a37a7519c4019_48726163',
  'variables' => 
  array (
    'osadmin_action_alert' => 0,
    'osadmin_quick_note' => 0,
    'menus' => 0,
    'menu' => 0,
    'module_id' => 0,
    'module_options_list' => 0,
  ),
  'has_nocache_code' => false,
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5a37a7519c4019_48726163')) {function content_5a37a7519c4019_48726163($_smarty_tpl) {?><?php if (!is_callable('smarty_function_html_options')) include 'F:\\PHPSTUDY\\PHPTutorial\\WWW\\school\\osadmin\\include\\config/../../include/lib/Smarty/plugins\\function.html_options.php';
?><?php echo $_smarty_tpl->getSubTemplate ("header.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>

<?php echo $_smarty_tpl->getSubTemplate ("navibar.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>

<?php echo $_smarty_tpl->getSubTemplate ("sidebar.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>

<!-- START 以上内容不需更改，保证该TPL页内的标签匹配即可 -->
<?php echo $_smarty_tpl->tpl_vars['osadmin_action_alert']->value;?>

<?php echo $_smarty_tpl->tpl_vars['osadmin_quick_note']->value;?>

    
<div class="well">
    <ul class="nav nav-tabs">
      <li class="active"><a href="#home" data-toggle="tab">菜单模块链接列表</a></li>
    </ul>	
	
	<div id="myTabContent" class="tab-content">
		  <div class="tab-pane active in" id="home">

           <form id="tab" method="post" action="">
				 <table class="table table-striped">
              <thead>
                <tr>
					<th><input type="checkbox" id="checkAll" >全选</th>
					<th>#</th>
					<th>名称</th>
					<th>URL</th>
					<th>#Module</th>
					<th >菜单</th>
					<th >是否在线</th>
					<th >快捷菜单</th>
					<th>描述</th>
                </tr>
              </thead>
              <tbody>							  
                <?php  $_smarty_tpl->tpl_vars['menu'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['menu']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['menus']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['menu']->key => $_smarty_tpl->tpl_vars['menu']->value) {
$_smarty_tpl->tpl_vars['menu']->_loop = true;
?>
					 
					<tr>
					 
					<td>
					<?php if ($_smarty_tpl->tpl_vars['menu']->value['menu_id']<=100) {?>
					<input type="checkbox" name="menu_ids[]" value="<?php echo $_smarty_tpl->tpl_vars['menu']->value['menu_id'];?>
" disabled>
					<?php } else { ?>
					<input type="checkbox" name="menu_ids[]" value="<?php echo $_smarty_tpl->tpl_vars['menu']->value['menu_id'];?>
" >
					<?php }?>
					</td>
					<td><?php echo $_smarty_tpl->tpl_vars['menu']->value['menu_id'];?>
</td>
					<td><?php echo $_smarty_tpl->tpl_vars['menu']->value['menu_name'];?>
</td>
					<td><?php echo $_smarty_tpl->tpl_vars['menu']->value['menu_url'];?>
</td>
					<td><?php echo $_smarty_tpl->tpl_vars['menu']->value['module_id'];?>
</td>
					<td>
					<?php if ($_smarty_tpl->tpl_vars['menu']->value['is_show']) {?>
						是
					<?php } else { ?>
						否
					<?php }?>
					</td>
					<td>
					<?php if ($_smarty_tpl->tpl_vars['menu']->value['online']) {?>
						在线
					<?php } else { ?>
						已下线
					<?php }?></td>
					<td>
					<?php if ($_smarty_tpl->tpl_vars['menu']->value['shortcut_allowed']) {?>
						允许
					<?php } else { ?>
						不允许
					<?php }?>
					</td>
					<td><?php echo $_smarty_tpl->tpl_vars['menu']->value['menu_desc'];?>
</td>
					</tr>
				<?php } ?>
              </tbody>
            </table> 
			<?php if ($_smarty_tpl->tpl_vars['module_id']->value>0) {?>
			<label>选择菜单模块</label>
				<?php echo smarty_function_html_options(array('name'=>'module','id'=>"DropDownTimezone",'class'=>"input-xlarge",'options'=>$_smarty_tpl->tpl_vars['module_options_list']->value,'selected'=>0),$_smarty_tpl);?>

				<div class="btn-toolbar">
					<button type="submit" class="btn btn-primary"><strong>修改菜单模块</strong></button>
				</div>
			<?php }?>
			</form>
        </div>
    </div>
</div>

<script type="text/javascript">
$("#checkAll").click(function(){
     if($(this).attr("checked")){
		$("input[name='menu_ids[]']").attr("checked",$(this).attr("checked"));
	 }else{
		$("input[name='menu_ids[]']").attr("checked",false);
	 }
});
</script>

<!-- END 以下内容不需更改，请保证该TPL页内的标签匹配即可 -->
<?php echo $_smarty_tpl->getSubTemplate ("footer.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>
<?php }} ?>
