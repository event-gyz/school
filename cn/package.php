<?php
session_start(); 
include('inc.php');
?>
<!DOCTYPE html> 
<html><!-- InstanceBegin template="/Templates/_page01.dwt" codeOutsideHTMLIsLocked="false" -->
<head>
	<?php 
		include('inc_head.php');
		include("inc_fancyboxes.php");
	?>
	<style>
		body{background: none;margin:0;}
		h1,h2,h3,h4,h5,h6,p,ul,li,dl,dt,dd{margin:0;padding:0;list-style: none;}
		input,button{padding: 0;margin:0;border:0;outline: none;}
		img{vertical-align: bottom}
	</style>
</head>
<body>                         
	<!-- InstanceBeginEditable name="wrap" -->
	<section id="wrap">
    <!-- InstanceEndEditable -->
        <!--//主內容//-->
        <section class="package">
        	<p><img src="../content/epaper/images/package.png" alt=""></p>
        	<h3>您已获得免费使用权</h3>
        	<b>半年免费体验更全面专业的宝贝成长日记</b>
        	<section>
        		<a href="#fy-complete-info">
	                <input type="submit" class="" value="立即使用">
	            </a>
        	</section>
        	<span>点击立即使用完善个人信息，享用全面的宝贝成长日记服务</span>
        </section>
        <!--//主內容//-->
    </section>
    <script src="../scripts/jquery.masonry.min.js"></script>
    <link rel="stylesheet" href="../scripts/fancybox/jquery.fancybox.css">
    <script src="../scripts/fancybox/jquery.fancybox.pack.js"></script>
    <link rel="stylesheet" type="text/css" href="../scripts/scrollbar/jquery.mCustomScrollbar.css">
    <script src="../scripts/scrollbar/jquery.mCustomScrollbar.concat.min.js"></script>
    <script src="../scripts/scroll_loading/jquery.infinitescroll.min.js"></script>
    <script src="../scripts/ios_slider/jquery.iosslider.min.js"></script>
    <script src="../scripts/other.js"></script>
    <script>
	    $(function(){
	        $('.package a').click(function(){
	        	$('.isbind_mobile').hide()
	            $.fancybox({
	                href: "#fy-complete-info"
	            });
	        })
	    })
	</script>
</body>
<!-- InstanceEnd --></html>