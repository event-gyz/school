<?php
session_start();
include('inc.php');
?>
<!DOCTYPE html>
<html><!-- InstanceBegin template="/Templates/_page01.dwt" codeOutsideHTMLIsLocked="false" -->
<head>
    <?php include('inc_head.php');  ?>
    <style>
        body{background: none;}
        h1,h2,h3,h4,h5,h6,p,ul,li,dl,dt,dd{margin:0;padding:0;list-style: none;}
        input,button{padding: 0;margin:0;border:0;outline: none;}
        img{vertical-align: bottom}
    </style>
</head>

<body>
<!-- InstanceBeginEditable name="wrap" -->
<section id="wrap">
    <!--//主內容//-->
    <section class="indexcont">
        <section class="inbox noBoxShadowPage">
            <section class="clearfix">
                <!--//主選單標題與路徑//-->
                <div class="share_tips">
                    <p><img src="../content/epaper/images/sharing_tips.jpg" alt=""></p>
                </div>
            </section>
        </section>
    </section>
    <!--//主內容//-->

    <!--【Footer】-->
    <?php include 'inc_footer.html'; ?>
    <!--【Footer End】-->
</section>
<?php include 'inc_bottom_js.php'; ?>
<script src="https://res.wx.qq.com/open/js/jweixin-1.0.0.js"></script>
<?php
require("JSSDK.php");
$jssdk = new JSSDK();
//返回签名基本信息
$signPackage = $jssdk->getSignPackage();
?>
<script>

    wx.config({
        appId: '<?= $signPackage["appId"];?>',
        timestamp: <?= $signPackage["timestamp"];?>,
        nonceStr: '<?= $signPackage["nonceStr"];?>',
        signature: '<?= $signPackage["signature"];?>',
        jsApiList: [
            "onMenuShareTimeline",
            "onMenuShareAppMessage",
            "onMenuShareQQ",
            "onMenuShareWeibo",
            "onMenuShareQZone",
        ]
    });
    <?php
    if(isset($_SESSION['user_token'])) {
        $member_uid = $CMEMBER->accessFromToken($_SESSION['user_token']);
        echo "var url = 'https://".$_SERVER['HTTP_HOST']."/cn/share.php?uid=".$member_uid."';";
    }else{
        echo "var url = 'https://".$_SERVER['HTTP_HOST']."/cn/share.php';";
    }
    ?>

    var imgUrl = 'http://colavia.com.cn/cn/images/bobdog.png';
    wx.ready(function () {
        // 在这里调用 API
        wx.checkJsApi({
            jsApiList: ["onMenuShareTimeline",
                "onMenuShareAppMessage",
                "onMenuShareQQ",
                "onMenuShareWeibo",
                "onMenuShareQZone",], // 需要检测的JS接口列表，所有JS接口列表见附录2,
            success: function(res) {
//                alert(JSON.stringify(res));
                if(res.errMsg !='checkJsApi:ok'){
                    alert('请升级您的微信版本');
                    return;
                }
            }
        });
        //分享Demo
        //获取“分享到朋友圈”按钮点击状态及自定义分享内容接口
        wx.onMenuShareTimeline({
            title: '宝贝成长日记', // 分享标题
            link: url, // 分享链接
            imgUrl: imgUrl, // 分享图标
            success: function () {
                // 用户确认分享后执行的回调函数
            },
            cancel: function () {
                // 用户取消分享后执行的回调函数
            }
        });
        //获取“分享给朋友”按钮点击状态及自定义分享内容接口
        wx.onMenuShareAppMessage({
            title: '宝贝成长日记' , // 分享标题
            desc: '加入成长日记，一起轻松养娃', // 分享描述
            link: url, // 分享链接
            imgUrl: imgUrl, // 分享图标
            type: '', // 分享类型,music、video或link，不填默认为link
            dataUrl: '', // 如果type是music或video，则要提供数据链接，默认为空
            success: function () {
                // 用户确认分享后执行的回调函数
            },
            cancel: function () {
                // 用户取消分享后执行的回调函数
            }
        });
        //获取“分享到QQ”按钮点击状态及自定义分享内容接口
        wx.onMenuShareQQ({
            title: '宝贝成长日记', // 分享标题
            desc: '加入成长日记，一起轻松养娃', // 分享描述
            link: url, // 分享链接
            imgUrl: imgUrl, // 分享图标
            success: function () {
                // 用户确认分享后执行的回调函数
            },
            cancel: function () {
                // 用户取消分享后执行的回调函数
            }
        });
        //获取“分享到腾讯微博”按钮点击状态及自定义分享内容接口
        wx.onMenuShareWeibo({
            title: '宝贝成长日记', // 分享标题
            desc: '加入成长日记，一起轻松养娃', // 分享描述
            link: url, // 分享链接
            imgUrl: imgUrl, // 分享图标
            success: function () {
                // 用户确认分享后执行的回调函数
            },
            cancel: function () {
                // 用户取消分享后执行的回调函数
            }
        });
        //获取“分享到QQ空间”按钮点击状态及自定义分享内容接口
        wx.onMenuShareQZone({
            title: '宝贝成长日记', // 分享标题
            desc: '加入成长日记，一起轻松养娃', // 分享描述
            link: url, // 分享链接
            imgUrl: imgUrl, // 分享图标
            success: function () {
                // 用户确认分享后执行的回调函数
            },
            cancel: function () {
                // 用户取消分享后执行的回调函数
            }
        });
    });
</script>
</body>
<!-- InstanceEnd --></html>
