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
        #content{padding-top: 0}
        h1,h2,h3,h4,h5,h6,p,ul,li,dl,dt,dd{margin:0;padding:0;list-style: none;}
        input,button{padding: 0;margin:0;border:0;outline: none;}
        img{vertical-align: bottom}
        .ceanza_menu_bg{padding-top: 125px;}
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

if(isset($_SESSION['user_token'])) {
    $member_uid = $CMEMBER->accessFromToken($_SESSION['user_token']);
}
if($member_uid > 0) {
    $sql = "select * from member where uid='$member_uid'";
    $result = M()->find($sql);
    if($result!=null) {
        $name = $result['first_name'];
        $email = $result['email'];
        $phone = $result['cellphone'];
        $fatherImage = (!empty($result['father_image']) && $result['father_image']!=' ')?$result['father_image']:'';
        $momImage = (!empty($result['mother_image']) && $result['mother_image']!=' ')?$result['mother_image']:'';
    }
    unset($result);
    unset($sql);
    $sql = "select nick_name,birth_day,gender,image_url from user where supervisor_uid='$member_uid'";
    $result = M()->find($sql);
    if($result!=null) {
        $nick_name = $result['nick_name'];
        $birth_day = $result['birth_day'];
        $gender = ($result['gender']==0?"男":"女");
        $babyImage = (!empty($result['image_url']) && $result['image_url']!=' ')?$result['image_url']:'';
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
            <div class="ceanza_menu_bg">
                <h4>成长日记</h4>
                <section class="gopath goback"><a href="index.php">首页</a> > 成长日记</section>
                <div class="photos">

                    <div class="father-head-portrait">
                        <div class="upHead">
                            <?php if($fatherImage){?>
                                <img src=<?= $fatherImage?> alt=""  class="userHead"  >
                            <?php }else{ ?>
                                <img src="../content/epaper/images/father.png" alt=""  class="noHead">
                            <?php } ?>
                            <b></b>
                            <p></p>
                            <form action="head_sculpture.php" class="personForm" method="post" enctype="multipart/form-data">
                                <input type="file" name="file" accept="image/png,image/jpg,image/jpeg" class="personImgfile">
                                <input hidden="" name="type" value="father" />
                            </form>
                        </div>
                        <span>宝爸</span>
                    </div>
                    <div class="baby-head-portrait">
                        <div class="upHead">
                            <?php if($babyImage){?>
                                <img src=<?= $babyImage?> alt=""  class="userHead"  >
                            <?php }else{ ?>
                                <img src="../content/epaper/images/baby.png" alt=""  class="noHead">
                            <?php } ?>
                            <b></b>
                            <p></p>
                            <form action="head_sculpture.php" class="babyForm" method="post" enctype="multipart/form-data">
                                <input type="file" name="file" accept="image/png,image/jpg,image/jpeg" class="babyImgfile">
                                <input hidden="" name="type" value="baby" />
                            </form>
                        </div>
                        <span>宝宝</span>
                    </div>
                    <div class="mather-head-portrait">
                        <div class="upHead">
                            <?php if($momImage){?>
                                <img src=<?= $momImage?> alt=""  class="userHead"  >
                            <?php }else{ ?>
                                <img src="../content/epaper/images/mather.png" alt=""  class="noHead">
                            <?php } ?>
                            <b></b>
                            <p></p>
                            <form action="head_sculpture.php" class="momForm" method="post" enctype="multipart/form-data">
                                <input type="file" name="file" accept="image/png,image/jpg,image/jpeg" class="momImgfile">
                                <input hidden="" name="type" value="mother" />
                            </form>
                        </div>
                        <span>宝妈</span>
                    </div>
                </div>
            </div>
            <ul class="ceanza-menu">
                <li class="selected">
                    <?php
                    $uid = $CMEMBER->getUserId();
                    $sql  = 'select * from user where supervisor_uid='.$uid;
                    $result = M()->find($sql);
                    ?>
                    <h4><?php echo $result['nick_name'];?></h4>
                    <?php
                    $age = $_SESSION['CURRENT_KID_AGE'];
                    $start_age = $age-1;
                    $end_age = $age+4;
                    $itemSql = "select grow_index.uid,grow_index.text,grow_index.age_max,grow_index.age_min,grow_log.early from grow_index LEFT JOIN grow_log on grow_log.item_uid=grow_index.uid where grow_log.user_uid='$uid' and (grow_index.age_min >= '$start_age' and grow_index.age_min<= '$end_age') or (grow_index.age_max <= '$end_age' and grow_index.age_max >= '$start_age') order by uid asc";
                    $itemCount = count(M()->query($itemSql));
                    ?>
                    <s><?=$itemCount?></s>
                    <p>性别：<span><?php echo ($result['gender']==1)?'女':'男';?></span></p>
                    <p>出生日期：<span><?php echo date('Y年m月d日',strtotime($result['birth_day']))?></span></p>
                    <!--<p>身高：<span>117.7cm</span></p>-->
                </li>
                <li>
                    <a class="a_box" href="/cn/ceanza_list.php">
                        <h4>成长记录</h4>
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
<script>


    $('.personImgfile').on('change', function(){
        $(this).closest('form').submit();
        $('.personForm').submit();
    });
    $('.babyImgfile').on('change', function(){
        $(this).closest('form').submit();
        $('.babyForm').submit();
    });
    $('.momImgfile').on('change', function(){
        $(this).closest('form').submit();
        $('.momForm').submit();
    });
</script>
</body>
<!-- InstanceEnd --></html>
