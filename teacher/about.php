<?php
session_start(); 
include('inc.php');	
$func = 999;
?>
<!DOCTYPE html> 
<html><!-- InstanceBegin template="/Templates/_page01.dwt" codeOutsideHTMLIsLocked="false" -->
<head>
	<?php include('inc_head.php');	?>
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
            <section class="inbox">
            	<section class="contbox clearfix">
            	
                <!--//主選單標題與路徑//-->
                <h2 class="title">关于我们</h2>
                <section class="gopath"><a href="#">首页</a> > 关于我们</section>
                <!--//主選單標題與路徑//-->
                
                <!--//文章區//-->
                <section class="artbox clearfix">
                    
                    <!--//圖片輪播區//-->
                    <!--【註1】class="slider"為圖片區，clider-pg為分頁icon區,幾張圖對應幾個icon。-->
                    <section class="picbox">
                    	<div class="inpic">
                        <div class="iosSlider">
                            <div class="slider">
                                <ul class="clearfix">
                                    <li>
                                        <div class="item">
                                            <img src="../theme/cn/images/content/item_about01.jpg">
                                        </div>
                                    </li>
                                    <li>
                                        <div class="item">
                                            <img src="../theme/cn/images/content/item_about02.jpg">
                                        </div>
                                    </li>
                                </ul>
                            </div>
                        </div>
                        </div>
                        <div class="slider-pg">
                            <div class="pgs">
                                <div class="item fst on"></div>
                                <div class="item"></div>
                            </div>
                        </div>
                    </section>
                    
                    <!--//文字編輯器區//-->
                    <section class="Txt fl clearfix">
                        <h3>安全、快乐，永远坚持以儿童的需求为中心考量。</h3>
                        <p>无论课程规划、数位内容研发、专业发展检测或系列活动的举办，晴天学园总是坚持以儿童的需求为中心考量，让他们在安全的学习环境中快乐成长。并针对两岸四地的华人教育市场，提供先进、优质的教育系统与教学方针，以满足家长与相关业者最大的需求，建立一个值得信赖的儿童事业领导品牌。</p>
                        <h3>启发儿童的智能比让他们获得知识更重要。</h3>
                        <p>儿童是世界上最重要的资产，二十世纪以来，儿童教育越来越受到社会重视。在儿童身心发展的重要阶段，启发智慧比让他们获得知识更重要；因为知识会随着时间被修正，而智慧是获取与运用知识的能力。如果想让孩子有实力面对未来的人生，就得按部就班教他们「如何思考」、「如何解决问题」。</p>
                        <h3>以儿童为本，顺自然，展个性。</h3>
                        <p>成功的教育应该要「以儿童为本，顺自然，展个性」，所以晴天学园最大的心愿就是──让孩子在无压的环境下，就能从游戏中学习到正确的好品德，获得一辈子受用无穷的智慧与关键能力。</p>
                    </section>
                    
                </section>
                <!--//文章區//-->
                
                <!--//回頂端//-->
				<section class="gotop bodytop"><img src="../theme/cn/images/content/item_gotop01.png">回顶端</section>
                
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
    <link rel="stylesheet" href="../scripts/fancybox/jquery.fancybox.css">
    <script src="../scripts/fancybox/jquery.fancybox.pack.js"></script>
    <link rel="stylesheet" type="text/css" href="../scripts/scrollbar/jquery.mCustomScrollbar.css">
    <script src="../scripts/scrollbar/jquery.mCustomScrollbar.concat.min.js"></script>
    <script src="../scripts/ios_slider/jquery.iosslider.min.js"></script>
    <script src="../scripts/other.js"></script>
</body>
<!-- InstanceEnd --></html>
