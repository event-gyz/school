<?php

include_once "ckeditor/ckeditor.php";
require ('../include/init.inc.php');

$method = $user_id = $page_no = '';
extract ( $_GET, EXTR_IF_EXISTS );
$CKEditor = new CKEditor();
$CKEditor->basePath = 'ckeditor/';
Template::display ( 'sunnyschool/htmlEditor.tpl' );
$CKEditor->replace("editor1");
?>
