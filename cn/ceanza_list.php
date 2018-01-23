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
        		<h4>成长日记</h4>
        		<p>替您的宝宝写下成长日记，为您的宝宝记录每天的成长与回忆。</p>
        		<a href="ceanza_add.php" class="add_ceanza">新增成长日记<b></b></a>
                <a href="javascript: void(0)" class="ceanza_category">
                    浏览日记分类
                    <b></b>
                    <div class="category-list">
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
                </a>
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
			<?php
			// 缩略图列表开始
			//        var_dump($_SESSION);
			if(isset($_SESSION['user_token'])) {
				$member_uid = $_SESSION["CURRENT_KID_UID"];
                $category_name = !empty($_GET['category_name'])?$_GET['category_name']:'';
                if($category_name){
                    $sql = "select * from grow_diary where uid in (select supervisor_uid from user where uid={$member_uid}) and grow_diary_category_name='{$category_name}' order by Id";
                }else{
                    $sql = "select * from grow_diary where uid in (select supervisor_uid from user where uid={$member_uid}) order by Id";
                }
//                echo $sql;exit;
				$list = query_result_list($sql);
			}
			if($list){
				$tmp_list = array();
				foreach ($list as $k){
					$picurl = $k['picurl'];
					$tmp_list[$k['date']][] = array('img' => $picurl,'title' => $k['title'],'Id' =>$k['Id']);
				}

				$key_list = array_keys($tmp_list);
				while($key_list){
					$age = array_pop($key_list);
					$year_now = date('Y',strtotime($age));
					$year_old = date('Y', strtotime($_SESSION['CURRENT_KID_BIRTH_DAY']));
					$year_age = $year_now - $year_old;
					// 缩略图列表开始
					echo "<div class=\"ceanza_list contraction\">";
					echo "<p>{$year_now} 年<span>{$year_age} 岁</span></p>";
					echo "<ul class=\"ceanza_contraction\">";
					foreach($tmp_list[$age] as $k){
						echo "<li><p><img src={$k['img']} alt=\"\"><i></i></p>
    			<span><b>{$k['title']}</b></span></li>";
					}
					echo "</ul>";
					echo "</div>";
					// 缩略图列表结束

					// 列表开始
					$url = base64_encode($_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']);
					echo "<div class=\"ceanza_list\">";
					echo "<p>{$year_now} 年<span>{$year_age} 岁</span></p>";
					echo "<div class=\"title\"> <p> <span>撰写日期</span> <span>日记标题</span> </p>";
					echo "<ul class=\"list\">";
					foreach($tmp_list[$age] as $k){
						$date = date('Y年m月d日',strtotime($age));
						echo "<li><p>{$date}</p>
                        <p>{$k['title']}</p>  <p><b class=\"check\"></b>"
							. "<span><a href=\"ceanza_view.php?grow_id={$k['Id']}\">查看</a></span></p> "
							. "</li>";
						echo "<li>
                            <p><b class=\"eqit\"></b><span><a href=\"ceanza_eqit.php?grow_id={$k['Id']}\">编辑</a></span></p>
                            <p><b class=\"delete\"></b><span><a href=\"grow_diary.php?grow_id={$k['Id']}&type=delete&back={$url}\">删除</a></span></p>
                          </li>";
					}
					echo "</ul>";
					echo "</div></div>";
					// 列表结束
				}
			}else{
                if(isset($_GET['category_name']) && !empty($_GET['category_name'])) {
                    ?>
                    <div class="noData" style="display:inherit">
                        符合
                        <span class="ceanza_type"><?php echo $_GET['category_name'] ?></span>
                        的日记有<span class="ceanza_count">0</span>篇,您可以点击<a href="ceanza_add.php">新增成长日记</a>
                    </div>
                    <?php
                }
            }



			?>

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
