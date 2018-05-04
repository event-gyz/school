<?php
session_start(); 
include('inc.php'); 
//SELECT TYPE , COUNT( * ) FROM grow_index GROUP BY TYPE
$fen_mu = array(161,217,176,123,289,180);
$fen_zi = array(0,0,0,0,0,0);
$total_learned = 0;
$user_uid = $_SESSION["CURRENT_KID_UID"];
$sql = "SELECT TYPE as t , COUNT( * ) as c FROM grow_log where user_uid='$user_uid' GROUP BY t";
$result = M()->select($sql);
if($result!=null) {
    foreach($result as $row){
        $type = $row['t'];
        $count = $row['c'];
        $fen_zi[$type] = $count;
        $total_learned += $count;
    }
    $data = array(0,0,0,0,0,0);
    if($total_learned > 0) {
        for($i = 0; $i < 6; $i++) {
            $data[$i] = $fen_zi[$i]* 100.0  / $total_learned;// / $fen_mu[$i];
        }
    }
}

//echo(json_encode($data));

$sql = "SELECT date_format(d,'%m/%d') as md, c FROM (SELECT DATE( log_time ) AS d, COUNT( * ) AS c FROM grow_log WHERE user_uid = '$user_uid' GROUP BY d ORDER BY d DESC LIMIT 10) AS a ORDER BY d ASC";
$result = M()->select($sql);
$arr_date = array();
$arr_count = array();
$arr_date[] = "";// date("Y");
$arr_count[] = 0;
foreach($result as $row){
    $arr_date[] = $row['md'];
    $arr_count[] = $row['c'];   
}
$max = max($arr_count);
if($max > 20) {
    $scaleSteps = 20;
    $scaleStepWidth = ceil($max / $scaleSteps);
}
else {
    $scaleSteps = 20;
    $scaleStepWidth = 1;
}
//echo(json_encode($arr_date));
//echo(json_encode($arr_count));
?>
<script src="../scripts/chart/Chart.min.js"></script>
<!-- <section class="report01">
    <h3 class="title">成长分析图</h3>
    当日完成项目
    <canvas id="canvas01" height="330" width="500"></canvas>
    <div align="center">日期</div> -->
    <script>
        // var width01 = $('#canvas01').parent().width();
        // $('#canvas01').attr('width',width01);
     //    var lineChartData = {
     //        labels : <?php //echo(json_encode($arr_date)); ?>,
     //        datasets : [
     //            {
     //                fillColor : "rgba(151,187,205,0.5)",
     //                strokeColor : "rgba(151,187,205,1)",
     //                pointColor : "rgba(151,187,205,1)",
     //                pointStrokeColor : "#fff",
     //                data :  <?php //echo(json_encode($arr_count)); ?>
     //            }
     //        ]
     //    }
     //    var options = {
     //     scaleOverlay: true,
     //     scaleShowLabels : true,
     //     bezierCurve: true,
     //     scaleOverride: true,
     //     scaleSteps: <?php //echo($scaleSteps); ?>,
     //     scaleStepWidth: <?php //echo($scaleStepWidth); ?>,
     //     scaleStartValue: 0
     //    };
     //    var myLine = new Chart(document.getElementById("canvas01").getContext("2d")).Line(lineChartData,options);
    </script>
