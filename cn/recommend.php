<?php
session_start(); 
include('inc.php');	

$_tag = @$_GET['t'];
if(!isset($_tag))
	$_tag = 0;
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
                <h2 class="title">推荐文章</h2>
                <section class="gopath"><a href="index.php">首頁</a> > 推荐文章</section>
                <!--//主選單標題與路徑//-->
                
                <!--//文章內容和文章列表//-->
                <section class="artbox">
                    
                    <section class="lbox">
                    	
                    	<div>
                    	类别: 
                    	<a href="?t=0" id="tag1" <?php if($_tag==0) echo('style="font-family:arial;color:blue;font-size:20px;"'); ?>>育儿</a>&nbsp;
                    	<a href="?t=1" id="tag2" <?php if($_tag==1) echo('style="font-family:arial;color:blue;font-size:20px;"'); ?>>医疗</a>&nbsp;
                    	<a href="?t=2" id="tag3" <?php if($_tag==2) echo('style="font-family:arial;color:blue;font-size:20px;"'); ?>>心理</a>&nbsp;
                    	<a href="?t=3" id="tag4" <?php if($_tag==3) echo('style="font-family:arial;color:blue;font-size:20px;"'); ?>>教育</a>
                    	</div>
                    	<!--//文字編輯器區//-->
                        <section id="main_article" name="main_article" class="Txt clearfix">
                            <?php 
                            	$article_id = af_recommend_load_article($_tag);
                            ?>
                        </section>
                        
                        <!--//相關文章//-->
                        <!--【註1】二個li，就帶一個<li class="clear"></li>-->
                        <!--                        
                        <section class="list02">
                            <h3 class="title">相关文章</h3>
                            <ul id="related_article" name="related_article" class="clearfix">
                            	<?php// af_recommend_list_related($article_id); ?>
                            </ul>
                        </section>
                        -->                        
                    </section>
                    
                    <section class="rbox">
                    
                    	<!--//其它推薦文章//-->
                        <section class="list02" style="overflow:auto;max-height:700px">
                            <h3 class="title">其它推荐文章</h3>
                            <ul id="article_list">
                            	<?php af_recommend_list($_tag); ?>
                            </ul>
                            <!--<a id="a_show_all" href="javascript:listMore();">本类全部文章</a>-->
                        </section>
                        
                    </section>
                    
                </section>
                <!--//文章和文章列表//-->
                
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
	<script type="text/javascript">
	function loadMainArticle(v_id) {
		// get THE article
		$.ajax({
		url: "get_article.php",
	    type: "POST",
	    data: {'uid': v_id, 'from_page': 'recommend'},
	    dataType: "html",
	    success: function (data) {
	    	$("#main_article").html(data);
	    	window.scrollTo(0,0);
	     },
	    error: function(xhr, err) {
	//	            alert('Ajax request ' + err);
			}
		});  
		// get RELATED article
		/*
		$.ajax({
		url: "get_article_related.php",
	    type: "POST",
	    data: {'uid': v_id },
	    dataType: "html",
	    success: function (data) {
	    	$("#related_article").html(data);
	     },
	    error: function(xhr, err) {
	//	            alert('Ajax request ' + err);
			}
		});  
		*/
		$("a").click(function(){$(this).css('style="color:lightgreen"');});
	}   
	/*
	function listMore() {
		$("#article_list").load('rec_list.ajax.php?tag='+<?php echo($_tag); ?>);
//		$("#article_list").load('rec_list.ajax.php?tag=999');
		$("#a_show_all").hide();
	}
	*/
	</script>       
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
