<?php /* Smarty version Smarty-3.1.15, created on 2014-10-22 01:49:25
         compiled from "/var/www/kidsdna_store/sunnyschool/osadmin/include/template/login.tpl" */ ?>
<?php /*%%SmartyHeaderCode:74766967541bbbf8603100-70914283%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '48b4df202fdd7f8f423297be81291262d6ab6ed2' => 
    array (
      0 => '/var/www/kidsdna_store/sunnyschool/osadmin/include/template/login.tpl',
      1 => 1413913757,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '74766967541bbbf8603100-70914283',
  'function' => 
  array (
  ),
  'version' => 'Smarty-3.1.15',
  'unifunc' => 'content_541bbbf863d011_76273106',
  'variables' => 
  array (
    'osadmin_action_alert' => 0,
    '_POST' => 0,
  ),
  'has_nocache_code' => false,
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_541bbbf863d011_76273106')) {function content_541bbbf863d011_76273106($_smarty_tpl) {?><?php echo $_smarty_tpl->getSubTemplate ("simple_header.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>

  <body class="simple_body"> 
  <!--<![endif]-->
    
    <div class="navbar">
        <div class="navbar-inner">
                <ul class="nav pull-right">
                    
                </ul>
                <a class="brand" href="<?php echo @constant('ADMIN_URL');?>
/index.php"><span class="first"></span> <span class="second"><?php echo @constant('COMPANY_NAME');?>
</span></a>
        </div>
    </div>
<div>
<div class="container-fluid">	    
    <div class="row-fluid">	
	
    <div class="dialog">
		<?php echo $_smarty_tpl->tpl_vars['osadmin_action_alert']->value;?>
	
        <div class="block">
            <p class="block-heading">登入</p>
            <div class="block-body">
                <form name="loginForm" method="post" action="">
                    <label>账号</label>
                    <input type="text" class="span12" name="user_name" value="<?php echo $_smarty_tpl->tpl_vars['_POST']->value['user_name'];?>
" required="true" autofocus="true">
                    <label>密码</label>
                    <input type="password" class="span12" name="password" value = "<?php echo $_smarty_tpl->tpl_vars['_POST']->value['password'];?>
" required="true" >
                    
                     <label>验证码</label>
					<input type="text" name="verify_code" class="span4" placeholder="输入验证码" autocomplete="off" required="required">
					<a href="#"><img title="验证码" id="verify_code" src="<?php echo @constant('ADMIN_URL');?>
/panel/verify_code_cn.php" style="vertical-align:top"></a>
				<!--	<div class="clearfix"><input type="checkbox" name="remember" value="remember-me"> 记住我 
					<span class="label label-info">一个月内不用再次登入</span> -->
					<input type="submit" class="btn btn-primary pull-right" name="loginSubmit" value="登入"/></div>
					
                </form>
            </div>
        </div>
        <p class="pull-right" style=""><a href="http://kidsdna.org" target="blank"></a></p>
    </div>
<script type="text/javascript">
$("#verify_code").click(function(){
	var d = new Date()
	var hour = d.getHours(); 
	var minute = d.getMinutes();
	var sec = d.getSeconds();
    $(this).attr("src","<?php echo @constant('ADMIN_URL');?>
/verify_code_cn.php?"+hour+minute+sec);
});
</script>

<?php echo $_smarty_tpl->getSubTemplate ("footer.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>



<?php }} ?>
