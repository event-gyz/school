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
			<?php
			$_token = $_SESSION['user_token'];
			$supervisor_uid = $CMEMBER->accessFromToken($_token);
			$sql = "select * from wap_buds where uid=$supervisor_uid";
			$re = M()->select($sql);
			if($re){
				$buds_type = array_column($re,'buds_type');
				$dates = array_column($re,'date');
				$buds = array_combine($buds_type,$dates);
			}
//			name="a" value="<?= isset($buds['a'])?$buds['a']:'';?>"
			?>
        <!-- InstanceBeginEditable name="content" -->
        	<section class="buds_record">
        		<h4>萌芽记录</h4>
        		<p>记录您宝宝牙齿的成长时间，能够更了解您宝宝在营养吸收和生长发育的健康状态！</p>
        		<div class="model_diagram">
        			<div class="model_diagram_top">
        				<ul class="model_diagram_left">
        					<li>
        						<p>a <span>中门齿（8-12月）</span></p>
        						<input type="text">
        					</li>
        					<li>
        						<p>b <span>侧门齿（9-13月）</span></p>
        						<input type="text">
        					</li>
        					<li>
        						<p>c <span>乳犬齿（16-22月）</span></p>
        						<input type="text">
        					</li>
        					<li>
        						<p>d <span>第一乳臼齿（13-19月）</span></p>
        						<input type="text">
        					</li>
        					<li>
        						<p>e <span>第二乳臼齿（25-33月）</span></p>
        						<input type="text">
        					</li>
        				</ul>
        				<p><img src="../content/epaper/images/buds_top.png" alt=""></p>
        				<ul class="model_diagram_right">
        					<li>
        						<p>k <span>中门齿（8-12月）</span></p>
        						<input type="text">
        					</li>
        					<li>
        						<p>l <span>侧门齿（9-13月）</span></p>
        						<input type="text">
        					</li>
        					<li>
        						<p>m <span>乳犬齿（16-22月）</span></p>
        						<input type="text">
        					</li>
        					<li>
        						<p>n <span>第一乳臼齿（13-19月）</span></p>
        						<input type="text">
        					</li>
        					<li>
        						<p>o <span>第二乳臼齿（25-33月）</span></p>
        						<input type="text">
        					</li>
        				</ul>
        			</div>
        			<div class="model_diagram_bottom">
        				<ul class="model_diagram_left">
        					<li>
        						<p>f <span>第二乳臼齿（23-31月）</span></p>
        						<input type="text">
        					</li>
        					<li>
        						<p>g <span>第一乳臼齿（14-18月）</span></p>
        						<input type="text">
        					</li>
        					<li>
        						<p>h <span>乳犬齿（17-23月）</span></p>
        						<input type="text">
        					</li>
        					<li>
        						<p>i <span>侧门齿（10-16月）</span></p>
        						<input type="text">
        					</li>
        					<li>
        						<p>j <span>中门齿（6-10月）</span></p>
        						<input type="text">
        					</li>
        				</ul>
        				<p><img src="../content/epaper/images/buds_bottom.png" alt=""></p>
        				<ul class="model_diagram_right">
        					<li>
        						<p>p <span>第二乳臼齿（23-31月）</span></p>
        						<input type="text">
        					</li>
        					<li>
        						<p>q <span>第一乳臼齿（14-18月）</span></p>
        						<input type="text">
        					</li>
        					<li>
        						<p>r <span>乳犬齿（17-23月）</span></p>
        						<input type="text">
        					</li>
        					<li>
        						<p>s <span>侧门齿（10-16月）</span></p>
        						<input type="text">
        					</li>
        					<li>
        						<p>t <span>中门齿（6-10月）</span></p>
        						<input type="text">
        					</li>
        				</ul>
        			</div>
        		</div>
        		<div class="end_line"></div>
        	</section>
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
