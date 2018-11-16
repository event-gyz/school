<?php
session_start();
include('inc.php');
?>
<!DOCTYPE html>
<html><!-- InstanceBegin template="/Templates/_page01.dwt" codeOutsideHTMLIsLocked="false" -->
<head>
    <?php include('inc_head.php');  ?>
    <style>
        body{background: #fff;}
    </style>
</head>

<body>

<!-- InstanceBeginEditable name="wrap" -->
<section id="wrap">
    <div class="diary_add">
    	<div class="diary_add_bg">
    		<a href="javascript: void(0)" onClick="history.go(-1)"><b></b></a>
    	</div>
    	<form action="index.php" method="post" enctype="multipart/form-data">
    		<ul class="diary_add_form">
				<li class="diary_add_theme">
					<p>主题：</p>
					<input name="theme" type="text">
					<b></b>
					<ul class="theme_sel_list">
						<li>第一次抬头</li>
						<li>第一次坐</li>
						<li>第一次站立</li>
						<li>第一次翻身</li>
						<li>第一次走路</li>
						<li>第一次抬头</li>
						<li>第一次叫妈妈</li>
						<li>第一次走路</li>
					</ul>
				</li>
				<li class="diary_add_describe">
					<p>描述：</p>
					<textarea name="describe">宝贝又长高了吧，用文字记录一下心情~</textarea>
				</li>
				<li class="diary_add_imgs">
					<div class="add_upload_img">
	                    <input name="imgFiles" type="file">
	                </div>
				</li>
				<li class="diary_add_address">
					<b></b>
	            	<input name="address" type="text" value="北京  丰台">
	            	<s></s>
				</li>
			</ul>
			<div class="diary_add_btn">
				<input onClick="history.go(-1)" type="text" class="diary_add_cancel" value="取消">
				<input type="submit" class="diary_add_submit" value="发布">
			</div>
    	</form>
    </div>
</section>
<?php include 'inc_bottom_js.php'; ?>
<script>
	$('.theme_sel_list li').click(function(){
		$('.diary_add_theme input').val($(this).html())
		$(this).parent().slideUp()
		$('.diary_add_theme b').removeClass('open')
	})
	$('.diary_add_theme b').click(function(){
		$(this).toggleClass('open')
		$(this).siblings('.theme_sel_list').slideToggle()
	})
</script>
</body>
<!-- InstanceEnd --></html>
