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
if(!empty($_SESSION)){
    //如果存在session，通过uid = $_SESSION['CURRENT_KID_UID']获取当前登录用户的生日
    $birth = "select birth_day from `user` where uid = '".$_SESSION['CURRENT_KID_UID']."'";
    //$birth = "select birth_day from `user` where uid = 1";
    //执行sql语句，获取到二维数组
    $birth_res = M()->query($birth);
    //取出该数组当中的日期，转换为时间戳
    $birth_time = strtotime($birth_res[0]['birth_day']);
    $time_diff = time() - $birth_time;
    $day_diff =floor($time_diff/(60*60*24));
    $year_diff = floor($day_diff/365);
    $month_diff = floor($day_diff%365/30);
    $date_diff = floor($day_diff%365%30);

////查询该用户最后一次体检身高的日期
//$wap_height = "SELECT date FROM `wap_height` where uid = ".$_SESSION['CURRENT_KID_UID']." order by `date` desc";
////$res = query($wap_height);
////$resu = mysqli_fetch_array($res,MYSQLI_ASSOC);
//$wap_height_hei = M()->find($wap_height);
////计算最后一次记录身高的时间距离现在的天数
//$wap_height_hei_day = floor((time() - strtotime($wap_height_hei['date']))/(60*60*24));


    //计算最近一次身高体重测量时间
    function wap_height_weight($table){
        $sql = "select date from `".$table."` where uid = ".$_SESSION['CURRENT_KID_UID']." order by `date` desc";
        $result = M()->find($sql);
        $time = time() - strtotime($result['date']);
        $time_day = floor($time/(60*60*24));
        return $time_day;
    }
    //身高
    $wap_height_day = wap_height_weight('wap_height');
    //体重
    $wap_weight_day = wap_height_weight('wap_weight');
}else{
    $year_diff = 0;
    $month_diff = 0;
    $date_diff = 0;
    $wap_height_day = 0;
    $wap_weight_day = 0;
}


//现在的时间中的小时
$now_time_hours = date('H',time());
//判断目前的时所处的时间段
if($now_time_hours>=00 && $now_time_hours<06){
    $time_message = '凌晨好~';
}elseif($now_time_hours>=06 && $now_time_hours<10){
    $time_message = '早上好~';
}elseif($now_time_hours>=10 && $now_time_hours<15){
    $time_message = '中午好~';
}elseif($now_time_hours>=15 && $now_time_hours<19){
    $time_message = '下午好~';
}else{
    $time_message = '晚上好~';
}
//获取目前的日期
$now_time_month = date('m',time());
$now_time_day = date('d',time());
$now_time_month_day = $now_time_month.'月'.$now_time_day.'日';

