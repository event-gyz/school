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
            echo ('<script type="text/javascript"> $(function(){document.location.href ="http://x.eqxiu.com/s/PclsbuXT";});</script>');
        }
    }
}



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
    $sql = "select nick_name,birth_day,gender,image_url from user where supervisor_uid='$member_uid'";
    $result = M()->find($sql);
    if($result!=null) {
        $nick_name = $result['nick_name'];
        $birth_day = $result['birth_day'];
        $image_url = (!empty($result['image_url']) && $result['image_url']!=' ')?$result['image_url']:'';
        $gender = ($result['gender']==0?"男":"女");
    }
    $weightSql = "select * from wap_weight where uid='$member_uid' order by `date` desc limit 1";
    $weightResult = M()->find($weightSql);
    if(!empty($weightResult['weight'])){
        $weight = $weightResult['weight'];
        $wtime = $weightResult['date'];
    }else{
        $weight = '';
        $wtime = '';
    }
    $heightSql = "select * from wap_height where uid='$member_uid' order by `date` desc limit 1";
    $heightResult = M()->find($heightSql);
    if(!empty($heightResult['height'])){
        $height = $heightResult['height'];
        $htime = $heightResult['date'];
    }else{
        $height = '';
        $htime = '';
    }
    if($wtime > $htime){
        $lasttime = $wtime;
    }else{
        $lasttime = $htime;
    }

}

?>
<!-- InstanceBeginEditable name="wrap" -->
<section id="wrap" class="inpage">
    <!-- InstanceEndEditable -->

    <!--【Header】-->
    <?php include 'inc_header.php'; ?>
    <!--【Header End】-->
    <!--【Content】-->
    <section id="content">
        <!-- InstanceBeginEditable name="content" -->

        <!--//主內容//-->
        <section class="indexcont newcomers">
            <section class="inbox noBoxShadowPage">
                <section class="contbox clearfix">
                    <!-- InstanceBeginEditable name="content" -->
                    <section class="baby_info">
                        <div class="baby-head-portrait">
                            <div class="upHead">
                                <?php if($image_url){?>
                                    <img src=<?= $image_url?>  alt=""  class="userHead">
                                <?php }else{ ?>
                                    <img src="../content/epaper/images/baby.png" alt=""  class="noHead">
                                <?php } ?>
                                <b></b>
                                <p></p>
                                <form action="head_sculpture.php" class="babyForm" method="post" enctype="multipart/form-data">
                                    <!-- <input type="file" name="file" accept="image/png,image/jpg,image/jpeg" class="imgfile"> -->
                                    <div class="clipper">
                                        <input class="clipper_input babyfile"
                                               ref="input"
                                               type="file"
                                               accept="image/gif,image/jpeg,image/png,image/bmp,image/jpg"
                                        >
                                    </div>
                                    <input hidden="" name="type" value="baby" />
                                </form>
                            </div>
                            <span><?=$nick_name?></span>
                        </div>
                        <ul class="info_list">
                            <li>
                                <p class="date"></p>
                                <span>测量日期：</span>
                                <input type="text" value="<?=$lasttime?>" disabled>
                            </li>
                            <li>
                                <p class="birthday"></p>
                                <span>生日：</span>
                                <a href="javascript: void(0)"><input class="birthday_time" type="text" value="<?=$birth_day?>" disabled></a>
                            </li>
                            <li>
                                <p class="gender"></p>
                                <span>性别：</span>
                                <a href="javascript: void(0)"><input type="text" value="<?=$gender?>" disabled></a>
                            </li>
                            <?php if(!empty($height)){?>
                                <li>
                                    <p class="height"></p>
                                    <span>身高(公分)：</span>
                                    <input type="text" value="<?=$height?>" disabled>
                                </li>
                            <?php }?>
                            <?php if(!empty($weight)){?>
                                <li>
                                    <p class="weight"></p>
                                    <span>体重(公斤)：</span>
                                    <input type="text" value="<?=$weight?>" disabled>
                                </li>
                            <?php }?>
                        </ul>
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
</body>
<script type="text/javascript">

    var clipper = null,imgElm = undefined;
    clipper = new Clipper()

    $('.babyfile').on('change', function(e){
        let resultObj = imgElm // 预览对象
        clipper.clip(e, {
            resultObj,
            aspectRatio : 1
        })
        clipper.confirm(function(file){
            // formData
            let fd = new FormData()
            // 上传头像参数
            fd.append('file', file)
            fd.append('type', 'baby')
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
        // $('.babyForm').submit();
    });

    $('.info_list a').click(function(){
        showEditBabyBox()
        var birthday = $('.birthday_time').val()
        var years = parseInt(birthday.split('-')[0])
        var months = parseInt(birthday.split('-')[1])
        var days = parseInt(birthday.split('-')[2])
        $('#birth_box_years').val(years)
        $('#birth_box_months').val(months)
        $('#birth_box_days').val(days)
    })


</script>
<!-- InstanceEnd --></html>
