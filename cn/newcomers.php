<?php
session_start(); 
include('inc.php');	
?>
<!DOCTYPE html> 
<html><!-- InstanceBegin template="/Templates/_page01.dwt" codeOutsideHTMLIsLocked="false" -->
<head>
	<?php include('inc_head.php');	?>
	<style>
		body{background: none;}
		h1,h2,h3,h4,h5,h6,p,ul,li,dl,dt,dd{margin:0;padding:0;list-style: none;}
		input,button{padding: 0;margin:0;border:0;outline: none;}
		img{vertical-align: bottom}
	</style>
</head>
<body>                         
        <?php
        	$payload=@$_GET['t'];
        	if(isset($payload)) {
	        	$dec_string = my_decrypt($payload);
	        	$params = explode("|",$dec_string);
	        	$action = $params[0];
	        	$goodlink = false;
	        	if($action == "resetpw") {
		        	$link_date = $params[1];
		        	$ver_code = $params[2];
		        	$token = $params[3];
		        	$date1 = new DateTime();
		        	$date2 = new DateTime($link_date);
		        	$interval = $date1->diff($date2);
		        	if($interval->days == 0) {
			        	$member_uid = $CMEMBER->accessFromToken($token);
			        	$CMEMBER->getUserInfo();
			        	if($member_uid > 0) {
			        		// check if the link is already used
				        	$sql = "UPDATE reset_password SET status=1,act_datetime=now() WHERE member_id='".$CMEMBER->id."' AND code='$ver_code' AND status=0";
				        	$result = query($sql);
				        	if(mysqli_affected_rows() > 0) {
			        		// login for now
					        	$_SESSION['user_token'] = $token;
					        	$_SESSION['user_email'] = $CMEMBER->email;
					        	$_SESSION['user_credit'] = $CMEMBER->credit;
					        	$_SESSION['user_epaper'] = $CMEMBER->epaper;
					        	$goodlink = true;
					        	echo('<script type="text/javascript">$(function(){$.fancybox({        href: "#fcb_pw_reset"    }	);});</script>');
					        }
			        	}
		        	}
		        	if(!$goodlink) {
			        	// expired
			        	echo('
						<script type="text/javascript"> 
							$(function(){
								$("#wrap").attr("class","inpage");
								$("#content").load("fg_nouse_content.html");
							});
						</script>						
						');
		        	}
	        	}
	        	else if($action == 'verify') {
		        	$member_id = $params[1];
		        	$ver_code = $params[2];
		        	$sql = "UPDATE reg_verify SET status='1',act_datetime=now() WHERE member_id='$member_id' AND ver_code='$ver_code' AND status=0";
		        	$result = query($sql);
		        	if(mysqli_affected_rows() > 0) {
			        	echo ('<script type="text/javascript"> 
			        			$(function(){
			        				$("#regwork").fancybox().trigger("click");
			        			});</script>
			        		');	
		        	}
		        	else {
		        	// TODO error handling
		        	}
	        	}
	        	else if($action == 'epaper' || $action == 'train') {
		        	$member_id = $params[1];
		        	$token = $params[2];
		        	$member_uid = $CMEMBER->accessFromToken($token);
		        	if($member_uid > 0) {
			        	$CMEMBER->getUserInfo();
			        	$_SESSION['user_token'] = $token;
			        	$_SESSION['user_email'] = $CMEMBER->email;
			        	$_SESSION['user_credit'] = $CMEMBER->credit;
			        	$_SESSION['user_epaper'] = $CMEMBER->epaper;
			        	if($action == 'epaper') {
				        	echo ('<script type="text/javascript"> $(function(){document.location.href ="epaper.php";});</script>');	
			        	}
				        else {
				        	echo ('<script type="text/javascript"> $(function(){document.location.href ="training.php";});</script>');	
				        }
			        }
	        	}	        	
        	}
        ?>
	<!-- InstanceBeginEditable name="wrap" -->
	<section id="wrap">
    <!-- InstanceEndEditable -->
    
    	<!--【Header】-->
    	<?php include 'inc_header.php'; ?>
        <!--【Header End】-->

        <!--【Content】-->
        <section id="content">
        <!-- InstanceBeginEditable name="content" -->

        <!--//主內容//-->
            <section class="indexcont newcomers">
                <section class="inbox noBoxShadowPage">
                    <section class="contbox clearfix">

                        <!--//主選單標題與路徑//-->
                        <h2 class="title">新手上路</h2>
                        <section class="gopath"><a href="index.php">首页</a> > 新手上路</section>
                        <p><img src="../content/epaper/images/newcomers_logo.jpg" alt=""></p>
                        <!--//主選單標題與路徑//-->

                        <dl class="newcomers_guide">
                            <dt>
                                <i></i>
                                <p>为什么要记录宝宝的成长？</p>
                            </dt>
                            <dd>
                                <p>很久之前，我们几乎把体重当成衡量宝宝发育是否良好的唯一标准。 </p>
                                <p>很久之前，我们宝宝长得好不好，几乎是跟别人家的孩子“比”出 来的。</p>
                                <p>很久之前，我们都习惯把身高记在门框上。</p>
                                <p>我们衡量、比较、记录。</p>
                                <p>我们希望知道宝宝的健康状态，希望留下这些承载着宝宝成长发育的珍贵数字，希望在宝宝发育出现偏差的时候，可以准确地为医生提供一些有价值的信息以供参考。</p>
                                <p>测量生长发育曲线的意义</p>
                                <p>通过记录和绘制生长发育曲线，我们可以清楚的了解在同龄儿童中，我们宝宝所处的位置，客观的了解宝宝到底“长得好不好”。</p>
                                <p>对于早产儿、低体重儿，可以评估宝宝生长追赶的情况。</p>
                                <p>短期来看，曲线能够敏感的反应出宝宝是否得到了充足的饮食和合理照料。</p>
                                <p>长远来看，通过监测生长发育曲线的轨迹，我们可以评估甚至预测宝宝的生长发育趋势，及时发现生长轨迹偏离正常水平的情况，明确宝宝生长减缓的原因。</p>
                            </dd>
                            <dt>
                                <i></i>
                                <p>如何测量宝宝的身高体重？</p>
                            </dt>
                            <dd>
                                <p>很久之前，我们几乎把体重当成衡量宝宝发育是否良好的唯一标准。 </p>
                                <p>很久之前，我们宝宝长得好不好，几乎是跟别人家的孩子“比”出 来的。</p>
                                <p>很久之前，我们都习惯把身高记在门框上。</p>
                                <p>我们衡量、比较、记录。</p>
                                <p>我们希望知道宝宝的健康状态，希望留下这些承载着宝宝成长发育的珍贵数字，希望在宝宝发育出现偏差的时候，可以准确地为医生提供一些有价值的信息以供参考。</p>
                                <p>测量生长发育曲线的意义</p>
                                <p>通过记录和绘制生长发育曲线，我们可以清楚的了解在同龄儿童中，我们宝宝所处的位置，客观的了解宝宝到底“长得好不好”。</p>
                                <p>对于早产儿、低体重儿，可以评估宝宝生长追赶的情况。</p>
                                <p>短期来看，曲线能够敏感的反应出宝宝是否得到了充足的饮食和合理照料。</p>
                                <p>长远来看，通过监测生长发育曲线的轨迹，我们可以评估甚至预测宝宝的生长发育趋势，及时发现生长轨迹偏离正常水平的情况，明确宝宝生长减缓的原因。</p>
                            </dd>
                            <dt>
                                <i></i>
                                <p>如何分析曲线图？</p>
                            </dt>
                            <dd>
                                <p>很久之前，我们几乎把体重当成衡量宝宝发育是否良好的唯一标准。 </p>
                                <p>很久之前，我们宝宝长得好不好，几乎是跟别人家的孩子“比”出 来的。</p>
                                <p>很久之前，我们都习惯把身高记在门框上。</p>
                                <p>我们衡量、比较、记录。</p>
                                <p>我们希望知道宝宝的健康状态，希望留下这些承载着宝宝成长发育的珍贵数字，希望在宝宝发育出现偏差的时候，可以准确地为医生提供一些有价值的信息以供参考。</p>
                                <p>测量生长发育曲线的意义</p>
                                <p>通过记录和绘制生长发育曲线，我们可以清楚的了解在同龄儿童中，我们宝宝所处的位置，客观的了解宝宝到底“长得好不好”。</p>
                                <p>对于早产儿、低体重儿，可以评估宝宝生长追赶的情况。</p>
                                <p>短期来看，曲线能够敏感的反应出宝宝是否得到了充足的饮食和合理照料。</p>
                                <p>长远来看，通过监测生长发育曲线的轨迹，我们可以评估甚至预测宝宝的生长发育趋势，及时发现生长轨迹偏离正常水平的情况，明确宝宝生长减缓的原因。</p>
                            </dd>
                        </dl>

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
    <script>
    	$(".newcomers_guide dt").on("click",function () {
            $('.newcomers_guide dd').stop();
            $(this).siblings("dt").removeAttr("id");
            if($(this).attr("id")=="open"){
                $(this).removeAttr("id").siblings("dd").slideUp();
                $(this).children('i').removeClass('active')
                $(this).css('borderBottom','1px solid #E3E3E3')
                $(this).siblings("dd").css('border','none')
            }else{
                $(this).attr("id","open").next().slideDown().siblings("dd").slideUp();
                $('.newcomers_guide dt i').removeClass('active')
                $(this).children('i').addClass('active')
                $('.newcomers_guide dt').css('borderBottom','1px solid #E3E3E3')
                $(this).css('border','none')
                $(this).siblings("dd").css('borderBottom','1px solid #E3E3E3')
            }
        });
    </script>
</body>
<!-- InstanceEnd --></html>
