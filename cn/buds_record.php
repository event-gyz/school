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
        //			name="a" value="<?= isset($buds['a'])?$buds['a']:'';?>
        <!-- InstanceBeginEditable name="content" -->

        <!--//主內容//-->
        <section class="indexcont">
            <section class="inbox noBoxShadowPage">
                <section class="contbox clearfix">
                    <!--//主選單標題與路徑//-->
                    <div class="breadcrumbs_logo">
                        <h2 class="title">萌芽记录</h2>
                        <section class="gopath"><a href="index.php">首页</a> > 萌芽记录</section>
                    </div>
                    <section class="Txt fl clearfix">
                        <p>记录您宝宝牙齿的成长时间，能够更了解您宝宝在营养吸收和生长发育的健康状态！</p>
                    </section>
                    <div class="model_diagram">
                        <ul class="model_diagram_left">
                            <li class="tooth_a">
                                <div class="tooth"></div>
                                <p>a <span>中门齿（8-12月）</span></p>
                                <div class="date_input">
                                    <input class="datepicker" data-bud="a" type="text" readonly value="<?=isset($buds['a'])?$buds['a']:''?>">
                                    <b class="clear_btn">×</b>
                                </div>
                            </li>
                            <li class="tooth_b">
                                <div class="tooth"></div>
                                <p>b <span>侧门齿（9-13月）</span></p>
                                <div class="date_input">
                                    <input class="datepicker" data-bud="b" type="text" readonly value="<?=isset($buds['b'])?$buds['b']:''?>">
                                    <b class="clear_btn">×</b>
                                </div>
                            </li>
                            <li class="tooth_c">
                                <div class="tooth"></div>
                                <p>c <span>乳犬齿（16-22月）</span></p>
                                <div class="date_input">
                                    <input class="datepicker" data-bud="c" type="text" readonly value="<?=isset($buds['c'])?$buds['c']:''?>">
                                    <b class="clear_btn">×</b>
                                </div>
                            </li>
                            <li class="tooth_d">
                                <div class="tooth"></div>
                                <p>d <span>第一乳臼齿（13-19月）</span></p>
                                <div class="date_input">
                                    <input class="datepicker" data-bud="d" type="text" readonly value="<?=isset($buds['d'])?$buds['d']:''?>">
                                    <b class="clear_btn">×</b>
                                </div>
                            </li>
                            <li class="tooth_e">
                                <div class="tooth"></div>
                                <p>e <span>第二乳臼齿（25-33月）</span></p>
                                <div class="date_input">
                                    <input class="datepicker" data-bud="e" type="text" readonly value="<?=isset($buds['e'])?$buds['e']:''?>">
                                    <b class="clear_btn">×</b>
                                </div>
                            </li>
                            <li class="tooth_f">
                                <div class="tooth"></div>
                                <p>f <span>第二乳臼齿（23-31月）</span></p>
                                <div class="date_input">
                                    <input class="datepicker" type="text" data-bud="f"  readonly value="<?=isset($buds['f'])?$buds['f']:''?>">
                                    <b class="clear_btn">×</b>
                                </div>
                            </li>
                            <li class="tooth_g">
                                <div class="tooth"></div>
                                <p>g <span>第一乳臼齿（14-18月）</span></p>
                                <div class="date_input">
                                    <input class="datepicker" type="text" data-bud="g" readonly value="<?=isset($buds['g'])?$buds['g']:''?>">
                                    <b class="clear_btn">×</b>
                                </div>
                            </li>
                            <li class="tooth_h">
                                <div class="tooth"></div>
                                <p>h <span>乳犬齿（17-23月）</span></p>
                                <div class="date_input">
                                    <input class="datepicker" type="text" data-bud="h" readonly value="<?=isset($buds['h'])?$buds['h']:''?>">
                                    <b class="clear_btn">×</b>
                                </div>
                            </li>
                            <li class="tooth_i">
                                <div class="tooth"></div>
                                <p>i <span>侧门齿（10-16月）</span></p>
                                <div class="date_input">
                                    <input class="datepicker" type="text" data-bud="i" readonly value="<?=isset($buds['i'])?$buds['i']:''?>">
                                    <b class="clear_btn">×</b>
                                </div>
                            </li>
                            <li class="tooth_j">
                                <div class="tooth"></div>
                                <p>j <span>中门齿（6-10月）</span></p>
                                <div class="date_input">
                                    <input class="datepicker" type="text" data-bud="j" readonly value="<?=isset($buds['j'])?$buds['j']:''?>">
                                    <b class="clear_btn">×</b>
                                </div>
                            </li>
                        </ul>
                        <ul class="model_diagram_right">
                            <li class="tooth_k">
                                <div class="tooth"></div>
                                <p>k <span>中门齿（8-12月）</span></p>
                                <div class="date_input">
                                    <input class="datepicker" data-bud="k" type="text" readonly value="<?=isset($buds['k'])?$buds['k']:''?>">
                                    <b class="clear_btn">×</b>
                                </div>
                            </li>
                            <li class="tooth_l">
                                <div class="tooth"></div>
                                <p>l <span>侧门齿（9-13月）</span></p>
                                <div class="date_input">
                                    <input class="datepicker" data-bud="l" type="text" readonly value="<?=isset($buds['l'])?$buds['l']:''?>">
                                    <b class="clear_btn">×</b>
                                </div>
                            </li>
                            <li class="tooth_m">
                                <div class="tooth"></div>
                                <p>m <span>乳犬齿（16-22月）</span></p>
                                <div class="date_input">
                                    <input class="datepicker" data-bud="m" type="text" readonly value="<?=isset($buds['m'])?$buds['m']:''?>">
                                    <b class="clear_btn">×</b>
                                </div>
                            </li>
                            <li class="tooth_n">
                                <div class="tooth"></div>
                                <p>n <span>第一乳臼齿（13-19月）</span></p>
                                <div class="date_input">
                                    <input class="datepicker" data-bud="n" type="text" readonly value="<?=isset($buds['n'])?$buds['n']:''?>">
                                    <b class="clear_btn">×</b>
                                </div>
                            </li>
                            <li class="tooth_o">
                                <div class="tooth"></div>
                                <p>o <span>第二乳臼齿（25-33月）</span></p>
                                <div class="date_input">
                                    <input class="datepicker" data-bud="o" type="text" readonly value="<?=isset($buds['o'])?$buds['o']:''?>">
                                    <b class="clear_btn">×</b>
                                </div>
                            </li>
                            <li class="tooth_p">
                                <div class="tooth"></div>
                                <p>p <span>第二乳臼齿（23-31月）</span></p>
                                <div class="date_input">
                                    <input class="datepicker" data-bud="p"  type="text" readonly value="<?=isset($buds['p'])?$buds['p']:''?>">
                                    <b class="clear_btn">×</b>
                                </div>
                            </li>
                            <li class="tooth_q">
                                <div class="tooth"></div>
                                <p>q <span>第一乳臼齿（14-18月）</span></p>
                                <div class="date_input">
                                    <input class="datepicker" data-bud="q" type="text" readonly value="<?=isset($buds['q'])?$buds['q']:''?>">
                                    <b class="clear_btn">×</b>
                                </div>
                            </li>
                            <li class="tooth_r">
                                <div class="tooth"></div>
                                <p>r <span>乳犬齿（17-23月）</span></p>
                                <div class="date_input">
                                    <input class="datepicker" data-bud="r" type="text" readonly value="<?=isset($buds['r'])?$buds['r']:''?>">
                                    <b class="clear_btn">×</b>
                                </div>
                            </li>
                            <li class="tooth_s">
                                <div class="tooth"></div>
                                <p>s <span>侧门齿（10-16月）</span></p>
                                <div class="date_input">
                                    <input class="datepicker" data-bud="s" type="text" readonly value="<?=isset($buds['s'])?$buds['s']:''?>">
                                    <b class="clear_btn">×</b>
                                </div>
                            </li>
                            <li class="tooth_t">
                                <div class="tooth"></div>
                                <p>t <span>中门齿（6-10月）</span></p>
                                <div class="date_input">
                                    <input class="datepicker" data-bud="t" type="text" readonly value="<?=isset($buds['t'])?$buds['t']:''?>">
                                    <b class="clear_btn">×</b>
                                </div>
                            </li>
                        </ul>
                    </div>
                    <div class="end_line"></div>
                    <section class="clearfix relevant_articles">
                        <h3 class="title">萌芽相关文章<a href="recommend.php" class="i-more">更多内容<span>&gt;&gt;</span></a></h3>
                        <?php af_articles_list_recommend('乳牙'); ?>
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
<!-- <link rel="stylesheet" href="../theme/cn/jquery.cxcalendar.css">
<script src="../scripts/jquery.cxcalendar.js"></script> -->
<link rel="stylesheet" href="../theme/cn/jquery-ui.min.css">
<script src="../scripts/jquery-ui.min.js"></script>
<script>
    // 定义日期选择器属性
    $( ".datepicker" ).datepicker({
        maxDate: 0,
        changeYear: true,
        changeMonth: true,
        monthNamesShort: ['一月','二月','三月','四月','五月','六月','七月','八月','九月','十月','十一月','十二月'],
        dayNamesMin: ['日','一','二','三','四','五','六'],
        dateFormat: 'yy-mm-dd'
    });

    $(function () {
        var inputList = $('.model_diagram input')
        // console.log(inputList)
        for(var i = 0; i < inputList.length; i++){
            if($(inputList[i]).val() == ''){
                $(inputList[i]).parent().siblings('.tooth').css('display','none')
            }else{
                $(inputList[i]).parent().siblings('.tooth').css('display','block')
            }
        }
    });


    $('.model_diagram').on('change','input',function(){
        var buds_type = $(this).attr('data-bud');
        var date  = $(this).val();

        $.ajax({
            url: "_buds_record.php",
            type: "POST",
            data: {
//                        'p1': nickname,
                'buds_type': buds_type,
                'date': date,
                'type':'save'
            },
            dataType: "json",
            success: function (jsonStr) {
                if(jsonStr.errno == 1) {
                    if(date == ''){
                        $(this).parent().siblings('.tooth').css('display','none')
                    }else{
                        $(this).parent().siblings('.tooth').css('display','block')
                    }
                    layer.msg(jsonStr.msg)
                }
            }.bind(this)
        });
    });

    $('.model_diagram').on('focus','input',function(){
        $(this).next().css({display:'block'})
    });

    $('.model_diagram').on('blur','input',function(){
        setTimeout(()=>{$(this).next().css({display:'none'})}, 300);
    });

    $('.model_diagram').on('click','b',function(){
        $(this).prev().val('')
        $(this).css({display:"none"})
        $(this).parent().siblings('.tooth').css('display','none')
        var buds_type = $(this).siblings('input').attr('data-bud');
        console.log($(this).siblings('input'))
        var date  = $(this).siblings('input').val();
        $.ajax({
            url: "_buds_record.php",
            type: "POST",
            data: {
//                        'p1': nickname,
                'buds_type': buds_type,
                'date': date,
                'type':'save'
            },
            dataType: "json",
            success: function (jsonStr) {
                if(jsonStr.errno == 1) {
                    layer.msg(jsonStr.msg)
                }
            }
        });
    })

</script>
</body>
<!-- InstanceEnd --></html>
