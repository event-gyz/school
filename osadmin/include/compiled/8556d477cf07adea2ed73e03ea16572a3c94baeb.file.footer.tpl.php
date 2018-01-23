<?php /* Smarty version Smarty-3.1.15, created on 2014-09-19 13:15:36
         compiled from "/var/www/kidsdna_store/sunnyschool/osadmin/include/template/footer.tpl" */ ?>
<?php /*%%SmartyHeaderCode:1520178186541bbbf867f788-95383073%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '8556d477cf07adea2ed73e03ea16572a3c94baeb' => 
    array (
      0 => '/var/www/kidsdna_store/sunnyschool/osadmin/include/template/footer.tpl',
      1 => 1402417311,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '1520178186541bbbf867f788-95383073',
  'function' => 
  array (
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.15',
  'unifunc' => 'content_541bbbf8687d08_00713974',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_541bbbf8687d08_00713974')) {function content_541bbbf8687d08_00713974($_smarty_tpl) {?>                    
	
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
