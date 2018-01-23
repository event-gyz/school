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
				        	if(mysql_affected_rows() > 0) {
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
		        	if(mysql_affected_rows() > 0) {
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
        	<section class="ceanza">
                <form action="grow_diary.php" method="post" enctype="multipart/form-data">
                    <input hidden="" name="type" value="diary" />
        		<h4>成长日记</h4>
        		<ul class="form">
        			<li class="title-menu">
        				<p>标题：</p>
                        <input name="title" class="title" type="text" maxlength="20">
        			</li>
                    <li class="title-menu">
                        <p>日记类型：</p>
                        <a href="javascript: void(0)">请选择</a>
                        <input type="hidden" name="grow_diary_category_name">
                        <div class="title-list">
                            <ul>
                                <li class="checked">一般日记</li>
                                <li>宝宝出生喽</li>
                                <li>第一次打预防针</li>
                                <li>三朝礼</li>
                                <li>满月</li>
                                <li>第一次量身高</li>
                                <li>剃胎发</li>
                                <li>宝宝的第一个玩具</li>
                                <li>百日礼</li>
                                <li>收涎</li>
                                <li>戴长命锁</li>
                                <li>第一次吃副食品</li>
                                <li>第一次撑起上半身</li>
                                <li>第一次坐着</li>
                                <li>第一次向前爬行</li>
                                <li>第一次扶着物品站立</li>
                                <li>第一次扶着物品向前走动</li>
                                <li>满周岁（抓周）</li>
                                <li>第一次用杯子喝水</li>
                                <li>第一次不依靠搀扶会自己行走</li>
                                <li>把球举高往前丢</li>
                                <li>第一次自己脱裤子</li>
                                <li>学会自己拉拉链</li>
                                <li>学会往后跳</li>
                                <li>第一次过新年</li>
                                <li>第一次切蛋糕</li>
                                <li>学会自己洗手</li>
                                <li>第一次和新朋友一起玩</li>
                                <li>第一次自己吃饭</li>
                                <li>宝宝最喜欢的玩具</li>
                                <li>宝宝第一次盖的城堡</li>
                                <li>宝宝骑三轮车</li>
                                <li>第一次自己看书</li>
                                <li>幼稚园开学</li>
                                <li>第一次写作业</li>
                                <li>第一次亲子活动</li>
                                <li>第一次过圣诞节</li>
                                <li>第一次上台表演</li>
                                <li>第一次自己穿衣服</li>
                                <li>宝宝第一次画全家福</li>
                                <li>学会单脚站立</li>
                                <li>才艺课初体验</li>
                                <li>第一次运动会</li>
                                <li>学会自己刷牙</li>
                                <li>学会自己扣扣子</li>
                                <li>学会自己上厕所</li>
                                <li>完成八片以上的拼图</li>
                                <li>能够以单脚往前跳</li>
                                <li>幼稚园毕业典礼</li>
                            </ul>
                            <p class="close">×</p>
                        </div>
                    </li>
                    <li class="ceanza-detail"><p>内容：</p><textarea name="content" cols="60" rows="4" maxlength="100"></textarea></li>
        			<li>
        				<b class="clock"></b>
        				记录时间：
                        <input name="date" class="time" type="date" value="<?php echo date('Y-m-d',time())?>">
        			</li>
        			<li>
        				<b class="address"></b>
        				记录地址：
        				<input name="address"  class="address-input" type="text" value="">
        			</li>
        		</ul>
        		<ul class="uploadImgList">
        			<li class="uploadImg">
	        			<div class="imgContent">+</div>
	        			<input type="file" name="file"/>
        			</li>
        		</ul>
        		<button class="submit">提交</button>
                </form>
            </section>
        	<!-- InstanceEndEditable -->
        </section>
        <!--【Content End】-->
        
    </section>
    <?php include 'inc_bottom_js.php'; ?>
</body>
<!-- InstanceEnd --></html>
