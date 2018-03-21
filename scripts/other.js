// JavaScript Document

/*===========================【判斷寬度】 ===========================*/
var pcUIMin = 960;
var iPadUIMin = 768;
var iPhoneUIMax = 480;
var iPhoneUIMin = 320;
var waitTime = {
            timer: '',
            second: 60
        }

// 单位换算
;(function (doc, win) {
    var docEl = doc.documentElement,
    resizeEvt = 'orientationchange' in window ? 'orientationchange' : 'resize',
    recalc    = function () {
        var clientWidth = docEl.clientWidth;
        if (clientWidth>=1025) {
            clientWidth = 1025;
        };
        if (!clientWidth) return;
        docEl.style.fontSize = 102.5 * (clientWidth / 1025) + 'px';
    };
    if (!doc.addEventListener) return;
    win.addEventListener(resizeEvt, recalc, false);
    doc.addEventListener('DOMContentLoaded', recalc, false);
})(document, window);


function w(){
    var windowWidth = $(window).width();
    if(windowWidth >= pcUIMin){
        $('body').attr('class','pcUIMin');
    } else if(windowWidth <= pcUIMin && windowWidth >= iPadUIMin){
        $('body').attr('class','ipadUI');
        $('#header .s-mnav').hide();
        $('.bg-o').fadeOut();
        $('.masonry').masonry({
            columnWidth: function( containerWidth ) {
                return containerWidth / 3;
            }
        });
    } else if(windowWidth <= iPadUIMin && windowWidth >= iPhoneUIMax){
        $('body').attr('class','iphoneUIMax');
        $('.masonry').masonry({
            columnWidth: function( containerWidth ) {
                return containerWidth / 2;
            }
        });
    } else if(windowWidth <= iPhoneUIMax){
        $('body').attr('class','iphoneUI');
    } else{
        $('body').attr('class','');
    }
}

function getCode (time, params) { // params: 参数对象
  if (time.timer) return false
  var mobileReg = /^[1][34578](\d){9}$/,html = ''
  if (params.Mobile && mobileReg.test(params.Mobile)) {
    params.errEl.hide()
    time.timer = setInterval(function(){
      time.second -= 1
      if (time.second < 0) {
        clearTimer(time)
      }
      html = time.timer === '' ? '获取验证码' : time.timer !== null ? waitTime.second + 's' : '重新获取'
      params.validEl.html(html)
    }, 1000)
  } else {
    params.errEl.show()
    return false
  }
}
// 清除定时器
function clearTimer (time) {
  clearInterval(time.timer)
  time.timer = null
  time.second = 60
}
//删除左右两端的空格
function trim(str){
    alert(str)
    return str.replace(/(^\s*)|(\s*$)/g, "");
}

$(window).resize(function(e){
    w();
});