<!-- </section> -->
<section class="report02">
    <h3 class="title">六力分析图</h3>
    <canvas id="canvas02" height="330" width="380"></canvas>
    <script>
        var width01 = $('#canvas02').parent().width();
        $('#canvas02').attr('width',width01);
        var radarChartData = {
            labels : ['语言','社交','粗大动作','细微动作','认知','自我帮助'],
            datasets : [
                {
                    fillColor : "rgba(151,187,205,0.5)",
                    strokeColor : "rgba(151,187,205,1)",
                    pointColor : "rgba(151,187,205,1)",
                    pointStrokeColor : "#fff",
                    data : <?php echo(json_encode($data));?>
                }
            ]
        }
        var myRadar = new Chart(document.getElementById("canvas02").getContext("2d")).Radar(radarChartData,{scaleShowLabels : false, pointLabelFontSize : 10});
    </script>
    <ul class="description">
        <li>
            <p>语言<b class="weak"></b></p>
            <span>宝贝可能缺少语言的刺激或互动,建议多加互动引导</span>
            <!-- <p>语言<b class="normal"></b></p>
            <span>0-6岁是语言发展的黄金期。如果给予适当引导，诱发兴趣，可以见到明显的进步</span>
            <p>语言<b class="strong"></b></p>
            <span>宝贝可能缺少语言的刺激或互动，建议多加互动引导</span> -->
        </li>
        <li>
            <p>社交<b class="weak"></b></p>
            <span>宝贝正逐步展现这个年龄段应有的社会互动能力,多鼓励他(她)探索世界,未来在群体中的发展无可限量</span>
            <!-- <p>社交<b class="normal"></b></p>
            <span>宝贝正处于人格养成阶段,建议持续为他(她)创造新事物的接触机会,并适度从旁辅导</span>
            <p>社交<b class="strong"></b></p>
            <span>宝贝可能需要有很多与外界接触的机会，幼儿时期的人格发展特别重要，一定要细心留意</span> -->
        </li>
        <li>
            <p>粗大动作<b class="weak"></b></p>
            <span>健康的运动潜质已崭露头角,记得持续为宝贝进行评测观察,并适量给予运动机会</span>
            <!-- <p>粗大动作<b class="normal"></b></p>
            <span>家长应该关注宝贝的营养摄取, 并鼓励他(她)参与适当年龄的运动或户外活动</span>
            <p>粗大动作<b class="strong"></b></p>
            <span>宝贝是否被过度呵护或是缺乏训练?注意我们的专家建议,给予适当的辅导或咨询专业医师</span> -->
        </li>
        <li>
            <p>细微动作<b class="weak"></b></p>
            <span>宝贝对于细微动作的掌握令人满意,持续为宝贝进行评测观察,未来可进一步观察他(她)在艺术,运动等领域的发展潜质</span>
            <!-- <p>细微动作<b class="normal"></b></p>
            <span>宝贝对于细微动作的掌握还有进步空间,可以准备些辅助玩教具,诱导孩子在游戏中练习</span>
            <p>细微动作<b class="strong"></b></p>
            <span>幼儿时期的细微动作发展往往容易被忽略,建议多花时间与宝贝互动观察</span> -->
        </li>
        <li>
            <p>认知<b class="weak"></b></p>
            <span>宝贝已具备现阶段年龄应有的认知能力,家长可以适当增加认知学习的辅导,有助于孩子的智力发展</span>
            <!-- <p>认知<b class="normal"></b></p>
            <span>认知不仅影响学习能力,更关乎安全,建议家长应该善加利用生活周遭的事物,引导宝贝得到更多体验</span>
            <p>认知<b class="strong"></b></p>
            <span>宝贝可能需要更多探索世界的机会,参考评测中的专家建议,并适时给予辅导</span> -->
        </li>
        <li>
            <p>自我帮助<b class="weak"></b></p>
            <span>宝贝的自我帮助能力符合标准,说明家长引导得当,可以搭配分年龄段的家庭早教包,更轻松让孩子养成多元的能力</span>
            <!-- <p>自我帮助<b class="normal"></b></p>
            <span>自我帮助是不断重复练习的生活能力,家长可以使用家庭早教包或参照测评中的专家建议,温柔地坚持让宝贝完成任务</span>
            <p>自我帮助<b class="strong"></b></p>
            <span>自主能力的养成是发展更多能力的基础,依不同年龄段给予正确的引导,同时家长的耐心也很重要</span> -->
        </li>
    </ul>
    <h3 class="title">完成项目</h3>
    <ul class="complete_item">
        <li>
            <p>2016年6月20</p>
            <ul class="item_list">
                <li><p>能说出现实中或图片中物品的名称</p></li>
                <li><p>能模仿听到的声音或语言</p></li>
            </ul>
        </li>
        <li>
            <p>2016年5月20</p>
            <ul class="item_list">
                <li><p>能说出现实中或图片中物品的名称</p></li>
                <li><p>能模仿听到的声音或语言</p></li>
                <li><p>能说出现实中或图片中物品的名称</p></li>
            </ul>
        </li>
    </ul>
</section>

<script>
$(window).resize(function() {
    var width01 = $('#canvas01').parent().width();
    $('#canvas01').attr('width', width01);
    var myLine = new Chart(document.getElementById("canvas01").getContext("2d")).Line(lineChartData);
    var width02 = $('#canvas02').parent().width();
    $('#canvas02').attr('width', width02);
    var myRadar = new Chart(document.getElementById("canvas02").getContext("2d")).Radar(radarChartData,{scaleShowLabels : false, pointLabelFontSize : 10});
});
</script>
