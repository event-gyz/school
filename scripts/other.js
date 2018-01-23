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
//		console.log(args);
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
	$('.btn01,.btn_submit01,.btn_submit02,.btn_submit03,.btn_submit04,.btn_submit05').hover(function(){
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
          errEl: $('#errorbar_reg_tel')
        }
        getCode(waitTime, params)
	})
	
	$("#forget_ref_code").click(function() {
        var params = {
          Mobile: $('#forget_mobile').val(),
          validEl: $('#forget_ref_code'),
          errEl: $('#errorbar_reg_mobile')
        }
        getCode(waitTime, params)
	})

	$('.fancybox').click(function() {
		clearTimer(waitTime)
		$('#ref_code').html('获取验证码')
		$('#forget_ref_code').html('获取验证码')
	})

	$(window).load(function(){
		$(".tab-bd .scrolltype").mCustomScrollbar();
	});

	// var uploadLi;
	$('.uploadImgList').on('change','li>input',function(){
		var imgContent = $(this).prev()
		// if($('.uploadImgList li').length - 1 == $(this).parent().index() && $('.uploadImgList li').length < 6){
		// 	uploadLi = $(this).parent().clone()
		// }
		if (this.files && this.files[0]) {
	    	var reader = new FileReader();
	    	reader.onload = function(evt) {
	    		imgContent.html('<img src="' + evt.target.result + '" />');
	    	}
	    	reader.readAsDataURL(this.files[0]);
	    	// $('.uploadImgList ').append(uploadLi)
	    }else {
	    	imgContent.html('<div class="img" style="filter:progid:DXImageTransform.Microsoft.AlphaImageLoader(sizingMethod=scale,src=\'' + this.value + '\'"></div>');
	    }
	})
	
	$('.eqitUploadImg input').change(function(){
		var imgContent = $('.eqitUploadImg .imgContent')
	    if (this.files && this.files[0]) {
	      var reader = new FileReader();
	      reader.onload = function(evt) {
	        imgContent.html('<img src="' + evt.target.result + '" />');
	      }
	      reader.readAsDataURL(this.files[0]);
	      $(this).attr('name',"new_file")
	    } else {
	      imgContent.html('<div class="img" style="filter:progid:DXImageTransform.Microsoft.AlphaImageLoader(sizingMethod=scale,src=\'' + this.value + '\'"></div>');
	    }
	})

	$('.mode_sel li').click(function(){
		if(!$(this).hasClass('selected')){
			$(this).addClass('selected').siblings().removeClass('selected')
		}
		if($('.mode_sel .selected').children('span').html() == '缩图'){
			$('.ceanza_list').css('display','none')
			$('.contraction').css('display','block')
			$('.height_record_list').css('display','none')
			$('.height_record_contraction').css('display','block')
			$('.weight_record_list').css('display','none')
			$('.weight_record_contraction').css('display','block')
		}else{
			$('.ceanza_list').css('display','block')
			$('.contraction').css('display','none')
			$('.height_record_list').css('display','block')
			$('.height_record_contraction').css('display','none')
			$('.weight_record_list').css('display','block')
			$('.weight_record_contraction').css('display','none')
		}
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
		$(".title-menu>input:hidden").val($(this).html())
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
	})

	$('.project_status p').click(function(){
		event.preventDefault()
		$(this).children('span').addClass('success').parents().siblings().children('span').removeClass('success')
	})


	$('.project_detail>p').click(function(){
		$(this).children('span').toggleClass('success')
	})



	var currentIndex = 1;
	var ulLeft = 0;
	for(var i = 0; i < $('.project_list li').length; i++){
		var li = $('.project_list li').eq(i)
		ulLeft += -(parseInt(li.css('width')) + parseInt(li.css('marginRight')))
	}

	function project_tab_change(args){
		$('.project_list li').removeClass('selected')
		$('.project_list li:eq(' + (args.currentSlideNumber - 1) + ')').addClass('selected');
		var liWidth = parseInt($('.project_list li').css('width'))
		var liMargin = parseInt($('.project_list li').css('marginRight'))
		$('.project_list ul').css('left',0)
		if(currentIndex < args.currentSlideNumber){
			currentIndex = args.currentSlideNumber
			if(args.currentSlideNumber > 0 && args.currentSlideNumber < 4){
				$('.project_list ul').css({'transform': 'matrix(1,0,0,1, ' + (ulLeft + ( - (args.currentSlideNumber - 1) * (liWidth + liMargin)) + 2) + ',0)'})
			}else if(args.currentSlideNumber > 5){
				$('.project_list ul').css({'transform': 'matrix(1,0,0,1, ' + (ulLeft + ( - ((args.currentSlideNumber - 4) * (liWidth + liMargin))) -14) + ',0)'})
			}
		}
		else if(currentIndex > args.currentSlideNumber){
			currentIndex = args.currentSlideNumber
			if(args.currentSlideNumber < 6 && args.currentSlideNumber > 3){
				$('.project_list ul').css({'transform': 'matrix(1,0,0,1, ' + (ulLeft + ( - ((args.currentSlideNumber - 4) * (liWidth + liMargin))) - 18) + ',0)'})
			}else if(args.currentSlideNumber < 2){
				$('.project_list ul').css({'transform': 'matrix(1,0,0,1, ' + (ulLeft + 2) + ',0)'})
			}
		}
	}

	$('.project_list').iosSlider();


	$('.project_tab').iosSlider({
		snapToChildren: true,
		desktopClickDrag: true,
		keyboardControls: true,
		navSlideSelector: $('.project_list li'),
		onSlideChange: project_tab_change
	});
});
