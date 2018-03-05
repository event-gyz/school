<?php
session_start(); 
include('inc.php');	
if(!isset($_SESSION['user_token'])) {
	header( 'Location: index.php' ) ;
	exit();
}
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
                <h2 class="title">每日e练习</h2>
                <section class="gopath"><a href="#">首頁</a> > 每日e练习</section>
                <!--//主選單標題與路徑//-->
                
                <!--//每日e练习//-->
                <section class="artbox">
                    
                    <!--//文字編輯器區//-->
                    <section class="Txt clearfix">
                        <p>「每日E练习」是一套最先进的e化学习模式，不论何种主题，都藉由不同的题型让孩子反复操作，将知识内化成直觉反应。只要每天上线就能透过系统化的单元循序渐进的训练孩子思考与解决问题的能力，让孩子在开心的氛围下培育未来社会最需要的关键智能。</p>
                        <h3 class="title">請注意：此單元需要使用桌上型電腦或筆記型電腦操作。</h3>
                    </section>
                    
                    <!--//Flash區//-->
                    <section class="flashbox">
                    	<?php
                    	$sql = "select uid,subject,flash_name from training where pub_date=date(now()) order by uid desc limit 1";
                    	$result = query($sql);
                    	if($row = mysqli_fetch_array($result)) {
                    		$uid = $row['uid'];
                    		$subject = $row['subject'];
	                    	$filename = $row['flash_name'];
	                    	echo('<h2>'.$subject.'</h2><iframe src="../content/upload/training/'.$uid.'/'.$filename.'" width="100%" height="600px"></iframe>');
//	                    	echo('<iframe src="loadswf.php?f='.$filename.'" width="100%" height="768px"></iframe>');
                    	}
                    	else {
                    	echo('<div id="flasharea" name="flasharea" style="width:100%:height:400px;line-height:400px;text-align:center;border:1px dashed #ccc;">');
                    		echo('本日尚无练习题目，请稍后再试。');
                    	echo('</div>');
                    	}
                     	?>
                    </section>
                    
                </section>
                <!--//每日e练习//-->
                
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
    <script src="../scripts/jquery.masonry.min.js"></script>
    <link rel="stylesheet" href="../scripts/fancybox/jquery.fancybox.css">
    <script src="../scripts/fancybox/jquery.fancybox.pack.js"></script>
    <link rel="stylesheet" type="text/css" href="../scripts/scrollbar/jquery.mCustomScrollbar.css">
    <script src="../scripts/scrollbar/jquery.mCustomScrollbar.concat.min.js"></script>
    <script src="../scripts/scroll_loading/jquery.infinitescroll.min.js"></script>
    <script src="../scripts/ios_slider/jquery.iosslider.min.js"></script>
    <script src="../scripts/other.js"></script>
</body>
<!-- InstanceEnd --></html>
