<?php /* Smarty version Smarty-3.1.15, created on 2014-09-16 12:59:42
         compiled from "/Users/bclin087/Desktop/KidsDNA/Web/webpage/osadmin/include/template/sunnyschool/editRec.tpl" */ ?>
<?php /*%%SmartyHeaderCode:104473822253f5bf1ba7a042-47329419%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '90c7fea0d0ca55f6bffdd6ffc6b01364f0d599d4' => 
    array (
      0 => '/Users/bclin087/Desktop/KidsDNA/Web/webpage/osadmin/include/template/sunnyschool/editRec.tpl',
      1 => 1408634218,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '104473822253f5bf1ba7a042-47329419',
  'function' => 
  array (
  ),
  'version' => 'Smarty-3.1.15',
  'unifunc' => 'content_53f5bf1baa9526_88701557',
  'variables' => 
  array (
    'total' => 0,
    'uid' => 0,
    'title' => 0,
    'description' => 0,
    'tag_options_val' => 0,
    'tag_options_name' => 0,
    'tag_selected_val' => 0,
    'pub_date' => 0,
    'list' => 0,
    'page_indexes' => 0,
  ),
  'has_nocache_code' => false,
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_53f5bf1baa9526_88701557')) {function content_53f5bf1baa9526_88701557($_smarty_tpl) {?><?php if (!is_callable('smarty_function_html_options')) include '/Users/bclin087/Desktop/KidsDNA/Web/webpage/osadmin/include/config/../../include/lib/Smarty/plugins/function.html_options.php';
?><?php echo $_smarty_tpl->getSubTemplate ("header.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>

<?php echo $_smarty_tpl->getSubTemplate ("navibar.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>

<?php echo $_smarty_tpl->getSubTemplate ("sidebar.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>

<!-- TPLSTART 以上内容不需更改，保证该TPL页内的标签匹配即可 -->
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>SunnySchool Text Editor</title>
<link href="ckeditor/_samples/sample.css" rel="stylesheet" type="text/css"/>
</head>
<body>
總筆數: <b><?php echo $_smarty_tpl->tpl_vars['total']->value;?>
</b>
<p></p>
<p><input type="button" name="new_button" value="新增">
</p>
<div id="edit_area" style="display:none">
<hr/>
<form id="content_form" action="submit_article.php" method="post"> 
<input type="hidden" name="uid" value="<?php echo $_smarty_tpl->tpl_vars['uid']->value;?>
">
<input type="hidden" name="type" value="REC">
標題：<input type="text" name="title" value="<?php echo $_smarty_tpl->tpl_vars['title']->value;?>
">
簡述：<input type="text" name="description" size="100" value="<?php echo $_smarty_tpl->tpl_vars['description']->value;?>
"><br>
分類：<select name="tag">
<?php echo smarty_function_html_options(array('values'=>$_smarty_tpl->tpl_vars['tag_options_val']->value,'output'=>$_smarty_tpl->tpl_vars['tag_options_name']->value,'selected'=>$_smarty_tpl->tpl_vars['tag_selected_val']->value,'seperator'=>'<br/>'),$_smarty_tpl);?>

</select>
日期：<input type="text" id="pub_date" name="pub_date" value="<?php echo $_smarty_tpl->tpl_vars['pub_date']->value;?>
" readonly>
<textarea cols="80" id="editor1" name="editor1" rows="10" ></textarea>
<!--<textarea cols="80" id="content" name="content" rows="10" ></textarea><br>-->
<input type="submit" name="submit" value="送出">
<input type="button" id="cancel_button" value="取消">
</form>
<hr/>
</div>

<div id="list_area">
<?php echo $_smarty_tpl->tpl_vars['list']->value;?>

<br>
<?php echo $_smarty_tpl->tpl_vars['page_indexes']->value;?>

</div>
</body>
<!-- TPLEND 以下内容不需更改，请保证该TPL页内的标签匹配即可 -->
<?php echo $_smarty_tpl->getSubTemplate ("footer.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>
<?php }} ?>
