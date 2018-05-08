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
<?php
$_token = $_SESSION['user_token'];
$supervisor_uid = $CMEMBER->accessFromToken($_token);
$select_membership = 'select membership from member where uid = '.$supervisor_uid;
$membership = M()->find($select_membership);
if($membership['membership']<time()){
    header("Content-type: text/html; charset=utf-8");
    $url = "/cn/index.php";
//    echo "<script src=\"../scripts/layer.js\"></script>";
    echo "<script language='javascript' type='text/javascript'>";
    echo "alert('您的会员已到期');";
    echo "window.location.href='$url';";
    echo "</script>";
    exit;
}
?>
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
        <section class="indexcont itenlist">
            <section class="inbox noBoxShadowPage">
                <section class="contbox clearfix">

                    <!--//主選單標題與路徑//-->
                    <h2 class="title">成长指标</h2>
                    <section class="gopath"><a href="index.php">首页</a> > 成长指标</section>
                    <!--//主選單標題與路徑//-->

                    <!--//成長指標//-->
                    <section class="repbox">

                        <!--//文字編輯器區//-->
                        <section class="Txt fl clearfix">
                            <p>
                                「1200项幼儿成长指标」其内容涵盖0-6岁关键期的语言、认知、粗动作、细动作、人格、自主能力等六大范围，家长只要输入孩子的出生日期，系统即会协助家长检核孩子的发展，参考分析结果为孩子扬长補短，奠定未来发展的基础。
                            </p>
                            <div class="item_successed_chart"></div>
                        </section>
                        <!--//成長指標列表//-->
                        <section class="slider_container">
                            <div class="project_list">
                                <ul class="clearfix">
                                    <li class="ttile selected">
                                        <a id="tab_01">语言</a>
                                    </li>
                                    <li class="ttile">
                                        <a id="tab_02">人格</a>
                                    </li>
                                    <li class="ttile">
                                        <a id="tab_03">认知</a>
                                    </li>
                                    <li class="ttile">
                                        <a id="tab_04">粗动作</a>
                                    </li>
                                    <li class="ttile">
                                        <a id="tab_05">细动作</a>
                                    </li>
                                    <li class="ttile">
                                        <a id="tab_06">自主</a>
                                    </li>
                                </ul>
                            </div>
                            <p><img src="../content/epaper/images/language_communication.jpg" alt=""></p>
                        </section>
                        <section class="replist">
                            <section class="tab-bd">

                                <div class="tabcont on">
                                    <div class="title">
                                        <p>时间</p>
                                        <p class="develop">发展成就量表</p>
                                    </div>
                                    <p class="backwardness"><span>红字</span>进度落后</p>
                                    <div class="loadmore">
                                        <p><span class="decrement">-</span><span class="increase">+</span>稍早</p>
                                    </div>
                                    <table id="gi_table" border="0" cellpadding="0" cellspacing="0" class="tb-rep">
                                        
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
    //    $(function() {
    /**
     * 传入相应参数返回圆形制定半径的弧度坐标
     * @param {*} x 中心点X坐标
     * @param {*} y 中心点y坐标
     * @param {*} R 圆半径
     * @param {*} a 角度
     */
    function coordMap(x, y, R, a) {
        var ta = (360 - a) * Math.PI / 180,
            tx, ty;
        tx = R * Math.cos(ta); // 角度邻边
        ty = R * Math.sin(ta); // 角度的对边
        return {
            x: x + tx,
            y: y - ty // 注意此处是“-”号，因为我们要得到的Y是相对于（0,0）而言的。
        }
    }

    /**
     * 创建弧线
     * @param {*} data.startAngle 开始角度
     * @param {*} data.endAngle 结束角度
     * @param {*} data.R 圆半径
     * @param {*} data.x 中心点X坐标
     * @param {*} data.y 中心点y坐标
     * @param {*} data.color 边框颜色  默认#CCC
     * @param {*} data.strokeWidth 边框宽度 默认1
     * @param {*} data.strokelinecap 不同类型的路径的开始结束点 可选值 butt round square  默认butt
     * @param {*} data.strokeDasharray 虚线设置 它是一个<length>和<percentage>数列，数与数之间用逗号或者
     * 空白隔开，指定短划线和缺口的长度。如果提供了奇数个值，则这个值的数列重复一次，从而变成偶数个值。因此，5,3,2等同于5,3,2,5,3,2。
     * @param {*} data.transform CSS3旋转设置
     */
    function drawSVG(data) {
        var path,
            // 起点坐标
            s = new coordMap(data.x, data.y, data.R, data.startAngle),
            // 结束坐标
            e = new coordMap(data.x, data.y, data.R, data.endAngle),
            // 创建弧线路径
            tpath = document.createElementNS("http://www.w3.org/2000/svg", "path");
        // 画一段到(x,y)的椭圆弧. 椭圆弧的 x, y 轴半径分别为 rx,ry. 椭圆相对于 x 轴旋转 x-axis-rotation 度. large-arc=0表明弧线小于180读, large-arc=1表示弧线大于180度. sweep=0表明弧线逆时针旋转, sweep=1表明弧线顺时间旋转.
        // svg : [A | a] (rx ry x-axis-rotation large-arc-flag sweep-flag x y)+
        path = 'M' + s.x + ',' + s.y + 'A' + data.R + ',' + data.R + ',0,' + (+(data.endAngle - data.startAngle > 180)) + ',1,' + e.x + ',' + e.y;
        // 设置路径
        tpath.setAttribute('d', path);
        // 去掉填充
        tpath.setAttribute("fill", "none");
        // 设置颜色
        tpath.setAttribute('stroke', data.color || '#CCC');
        // 设置透明度
        tpath.setAttribute('opacity', data.opacity || '1');
        // 边线宽度
        tpath.setAttribute('stroke-width', data.strokeWidth || 1);
        data.strokelinecap ? tpath.setAttribute('stroke-linecap', data.strokelinecap) : '';
        data.strokeDasharray ? tpath.setAttribute('stroke-dasharray', data.strokeDasharray) : '';
        data.transform ? tpath.setAttribute('transform', data.transform) : '';
        return tpath;
    }

    /**
     * 创建文本
     * @param {*} data.x 中心点X坐标
     * @param {*} data.y 中心点y坐标
     * @param {*} data.transform CSS3旋转设置
     */
    function drawRectSVG(data) {
        // 创建text
        var rect = document.createElementNS("http://www.w3.org/2000/svg", "rect");
        // 设置 x
        rect.setAttribute('x', data.x);
        // 设置 y
        rect.setAttribute('y', data.y);
        // 设置 width
        rect.setAttribute('width', data.width || '28');
        // 设置 height
        rect.setAttribute('height', data.height || '16');
        // 设置 rx
        rect.setAttribute('rx', data.rx || '2');
        // 设置 ry
        rect.setAttribute('ry', data.ry || '2');
        // 设置 fill
        rect.setAttribute('fill', data.fill || '#62BE54');
        data.transform ? rect.setAttribute('transform', data.transform) : '';
        return rect;
    }

    /**
     * 创建文本
     * @param {*} data.x 中心点X坐标
     * @param {*} data.y 中心点y坐标
     * @param {*} data.strokeDasharray 虚线设置 它是一个<length>和<percentage>数列，数与数之间用逗号或者
     * 空白隔开，指定短划线和缺口的长度。如果提供了奇数个值，则这个值的数列重复一次，从而变成偶数个值。因此，5,3,2等同于5,3,2,5,3,2。
     * @param {*} data.transform CSS3旋转设置
     */
    function drawTextSVG(data) {
        // 创建text
        var tspan = document.createElementNS("http://www.w3.org/2000/svg", "text");
        // 设置 class
        tspan.setAttribute('class', data.className || '');
        // 设置 x
        tspan.setAttribute('x', data.x);
        // 设置 y
        tspan.setAttribute('y', data.y);
        // 设置文本大小
        tspan.setAttribute("font-size", data.size || '12px');
        // 设置颜色
        tspan.setAttribute('fill', data.color || '#CCC');
        // 设置文本居中
        tspan.setAttribute('text-anchor', data.anchor || '');
        // 设置文本背景颜色
        tspan.setAttribute('background-color', data.background || '');
        // 设置文本背景倒角
        tspan.setAttribute('border-radius', data.radius || '');
        tspan.setAttribute('alignment-baseline', 'before-edge');
        // 设置文本内容
        tspan.textContent = data.text
        // 边线宽度
        tspan.setAttribute('font-weight', data.weight || 'normal');
        data.transform ? tspan.setAttribute('transform', data.transform) : '';
        return tspan;
    }

    /**
     * @param {*} $select  容器
     * @param {*} size 已完成的指标个数
     * @param {*} currentSize 当前年龄段所需完成指标个数
     */
        // 创建SVG
    var svg = document.createElementNS("http://www.w3.org/2000/svg", "svg");
    svg.setAttribute("version", "1.1"); // IE9+ support SVG 1.1 version
    function svgView($select, size, currentSize , late) {
        $("svg").empty()
        var size = size
        // 画轴线并加入SVG中
        svg.appendChild(new drawSVG({
            startAngle: 25,
            endAngle: 335,
            x: 80,
            y: 120,
            R: 63,
            strokelinecap: 'round',
            color: '#62BE54',
            strokeWidth: 8,
            transform: 'rotate(90, 80, 120)'
        }));
        // 画矩形框并加入SVG中
        svg.appendChild(new drawRectSVG({
            x: 18,
            y: 3,
            width: 12,
            height: 12,
            fill: '#FFD181'
        }));
        // 画文本并加入SVG中
        svg.appendChild(new drawTextSVG({
            x: '50%',
            y: 2,
            size: '14px',
            text: '完成度'+Math.round(size/currentSize*100)+'%',
            color: '#7C7C7C',
            weight: 'bold',
            anchor: 'middle'
        }));
        svg.appendChild(new drawTextSVG({
            x: '50%',
            y: 20,
            size: '14px',
            text: '（落后项目：'+late+'）',
            color: '#A6A7A8',
            anchor: 'middle'
        }));
        svg.appendChild(new drawTextSVG({
            x: '50%',
            y: 100,
            size: '16px',
            text: '<?= $_SESSION['CURRENT_KID_NICKNAME'];?>',
            color: '#8D8D8D',
            weight: 'bold',
            anchor: 'middle'
        }));


        svg.appendChild(new drawTextSVG({
            x: '50%',
            y: 120,
            size: '14px',
            text: '<?php
                $birthday = new DateTime($_SESSION['CURRENT_KID_BIRTH_DAY']);
                $diff = $birthday->diff(new DateTime());
                $months = $diff->format('%m') + 12 * $diff->format('%y');
                $year = floor($months/12);
                $mm = $months%12;
                echo '(';
                if($year>0){
                    echo $year.'岁';
                }
                if($mm>0){
                    echo $mm.'个月';
                }
                echo ')';
                ?>',
            color: '#8D8D8D',
            anchor: 'middle'
        }));
        svg.appendChild(new drawRectSVG({
            x: 37,
            y: 131,
            transform: 'rotate(60, 37, 131)'
        }));
        svg.appendChild(new drawTextSVG({
            className: 'age-group',
            x: 40,
            y: 135,
            size: '12px',
            text: '1岁',
            color: '#FFF',
            transform: 'rotate(60, 40, 135)'
        }));
        svg.appendChild(new drawRectSVG({
            x: 48,
            y: 87,
            transform: 'rotate(-240, 48, 87)'
        }));
        svg.appendChild(new drawTextSVG({
            className: 'age-group',
            x: 46,
            y: 91,
            size: '12px',
            text: '2岁',
            color: '#FFF',
            transform: 'rotate(-240, 46, 91)'
        }));
        svg.appendChild(new drawRectSVG({
            x: 66,
            y: 60
        }));
        svg.appendChild(new drawTextSVG({
            className: 'age-group',
            x: 70,
            y: 62,
            size: '12px',
            text: '3岁',
            color: '#FFF'
        }));
        svg.appendChild(new drawRectSVG({
            x: 125,
            y: 80,
            transform: 'rotate(60, 125, 80)'
        }));
        svg.appendChild(new drawTextSVG({
            className: 'age-group',
            x: 126,
            y: 85,
            size: '12px',
            text: '4岁',
            color: '#FFF',
            transform: 'rotate(60, 126, 85)'
        }));
        svg.appendChild(new drawRectSVG({
            x: 110,
            y: 154,
            transform: 'rotate(-60, 110, 154)'
        }));
        svg.appendChild(new drawTextSVG({
            className: 'age-group',
            x: 112,
            y: 150,
            size: '12px',
            text: '5岁',
            color: '#FFF',
            transform: 'rotate(-60, 112, 150)'
        }));
        svg.appendChild(new drawTextSVG({
            x: '50%',
            y: 180,
            size: '13px',
            text: '0岁~6岁',
            color: '#62BE55',
            weight: 'bold',
            anchor: 'middle'
        }));
        svg.appendChild(new drawTextSVG({
            x: '50%',
            y: 180,
            size: '13px',
            text: '0岁~6岁',
            color: '#62BE55',
            weight: 'bold',
            anchor: 'middle'
        }));
        // 画内圈并加入SVG中
        svg.appendChild(new drawSVG({
            startAngle: 1,
            endAngle: 359,
            x: 80,
            y: 120,
            R: 57,
            strokelinecap: 'round',
            color: '#E9EFF1',
            opacity: .6,
            strokeWidth: 5
        }));
        // 步长
        var step = (330 - 30) / 1200,
            i = 1;
        // 画当前阶段所需完成度弧线并加入SVG中
        svg.appendChild(new drawSVG({
            startAngle: 30,
            endAngle: 30 + (330 - 30) / 1200 * currentSize,
            x: 80,
            y: 120,
            R: 75,
            strokelinecap: 'round',
            strokeWidth: 10,
            color: '#F3A41A',
            transform: 'rotate(90, 80, 120)'
        }));
        // 画已完成度弧线并加入SVG中
        svg.appendChild(new drawSVG({
            startAngle: 30,
            endAngle: 30 + step * i,
            x: 80,
            y: 120,
            R: 75,
            strokelinecap: 'round',
            strokeWidth: 10,
            color: '#FFD181',
            transform: 'rotate(90, 80, 120)'
        }));
        // 写入页面
        document.querySelector('.item_successed_chart').appendChild(svg);
        // 通过设置时间循环步
        var tc = setInterval(function() {
            // 创建新的弧线 替换进度弧线
            svg.replaceChild(new drawSVG({
                startAngle: 30,
                endAngle: 30 + step * i,
                x: 80,
                y: 120,
                R: 75,
                strokelinecap: 'round',
                strokeWidth: 10,
                color: '#FFD181',
                transform: 'rotate(90, 80, 120)'
            }), svg.lastChild);
            i++;
            if (i > size) {
                clearInterval(tc);
            }
        }, 5);
    };
    <?php
    //        $user_age = $_SESSION['CURRENT_KID_AGE'];
    //        $start_age = $user_age-1;
    //        $end_age = $user_age+1;
    //        if(!empty($e) && ($start_age>=12)){
    //            $start_age -=4;
    //        }
    //        $user_uid = $_SESSION["CURRENT_KID_UID"];
    //        $sql = "select count(*) as cc from grow_index left join grow_log as log on log.item_uid=grow_index.uid where ((grow_index.age_min >= '$start_age' and grow_index.age_min<= '$end_age') or (grow_index.age_max <= '$end_age' and grow_index.age_max >= '$start_age')) and user_uid=$user_uid";
    //        $res = M()->find($sql);
    //        if(empty($res)){
    //            $res['cc'] = 0;
    //        }
    //        $sql = "select count(*) as cc from grow_index where ((grow_index.age_min >= '$start_age' and grow_index.age_min<= '$end_age') or (grow_index.age_max <= '$end_age' and grow_index.age_max >= '$start_age'))";
    //        $re = M()->find($sql);
    //        if(empty($re)){
    //            $re['cc'] = 0;
    //        }
    //
    //        $sql = "select count(DISTINCT grow_index.uid) as cc from grow_index left join grow_log on grow_index.uid = grow_log.item_uid where grow_index.age_max <= '$start_age' and( grow_log.user_uid != $user_uid or grow_log.uid is null)";
    //        $late = M()->find($sql);
    //        if(empty($late)){
    //            $late['cc'] = 0;
    //        }
    //
    //        ?>
    //        svgView('#svgView', <?//=$res['cc']?>//, <?//=$re['cc']?>//, <?//=$late['cc']?>//);


    //        a=all b=buhui c=yihui
    //语言沟通
    $("#tab_01").click(function(){
        initList('0');
        $(".ttile").removeClass("selected");
        $(this).parent('li').addClass("selected");
        $(".loadmore p").removeClass("have_selected");
        $('.slider_container p>img').attr('src','../content/epaper/images/language_communication.jpg')
    });
    //社会人格
    $("#tab_02").click(function(){
        initList('1');
        $(".ttile").removeClass("selected");
        $(this).parent('li').addClass("selected");
        $(".loadmore p").removeClass("have_selected");
        $('.slider_container p>img').attr('src','../content/epaper/images/social_personality.jpg')
    });
    //知觉认知
    $("#tab_03").click(function(){
        initList('4');
        $(".ttile").removeClass("selected");
        $(this).parent('li').addClass("selected");
        $(".loadmore p").removeClass("have_selected");
        $('.slider_container p>img').attr('src','../content/epaper/images/conscious_cognition.jpg')
    });
    //粗动作
    $("#tab_04").click(function(){
        initList('2');
        $(".ttile").removeClass("selected");
        $(this).parent('li').addClass("selected");
        $(".loadmore p").removeClass("have_selected");
        $('.slider_container p>img').attr('src','../content/epaper/images/fine_action.jpg')
    });
    //细动作
    $("#tab_05").click(function(){
        initList('3');
        $(".ttile").removeClass("selected");
        $(this).parent('li').addClass("selected");
        $(".loadmore p").removeClass("have_selected");
        $('.slider_container p>img').attr('src','../content/epaper/images/rough_action.jpg')
    });
    //自主能力
    $("#tab_06").click(function(){
        initList('5');
        $(".ttile").removeClass("selected");
        $(this).parent('li').addClass("selected");
        $(".loadmore p").removeClass("have_selected");
        $('.slider_container p>img').attr('src','../content/epaper/images/autonomy.jpg')
    });

    ajaxLoadUserStat();
    initList('<?php echo($tabon); ?>');

    $(".loadmore p").click(function(){
        $(this).children('.increase').toggle().siblings('.decrement').toggle();
        var have_selected = $(this).hasClass("have_selected");
        var func = $("span[class$='success']").parents().attr('data-status');
        var selectedId = $("li[class$='selected']").children("a").attr("ID");
        var type = '';
        if(have_selected){
            $(".loadmore p").removeClass("have_selected");
        }else{
            $(this).addClass("have_selected");
            var early = 'yes';
        }
        if(selectedId == 'tab_01'){
            //语言沟通
            type = '0';
        }else if(selectedId == 'tab_02'){
            //社会
            type = '1';
        }else if(selectedId == 'tab_03'){
            //自觉认知
            type = '4';
        }else if(selectedId == 'tab_04'){
            //粗动作
            type = '2';
        }else if(selectedId == 'tab_05'){
            //系动作
            type = '3';
        }else if(selectedId == 'tab_06'){
            //自主能力
            type = '5';
        }
        initList(type,func);


    });
    //    });

         function initList(type,func) {
             if( $(".increase").css("display")=='none' ) {
                 var early = 'yes';

             }
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
        $(".isComplete").unbind();
        $(".isComplete").click(function() {
                var item_uid = $(this).attr('name');
                ajaxCheckItem(item_uid);
            }
        );
    }

    function ajaxCheckItem(uid) {
        $.ajax({
            url: "gi_check_item.ajax.php",
            type: "POST",
            data: {
                'p1': uid
            },
            dataType: "json",
            success: function (jsonStr) {
                if(jsonStr.result=='success') {
                    var message = $.parseJSON(jsonStr.message);
                    var uid = message.uid;
                    var is_early = message.is_early;
                    var is_late = message.is_late;
                    $("#gi_"+uid).remove();
                    ajaxLoadUserStat();
                    layer.msg('保存成功');
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
                fina_count = jsonStr.fina;
                late_count = jsonStr.late;
                $("svgView").remove();
                svgView('#svgView', fina_count, all_count, late_count);
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
