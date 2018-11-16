<?php
if(isset($_SESSION['user_token'])) {
	echo ('<script type="text/javascript"> $(function(){ $("#ex_target_text").text("立即使用"); });</script>');
}
$filename = basename($_SERVER['PHP_SELF']);
$pagename = substr($filename, 0, strrpos($filename, "."));
?>

<header id="header">
	<section class="inbox clearfix">
		<h1><a href="index.php"><img src="../theme/cn/images/header/item_logo.jpg"></a></h1>
		<nav>
			<!--//登入前//-->
			<ul class="tnav" name="login_status" id="login_status">
				<?php
				if(isset($_SESSION['user_token'])) {
					echo('<li class="m_name-point fst"><b>'.$_SESSION['user_email'].'</b></li><li><a href="javascript:doLogout();">登出</a></li>');
				}
				else {
					?>
					<li class="fst"><a href="#fy-register" class="fancybox">注册</a></li>
					<li><a href="#fy-login" class="fancybox">登入</a></li>
					<?php
				}
				?>
			</ul>
			<!--//選單//-->
			<ul class="mnav">
				<li <?php if($pagename=='news') echo('class="on"'); ?> ><a href="news.php">最新消息</a></li>
				<li <?php if($pagename=='recommend') echo('class="on"'); ?>><a href="recommend.php">育儿天地</a></li>
				<li <?php if($pagename=='itemlist') echo('class="on"'); ?>><a id="menuitem_3" href="javascript:void(0);">成长指标</a></li>
				<li <?php if($pagename=='report') echo('class="on"'); ?>><a id="menuitem_6" href="javascript:void(0);">成长报告</a></li>
				<li <?php if($pagename=='ceanza_menu') echo('class="on"'); ?>><a id="menuitem_2" href="javascript:void(0);">成长记录</a></li>
				<li <?php if($pagename=='buds_record') echo('class="on"'); ?>><a id="menuitem_8">萌芽记录</a></li>
				<li <?php if($pagename=='epaper') echo('class="on"'); ?>><a  id="menuitem_4">巴布豆家庭早教</a></li>
				<li <?php if($pagename=='about') echo('class="on"'); ?>><a href="about.php">关于我们</a></li>
			</ul>
		</nav>
	</section>

	<!--//手機選單//-->
	<div class="i-menu">Menu</div>
	<nav class="s-mnav">
		<ul class="clearfix">



			<li <?php if($pagename=='itemlist') echo('class="on"'); ?>><a id="menuitem_3_m" href="javascript:void(0);">成长指标</a></li>
			<li <?php if($pagename=='report') echo('class="on"'); ?>><a id="menuitem_6_m" href="javascript:void(0);">成长报告</a></li>
			<li <?php if($pagename=='ceanza_menu') echo('class="on"'); ?>><a id="menuitem_2_m" href="javascript:void(0);">成长记录</a></li>
			<li <?php if($pagename=='buds_record') echo('class="on"'); ?>><a id="menuitem_8_m">萌芽记录</a></li>
			<li <?php if($pagename=='news') echo('class="on"'); ?> ><a href="news.php">最新消息</a></li>
			<li <?php if($pagename=='recommend') echo('class="on"'); ?>><a href="recommend.php">育儿天地</a></li>
			<li <?php if($pagename=='epaper') echo('class="on"'); ?>><a id="menuitem_4_m">巴布豆家庭早教</a></li>
			<li <?php if($pagename=='about') echo('class="on"'); ?>><a href="about.php">关于我们</a></li>
			<?php
			if(isset($_SESSION['user_token'])) {
				echo('<li class="last"><b>'.$_SESSION['user_email'].'</b><a href="javascript:doLogout();">登出</a></li>');
			}
			else {
				?>
				<li class="last" name="login_status_m" id="login_status_m"><a href="#fy-register" class="fst fancybox">注册</a><a href="#fy-login" class="fancybox">登入</a></li>
				<?php
			}
			?>
		</ul>
	</nav>
	<section class="bg-o"></section>
	<!--//選單//-->
</header>
