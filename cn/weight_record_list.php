<?php
session_start();
include('inc.php');
?>
<!DOCTYPE html>
<html><!-- InstanceBegin template="/Templates/_page01.dwt" codeOutsideHTMLIsLocked="false" -->
<head>
	<?php include('inc_head.php');	?>
	<script src="../scripts/echarts/echarts.js"></script>
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
<?php
if(isset($_SESSION['user_token'])) {
	$member_uid = $CMEMBER->accessFromToken($_SESSION['user_token']);
}
if($member_uid > 0) {
	$sql = "select first_name,email,cellphone from member where uid='$member_uid'";
	$result = M()->find($sql);
	if($result!=null) {
		$name = $result['first_name'];
		$email = $result['email'];
		$phone = $result['cellphone'];
	}
	unset($result);
	unset($sql);
	$sql = "select nick_name,birth_day,gender from user where supervisor_uid='$member_uid'";
	$result = M()->find($sql);
	if($result!=null) {
		$nick_name = $result['nick_name'];
		$birth_day = $result['birth_day'];
		$sex = $result['gender'];
//		$sex = ($result['gender']==0?"男":"女");
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
			<h4>体重记录</h4>
			<section class="gopath goback"><a href="index.php">首页</a> > 体重记录</section>
			<p>您可以在这里看到宝宝的体重改变曲线，有颜色的区域是世界卫生组织(WHO)所统计全世界儿童的平均体重区间，当宝宝的体重落于其间则表示正常，如果超出这份区域，则表示过胖或过瘦。</p>
			<a href="weight_record_add.php" class="add_weight_record">新增体重记录<b></b></a>
			<div class="browse_mode">
				<p></p>
				<ul class="mode_sel">
					<li class="selected">
						<span>图表</span>
						<b></b>
					</li>
					<li>
						<span>列表</span>
						<b></b>
					</li>
				</ul>
			</div>
		</section>
		<!-- 缩图图表 -->
		<div id="weight_record_contraction" class="weight_record_contraction"></div>
		<p class="prompt">左右滑动查看</p>
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
			<h4>体重相关文章</h4>
			<ul>
				<?php af_articles_list_recommend('体重'); ?>
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
<script>
	// 身高图表
	// 基于准备好的dom，初始化echarts实例
	var weightChart = echarts.init(document.getElementById('weight_record_contraction'));

	// 指定图表的配置项和数据
	weightOption = {
		tooltip : {
			trigger: 'axis',
			backgroundColor: '#fff',
			borderWidth: 2,
			borderColor: '#7FC242',
			padding: 0,
			axisPointer: {
				lineStyle: {
					color: 'transparent'
				},
			},
			textStyle: {
				align: 'center',
				color: '#7FC242'
			},
			triggerOn: 'click',
			formatter: function(params){
				var year = parseInt(parseInt(params[0].data[0])/12)
				var month = parseInt(params[0].data[0])%12
				var old = (year > 0 ? year + '岁' : '') + (month > 0 ? month + '个月' : '')
				var res = '<div class="detail"><p class="headImg"><img src="'+ params[0].data[3] +'"></p><span class="old">'+ old +'</span><p>'+ parseInt(params[0].data[1]) +'<span>kg</span></p></div>'
				return res;
			}
		},
		xAxis : [
			{
				type : 'category',
				boundaryGap : false,
				data : function (){
					var list = [];
					for (var i = 0; i <= 96; i++) {
						list.push(i);
					}
					return list;
				}(),
				axisLine: {
					lineStyle:{
						color:'#87C64D'
					}
				},
				axisLabel: {
					color: '#87C64D',
					formatter: function (value, index) {
						var year = parseInt(value/12)
						var month = value % 12
						var value = value == 0 ? '0岁' : (year > 0 ? year + '岁' : '') + (month > 0 ? month + '个月' : '')
						return value
					},
					minInterval: 0
				}
			}
		],
		yAxis : [
			{
				type : 'category',
				name: '单位(kg)',
				boundaryGap : false,
				data : function (){
					var list = [];
					for (var i = 0; i <= 80; i++) {
						list.push(i);
					}
					return list;
				}(),
				axisLine: {
					lineStyle:{
						color:'#87C64D'
					}
				},
				axisLabel: {
					interval: 19,
					color: '#87C64D'
				}
			}
		],
		dataZoom: [
			{
				type: 'slider',
				start: 0,
				end: 100,
				width:'54%',
				height: '11%',
				fillerColor: '#fff',
				dataBackgroundColor :'#7EC342',
				backgroundColor:'#fff',
				dataBackground: {
					lineStyle:{
						color: '#fff'
					},
					areaStyle:{
						color: '#fff',
						opacity: 0
					}
				},
				handleIcon:'image://../content/epaper/images/pullIcon.png',
				handleSize: '101%',
				textStyle: {
					color: '#88C650'
				},
				lineHeight: 56,
				left: '23%',
				bottom:"0%"
			},
			{
				type: 'inside',
				start: 0,
				end: 35
			},
		],
		series : [
			{
				type:'line',
				data:function (){
					<?php
					$echartsql = "select * from wap_weight where  uid=(select supervisor_uid from user where uid={$member_uid}) order by id desc";
					$weightInfo = M()->select($sql);
					$birth_day = $_SESSION['CURRENT_KID_BIRTH_DAY'];
					if($weightInfo){
						foreach($weightInfo as $value){
							$c = strtotime($value['date'])-strtotime($birth_day);
							$new_key = intval($c/86400/30);
							@$weight[$new_key]['weight'] = $value['weight'];
							@$weight[$new_key]['img'] = $value['picurl'];
						}
					}

					?>
					var list = <?php
						if($weight){
							echo '[';
							foreach($weight as $k=>$v){
								if($k>=0){
									echo "['{$k}','{$v['weight']}','10',{$v['img']}],";
								}
							}
							echo ']';
						}
						?>;
					return list;
				}(),
				itemStyle: {
					normal: {
						color: '#649E2F',
						lineStyle: {
							color: '#649E2F',
							width: 2
						},
					}
				},
				symbolSize: function (val) {
					return val[2];
				},
				symbol: 'circle',
				showAllSymbol: true
			},
			{
				type:'line',
				// 男
				<?php if($sex!=1){?>
				data:[
					[0,2.1],[1,2.9],[2,3.8],[3,4.4],[4,4.9],[5,5.3],[6,5.7],[7,5.9],[8,6.2],[9,6.4],[10,6.6],[11,6.8],[12,6.9],[13,7.1],[14,7.2],[15,7.4],[16,7.5],[17,7.7],[18,7.8],[19,8.0],[20,8.1],[21,8.2],[22,8.4],[23,8.5],[24,8.6],[25,8.8],[26,8.9],[27,9.0],[28,9.1],[29,9.2],[30,9.4],[31,9.5],[32,9.6],[33,9.7],[34,9.8],[35,9.9],[36,10.0],[37,10.1],[38,10.2],[39,10.3],[40,10.4],[41,10.5],[42,10.6],[43,10.7],[44,10.8],[45,10.9],[46,11],[47,11.1],[48,11.2],[49,11.3],[50,11.4],[51,11.5],[52,11.6],[53,11.7],[54,11.8],[55,11.9],[56,12.0],[57,12.1],[58,12.2],[59,12.3],[60,12.4],[61,12.7],[62,12.8],[63,13.0],[64,13.1],[65,13.2],[66,13.3],[67,13.4],[68,13.6],[69,13.7],[70,13.8],[71,13.9],[72,14.1],[73,14.2],[74,14.3],[75,14.5],[76,14.6],[77,14.7],[78,14.9],[79,15.0],[80,15.1],[81,15.3],[82,15.4],[83,15.5],[84,15.7],[85,15.8],[86,15.9],[87,16.1],[88,16.2],[89,16.3],[90,16.5],[91,16.6],[92,16.7],[93,16.9],[94,17.0],[95,17.1],[96,17.3],[96,41.5],[95,41.0],[94,40.5],[93,40.1],[92,39.6],[91,39.1],[90,38.7],[89,38.2],[88,37.8],[87,37.4],[86,36.9],[85,36.5],[84,36.1],[83,35.7],[82,35.3],[81,34.9],[80,34.5],[79,34.1],[78,33.7],[77,33.3],[76,33.0],[75,32.6],[74,32.2],[73,31.9],[72,31.5],[71,31.2],[70,30.8],[69,30.4],[68,30.1],[67,29.8],[66,29.4],[65,29.1],[64,28.8],[63,28.4],[62,28.1],[61,27.8],[60,27.9],[59,27.6],[58,27.2],[57,26.9],[56,26.6],[55,26.3],[54,26.0],[53,25.7],[52,25.4],[51,25.1],[50,24.8],[49,24.5],[48,24.2],[47,23.9],[46,23.6],[45,23.3],[44,23],[43,22.7],[42,22.4],[41,22.1],[40,21.9],[39,21.6],[38,21.3],[37,21],[36,20.7],[35,20.4],[34,20.2],[33,19.9],[32,19.6],[31,19.3],[30,19.0],[29,18.7],[28,18.4],[27,18.1],[26,17.8],[25,17.5],[24,17.1],[23,16.8],[22,16.5],[21,16.2],[20,15.9],[19,15.6],[18,15.3],[17,14.9],[16,14.6],[15,14.3],[14,14.0],[13,13.7],[12,13.3],[11,13],[10,12.7],[9,12.3],[8,11.9],[7,11.4],[6,10.9],[5,10.4],[4,9.7],[3,9.0],[2,8.0],[1,6.6],[0,5],[0,2.1]
				],
				<?php }else{ ?>
				// 女
				data:[
					[0,2.0],[1,2.7],[2,3.4],[3,4.0],[4,4.4],[5,4.8],[6,5.1],[7,5.3],[8,5.6],[9,5.8],[10,5.9],[11,6.1],[12,6.3],[13,6.4],[14,6.6],[15,6.7],[16,6.9],[17,7.0],[18,7.2],[19,7.3],[20,7.5],[21,7.6],[22,7.8],[23,7.9],[24,8.1],[25,8.2],[26,8.4],[27,8.5],[28,8.6],[29,8.8],[30,8.9],[31,9.0],[32,9.1],[33,9.3],[34,9.4],[35,9.5],[36,9.6],[37,9.7],[38,9.8],[39,9.9],[40,10.1],[41,10.2],[42,10.3],[43,10.4],[44,10.5],[45,10.6],[46,10.7],[47,10.8],[48,10.9],[49,11.0],[50,11.1],[51,11.2],[52,11.3],[53,11.4],[54,11.5],[55,11.6],[56,11.7],[57,11.8],[58,11.9],[59,12.0],[60,12.1],[61,12.4],[62,12.5],[63,12.6],[64,12.7],[65,12.8],[66,12.9],[67,13.0],[68,13.1],[69,13.2],[70,13.3],[71,13.4],[72,13.5],[73,13.6],[74,13.7],[75,13.8],[76,13.9],[77,14.0],[78,14.1],[79,14.2],[80,14.3],[81,14.4],[82,14.5],[83,14.6],[84,14.8],[85,14.9],[86,15.0],[87,15.1],[88,15.2],[89,15.4],[90,15.5],[91,15.6],[92,15.7],[93,15.9],[94,16.0],[95,16.2],[96,16.3],[96,44.1],[95,43.6],[94,43.1],[93,42.6],[92,42.0],[91,41.5],[90,41.1],[89,40.6],[88,40.1],[87,39.6],[86,39.2],[85,38.7],[84,38.3],[83,37.8],[82,37.4],[81,37.0],[80,36.6],[79,36.2],[78,35.8],[77,35.4],[76,35.0],[75,34.6],[74,34.2],[73,33.8],[72,33.4],[71,33.1],[70,32.7],[69,32.3],[68,32.0],[67,31.6],[66,31.3],[65,30.9],[64,30.5],[63,30.2],[62,29.8],[61,29.5],[60,29.5],[59,29.2],[58,28.8],[57,28.5],[56,28.1],[55,27.7],[54,27.4],[53,27.0],[52,26.6],[51,26.3],[50,25.9],[49,25.5],[48,25.2],[47,24.8],[46,24.5],[45,24.1],[44,23.7],[43,23.4],[42,23.0],[41,22.7],[40,22.3],[39,22.0],[38,21.6],[37,21.3],[36,20.9],[35,20.6],[34,20.3],[33,20.0],[32,19.6],[31,19.3],[30,19.0],[29,18.7],[28,18.3],[27,18.0],[26,17.7],[25,17.3],[24,17.0],[23,16.7],[22,16.4],[21,16.0],[20,15.7],[19,15.4],[18,15.1],[17,14.8],[16,14.5],[15,14.1],[14,13.8],[13,13.5],[12,13.1],[11,12.8],[10,12.4],[9,12.0],[8,11.6],[7,11.1],[6,10.6],[5,10.0],[4,9.3],[3,8.5],[2,7.5],[1,6.2],[0,4.8],[0,2.0]
				],
				<?php }?>
				areaStyle: {
					color: '#CDE7B6'
				},
				itemStyle: {
					normal: {
						lineStyle: {
							width: 0
						},
					}
				},
				showSymbol: false,
				smooth:true,
				tooltip:{
					trigger: 'none'
				}
			}
		]
	}

	// 使用刚指定的配置项和数据显示图表。
	weightChart.setOption(weightOption);
</script>
</body>
<!-- InstanceEnd --></html>
