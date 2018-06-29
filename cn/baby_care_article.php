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
                <section class="contbox clearfix baby_care_article">

                    <!--//主選單標題與路徑//-->
                    <div class="breadcrumbs_logo">
                        <h2 class="title">育儿天地</h2>
                        <section class="gopath"><a href="index.php">首页</a> > <a href="recommend.php">育儿天地</a> > <a href="baby_care.php">婴儿护理</a> > 婴儿护理文章</section>
                    </div>

                    <div class="article_column">
                        <div id="slider_box">
                            <div class="wrap" id='slider'>
                                <ul id="pic">
                                    <li>
                                        <img src="../content/epaper/images/care_article01.jpg" alt="">
                                        <div class="slider_mask"></div>
                                        <div class="article_info">
                                            <h4>母乳副食品篇</h4>
                                            <p>简单两步骤 母乳奶油轻松做</p>
                                        </div>
                                    </li>
                                    <li>
                                        <img src="../content/epaper/images/care_article02.jpg" alt="">
                                        <div class="slider_mask"></div>
                                        <div class="article_info">
                                            <h4>亲子运动篇</h4>
                                            <p>亲子蹲运动 核心肌肉锻炼</p>
                                        </div>
                                    </li>
                                    <li>
                                        <img src="../content/epaper/images/care_article03.jpg" alt="">
                                        <div class="slider_mask"></div>
                                        <div class="article_info">
                                            <h4>按摩篇</h4>
                                            <p>肩颈疼痛？按三点，速缓解</p>
                                        </div>
                                    </li>
                                    <li>
                                        <img src="../content/epaper/images/care_article04.jpg" alt="">
                                        <div class="slider_mask"></div>
                                        <div class="article_info">
                                            <h4>生活篇</h4>
                                            <p>奶瓶真的有洗干净吗？</p>
                                        </div>
                                    </li>
                                    <li>
                                        <img src="../content/epaper/images/care_article05.jpg" alt="">
                                        <div class="slider_mask"></div>
                                        <div class="article_info">
                                            <h4>亲子篇</h4>
                                            <p>当爸爸后生活大不同!</p>
                                        </div>
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

                    <div class="baby_care_article_list">
                        <div class="massage">
                            <h4>
                                按摩篇
                                <i></i>
                            </h4>
                            <ul>
                                <li>
                                    <a href="massage01.php">
                                        <p><img src="../content/epaper/images/massage01.jpg" alt=""></p>
                                        <span>肩颈疼痛？按3点，速缓解</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="massage02.php">
                                        <p><img src="../content/epaper/images/massage02.jpg" alt=""></p>
                                        <span>宝宝正在学翻身、坐、爬？</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="#">
                                        <p><img src="../content/epaper/images/massage03.jpg" alt=""></p>
                                        <span>宝宝肚子鼓鼓的，频哭闹？</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="#">
                                        <p><img src="../content/epaper/images/massage04.jpg" alt=""></p>
                                        <span>按、搓、推，让宝宝头脑更聪明！</span>
                                    </a>
                                </li>
                            </ul>
                        </div>
                        <div class="sports">
                            <h4>
                                亲子运动篇
                                <i></i>
                            </h4>
                            <ul>
                                <li>
                                    <a href="sports01.php">
                                        <p><img src="../content/epaper/images/sports01.jpg" alt=""></p>
                                        <span>亲子蹲运动，核心肌肉锻炼</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="#">
                                        <p><img src="../content/epaper/images/sports02.jpg" alt=""></p>
                                        <span>打造好体质健康宝宝瑜伽操！</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="#">
                                        <p><img src="../content/epaper/images/sports03.jpg" alt=""></p>
                                        <span>宝宝学爬更快速，简单一招搞定！</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="#">
                                        <p><img src="../content/epaper/images/sports04.jpg" alt=""></p>
                                        <span>宝宝健身操，学坐好轻松！</span>
                                    </a>
                                </li>
                            </ul>
                        </div>
                        <div class="non_staple_food">
                            <h4>
                                母婴副食品篇
                                <i></i>
                            </h4>
                            <ul>
                                <li>
                                    <a href="#">
                                        <p><img src="../content/epaper/images/non_staple_food01.jpg" alt=""></p>
                                        <span>简单两步骤母乳奶油轻松做！</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="non_staple_food02.php">
                                        <p><img src="../content/epaper/images/non_staple_food02.jpg" alt=""></p>
                                        <span>简单4步骤，周岁母奶乳霜蛋糕！</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="non_staple_food03.php">
                                        <p><img src="../content/epaper/images/non_staple_food03.jpg" alt=""></p>
                                        <span>母奶冰激淋，秋天美味清凉点心！</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="#">
                                        <p><img src="../content/epaper/images/non_staple_food04.jpg" alt=""></p>
                                        <span>3招母奶变松饼，甜蜜过圣诞！</span>
                                    </a>
                                </li>
                            </ul>
                        </div>
                        <div class="life">
                            <h4>
                                生活篇
                                <i></i>
                            </h4>
                            <ul>
                                <li>
                                    <a href="#">
                                        <p><img src="../content/epaper/images/life01.jpg" alt=""></p>
                                        <span>体贴老婆，必做贴心事</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="life02.php">
                                        <p><img src="../content/epaper/images/life02.jpg" alt=""></p>
                                        <span>奶瓶用完就洗or累计多支1次洗？</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="#">
                                        <p><img src="../content/epaper/images/life03.jpg" alt=""></p>
                                        <span>天冷，帮宝宝洗澡免紧张！</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="life04.php">
                                        <p><img src="../content/epaper/images/life04.jpg" alt=""></p>
                                        <span>宝宝半夜常哭闹？过敏惹的祸！</span>
                                    </a>
                                </li> 
                            </ul>
                        </div>
                        <div class="parent_offspring">
                            <h4>
                                亲子篇
                                <i></i>
                            </h4>
                            <ul>
                                <li>
                                    <a href="#">
                                        <p><img src="../content/epaper/images/parent_offspring01.jpg" alt=""></p>
                                        <span>当爸爸后，生活大不同！</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="#">
                                        <p><img src="../content/epaper/images/parent_offspring02.jpg" alt=""></p>
                                        <span>当妈之后，成了炫娃狂人！</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="#">
                                        <p><img src="../content/epaper/images/parent_offspring03.jpg" alt=""></p>
                                        <span>三人行约会更浪漫！</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="parent_offspring04.php">
                                        <p><img src="../content/epaper/images/parent_offspring04.jpg" alt=""></p>
                                        <span>爸爸多陪伴孩子，让孩子更有竞争力！</span>
                                    </a>
                                </li> 
                            </ul>
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
