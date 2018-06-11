<?php
session_start();
include('inc.php');
?>
<!DOCTYPE html>
<html><!-- InstanceBegin template="/Templates/_page01.dwt" codeOutsideHTMLIsLocked="false" -->
<head>
    <?php include('inc_head.php');	?>
    <style>
        body{background: #fff;}
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
<section id="wrap">
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

                    <!--//主選單標題與路徑//-->
                    <h2 class="title">新手上路</h2>
                    <section class="gopath"><a href="index.php">首页</a> > 新手上路</section>
                    <p><img src="../content/epaper/images/newcomers_logo.jpg" alt=""></p>
                    <!--//主選單標題與路徑//-->

                    <dl class="newcomers_guide">
                        <dt>
                            <i></i>
                        <p>为什么要记录宝宝的成长？</p>
                        </dt>
                        <dd>
                            <p>很久之前，我们几乎把体重当成衡量宝宝发育是否良好的唯一标准。 </p>
                            <p>很久之前，我们宝宝长得好不好，几乎是跟别人家的孩子“比”出来的。</p>
                            <p>很久之前，我们都习惯把身高记在门框上。</p>
                            <br>
                            <p>我们衡量、比较、记录。</p>
                            <p>我们希望知道宝宝的健康状态，希望留下这些承载着宝宝成长发育的珍贵数字，希望在宝宝发育出现偏差的时候，可以准确地为医生提供一些有价值的信息以供参考。</p>
                            <br>
                            <br>
                            <p>测量生长发育曲线的意义</p>
                            <p>通过记录和绘制生长发育曲线，我们可以清楚的了解在同龄儿童中，我们宝宝所处的位置，客观的了解宝宝到底“长得好不好”。</p>
                            <p>对于早产儿、低体重儿，可以评估宝宝生长追赶的情况。</p>
                            <p>短期来看，曲线能够敏感的反应出宝宝是否得到了充足的饮食和合理照料。</p>
                            <p>长远来看，通过监测生长发育曲线的轨迹，我们可以评估甚至预测宝宝的生长发育趋势，及时发现生长轨迹偏离正常水平的情况，明确宝宝生长减缓的原因。</p>
                            <p>除此之外，生长发育曲线也为我们“和自己比”提供了可能。</p>
                            <br>
                            <p>无论宝宝发育得过快、过缓或曲线在正常范围内的骤增、骤减，都应该引起家长的高度关注。</p>
                            <br>
                            <br>
                            <p>因此，无论是想要观察宝宝在短期是否得到了良好的照料和充足的饮食，还是较长的一段时间内评估宝宝的生长发育趋势，曲线都是非常靠谱的工具。</p>
                        </dd>
                        <dt>
                            <i></i>
                        <p>如何测量宝宝的身高体重？</p>
                        </dt>
                        <dd>
                            <p>对自己的宝宝，家长一定是最耐心、最细致的人。说到为宝宝测量身长体重，由于小宝宝的基数小，同时宝宝的情绪、衣着、姿势等任何一点波动都可能影响测量结果的准确性，不管是社区医院还是保健科大夫，测量的一定都没有您自己准确！</p>
                            <br>
                            <p>身长</p>
                            <br>
                            <br>
                            <p>对于宝宝来说，躺着测量的叫身长，站着测量的才叫身高。两岁以内一般都建议给宝宝测量身长，也就是让宝宝平躺着量。其实无论宝宝性别，在两岁以前，他们的身高差异都是非常小的，除非特别矮小或高长，否则不需要特别担心。</p>
                            <br>
                            <p>1 测量方法</p>
                            <p>测量方法</p>
                            <p>对于2岁以内的小宝宝，身长最好是在宝宝睡着的时候测量：让宝宝平躺，双腿捋顺、捋直，双脚并拢，头顶上放一本硬质的书，脚底下放一本硬质的书。平行移动两本书，测量两本书之间的直线距离，就是宝宝的身长。</p>
                            <br>
                            <p>2</p>
                            <p>A.为确保测量结果的准确性，家长需要给宝宝测量三遍，取平均数值。</p>
                            <p>B.宝宝躺的地方要偏硬一些，不能太软。如果在太软的地方测量，宝宝身体会陷下去一些，测量的结果肯定就会偏短。</p>
                            <p>C.今后每次测量，尽量都让宝宝在同一个位置进行。</p>
                            <br>
                            <p>体重</p>
                            <br>
                            <br>
                            <p>体重是反应宝宝营养状况最灵敏的指标。</p>
                            <p>疾病可以在较短时间内使孩子的体重发生变化，尤以婴幼儿最为明显。</p>
                            <br>
                            <p>1</p>
                            <p>测量工具与方法</p>
                            <br>
                            <p>婴儿秤或普通的电子秤均可。</p>
                            <br>
                            <p>给宝宝洗完澡测量体重最佳，用同一个浴巾包着宝宝。</p>
                            <p>如果是用婴儿秤测量的，就减去浴巾的重量。</p>
                            <p>如果是用普通电子秤测量，家长抱着宝宝先称，记下数据后再自己拿着浴巾称，总的重量减去大人和浴巾的重量就是咱们宝宝的体重。</p>
                            <br>
                            <p>2</p>
                            <p>注意事项</p>
                            <p>A.用哪种秤不重要，重要的是每次测量要给宝宝用同一个秤。</p>
                            <br>
                            <p>B.无论什么时候测，尽量在同样的条件下进行。宝宝的体重是用克计算的，要是刚给孩子吃完100毫升奶就测量体重，最起码差了100多克。要是一宿没换尿不湿，最少差了半斤。这对于基数就很小的宝宝来说，是非常大的误差了。所以每次为宝宝测量的时候，要穿衣服就尽量穿同样的衣服，要不穿就都光着PP，要吃奶就都吃完奶测，要换尿不湿就都刚换完尿不湿测。</p>
                            <br>
                            <p>C.每次测量最好都用同一个姿势抱着宝宝，最好也是测量三次，取平均值。</p>
                        </dd>
                        <dt>
                            <i></i>
                        <p>如何分析曲线图？</p>
                        </dt>
                        <dd>
                            <p>1 身高曲线 </p>
                            <p>您可以在这里看到宝宝的身高改变曲线，当宝宝的身高落于有颜色的区域，这代表著符合世界卫生组织(WHO)儿童身高区间，也就是身高落于大部分儿童身高族群之间。</p>
                            <p>2 体重曲线</p>
                            <p>您可以在这里看到宝宝的体重改变曲线，有颜色的区域是世界卫生组织(WHO)所统计全世界儿童的平均体重区间，当宝宝的体重落于其间则表示正常，如果超出这个区域，则表示过胖或过瘦。</p>
                        </dd>
                    </dl>

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
<script>
    $(".newcomers_guide dt").on("click",function () {
        $('.newcomers_guide dd').stop();
        $(this).siblings("dt").removeAttr("id");
        if($(this).attr("id")=="open"){
            $(this).removeAttr("id").siblings("dd").slideUp();
            $(this).children('i').removeClass('active')
            $(this).css('borderBottom','1px solid #E3E3E3')
            $(this).siblings("dd").css('border','none')
        }else{
            $(this).attr("id","open").next().slideDown().siblings("dd").slideUp();
            $('.newcomers_guide dt i').removeClass('active')
            $(this).children('i').addClass('active')
            $('.newcomers_guide dt').css('borderBottom','1px solid #E3E3E3')
            $(this).css('border','none')
            $(this).siblings("dd").css('borderBottom','1px solid #E3E3E3')
        }
    });
</script>
</body>
<!-- InstanceEnd --></html>
