<?php
session_start(); 
include('inc.php');	

$tabon = $_REQUEST['f'];
if(!isset($tabon))
	$tabon = 0;
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
                <h2 class="title">成长报告</h2>
                <section class="gopath"><a href="index.php">首頁</a> > 成长报告</section>
                <!--//主選單標題與路徑//-->
                
                <!--//成長報告//-->
                <section class="repbox">
                    
                    <!--//成長報告列表//-->
                    <section class="replist">
                    	<section class="tab-hd">
                        	<ul class="clearfix">
                            	<li <?php if($tabon== 0) echo('class="on"'); ?>><a id="a_tab01" href="#tab01">成长指标</a></li>
                                <li <?php if($tabon > 0) echo('class="on"'); ?>><a id="a_tab02" href="#tab02">基本资料</a></li>
                            </ul>
                        </section>
                        <section class="tab-bd">
                        
                        	<!--//雷達曲線圖//-->
                        	<div id="tab01" class="tabcont <?php if($tabon==0) echo('on'); ?>">
                            	<section id="report01" name="report01" class="repwrap clearfix">
                                </section>
                            </div>
                            
                            <!--//基本資料//-->
                        	<div id="tab02" class="tabcont  <?php if($tabon==1) echo('on'); ?>">
                            	<section id="report02" name="report02" class="repwrap clearfix">
                                </section>
                            </div>
                        </section>
                    </section>
                    
                    <!--//待完成項目與看總表//-->
                    <section class="repinfo clearfix">
                    	<section class="repother">
                        	<h3 class="title">待完成项目：</h3>
                            <ul class="clearfix">
                            <?php
	                            $user_age = $_SESSION['CURRENT_KID_AGE'];
	                            $user_uid = $_SESSION['CURRENT_KID_UID'];
//	                            $sql = "select text from grow_index where age_max < '$user_age' and uid not in (select item_uid from grow_log where user_uid='$user_uid') limit 10";
$sql = "select text from grow_index where (age_min <= '$user_age' and age_max >= '$user_age') and uid not in (select item_uid from grow_log where user_uid='$user_uid') limit 10";

	                            $result = query($sql);
	                            while($row=mysqli_fetch_array($result)) {
	                            	echo('<li>'.$row["text"].'</li>');
	                            }       
                            ?>
                                <li class="last"><a href="itemlist.php?f=b">看全部项目...</a></li>
                            </ul>
                        </section>
                        <section class="btnbox clearfix">
                            <a href="itemlist.php" class="btn01"><i><img src="../theme/cn/images/content/icon_btn09.png"></i><span>去看看總表</span></a>
                        </section>
                    </section>
                    
                </section>
                <!--//成長報告//-->
                
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
    <?php include 'inc_bottom_js.php'; ?>
</body>
<script type="text/javascript">
    $(function() {
    	$("#a_tab01").click(function() {
    		$(".repinfo").show();
    		reloadTab01();
    	});
    	$("#a_tab02").click(function() {
    		$(".repinfo").hide();
    	});
		$("#report01").load("div_report_tab01.php");    	
		$("#report02").load("div_report_tab02.php");
    	<?php 
    		if($tabon > 0) {
    			echo('$(".repinfo").hide();'); 
    		}
    		if($tabon == 2) // 直接進入填寫資料
    		{
    			echo('$.fancybox({        href: "#fy-modify"    });');
    		}
    	?>
    });
    function reloadTab01() { 
		$("#report01").load("div_report_tab01.php");
    }
</script>
<!-- InstanceEnd --></html>
