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
                <h2 class="title">当期电子报</h2>
                <section class="gopath"><a href="#">首頁</a> > 当期电子报</section>
                <!--//主選單標題與路徑//-->
                
                <!--//電子報//-->
                <section class="paperbox">
                	
                    <!--//當期電子報//-->
                    <section id="paper_main" name="paper_main" class="paper-main clearfix">  
                    <?php
                    $email = $_SESSION['user_email'];
                    if($_SESSION['user_epaper']) {
                    	$newval = 0;
	                    $message = '退订电子报';
                    }
	                else {
                    	$newval = 1;
	                    $message = '订阅电子报';
	                }
	                
                    $sql = "update member set epaper = '$newval' where email = '$email'";
                    $result = query($sql);
                    if(mysqli_affected_rows() > 0) {
	                    echo($message.'成功'); // 成功失败
	                    $_SESSION['user_epaper'] = $newval;
                    }
                    else {
	                    echo($message.'失败'); // 成功失败
                    }
                    ?>
                    </section>
                </section>
                <!--//電子報//-->
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
	    $(function(){
	    	$("#hist_papers").change(function(){
	    		$("#paper_main embed").remove();
	    		var ss = $("#hist_papers option:selected").text().split(" > ");
	    		$("#paper_main i").text(ss[0]);
	    		$("#paper_main h3").text(ss[1]);
	    		$("#paper_main").append("<embed src='loadpdf.php?f="+$(this).val()+"' width=100% height=768px></embed>");
		    	//$("embed").src("loadpdf.php?f="+$(this).val());
	    	});
	    });
	</script>
</body>
<!-- InstanceEnd --></html>
