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
    <script src="../scripts/ssutils.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/Swiper/4.0.0/css/swiper.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Swiper/4.0.0/js/swiper.min.js"></script>
    <script type="text/javascript">
        var _next_move_ = 0;
        var waitTime = {    timer: '',  second: 60  };
        var authcode = false;
        var reg_genner = "男";
        $(function(){
            // Login
            $("#login_form").submit(function(e){
                e.preventDefault();
                if(!checkEmailFormat() || !checkPasswordFormat()) {
                    $("#fy-login .error01").show().delay(3000).fadeOut();
                    return true;
                }
                var user_id = $("#login_id").val();
                var user_password = $("#login_pass").val();

                $.ajax({
                    url: "login.php",
                    type: "POST",
                    data: {
                        'p1': user_id,
                        'p2': user_password
                    },
                    dataType: "json",
                    success: function (jsonStr) {
                        if(jsonStr.result=='success') {
                            var message = $.parseJSON(jsonStr.message);
                            showLoginStatus(message.email,message.credit);
                            $.fancybox.close();
                            <?php
                            if(isset($b_post_tv_submit) && $b_post_tv_submit == true) {
                                $b_post_tv_submit = false;
                                echo('postTvSubmit();');
                            }
                            ?>1
                            if(_next_move_ == 100) {
                                onMenuItem3Click();
                            }
                            else if(_next_move_ == 102) {
                                _next_move_ = 0;
                                document.location.href = 'ceanza_menu.php';
                            }
                            else if(_next_move_ == 104) {
                                _next_move_ = 0;
                                document.location.href = 'early_education.php';
                            }
                            else if(_next_move_ == 106) {
                                onMenuItem6Click();
                            }
                            else if(_next_move_ == 107) {
                                _next_move_ = 0;
                               // document.location.href = 'http://x.eqxiu.com/s/PclsbuXT';
                                document.location.href = 'buds_record.php';
                            }
                            else if(_next_move_ == 108) {
                                _next_move_ = 0;
                                document.location.href = 'baby_vaccine.php';
                            }
                            else if(_next_move_ == 109) {
                                _next_move_ = 0;
                                document.location.href = 'person.php';
                            }
                        }
                        else {
                            $("#fy-login .error01").show().delay(3000).fadeOut();
                        }
                    },
                    error: function(xhr, err) {
                        layer.msg('账号或密码不一致，请重新输入');
                    }
                });
                return false;
            });

            $("#mobile_login_form").submit(function(e){
                e.preventDefault();
               // if(!checkEmailFormat() || !checkPasswordFormat()) {
               //     $("#fy-login .error01").show().delay(3000).fadeOut();
               //     return true;
               // }
                var login_mobile = $("#login_mobile").val();
                var login_vcode = $("#login_vcode").val();

                $.ajax({
                    url: "login_phone.php",
                    type: "POST",
                    data: {
                        'p1': login_mobile,
                        'p2': login_vcode
                    },
                    dataType: "json",
                    success: function (jsonStr) {
                        console.log(jsonStr);
                        if(jsonStr.result=='success') {
                            $.fancybox.close();
                            <?php
                            if(isset($b_post_tv_submit) && $b_post_tv_submit == true) {
                                $b_post_tv_submit = false;
                                echo('postTvSubmit();');
                            }
                            ?>
                            if(jsonStr.need_complete == 1){
                                document.location.href = 'package.php';
                            }else{
                                document.location.href = 'index.php';
                            }

                        }
                        else {
                            $("#fy-login .error01").show().delay(3000).fadeOut();
                        }
                    },
                    error: function(xhr, err) {
                        // alert('Ajax request ' + err);
                    }
                });
                return false;
            });

            $(".login_wx").click(function(e) {
                document.location.href = 'login_wx.php';
            });


            // Register
            // $("#register_form").submit(function(e){
            //  e.preventDefault();
            //  if(!checkRegEmailFormat()) {
            //      $("#errorbar_reg_email").text('请输入正确的电子邮件').show().delay(3000).fadeOut();
            //      return true;
            //  }
            //  if (!checkRegPasswordFormat()) {
            //      $("#errorbar_reg_password").text('须6至20位，可含字母、数字、下划线').show().delay(3000).fadeOut();
            //      return true;
            //  }
            //  if (!checkPasswordRepeat()){
            //      return true;
            //  }
            //  // if (!checkRegNameFormat()){
            //  //    return true;
            //  // }
            //  if (!checkRegDateFormat()){
            //      return true;
            //  }
            //  // 参数
            //  var phone = $("#reg_tel").val();
            //  var auth_code = $("#reg_authcode").val();
            //  var user_id = $("#reg_email").val();
            //  var user_password = $("#reg_password").val();
            //  var birthday = $("#reg_date").val();
            //  var city_name = $("#city_name").val();
            //  var sex = 1;
            //  if(reg_genner == "男"){
            //      sex = 0;
            //  }
            //  var nickname = $("#reg_name").val();
            //  checkAuthcodeFormat(phone, auth_code);
            //  if (!authcode){
            //      $("#errorbar_reg_authcode").text('验证码错误').show().delay(3000).fadeOut();
            //      return true;
            //  }


            //  $.ajax({
            //      url: "register.php",
            //      type: "POST",
            //      data: {
            //          'p1': user_id,
            //          'p2': user_password,
            //          'p3': auth_code,
            //          'p4': phone,
            //          'p5':birthday,
            //          'p6':sex,
            //          'p7':nickname,
            //          'p8':city_name,
            //      },
            //      dataType: "json",
            //      success: function (jsonStr) {
            //          //console.log(jsonStr);
            //          if(jsonStr.result=='success') {
            //              var message = $.parseJSON(jsonStr.message);
            //              showLoginStatus(message.email,message.credit);
            //              $.fancybox.close();
            //              <?php
            //              if(isset($b_post_tv_submit) && $b_post_tv_submit == true) {
            //                  $b_post_tv_submit = false;
            //                  echo('postTvSubmit();');
            //              }
            //              else {
            //                  //echo('$("#regdone").fancybox().trigger("click");');
            //                  echo('
            //                  $("#regdone").css("max-width","500px");
            //                  $("#regdone").fancybox({"width":500, "height":500, "autoSize" : false}).trigger("click");
            //              ');
            //              }
            //              ?>
            //          }
            //          else
            //          {
            //              $("#fy-register .error01").text(jsonStr.message).show().delay(3000).fadeOut();
            //          }
            //      },
            //      error: function(xhr, err) {
            //          alert('Ajax request ' + err);
            //      }
            //  });
            //  return false;
            // });
            // modify baby

            // modify member
            $("#modify_member_form").submit(function(){
               // var nickname = $("#fstmb_nickname").val();
                var phone = $("#fstmb_phone").val();
                var password = $("#fstmb_password").val();
                var password2 = $("#fstmb_password2").val();
                var check_ok = true;
               // if(!nickname) {
               //     $("#fstmb_error1").show().delay(2000).fadeOut();
               //     check_ok = false;
               // }

                if(phone && !isTel(phone)) {
                    $("#fstmb_error2").show().delay(2000).fadeOut();
                    check_ok = false;
                }
                if(password) {
                    if(!isPasswd(password)) {
                        $("#fstmb_error3").show().delay(2000).fadeOut();
                        check_ok = false;
                    }
                    else if(password != password2) {
                        $("#fstmb_error4").show().delay(2000).fadeOut();
                        check_ok = false;
                    }
                }
                if(check_ok) {
                    $.ajax({
                        url: "edit_member.php",
                        type: "POST",
                        data: {
                            // 'p1': nickname,
                            'p2': phone,
                            'p3': password
                        },
                        dataType: "json",
                        success: function (jsonStr) {
                            console.log(jsonStr);
                            if(jsonStr.result=='success') {
                                $.fancybox.close();
                                document.location.href= 'report.php?f=1';
                            }
                            else {
                                alert(jsonStr.message);
                                $("#modify_member_form .errorbar1").text(jsonStr.message).show().delay(3000).fadeOut();
                            }
                        },
                        error: function(xhr, err) {
                            // alert('edit member failed: ' + err);
                        }
                    });
                }
                return false;
            });
            // forget password
            $("#forget_pwd_form").submit(function(){
                var auth_code = $("#forget_authcode").val();
                var phone = $("#forget_mobile").val();
                $.ajax({
                    url: "send_forget.php",
                    type: "POST",
                    data: {
                        'p2': auth_code,
                        'p3': phone
                    },
                    dataType: "json",
                    success: function (jsonStr) {
                        console.log(jsonStr);
                        if(jsonStr.result=='success') {
                            $.fancybox.close();
                            $.fancybox({        href: "#fgsend"    }    );
                        }
                        else {
                            $("#fy-forget .error01").text(jsonStr.message).show().delay(3000).fadeOut();
                        }
                    },
                    error: function(xhr, err) {
                       // alert('Ajax request ' + err);
                    }
                });
                return false;
            });

            $("#mobile_bind").submit(function(){
                var auth_code = $("#bind_vcode").val();
                var phone = $("#bind_mobile").val();
                $.ajax({
                    url: "mobile_bind.php",
                    type: "POST",
                    data: {
                        'p2': auth_code,
                        'p3': phone
                    },
                    dataType: "json",
                    success: function (jsonStr) {
                        console.log(jsonStr);
                        if(jsonStr.result=='success') {
                            $.fancybox.close();
                            $.fancybox({        href: "#bmsend"    }    );
                        }
                        else {
                            $("#fy-mobile-bind .error01").text(jsonStr.message).show().delay(3000).fadeOut();
                        }
                    },
                    error: function(xhr, err) {
                       // alert('Ajax request ' + err);
                    }
                });
                return false;
            });

            //关联旧账号
            $("#wx_bind_mobile").submit(function(){
                var auth_code = $("#info_vcode").val();
                var phone = $("#info_mobile").val();
                $.ajax({
                    url: "wx_bind.php",
                    type: "POST",
                    data: {
                        'p2': auth_code,
                        'p3': phone
                    },
                    dataType: "json",
                    success: function (jsonStr) {
                        console.log(jsonStr);
                        if(jsonStr.result=='success') {
                            $.fancybox.close();
                            alert('关联成功');
                            document.location.href= 'index.php';
                        }
                        else {
                            layer.msg(jsonStr.message);
                        }
                    },
                    error: function(xhr, err) {
                        // alert('Ajax request ' + err);
                    }
                });
                return false;
            });


            $("#mobile_register_form").submit(function(){
                var auth_code = $("#register_vcode").val();
                var phone = $("#register_mobile").val();
                if(auth_code && phone){
                    $.ajax({
                        url: "register_phone.php",
                        type: "POST",
                        data: {
                            'p2': auth_code,
                            'p1': phone
                        },
                        dataType: "json",
                        success: function (jsonStr) {
                            if(jsonStr.result=='success') {
                                $.fancybox.close();
                                document.location.href = 'package.php';
                            }
                            else {
                                $("#fy-mobile-bind .error01").text(jsonStr.message).show().delay(3000).fadeOut();
                            }
                        },
                        error: function(xhr, err) {
                            // alert('Ajax request ' + err);
                        }
                    });
                    var arr = location.href.split('#');
                    fancyboxName = arr[arr.length-1];
                    if(fancyboxName == 'fy-mobile-register'){
                        $('.isbind_mobile').show()
                    }
                    $.fancybox({
                        href: "#fy-complete-info"
                    });
                    return false;
                }else if(!phone){
                    $('#div_err_mobile_reg').show()
                    return false;
                }else if(!auth_code){
                    layer.msg('验证码错误，请重新输入。')
                    return false;
                }
            });

            // trial
            $("#exp_form").submit(function(e) {
                e.preventDefault();
                var year = $("#exbox01 input[name='radio01']:checked").val();
                var month = $("#exbox01 input[name='radio02']:checked").val();
                if(year!=undefined && month!=undefined) {
                    loadTrialQA(year,month);
                }
                else {
                    $("#exbox01 .error01").show().delay(3000).fadeOut();
                }
                return true;
            });
            $("#exp_form_submit").click(function(e) {
                e.preventDefault();
                $("#exp_form").submit();
            });
            // initialize forms
            $("form").attr("method","post");
            $(".errorbar").hide();
            $("#login_id").blur(checkEmailFormat);
            $("#login_pass").blur(checkPasswordFormat);
        });

        function checkEmailFormat() {
            if(!isEmail($("#login_id").val()) && !isTel($("#login_id").val())) {
                $("#div_err_email").show();
                return false;
            }
            else {
                $("#div_err_email").hide();
                return true;
            }
        }

        function checkRegTelFormat(){
            if(!isTel($("#reg_tel").val())){
                $("#errorbar_reg_tel").show();
                return false;
            }
            else{
                $("#errorbar_reg_tel").hide();
                return true;
            }
        }

        function checkPasswordFormat() {
            if(!isPasswd($("#login_pass").val())) {
                $("#div_err_password").show();
                return false;
            }
            else {
                $("#div_err_password").hide();
                return true;
            }
        }

        function checkRegEmailFormat() {
            if(!isEmail($("#reg_email").val())) {
                $("#errorbar_reg_email").show();
                return false;
            }
            else {
                $("#errorbar_reg_email").hide();
                return true;
            }
        }

        function checkRegPasswordFormat() {
            if(!isPasswd($("#reg_password").val())) {
                $("#errorbar_reg_password").show();
                return false;
            }
            else {
                $("#errorbar_reg_password").hide();
                return true;
            }
        }

        function checkPasswordRepeat() {
            var a = $("#reg_password").val();
            var b = $("#confirm_password").val();
            if( a !== b) {
                $("#errorbar_confirm_password").show();
                return false;
            }
            else {
                $("#errorbar_confirm_password").hide();
                return true;
            }
        }

        function checkRegDateFormat(){
            if(!isdate($("#reg_date").val())) {
                $("#errorbar_reg_date").show();
                return false;
            }
            else {
                $("#errorbar_reg_date").hide();
                return true;
            }
        }

        function showLoginStatus(nickname,points) {
            $("#login_status").html('<li class="m_name-point fst"><b>'+nickname+'</b></li><li><a href="javascript:doLogout();">登出</a></li>');
            $("#login_status_m").html('<b>'+nickname+'</b><a href="javascript:doLogout();">登出</a>');
            $("#ex_target_text").text("立即使用");
        }

        function doLogout() {
            $.ajax({
                url: "logout.php",
                success: function () {
                    location.href = "index.php";
                }
            });
        }

        function postTvSubmit() {
            var form = document.createElement("form");
            form.setAttribute("method", "post");
            form.setAttribute("action", "tv_submit.php");
            document.body.appendChild(form);
            form.submit();
        }
        
        function loadTrialQA(year,month) {
            $.ajax({
                url: "gi_load_trial.ajax.php",
                type: "POST",
                data: {
                    'p1': year,
                    'p2': month
                },
                dataType: "json",
                success: function (jsonStr) {
                    $("#ex_title").text(jsonStr.title);
                    $("#ex_question").text(jsonStr.detail);
                    $("#ex_advice").text(jsonStr.advice);
                    $.fancybox({    href: "#exbox02"    });
                },
                error: function(xhr, err) {
                    // alert('Woops! Something was wrong!');
                }
            });
        }
    </script>
    <style>
        body{background:#FFFFFF;}
    </style>
</head>

<body>
<?php
include("inc_fancyboxes.php");
?>
<!-- InstanceBeginEditable name="wrap" -->
<section id="wrap">
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
        upload_img_html+= `<li>
                    <b onClick="delDiaryUploadImgs(${i})"></b>
                    <p><img onClick="previewUploadImgs(${i})" src="${diaryUploadImgs[i].url}" alt=""></p>
                </li>`
    }
    $('.upload_imgs').html(upload_img_html)
    for(var i = 0; i < newDiaryUploadImgs.length; i++){
        slide_img_html+= `<div class="swiper-slide"><img src="${newDiaryUploadImgs[i].url}" alt=""></div>`
    }
    $('#banner .swiper-wrapper').html(slide_img_html)

    function delDiaryUploadImgs(index){
        newDiaryUploadImgs.splice(index,1)
        upload_img_html = '',slide_img_html = '';
        for(var i = 0; i < newDiaryUploadImgs.length; i++){
            upload_img_html+= `<li>
                        <b onClick="delDiaryUploadImgs(${i})"></b>
                        <p><img onClick="previewUploadImgs(${i})" src="${newDiaryUploadImgs[i].url}" alt=""></p>
                    </li>`
        }
        $('.upload_imgs').html(upload_img_html)
        for(var i = 0; i < newDiaryUploadImgs.length; i++){
            slide_img_html+= `<div class="swiper-slide"><img src="${newDiaryUploadImgs[i].url}" alt=""></div>`
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
<!-- InstanceEnd --></html>
