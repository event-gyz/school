<?php
session_start();
include('inc.php');
?>
<!DOCTYPE html>
<html><!-- InstanceBegin template="/Templates/_page01.dwt" codeOutsideHTMLIsLocked="false" -->
<head>
    <?php include('inc_head.php');  ?>
    <style>
        body{background: none;}
        h1,h2,h3,h4,h5,h6,p,ul,li,dl,dt,dd{margin:0;padding:0;list-style: none;}
        input,button{padding: 0;margin:0;border:0;outline: none;}
        img{vertical-align: bottom}
    </style>
</head>
<?php include 'inc_header.php'; ?>
<body>
<!-- InstanceBeginEditable name="wrap" -->
<section id="wrap">
    <!--//主內容//-->
    <section class="indexcont">
        <section class="inbox noBoxShadowPage">
            <section class="clearfix">
                <!--//主選單標題與路徑//-->
                <div class="share">
                    <p><img src="../content/epaper/images/share_logo.jpg" alt=""></p>
                </div>
                <form name="share_register_form" id="share_register_form" method="post">
                    <div class="share_register">
                        <div class="mobile_code">
                            <input name="share_mobile" id="share_mobile" type="tel" class="tf" placeholder="请输入手机号码">
                        </div>
                        <div class="valid_code">
                            <input type="number" id="share_vcode" placeholder="短信验证码">
                            <a href="javascript: void(0)" class="getcode">获取验证码</a>
                        </div>
                        <input type="submit" class="share_register_submit" value="注册">
                    </div>
                </form>
            </section>
        </section>
    </section>
    <!--//主內容//-->
</section>
<?php include 'inc_bottom_js.php'; ?>

</body>
<!-- InstanceEnd --></html>
