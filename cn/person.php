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
<section id="wrap" class="inpage">
    <!-- InstanceEndEditable -->

    <!--【Header】-->
    <?php include 'inc_header.php'; ?>
    <!--【Header End】-->
    <?php
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
            $membership = $result['membership'];
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
    ?>
    <!--【Content】-->
    <section id="content">
        <!-- InstanceBeginEditable name="content" -->

        <!--//主內容//-->
        <section class="indexcont newcomers">
            <section class="inbox noBoxShadowPage">
                <section class="contbox clearfix">
                    <!-- InstanceBeginEditable name="content" -->
                    <section class="person">
                        <div class="parent-head-portrait">
                            <div class="upHead">
                                <?php if($image_url){?>
                                    <img src=<?= $image_url?> alt=""  class="userHead">
                                <?php }else{ ?>
                                    <img src="../content/epaper/images/parent.png" alt=""  class="noHead">
                                <?php } ?>
                                <b></b>
                                <p></p>
                                <!-- <form action="head_sculpture.php"  method="post" enctype="multipart/form-data"> -->
                                <div class="clipper">
                                    <input class="clipper_input imgfile"
                                           ref="input"
                                           type="file"
                                           accept="image/gif,image/jpeg,image/png,image/bmp,image/jpg"
                                    >
                                </div>
                                <!-- <input hidden="" name="type" value="person" /> -->
                                <!-- </form> -->
                            </div>
                            <span>家长已登录</span>
                            <!--                            <a href="javascript: void(0)">积分：100积分</a>-->
                        </div>
                        <ul class="info_list">
                            <li>
                                <a href="#fy-modify" class="basic-info">
                                    <p class="account"></p>
                                    <span>账号资料</span>
                                    <input type="text" value="<?=$_SESSION['user_email']?>" disabled>
                                </a>
                            </li>
                            <li>
                                <p class="mobile"></p>
                                <span>电话</span>
                                <?php
                                if(!empty($phone)){
                                    ?>
                                    <input type="phone" value="<?=$phone?>" disabled>
                                    <?php
                                }else{
                                    ?>
                                    <a style="float: right;width: 4.4878rem;height: 1.0732rem;text-align: right;color:#C84040;padding:0;font-size: 0.3902rem;" class="bind_mobile"><b>绑定手机送好礼</b></a>
                                    <?php
                                }
                                ?>

                            </li>
                            <li class="baby_infos">
                                <a href="baby_info.php">
                                    <i></i>
                                    <p class="info"></p>
                                    <span>宝宝信息</span>
                                    <input type="text" value="<?=$nick_name?>" disabled>
                                </a>
                            </li>
                            <li>
                                <i></i>
                                <p class="consultation"></p>
                                <span>专家咨询</span>
                            </li>
                            <li>
                                <a href="share_tips.php" class="recommend_friends"><b>推荐好友送好礼</b></a>
                                <p class="recommend"></p>
                                <span>推荐好友</span>
                            </li>
                            <li>
                                <input type="text" value="<?= date('Y年m月d日',$membership)?>" disabled>
                                <p class="expiry_date"></p>
                                <span>会员截止日期</span>
                            </li>
                        </ul>
                        <!--                        <div class='set_meal_info'>-->
                        <!--                            <h3>免费体验<i>3</i>个月</h3>-->
                        <!--                            <span>3个月后1200项指标测验将对您暂停服务</span>-->
                        <!--                            <div class="half_year_member">-->
                        <!--                                <div class="member_name">-->
                        <!--                                    <p><i>半年</i>超级会员</p>-->
                        <!--                                    <span>享用最全面的宝贝成长记录</span>-->
                        <!--                                </div>-->
                        <!--                                <div class="member_price">¥39.00</div>-->
                        <!--                            </div>-->
                        <!--                            <div class="one_year_member">-->
                        <!--                                <div class="member_name">-->
                        <!--                                    <p><i>一年</i>尊享会员</p>-->
                        <!--                                    <span>享用最全面的宝贝成长记录</span>-->
                        <!--                                </div>-->
                        <!--                                <div class="member_price">¥69.00</div>-->
                        <!--                            </div>-->
                        <!--                        </div>-->
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
<script type="text/javascript">
    var clipper = null,imgElm = undefined;
    clipper = new Clipper()

    $('.imgfile').on('change', function(e){
        let resultObj = imgElm // 预览对象
        clipper.clip(e, {
            resultObj,
            aspectRatio : 1
        })
        clipper.confirm(function(file){
            // formData
            let fd = new FormData()
            // 上传头像参数
            fd.append('type', 'person')
            fd.append('file', file)  // 通过append向form对象添加数据

            // 调用接口
            $.ajax({
                url: "head_sculpture.php",
                type: 'post',
                data: fd,
                dataType: 'json',
                processData: false,
                contentType: false,
                success: function (jsonStr) {
                    if(jsonStr.errno=='1') {
                        window.location.reload();
                    }
                },
            });
        })
        // $(this).closest('form').submit();

    });
    $('.basic-info').click(function(){
        $.fancybox({href: "#fy-modify"});
    })

    $('.bind_mobile').click(function(){
        $.fancybox({
            href: "#fy-mobile-bind"
        });
    })


</script>
<?php include 'inc_bottom_js.php'; ?>
</body>
<!-- InstanceEnd --></html>
