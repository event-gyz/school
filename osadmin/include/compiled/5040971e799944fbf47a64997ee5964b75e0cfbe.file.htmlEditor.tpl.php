<?php /* Smarty version Smarty-3.1.15, created on 2014-06-11 01:29:25
         compiled from "/Users/bclin087/Desktop/KidsDNA/Web/webpage/osadmin/include/template/sunnyschool/htmlEditor.tpl" */ ?>
<?php /*%%SmartyHeaderCode:20326547525397356ba61961-07763193%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '5040971e799944fbf47a64997ee5964b75e0cfbe' => 
    array (
      0 => '/Users/bclin087/Desktop/KidsDNA/Web/webpage/osadmin/include/template/sunnyschool/htmlEditor.tpl',
      1 => 1402421362,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '20326547525397356ba61961-07763193',
  'function' => 
  array (
  ),
  'version' => 'Smarty-3.1.15',
  'unifunc' => 'content_5397356ba6fc82_33639478',
  'has_nocache_code' => false,
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5397356ba6fc82_33639478')) {function content_5397356ba6fc82_33639478($_smarty_tpl) {?><?php echo $_smarty_tpl->getSubTemplate ("header.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>

<?php echo $_smarty_tpl->getSubTemplate ("navibar.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>

<?php echo $_smarty_tpl->getSubTemplate ("sidebar.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>

<!-- TPLSTART 以上内容不需更改，保证该TPL页内的标签匹配即可 -->
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>SunnySchool Text Editor</title>
<link href="ckeditor/_samples/sample.css" rel="stylesheet" type="text/css"/>
</head>

<body>
<p>編輯完成後，按下「原始碼」按鈕，複製編輯區內的HTML原始碼來使用。</p>
<textarea cols="80" id="editor1" name="editor1" rows="10"></textarea>    
</body>
<!-- TPLEND 以下内容不需更改，请保证该TPL页内的标签匹配即可 -->
<?php echo $_smarty_tpl->getSubTemplate ("footer.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>
<?php }} ?>
