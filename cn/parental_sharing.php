<?php
session_start();
include('inc.php');
?>
<!DOCTYPE html>
<html><!-- InstanceBegin template="/Templates/_page01.dwt" codeOutsideHTMLIsLocked="false" -->
<head>
    <?php include('inc_head.php');	?>
    <style>
        body{background: none;}
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

    <!--【Content】-->
    <section id="content">
        <!-- InstanceBeginEditable name="content" -->

        <!--//主內容//-->
        <section class="indexcont parental_sharing">
            <section class="inbox noBoxShadowPage">
                <section class="contbox clearfix">

                    <!--//主選單標題與路徑//-->
                    <h2 class="title">家长分享</h2>
                    <section class="gopath"><a href="index.php">首页</a> > 家长分享</section>
                    <p><img src="../content/epaper/images/parental_sharing.jpg" alt=""></p>
                    <!--//主選單標題與路徑//-->
                    <ul class='article_list'>
						<?php

						$sql = "SELECT * from grow_diary WHERE `open`='1' order by create_time desc limit 20";
						$result = M()->query($sql);
						if(is_array($result) && !empty($result)){
							foreach($result as $value){
								$title = $value['title'];
								$content = $value['content'];
								$time = $value['create_time'];
						?>
								<li>
									<a href="ceanza_view.php">
										<h4><?=$title ?></h4>
									</a>
									<p><?=$content?></p>
								</li>

						<?php } }
						?>

                    </ul>
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
<script>
    
</script>
</body>
<!-- InstanceEnd --></html>
