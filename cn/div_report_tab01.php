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
<section class="report01">
    <h3 class="title">成长分析图</h3>
    当日完成项目
    <canvas id="canvas01" height="330" width="500"></canvas>
    <div align="center">日期</div>
    <script>
	    var width01 = $('#canvas01').parent().width();
	    $('#canvas01').attr('width',width01);
        var lineChartData = {
            labels : <?php echo(json_encode($arr_date)); ?>,
            datasets : [
                {
                    fillColor : "rgba(151,187,205,0.5)",
                    strokeColor : "rgba(151,187,205,1)",
                    pointColor : "rgba(151,187,205,1)",
                    pointStrokeColor : "#fff",
                    data :  <?php echo(json_encode($arr_count)); ?>
                }
            ]
        }
        var options = {
        	scaleOverlay: true,
        	scaleShowLabels : true,
        	bezierCurve: true,
        	scaleOverride: true,
        	scaleSteps: <?php echo($scaleSteps); ?>,
        	scaleStepWidth: <?php echo($scaleStepWidth); ?>,
        	scaleStartValue: 0
        };
        var myLine = new Chart(document.getElementById("canvas01").getContext("2d")).Line(lineChartData,options);
    </script>
</section>
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
