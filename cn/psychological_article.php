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
<section id="wrap" class="inpage">
    <!-- InstanceEndEditable -->

    <!--【Header】-->
    <?php include 'inc_header.php'; ?>
    <!--【Header End】-->

    <!--【Content】-->
    <section id="content">
        <!-- InstanceBeginEditable name="content" -->

        <!--//主內容//-->
        <section class="indexcont">
            <section class="inbox noBoxShadowPage">
                <section class="contbox clearfix psychological_article">

                    <!--//主選單標題與路徑//-->
                    <div class="breadcrumbs_logo">
                        <h2 class="title">育儿天地</h2>
                        <section class="gopath"><a href="index.php">首页</a> > <a href="recommend.php">育儿天地</a> > <a href="children_psychology.php">儿童心理</a> > 儿童心理文章</section>
                    </div>

                    <div class="article_column">
                        <div id="slider_box">
                            <div class="wrap" id='slider'>
                                <ul id="pic">
                                    <li><a href="article.php?index=1"><img src="../content/epaper/images/article_column01.jpg" alt=""></a></li>
                                    <li><a href="article.php?index=2"><img src="../content/epaper/images/article_column02.jpg" alt=""></a></li>
                                    <li><a href="article.php?index=3"><img src="../content/epaper/images/article_column03.jpg" alt=""></a></li>
                                    <li><a href="article.php?index=4"><img src="../content/epaper/images/article_column04.jpg" alt=""></a></li>
                                </ul>
                                <ol id="list">
                                    <li><a class="on" href="1"></a></li>
                                    <li><a href="2"></a></li>
                                    <li><a href="3"></a></li>
                                    <li><a href="4"></a></li>
                                </ol>
                            </div>
                        </div>
                    </div>

                    <ul class="psychological_article_list">
                        <li>
                            <a href="article.php?index=2">
                                <p><img src="../content/epaper/images/article_column02.jpg" alt=""></p>
                                <span>容易挫败的孩子需要多陪伴！</span>
                            </a>
                        </li>
                        <li>
                            <a href="article.php?index=3">
                                <p><img src="../content/epaper/images/article_column03.jpg" alt=""></p>
                                <span>孩子正在学你！「隐性」的身教影响更大！</span>
                            </a>
                        </li>
                        <li>
                            <a href="article.php?index=4">
                                <p><img src="../content/epaper/images/article_column04.jpg" alt=""></p>
                                <span>玩出孩子的软实力！</span>
                            </a>
                        </li>
                        <li>
                            <a href="article.php?index=1">
                                <p><img src="../content/epaper/images/article_column01.jpg" alt=""></p>
                                <span>夜深了，孩子正在跟你拔河！</span>
                            </a>
                        </li>
                    </ul>

                    
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
<script>
    $(function(){
        function banner(){
            var wrap = document.getElementById('slider'),
                pic = document.getElementById('pic').getElementsByTagName("li"),
                list = document.querySelectorAll('#list li>a');
            plays(wrap,pic,list);
            //console.log(list);
        }
        banner();
    })
</script>
</body>
<!-- InstanceEnd --></html>
