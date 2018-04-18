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
                            <td rowspan="2"
                                <?php if(strtotime($birth_day)<time()){
                                    echo 'style="color: #B9B9B9;"';
                                }?>

                            ><?php
                                if(!empty($birth_day)){
                                    echo date('Y年m月d日',strtotime($birth_day));
                                }
                                ?></td>
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
                            <td
                                <?php if(strtotime("+1 months", strtotime($birth_day))<time()){
                                    echo 'style="color: #B9B9B9;"';
                                }?>
                            ><?php
                                if(!empty($birth_day)){
                                    echo date("Y年m月d日", strtotime("+1 months", strtotime($birth_day)));
                                }
                                ?></td>
                            <td>1月龄</td>
                            <td>乙肝疫苗</td>
                            <td>第二次</td>
                            <td>乙型病毒性肝炎</td>
                        </tr>
                        <tr>
                            <td <?php if(strtotime("+2 months", strtotime($birth_day))<time()){
                                echo 'style="color: #B9B9B9;"';
                            }?>
                            ><?php
                                if(!empty($birth_day)){
                                    echo date("Y年m月d日", strtotime("+2 months", strtotime($birth_day)));
                                }
                                ?></td>
                            <td>2月龄</td>
                            <td>脊灰疫苗</td>
                            <td>第一次</td>
                            <td>脊髓灰质炎(小儿麻痹)</td>
                        </tr>
                        <tr>
                            <td rowspan="2" <?php if(strtotime("+3 months", strtotime($birth_day))<time()){
                                echo 'style="color: #B9B9B9;"';
                            }?>
                            ><?php
                                if(!empty($birth_day)){
                                    echo date("Y年m月d日", strtotime("+3 months", strtotime($birth_day)));
                                }
                                ?></td>
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
                            <td rowspan="2" <?php if(strtotime("+4 months", strtotime($birth_day))<time()){
                                echo 'style="color: #B9B9B9;"';
                            }?>
                            ><?php
                                if(!empty($birth_day)){
                                    echo date("Y年m月d日", strtotime("+4 months", strtotime($birth_day)));
                                }
                                ?></td>
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
                            <td <?php if(strtotime("+5 months", strtotime($birth_day))<time()){
                                echo 'style="color: #B9B9B9;"';
                            }?>
                            ><?php
                                if(!empty($birth_day)){
                                    echo date("Y年m月d日", strtotime("+5 months", strtotime($birth_day)));
                                }
                                ?></td>
                            <td>5月龄</td>
                            <td>无细胞百日破疫苗</td>
                            <td>第三次</td>
                            <td>百日咳、白喉、破伤风</td>
                        </tr>
                        <tr>
                            <td rowspan="2" <?php if(strtotime("+6 months", strtotime($birth_day))<time()){
                                echo 'style="color: #B9B9B9;"';
                            }?>
                            ><?php
                                if(!empty($birth_day)){
                                    echo date("Y年m月d日", strtotime("+6 months", strtotime($birth_day)));
                                }
                                ?></td>
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
                            <td <?php if(strtotime("+8 months", strtotime($birth_day))<time()){
                                echo 'style="color: #B9B9B9;"';
                            }?>
                            ><?php
                                if(!empty($birth_day)){
                                    echo date("Y年m月d日", strtotime("+8 months", strtotime($birth_day)));
                                }
                                ?></td>
                            <td>8月龄</td>
                            <td>麻疹疫苗</td>
                            <td>第一次</td>
                            <td>麻疹</td>
                        </tr>
                        <tr>
                            <td <?php if(strtotime("+9 months", strtotime($birth_day))<time()){
                                echo 'style="color: #B9B9B9;"';
                            }?>
                            ><?php
                                if(!empty($birth_day)){
                                    echo date("Y年m月d日", strtotime("+9 months", strtotime($birth_day)));
                                }
                                ?></td>
                            <td>9月龄</td>
                            <td>流脑疫苗</td>
                            <td>第二次</td>
                            <td>流行性脑脊髓膜炎</td>
                        </tr>
                        <tr>
                            <td <?php if(strtotime("+1 years", strtotime($birth_day))<time()){
                                echo 'style="color: #B9B9B9;"';
                            }?>
                            ><?php
                                if(!empty($birth_day)){
                                    echo date("Y年m月d日", strtotime("+1 years", strtotime($birth_day)));
                                }
                                ?></td>
                            <td>1岁</td>
                            <td>乙脑减毒疫苗</td>
                            <td>第一次</td>
                            <td>流行性乙型脑炎</td>
                        </tr>
                        <tr>
                            <td rowspan="3" <?php if(strtotime("+18 months", strtotime($birth_day))<time()){
                                echo 'style="color: #B9B9B9;"';
                            }?>
                            ><?php
                                if(!empty($birth_day)){
                                    echo date("Y年m月d日", strtotime("+18 months", strtotime($birth_day)));
                                }
                                ?></td>
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
                            <td rowspan="2" <?php if(strtotime("+2 years", strtotime($birth_day))<time()){
                                echo 'style="color: #B9B9B9;"';
                            }?>
                            ><?php
                                if(!empty($birth_day)){
                                    echo date("Y年m月d日", strtotime("+2 years", strtotime($birth_day)));
                                }
                                ?></td>
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
                            <td <?php if(strtotime("+3 years", strtotime($birth_day))<time()){
                                echo 'style="color: #B9B9B9;"';
                            }?>
                            ><?php
                                if(!empty($birth_day)){
                                    echo date("Y年m月d日", strtotime("+3 years", strtotime($birth_day)));
                                }
                                ?></td>
                            <td>3岁</td>
                            <td>A+C流脑疫苗</td>
                            <td>加强</td>
                            <td>流行性脑脊髓膜炎</td>
                        </tr>
                        <tr>
                            <td <?php if(strtotime("+4 years", strtotime($birth_day))<time()){
                                echo 'style="color: #B9B9B9;"';
                            }?>
                            ><?php
                                if(!empty($birth_day)){
                                    echo date("Y年m月d日", strtotime("+4 years", strtotime($birth_day)));
                                }
                                ?></td>
                            <td>4岁</td>
                            <td>脊灰疫苗</td>
                            <td>第四次</td>
                            <td>脊髓灰质炎(小儿麻痹)</td>
                        </tr>
                        <tr>
                            <td rowspan="3" <?php if(strtotime("+6 years", strtotime($birth_day))<time()){
                                echo 'style="color: #B9B9B9;"';
                            }?>
                            ><?php
                                if(!empty($birth_day)){
                                    echo date("Y年m月d日", strtotime("+6 years", strtotime($birth_day)));
                                }
                                ?></td>
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
