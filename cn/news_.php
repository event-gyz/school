<?php
session_start(); 
include('inc.php');	
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
                <h2 class="title">最新消息</h2>
                <section class="gopath"><a href="#">首頁</a> > 最新消息</section>
                <!--//主選單標題與路徑//-->
                
                <!--//最新消息//-->
                <section class="newsbox masonry">
                	<ul class="clearfix">
                    	<?php af_news_list(1); ?>
                    </ul>
                </section>
                <div id="next">
                	<a href="news2.php?p=2">&nbsp;</a>
                </div>
                <script>
				$(function(){
					$('.newsbox').infinitescroll({
						navSelector  	: "#next",
						nextSelector 	: "#next a",
						itemSelector 	: "li",
						loading: {
						  img: '../theme/cn/images/content/loading.gif',
						  msgText: '讀取中...',
						  finishedMsg: 'no more...'
						}
					}, function( newElements ) {
						var $newElems = $( newElements ).css({ opacity: 0 });
						$newElems.imagesLoaded(function(){
						  	$newElems.animate({ opacity: 1 });
						  	$('.masonry').masonry( 'appended', $newElems, true ); 
						});
					});
				})
				</script>
                <!--//最新消息//-->
                
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
