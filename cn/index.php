<?php
session_start();
include('inc.php');
?>
<!DOCTYPE html>
<html><!-- InstanceBegin template="/Templates/_page01.dwt" codeOutsideHTMLIsLocked="false" -->
<head>
    <?php include('inc_head.php');	?>
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
                    unset($_SESSION['user_token']);
                    unset($_SESSION['user_email']);
                    unset($_SESSION['user_credit']);
                    unset($_SESSION['user_epaper']);
                    unset($_SESSION['auth_code']);
                    unset($_SESSION['CURRENT_KID_UID']);
                    unset($_SESSION['CURRENT_KID_AGE']);
                    unset($_SESSION['question_uid']);
                    unset($_SESSION['answer_id']);

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
            unset($_SESSION['user_token']);
            unset($_SESSION['user_email']);
            unset($_SESSION['user_credit']);
            unset($_SESSION['user_epaper']);
            unset($_SESSION['auth_code']);
            unset($_SESSION['CURRENT_KID_UID']);
            unset($_SESSION['CURRENT_KID_AGE']);
            unset($_SESSION['question_uid']);
            unset($_SESSION['answer_id']);
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
    if($member_uid > 0) {
        $sql = "select first_name,email,cellphone,image_url from member where uid='$member_uid'";
        $result = M()->find($sql);
        if($result!=null) {
            $name = $result['first_name'];
            $email = $result['email'];
            $phone = $result['cellphone'];
            $image_url = (!empty($result['image_url']) && $result['image_url']!=' ')?$result['image_url']:'';
        }
        unset($result);
        unset($sql);
        $sql = "select nick_name,birth_day,gender from user where supervisor_uid='$member_uid'";
        $result = M()->find($sql);
        if($result!=null) {
            $nick_name = $result['nick_name'];
            $birth_day = $result['birth_day'];
            $gender = ($result['gender']==0?"男":"女");
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

        <!--//Slider Banner//-->
        <!--【註1】class="slider"為圖片區，clider-pg為分頁icon區,幾張圖對應幾個icon。-->
        <section class="sliderbox">
            <div class="iosSlider">
                <div class="slider">
                    <ul class="clearfix">
                        <li>
                            <div class="item">
                                <img src="../theme/cn/images/header/item_bnr01.png">
                            </div>
                        </li>
                        <li>
                            <div class="item">
                                <img src="../theme/cn/images/header/item_bnr02.png">
                            </div>
                        </li>
                        <li>
                            <div class="item">
                                <img src="../theme/cn/images/header/item_bnr03.png">
                            </div>
                        </li>
                    </ul>
                </div>
                <div class="slider-pg">
                    <div class="pgs">
                        <div class="item fst on"></div>
                        <div class="item"></div>
                        <div class="item"></div>
                    </div>
                </div>
            </div>
        </section>
        <!--//Slider Banner//-->

        <!--//主內容//-->
        <section class="indexcont">
            <section class="inbox">

                <!--//4 Banner//-->
                <section class="sbnr">
                    <ul class="clearfix">
                        <li><a href="#exbox01" class="fancybox"><img src="../theme/cn/images/content/item_sbnr01.png"></a></li>
                        <li><a href="javascript:onMenuItem3Click();"><img src="../theme/cn/images/content/item_sbnr02.png"></a></li>
                        <li><a href="javascript:onMenuItem2Click();"><img src="../theme/cn/images/content/item_sbnr03.png"></a></li>
                        <li><a href="javascript: void(0)" onclick="goUrlClick('report.php')"><img src="../theme/cn/images/content/item_sbnr04.png"></a></li>
                        <li><a href="recommend.php"><img src="../theme/cn/images/content/item_sbnr05.png"></a></li>
                        <li><a href="javascript:onMenuItem4Click();"><img src="../theme/cn/images/content/item_sbnr06.png"></a></li>
                    </ul>
                </section>
                <!--//4 Banner//-->

                <!--//【Fancybox】體驗流程//-->
                <?php include 'inc_trial.php'; ?>
                <!--//【Fancybox】體驗流程//-->

                <!--//首页三區塊//-->
                <section class="contbox clearfix">

                    <!--//推薦文章//-->
                    <!--【註1】固定四則訊息，最後一個給予class="m-none"是For手機不顯示用。 原本用 list01 fl, 改為 list02 不顯示圖片-->
                    <?php
                    if($_show_image) {
                        echo('<section class="list01 fl">');
                    }
                    else {
                        echo('<section class="list03 fl">');
                    }
                    ?>
                    <h3 class="title">最新消息</h3>
                    <?php
                    if(empty($phone)){
                        ?>
                        <a href="javascript:void(0)" class="bind_mobile">绑定手机赢好礼</a>
                        <?php
                    }
                    ?>

                    <a href="share_tips.php" class="recommend_tips">推荐好友送好礼</a>

                    <ul>
                        <li>
                            <h4>您的宝宝最近一次疫苗</h4>
                            <p>
                                <?php get_baby_vaccine(); ?>
                            </p>
                        </li>
                    </ul>
                    <?php af_articles_list_recommend('推荐'); ?>
                </section>
                <!--//推薦文章//-->

                <!--//最新消息//-->
                <!--【註1】固定五則訊息，最後二個給予class="m-none"是For手機不顯示用。-->
                <section class="list02 fl">
                    <h3 class="title">家长分享<a href="parental_sharing.php" class="i-more">更多内容</a></h3>

                    <?php index_grow_diary_list(); ?>
                </section>
                <!--//最新消息//-->

                <!--//右側Bnr//-->
                <section class="bnrlist fl">
                    <ul>
                        <li><a href="#fy-register" class="fancybox"><img src="../theme/cn/images/content/item_rbnr01.jpg"></a></li>
                    </ul>
                </section>
                <!--//右側Bnr//-->

            </section>
            <!--//首页三區塊//-->

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
    $(function(){
        <?php if(isset($_GET['ask_account']) && $_GET['ask_account']==1 && isset($_SESSION['wx_info'])){?>
        $.fancybox({
            href: "#fy-info-ask-account"
        });
        <?php }?>
    })
    $('.bind_mobile').click(function(){
        $.fancybox({
            href: "#fy-mobile-bind"
        });
    })
</script>
</body>
<!-- InstanceEnd --></html>
