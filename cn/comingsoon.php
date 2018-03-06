<?php
session_start(); 
include('inc.php');	

$title = $_GET['t'];
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
                <h2 class="title">即將開放</h2>
                <section class="gopath"><a href="index.php">首页</a> > 即將開放</section>
                <!--//主選單標題與路徑//-->
                
                <!--//敬請期待//-->
                <section class="i-cs">
                    <section class="Txt clearfix">
                        <p><img src="../theme/cn/images/content/item_cs.jpg"><br>敬请期待</p>
                    </section>
                </section>
                <!--//敬請期待//-->
                
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
<!-- InstanceEnd --></html>
