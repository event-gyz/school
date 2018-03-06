<script src="../scripts/ssutils.js"></script>
<script type="text/javascript">
var _next_move_ = 0;

$(function(){
 
    // modify member
    $("#modify_member_form").submit(function(){
		var nickname = $("#fstmb_nickname").val();
		var phone = $("#fstmb_phone").val();
		var password = $("#fstmb_password").val();
		var password2 = $("#fstmb_password2").val();
		var check_ok = true;
		if(!nickname) {
			$("#fstmb_error1").show().delay(2000).fadeOut();
			check_ok = false;
		}
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
	                'p1': nickname,
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
		            alert('edit member failed: ' + err);
	      		}
      		});  
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

 
    // menu item click
    $("#menuitem_2").click(onMenuItem2NewClick);
    $("#menuitem_2_m").click(onMenuItem2NewClick);
    $("#menuitem_3").click(onMenuItem3Click);
    $("#menuitem_3_m").click(onMenuItem3Click);
    $("#menuitem_4").click(onMenuItem4Click);
    $("#menuitem_4_m").click(onMenuItem4Click);
    $("#menuitem_6").click(onMenuItem6Click);
    $("#menuitem_6_m").click(onMenuItem6Click);
    $("#menuitem_7").click(onMenuItem7Click);
    $("#menuitem_7_m").click(onMenuItem7Click);
	$("#menuitem_8").click(onMenuItem8Click);
	$("#menuitem_8_m").click(onMenuItem8Click);

});

