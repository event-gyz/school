<script src="../scripts/jquery.masonry.min.js"></script>
<link rel="stylesheet" href="../scripts/fancybox/jquery.fancybox.css">
<script src="../scripts/fancybox/jquery.fancybox.pack.js"></script>
<link rel="stylesheet" type="text/css" href="../scripts/scrollbar/jquery.mCustomScrollbar.css">
<script src="../scripts/scrollbar/jquery.mCustomScrollbar.concat.min.js"></script>
<script src="../scripts/scroll_loading/jquery.infinitescroll.min.js"></script>
<script src="../scripts/ios_slider/jquery.iosslider.min.js"></script>
<script src="../scripts/other.js"></script>
<script src="../scripts/ssutils.js"></script>
<script type="text/javascript">
    var _next_move_ = 0;
    var waitTime = {    timer: '',  second: 60  };
    var authcode = false;
    var reg_genner = "男";
    $(function(){

        $("#share_register_form").submit(function(){
            var auth_code = $("#share_vcode").val();
            var phone = $("#share_mobile").val();
            $.ajax({
                url: "register_phone_share.php",
                type: "POST",
                data: {
                    'p2': auth_code,
                    'p1': phone
                },
                dataType: "json",
                success: function (jsonStr) {
                    console.log(jsonStr);
                    if(jsonStr.result=='success') {
                        $.fancybox.close();
                        document.location.href = 'share_succ.php?phone='+phone;
                    }
                    else {
                        layer.msg(jsonStr.message);
                    }
                },
                error: function(xhr, err) {
//					alert('Ajax request ' + err);
                }
            });
            return false;
        });

        // modify baby
        $("#modify_baby_form").submit(function(){
            var nickname = $("#fst_nickname").val();
            var sex = $('input[name=fst_sex]:checked').val()
            var birthdate = $('#fst_birthdate').val();
            if(nickname && birthdate) {
                $.ajax({
                    url: "addUser.php",
                    type: "POST",
                    data: {
                        'p1': nickname,
                        'p2': sex,
                        'p3': birthdate
                    },
                    dataType: "json",
                    success: function (jsonStr) {
                        if(jsonStr.result=='success') {
                            var message = $.parseJSON(jsonStr.message);
                            $.fancybox.close();
                            if(_next_move_==100) {
                                _next_move_ = 0;
                                document.location.href = 'itemlist.php';
                            }
                            else if(_next_move_==106) {
                                _next_move_ = 0;
                                document.location.href = 'report.php';
                            }
                            else
                                document.location.href= 'report.php?f=1';
                        }
                        else {
                            layer.msg(jsonStr.message);
                            $("#modify_baby_form .errorbar").text(jsonStr.message).show().delay(3000).fadeOut();
                        }
                    },
                    error: function(xhr, err) {
//                        alert('addUser failed: ' + err);
                    }
                });
            }else if(!nickname){
                $(".fst_nickname_err").show().delay(3000).fadeOut();
            }else if(!birthdate){
                $(".fst_birthdate_err").show().delay(3000).fadeOut();
            }
            return false;
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

        $('.fbar .genner').click(function() {
            if (!$(this).hasClass('selected')) {
                reg_genner = $(this).text()
                $(this).addClass('selected').siblings('.selected').removeClass('selected');
            }
        });
        $("#reg_tel").blur(checkRegTelFormat);
        $("#reg_email").blur(checkRegEmailFormat);
        $("#reg_password").blur(checkRegPasswordFormat);
        $("#confirm_password").blur(checkPasswordRepeat);
//        $("#reg_name").blur(checkRegNameFormat);
        $("#reg_date").blur(checkRegDateFormat);

//    $("#forget_ref_code").click(function() {
//        var params = {
//          Mobile: $('#forget_mobile').val(),
//          validEl: $('#forget_ref_code'),
//          errEl: $('#errorbar_reg_mobile'),
//            type: "forget",
//        };
//        getCode(waitTime, params,$('#forget_mobile').val(),"forget");
//    });

        $('.fancybox').click(function() {
            clearTimer(waitTime);
            $('#ref_code').html('获取验证码');
            $('#forget_ref_code').html('获取验证码');
        });

        $('.add_ceanza').click(function(){
            document.location.href = 'ceanza_add.php';
        });
        // menu item click
        $("#menuitem_2").click(onMenuItem2Click);
        $("#menuitem_2_m").click(onMenuItem2Click);
        $("#menuitem_3").click(onMenuItem3Click);
        $("#menuitem_3_m").click(onMenuItem3Click);
        $("#menuitem_4").click(onMenuItem4Click);
        $("#menuitem_4_m").click(onMenuItem4Click);
        $("#menuitem_6").click(onMenuItem6Click);
        $("#menuitem_6_m").click(onMenuItem6Click);
    });

    // 发送验证码
    function send_message(phone,type,time,params){
        $.post("reg_message.php",{'phone': phone,'type':  type},function(result){
            result = jQuery.parseJSON(result)
            if(result.result!='success') {
                clearTimer(time)
                layer.msg(result.message);
                return false;
            }else{
                layer.msg('发送成功');
            }
        });
        return false;
    }

    function getCode (time, params) { // params: 参数对象
        if (time.timer) return false
        var mobileReg = /^[1][34578](\d){9}$/,html = ''
        if (params.Mobile && mobileReg.test(params.Mobile)) {
            //发送验证码
            send_message(params.Mobile,params.type,time,params);
            params.errEl.hide()
            time.timer = setInterval(function(){
                time.second -= 1
                if (time.second < 0) {
                    clearTimer(time)
                }
                html = time.timer === '' ? '获取验证码' : time.timer !== null ? waitTime.second + 's' : '重新获取';
                params.validEl.html(html)
            }, 1000);
        } else {
            params.errEl.show()
            return false
        }
    }

    function checkRegNameFormat(){
        if(!isName($("#reg_name").val())) {
            $("#errorbar_reg_name").show();
            return false;
        }
        else {
            $("#errorbar_reg_name").hide();
            return true;
        }
    }
    // 清除定时器
    function clearTimer (time) {
        clearInterval(time.timer)
        time.timer = null
        time.second = 60
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

    function onMenuItem2Click() {
        $.ajax({url: "check_login_status.ajax.php",
            type: "POST",
            dataType: "json",
            success: function (jsonStr) {
                if(jsonStr.islogin==true) {
                    if(jsonStr.haskid==true) {
                        _next_move_ = 0;
                        document.location.href = 'ceanza_menu.php';
                    }
                    else {
                        _next_move_ = 102;
                        showEditBabyBox();
                    }
                }
                else {
                    _next_move_ = 102;
                    $.fancybox({
                        href: "#fy-login"
                    });
                }
            },
            error: function(xhr, err) {
//	            alert('Ajax request ' + err);
            }
        });
    }


    function onMenuItem3Click() {
        $.ajax({url: "check_login_status.ajax.php",
            type: "POST",
            dataType: "json",
            success: function (jsonStr) {
//            console.log(jsonStr);
//            console.log(jsonStr.haskid);
                if(jsonStr.islogin==true) {
                    if(jsonStr.haskid==true) {
                        _next_move_ = 0;
                        document.location.href = 'itemlist.php';
                    }
                    else {
                        _next_move_ = 100;
                        showEditBabyBox();
                    }
                }
                else {
                    _next_move_ = 100;
                    $.fancybox({
                        href: "#fy-login"
                    });
                }
            },
            error: function(xhr, err) {
//                alert('Ajax request ' + err);
            }
        });
    }

    function onMenuItem4Click() {
        $.ajax({url: "check_login_status.ajax.php",
            type: "POST",
            dataType: "json",
            success: function (jsonStr) {
                if(jsonStr.islogin==true) {
                    _next_move_ = 0;
//                    document.location.href = 'http://x.eqxiu.com/s/PclsbuXT';
                    document.location.href = 'early_education.php';
                }
                else {
                    _next_move_ = 104;
                    $.fancybox({
                        href: "#fy-login"
                    });
                }
            },
            error: function(xhr, err) {
            }
        });
    }

    function onMenuItem6Click() {
        $.ajax({url: "check_login_status.ajax.php",
            type: "POST",
            dataType: "json",
            success: function (jsonStr) {
                if(jsonStr.islogin==true) {
                    if(jsonStr.haskid==true) {
                        _next_move_ = 0;
                        document.location.href = 'report.php';
                    }
                    else {
                        _next_move_ = 106;
                        showEditBabyBox();
                    }
                }
                else {
                    _next_move_ = 106;
                    $.fancybox({
                        href: "#fy-login"
                    });
                }
            },
            error: function(xhr, err) {
//                console.log('Ajax request ' + err);
            }
        });
    }

    // function updateNumberOfDays(){
    //     $('#birth_box_days').html('');
    //     month=$('#birth_box_months').val();
    //     year=$('#birth_box_years').val();
    //     days=daysInMonth(month, year);

    //     for(i=1; i < days+1 ; i++){
    //         $('#birth_box_days').append($('<option />').val(i).html(i));
    //     }
    // }

    // function daysInMonth(month, year) {
    //     return new Date(year, month, 0).getDate();
    // }

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

    function checkAuthcodeFormat(phone,code ) {
        $.ajax({
            url: "reg_message.php",
            type: "POST",
            async: false,
            data: {
                'phone': phone,
                'type':  "vali",
                'code':code
            },
            dataType: "json",
            success: function (jsonStr) {
                console.log(jsonStr);
                if(jsonStr.result == 'success') {
                    authcode = true;
                }
                else {
                    layer.msg(jsonStr.message);
                    authcode = false;
                }
            },
            error: function(xhr, err) {
//                alert('Ajax request ' + err);
            }
        });
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

    function loadArticle(v_id) {
        $("#articlebox").attr('class', 'articlebox');
        $("#articlebox").load("get_article.php",{uid:v_id},function() {
            $.fancybox({        href: "#articlebox"    }	);
        });
        /*

         $.ajax({
         url: "get_article.php",
         type: "POST",
         data: {'uid': v_id},
         dataType: "html",
         success: function (data) {
         $("#articlebox").attr('class', 'articlebox');
         $("#articlebox").html(data);
         $("#articlebox").fancybox().trigger('click');
         },
         error: function(xhr, err) {
         //	            alert('Ajax request ' + err);
         }
         });
         */
    }

    function loadGIDetail(index_id,a_type) {
        $("#articlebox").attr('class', 'articlebox abox');
        $("#articlebox").load("gi_load_more.ajax.php",{p1:index_id,p2:a_type},function() {
            $.fancybox({
                href: "#articlebox"
            });
        });
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
                $.fancybox({   	href: "#exbox02"    });
            },
            error: function(xhr, err) {
                alert('Woops! Something was wrong!');
            }
        });
    }

    function goUrlClick(url) {
        $.ajax({url: "check_login_status.ajax.php",
            type: "POST",
            dataType: "json",
            success: function (jsonStr) {
                if(jsonStr.islogin==true) {
                    console.log(11)
                    if(jsonStr.haskid==true) {
                        _next_move_ = 0;
                        document.location.href = url;
                    }else {
                        _next_move_ = 100;
                        showEditBabyBox();
                    }
                }
                else {
                    if(url == 'baby_vaccine.php') {
                        _next_move_ = 108;
                    }else if(url == 'person.php') {
                        _next_move_ = 109;
                    }else{
                        _next_move_ = 100;
                    }
                    $.fancybox({
                        href: "#fy-login"
                    });
                }
            },
            error: function(xhr, err) {
//              alert('Ajax request ' + err);
            }
        });
    }
</script>
