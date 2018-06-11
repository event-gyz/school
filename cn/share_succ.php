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
        body,h1,h2,h3,h4,h5,h6,p,ul,li,dl,dt,dd{margin:0;padding:0;list-style: none;}
        input,button{padding: 0;margin:0;border:0;outline: none;}
        img{vertical-align: bottom}
    </style>
</head>

<body>
<!-- InstanceBeginEditable name="wrap" -->
<section id="wrap">
    <!--//主內容//-->
    <section class="indexcont">
        <section class="inbox noBoxShadowPage">
            <section class="clearfix">
                <!--//主選單標題與路徑//-->
                <div class="share_succ">
                    <p><img src="../content/epaper/images/share_succ_logo.jpg" alt=""></p>
                </div>
                <div class="share_two_dimension_code">
                    <h3>扫描二维码进入宝贝成长日记</h3>
                    <p><img src="../content/epaper/images/two_dimension_code.jpg" alt=""></p>
                    <?php if(isset($_GET['phone']) && !empty($_GET['phone'])){?>
                    <div class="use_login">使用<span><?=$_GET['phone']?></span>登录</div>
                    <?php }?>
                    <span>即可立即免费使用半年宝贝成长日记服务</span>
                </div>
            </section>
        </section>
    </section>
    <!--//主內容//-->
</section>
<?php include 'inc_bottom_js.php'; ?>
<script></script>
</body>
<!-- InstanceEnd --></html>
