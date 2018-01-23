<?php /* Smarty version Smarty-3.1.15, created on 2017-11-12 12:24:44
         compiled from "/www/web/kidsdna/kidsdna_store/sunnyschool/osadmin/include/template/footer.tpl" */ ?>
<?php /*%%SmartyHeaderCode:1290174215a07cd0c1404b8-25469969%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'cad3d4035c98bf9671e00a0c3753190be15588c1' => 
    array (
      0 => '/www/web/kidsdna/kidsdna_store/sunnyschool/osadmin/include/template/footer.tpl',
      1 => 1402417311,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '1290174215a07cd0c1404b8-25469969',
  'function' => 
  array (
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.15',
  'unifunc' => 'content_5a07cd0c142dd7_34843121',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5a07cd0c142dd7_34843121')) {function content_5a07cd0c142dd7_34843121($_smarty_tpl) {?>                    
	
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
