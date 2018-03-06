<?php /* Smarty version Smarty-3.1.15, created on 2014-06-11 01:27:20
         compiled from "/Users/bclin087/Desktop/KidsDNA/Web/webpage/osadmin/include/template/sunnyschool/ajaxcrud.tpl" */ ?>
<?php /*%%SmartyHeaderCode:17048674505397388dba05a8-89249412%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'eea7937f3eeaa099fad69ec5199c418981a0e43c' => 
    array (
      0 => '/Users/bclin087/Desktop/KidsDNA/Web/webpage/osadmin/include/template/sunnyschool/ajaxcrud.tpl',
      1 => 1402421239,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '17048674505397388dba05a8-89249412',
  'function' => 
  array (
  ),
  'version' => 'Smarty-3.1.15',
  'unifunc' => 'content_5397388dbaf024_09813385',
  'variables' => 
  array (
    'gi_count' => 0,
    'content' => 0,
  ),
  'has_nocache_code' => false,
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5397388dbaf024_09813385')) {function content_5397388dbaf024_09813385($_smarty_tpl) {?><?php echo $_smarty_tpl->getSubTemplate ("header.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>

<?php echo $_smarty_tpl->getSubTemplate ("navibar.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>

<?php echo $_smarty_tpl->getSubTemplate ("sidebar.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>

<!-- TPLSTART 以上内容不需更改，保证该TPL页内的标签匹配即可 -->
<div style="float: left">
总筆數: <b><?php echo $_smarty_tpl->tpl_vars['gi_count']->value;?>
</b><br />
</div>
<div style="clear:both;"></div>
<?php echo $_smarty_tpl->tpl_vars['content']->value;?>

<!-- TPLEND 以下内容不需更改，请保证该TPL页内的标签匹配即可 -->
<?php echo $_smarty_tpl->getSubTemplate ("footer.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>
<?php }} ?>
