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
        	<section class="weight_record">
        		<h4>体重日记</h4>
        		<p>您可以在这里看到宝宝的体重改变曲线，有颜色的区域是世界卫生组织(WHO)所统计全世界儿童的平均体重区间，当宝宝的体重落于其间则表示正常，如果超出这份区域，则表示过胖或过瘦。</p>
        		<a href="weight_record_add.php" class="add_weight_record">新增体重记录<b></b></a>
        		<div class="browse_mode">
        			<p></p>
        			<ul class="mode_sel">
        				<li>
        					<span>缩图</span>
        					<b></b>
        				</li>
        				<li class="selected">
        					<span>列表</span>
        					<b></b>
        				</li>
        			</ul>
        		</div>
        	</section>
            <!-- 缩图图表 -->
            <div class="weight_record_contraction" style="display:none">
                
            </div>
			<?php
			if(isset($_SESSION['user_token'])) {
				$member_uid = $_SESSION["CURRENT_KID_UID"];
				$sql = "select * from wap_weight where uid in (select supervisor_uid from user where uid={$member_uid}) order by id desc";
				$list = M()->select($sql);
				$url = base64_encode($_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']);
			}
			?>
            <!-- 列表 -->
        	<div class="weight_record_list">
    			<div class="title">
    				<p>
    					<span>照片</span>
    					<span>日期</span>
                        <span>体重（kg）</span>
    				</p>
    				<ul class="list">
						<?php foreach($list as $value){ ?>
    					<li>
    						<p><i><a href="#"><img src=<?php echo $value['picurl']?> alt=""></a></i></p>
    						<p><?php echo date('Y年m月d日',strtotime($value['date']))?></p>
    						<p><?php echo $value['weight']?></p>
    					</li>

						<li>
							<p><b class="eqit"></b><span><a href="weight_record_eqit.php?id=<?= $value['id']?>">编辑</a></span></p>
							<p><b class="delete"></b>
								<span>
								<a href="weight_record.php?id=<?= $value['id']?>&type=delete&back=<?=$url?>">删除</a>
							</span>
							</p>

						</li>

						<?php }?>
    				</ul>
    			</div>
    		</div>
    		<p class='end_line'></p>
    		<div class="relevant_articles">
    			<h4>体重日记相关文章</h4>
				<ul>
					<?php af_articles_list_recommend('体重'); ?>
				</ul>
    		</div>
        	<!-- InstanceEndEditable -->   
        </section>
        <!--【Content End】-->
        
    </section>
    <?php include 'inc_bottom_js.php'; ?>
</body>
<!-- InstanceEnd --></html>
