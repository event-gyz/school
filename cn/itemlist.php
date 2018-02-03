<?php
session_start();
include('inc.php');
if(!isset($_SESSION['user_token'])) {
    header( 'Location: index.php' ) ;
    exit();
}
$tabon = @$_REQUEST['f'];
if(!isset($tabon))
    $tabon = '0';
?>
<!DOCTYPE html>
<html><!-- InstanceBegin template="/Templates/_page01.dwt" codeOutsideHTMLIsLocked="false" -->
<head>
    <?php include('inc_head.php');	?>
    <style>
        body{background: none;}
        h1,h2,h3,h4,h5,h6,p,ul,li,dl,dt,dd{margin:0;padding:0;list-style: none;}
        input,button{padding: 0;margin:0;border:0;outline: none;}
        img{vertical-align: bottom}
    </style>
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
                        <div class="progress_board">
                            <div class="progress_data">
                                <h3>豆豆</h3>
                                <h4>进度记分板</h4>
                                <ul>
                                    <li>
                                        <p><span class="all">0</span>/ 1200</p>
                                        完成项目：
                                    </li>
                                    <li>
                                        <p><span class="eraly">0</span>枚</p>
                                        提前奖章：
                                    </li>
                                    <li>
                                        <p><span class="late">755</span>项</p>
                                        落后项目：
                                    </li>
                                </ul>
                            </div>
                        </div>

                        <!--//指標列表說明//-->
                        <div class="icon_explain">
                            <p><img src="../theme/cn/images/content/item_rep01.jpg"></b>进度超前
                                <span>红字</span>进度落后</p>
                            <p><img src="../theme/cn/images/content/item_rep02.jpg"></b>详细说明
                                <img src="../theme/cn/images/content/item_rep03.jpg"></b>专家建议</p>
                        </div>

                        <!--//成長指標列表//-->
                        <section class="slider_container">
                            <div class="project_list">
                                <ul class="clearfix">
                                    <li class="ttile selected">
                                        <a id="tab_01">语言沟通</a>
                                    </li>
                                    <li class="ttile">
                                        <a id="tab_02">社会人格</a>
                                    </li>
                                    <li class="ttile">
                                        <a id="tab_03">自觉认知</a>
                                    </li>
                                    <li class="ttile">
                                        <a id="tab_04">粗动作技能</a>
                                    </li>
                                    <li class="ttile">
                                        <a id="tab_05">细动作技能</a>
                                    </li>
                                    <li class="ttile">
                                        <a id="tab_06">自主能力</a>
                                    </li>
                                </ul>
                            </div>
                        </section>
                        <section class="replist">
                            <section class="tab-bd">

                                <div class="tabcont on">
                                    <table id="gi_table" border="0" cellpadding="0" cellspacing="0" class="tb-rep">
                                        <div class="project_status">
                                            <p data-status="b"><span class="changeStatus success"></span>未完成项目</p>
                                            <p data-status="c"><span class="changeStatus"></span>已完成项目</p>
                                        </div>
                                        <div class="title">
                                            <p>时间</p>
                                            <p>发展成就量表</p>
                                        </div>
                                        <div class="loadmore">
                                            <p><span>+</span>稍早</p>
                                        </div>

                                    </table>
                                </div>
                            </section>
                            <!--                       	<div id="next"><a href="gi_list_by_age.php?f=a&p=2"></a>&nbsp;</div>-->
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

<script type="text/javascript">
    $(function() {
//        a=all b=buhui c=yihui
        //语言沟通
        $("#tab_01").click(function(){
            initList('0');
            $(".ttile").removeClass("selected");
            $(this).parent('li').addClass("selected");
        });
        //社会人格
        $("#tab_02").click(function(){
            initList('1');
            $(".ttile").removeClass("selected");
            $(this).parent('li').addClass("selected");
        });
        //知觉认知
        $("#tab_03").click(function(){
            initList('4');
            $(".ttile").removeClass("selected");
            $(this).parent('li').addClass("selected");
        });
        //粗动作
        $("#tab_04").click(function(){
            initList('2');
            $(".ttile").removeClass("selected");
            $(this).parent('li').addClass("selected");
        });
        //细动作
        $("#tab_05").click(function(){
            initList('3');
            $(".ttile").removeClass("selected");
            $(this).parent('li').addClass("selected");
        });
        //自主能力
        $("#tab_06").click(function(){
            initList('5');
            $(".ttile").removeClass("selected");
            $(this).parent('li').addClass("selected");
        });

        ajaxLoadUserStat();
        initList('<?php echo($tabon); ?>');

        $(".project_status p").click(function(){
            var func = $(this).attr('data-status');
            var selectedId = $("li[class$='selected']").children("a").attr("ID");
            var type = '';
            if(selectedId == 'tab_01'){
                type = '0';
            }else if(selectedId == 'tab_02'){
                type = '1';
            }else if(selectedId == 'tab_03'){
                type = '4';
            }else if(selectedId == 'tab_04'){
                type = '2';
            }else if(selectedId == 'tab_05'){
                type = '3';
            }else if(selectedId == 'tab_06'){
                type = '5';
            }
            initList(type,func);
        });

        $(".loadmore p").click(function(){
            var func = $("span[class$='success']").parents().attr('data-status');
            var selectedId = $("li[class$='selected']").children("a").attr("ID");
            var type = '';
            var early = 'yes';
            if(selectedId == 'tab_01'){
                type = '0';
            }else if(selectedId == 'tab_02'){
                type = '1';
            }else if(selectedId == 'tab_03'){
                type = '4';
            }else if(selectedId == 'tab_04'){
                type = '2';
            }else if(selectedId == 'tab_05'){
                type = '3';
            }else if(selectedId == 'tab_06'){
                type = '5';
            }
            initList(type,func,early);
        });
    });

    function initList(type,func,early) {
        cur_func = func;
        var url = "gi_list_by_age.php?t="+type;
        if(func){
            link = url + "&f="+func;
        }else{
            link = url;
        }
        if(early){
            link = link + "&e="+early;
        }
//    	$("#next a").attr("href",url+"&p=2");

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

//	   		infiniteScrollContainer.infinitescroll({
//				navSelector  	: "#next",
//				nextSelector 	: "#next a",
//				itemSelector 	: "tr"
//			},addItemListeners);
        });
    }

    function addItemListeners() {
        $(".tablinks a").unbind();
        $(".tablinks a").click(function() {
            var u = $(this).attr("name");
            var t = $(this).attr("value");
            loadGIDetail(u,t);
            return false;
        });
        $(".new_ck").unbind();
        $(".new_ck").change(function() {
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
        $.ajax({
            url: "gi_load_user_stat.ajax.php",
            type: "POST",
            dataType: "json",
            success: function (jsonStr) {
                nick_name = jsonStr.nickname;
                all_count = jsonStr.all;
                $(".all").html(all_count);
                early_count = jsonStr.early;
                $(".eraly").html(early_count);
                late_count = jsonStr.late;
                $(".late").html(late_count);

            },
            error: function(xhr, err) {
                console.log('ajaxLoadUserStat failed: ' + err);
            }
        });
    }

    var nick_name,all_count,early_count,late_count,cur_func;
</script>
<?php include 'inc_bottom_js.php'; ?>
</body>

<!-- InstanceEnd --></html>
