<?php /* Smarty version Smarty-3.1.15, created on 2017-12-19 16:37:57
         compiled from "F:\PHPSTUDY\PHPTutorial\WWW\school\osadmin\include\template\index.tpl" */ ?>
<?php /*%%SmartyHeaderCode:321885a37a0e950e597-95726870%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '6220f24a7aeef1c0483144b7a0bdcf9d7b13be62' => 
    array (
      0 => 'F:\\PHPSTUDY\\PHPTutorial\\WWW\\school\\osadmin\\include\\template\\index.tpl',
      1 => 1513672056,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '321885a37a0e950e597-95726870',
  'function' => 
  array (
  ),
  'version' => 'Smarty-3.1.15',
  'unifunc' => 'content_5a37a0e9535782_32973831',
  'variables' => 
  array (
    'osadmin_action_alert' => 0,
    'osadmin_quick_note' => 0,
    'menus' => 0,
    'menu' => 0,
    'user_info' => 0,
  ),
  'has_nocache_code' => false,
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5a37a0e9535782_32973831')) {function content_5a37a0e9535782_32973831($_smarty_tpl) {?><?php echo $_smarty_tpl->getSubTemplate ("header.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>

<?php echo $_smarty_tpl->getSubTemplate ("navibar.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>

<?php echo $_smarty_tpl->getSubTemplate ("sidebar.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>


<!--- START 以上内容不需更改，保证该TPL页内的标签匹配即可 --->

<?php echo $_smarty_tpl->tpl_vars['osadmin_action_alert']->value;?>

<?php echo $_smarty_tpl->tpl_vars['osadmin_quick_note']->value;?>


	<div class="block">
        <a href="#page-menu" class="block-heading" data-toggle="collapse">快捷菜单</a>
        <div id="page-menu" class="block-body collapse in">
		<h3>
		<?php if (count($_smarty_tpl->tpl_vars['menus']->value)>0) {?>
			<?php  $_smarty_tpl->tpl_vars['menu'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['menu']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['menus']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['menu']->key => $_smarty_tpl->tpl_vars['menu']->value) {
$_smarty_tpl->tpl_vars['menu']->_loop = true;
?>
                            <span>
                                    <a href="<?php echo @constant('ADMIN_URL');?>
<?php echo $_smarty_tpl->tpl_vars['menu']->value['menu_url'];?>
">
                                            <?php echo $_smarty_tpl->tpl_vars['menu']->value['menu_name'];?>

                                    </a>
                            </span>&nbsp;
			<?php } ?>
		<?php }?>
		</h3>
		</div> 
    </div>
	
	<div class="block">
        <a href="#page-stats" class="block-heading" data-toggle="collapse">当前用户信息</a>
        <div id="page-stats" class="block-body collapse in">
			
               <table class="table table-striped">  
						     
							 <tr>
						        <td>用户名</td>
						        <td>真实姓名</td>
						        <td>手机号</td>
						        <td>Email</td>
						        <td>登录时间</td>
						        <td>登录IP</td>
					          </tr>
						      <tr>
						        <td><?php echo $_smarty_tpl->tpl_vars['user_info']->value['user_name'];?>
</td>
						        <td><?php echo $_smarty_tpl->tpl_vars['user_info']->value['real_name'];?>
</td>
						        <td><?php echo $_smarty_tpl->tpl_vars['user_info']->value['mobile'];?>
</td>
						        <td><?php echo $_smarty_tpl->tpl_vars['user_info']->value['email'];?>
</td>
						        <td><?php echo $_smarty_tpl->tpl_vars['user_info']->value['login_time'];?>
</td>
						        <td><?php echo $_smarty_tpl->tpl_vars['user_info']->value['login_ip'];?>
</td>
					          </tr>
					        
					      </table>
		</div>
		<div class="alert alert-success">
			<button type="button" class="close" data-dismiss="alert">×</button>
			<strong>注意！</strong>请保管好您的个人信息，一点发生密码泄露请紧急联系管理员。</div>
        </div>
    </div>
	
<!--- END 以下内容不需更改，请保证该TPL页内的标签匹配即可 --->
<?php echo $_smarty_tpl->getSubTemplate ("footer.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>
<?php }} ?>
