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
		body{background: #fff;}
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
		<!--//主內容//-->
		<section class="indexcont">
			<section class="inbox noBoxShadowPage">
				<section class="contbox clearfix">
					<section class="height_record">
						<!--//主選單標題與路徑//-->
						<div class="breadcrumbs_logo">
							<h2 class="title">体重记录</h2>
							<section class="gopath"><a href="index.php">首页</a> > 体重记录</section>
						</div>
						<section class="Txt clearfix">
							<p>您可以在这里看到宝宝的体重改变曲线，有颜色的区域是世界卫生组织(WHO)所统计全世界儿童的平均体重区间，当宝宝的体重落于其间则表示正常，如果超出这份区域，则表示过胖或过瘦。</p>
						</section>
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
					<section class="clearfix relevant_articles">
						<h3 class="title">体重相关文章<a href="recommend.php" class="i-more">更多内容<span>&gt;&gt;</span></a></h3>
						<?php af_articles_list_recommend('体重'); ?>
					</section>
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
				var res = '<div class="detail"><p class="headImg"><img src="'+ params[0].data[3] +'"></p><span class="old">'+ old +'</span><p>'+ parseFloat(params[0].data[1]) +'<span>kg</span></p></div>'
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
					for (var i = 0; i <= 80.01; ) {
						list.push(parseFloat(i.toFixed(2)));
						i += 0.01
					}
					return list;
				}(),
				axisLine: {
					lineStyle:{
						color:'#87C64D'
					}
				},
				axisLabel: {
					interval: 1999,
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
					[0,210],[1,290],[2,380],[3,440],[4,490],[5,530],[6,570],[7,590],[8,620],[9,640],[10,660],[11,680],[12,690],[13,710],[14,720],[15,740],[16,750],[17,770],[18,780],[19,800],[20,810],[21,820],[22,840],[23,850],[24,860],[25,880],[26,890],[27,900],[28,910],[29,920],[30,940],[31,950],[32,960],[33,970],[34,980],[35,990],[36,1000],[37,1010],[38,1020],[39,1030],[40,1040],[41,1050],[42,1060],[43,1070],[44,1080],[45,1090],[46,1100],[47,1110],[48,1120],[49,1130],[50,1140],[51,1150],[52,1160],[53,1170],[54,1180],[55,1190],[56,1200],[57,1210],[58,1220],[59,1230],[60,1240],[61,1270],[62,1280],[63,1300],[64,1310],[65,1320],[66,1330],[67,1340],[68,1360],[69,1370],[70,1380],[71,1390],[72,1410],[73,1420],[74,1430],[75,1450],[76,1460],[77,1470],[78,1490],[79,1500],[80,1510],[81,1530],[82,1540],[83,1550],[84,1570],[85,1580],[86,1590],[87,1610],[88,1620],[89,1630],[90,1650],[91,1660],[92,1670],[93,1690],[94,1700],[95,1710],[96,1730],[96,4150],[95,4100],[94,4050],[93,4010],[92,3960],[91,3910],[90,3870],[89,3820],[88,3780],[87,3740],[86,3690],[85,3650],[84,3610],[83,3570],[82,3530],[81,3490],[80,3450],[79,3410],[78,3370],[77,3330],[76,3300],[75,3260],[74,3220],[73,3190],[72,3150],[71,3120],[70,3080],[69,3040],[68,3010],[67,2980],[66,2940],[65,2910],[64,2880],[63,2840],[62,2810],[61,2780],[60,2790],[59,2760],[58,2720],[57,2690],[56,2660],[55,2630],[54,2600],[53,2570],[52,2540],[51,2510],[50,2480],[49,2450],[48,2420],[47,2390],[46,2360],[45,2330],[44,2300],[43,2270],[42,2240],[41,2210],[40,2190],[39,2160],[38,2130],[37,2100],[36,2070],[35,2040],[34,2020],[33,1990],[32,1960],[31,1930],[30,1900],[29,1870],[28,1840],[27,1810],[26,1780],[25,1750],[24,1710],[23,1680],[22,1650],[21,1620],[20,1590],[19,1560],[18,1530],[17,1490],[16,1460],[15,1430],[14,1400],[13,1370],[12,1330],[11,1300],[10,1270],[9,1230],[8,1190],[7,1140],[6,1090],[5,1040],[4,970],[3,900],[2,800],[1,660],[0,500],[0,210]
				],
				<?php }else{ ?>
				// 女
				data:[
					[0,200],[1,270],[2,340],[3,400],[4,440],[5,480],[6,510],[7,530],[8,560],[9,580],[10,590],[11,610],[12,630],[13,640],[14,660],[15,670],[16,690],[17,700],[18,720],[19,730],[20,750],[21,760],[22,780],[23,790],[24,810],[25,820],[26,840],[27,850],[28,860],[29,880],[30,890],[31,900],[32,910],[33,930],[34,940],[35,950],[36,960],[37,970],[38,980],[39,990],[40,1010],[41,1020],[42,1030],[43,1040],[44,1050],[45,1060],[46,1070],[47,1080],[48,1090],[49,1100],[50,1110],[51,1120],[52,1130],[53,1140],[54,1150],[55,1160],[56,1170],[57,1180],[58,1190],[59,1200],[60,1210],[61,1240],[62,1250],[63,1260],[64,1270],[65,1280],[66,1290],[67,1300],[68,1310],[69,1320],[70,1330],[71,1340],[72,1350],[73,1360],[74,1370],[75,1380],[76,1390],[77,1400],[78,1410],[79,1420],[80,1430],[81,1440],[82,1450],[83,1460],[84,1480],[85,1490],[86,1500],[87,1510],[88,1520],[89,1540],[90,1550],[91,1560],[92,1570],[93,1590],[94,1600],[95,1620],[96,1630],[96,4410],[95,4360],[94,4310],[93,4260],[92,4200],[91,4150],[90,4110],[89,4060],[88,4010],[87,3960],[86,3920],[85,3870],[84,3830],[83,3780],[82,3740],[81,3700],[80,3660],[79,3620],[78,3580],[77,3540],[76,3500],[75,3460],[74,3420],[73,3380],[72,3340],[71,3310],[70,3270],[69,3230],[68,3200],[67,3160],[66,3130],[65,3090],[64,3050],[63,3020],[62,2980],[61,2950],[60,2950],[59,2920],[58,2880],[57,2850],[56,2810],[55,2770],[54,2740],[53,2700],[52,2660],[51,2630],[50,2590],[49,2550],[48,2520],[47,2480],[46,2450],[45,2410],[44,2370],[43,2340],[42,2300],[41,2270],[40,2230],[39,2200],[38,2160],[37,2130],[36,2090],[35,2060],[34,2030],[33,2000],[32,1960],[31,1930],[30,1900],[29,1870],[28,1830],[27,1800],[26,1770],[25,1730],[24,1700],[23,1670],[22,1640],[21,1600],[20,1570],[19,1540],[18,1510],[17,1480],[16,1450],[15,1410],[14,1380],[13,1350],[12,1310],[11,1280],[10,1240],[9,1200],[8,1160],[7,1110],[6,1060],[5,1000],[4,930],[3,850],[2,750],[1,620],[0,480],[0,200]
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
