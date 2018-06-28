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
                                    <li>
                                        <a href="article.php?index=1">
                                            <img src="../content/epaper/images/article_column01.jpg" alt="">
                                            <div class="slider_mask"></div>
                                            <div class="article_info">
                                                <h4>夜深了，孩子正在跟你拔河！</h4>
                                                <p>孩子出现这种令你困惑的作息拔河，一定要思考看看，他是不是还有其他心理的需求，正在透过他的行为得到满足。</p>
                                            </div>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="article.php?index=2">
                                            <img src="../content/epaper/images/article_column02.jpg" alt="">
                                            <div class="slider_mask"></div>
                                            <div class="article_info">
                                                <h4>容易挫败的孩子需要多陪伴！</h4>
                                                <p>孩子的感觉是由很多因素、长期、累加而形成的，当下的活动只是一个激发点，即使排除了这个活动，感觉仍然会停留一阵子，父母需要观察孩子容易紧张、焦虑、挫败的状况，才能帮助他度过未来的更多关卡。</p>
                                            </div>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="article.php?index=3">
                                            <img src="../content/epaper/images/article_column03.jpg" alt="">
                                            <div class="slider_mask"></div>
                                            <div class="article_info">
                                                <h4>孩子正在学你！「隐性」的身教影响更大！</h4>
                                                <p>好好认识你自己的情绪，必要时，告诉孩子你的情绪，可以帮助孩子认识负面情绪，也能学会接纳自己。父母若遇重大事件，而产生情绪困扰时，务必咨询专家，适度隔离或寻求帮助，避免对孩子造成隐性的影响。</p>
                                            </div>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="article.php?index=4">
                                            <img src="../content/epaper/images/article_column04.jpg" alt="">
                                            <div class="slider_mask"></div>
                                            <div class="article_info">
                                                <h4>玩出孩子的软实力！</h4>
                                                <p>玩乐当中除了肢体和小肌肉的训练、解决能力的培养、耐心和毅力等，最重要的，却比较难以量化的其实是心理发展。透过同侪互动、团体规矩、人生挫折，奠定了孩子日后的社会发展基础。</p>
                                            </div>
                                        </a>
                                    </li>
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
                                <p>
                                    <img src="../content/epaper/images/psychological_course.jpg" alt="">
                                </p>
                                <div class="slider_mask"></div>
                                <div class="course_info">
                                    <h4>夜深了，孩子正在跟你拔河！</h4>
                                    <p>孩子出现这种令你困惑的作息拔河，一定要思考看看，他是不是还有其他心理的需求，正在透过他的行为得到满足。</p>
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
