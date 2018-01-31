<?php
session_start();
include('inc.php');
if(!isset($_SESSION['user_token'])) {
    header( 'Location: index.php' ) ;
    exit();
}
$tabon = @$_REQUEST['f'];
if(!isset($tabon))
    $tabon = '0';
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
        <!-- InstanceBeginEditable name="content" -->

        <section class="growth_index">
            <h4>成长指标</h4>
            <p>幼儿发展是阶段性的，每一步都必须踩稳才能迈向下一步！「1200项幼儿成长指标」其内容涵盖语言、认知、粗动作、细动作、人格、自主能力等六大范围，家长只要输入孩子的出生日期，系统即会协助家长检核孩子的发展，让孩子的成长基础更稳固、大脑的神经网络更紧密，好在未来有实力迎向各种挑战。</p>
            <div class="progress_board">
                <div class="progress_data">
                    <h3>豆豆</h3>
                    <h4>进度记分板</h4>
                    <ul>
                        <li>
                            <p><span>0</span>/ 1200</p>
                            完成项目：
                        </li>
                        <li>
                            <p><span>0</span>枚</p>
                            提前奖章：
                        </li>
                        <li>
                            <p><span>755</span>项</p>
                            落后项目：
                        </li>
                    </ul>
                </div>
            </div>
            <div class="icon_explain">
                <p><img src="../theme/cn/images/content/item_rep01.jpg"></b>进度超前
                    <span>红字</span>进度落后</p>
                <p><img src="../theme/cn/images/content/item_rep02.jpg"></b>详细说明
                    <img src="../theme/cn/images/content/item_rep03.jpg"></b>专家建议</p>
            </div>
        </section>





        <section class="slider_container">
            <div class="project_list">
                <ul class="clearfix">
                    <li class="selected">
                        <a>语言沟通</a>
                    </li>
                    <li>
                        <a>社会人格</a>
                    </li>
                    <li>
                        <a>自觉认知</a>
                    </li>
                    <li>
                        <a>粗动作技能</a>
                    </li>
                    <li>
                        <a>细动作技能</a>
                    </li>
                    <li>
                        <a>自主能力</a>
                    </li>
                </ul>
            </div>
        </section>

        <section class="project_sliderbox">
            <div class="project_tab">
                <ul class="clearfix">
                    <li>
                        <div class="project_box">
                            <div class="project_status">
                                <p><span class="success"></span>未完成项目</p>
                                <p><span></span>已完成项目</p>
                            </div>
                            <div class='title'>
                                <p>时间</p>
                                <p>发展成就量表</p>
                            </div>
                            <div class="loadmore">
                                <p><span>+</span>稍早</p>
                            </div>
                            <div class="project_detail_list">
                                <div class="project_detail">
                                    <p><span></span>4周-20周</p>
                                    <div class="detail">
                                        <p>能说出现实中或图片中物品的名称</p>
                                        <div class="detail_eqit">
                                            <span class="search_detail"></span>
                                            <span class="proposal"></span>
                                        </div>
                                    </div>
                                </div>
                                <div class="project_detail">
                                    <p><span class="success"></span>6周-16周</p>
                                    <div class="detail">
                                        <p>能模仿听到的声音或语言</p>
                                        <div class="detail_eqit">
                                            <span class="search_detail"></span>
                                            <span class="proposal"></span>
                                        </div>
                                    </div>
                                </div>
                                <div class="project_detail">
                                    <p><span></span>8周-7月</p>
                                    <div class="detail">
                                        <p>能说出自己喜爱的旋律</p>
                                        <div class="detail_eqit">
                                            <span class="search_detail"></span>
                                            <span class="proposal"></span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </li>
                    <li>
                        <div class="project_box">
                            <div class="project_status">
                                <p><span class="success"></span>未完成项目</p>
                                <p><span></span>已完成项目</p>
                            </div>
                            <div class='title'>
                                <p>时间</p>
                                <p>发展成就量表</p>
                            </div>
                            <div class="loadmore">
                                <p><span>+</span>稍早</p>
                            </div>
                            <div class="project_detail_list">
                                <div class="project_detail">
                                    <p><span></span>4周-20周</p>
                                    <div class="detail">
                                        <p>能说出现实中或图片中物品的名称</p>
                                        <div class="detail_eqit">
                                            <span class="search_detail"></span>
                                            <span class="proposal"></span>
                                        </div>
                                    </div>
                                </div>
                                <div class="project_detail">
                                    <p><span class="success"></span>6周-16周</p>
                                    <div class="detail">
                                        <p>能模仿听到的声音或语言</p>
                                        <div class="detail_eqit">
                                            <span class="search_detail"></span>
                                            <span class="proposal"></span>
                                        </div>
                                    </div>
                                </div>
                                <div class="project_detail">
                                    <p><span></span>8周-7月</p>
                                    <div class="detail">
                                        <p>能说出自己喜爱的旋律</p>
                                        <div class="detail_eqit">
                                            <span class="search_detail"></span>
                                            <span class="proposal"></span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </li>
                    <li>
                        <div class="project_box">
                            <div class="project_status">
                                <p><span class="success"></span>未完成项目</p>
                                <p><span></span>已完成项目</p>
                            </div>
                            <div class='title'>
                                <p>时间</p>
                                <p>发展成就量表</p>
                            </div>
                            <div class="loadmore">
                                <p><span>+</span>稍早</p>
                            </div>
                            <div class="project_detail_list">
                                <div class="project_detail">
                                    <p><span></span>4周-20周</p>
                                    <div class="detail">
                                        <p>能说出现实中或图片中物品的名称</p>
                                        <div class="detail_eqit">
                                            <span class="search_detail"></span>
                                            <span class="proposal"></span>
                                        </div>
                                    </div>
                                </div>
                                <div class="project_detail">
                                    <p><span class="success"></span>6周-16周</p>
                                    <div class="detail">
                                        <p>能模仿听到的声音或语言</p>
                                        <div class="detail_eqit">
                                            <span class="search_detail"></span>
                                            <span class="proposal"></span>
                                        </div>
                                    </div>
                                </div>
                                <div class="project_detail">
                                    <p><span></span>8周-7月</p>
                                    <div class="detail">
                                        <p>能说出自己喜爱的旋律</p>
                                        <div class="detail_eqit">
                                            <span class="search_detail"></span>
                                            <span class="proposal"></span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </li>
                    <li>
                        <div class="project_box">
                            <div class="project_status">
                                <p><span class="success"></span>未完成项目</p>
                                <p><span></span>已完成项目</p>
                            </div>
                            <div class='title'>
                                <p>时间</p>
                                <p>发展成就量表</p>
                            </div>
                            <div class="loadmore">
                                <p><span>+</span>稍早</p>
                            </div>
                            <div class="project_detail_list">
                                <div class="project_detail">
                                    <p><span></span>4周-20周</p>
                                    <div class="detail">
                                        <p>能说出现实中或图片中物品的名称</p>
                                        <div class="detail_eqit">
                                            <span class="search_detail"></span>
                                            <span class="proposal"></span>
                                        </div>
                                    </div>
                                </div>
                                <div class="project_detail">
                                    <p><span class="success"></span>6周-16周</p>
                                    <div class="detail">
                                        <p>能模仿听到的声音或语言</p>
                                        <div class="detail_eqit">
                                            <span class="search_detail"></span>
                                            <span class="proposal"></span>
                                        </div>
                                    </div>
                                </div>
                                <div class="project_detail">
                                    <p><span></span>8周-7月</p>
                                    <div class="detail">
                                        <p>能说出自己喜爱的旋律</p>
                                        <div class="detail_eqit">
                                            <span class="search_detail"></span>
                                            <span class="proposal"></span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </li>
                    <li>
                        <div class="project_box">
                            <div class="project_status">
                                <p><span class="success"></span>未完成项目</p>
                                <p><span></span>已完成项目</p>
                            </div>
                            <div class='title'>
                                <p>时间</p>
                                <p>发展成就量表</p>
                            </div>
                            <div class="loadmore">
                                <p><span>+</span>稍早</p>
                            </div>
                            <div class="project_detail_list">
                                <div class="project_detail">
                                    <p><span></span>4周-20周</p>
                                    <div class="detail">
                                        <p>能说出现实中或图片中物品的名称</p>
                                        <div class="detail_eqit">
                                            <span class="search_detail"></span>
                                            <span class="proposal"></span>
                                        </div>
                                    </div>
                                </div>
                                <div class="project_detail">
                                    <p><span class="success"></span>6周-16周</p>
                                    <div class="detail">
                                        <p>能模仿听到的声音或语言</p>
                                        <div class="detail_eqit">
                                            <span class="search_detail"></span>
                                            <span class="proposal"></span>
                                        </div>
                                    </div>
                                </div>
                                <div class="project_detail">
                                    <p><span></span>8周-7月</p>
                                    <div class="detail">
                                        <p>能说出自己喜爱的旋律</p>
                                        <div class="detail_eqit">
                                            <span class="search_detail"></span>
                                            <span class="proposal"></span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </li>
                    <li>
                        <div class="project_box">
                            <div class="project_status">
                                <p><span class="success"></span>未完成项目</p>
                                <p><span></span>已完成项目</p>
                            </div>
                            <div class='title'>
                                <p>时间</p>
                                <p>发展成就量表</p>
                            </div>
                            <div class="loadmore">
                                <p><span>+</span>稍早</p>
                            </div>
                            <div class="project_detail_list">
                                <div class="project_detail">
                                    <p><span></span>4周-20周</p>
                                    <div class="detail">
                                        <p>能说出现实中或图片中物品的名称</p>
                                        <div class="detail_eqit">
                                            <span class="search_detail"></span>
                                            <span class="proposal"></span>
                                        </div>
                                    </div>
                                </div>
                                <div class="project_detail">
                                    <p><span class="success"></span>6周-16周</p>
                                    <div class="detail">
                                        <p>能模仿听到的声音或语言</p>
                                        <div class="detail_eqit">
                                            <span class="search_detail"></span>
                                            <span class="proposal"></span>
                                        </div>
                                    </div>
                                </div>
                                <div class="project_detail">
                                    <p><span></span>8周-7月</p>
                                    <div class="detail">
                                        <p>能说出自己喜爱的旋律</p>
                                        <div class="detail_eqit">
                                            <span class="search_detail"></span>
                                            <span class="proposal"></span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </li>
                </ul>
            </div>
        </section>
        <!-- InstanceEndEditable -->
    </section>
    <!--【Content End】-->


    <!-- <?php include 'inc_footer.html'; ?> -->

</section>
<?php include 'inc_bottom_js.php'; ?>
</body>
<!-- InstanceEnd --></html>