$(function(){
    
    w();
    
    /*===========================【首頁主選單】 ===========================*/  
    $('#header nav li').hover(function(){
        $(this).addClass('hv');
    } , function(){
        $(this).removeClass('hv');
    });
    $('.i-menu').click(function(){
        $(this).toggleClass('on');
        $('#header .s-mnav').stop(false, true).slideToggle();
        $('.bg-o').stop(false, true).fadeToggle();
    });
    
    /*===========================【首頁slider】 ===========================*/
    $('.slider').iosSlider({
        snapToChildren: true,
        desktopClickDrag: true,
        keyboardControls: true,
        autoSlide: true,
        autoSlideTimer: 5000,
        navSlideSelector: $('.pgs .item'),
        onSlideChange: slideChange
    });
    function slideChange(args) {
//      console.log(args);
        $('.pgs .item').removeClass('on');
        $('.pgs .item:eq(' + (args.currentSlideNumber - 1) + ')').addClass('on');
    }
    
    // code for fade in element by element
    $.fn.fadeInWithDelay = function(){
        var delay = 0;
        return this.each(function(){
            $(this).delay(delay).animate({opacity:1}, 200);
            delay += 100;
        });
    };
    
    /*===========================【Fancybox】 ===========================*/   
    $('.fancybox').fancybox({
        'maxWidth':850
    });
    
    /*===========================【首頁主選單】 ===========================*/  
    $('.btn01,.btn_submit01,.btn_submit03,.btn_submit04,.btn_submit05').hover(function(){
        $(this).addClass('hv');
    } , function(){
        $(this).removeClass('hv');
    });
    
    /*=========================== 【頁籤表單】 ===========================*/
    $(".tabcont").hide();
    $('.tab-hd li').click(function(){
        var $this = $(this),
            _clickTab = $this.find('a').attr('href');
        $this.addClass('on').siblings('.on').removeClass('on');
        $(_clickTab).addClass('on').siblings('.on').removeClass('on');
        $(_clickTab).stop(false, true).fadeIn().siblings().hide();
        w();
        return false;
    }).find('a').focus(function(){
        this.blur();
    });
    
    /*=========================== 【表格】 ===========================*/
    $(".tb-rep tr:odd").addClass("even"); 
    
    /*=========================== 【Masonry】 ===========================*/
    $('.masonry').imagesLoaded(function(){
        $('.masonry').masonry({
            itemSelector: '.masli',
            isAnimated: true,
            columnWidth: function( containerWidth ) {
                return containerWidth / 3;
            }
        });
    });
    
    /*=========================== 【Radio】 ===========================*/
    $('.ralist01 li').click(function() {
        $('.ralist01 li').removeClass("selected");
        $(this).addClass("selected");
    });
    $('.ralist02 li').click(function() {
        $('.ralist02 li').removeClass("selected");
        $(this).addClass("selected");
    });
    
    /*=========================== 【回頂端】 ===========================*/
    $('.bodytop').click(function() {
        $('body,html').animate({scrollTop:0},800);
    });
    $('.divtop').click(function() {
        if (navigator.userAgent.match(/(iPod|iPhone|iPad)/)) {
            $('body,html').animate({scrollTop:$('.fy-bd').offset().top-50},800);    
        } else {
            $('.fancybox-overlay').animate({scrollTop:0},800);
        }
    });

    $('.fbar .genner').click(function() {
        if (!$(this).hasClass('selected')) {
            $(this).addClass('selected').siblings('.selected').removeClass('selected')
        }
    })

    $("#ref_code").click(function() {
        var params = {
          Mobile: $('#reg_tel').val(),
          validEl: $('#ref_code'),
          errEl: $('#errorbar_reg_tel'),
            type: 'send',
        }
        getCode(waitTime, params)
    })
    
    $("#forget_ref_code").click(function() {
        var params = {
          Mobile: $('#forget_mobile').val(),
          validEl: $('#forget_ref_code'),
          errEl: $('#errorbar_reg_mobile'),
            type: 'forget',
        }
        getCode(waitTime, params)
    })

    $("#register").click(function(e) {
//        e.preventDefault();
        if(!checkRegEmailFormat()) {
            $("#errorbar_reg_email").text('请输入正确的电子邮件').show().delay(3000).fadeOut();
            return true;
        }
        if (!checkRegPasswordFormat()) {
            $("#errorbar_reg_password").text('须6至20位，可含字母、数字、下划线').show().delay(3000).fadeOut();
            return true;
        }
        if (!checkPasswordRepeat()){
            return true;
        }
        if (!checkRegNameFormat()){
            return true;
        }
        if (!checkRegDateFormat()){
            return true;
        }
        // 参数
        var phone = $("#reg_tel").val();
        var auth_code = $("#reg_authcode").val();
        var user_id = $("#reg_email").val();
        var user_password = $("#reg_password").val();
        var birthday = $("#reg_date").val();
        var sex = 1;
        if(reg_genner == "男"){
            sex = 0;
        }
        var nickname = $("#reg_name").val();
        checkAuthcodeFormat(phone, auth_code);
        if (!authcode){
            $("#errorbar_reg_authcode").text('验证码错误').show().delay(3000).fadeOut();
            return true;
        }
        $.ajax({
            url: "register.php",
            type: "POST",
            data: {
                'p1': user_id,
                'p2': user_password,
                'p3': auth_code,
                'p4': phone,
                'p5':birthday,
                'p6':sex,
                'p7':nickname
            },
            dataType: "json",
            success: function (jsonStr) {
                //console.log(jsonStr);
                if(jsonStr.result=='success') {
                    var message = $.parseJSON(jsonStr.message);
                    showLoginStatus(message.email,message.credit);
                    $.fancybox.close();
                }
                else
                {
                    $("#fy-register .error01").text(jsonStr.message).show().delay(3000).fadeOut();
                }
            },
            error: function(xhr, err) {
                alert('Ajax request ' + err);
            }
        });
        return false;
    });

    $('.fancybox').click(function() {
        clearTimer(waitTime)
        $('#ref_code').html('获取验证码')
        $('#forget_ref_code').html('获取验证码')
    })

    $(window).load(function(){
        $(".tab-bd .scrolltype").mCustomScrollbar();
    });

    $("input[name='height']").keyup(function(){
        var height = $(this).val()
        height = height.replace(/[^\d.]/g, "");
        height = height.replace(/^\./g, "");
        height = height.replace(/\.{2,}/g, ".");
        height = height.replace(".", "$#$").replace(/\./g, "").replace("$#$", ".");
        height = height.replace(/^(\-)*(\d+)\.(\d).*$/, '$1$2.$3');
        $(this).val(height);
    })

    $("input[name='weight']").keyup(function(){
        var weight = $(this).val()
        weight = weight.replace(/[^\d.]/g, "");
        weight = weight.replace(/^\./g, "");
        weight = weight.replace(/\.{2,}/g, ".");
        weight = weight.replace(".", "$#$").replace(/\./g, "").replace("$#$", ".");
        weight = weight.replace(/^(\-)*(\d+)\.(\d\d).*$/, '$1$2.$3');
        $(this).val(weight);
    })

    $('.uploadImgList').on('change','input',function(){
        var files = this.files;
        var item = files[0];
        var imgContent = $('.imgContent')
            if (this.files && this.files[0]) {
                var reader = new FileReader();
                reader.onload = function(evt) {
                    imgContent.html('<img src="' + evt.target.result + '" />');
                }
                reader.readAsDataURL(this.files[0]);
            }else {
                imgContent.html('<div class="img" style="filter:progid:DXImageTransform.Microsoft.AlphaImageLoader(sizingMethod=scale,src=\'' + this.value + '\'"></div>');
            }
    })

    $('.eqitUploadImg input').change(function(){
        var that = this
        var files = this.files;
        var item = files[0];
        // console.log("原图片大小", item.size);
        var imgContent = $('.eqitUploadImg .imgContent')
        // if (item.size > 1024 * 1024 * 3) {
        //     // console.log("图片大于3M，开始进行压缩...");
        //     (function(img) {
        //      // console.log(img)
        //         var mpImg = new MegaPixImage(img);
        //         var resImg = document.createElement("img");
        //         resImg.file = img;
        //         mpImg.render(resImg, { maxWidth: 500, maxHeight: 500, quality: 1 }, function() {
        //          imgContent.html('<img src="' + $(resImg).attr('src') + '" />');
        //         });
        //     })(item);
        // }else{
            if (this.files && this.files[0]) {
                var reader = new FileReader();
                reader.onload = function(evt) {
                    imgContent.html('<img src="' + evt.target.result + '" />');
                }
                reader.readAsDataURL(this.files[0]);
                $(this).attr('name',"new_file")
                $(this).siblings('.imgContent').css('height','auto')
            }else {
                $(this).siblings('.imgContent').css('height','240px')
                imgContent.html('<div class="img" style="filter:progid:DXImageTransform.Microsoft.AlphaImageLoader(sizingMethod=scale,src=\'' + this.value + '\'"></div>');
            }
            setTimeout(function(){
                $(that).css('height',$(that).siblings('.imgContent').css('height'))
            }, 500);
            
        // }
    })

    $('.diagnosis-doctors').change(function(){
        if($(this).val()){
            var option = $("option[value='"+ $(this).val() +"']")
            $('input[name="hospital"]').val(option.attr('data-hospital'))
            $('input[name="doctor"]').val(option.attr('data-name'))
        }
    })

    $('.mode_sel li').click(function(){
        if(!$(this).hasClass('selected')){
            $(this).addClass('selected').siblings().removeClass('selected')
        }
        if($('.mode_sel .selected').children('span').html() == '缩图' || $('.mode_sel .selected').children('span').html() == '图表'){
            $('.ceanza_list').css('display','none')
            $('.contraction').css('display','block')
            $('.height_record_list').css('display','none')
            $('.height_record_contraction').css('display','block')
            $('.weight_record_list').css('display','none')
            $('.weight_record_contraction').css('display','block')
            $('.prompt').css('display','block')
        }else{
            $('.ceanza_list').css('display','block')
            $('.contraction').css('display','none')
            $('.height_record_list').css('display','block')
            $('.height_record_contraction').css('display','none')
            $('.weight_record_list').css('display','block')
            $('.weight_record_contraction').css('display','none')
            $('.prompt').css('display','none')
        }
    })

    $('.list').on('click','li:nth-child(odd)',function(){
        $(this).next().toggle()
    })

    $('.consultation_detail').on('click','li',function(){
        $('.consultation_detail .operation').toggle()
    })

    $('.medical_institution_detail').on('click','li',function(){
        $('.medical_institution_detail .operation').toggle()
    })

    $('.title-menu>input').click(function(){
        $('.headtitle-list').addClass('headtitle-list-block')
        $('.title-list').removeClass('title-list-block')
    })

    $('.headtitle-list .close').click(function(){
        event.stopPropagation()
        $('.headtitle-list').removeClass('headtitle-list-block')
    })

    $('.headtitle-list li').click(function(){
        event.stopPropagation()
        if($(this).html() == '一般日记'){
            $("input[name='title']").val('')
            $(this).addClass('checked').siblings('.checked').removeClass('checked')
            $('.headtitle-list').removeClass('headtitle-list-block')
        }else{
            $("input[name='title']").val($(this).html())
            $(this).addClass('checked').siblings('.checked').removeClass('checked')
            $(this).parents('.headtitle-list').removeClass('headtitle-list-block')
        }
        $(".title-menu>input")[0].focus()
    })

    $('.title-menu>a').click(function(){
        $('.title-list').addClass('title-list-block')
    })


    $('.title-menu .close').click(function(){
        event.stopPropagation()
        $('.title-list').removeClass('title-list-block')
    })

    $('.title-list li').click(function(){
        event.stopPropagation()
        $('.title-menu>a').html($(this).html())
        $("input[name='grow_diary_category_name']").val($(this).html())
        $(this).addClass('checked').siblings('.checked').removeClass('checked')
        $(this).parents('.title-list').removeClass('title-list-block')
    })

    $('.ceanza_category').click(function(){
        $('.category-list').addClass('title-list-block')
    })

    $('.ceanza_category .close').click(function(){
        event.stopPropagation()
        $('.category-list').removeClass('title-list-block')
    })

    $('.category-list li').click(function(){
        event.stopPropagation()
        $(this).addClass('checked').siblings('.checked').removeClass('checked')
        $(this).parents('.category-list').removeClass('title-list-block')
        $('.noData .ceanza_type').html($(this).html())
        location.href = '../cn/ceanza_list.php?category_name='+ $(this).html()
    })

    $('.ceanza_add_submit').click(function(){
        var title = trim($("input[name='title']").val())
        var type = trim($("input[name='grow_diary_category_name']").val())
        var content = trim($("textarea[name='content']").val())
        var date = $("input[name='date']").val()
        var address = trim($(".address-input").val())
        var file = $("input[name='file']").val()
        if(!(title && type && content && date && address && file)){
            layer.msg('请填写完整成长日记信息')
            return false;
        }
    });

    $('.ceanza_eqit_submit').click(function(){
        var title = trim($("input[name='title']").val())
        var content = trim($("input[name='content']").val())
        var date = $("input[name='date']").val()
        var address = trim($(".address-input").val())
        var file = $("input[name='file']").val()
        if(!(title && content && date && address && file)){
            layer.msg('请填写完整成长日记信息')
            return false;
        }
    })

    $('.height_record .submit').click(function(){
        var height = trim($("input[name='height']").val())
        var date = $("input[name='date']").val()
        var file = $("input[name='file']").val()
        if(!(height && date && file)){
            layer.msg('请填写完整身高记录信息')
            return false;
        }
    })

    $('.weight_record .submit').click(function(){
        var weight = trim($("input[name='weight']").val())
        var date = $("input[name='date']").val()
        var file = $("input[name='file']").val()
        if(!(weight && date && file)){
            layer.msg('请填写完整体重记录信息')
            return false;
        }
    })

    $('.medical_institution_add_submit').click(function(){
        var hospital = trim($("input[name='hospital']").val())
        var doctor = trim($("input[name='doctor_name']").val())
        var address = trim($("input[name='address']").val())
        var phone = trim($("input[name='doctor_phone']").val())
        if(!(hospital && doctor && address && address && phone)){
            layer.msg('请填写完整医疗机构信息')
            return false;
        }
    })

    $('.medical_institution_eqit_submit').click(function(){
        var hospital = trim($("input[name='hospital']").val())
        var doctor = trim($("input[name='doctor_name']").val())
        var address = trim($("input[name='address']").val())
        var phone = trim($("input[name='doctor_phone']").val())
        if(!(hospital && doctor && address && address && phone)){
            layer.msg('请填写完整医疗机构信息')
            return false;
        }
    })

    $('.medical_record_add_submit').click(function(){
        var date = $("input[name='date']").val()
        var hospital = trim($("input[name='hospital']").val())
        var doctor = trim($("input[name='doctor']").val())
        var symptom = trim($("input[name='symptom']").val())
        var told = trim($("textarea[name='note']").val())
        if(!(date && hospital && doctor && symptom && told)){
            layer.msg('请填写完整就诊记录信息')
            return false;
        }
    })

    $('.medical_record_eqit_submit').click(function(){
        var date = $("input[name='date']").val()
        var hospital = trim($("input[name='hospital']").val())
        var doctor = trim($("input[name='doctor']").val())
        var symptom = trim($("input[name='symptom']").val())
        var told = trim($("textarea[name='note']").val())
        if(!(date && hospital && doctor && symptom && told)){
            layer.msg('请填写完整就诊记录信息')
            return false;
        }
    })

    $('.project_status p').click(function(){
        event.preventDefault()
        $(this).children('span').addClass('success').parents().siblings().children('span').removeClass('success')
    })
});
