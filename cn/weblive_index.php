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
                <h2 class="title">线上学习</h2>
                <section class="gopath"><a href="index.php">首页</a> > 线上学习</section>
                <!--//主選單標題與路徑//-->
                
                <!--//最新消息//-->
                <section class="newsbox masonry_weblive">
                </section>
                <div id="next">
                	<a href="weblive_list.php?p=2">&nbsp;</a>
                </div>
                <script>
				$(function(){
					$('.newsbox').infinitescroll({
						navSelector  	: "#next",
						nextSelector 	: "#next a",
						itemSelector 	: "li",
						loading: {
						  img: '../theme/cn/images/content/loading.gif',
						  msgText: '读取中...',
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
                
                <!--//回頂端//-->
				<section class="gotop bodytop pc"><img src="../theme/cn/images/content/item_gotop01.png">回顶端</section>
                
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
    <script type="text/javascript">
    $(function() { 
    	$(".newsbox").load("weblive_list.php?p=1",addItemListeners);
    });
    function addItemListeners() {
	    $("a[name='course']").click(function() {
	    	var course_id = $(this).attr('id');
	    	var param = { 'c' : course_id};		    		
	    	OpenWindowWithPost("weblive_fetch.php", "width='100%',height='100%',resizable=yes,scrollbars=no", "weblive", param);
	    	/*
    		$.ajax({
				url: "weblive_fetch.php",
			    type: "POST",
			    data: {'c': course_id},
			    dataType: "html",
			    success: function (data) {
			    	//$("#articlebox").attr('class', 'articlebox');
			    	//$("#articlebox").html(data);
			    	//$("#articlebox").fancybox().trigger('click');
			    	window.open(data);
			     },
			    error: function(xhr, err) {
				}
			});  
			*/
	    });
    }

    function OpenWindowWithPost(url, windowoption, name, params) {
            var form = document.createElement("form");
            form.setAttribute("method", "post");
            form.setAttribute("action", url);
            form.setAttribute("target", name);
 
            for (var i in params) {
                if (params.hasOwnProperty(i)) {
                    var input = document.createElement('input');
                    input.type = 'hidden';
                    input.name = i;
                    input.value = params[i];
                    form.appendChild(input);
                }
            }
 
            document.body.appendChild(form);
            window.open("post.htm", name, windowoption);
            form.submit();
            document.body.removeChild(form);
    }
    </script>
</body>
<!-- InstanceEnd --></html>
