<?php
session_start();
include('inc.php');
?>
<!DOCTYPE html>
<html><!-- InstanceBegin template="/Templates/_page01.dwt" codeOutsideHTMLIsLocked="false" -->
<head>
	<?php include('inc_head.php');	?>
	<link rel="stylesheet" href="../theme/cn/jquery.cxcalendar.css">
	<script src="../scripts/megapix/megapix-image.js"></script>
	<script src="../scripts/jquery.cxcalendar.js"></script>
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
		<section class="height_record">
			<form action="height_record.php" method="post" enctype="multipart/form-data">
				<input hidden="" name="type" value="diary" />
				<h4>新增身高记录</h4>
				<ul class="form">
					<li><p>身高（公分）：</p><input name="height" type="text" maxlength="20"></li>
					<li>
						<b class="clock"></b>
						记录时间：
						<input class="time date_a"  name="date" type="text" data-position='bottomLeft' readonly x-webkit-speech="none" value="<?php echo date('Y-m-d',time())?>">
					</li>
				</ul>
				<ul class="uploadImgList">
					<li class="uploadImg">
						<div class="imgContent">+</div>
						<input type="file" name="file" accept="image/png,image/jpg,image/jpeg"/>
						<!-- <div class="camera_photograph">
                        <p><img src="../content/epaper/images/camera.png" alt=""></p>
                        <input type="file" class="camera_input" name="myPhoto" capture="camera" accept="image/*"/>
                    </div> -->
					</li>
				</ul>
				<!-- <p class="uploadDemand">(上传图片档案大小不得超过3MB)</p> -->
				<button class="submit">提交</button>
			</form>
		</section>
		<!-- InstanceEndEditable -->
	</section>
	<!--【Content End】-->
	<!--【Footer】-->
	<?php include 'inc_footer.html'; ?>
	<!--【Footer End】-->

</section>
<?php include 'inc_bottom_js.php'; ?>
<script>
	// 限制可选日期
	$('.date_a').cxCalendar({
		type: 'date',
		format: 'YYYY-MM-DD',
		wday: 0,
		endDate: new Date().getFullYear() + '-' + (new Date().getMonth() + 1) + '-' + new Date().getDate()
	});
</script>
</body>
<!-- InstanceEnd --></html>
