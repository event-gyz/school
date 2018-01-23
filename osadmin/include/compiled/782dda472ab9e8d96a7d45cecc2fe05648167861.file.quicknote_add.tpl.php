<?php /* Smarty version Smarty-3.1.15, created on 2014-10-09 14:45:55
         compiled from "/var/www/kidsdna_store/sunnyschool/osadmin/include/template/panel/quicknote_add.tpl" */ ?>
<?php /*%%SmartyHeaderCode:86010283554362f233fe691-95970888%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '782dda472ab9e8d96a7d45cecc2fe05648167861' => 
    array (
      0 => '/var/www/kidsdna_store/sunnyschool/osadmin/include/template/panel/quicknote_add.tpl',
      1 => 1382249386,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '86010283554362f233fe691-95970888',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'osadmin_action_alert' => 0,
    'osadmin_quick_note' => 0,
    '_POST' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.15',
  'unifunc' => 'content_54362f234301f8_45116635',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_54362f234301f8_45116635')) {function content_54362f234301f8_45116635($_smarty_tpl) {?><?php echo $_smarty_tpl->getSubTemplate ("header.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>

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

				<textarea name="note_content" rows="3" class="input-xlarge" autofocus="true"><?php echo $_smarty_tpl->tpl_vars['_POST']->value['note_content'];?>
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
