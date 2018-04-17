<?php
session_start();
include('inc.php');
?>
<!DOCTYPE html>
<html><!-- InstanceBegin template="/Templates/_page01.dwt" codeOutsideHTMLIsLocked="false" -->
<head>
    <?php include('inc_head.php');  ?>
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

        <!--//主內容//-->
        <section class="indexcont baby_vaccine">
            <section class="inbox noBoxShadowPage">
                <section class="contbox clearfix">

                    <!--//主選單標題與路徑//-->
                    <h2 class="title">宝宝疫苗</h2>
                    <section class="gopath"><a href="index.php">首页</a> > 宝宝疫苗</section>
                </section>
                <p><img src="../content/epaper/images/baby_vaccine.jpg" alt=""></p>
                <!--//主選單標題與路徑//-->
                <table class="vaccine_info">
                    <thead>
                        <tr>
                            <th class="inoculation_time">接种时间</th>
                            <th class="age">年龄</th>
                            <th class="vaccine_name">疫苗名称</th>
                            <th class="frequency">次数</th>
                            <th class="prevent_disease">可防的疾病</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td rowspan="2">2018年3月17日</td>
                            <td rowspan="2">出生时</td>
                            <td>乙肝疫苗</td>
                            <td>第一次</td>
                            <td>乙型病毒性肝炎</td>
                        </tr>
                        <tr>
                            <td>卡介苗</td>
                            <td>第一次</td>
                            <td>结核病</td>
                        </tr>
                        <tr>
                            <td>2018年4月17日</td>
                            <td>1月龄</td>
                            <td>乙肝疫苗</td>
                            <td>第二次</td>
                            <td>乙型病毒性肝炎</td>
                        </tr>
                        <tr>
                            <td>2018年5月17日</td>
                            <td>2月龄</td>
                            <td>脊灰疫苗</td>
                            <td>第一次</td>
                            <td>脊髓灰质炎(小儿麻痹)</td>
                        </tr>
                        <tr>
                            <td rowspan="2">2018年6月17日</td>
                            <td rowspan="2">3月龄</td>
                            <td>脊灰疫苗</td>
                            <td>第二次</td>
                            <td>脊髓灰质炎(小儿麻痹)</td>
                        </tr>
                        <tr>
                            <td>无细胞百日破疫苗</td>
                            <td>第一次</td>
                            <td>百日咳、白喉、破伤风</td>
                        </tr>
                        <tr>
                            <td rowspan="2">2018年7月17日</td>
                            <td rowspan="2">4月龄</td>
                            <td>脊灰疫苗</td>
                            <td>第三次</td>
                            <td>脊髓灰质炎(小儿麻痹)</td>
                        </tr>
                        <tr>
                            <td>无细胞百日破疫苗</td>
                            <td>第二次</td>
                            <td>百日咳、白喉、破伤风</td>
                        </tr>
                        <tr>
                            <td></td>
                            <td>5月龄</td>
                            <td>无细胞百日破疫苗</td>
                            <td>第三次</td>
                            <td>百日咳、白喉、破伤风</td>
                        </tr>
                        <tr>
                            <td rowspan="2"></td>
                            <td rowspan="2">6月龄</td>
                            <td>乙肝疫苗</td>
                            <td>第三次</td>
                            <td>乙型病毒性肝炎</td>
                        </tr>
                        <tr>
                            <td>流脑疫苗</td>
                            <td>第一次</td>
                            <td>流行性脑脊髓膜炎</td>
                        </tr>
                        <tr>
                            <td></td>
                            <td>8月龄</td>
                            <td>麻疹疫苗</td>
                            <td>第一次</td>
                            <td>麻疹</td>
                        </tr>
                        <tr>
                            <td></td>
                            <td>9月龄</td>
                            <td>流脑疫苗</td>
                            <td>第二次</td>
                            <td>流行性脑脊髓膜炎</td>
                        </tr>
                        <tr>
                            <td></td>
                            <td>1岁</td>
                            <td>乙脑减毒疫苗</td>
                            <td>第一次</td>
                            <td>流行性乙型脑炎</td>
                        </tr>
                        <tr>
                            <td rowspan="3"></td>
                            <td rowspan="3">1.5岁</td>
                            <td>甲肝疫苗</td>
                            <td>第一次</td>
                            <td>甲型病毒性肝炎</td>
                        </tr>
                        <tr>
                            <td>无细胞百日破疫苗</td>
                            <td>第四次</td>
                            <td>百日咳、白喉、破伤风</td>
                        </tr>
                        <tr>
                            <td>麻风腮疫苗</td>
                            <td>第一次</td>
                            <td>麻疹、风疹、腮腺炎</td>
                        </tr>
                        <tr>
                            <td rowspan="2"></td>
                            <td rowspan="2">2岁</td>
                            <td>乙脑减毒疫苗</td>
                            <td>第二次</td>
                            <td>流行性乙型脑炎</td>
                        </tr>
                        <tr>
                            <td>甲肝疫苗(与前剂间隔6-12个月)</td>
                            <td>第二次</td>
                            <td>甲型病毒性肝炎</td>
                        </tr>
                        <tr>
                            <td></td>
                            <td>3岁</td>
                            <td>A+C流脑疫苗</td>
                            <td>加强</td>
                            <td>流行性脑脊髓膜炎</td>
                        </tr>
                        <tr>
                            <td></td>
                            <td>4岁</td>
                            <td>脊灰疫苗</td>
                            <td>第四次</td>
                            <td>脊髓灰质炎(小儿麻痹)</td>
                        </tr>
                        <tr>
                            <td rowspan="3"></td>
                            <td rowspan="3">6岁</td>
                            <td>无细胞百日破疫苗(白破)</td>
                            <td>加强</td>
                            <td>百日咳、白喉、破伤风</td>
                        </tr>
                        <tr>
                            <td>麻风腮疫苗</td>
                            <td>第二次</td>
                            <td>麻疹、风疹、腮腺炎</td>
                        </tr>
                        <tr>
                            <td>乙脑减毒疫苗</td>
                            <td>第三次</td>
                            <td>流行性乙型脑炎</td>
                        </tr>
                    </tbody>
                </table>
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
<!-- InstanceEnd --></html>
