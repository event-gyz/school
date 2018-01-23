<?php /* Smarty version Smarty-3.1.15, created on 2017-12-24 16:10:24
         compiled from "F:\PHPSTUDY\PHPTutorial\WWW\school\osadmin\include\template\sunnyschool\ajaxcrud.tpl" */ ?>
<?php /*%%SmartyHeaderCode:260635a37a811e987b9-56439035%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'a33d8c3ce750b6fb9a0c212a125616758592a94f' => 
    array (
      0 => 'F:\\PHPSTUDY\\PHPTutorial\\WWW\\school\\osadmin\\include\\template\\sunnyschool\\ajaxcrud.tpl',
      1 => 1514102866,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '260635a37a811e987b9-56439035',
  'function' => 
  array (
  ),
  'version' => 'Smarty-3.1.15',
  'unifunc' => 'content_5a37a811e987b0_12166265',
  'variables' => 
  array (
    'gi_count' => 0,
    'content' => 0,
  ),
  'has_nocache_code' => false,
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5a37a811e987b0_12166265')) {function content_5a37a811e987b0_12166265($_smarty_tpl) {?><?php echo $_smarty_tpl->getSubTemplate ("header.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>

<?php echo $_smarty_tpl->getSubTemplate ("navibar.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>

<?php echo $_smarty_tpl->getSubTemplate ("sidebar.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>

<!-- TPLSTART 以上内容不需更改，保证该TPL页内的标签匹配即可 -->
<div style="float: left">
总数: <b><?php echo $_smarty_tpl->tpl_vars['gi_count']->value;?>
</b><br />
</div>
<div style="clear:both;"></div>
<?php echo $_smarty_tpl->tpl_vars['content']->value;?>

<!-- TPLEND 以下内容不需更改，请保证该TPL页内的标签匹配即可 -->
<?php echo $_smarty_tpl->getSubTemplate ("footer.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>
<?php }} ?>
