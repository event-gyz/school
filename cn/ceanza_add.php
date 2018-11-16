<?php
session_start();
include('inc.php');
?>
<!DOCTYPE html>
<html><!-- InstanceBegin template="/Templates/_page01.dwt" codeOutsideHTMLIsLocked="false" -->
<head>
    <?php include('inc_head.php');  ?>
    <?php if(strpos($_SERVER['SERVER_NAME'],'.com.cn')===false){
        ?>
        <!-- 测试环境 -->
        <script type="text/javascript" src="http://api.map.baidu.com/getscript?v=2.0&ak=MDD4sezyIh6fuPuiG9cY1CGHFqUbs5GS&s=1"></script>
        <script type="text/javascript" src="../scripts/convertor.js"></script>
        <?php
    }else{
        ?>
        <!-- 生产环境 -->
        <!-- <script type="text/javascript" src="https://api.map.baidu.com/api?v=2.0&ak=MDD4sezyIh6fuPuiG9cY1CGHFqUbs5GS&s=1"></script>
        <script type="text/javascript" src="../scripts/convertor.js"></script> -->
        <?php
    }
    ?>
    <style>
        body{background: #fff;}
        h1,h2,h3,h4,h5,h6,p,ul,li,dl,dt,dd{margin:0;padding:0;list-style: none;}
        input,button{padding: 0;margin:0;border:0;outline: none;}
        img{vertical-align: bottom}
    </style>
</head>

<body>

<!-- InstanceBeginEditable name="wrap" -->
<section id="wrap">
    <!-- 百度地图 -->
    <!-- <div id="allmap" style="display: none"></div> -->
    <!-- InstanceEndEditable -->

    <!--【Header】-->
    <?php include 'inc_header.php'; ?>
    <!--【Header End】-->

    <!--【Content】-->
    <section id="content">
        <!-- InstanceBeginEditable name="content" -->
        <!--//主內容//-->
        <section class="indexcont">
            <section class="inbox noBoxShadowPage">
                <section class="contbox clearfix">
                    <section class="ceanza">
                        <form action="grow_diary.php" method="post" enctype="multipart/form-data">
                            <input hidden="" name="type" value="diary" />
                            <h4>新增宝贝日记</h4>
                            <section class="gopath"><a href="index.php">首页</a> > 新增宝贝日记</section>
                            <ul class="form">
                                <li class="title-menu">
                                    <p>标题：</p>
                                    <input name="title" class="title" type="text" maxlength="20">
                                    <div class="headtitle-list">
                                        <ul>
                                            <li class="checked">一般日记</li>
                                            <li>宝宝出生喽</li>
                                            <li>第一次打预防针</li>
                                            <li>三朝礼</li>
                                            <li>满月</li>
                                            <li>第一次量身高</li>
                                            <li>剃胎发</li>
                                            <li>宝宝的第一个玩具</li>
                                            <li>百日礼</li>
                                            <li>收涎</li>
                                            <li>戴长命锁</li>
                                            <li>第一次吃副食品</li>
                                            <li>第一次撑起上半身</li>
                                            <li>第一次坐着</li>
                                            <li>第一次向前爬行</li>
                                            <li>第一次扶着物品站立</li>
                                            <li>第一次扶着物品向前走动</li>
                                            <li>满周岁（抓周）</li>
                                            <li>第一次用杯子喝水</li>
                                            <li>第一次不依靠搀扶会自己行走</li>
                                            <li>把球举高往前丢</li>
                                            <li>第一次自己脱裤子</li>
                                            <li>学会自己拉拉链</li>
                                            <li>学会往后跳</li>
                                            <li>第一次过新年</li>
                                            <li>第一次切蛋糕</li>
                                            <li>学会自己洗手</li>
                                            <li>第一次和新朋友一起玩</li>
                                            <li>第一次自己吃饭</li>
                                            <li>宝宝最喜欢的玩具</li>
                                            <li>宝宝第一次盖的城堡</li>
                                            <li>宝宝骑三轮车</li>
                                            <li>第一次自己看书</li>
                                            <li>幼稚园开学</li>
                                            <li>第一次写作业</li>
                                            <li>第一次亲子活动</li>
                                            <li>第一次过圣诞节</li>
                                            <li>第一次上台表演</li>
                                            <li>第一次自己穿衣服</li>
                                            <li>宝宝第一次画全家福</li>
                                            <li>学会单脚站立</li>
                                            <li>才艺课初体验</li>
                                            <li>第一次运动会</li>
                                            <li>学会自己刷牙</li>
                                            <li>学会自己扣扣子</li>
                                            <li>学会自己上厕所</li>
                                            <li>完成八片以上的拼图</li>
                                            <li>能够以单脚往前跳</li>
                                            <li>幼稚园毕业典礼</li>
                                        </ul>
                                        <p class="close">×</p>
                                    </div>
                                    <div class="isShare">
                                        <input type="checkbox" id="checkshare" name="checkshare">
                                        <label for="checkshare">公开</label>
                                    </div>
                                </li>
                                <li class="title-menu">
                                    <p>日记分类：</p>
                                    <a href="javascript: void(0)">请选择</a>
                                    <input type="hidden" name="grow_diary_category_name">
                                    <div class="title-list">
                                        <ul>
                                            <li class="checked">0月-3月</li>
                                            <li>3月-1岁</li>
                                            <li>1岁-2岁</li>
                                            <li>2岁-3岁</li>
                                            <li>3岁-4岁</li>
                                            <li>4岁-5岁</li>
                                            <li>5岁-6岁</li>
                                        </ul>
                                        <p class="close">×</p>
                                    </div>
                                </li>
                                <li class="ceanza-detail"><p>内容：</p><textarea name="content" cols="60" rows="4" maxlength="800"></textarea></li>
                                <li>
                                    <b class="clock"></b>
                                    记录时间：
                                    <input class="time datepicker"  name="date" readonly value="<?php echo date('Y-m-d',time())?>">
                                </li>
                                <li class="geographical_location">
                                    <b class="address"></b>
                                    记录地址：
                                    <input type="text" id="suggestId" name="address"  class="address-input"/>
                                    <!-- <div class="relative_position">
                                        <p>手动输入</p>
                                        <ul class="position_list"></ul>
                                    </div> -->
                                </li>
                            </ul>
                            <ul class="uploadImgList">
                                <li class="uploadImg">
                                    <div class="imgContent">+</div>
                                    <input type="file" name="file" accept="image/gif,image/jpeg,image/png,image/bmp,image/jpg"/>
                                    <!-- <div class="camera_photograph">
                                         <p><img src="../content/epaper/images/camera.png" alt=""></p>
                                         <input type="file" class="camera_input" name="myPhoto" capture="camera" accept="image/*"/>
                                     </div> -->
                                </li>
                            </ul>
                            <!-- <p class="uploadImgPrompt">(上传图片档案大小不得超过3MB)</p> -->
                            <button class="submit ceanza_add_submit">提交</button>
                        </form>
                    </section>
                    <!--//主選單標題與路徑//-->
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
<?php include 'inc_bottom_js.php'; ?>
<script>

    const map = new BMap.Map("allmap");

    var geolocation = new BMap.Geolocation();

    // geolocation.getCurrentPosition( r => {
    //     $('#suggestId').focus(function(){
    //     if(geolocation.getStatus() == BMAP_STATUS_SUCCESS){
    //         var new_point = new BMap.Point(r.point.lng,r.point.lat);
    //         BMap.Convertor.translate(new_point, 0, point => {
    //             var geoc = new BMap.Geocoder();
    //         geoc.getLocation(point, rs => {
    //             console.log(rs)
    //             var positionList = rs.surroundingPois,
    //             html = `<li class="first_position"><p>${rs.addressComponents.city}</p></li>`;
    //         for(var i = 0; i < positionList.length; i++){
    //             html += `<li><p>${positionList[i].title}</p><span>${positionList[i].address}</span></li>`
    //         }
    //         $('.position_list').html(html)
    //     });
    //     });
    //     }else {
    //         alert('failed'+geolocation.getStatus());
    //     }
    //     $(this).siblings('.relative_position').show()
    // })
    // },{enableHighAccuracy: true})

    // $('#suggestId').blur(function(){
    //     setTimeout(()=>{$(this).siblings('.relative_position').hide()},100)
    // })

    // $('.relative_position p').click(function(event){
    //     var e = event || window.event
    //     event.stopPropagation()
    //     $('#suggestId').val('')
    //     $('#suggestId').focus()
    //     $(this).parent().hide()
    // })

    // $('.position_list').on('click','li:not(li.first_position)',function(){
    //     var address = $('.position_list li:first-child p').html() + $(this).children('p').html()
    //     $('#suggestId').val(address)
    // })

    // $('.position_list').on('click','li.first_position',function(){
    //     var address = $(this).children('p').html()
    //     $('#suggestId').val(address)
    // })
</script>
</body>
<!-- InstanceEnd --></html>
