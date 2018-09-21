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
                    echo('<script type="text/javascript">$(function(){$.fancybox({        href: "#fcb_pw_reset"    }    );});</script>');
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
<?php
include("inc_fancyboxes.php");
?>
<!-- InstanceBeginEditable name="wrap" -->
<section id="wrap">
    <!--【Header】-->
    <?php //include 'inc_header.php'; ?>
    <!--【Header End】-->
    <!-- InstanceEndEditable -->
    <div class="index">
        <div class="top_banner">
            <div class="message">
                <b></b>
            </div>
            <div class="sign_in"></div>
            <div class="login_name">ZICO</div>
            <div class="login_age">
                <p>早上好~</p>
                <span>今天你5岁1个月3天啦</span>
            </div>
        </div>
        <div class="index_info">
            <ul class="month">
                <li>
                    <p>6个月零1天</p>
                </li>
                <li class="current">
                    <p>6个月零3天</p>
                    <span>9月30日</span>
                </li>
                <li>
                    <p>6个月零30天</p>
                </li>
            </ul>
            <p>妈妈，我已经爬的很快了，我想学走路。</p>
            <ul class="category">
                <li class="height">
                    <p>
                        <b></b>
                    </p>
                    <span>38.6-45.3cm</span>
                </li>
                <li class="weight">
                    <p>
                        <b></b>
                    </p>
                    <span>18-24kg</span>
                </li>
                <li class="vaccine">
                    <p>
                        <b></b>
                    </p>
                </li>
            </ul>
        </div>
        <div class="todolist">
            <ul class="todolist_category">
                <li class="current">成长日记</li>
                <li>生长发育</li>
                <li>疫苗接种</li>
            </ul>
            <ul class="todoitems">
                <li class="measure_body">
                    <b></b>
                    <p>您已经有85天没有给默默测量身高体重了</p>
                </li>
                <li class="share">
                    <b></b>
                    <p>好东西值得分享，快去分享给好友吧！</p>
                </li>
                <li class="vaccine">
                    <b></b>
                    <p>宝宝9个月了，已经打过四次疫苗了没来看看吧！</p>
                </li>
            </ul>
        </div>
        <div class="keep_diary">
            <div class="small_title">
                <i></i>
                <b></b>
                <p>写日记</p>
            </div>
            <div class="diary_info">
                <i></i>
                <s></s>
                <div class="diary_date">
                    <h2>暑假第一天</h2>
                    <div class="date">
                        <b>16</b>
                        <div class="month">
                            <p>AUG</p>
                            <span>2018</span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="diary_operation">
                <ul>
                    <li class="likes">
                        <b></b>
                        <span>33</span>
                    </li>
                    <li class="edit">
                        <b></b>
                        <span>50</span>
                    </li>
                    <li class="share">
                        <b></b>
                        <span>19</span>
                    </li>
                    <li class="delete">
                        <b></b>
                    </li>
                </ul>
                <p>全文</p>
            </div>
            <div class="comment">
                <ul>
                    <li>
                        <p><img src="../content/epaper/images/commentator01.png" alt=""></p>
                        <span>奶奶：哈哈 太淘气了 像他爸爸小时候</span>
                    </li>
                    <li>
                        <p><img src="../content/epaper/images/commentator02.png" alt=""></p>
                        <span>NINI：好可爱 \(//V//)\</span>
                    </li>
                    <li>
                        <p></p>
                        <span></span>
                    </li>
                </ul>
            </div>
        </div>
    </div>
    <!-- InstanceEndEditable -->
</section>
<!--【Content End】-->
<!--【Footer】-->
<?php include 'inc_footer.html'; ?>
<!--【Footer End】-->
<?php include 'inc_bottom_js.php'; ?>
</body>
<!-- InstanceEnd --></html>
