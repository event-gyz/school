<?php /* Smarty version Smarty-3.1.15, created on 2014-06-11 00:04:20
         compiled from "/Users/bclin087/Desktop/KidsDNA/Web/webpage/osadmin/include/template/simple_header.tpl" */ ?>
<?php /*%%SmartyHeaderCode:40782693153972c8420ab71-31110323%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '86cef5e793940c951332ecc00d5d3c6aecdd49d1' => 
    array (
      0 => '/Users/bclin087/Desktop/KidsDNA/Web/webpage/osadmin/include/template/simple_header.tpl',
      1 => 1382249152,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '40782693153972c8420ab71-31110323',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'page_title' => 0,
    'user_info' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.15',
  'unifunc' => 'content_53972c84259721_86108394',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_53972c84259721_86108394')) {function content_53972c84259721_86108394($_smarty_tpl) {?><!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <title><?php echo $_smarty_tpl->tpl_vars['page_title']->value;?>
 - <?php echo @constant('ADMIN_TITLE');?>
</title>
    <meta content="IE=edge,chrome=1" http-equiv="X-UA-Compatible">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">

    <link rel="stylesheet" href="<?php echo @constant('ADMIN_URL');?>
/assets/lib/bootstrap/css/bootstrap.css">
    
    <link rel="stylesheet" href="<?php echo @constant('ADMIN_URL');?>
/assets/stylesheets_<?php if ($_smarty_tpl->tpl_vars['user_info']->value) {?><?php echo $_smarty_tpl->tpl_vars['user_info']->value['template'];?>
<?php } else { ?>default<?php }?>/theme.css">
    <link rel="stylesheet" href="<?php echo @constant('ADMIN_URL');?>
/assets/lib/font-awesome/css/font-awesome.css">

    <script src="<?php echo @constant('ADMIN_URL');?>
/assets/lib/jquery-1.8.1.min.js" ></script>
	<script src="<?php echo @constant('ADMIN_URL');?>
/assets/js/other.js" ></script>

    <!-- Demo page code -->

    <style type="text/css">
        #line-chart {
            height:300px;
            width:800px;
            margin: 0px auto;
            margin-top: 1em;
        }
        .brand { font-family: georgia, serif; }
        .brand .first {
            color: #ccc;
            font-style: italic;
        }
        .brand .second {
            color: #fff;
            font-weight: bold;
        }
    </style>

    <!-- Le HTML5 shim, for IE6-8 support of HTML5 elements -->
    <!--[if lt IE 9]>
      <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
    <![endif]-->
  </head><?php }} ?>
