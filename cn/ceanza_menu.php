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
        <section class="ceanza">
            <h4>成长日记</h4>
            <ul class="bread-crumb">
                <li><a href="/">首页</a><b>&gt;</b></li>
                <li><a href="#">成长日记</a></li>
            </ul>
            <ul class="ceanza-menu">
                <li class="selected">
                    <?php
                    $sql  = 'select * from user where supervisor_uid='.$CMEMBER->getUserId();
                    $result = M()->find($sql);
                    ?>
                    <h4><?php echo $result['nick_name'];?></h4>
                    <?php $user_age = $_SESSION['CURRENT_KID_AGE'];
                    $start_age = intval($user_age/12)*12;
                    if(!empty($e) && ($start_age>=12)){
                        $start_age -=12;
                    }
                    $end_age = ceil($user_age/12)*12;
                    if($start_age == $end_age){
                        $end_age = $end_age+12;
                    }
                    $user_uid = $_SESSION["CURRENT_KID_UID"];
                    $sql2 = "select count(grow_index.uid) as c from grow_index LEFT JOIN grow_log on grow_log.item_uid=grow_index.uid and grow_log.user_uid='$user_uid' where grow_index.age_min >= '$start_age' and grow_index.age_max <= '$end_age' and early is null";
                    $res = M()->find($sql2);
                    ?>

                    <a href="itemlist.php"><s><?= empty($res['c'])?'':$res['c'];?></s></a>
                    <p>性别：<span><?php echo ($result['gender']==1)?'女':'男';?></span></p>
                    <p>出生日期：<span><?php echo date('Y年m月d日',strtotime($result['birth_day']))?></span></p>
                    <!--                                                        <p>身高：<span>117.7cm</span></p>-->
                    <b></b>

                </li>
                <li>
                    <a class="a_box" href="/cn/ceanza_list.php">
                        <h4>成长日记</h4>
                        <p>替您的宝宝写下成长日記，为您的宝宝记录每天的成长与回忆......</p>
                        <i></i>
                        <div class="menu_logo"><img src="../content/epaper/images/ceanza.png" alt=""></div>
                    </a>
                </li>
                <li>
                    <a class="a_box" href="/cn/height_record_list.php">
                        <h4>身高记录</h4>
                        <p>记录您小孩子的身高，世界卫生组织(WHO)儿童身高......</p>
                        <i></i>
                        <div class="menu_logo height_record_img"><img src="../content/epaper/images/height_record.png" alt=""></div>
                    </a>
                </li>
                <li>
                    <a class="a_box" href="/cn/weight_record_list.php">
                        <h4>体重记录</h4>
                        <p>记录您小孩子的体重，世界卫生组织(WHO)统计全世界儿童的平均体重......</p>
                        <i></i>
                        <div class="menu_logo weight_record_img"><img src="../content/epaper/images/weight_record.png" alt=""></div>
                    </a>
                </li>
                <li>
                    <a class="a_box" href="/cn/buds_record.php">
                        <h4>萌芽记录</h4>
                        <p>记录您宝宝牙齿的成长时间，能够更了解您宝宝的营养吸收和生长发育......</p>
                        <i></i>
                        <div class="menu_logo buds_record_img"><img src="../content/epaper/images/buds_record.png" alt=""></div>
                    </a>
                </li>
                <li>
                    <a class="a_box" href="/cn/medical_record.php">
                        <h4>就诊记录</h4>
                        <p>每笔就诊记录都是日后珍贵的就医參考，同时也能了解宝宝......</p>
                        <i></i>
                        <div class="menu_logo medical_record_img"><img src="../content/epaper/images/medical_record.png" alt=""></div>
                    </a>
                </li>
            </ul>
        </section>
        <!-- InstanceEndEditable -->
    </section>
    <!--【Content End】-->

    <!--【Footer】-->
    <?php include 'inc_footer.html'; ?>
    <!--【Footer End】-->
</section>
<?php include 'inc_bottom_js.php'; ?>
</body>
<!-- InstanceEnd --></html>
