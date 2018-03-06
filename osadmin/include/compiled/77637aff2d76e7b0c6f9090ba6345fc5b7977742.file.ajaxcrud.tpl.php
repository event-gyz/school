<?php /* Smarty version Smarty-3.1.15, created on 2017-11-12 12:25:04
         compiled from "/www/web/kidsdna/kidsdna_store/sunnyschool/osadmin/include/template/sunnyschool/ajaxcrud.tpl" */ ?>
<?php /*%%SmartyHeaderCode:16742272035a07cd205d2ee1-94134041%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '77637aff2d76e7b0c6f9090ba6345fc5b7977742' => 
    array (
      0 => '/www/web/kidsdna/kidsdna_store/sunnyschool/osadmin/include/template/sunnyschool/ajaxcrud.tpl',
      1 => 1402421239,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '16742272035a07cd205d2ee1-94134041',
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
  'unifunc' => 'content_5a07cd205db646_64249244',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5a07cd205db646_64249244')) {function content_5a07cd205db646_64249244($_smarty_tpl) {?><?php echo $_smarty_tpl->getSubTemplate ("header.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>

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
