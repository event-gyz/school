<?php
session_start();
include('inc.php');

$name = "尚未输入";
$email = "尚未输入";
$phone = "尚未输入";

$nick_name = "尚未输入";
$birth_day = "尚未输入";
$gender = "尚未输入";

if(isset($_SESSION['user_token'])) {
    $member_uid = $CMEMBER->accessFromToken($_SESSION['user_token']);
}
if($member_uid > 0) {
    $sql = "select first_name,email,cellphone from member where uid='$member_uid'";
    $result = M()->find($sql);
    if($result!=null) {
        $name = $result['first_name'];
        $email = $result['email'];
        $phone = $result['cellphone'];
    }
    unset($result);
    unset($sql);
    $sql = "select nick_name,birth_day,gender from user where supervisor_uid='$member_uid'";
    $result = M()->find($sql);
    if($result!=null) {
        $nick_name = $result['nick_name'];
        $birth_day = $result['birth_day'];
        $gender = ($result['gender']==0?"男":"女");
    }
}
?>
<h3 class="title">以下为您的基本资料</h3>
<section class="board board01">
    <section class="inboard">
        <ul class="clearfix">
            <li><b>帐号</b><i><?php echo($email); ?></i></li>
            <li><b>密码</b><i>********</i></li>
            <li><b>电话</b><i><?php echo($phone); ?></i></li>
        </ul>
        <section class="btnbox clearfix">
            <a href="#fy-modify" class="btn01 fancybox"><i><img src="../theme/cn/images/content/icon_btn10.png"></i><span>编辑</span></a>
        </section>
    </section>
</section>
<h3 class="title">以下为您宝贝的基本资料</h3>
<p>若修改寶貝生日，成長指標將清空重新記錄。</p>
<section class="board board01 board-baby">
    <section class="inboard">
        <ul class="clearfix">
            <li><b>昵称</b><i><?php echo($nick_name); ?></i></li>
            <li><b>生日</b><i class="birthDay"><?php echo($birth_day); ?></i></li>
            <li><b>性別</b><i><?php echo($gender); ?></i></li>
        </ul>
        <section class="btnbox clearfix">
            <a href="javascript:void(0);" class="btn01"><i><img src="../theme/cn/images/content/icon_btn10.png"></i><span>编辑</span></a>
        </section>
    </section>
</section>
<script>
    $('.board-baby .btn01').click(function(){
        showEditBabyBox()
        var birthday = $('.birthDay').html()
        // var years = parseInt(birthday.split('-')[0])
        // var months = parseInt(birthday.split('-')[1])
        // var days = parseInt(birthday.split('-')[2])
        // $('#birth_box_years').val(years)
        // $('#birth_box_months').val(months)
        // $('#birth_box_days').val(days)
        $('#fst_birthdate').val(birthday)
    })
</script>
<?php
echo('<script type="text/javascript">$(function() { 	$("#fst_nickname").val("'.$nick_name.'");})</script>');
?>
