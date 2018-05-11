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
			echo ('<script type="text/javascript"> $(function(){document.location.href ="http://x.eqxiu.com/s/PclsbuXT";});</script>');
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
		<section class="ceanza">
			<h4>成长记录</h4>
			<p>替您的宝宝写下成长日记，为您的宝宝记录每天的成长与回忆。</p>
			<button class="add_ceanza">新增成长日记<b></b></button>
			<div class="browse_mode">
				<p></p>
				<ul class="mode_sel">
					<li class="selected">
						<span>缩图</span>
						<b></b>
					</li>
					<li>
						<a href="ceanza_list.php"><span>列表</span></a>
						<b></b>
					</li>
				</ul>
			</div>
		</section>
		<div class="ceanza_list">
			<p>2015<span>1岁</span></p>
			<ul class="ceanza_contraction">
				<li class="selected">
					<p><img src="../content/epaper/images/contraction_01.png" alt=""><i></i></p>
					<span><b>宝宝出生咯</b></span>
				</li>
				<li>
					<p><img src="../content/epaper/images/contraction_02.png" alt=""><i></i></p>
					<span><b>第一次打预防针</b></span>

				</li>
				<li>
					<p><img src="../content/epaper/images/contraction_03.png" alt=""><i></i></p>
					<span><b>第一次量身高</b></span>
				</li>
			</ul>
		</div>
		<div class="ceanza_list">
			<p>2015<span>1岁</span></p>
			<ul class="ceanza_contraction">
				<li>
					<p><img src="../content/epaper/images/contraction_01.png" alt=""><i></i></p>
					<span><b>第一次坐着</b></span>
				</li>
				<li>
					<p><img src="../content/epaper/images/contraction_02.png" alt=""><i></i></p>
					<span><b>第一次用杯子喝水</b></span>

				</li>
				<li>
					<p><img src="../content/epaper/images/contraction_03.png" alt=""><i></i></p>
					<span><b>学会自己洗手</b></span>
				</li>
			</ul>
		</div>
		<p class='end_line'></p>
		<div class="relevant_articles">
			<h4>成长日记相关文章</h4>
			<ul>
				<li>让宝宝记住个人资讯</li>
				<li>让孩子为自己的行为负责</li>
				<li>让2-3岁的孩子学画画</li>
			</ul>
		</div>
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