//随机抽取一条成长指标内容
$grow_index = "select text from `grow_index` order by rand() limit 1";
$grow_index_text = M()->find($grow_index);

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
    <div class="person_index">
        <div class="top_banner">
            <div class="message">
                <b></b>
            </div>
            <div class="sign_in"></div>
            <?php
            if(isset($_SESSION['user_token'])){
                echo('<div class="login_name">'.$nick_name.'</div>');
            }else {
                ?>
                <div class="login_name">admin</div>
                <?php
            }
            ?>
            <div class="login_age">
                <?php
                echo('<p>'.$time_message.'</p>');
                ?>
                <?php
                echo('<span>今天你'.$year_diff.'岁'.$month_diff.'个月'.$date_diff.'天啦</span>');
                ?>
            </div>
        </div>
        <div class="index_info">
            <ul class="month">
                <li>
                    <?php
                    if($date_diff<10 && $date_diff>0){
                        $date_diff0 = '零'.$date_diff-1;
                        $month_diff0 = $month_diff;
                    }elseif ($date_diff == 0){
                        if($month_diff == 0){
                            $month_diff0 = 0;
                            $date_diff0 = 0;
                        }else{
                            $month_diff0 = $month_diff-1;
                            $date_diff0 = 30;
                        }
                    }else{
                        $date_diff0 = $date_diff-1;
                        $month_diff0 = $month_diff;
                    }
                    echo('<p>'.$month_diff0.'个月'.$date_diff0.'天</p>')
                    ?>
                </li>
                <li class="current">
                    <?php
                    echo('<p>'.$month_diff.'个月'.$date_diff.'天</p>')
                    ?>
                    <?php
                    echo('<span>'.$now_time_month_day.'</span>');
                    ?>
                </li>
                <li>
                    <?php
                    if($date_diff == 30){
                        $month_diff1 = $month_diff+1;
                        $date_diff1 = '零1天';
                    }else{
                        $month_diff1 = $month_diff;
                        $date_diff1 = $date_diff+1;
                    }
                    echo('<p>'.$month_diff.'个月'.$date_diff1.'天</p>');
                    ?>
                </li>
            </ul>
            <?php
            echo('<p>'.$grow_index_text['text'].'</p>');
            ?>
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
                    <?php
                    if(isset($_SESSION['user_token'])){
                        echo('<p>您已经有'.$wap_height_day.'天没有给'.$nick_name.'测量身高,
                                    '.$wap_weight_day.'天没测量体重啦
                                </p>');
                    }else {
                        ?>
                        <p>您已经有85天没有给admin测量身高体重了</p>
                        <?php
                    }
                    ?>

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
            <div class="date_sel">
                <b></b>
                <p>按日期查看</p>
                <input class="datepicker" type="text" readonly>
            </div>
            <div class="small_title">
                <a href="diary_add.php">
                    <i></i>
                    <b></b>
                    <p>写日记</p>
                </a>
            </div>
            <div class="diary_info">
                <i class="edit_diary_info"></i>
                <s class="open_diary_info"></s>
                <b class="page_size">共<span>5</span>页</b>
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
            <div class="diary_txt">
                <p>ZICO十分顽皮，有时明明知道是错的事，我不让他做的事，他就像是逗你玩似的，要去做，做的时候还用眼睛瞄着你，趁你不注意就做了，做成功了还在那呵呵乐，实在让人好气又好笑。</p>
                <p>现在每当我下班回家后，总是能看到ZICO在伏案画画，我想，不管他画的好与否，但至少能让他有一个认真的态度。</p>
            </div>
            <div class="diary_operation">
                <ul>
                    <!-- <li class="likes">
                        <b></b>
                        <span>33</span>
                    </li>
                    <li class="edit">
                        <b></b>
                        <span>50</span>
                    </li> -->
                    <li class="share">
                        <b></b>
                        <span>19</span>
                    </li>
                    <li class="delete">
                        <b></b>
                    </li>
                </ul>
                <!-- <p>全文</p> -->
            </div>
            <!-- <div class="comment">
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
            </div> -->
            <div class="diary_open_edit">
                <textarea name="" id="">ZICO十分顽皮，有时明明知道是错的事，我不让他做的事，他就像是逗你玩似的，要去做，做的时候还用眼睛瞄着你，趁你不注意就做了，做成功了还在那呵呵乐，实在让人好气又好笑。                   现在每当我下班回家后，总是能看到ZICO在伏案画画，我想，不管他画的好与否，但至少能让他有一个认真的态度。</textarea>
                <ul class="upload_imgs">
                    <!-- <li>
                        <b><span>×</span></b>
                        <p><img src="../content/epaper/images/upload_img01.jpg" alt=""></p>
                    </li>
                    <li>
                        <b><span>×</span></b>
                        <p><img src="../content/epaper/images/upload_img02.jpg" alt=""></p>
                    </li> -->
                </ul>
                <div class="add_upload_img">
                    <input type="file">
                </div>
                <div class="operation_btn">
                    <button class="cancel">取消</button>
                    <button class="upload">发布</button>
                </div>
            </div>
        </div>
        <div id="banner">
            <p class="close_banner"></p>
            <div class="swiper-container">
                <div class="swiper-wrapper">
                    <div class="swiper-slide"><img src="" alt=""></div>
                </div>
                <div class="swiper-button-prev"></div><!--左箭头-->
                <div class="swiper-button-next"></div><!--右箭头-->
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
<script>
    var upload_img_html = '',slide_img_html = '',mySwiper;
    newDiaryUploadImgs = [].concat(diaryUploadImgs)
    for(var i = 0; i < diaryUploadImgs.length; i++){
        upload_img_html += `<li>
                    <b onClick="delDiaryUploadImgs(${i})"></b>
                    <p><img onClick="previewUploadImgs(${i})" src="${diaryUploadImgs[i].url}" alt=""></p>
                </li>`
    }
    $('.upload_imgs').html(upload_img_html)
    for(var i = 0; i < newDiaryUploadImgs.length; i++){
        slide_img_html += `<div class="swiper-slide"><img src="${newDiaryUploadImgs[i].url}" alt=""></div>`
    }
    $('#banner .swiper-wrapper').html(slide_img_html)

    function delDiaryUploadImgs(index){
        newDiaryUploadImgs.splice(index,1)
        upload_img_html = '',slide_img_html = '';
        for(var i = 0; i < newDiaryUploadImgs.length; i++){
            upload_img_html += `<li>
                        <b onClick="delDiaryUploadImgs(${i})"></b>
                        <p><img onClick="previewUploadImgs(${i})" src="${newDiaryUploadImgs[i].url}" alt=""></p>
                    </li>`
        }
        $('.upload_imgs').html(upload_img_html)
        for(var i = 0; i < newDiaryUploadImgs.length; i++){
            slide_img_html += `<div class="swiper-slide"><img src="${newDiaryUploadImgs[i].url}" alt=""></div>`
        }
        $('#banner .swiper-wrapper').html(slide_img_html)
    }

    function previewUploadImgs(key){
        new Swiper('.swiper-container', {
            navigation: {
                nextEl: '.swiper-button-next',
                prevEl: '.swiper-button-prev'
            },
            initialSlide :key,
            observer:true,
            observeParents:true
        })
        $('#banner').fadeIn()
    }

    $('.close_banner').click(function(){
        // console.log(mySwiper.realIndex)
        $('#banner').fadeOut()
    })

    $('.edit_diary_info').click(function(){
        $('.diary_txt').slideUp()
        $('.open_diary_info').removeClass('open')
        $('.diary_operation').hide()
        $('.diary_open_edit').slideDown()
    })

    $('.open_diary_info').click(function(){
        $('.diary_open_edit').slideUp();
        $('.diary_txt').slideToggle()
        $(this).toggleClass('open')
        $('.diary_operation').show()
    })

    $('.diary_open_edit .cancel').click(function(){
        $('.diary_open_edit').slideUp();
        // $('.diary_txt').slideUp()
        $('.diary_operation').show()
    })

</script>
</body>
