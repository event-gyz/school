<?php
session_start();
include('inc.php');
?>
<!DOCTYPE html>
<html><!-- InstanceBegin template="/Templates/_page01.dwt" codeOutsideHTMLIsLocked="false" -->
<head>
	<?php include('inc_head.php');	?>
	<style>
		body{background: #fff;}
		h1,h2,h3,h4,h5,h6,p,ul,li,dl,dt,dd{margin:0;padding:0;list-style: none;}
		input,button{padding: 0;margin:0;border:0;outline: none;}
		img{vertical-align: bottom}
	</style>
</head>
<body>

<!-- InstanceBeginEditable name="wrap" -->
<section id="wrap">
	<!-- InstanceEndEditable -->

	<!--【Header】-->
	<?php include 'inc_header.php'; ?>
	<!--【Header End】-->
	<?php
	$sql = '';
	?>
	<!--【Content】-->
	<section id="content">
		<!-- InstanceBeginEditable name="content" -->
		<!--//主內容//-->
		<section class="indexcont">
			<section class="inbox noBoxShadowPage">
				<section class="contbox clearfix">
					<section class="ceanza ceanza_view">
						<?php
						$sql  = 'select * from grow_diary where Id='.$_GET['grow_id'];
						$result = M()->find($sql);
						//				print_r($result);
						?>
						<h4>查看宝贝日记</h4>
						<section class="gopath"><a href="index.php">首页</a> > 查看宝贝日记</section>
						<ul class="ceanza_view">
							<li class="title">标题：<?php echo $result['title']?></li>
							<li>内容：<?php echo $result['content']?></li>

							<li class="eqitUploadImg">
								<div class="imgContent">
									<img src=<?php echo $result['picurl']?> alt="">
								</div>
							</li>
						</ul>
						<div class="diaryTime">
							<p><?php echo date('Y年m月d日',strtotime($result['date']))?></p>
							<span><?php echo $result['address']?></span>
						</div>
					</section>
					<!--//主選單標題與路徑//-->
				</section>
			</section>
		</section>
		<!--//主內容//-->
		<!-- InstanceEndEditable -->
	</section>
	<!--【Content End】-->

	<!--【Footer】-->
	<?php include 'inc_footer.html'; ?>
	<!--【Footer End】-->

</section>
<?php include 'inc_bottom_js.php'; ?>
</body>
<!-- InstanceEnd --></html>
