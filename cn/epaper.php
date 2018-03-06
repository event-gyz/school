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
                <section class="gopath"><a href="#">首页</a> > 当期电子报</section>
                <!--//主選單標題與路徑//-->
                
                <!--//電子報//-->
                <section class="paperbox">
                	
                    <!--//當期電子報//-->
                    <section id="paper_main" name="paper_main" class="paper-main clearfix">  
                    <?php
                    $sql = "select subject,pdf_name,pub_date from epaper  where date(pub_date) <= curdate() order by pub_date desc";
                    $result = M()->select($sql);
                    $issues = array();
                    if($result){
                        foreach($result as $row){
                            $issues[] = $row;
                        }
                    }

                    if(count($issues) > 0) {
                    	$pdf_name = $issues[0]["pdf_name"];
                    	$pub_date = $issues[0]["pub_date"];
                    	echo("<i>$pub_date</i>");
                    	echo('<h3 class="title">'.$issues[0]["subject"].'</h3>');
	                    echo("<div><embed src='loadpdf.php?f=$pdf_name' width=100% height=768px></embed><div>");
                    }
                    else {
	                    echo('没有资料');
                    }
                    ?>
                    </section>
                    
                    <!--//前期電子報//-->
                    <section id="paper_list" name="paper_list" class="shbox">
                    	<h2 class="title">所有电子报</h2>
                    	<?php
                    	if(count($issues) > 0) {
							echo('<select id="hist_papers" style="width:80%">');
							for($i = 0; $i < count($issues); $i++) {
								$sbj = $issues[$i]["subject"];//(mb_strlen($issues[$i]["subject"],"utf-8")<20?$issues[$i]["subject"]:(mb_substr($issues[$i]["subject"],0,20,"utf-8")."..."));
								
								$entry = $issues[$i]["pub_date"]." > ".$sbj;
								echo('<option value="'.$issues[$i]["pdf_name"].'">'.$entry.'</option>');
							}
	                        echo('</select>');	                    	
                    	}
                    	?>
                    </section>
                </section>
                <!--//電子報//-->
                <div align="center"><a href="sube.php"><?php if($_SESSION['user_epaper']) echo('退订电子报'); else echo('订阅电子报'); ?></a></div>
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
