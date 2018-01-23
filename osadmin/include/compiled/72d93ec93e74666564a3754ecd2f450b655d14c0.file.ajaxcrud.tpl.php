<?php /* Smarty version Smarty-3.1.15, created on 2014-09-19 13:36:59
         compiled from "/var/www/kidsdna_store/sunnyschool/osadmin/include/template/sunnyschool/ajaxcrud.tpl" */ ?>
<?php /*%%SmartyHeaderCode:665155815541bc0fb190d12-31103431%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '72d93ec93e74666564a3754ecd2f450b655d14c0' => 
    array (
      0 => '/var/www/kidsdna_store/sunnyschool/osadmin/include/template/sunnyschool/ajaxcrud.tpl',
      1 => 1402421239,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '665155815541bc0fb190d12-31103431',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'gi_count' => 0,
    'content' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.15',
  'unifunc' => 'content_541bc0fb1b0e31_24418553',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_541bc0fb1b0e31_24418553')) {function content_541bc0fb1b0e31_24418553($_smarty_tpl) {?><?php echo $_smarty_tpl->getSubTemplate ("header.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>

<?php echo $_smarty_tpl->getSubTemplate ("navibar.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>

<?php echo $_smarty_tpl->getSubTemplate ("sidebar.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>

<!-- TPLSTART 以上内容不需更改，保证该TPL页内的标签匹配即可 -->
<div style="float: left">
總筆數: <b><?php echo $_smarty_tpl->tpl_vars['gi_count']->value;?>
</b><br />
</div>
<div style="clear:both;"></div>
<?php echo $_smarty_tpl->tpl_vars['content']->value;?>

<!-- TPLEND 以下内容不需更改，请保证该TPL页内的标签匹配即可 -->
<?php echo $_smarty_tpl->getSubTemplate ("footer.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>
<?php }} ?>
