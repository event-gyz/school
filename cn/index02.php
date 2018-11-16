<?php
session_start();
include('inc.php');
if(isset($_GET['id'])&&!empty($_GET['id'])){
    $_SESSION['agency_id'] = $_GET['id'];
}
?>
<!DOCTYPE html>
<html><!-- InstanceBegin template="/Templates/_page01.dwt" codeOutsideHTMLIsLocked="false" -->
<head>
    <?php include('inc_head.php');	?>
    <style>
        body{background:#FFFFFF;}
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
    <div class="index">
        <div class="swiper-container">
            <div class="swiper-wrapper">
                <div class="swiper-slide"><img src="../content/epaper/images/index_banner01.jpg" alt=""></div>
                <div class="swiper-slide"><img src="../content/epaper/images/index_banner02.jpg" alt=""></div>
                <div class="swiper-slide"><img src="../content/epaper/images/index_banner03.jpg" alt=""></div>
                <div class="swiper-slide"><img src="../content/epaper/images/index_banner04.jpg" alt=""></div>
            </div>
            <div class="swiper-pagination"></div>
        </div>
        <div class="icon_list">
            <ul>
                <li>
                    <p><img src="../content/epaper/images/icon_list01.png" alt=""></p>
                    <span>小测牛刀</span>
                </li>
                <li>
                    <p><img src="../content/epaper/images/icon_list02.png" alt=""></p>
                    <span>豆妈学院</span>
                </li>
                <li>
                    <p><img src="../content/epaper/images/icon_list03.png" alt=""></p>
                    <span>育儿天地</span>
                </li>
                <li>
                    <p><img src="../content/epaper/images/icon_list04.png" alt=""></p>
                    <span>家庭早教</span>
                </li>
                <li>
                    <p><img src="../content/epaper/images/icon_list05.png" alt=""></p>
                    <span>身高纪录</span>
                </li>
                <li>
                    <p><img src="../content/epaper/images/icon_list06.png" alt=""></p>
                    <span>体重记录</span>
                </li>
                <li>
                    <p><img src="../content/epaper/images/icon_list07.png" alt=""></p>
                    <span>疫苗记录</span>
                </li>
                <li>
                    <p><img src="../content/epaper/images/icon_list08.png" alt=""></p>
                    <span>成长日记</span>
                </li>
            </ul>
        </div>
        <div class="tips_list">
            <p><a href="#">绑定手机，有好礼相送</a></p>
            <p><a href="#">好东西值得分享，快去分享给好友吧？还有惊喜等着你哦~</a></p>
            <p><a href="#">宝宝3个月了，已经打过四次疫苗了，来看看吧</a></p>
        </div>
        <div class="today_updated">
            <p>今日已更新</p>
            <div class="recommended_courses">
                <div class="recommend_more">
                    <p><a href="#">更多></a></p>
                    推荐课程
                </div>
                <ul class="recommended_courses_list">
                    <li>
                        <p><img src="../content/epaper/images/recommended_courses01.jpg" alt=""></p>
                        <div class="recommended_courses_title">
                            <h4>心理学专栏</h4>
                            <p>如何通过运动建立孩子的高情商</p>
                            <div class="name_time">
                                <p>讲师：许婴宁</p>
                                <span>时间：2018年8月31日19:00</span>
                            </div>
                        </div>
                    </li>
                    <li>
                        <p><img src="../content/epaper/images/recommended_courses02.jpg" alt=""></p>
                        <div class="recommended_courses_title">
                            <h4>婴幼护理专栏</h4>
                            <p>宝宝运动不可少，怎么运动才算好</p>
                            <div class="name_time">
                                <p>讲师：宋美莳</p>
                                <span>时间：2018年8月30日19:00</span>
                            </div>
                        </div>
                    </li>
                </ul>
            </div>
            <div class="recommended_articles">
                <div class="recommend_more">
                    <p><a href="#">更多></a></p>
                    推荐文章
                </div>
                <ul class="recommended_articles_list">
                    <li>
                        <p><img src="../content/epaper/images/recommended_articles01.jpg" alt=""></p>
                        <div class="recommended_articles_title">
                            <h4>5—6岁宝宝适合的玩具</h4>
                            <p>这时候的孩子语言能力突飞猛进，可以藉由发问、交谈与观察来学习。对小孩健康又活泼，但根据研究显示</p>
                        </div>
                    </li>
                    <li>
                        <p><img src="../content/epaper/images/recommended_articles02.jpg" alt=""></p>
                        <div class="recommended_articles_title">
                            <h4>为什么我的小孩是过动儿？</h4>
                            <p>每个爸爸妈妈都希望自己的小孩健康又活泼，但根据研究显示，过动小孩健康又活泼，但根据研究显示</p>
                        </div>
                    </li>
                </ul>
            </div>
        </div>
    </div>
    <!-- InstanceEndEditable -->

<!--【Footer】-->
<?php include 'inc_footer.html'; ?>
<!--【Footer End】-->

</section>
<?php include 'inc_bottom_js.php'; ?>

<script>
    new Swiper('.swiper-container', {
        navigation: {
            nextEl: '.swiper-button-next',
            prevEl: '.swiper-button-prev'
        },
        pagination: {
            el: '.swiper-pagination'
        },
        autoplay: true,
        observer: true,
        observeParents: true
    })
</script>

</body>
<!-- InstanceEnd --></html>
