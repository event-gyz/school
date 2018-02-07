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
                echo ('<script type="text/javascript"> $(function(){document.location.href ="http://x.eqxiu.com/s/PclsbuXT";});</script>');
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
            padding:0,
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
                    // interval:0
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
                // name:'最高',
                type:'line',
                data:function (){
                    <?php
                    $echartsql = "select * from wap_height where  uid=(select supervisor_uid from user where uid={$member_uid}) order by id desc";
                    $heightInfo = M()->select($sql);
                    //                            $height = array_combine(array_column($heightInfo,'date'),array_column($heightInfo,'height'));
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
            }
        ]
    }

    // 使用刚指定的配置项和数据显示图表。
    heightChart.setOption(heightOption);
</script>
</body>
<!-- InstanceEnd --></html>
