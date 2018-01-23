<?php  
session_start();
header("Content-type: image/PNG");
$lang = 0; // 1: cn

$w=100;
$h=40;
$fontface="./fzzy.ttf"; //字体文件
if($lang == 0) {
	$word_count = 4;
	$str = "ABCDEFGHIJKLMNOPQRSTUVWXYZ";//abcdefghijklmnopqrstuvwxyz";	
}
else {
	$word_count = 2;
	$str="在这春光明媚的日子同大家在美丽的巴黎欢聚一堂纪念中法建交周年感到十分高兴首先我谨代表中国政府和人民并以我个人的名义向在座各位并通过各位向长期致力于中法友好事业的各界人士向友好的法国人民致以诚挚的问候和良好的祝愿中法关系正处在承前启后的重要时刻我来到法国带来的是中国政府和人民对中法两国人民友谊的美好回忆和深化中法全面战略伙伴关系的真诚愿望吃水不忘挖井人此时此刻我们都会想起两位伟人年前在东西方冷战正酣的大背景下毛泽东主席和戴高乐将军以超凡的战略眼光毅然作出中法全面建交的历史性决策在中法之间同时也在中国同西方世界之间打开了相互认知和交往的大门从此中法关系成为世界大国关系中的一对特殊关系始终走在中国同西方主要发达国家关系前列";  	
}
$str_arr = array();
$code = "";
for($i=0;$i<$word_count;$i++){
	if($lang==0) {
        $Xi=mt_rand(0,strlen($str)-1);
        $arr[] = substr($str,$Xi,1);
	}
	else {
        $Xi=mt_rand(0,mb_strlen($str,"UTF8")-1);
        $arr[] = mb_substr($str,$Xi,1,"UTF8");		
	}
    $code.= $arr[$i];
}
$_SESSION['auth_code']=$code;
$im=imagecreatetruecolor($w,$h);
$bkcolor=imagecolorallocate($im,250,250,250);
imagefill($im,0,0,$bkcolor);
/***添加干扰***/
for($i=0;$i<15;$i++){
        $fontcolor=imagecolorallocate($im,mt_rand(0,255),mt_rand(0,255),mt_rand(0,255));
        imagearc($im,mt_rand(-10,$w),mt_rand(-10,$h),mt_rand(30,300),mt_rand(20,200),55,44,$fontcolor);
}
for($i=0;$i<255;$i++){
        $fontcolor=imagecolorallocate($im,mt_rand(0,255),mt_rand(0,255),mt_rand(0,255));
        imagesetpixel($im,mt_rand(0,$w),mt_rand(0,$h),$fontcolor);
}
/***********内容*********/
for($i=0;$i<$word_count;$i++){
        $fontcolor=imagecolorallocate($im,mt_rand(0,120),mt_rand(0,120),mt_rand(0,120)); //这样保证随机出来的颜色较深。
        if($lang==0) {
	        imagettftext($im,mt_rand(18,22),mt_rand(-30,30),22*$i+15,mt_rand(24,32),$fontcolor,$fontface,$arr[$i]);
        }
	    else {
		    imagettftext($im,mt_rand(18,22),mt_rand(-60,60),40*$i+20,mt_rand(20,30),$fontcolor,$fontface,$arr[$i]);
	    }
}
imagepng($im);
ImageDestroy($im);  
?>
