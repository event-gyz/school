<?php
session_start();
include('inc.php');
?>

<!DOCTYPE html>
<html><!-- InstanceBegin template="/Templates/_page01.dwt" codeOutsideHTMLIsLocked="false" -->
<head>
    <link href="https://vjs.zencdn.net/7.0.3/video-js.css" rel="stylesheet">
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
                <section class="contbox clearfix baby_care_video">

                    <!--//主選單標題與路徑//-->
                    <div class="breadcrumbs_logo">
                        <h2 class="title">育儿天地</h2>
                        <section class="gopath"><a href="index.php">首页</a> > <a href="recommend.php">育儿天地</a> > <a href="baby_care.php">婴儿护理</a> > 婴儿护理视频</section>
                    </div>

                    <div class="baby_care_video">
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
                    </div>

                    <ul class="baby_care_video_list">
                        <li>
                            <p>
                                <video class="video-js" controls preload="auto"
                                  poster="../content/epaper/images/baby_care_video01.jpg" data-setup="{}">
                                    <source src="../content/epaper/source/baby_care_video01.mp4" type='video/mp4'>
                                </video>
                            </p>
                            <span>宝宝学爬？爸妈这样辅助！</span>
                        </li>
                        <li>
                            <p>
                                <video class="video-js" controls preload="auto"
                                  poster="../content/epaper/images/baby_care_video02.jpg" data-setup="{}">
                                    <source src="../content/epaper/source/baby_care_video02.mp4" type='video/mp4'>
                                </video>
                            </p>
                            <span>0-1岁多按，促进视觉发展！</span>
                        </li>
                        <li>
                            <p>
                                <video class="video-js" controls preload="auto"
                                  poster="../content/epaper/images/baby_care_video03.jpg" data-setup="{}">
                                    <source src="../content/epaper/source/baby_care_video03.mp4" type='video/mp4'>
                                </video>
                            </p>
                            <span>增强宝宝益智健脑，这样按！</span>
                        </li>
                        <li>
                            <p>
                                <video class="video-js" controls preload="auto"
                                  poster="../content/epaper/images/baby_care_video04.jpg" data-setup="{}">
                                    <source src="../content/epaper/source/baby_care_video04.mp4" type='video/mp4'>
                                </video>
                            </p>
                            <span>讨厌的肠绞痛，Bye-bye！</span>
                        </li>
                        <li>
                            <p>
                                <video class="video-js" controls preload="auto"
                                  poster="../content/epaper/images/baby_care_video05.jpg" data-setup="{}">
                                    <source src="../content/epaper/source/baby_care_video05.mp4" type='video/mp4'>
                                </video>
                            </p>
                            <span>这样按，预防宝宝扁平足！</span>
                        </li>
                        <li>
                            <p>
                                <video class="video-js" controls preload="auto"
                                  poster="../content/epaper/images/baby_care_video06.jpg" data-setup="{}">
                                    <source src="../content/epaper/source/baby_care_video06.mp4" type='video/mp4'>
                                </video>
                            </p>
                            <span>4招，让宝宝「高」人一等！</span>
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
<script src="https://vjs.zencdn.net/7.0.3/video.js"></script>
<script>
    // window.onload = function(){
    //     var Width=$('.baby_care_video_list p').innerWidth();
    //     var Height=$('.baby_care_video_list p').innerHeight();
    //     $('.c-h5').css({
    //         width:Width,
    //         height:Height
    //     })
    // }
    //获取video

    // var oLiveVideo=document.getElementById("liveVideo");

    // //获取canvas画布

    // var oLiveCanvas=document.getElementById("canvas");

    // //设置画布

    // var oLiveCanvas2D=oLiveCanvas.getContext('2d');

    // //设置setinterval定时器

    // var bLiveVideoTimer=null;

    // //监听播放

    // oLiveVideo.addEventListener('play',function() {

    //     bLiveVideoTimer=setInterval(function() {

    //         oLiveCanvas2D.drawImage(myPlayer,0,0,640,320);

    //     },20);

    // },false);

    // //监听暂停

    // oLiveVideo.addEventListener('pause',function() {

    //     clearInterval(bLiveVideoTimer);

    // },false);

    // //监听结束

    // oLiveVideo.addEventListener('ended',function() {

    //     clearInterval(bLiveVideoTimer);

    // },false);
</script>
</body>
<!-- InstanceEnd --></html>
