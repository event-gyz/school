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
		<!--//主內容//-->
		<section class="indexcont">
			<section class="inbox noBoxShadowPage">
				<section class="contbox clearfix">
					<section class="height_record">
						<!--//主選單標題與路徑//-->
						<div class="breadcrumbs_logo">
							<h2 class="title">身高记录</h2>
							<section class="gopath"><a href="index.php">首页</a> > 身高记录</section>
						</div>
						<section class="Txt clearfix">
							<p>您可以在这里看到宝宝的身高改变曲线，当宝宝的身高落于有顏色的区域，这代表着符合世界卫生组织(WHO)儿童身高区间，也就是身高落于大部分儿童身高族群之间。</p>
						</section>
						<a href="height_record_add.php" class="add_height_record">新增身高记录<b></b></a>
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
					<div class="height_record_contraction" id="height_record_contraction">
					</div>
					<p class="prompt">左右滑动查看</p>
					<?php
					if(isset($_SESSION['user_token'])) {
						$member_uid = $_SESSION["CURRENT_KID_UID"];
						$sql = "select * from wap_height where uid in (select supervisor_uid from user where uid={$member_uid}) order by `date` desc";
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
					<section class="clearfix relevant_articles">
						<h3 class="title">身高相关文章<a href="recommend.php" class="i-more">更多内容<span>&gt;&gt;</span></a></h3>
						<?php af_articles_list_recommend('身高'); ?>
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
	var heightChart = echarts.init(document.getElementById('height_record_contraction'));

	// 指定图表的配置项和数据
	heightOption = {
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
				var res = '<div class="detail"><p class="headImg"><img src="'+ params[0].data[3] +'"></p><span class="old">'+ old +'</span><p>'+ parseFloat(params[0].data[1]) +'<span>cm</span></p></div>'
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
				name: '单位(cm)',
				boundaryGap : false,
				data : function (){
					var list = [];
					for (var i = 0; i <= 180; ) {
						list.push(parseFloat(i.toFixed(1)));
						i += 0.1
					}
					return list;
				}(),
				axisLine: {
					lineStyle:{
						color:'#87C64D'
					}
				},
				axisLabel: {
					interval: 449,
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
					$echartsql = "select * from wap_height where  uid=(select supervisor_uid from user where uid={$member_uid}) order by `date` desc";
					$heightInfo = M()->select($echartsql);
					//$height = array_combine(array_column($heightInfo,'date'),array_column($heightInfo,'height'));
					$birth_day = $_SESSION['CURRENT_KID_BIRTH_DAY'];
					if($heightInfo){
						foreach($heightInfo as $value){
							$c = strtotime($value['date'])-strtotime($birth_day);
							$new_key = intval($c/86400/30);
							@$height[$new_key]['height'] = $value['height'];
							@$height[$new_key]['img'] = $value['picurl'];
						}
					}
					?>
					var list = <?php
						if($height){
							echo '[';
							foreach($height as $k=>$v){
								if($k>=0){
									echo "['{$k}','{$v['height']}','10',{$v['img']}],";
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
					[0,442],[1,489],[2,524],[3,553],[4,576],[5,596],[6,612],[7,627],[8,640],[9,652],[10,664],[11,674],[12,686],[13,696],[14,706],[15,716],[16,725],[17,733],[18,742],[19,750],[20,758],[21,765],[22,772],[23,780],[24,780],[25,786],[26,793],[27,799],[28,805],[29,811],[30,817],[31,823],[32,828],[33,834],[34,839],[35,844],[36,850],[37,855],[38,860],[39,865],[40,870],[41,875],[42,880],[43,884],[44,889],[45,894],[46,898],[47,903],[48,907],[49,912],[50,916],[51,921],[52,925],[53,930],[54,934],[55,939],[56,943],[57,947],[58,952],[59,956],[60,961],[61,965],[62,969],[63,974],[64,978],[65,982],[66,987],[67,991],[68,995],[69,999],[70,1004],[71,1008],[72,1012],[73,1016],[74,1020],[75,1024],[76,1028],[77,1032],[78,1036],[79,1039],[80,1043],[81,1047],[82,1051],[83,1055],[84,1059],[85,1063],[86,1066],[87,1070],[88,1074],[89,1078],[90,1081],[91,1085],[92,1089],[93,1092],[94,1096],[95,1100],[96,1103],[96,1442],[95,1430,7],[94,1431],[93,1426],[92,1420],[91,1415],[90,1409],[89,1404],[88,1398],[87,1393],[86,1387],[85,1382],[84,1376],[83,1370],[82,1365],[81,1359],[80,1353],[79,1348],[78,1342],[77,1336],[76,1330],[75,1325],[74,1319],[73,1313],[72,1307],[71,1301],[70,1296],[69,1290],[68,1284],[67,1278],[66,1271],[65,1265],[64,1259],[63,1253],[62,1247],[61,1240],[60,1239],[59,1232],[58,1226],[57,1219],[56,1212],[55,1206],[54,1199],[53,1192],[52,1186],[51,1179],[50,1173],[49,1166],[48,1159],[47,1152],[46,1146],[45,1139],[44,1132],[43,1125],[42,1117],[41,1110],[40,1103],[39,1095],[38,1088],[37,1080],[36,1072],[35,1064],[34,1056],[33,1048],[32,1039],[31,1030],[30,1021],[29,1012],[28,1003],[27,993],[26,983],[25,973],[24,963],[23,959],[22,949],[21,938],[20,926],[19,915],[18,904],[17,892],[16,880],[15,864],[14,855],[13,842],[12,829],[11,815],[10,801],[9,787],[8,772],[7,757],[6,740],[5,722],[4,701],[3,676],[2,644],[1,606],[0,556],[0,442]
				],

				<?php }else{ ?>
				// 女
				data: [
					[0, 436], [1, 478], [2, 510], [3, 535], [4, 556], [5, 574], [6, 589], [7, 603], [8, 617], [9, 629], [10, 641], [11, 652], [12, 663], [13, 673], [14, 683], [15, 693], [16, 702], [17, 711], [18, 720], [19, 728], [20, 737], [21, 745], [22, 752], [23, 760], [24, 767], [25, 768], [26, 775], [27, 781], [28, 788], [29, 795], [30, 801], [31, 807], [32, 813], [33, 819], [34, 825], [35, 831], [36, 836], [37, 842], [38, 847], [39, 853], [40, 858], [41, 863], [42, 868], [43, 874], [44, 879], [45, 884], [46, 889], [47, 893], [48, 898], [49, 903], [50, 907], [51, 912], [52, 917], [53, 921], [54, 926], [55, 930], [56, 934], [57, 939], [58, 943], [59, 947], [60, 952], [61, 953], [62, 957], [63, 961], [64, 965], [65, 970], [66, 974], [67, 978], [68, 982], [69, 986], [70, 990], [71, 994], [72, 998], [73, 1002], [74, 1005], [75, 1009], [76, 1013], [77, 1017], [78, 1021], [79, 1025], [80, 1029], [81, 1032], [82, 1036], [83, 1040], [84, 1044], [85, 1048], [86, 1052], [87, 1056], [88, 1060], [89, 1064], [90, 1068], [91, 1072], [92, 1076], [93, 1080], [94, 1084], [95, 1088], [96, 1092], [96, 1439], [95, 1434], [94, 1428], [93, 1423], [92, 1417], [91, 1411], [90, 1406], [89, 1400], [88, 1394], [87, 1389], [86, 1383], [85, 1378], [84, 1372], [83, 1367], [82, 1361], [81, 1355], [80, 1350], [79, 1344], [78, 1339], [77, 1333], [76, 1327], [75, 1322], [74, 1316], [73, 1311], [72, 1305], [71, 1299], [70, 1293], [69, 1288], [68, 1282], [67, 1276], [66, 1270], [65, 1264], [64, 1258], [63, 1252], [62, 1245], [61, 1239], [60, 1237], [59, 1231], [58, 1224], [57, 1218], [56, 1211], [55, 1204], [54, 1198], [53, 1191], [52, 1184], [51, 1177], [50, 1171], [49, 1164], [48, 1157], [47, 1149], [46, 1142], [45, 1135], [44, 1127], [43, 1120], [42, 1112], [41, 1105], [40, 1097], [39, 1089], [38, 1081], [37, 1073], [36, 1065], [35, 1056], [34, 1048], [33, 1039], [32, 1031], [31, 1022], [30, 1013], [29, 1003], [28, 994], [27, 984], [26, 974], [25, 964], [24, 954], [23, 950], [22, 940], [21, 929], [20, 917], [19, 906], [18, 894], [17, 882], [16, 870], [15, 857], [14, 844], [13, 831], [12, 817], [11, 803], [10, 789], [9, 774], [8, 758], [7, 742], [6, 725], [5, 707], [4, 686], [3, 661], [2, 632], [1, 595], [0, 547], [0, 436]
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
	heightChart.setOption(heightOption);
</script>
</body>
<!-- InstanceEnd --></html>
