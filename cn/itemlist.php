<?php
session_start(); 
include('inc.php');	
if(!isset($_SESSION['user_token'])) {
	header( 'Location: index.php' ) ;
	exit();
}
$tabon = $_REQUEST['f'];
if(!isset($tabon))
	$tabon = 'a';
?>
<!DOCTYPE html> 
<html><!-- InstanceBegin template="/Templates/_page01.dwt" codeOutsideHTMLIsLocked="false" -->
<head>
	<?php include('inc_head.php');	?>
</head>
<body>
<style>
     .fancybox-wrap,.fancybox-inner{max-width:550px !important;}
     .articlebox .Txt img{}
</style>
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
            <section class="indexcont">
            <section class="inbox">
            	<section class="contbox clearfix">
            	
                <!--//主選單標題與路徑//-->
                <h2 class="title">成长指标</h2>
                <section class="gopath"><a href="index.php">首頁</a> > 成长指标</section>
                <!--//主選單標題與路徑//-->
                
                <!--//成長指標//-->
                <section class="repbox">
                    
                    <!--//文字編輯器區//-->
                    <section class="Txt fl clearfix">
                        <p>
                        幼儿发展是阶段性的，每一步都必须踩稳才能迈向下一步！「1200项幼儿成长指标」其内容涵盖语言、认知、<br>
                        粗动作、细动作、人格、自主能力等六大范围，家长只要输入孩子的出生日期，系统即会协助家长检核孩子的发<br>
                        展，让孩子的成长基础更稳固、大脑的神经网络更紧密，好在未来有实力迎向各种挑战。
                        </p>
                    </section>
                    
                    <!--//記分板//-->
                    <section class="board">
                        <section class="inboard">
                        </section>
                    </section>
                    
                    <!--//指標列表說明//-->
                    <section class="tab-info">
                        <span><b><img src="../theme/cn/images/content/item_rep01.jpg"></b>进度超前</span>
                        <span><b>紅字</b>进度落后</span>
                        <br>
                        <span><b><img src="../theme/cn/images/content/item_rep02.jpg"></b>详细说明</span>
                        <span><b><img src="../theme/cn/images/content/item_rep03.jpg"></b>医生建议</span>
                    </section>
                    
                    <!--//成長指標列表//-->
                    <section class="replist">
                    	<section class="tab-hd">
                        	<ul class="clearfix">
                            	<li <?php if($tabon=='a') echo('class="on"'); ?>><a id="tab_01" href="#">全部项目</a></li>
	                            <li <?php if($tabon=='b') echo('class="on"'); ?>><a id="tab_02" href="#">还不会的项目</a></li>
                                <li <?php if($tabon=='c') echo('class="on"'); ?>><a id="tab_03"href="#">已经会的项目</a></li>
                            </ul>
                        </section>
                        <section class="tab-bd">
                        	<div class="tabcont on">
                        		<!--
                            	<div class="scrolltype">
                            	-->
                            	<table id="gi_table" border="0" cellpadding="0" cellspacing="0" class="tb-rep">
	                            	
                                </table>
                        		<!--
                                </div>
                            	-->
                            </div>
                        </section>
                       	<div id="next"><a href="gi_list_by_age.php?f=a&p=2"></a>&nbsp;</div>
                    </section>
                </section>
                <!--//成長指標//-->
                
                <!--//回頂端//-->
				<section class="gotop pc bodytop"><img src="../theme/cn/images/content/item_gotop01.png">回顶端</section>
                
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
    <script src="../scripts/jquery.masonry.min.js"></script>
    <link rel="stylesheet" href="../scripts/fancybox/jquery.fancybox.css">
    <script src="../scripts/fancybox/jquery.fancybox.pack.js"></script>
    <link rel="stylesheet" type="text/css" href="../scripts/scrollbar/jquery.mCustomScrollbar.css">
    <script src="../scripts/scrollbar/jquery.mCustomScrollbar.concat.min.js"></script>
    <script src="../scripts/scroll_loading/jquery.infinitescroll.min.js"></script>
    <script src="../scripts/ios_slider/jquery.iosslider.min.js"></script>
    <script src="../scripts/other.js"></script>
    <script type="text/javascript">
    $(function() { 
    	$("#tab_01").click(function(){
	    	initList('a');
    	});
    	$("#tab_02").click(function(){
	    	initList('b');
    	});
    	$("#tab_03").click(function(){
	    	initList('c');
    	});
    	
    	ajaxLoadUserStat();
    	initList('<?php echo($tabon); ?>');
    });
    
    function initList(func) {
    	cur_func = func;
    	var url = "gi_list_by_age.php?f="+func;
    	var link = url + "&p=1";
    	$("#next a").attr("href",url+"&p=2");
    	
	    var infiniteScrollContainer = $("#gi_table");
	    // Reset the plugin before intializing it again
    	infiniteScrollContainer.load(link, function() {
    		addItemListeners();
		    infiniteScrollContainer.infinitescroll('binding','unbind');
		    infiniteScrollContainer.data('infinitescroll', null);
		    $(window).unbind('.infscr');
	    
    		infiniteScrollContainer.infinitescroll({                      
			      state: {                                              
			        isDestroyed: false,
			        isDone: false,
			        isDuringAjax : false                           
			      }
			});
    		
	   		infiniteScrollContainer.infinitescroll({
				navSelector  	: "#next",
				nextSelector 	: "#next a",
				itemSelector 	: "tr"
			},addItemListeners);	    	
    	});    		
    }
    
    function addItemListeners() {
    	$(".tablinks a").unbind();
    	$(".tablinks a").click(function() {
    		var u = $(this).attr("name");
    		var t = $(this).attr("value");
//    		console.log("click item:"+u+", type="+t);
        	loadGIDetail(u,t);
        	return false;
    	});
    	$(".ck").unbind();
    	$(".ck").change(function() { 
    			//alert($(this).val() + ($(this).prop("checked")?"checked":"unchecked")); 
    			var item_uid = $(this).val();
    			var checked = ($(this).prop("checked")?1:0);
    			$("input[value="+item_uid+"]").prop("checked",$(this).prop("checked"));
    			ajaxCheckItem(item_uid,checked);
    		}
    	);    	
    }
    
    function ajaxCheckItem(uid,checked) {
	    $.ajax({
	    	url: "gi_check_item.ajax.php",
            type: "POST",
            data: {
                'p1': uid,
                'p2': checked,
            },
            dataType: "json",
            success: function (jsonStr) {
//            console.log(jsonStr);
            	if(jsonStr.result=='success') {
	              	var message = $.parseJSON(jsonStr.message);
	              	var uid = message.uid;
	              	var is_early = message.is_early;
	              	var is_late = message.is_late;
/*	              	
	              	if($("li[name=gi_"+uid+"]").hasClass('out')) {
		              	late_count--;	              	
	              	}
	              	if($("li[name=gi_"+uid+"]").hasClass('out')) {
		              	early_count--;
	              	}
*/	              	
	              	$("#gi_"+uid).removeClass('out');
	              	$("#gi_"+uid).removeClass('pass');
	              	if(is_early==true) {
	              		$("#gi_"+uid).addClass('pass');
//	              		early_count++;
	              	}
	              	if(is_late==true) {
	              		$("#gi_"+uid).addClass('out');
//	              		late_count++;	              	
	              	}
	              	// update stat panel
	              	/*
            		if(checked==0) {
	            		all_count--;
            		}
            		else {
	            		all_count++;
            		}
            		*/
            		//invalidateUserStat();
            		ajaxLoadUserStat();
//            		if(func=='c' && checked==0) {
//            			$("li").remove("[name=gi_"+uid+"]");
//            		}
            	}
            	else {
            	// changed nothing
            	}
             },
            error: function(xhr, err) {
	            alert('addUser failed: ' + err);
      		}
        });  
    }
    
    function ajaxLoadUserStat() {
		//$(".inboard").load("gi_load_user_stat.ajax.php");
	    $.ajax({
	    	url: "gi_load_user_stat.ajax.php",
            type: "POST",
            dataType: "json",
            success: function (jsonStr) {
            	console.log(jsonStr);
            	nick_name = jsonStr.nickname;
            	all_count = jsonStr.all;
            	early_count = jsonStr.early;
            	late_count = jsonStr.late;
            	invalidateUserStat();
            	
             },
            error: function(xhr, err) {
	            console.log('ajaxLoadUserStat failed: ' + err);
      		}
        });          
	}
	
	function invalidateUserStat() {
		var htmlString = '<h3>'+nick_name+'<b>进度记分板</b></h3><ul class="clearfix"><li><b>完成项目</b><i>'+all_count+'<small>/1200</small></i></li><li><b>提前奖章</b><i>'+early_count+'<small>枚</small></i></li><li><b>落后项目</b><i>'+late_count+'<small>项</small></i></li></ul>';
		$("section.inboard").html(htmlString);
	}
	
	function showUserStat() {
		
	}
	
	function showMoreInList(a_name) {
		if($("#"+a_name).text()=="[+]")
		{
			$("li[name='"+a_name+"']").show();
			$("#"+a_name).text("[-]");
		}
		else {
			$("li[name='"+a_name+"']").hide();
			$("#"+a_name).text("[+]");
		}
	}
	
	var nick_name,all_count,early_count,late_count,cur_func;
    </script>    
</body>
<!-- InstanceEnd --></html>
