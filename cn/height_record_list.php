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
        	<section class="height_record">
        		<h4>身高记录</h4>
        		<p>您可以在这里看到宝宝的身高改变曲线，当宝宝的身高落于有顏色的区域，这代表着符合世界卫生组织(WHO)儿童身高区间，也就是身高落于大部分儿童身高族群之间。</p>
        		<a href="height_record_add.php" class="add_height_record">新增身高/体重记录<b></b></a>
        		<div class="browse_mode">
        			<p></p>
        			<ul class="mode_sel">
        				<li>
        					<span>图标</span>
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
            <div class="height_record_contraction">
                
            </div>
			<?php
			if(isset($_SESSION['user_token'])) {
				$member_uid = $_SESSION["CURRENT_KID_UID"];
				$sql = "select * from wap_height where uid in (select supervisor_uid from user where uid={$member_uid}) order by id desc";
				$list = M()->select($sql);
				$url = base64_encode($_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']);
			}
			?>
            <!-- 列表 -->
        	<div class="height_record_list">
    			<div class="title">
    				<p>
    					<span>照片</span>
    					<span>日期</span>
                        <span>身高（cm）</span>
    				</p>
    				<ul class="list">
						<?php foreach($list as $value){ ?>
    					<li>
    						<p><i><a href="#"><img src=<?php echo $value['picurl']?> alt=""></a></i></p>
    						<p><?php echo date('Y年m月d日',strtotime($value['date']))?></p>
    						<p><?php echo $value['height']?></p>
    					</li>
							<li>
								<p><b class="eqit"></b><span><a href="height_record_eqit.php?id=<?= $value['id']?>">编辑</a></span></p>
								<p><b class="delete"></b>
									<span>
									<a href="height_record.php?id=<?= $value['id']?>&type=delete&back=<?=$url?>">删除</a>
								</span>
								</p>

							</li>
						<?php }?>

    				</ul>
    			</div>
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
        
    </section>
    <?php include 'inc_bottom_js.php'; ?>
</body>
<!-- InstanceEnd --></html>
