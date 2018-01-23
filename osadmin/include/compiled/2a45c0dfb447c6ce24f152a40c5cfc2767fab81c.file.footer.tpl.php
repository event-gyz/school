<?php /* Smarty version Smarty-3.1.15, created on 2017-12-18 19:02:35
         compiled from "F:\PHPSTUDY\PHPTutorial\WWW\school\osadmin\include\template\footer.tpl" */ ?>
<?php /*%%SmartyHeaderCode:138955a37a04ba727d2-97479657%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '2a45c0dfb447c6ce24f152a40c5cfc2767fab81c' => 
    array (
      0 => 'F:\\PHPSTUDY\\PHPTutorial\\WWW\\school\\osadmin\\include\\template\\footer.tpl',
      1 => 1402417311,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '138955a37a04ba727d2-97479657',
  'function' => 
  array (
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.15',
  'unifunc' => 'content_5a37a04ba727d8_16783514',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5a37a04ba727d8_16783514')) {function content_5a37a04ba727d8_16783514($_smarty_tpl) {?>                    
	
					<footer>
                        <hr>
                        <p>&copy; 2014 <a href="http://www.kidsdna.org" target="_blank">KidDNA Inc.</a></p>
                    </footer>
				</div>
			</div>
		</div>
    <script src="<?php echo @constant('ADMIN_URL');?>
/assets/lib/bootstrap/js/bootstrap.js"></script>
	
<!--- + -快捷方式的提示 --->
	
<script type="text/javascript">	
	
alertDismiss("alert-success",3);
alertDismiss("alert-info",10);
	
listenShortCut("icon-plus");
listenShortCut("icon-minus");
doSidebar();
</script>
  </body>
</html><?php }} ?>
