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
    		<div class="relevant_articles">
    			<h4>身高相关文章</h4>
				<ul>
					<?php af_articles_list_recommend('身高'); ?>
				</ul>
    		</div>
        	<!-- InstanceEndEditable -->   
        </section>
        <!--【Content End】-->
        
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
				    	var res = '<div class="detail"><p class="headImg"><img src="'+ params[0].data[3] +'"></p><span class="old">'+ old +'</span><p>'+ parseInt(params[0].data[1]) +'<span>cm</span></p></div>'
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
			                for (var i = 0; i <= 180; i++) {
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
			                interval: 44,
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
			             	[0,44.2],[1,48.9],[2,52.4],[3,55.3],[4,57.6],[5,59.6],[6,61.2],[7,62.7],[8,64],[9,65.2],[10,66.4],[11,67.4],[12,68.6],[13,69.6],[14,70.6],[15,71.6],[16,72.5],[17,73.3],[18,74.2],[19,75.0],[20,75.8],[21,76.5],[22,77.2],[23,78.0],[24,78.0],[25,78.6],[26,79.3],[27,79.9],[28,80.5],[29,81.1],[30,81.7],[31,82.3],[32,82.8],[33,83.4],[34,83.9],[35,84.4],[36,85.0],[37,85.5],[38,86.0],[39,86.5],[40,87.0],[41,87.5],[42,88.0],[43,88.4],[44,88.9],[45,89.4],[46,89.8],[47,90.3],[48,90.7],[49,91.2],[50,91.6],[51,92.1],[52,92.5],[53,93.0],[54,93.4],[55,93.9],[56,94.3],[57,94.7],[58,95.2],[59,95.6],[60,96.1],[61,96.5],[62,96.9],[63,97.4],[64,97.8],[65,98.2],[66,98.7],[67,99.1],[68,99.5],[69,99.9],[70,100.4],[71,100.8],[72,101.2],[73,101.6],[74,102.0],[75,102.4],[76,102.8],[77,103.2],[78,103.6],[79,103.9],[80,104.3],[81,104.7],[82,105.1],[83,105.5],[84,105.9],[85,106.3],[86,106.6],[87,107.0],[88,107.4],[89,107.8],[90,108.1],[91,108.5],[92,108.9],[93,109.2],[94,109.6],[95,110.0],[96,110.3],[96,144.2],[95,143,7],[94,143.1],[93,142.6],[92,142.0],[91,141.5],[90,140.9],[89,140.4],[88,139.8],[87,139.3],[86,138.7],[85,138.2],[84,137.6],[83,137.0],[82,136.5],[81,135.9],[80,135.3],[79,134.8],[78,134.2],[77,133.6],[76,133.0],[75,132.5],[74,131.9],[73,131.3],[72,130.7],[71,130.1],[70,129.6],[69,129.0],[68,128.4],[67,127.8],[66,127.1],[65,126.5],[64,125.9],[63,125.3],[62,124.7],[61,124.0],[60,123.9],[59,123.2],[58,122.6],[57,121.9],[56,121.2],[55,120.6],[54,119.9],[53,119.2],[52,118.6],[51,117.9],[50,117.3],[49,116.6],[48,115.9],[47,115.2],[46,114.6],[45,113.9],[44,113.2],[43,112.5],[42,111.7],[41,111.0],[40,110.3],[39,109.5],[38,108.8],[37,108.0],[36,107.2],[35,106.4],[34,105.6],[33,104.8],[32,103.9],[31,103.0],[30,102.1],[29,101.2],[28,100.3],[27,99.3],[26,98.3],[25,97.3],[24,96.3],[23,95.9],[22,94.9],[21,93.8],[20,92.6],[19,91.5],[18,90.4],[17,89.2],[16,88.0],[15,86.4],[14,85.5],[13,84.2],[12,82.9],[11,81.5],[10,80.1],[9,78.7],[8,77.2],[7,75.7],[6,74.0],[5,72.2],[4,70.1],[3,67.6],[2,64.4],[1,60.6],[0,55.6],[0,44.2]
			             ],

					<?php }else{ ?>
					// 女
					data: [
						[0, 43.6], [1, 47.8], [2, 51.0], [3, 53.5], [4, 55.6], [5, 57.4], [6, 58.9], [7, 60.3], [8, 61.7], [9, 62.9], [10, 64.1], [11, 65.2], [12, 66.3], [13, 67.3], [14, 68.3], [15, 69.3], [16, 70.2], [17, 71.1], [18, 72.0], [19, 72.8], [20, 73.7], [21, 74.5], [22, 75.2], [23, 76.0], [24, 76.7], [25, 76.8], [26, 77.5], [27, 78.1], [28, 78.8], [29, 79.5], [30, 80.1], [31, 80.7], [32, 81.3], [33, 81.9], [34, 82.5], [35, 83.1], [36, 83.6], [37, 84.2], [38, 84.7], [39, 85.3], [40, 85.8], [41, 86.3], [42, 86.8], [43, 87.4], [44, 87.9], [45, 88.4], [46, 88.9], [47, 89.3], [48, 89.8], [49, 90.3], [50, 90.7], [51, 91.2], [52, 91.7], [53, 92.1], [54, 92.6], [55, 93.0], [56, 93.4], [57, 93.9], [58, 94.3], [59, 94.7], [60, 95.2], [61, 95.3], [62, 95.7], [63, 96.1], [64, 96.5], [65, 97.0], [66, 97.4], [67, 97.8], [68, 98.2], [69, 98.6], [70, 99.0], [71, 99.4], [72, 99.8], [73, 100.2], [74, 100.5], [75, 100.9], [76, 101.3], [77, 101.7], [78, 102.1], [79, 102.5], [80, 102.9], [81, 103.2], [82, 103.6], [83, 104.0], [84, 104.4], [85, 104.8], [86, 105.2], [87, 105.6], [88, 106.0], [89, 106.4], [90, 106.8], [91, 107.2], [92, 107.6], [93, 108.0], [94, 108.4], [95, 108.8], [96, 109.2], [96, 143.9], [95, 143.4], [94, 142.8], [93, 142.3], [92, 141.7], [91, 141.1], [90, 140.6], [89, 140.0], [88, 139.4], [87, 138.9], [86, 138.3], [85, 137.8], [84, 137.2], [83, 136.7], [82, 136.1], [81, 135.5], [80, 135.0], [79, 134.4], [78, 133.9], [77, 133.3], [76, 132.7], [75, 132.2], [74, 131.6], [73, 131.1], [72, 130.5], [71, 129.9], [70, 129.3], [69, 128.8], [68, 128.2], [67, 127.6], [66, 127.0], [65, 126.4], [64, 125.8], [63, 125.2], [62, 124.5], [61, 123.9], [60, 123.7], [59, 123.1], [58, 122.4], [57, 121.8], [56, 121.1], [55, 120.4], [54, 119.8], [53, 119.1], [52, 118.4], [51, 117.7], [50, 117.1], [49, 116.4], [48, 115.7], [47, 114.9], [46, 114.2], [45, 113.5], [44, 112.7], [43, 112.0], [42, 111.2], [41, 110.5], [40, 109.7], [39, 108.9], [38, 108.1], [37, 107.3], [36, 106.5], [35, 105.6], [34, 104.8], [33, 103.9], [32, 103.1], [31, 102.2], [30, 101.3], [29, 100.3], [28, 99.4], [27, 98.4], [26, 97.4], [25, 96.4], [24, 95.4], [23, 95.0], [22, 94.0], [21, 92.9], [20, 91.7], [19, 90.6], [18, 89.4], [17, 88.2], [16, 87.0], [15, 85.7], [14, 84.4], [13, 83.1], [12, 81.7], [11, 80.3], [10, 78.9], [9, 77.4], [8, 75.8], [7, 74.2], [6, 72.5], [5, 70.7], [4, 68.6], [3, 66.1], [2, 63.2], [1, 59.5], [0, 54.7], [0, 43.6]
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
