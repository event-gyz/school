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
        	<section class="ceanza">
        		<h4>就诊记录</h4>
        		<p>每笔就诊记录都是日后珍贵的就医参考，同时也能了解宝宝的免疫能力与健康状态。</p>
        		<a href="medical_record_add.php" class="add_consultation">新增就诊记录<b></b></a>
                <a href="medical_institution_add.php" class="add_medical_institution">新增常用医疗机构<b></b></a>
        	</section>
        	<div class="consultation_list">
    			<p>就诊记录</p>
<!--				--><?php //af_index_list_recommend(); ?>
				<?php
//				$sql_medical_list = "select * from grow_medical_records where uid=".$CMEMBER->getUserId();
				$sql_medical_list = "select * from grow_medical_records where uid=".$CMEMBER->getUserId();
				$result = query($sql_medical_list);

				?>
    			<ul class="consultation_detail">
    				<li>
    					<p>就诊日期：</p>
    					<span>2017年11月21日</span>
    					<ul class="operation">
    						<li>
    							<p class="eqit"></p>
    							<span>编辑</span>
    						</li>
    						<li>
    							<p class="delete"></p>
    							<span>删除</span>
    						</li>
    					</ul>
    				</li>
    				<li>
    					<p>医院：</p>
    					<span>北京同仁医院</span>
    				</li>
    				<li>
    					<p>医生：</p>
    					<span>李明 医生</span>
    				</li>
    				<li>
    					<p>诊断：</p>
    					<span>牙齿发炎</span>
    				</li>
    				<li>
    					<p>医生叮嘱：</p>
    					<span>吃消炎药，不能吃甜食，多喝水</span>
    				</li>
    			</ul>
    		</div>
			<?php

			if(isset($_SESSION['user_token'])) {
				$member_uid = $_SESSION["CURRENT_KID_UID"];
				$sql = "select * from wap_medical where uid in (select supervisor_uid from user where uid={$member_uid}) order by id desc";
				$list = M()->select($sql);
			}
			?>
    		<div class="medical_institution_list">
    			<p>常用医疗机构</p>
    			<ul class="medical_institution_detail">
					<?php foreach($list as $value){?>
    				<li>
    					<p>医院：</p>
    					<span><?= $value['hospital']?></span>
    					<ul class="operation">
    						<li>
    							<p class="eqit"></p>
    							<span><a href="medical_institution_eqit.php?id=<?= $value['id']?>">编辑</a></span>
    						</li>
    						<li>
    							<p class="delete"></p>
    							<span><a href="medical_institution.php?id=<?= $value['id']?>&type=delete">删除</a></span>
    						</li>
    					</ul>
    				</li>
    				<li>
    					<p>医生：</p>
    					<span><?= $value['doctor_name']?></span>
    				</li>
    				<li>
    					<p>地址：</p>
    					<span><?= $value['address']?></span>
    				</li>
    				<li>
    					<p>电话：</p>
    					<span><?= $value['doctor_phone']?></span>
    				</li>
					<?php }?>
    			</ul>
    		</div>
        	<!-- InstanceEndEditable -->   
        </section>
        <!--【Content End】-->
        
    </section>
    <?php include 'inc_bottom_js.php'; ?>
</body>
<!-- InstanceEnd --></html>
