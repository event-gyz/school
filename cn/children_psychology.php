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
                <section class="contbox clearfix children_psychology">

                    <!--//主選單標題與路徑//-->
                    <div class="breadcrumbs_logo">
                        <h2 class="title">育儿天地</h2>
                        <section class="gopath"><a href="index.php">首页</a> > <a href="recommend.php">育儿天地</a> > 儿童心理</section>
                    </div>

                    <p class="column_introduction">
                        <img src="../content/epaper/images/column_introduction.jpg" alt="">
                    </p>

                    <div class="article_column">
                        <p><a href="psychological_article.php">更多》</a></p>
                        <h4>
                            儿童心理文章
                            <i></i>
                        </h4>
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

                    <div class="course_column">
                        <p><a href="psychological_course.php">更多》</a></p>
                        <h4>
                            儿童心理课程
                            <i></i>
                        </h4>
                        <div class="psychological_course">
                            <a href="course.php">
                                <p><img src="../content/epaper/images/psychological_course.jpg" alt=""></p>
                            </a>
                        </div>
                    </div>
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
