<?php /* Smarty version Smarty-3.1.15, created on 2014-06-11 00:21:55
         compiled from "/Users/bclin087/Desktop/KidsDNA/Web/webpage/osadmin/include/template/footer.tpl" */ ?>
<?php /*%%SmartyHeaderCode:126866573553972c8425ea40-63585291%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'd415c4e4c076d4f2fcc9298b52f04ba238c1afd1' => 
    array (
      0 => '/Users/bclin087/Desktop/KidsDNA/Web/webpage/osadmin/include/template/footer.tpl',
      1 => 1402417311,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '126866573553972c8425ea40-63585291',
  'function' => 
  array (
  ),
  'version' => 'Smarty-3.1.15',
  'unifunc' => 'content_53972c84268a46_74181462',
  'has_nocache_code' => false,
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_53972c84268a46_74181462')) {function content_53972c84268a46_74181462($_smarty_tpl) {?>                    
	
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
