<?php /* Smarty version Smarty-3.1.15, created on 2014-10-09 14:46:48
         compiled from "/var/www/kidsdna_store/sunnyschool/osadmin/include/template/panel/quicknote_modify.tpl" */ ?>
<?php /*%%SmartyHeaderCode:12115576754362f586cdbb3-46284645%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '7097b6593e2d9850225f48a55b7eb185ffcb4f66' => 
    array (
      0 => '/var/www/kidsdna_store/sunnyschool/osadmin/include/template/panel/quicknote_modify.tpl',
      1 => 1382249386,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '12115576754362f586cdbb3-46284645',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'osadmin_action_alert' => 0,
    'osadmin_quick_note' => 0,
    'quicknote' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.15',
  'unifunc' => 'content_54362f586fa5f6_25892169',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_54362f586fa5f6_25892169')) {function content_54362f586fa5f6_25892169($_smarty_tpl) {?><?php echo $_smarty_tpl->getSubTemplate ("header.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>

<?php echo $_smarty_tpl->getSubTemplate ("navibar.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>

<?php echo $_smarty_tpl->getSubTemplate ("sidebar.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>

<!-- START 以上内容不需更改，保证该TPL页内的标签匹配即可 -->
<?php echo $_smarty_tpl->tpl_vars['osadmin_action_alert']->value;?>

<?php echo $_smarty_tpl->tpl_vars['osadmin_quick_note']->value;?>

    
<div class="well">
    <ul class="nav nav-tabs">
      <li class="active"><a href="#home" data-toggle="tab">请填写quick note</a></li>
    </ul>	
	
	<div id="myTabContent" class="tab-content">
		  <div class="tab-pane active in" id="home">

           <form id="tab" method="post" action="">
				<label><span class="label label-info">不支持HTML代码</span></label>
				<textarea name="note_content" rows="3" class="input-xlarge" required="true"><?php echo $_smarty_tpl->tpl_vars['quicknote']->value['note_content'];?>
</textarea>
				
				<div class="btn-toolbar">
					<button type="submit" class="btn btn-primary"><strong>提交</strong></button>
				</div>
			</form>
        </div>
    </div>
</div>
	
<!-- END 以下内容不需更改，请保证该TPL页内的标签匹配即可 -->
<?php echo $_smarty_tpl->getSubTemplate ("footer.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>
<?php }} ?>