function onMenuItem2Click() {
	$.ajax({url: "check_login_status.ajax.php",
            type: "POST",
            dataType: "json",
            success: function (jsonStr) {
            	if(jsonStr.islogin==true) {
	            	_next_move_ = 0;
            		document.location.href = 'ceanza_list.php';
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

function onMenuItem2NewClick() {
	$.ajax({url: "check_login_status.ajax.php",
		type: "POST",
		dataType: "json",
		success: function (jsonStr) {
			if(jsonStr.islogin==true) {
				_next_move_ = 0;
				document.location.href = 'ceanza_add.php';
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
	            alert('Ajax request ' + err);
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
            		document.location.href = 'http://x.eqxiu.com/s/PclsbuXT';
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
	            console.log('Ajax request ' + err);
      		}
        });  	
}

function onMenuItem7Click() {
	$.ajax({url: "check_login_status.ajax.php",
            type: "POST",
            dataType: "json",
            success: function (jsonStr) {
            	if(jsonStr.islogin==true) {
	            	_next_move_ = 0;
            		document.location.href = 'http://x.eqxiu.com/s/PclsbuXT';
            	}
            	else {
	            	_next_move_ = 107;
            		$.fancybox({        
            			href: "#fy-login"    
            		});
            	}
             },
            error: function(xhr, err) {
      		}
        }); 
}

function onMenuItem8Click() {
	$.ajax({url: "check_login_status.ajax.php",
		type: "POST",
		dataType: "json",
		success: function (jsonStr) {
			if(jsonStr.islogin==true) {
				_next_move_ = 0;
				document.location.href = 'http://x.eqxiu.com/s/PclsbuXT';
			}
			else {
				_next_move_ = 107;
				$.fancybox({
					href: "#fy-login"
				});
			}
		},
		error: function(xhr, err) {
		}
	});
}

function goUrlClick(url) {
	$.ajax({url: "check_login_status.ajax.php",
		type: "POST",
		dataType: "json",
		success: function (jsonStr) {
			if(jsonStr.islogin==true) {
				if(jsonStr.haskid==true) {
					_next_move_ = 0;
					document.location.href = url;
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
			alert('Ajax request ' + err);
		}
	});
}

//-- birhday --//
function showEditBabyBox() {
	var cur_year = new Date().getFullYear();
	$('#birth_box_years').html('');
	$('#birth_box_months').html('');
	$('#birth_box_days').html('');
	for (i = cur_year; i > (cur_year-10); i--) {
    	$('#birth_box_years').append($('<option />').val(i).html(i));
    }

    for (i = 1; i < 13; i++) {
    	$('#birth_box_months').append($('<option />').val(i).html(i));
    }
    updateNumberOfDays(); 

    $('#birth_box_years, #birth_box_months').change(function(){
        updateNumberOfDays(); 
    });
    $.fancybox({        
    	href: "#fy-fst"    
    });
}

function updateNumberOfDays(){
	$('#birth_box_days').html('');
	month=$('#birth_box_months').val();
	year=$('#birth_box_years').val();
	days=daysInMonth(month, year);

    for(i=1; i < days+1 ; i++){
	    $('#birth_box_days').append($('<option />').val(i).html(i));
    }
}

function daysInMonth(month, year) {
    return new Date(year, month, 0).getDate();
}

function checkEmailFormat() {
	if(!isEmail($("#login_id").val())) {
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

</script>
<?php 
	if(isset($_SESSION['user_token'])) {
		echo ('<script type="text/javascript"> $(function(){ $("#ex_target_text").text("立即使用"); });</script>');
	}
 	$filename = basename($_SERVER['PHP_SELF']); 
 	$pagename = substr($filename, 0, strrpos($filename, "."));
?>

<header id="header">
    <section class="inbox clearfix">
        <h1><a href="index.php"><img src="../theme/cn/images/header/item_logo.jpg"></a></h1>
        <nav>
            <!--//登入前//-->
            <ul class="tnav" name="login_status" id="login_status">
            <?php 
	            if(isset($_SESSION['user_token'])) {
	            echo('<li class="m_name-point fst"><b>'.$_SESSION['user_email'].'</b></li><li><a href="javascript:doLogout();">登出</a></li>');
				}
				else {
			?>
                <li class="fst"><a href="#fy-register" class="fancybox">注册</a></li>
                <li><a href="#fy-login" class="fancybox">登入</a></li>					
            <?php 
				}
			?>
            </ul>
            <!--//選單//-->
            <ul class="mnav">
	            <li <?php if($pagename=='news') echo('class="on"'); ?> ><a href="news.php">最新消息</a></li>
				<li <?php if($pagename=='recommend') echo('class="on"'); ?>><a href="recommend.php">推荐文章</a></li>
				<li <?php if($pagename=='itemlist') echo('class="on"'); ?>><a id="menuitem_3" href="javascript:void(0);">成长指标</a></li>
				<li <?php if($pagename=='report') echo('class="on"'); ?>><a id="menuitem_6" href="javascript:void(0);">成长报告</a></li>
	            <li <?php if($pagename=='ceanza_menu') echo('class="on"'); ?>><a id="menuitem_2" href="javascript:void(0);">成长日记</a></li>

<!--	            <li --><?php //if($pagename=='training') echo('class="on"'); ?><!-->
<!--					<a id="menuitem_4" href="javascript:void(0);">每日e练习</a>-->
<!--				</li>-->
	            <li <?php if($pagename=='buds_record') echo('class="on"'); ?>><a id="menuitem_8">萌芽记录</a></li>

	            <li <?php if($pagename=='epaper') echo('class="on"'); ?>><a  id="menuitem_7" href="javascript:void(0);">巴布豆家庭早教</a></li>
	            <li <?php if($pagename=='about') echo('class="on"'); ?>><a href="about.php">关于我们</a></li>
            </ul>
        </nav>
    </section>
    
    <!--//手機選單//-->
    <div class="i-menu">Menu</div>
   	<nav class="s-mnav">
        <ul class="clearfix">


            <li <?php if($pagename=='news') echo('class="on"'); ?> ><a href="news.php">最新消息</a></li>
			<li <?php if($pagename=='recommend') echo('class="on"'); ?>><a href="recommend.php">推荐文章</a></li>
			<li <?php if($pagename=='itemlist') echo('class="on"'); ?>><a id="menuitem_3_m" href="javascript:void(0);">成长指标</a></li>
			<li <?php if($pagename=='report') echo('class="on"'); ?>><a id="menuitem_6_m" href="javascript:void(0);">成长报告</a></li>
			<li <?php if($pagename=='ceanza_menu') echo('class="on"'); ?>><a id="menuitem_2_m" href="javascript:void(0);">成长日记</a></li>
            <li <?php if($pagename=='buds_record') echo('class="on"'); ?>><a id="menuitem_8_m">萌芽记录</a></li>

            <li <?php if($pagename=='epaper') echo('class="on"'); ?>><a id="menuitem_7_m" href="javascript:onMenuItem4Click();">巴布豆家庭早教</a></li>
            <li <?php if($pagename=='about') echo('class="on"'); ?>><a href="about.php">关于我们</a></li>
            <?php 
	            if(isset($_SESSION['user_token'])) {
		            echo('<li class="last"><b>'.$_SESSION['user_email'].'</b><a href="javascript:doLogout();">登出</a></li>');		
				}
				else {
			?>
            <li class="last" name="login_status_m" id="login_status_m"><a href="#fy-register" class="fst fancybox">注册</a><a href="#fy-login" class="fancybox">登入</a></li>
            <?php 
				}
			?>
        </ul>
    </nav>
    <section class="bg-o"></section>
    <!--//選單//-->
	<?php
	include("inc_fancyboxes.php");
	?>	
</header>
