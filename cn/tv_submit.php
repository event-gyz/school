<?php
session_start(); 
include('inc.php');	

$question_uid = $_POST['p1'];
$answer_id = $_POST['p2'];
$email = $_POST['p3'];

if(!isset($question_uid) && isset($_SESSION['question_uid']))
	$question_uid = $_SESSION['question_uid'];
if(!isset($answer_id) && isset($_SESSION['answer_id']))
	$answer_id = $_SESSION['answer_id'];
if(!isset($email) && isset($_SESSION['user_email']))
	$email = $_SESSION['user_email'];

if(!isset($answer_id) || !isset($question_uid) || !isset($email)) {
//echo('aaaa');
	header("Location: index.php");
	exit();
//	die('<script>window.location.href="index.php"</script>');
}
else {
	// keep user answer for later usage
	$_SESSION['question_uid'] = $question_uid;
	$_SESSION['answer_id'] = $answer_id;
	// check if logged in
	if(isset($_SESSION['user_token'])) {
		$member_uid = $CMEMBER->accessFromToken($_SESSION['user_token']);
	}
	if($member_uid > 0) {
		$CMEMBER->getUserInfo();
		if($CMEMBER->email == $email) {
			// submit score if not already today
			$sql = "SELECT uid FROM tvqa_attend WHERE member_uid='$member_uid' AND DATE(att_date)=DATE(NOW())";
			$result = query($sql);
			if(mysqli_num_rows($result) > 0) {
				$next_step = 0; // Already attended!
			}
			else {
				$sql = "INSERT INTO tvqa_attend (member_uid,qa_uid,ans_id) VALUES ('$member_uid','$question_uid','$answer_id')";		
				$result = query($sql);
				if(mysqli_affected_rows() == 0)
					$next_step = -1; // failed for some reason
				else {
					// check answer
					$next_step = 2; // default assume wrong
					$sql = "SELECT answer_id FROM tvqa WHERE uid='$question_uid'";
					$result = query($sql);
					if($row = mysqli_fetch_array($result)) {
						$correct_answer = $row['answer_id'];
						if($correct_answer == $answer_id) 
							$next_step = 1; // CORRECT
					}
				}
			}
			unset($_SESSION['question_uid']);
			unset($_SESSION['answer_id']);
		}
		else {
			// incompatible access token v. email
			// TODO logout user
		}
	}
	if(!isset($next_step)) {
		// if email exists, show login form
		if($CMEMBER->exist($email)) {
			$next_step = 3; 
		}
		// else, show register form
		else {
			$next_step = 4;
		}
	}
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
    
		<script type="text/javascript">
		$(function(){
		<?php
		if($next_step == 3) {
			echo('$("#login_id").val("'.$email.'");');
			echo('$.fancybox({href: "#fy-login"});');
			$b_post_tv_submit = true;
		}
		elseif($next_step == 4) {
			echo('$("#reg_email").val("'.$email.'");');
			echo('$.fancybox({href: "#fy-register"});');
			$b_post_tv_submit = true;
		}
		?>
		});
		</script>    
        
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
                <section class="gopath"><a href="#">首页</a> > 电视问答</section>
                <!--//主選單標題與路徑//-->
                
                <!--//電視問答//-->
                <section class="tvbox">
                    
                    <!--//文圖區//-->
                    <section class="endbox">
<?php
						if($next_step == -1) {
						// submit error
							echo('<h3 class="title">Database Error</h3><p>'.mysql_error());				
						}
						elseif($next_step == 0) {
							echo('<h3 class="title">您今天已经参加过活动，欢迎明天再来！</h3><p align="center"><img src="../theme/cn/images/content/item_n.jpg"></p><section class="btnbox clearfix"><a href="winlist.php" class="btn01"><i><img src="../theme/cn/images/content/icon_btn04.png"></i><span>看中奖名单</span></a><a href="index.php" class="btn01"><i><img src="../theme/cn/images/content/icon_btn05.png"></i><span>更多有趣内容</span></a></section>');
						}
						elseif($next_step == 1) {
?>
                    	<h3 class="title">恭喜您！答对啰！</h3>
                        <p align="center"><img src="../theme/cn/images/content/item_y.jpg"></p>
                        <section class="btnbox clearfix">
                            <a href="winlist.php" class="btn01"><i><img src="../theme/cn/images/content/icon_btn04.png"></i><span>看中奖名单</span></a>
                            <a href="index.php" class="btn01"><i><img src="../theme/cn/images/content/icon_btn05.png"></i><span>更多有趣内容</span></a>
                        </section>
<?php
						}
						elseif($next_step == 2) {
?>
                    	<h3 class="title">答错啰！下次加油喔</h3>
                        <p align="center"><img src="../theme/cn/images/content/item_n.jpg"></p>
                        <section class="btnbox clearfix">
                            <a href="winlist.php" class="btn01"><i><img src="../theme/cn/images/content/icon_btn04.png"></i><span>看中奖名单</span></a>
                            <a href="index.php" class="btn01"><i><img src="../theme/cn/images/content/icon_btn01.png"></i><span>更多有趣内容</span></a>
                        </section>
<?php
						}
						elseif($next_step == 3) {
							echo('<h3 class="title">登入後將顯示答題結果</h3>');				
						}
						elseif($next_step == 4) {
							echo('<h3 class="title">注册后将显示答题结果</h3>');				
						}
?>                    
                    </section>
                    
                    <!--//活動規約//-->
                    <section class="bbox">
                        <h3 class="title">活动规约：</h3>
                        <section class="Txt clearfix">
                            <ol>
                                <li>他们呼吁全球彻底审查监管措施以保护儿童的大脑。</li>
                                <li>格兰简博士说我们从中毒的成年患者的临床资料中了解到，这些化学物质通过血脑屏障进入大脑</li>
                                <li>能引起神经系统症状。当这种情况发生在儿童或怀孕期间</li>
                                <li>这些化学品有剧毒，因为我们现在知道发育中的大脑是一个</li>
                                <li>尤为脆弱的器官，而且后果是永久性的。</li>
                            </ol>
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
