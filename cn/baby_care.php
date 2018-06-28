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
                <section class="contbox clearfix baby_care">

                    <!--//主選單標題與路徑//-->
                    <div class="breadcrumbs_logo">
                        <h2 class="title">育儿天地</h2>
                        <section class="gopath"><a href="index.php">首页</a> > <a href="recommend.php">育儿天地</a> > 婴儿护理</section>
                    </div>

                    <p class="care_introduction">
                        <img src="../content/epaper/images/care_introduction.jpg" alt="">
                    </p>

                    <div class="article_column">
                        <p><a href="baby_care_article.php">更多》</a></p>
                        <h4>
                            婴儿护理文章
                            <i></i>
                        </h4>
                        <div id="slider_box">
                            <div class="wrap" id='slider'>
                                <ul id="pic">
                                    <li>
                                        <a href="#">
                                            <img src="../content/epaper/images/care_article01.jpg" alt="">
                                            <div class="slider_mask"></div>
                                            <div class="article_info">
                                                <h4>母乳副食品篇</h4>
                                                <p>简单两步骤 母乳奶油轻松做</p>
                                            </div>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="#">
                                            <img src="../content/epaper/images/care_article02.jpg" alt="">
                                            <div class="slider_mask"></div>
                                            <div class="article_info">
                                                <h4>亲子运动篇</h4>
                                                <p>亲子蹲运动 核心肌肉锻炼</p>
                                            </div>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="#">
                                            <img src="../content/epaper/images/care_article03.jpg" alt="">
                                            <div class="slider_mask"></div>
                                            <div class="article_info">
                                                <h4>按摩篇</h4>
                                                <p>肩颈疼痛？按三点，速缓解</p>
                                            </div>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="#">
                                            <img src="../content/epaper/images/care_article04.jpg" alt="">
                                            <div class="slider_mask"></div>
                                            <div class="article_info">
                                                <h4>生活篇</h4>
                                                <p>奶瓶真的有洗干净吗？</p>
                                            </div>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="#">
                                            <img src="../content/epaper/images/care_article05.jpg" alt="">
                                            <div class="slider_mask"></div>
                                            <div class="article_info">
                                                <h4>亲子篇</h4>
                                                <p>当爸爸后生活大不同!</p>
                                            </div>
                                        </a>
                                    </li>
                                </ul>
                                <ol id="list">
                                    <li><a class="on" href="1"></a></li>
                                    <li><a href="2"></a></li>
                                    <li><a href="3"></a></li>
                                    <li><a href="4"></a></li>
                                    <li><a href="5"></a></li>
                                </ol>
                            </div>
                        </div>
                    </div>

                    <div class="course_column">
                        <p><a href="#">更多》</a></p>
                        <h4>
                            婴儿护理课程
                            <i></i>
                        </h4>
                        <div class="baby_care_course">
                            <a href="#">
                                <p>
                                    <img src="../content/epaper/images/care_course.jpg" alt="">
                                </p>
                                <div class="slider_mask"></div>
                                <div class="course_info">
                                    <h4>婴幼护理课程</h4>
                                    <p>从宝宝抚触与按摩开始,指导你如何建立安全感与亲子关系,并进一步帮助孩子身体与心智的健康发展,做宝宝成长的关键推手。</p>
                                </div>
                            </a>
                        </div>
                    </div>

                    <div class="video_column">
                        <p><a href="baby_care_video.php">更多》</a></p>
                        <h4>
                            婴儿护理视频
                            <i></i>
                        </h4>
                        <div class="baby_care_video">
                            <a href="baby_care_video.php">
                                <p>
                                    <img src="../content/epaper/images/care_video.jpg" alt="">
                                </p>
                                <div class="slider_mask"></div>
                                <div class="video_info">
                                    <h4>婴幼儿按摩对宝贝的好处有？</h4>
                                    <p>
                                        <span>心理-情绪稳定、睡眠品质更佳</span>
                                        <span>生理-舒缓成长期不适、增进血液循环</span>
                                        <span>智力-启发神经系统、感觉统合</span>
                                        <span>发展增进社交能力及适应性</span>
                                        <span>体能-更加运用肌肉及肌力</span>
                                        亲子关系-增加亲子互动及信任
                                    </p>
                                </div>
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
