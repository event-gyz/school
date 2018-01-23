<?php /* Smarty version Smarty-3.1.15, created on 2014-08-21 18:39:27
         compiled from "/Users/bclin087/Desktop/KidsDNA/Web/webpage/osadmin/include/template/sunnyschool/editArticle.tpl" */ ?>
<?php /*%%SmartyHeaderCode:2914679905399b7a6c594a6-57105674%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'ca7b79f2a60d738a824a047fc54679be9f218a21' => 
    array (
      0 => '/Users/bclin087/Desktop/KidsDNA/Web/webpage/osadmin/include/template/sunnyschool/editArticle.tpl',
      1 => 1408617564,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '2914679905399b7a6c594a6-57105674',
  'function' => 
  array (
  ),
  'version' => 'Smarty-3.1.15',
  'unifunc' => 'content_5399b7a6c9c0a5_66221174',
  'variables' => 
  array (
    'total' => 0,
    'radio_options_val' => 0,
    'radio_options_name' => 0,
    'type_filter_selected_val' => 0,
    'uid' => 0,
    'title' => 0,
    'description' => 0,
    'tag_options_val' => 0,
    'tag_options_name' => 0,
    'tag_selected_val' => 0,
    'radio_selected_val' => 0,
    'pub_date' => 0,
    'list' => 0,
    'page' => 0,
    'prev_page' => 0,
    'next_page' => 0,
  ),
  'has_nocache_code' => false,
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5399b7a6c9c0a5_66221174')) {function content_5399b7a6c9c0a5_66221174($_smarty_tpl) {?><?php if (!is_callable('smarty_function_html_options')) include '/Users/bclin087/Desktop/KidsDNA/Web/webpage/osadmin/include/config/../../include/lib/Smarty/plugins/function.html_options.php';
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
<select name="type_filter" id="type_filter">
<?php echo smarty_function_html_options(array('values'=>$_smarty_tpl->tpl_vars['radio_options_val']->value,'output'=>$_smarty_tpl->tpl_vars['radio_options_name']->value,'selected'=>$_smarty_tpl->tpl_vars['type_filter_selected_val']->value),$_smarty_tpl);?>

</select>
<p><input type="button" name="new_button" value="新增">
</p>
<div id="edit_area" style="display:none">
<hr/>
<form id="content_form" action="submit_article.php" method="post"> 
<input type="hidden" name="uid" value="<?php echo $_smarty_tpl->tpl_vars['uid']->value;?>
">
標題：<input type="text" name="title" value="<?php echo $_smarty_tpl->tpl_vars['title']->value;?>
">
簡述：<input type="text" name="description" size="100" value="<?php echo $_smarty_tpl->tpl_vars['description']->value;?>
"><br>
標籤：<select name="tag">
<?php echo smarty_function_html_options(array('values'=>$_smarty_tpl->tpl_vars['tag_options_val']->value,'output'=>$_smarty_tpl->tpl_vars['tag_options_name']->value,'selected'=>$_smarty_tpl->tpl_vars['tag_selected_val']->value,'seperator'=>'<br/>'),$_smarty_tpl);?>

</select>
類型：<select name="type">
<?php echo smarty_function_html_options(array('values'=>$_smarty_tpl->tpl_vars['radio_options_val']->value,'output'=>$_smarty_tpl->tpl_vars['radio_options_name']->value,'selected'=>$_smarty_tpl->tpl_vars['radio_selected_val']->value,'seperator'=>'<br/>'),$_smarty_tpl);?>

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

<table width='20%' align="left">
<tr>
<td align="left">Page <?php echo $_smarty_tpl->tpl_vars['page']->value;?>
</td>
<td align="left"><a id="a_prev" href="edit_article.php?page=<?php echo $_smarty_tpl->tpl_vars['prev_page']->value;?>
">[上頁]</a></td>
<td align="left"><a id="a_next" href="edit_article.php?page=<?php echo $_smarty_tpl->tpl_vars['next_page']->value;?>
">[下頁]</a></td>
</tr>
</table>
</div>
</body>
<!-- TPLEND 以下内容不需更改，请保证该TPL页内的标签匹配即可 -->
<?php echo $_smarty_tpl->getSubTemplate ("footer.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>
<?php }} ?>
