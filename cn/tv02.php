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
                <h2 class="title">电视问答</h2>
                <section class="gopath"><a href="#">首頁</a> > 电视问答</section>
                <!--//主選單標題與路徑//-->
                
                <!--//電視問答//-->
                <section class="tvbox">
                    
                    <!--//文字編輯器區//-->
                    <section class="Txt clearfix">
                    	
                    	<?php
	                    	$sql = "SELECT * FROM tvqa WHERE DATE(pub_date)='".date('Y-m-d')."'"; // replace DATE(NOW()) to prevenet server timezone differences
	                    	$result = query($sql);
	                    	$question = "";
	                    	$img = 'ig10_txt.jpg';
	                    	$ans1 = "";
	                    	$ans2 = "";
	                    	$ans3 = "";
	                    	if($row=mysqli_fetch_array($result)) {
	                    		$uid = $row['uid'];
		                    	$question = $row['question'];
		                    	if(!empty($row['image'])) {
		                    		$img = $row['image'];
		                    	}		                    	
	                    		$ans1 = $row['answer1'];
	                    		$ans2 = $row['answer2'];
	                    		$ans3 = $row['answer3'];
		                    	echo('<h3 class="title">今天的题目是：</h3>');
		                    	echo('<p>'.$question.'</p>');	
	                    	}
	                    	else {
		                    	echo('<h3 class="title">今天还没有题目...</h3>');
	                    	}
	                    	echo('<p align="center"><img src="../theme/cn/images/content/img/'.$img.'"></p>');
                    	?>
                    </section>
                    
                    <!--//作答區//-->
                    <section class="ansbox clearfix">
                    <?php
                    	if(strlen($question) > 0) {
	                    	?>
	                    	<form name="anser_form" action="tv_submit.php" method="post">
	                    	<section class="lbox">
	                        	<h3 class="title">我觉得答案是：</h3>
	                            <section class="formbox">
	                            	<div class="fbar"><label><input type="radio" name="p2" value="1" checked="true"><b>1</b><span><?php echo($ans1); ?></span></label></div>
	                                <div class="fbar"><label><input type="radio" name="p2" value="2"><b>2</b><span><?php echo($ans2); ?></span></label></div>
	                                <div class="fbar"><label><input type="radio" name="p2" value="3"><b>3</b><span><?php echo($ans3); ?></span></label></div>
	                            </section>
	                        </section>
	                        <section class="rbox">
	                        	<?php
	                        		echo('<input type="hidden" id="p1" name="p1" value="'.$uid.'" />');
	                        		if(isset($_SESSION['user_token'])) {
	                        			$member_uid = $CMEMBER->accessFromToken($_SESSION['user_token']);
	                        		}
	                    			if($member_uid > 0) {
		                    			echo('<h3 class="title">您的电子邮件：</h3>');
	                        			$CMEMBER->getUserInfo();
										echo('<div class="fbar"><input name="p3" type="text" value="'.$CMEMBER->email.'" class="tf" readonly></div>');	                        
	                    			}	
	                    			else {
		                    			echo('<h3 class="title">填写电子邮件：</h3>');
		                    			echo('<div class="fbar clearfix"><input name="p3" type="text" class="tf"><div class="errorbar">请填写正确的Email</div></div>');                            
		                    			echo('<p>- 请填写正确的Email。<br>- 若您已是会员，请填写您的注册帐号。</p>');
	                    			}
	                        	?>                            
	                           	<input type="submit" class="btn_submit01" value="">
	                        </section>
	                        </form>	                    	
	                    	<?php
                    	}
                    ?>

                        <section class="bbox">
                            <h3 class="title">活动规约：</h3>
                            <section class="Txt clearfix">
                                <ol>
		                         	<li>只有登入为正式会员后，才能参加此有奖征答</li>
		                            <li>得奖者将于「隔周」统一公告在得奖名单内，并由本学园以电邮方式通知得奖会员</li>
		                            <li>没得奖的粉丝们也不要灰心，即日起每周X晚上X点都会有「有奖征答抽奖活动」，并且持续X个月</li>
                                </ol>
                            </section>
                        </section>
                    </section>
                    
                </section>
                <!--//電視問答//-->
                
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
