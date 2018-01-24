<?php
header('Content-Type:text/plain;charset=utf-8');
session_start();

include("inc.php"); 

if(isset($_POST['type']) && $_POST['type'] == 'add'){
    $hospital = $_POST['hospital'];
    $doctor_name = $_POST['doctor_name'];
    $address = $_POST['address'];
    $doctor_phone = $_POST['doctor_phone'];
    $_token = $_SESSION['user_token'];
    $member_uid = $CMEMBER->accessFromToken($_token);

    $sql = "INSERT INTO wap_medical (hospital,doctor_name,address, doctor_phone,uid)  value('{$hospital}','{$doctor_name}','{$address}','{$doctor_phone}','{$member_uid}')";
    $result = query($sql);
    if($result!=null) {
        header("Location:medical_record.php");
//                die(genResponse(true, "添加成功"));
    }
    die(genResponse(false,$_v_ERROR_REGISTER_FAILED."，添加失败"));

}

if(isset($_POST['type']) && $_POST['type'] == 'update'){
    $id = $_POST['id'];
    $hospital = $_POST['hospital'];
    $doctor_name = $_POST['doctor_name'];
    $address = $_POST['address'];
    $doctor_phone = $_POST['doctor_phone'];
    $_token = $_SESSION['user_token'];

    if ($supervisor_uid = $CMEMBER->accessFromToken($_token)) {

        if(isset($_FILES['new_file']) && !empty($_FILES['new_file'])){
            $picurl = ceanza_upload("new_file");
        }else{
            $picurl = '"'.$files.'"';
        }
        $sql = "update wap_medical set hospital='{$hospital}',doctor_name='{$doctor_name}',doctor_phone='{$doctor_phone}',address='{$address}' where id=$id";
        $result = query($sql);
        if($result!=null) {
            header("Location:medical_record.php");
            die(genResponse(true, "添加成功"));
        }
        // die(genResponse(false,$_v_ERROR_REGISTER_FAILED."，添加失败"));
    }

    exit;
}

if(isset($_GET['type']) && $_GET['type'] == "get"){
    $category = 0;
    if(isset($_GET['category'])){
        $category = intval($_GET['category']);
    }
    $where = "where id > 0";
    if($category){
        $where .= " and grow_diary_category_id=".$category;
    }
    $sql = "select * from wap_medical {$where} group by date";
    $result = query_result_list($sql);
    if($result){
        var_dump($result);
    }
    echo "无数据";
}

if(isset($_GET['type']) && $_GET['type'] == "delete"){
    $sql = "delete from wap_medical where id=".$_GET['id'];
    if(query_delete($sql)){
        $url = base64_decode($_GET['back']);
        header("Location:medical_record.php");
    }
}

/**********************
 *	medical_record.php
 *********************/
function af_medical_institution_list() {
    global $_show_image;
    $item_count = $_show_image?4:8;
    $sql = "SELECT * from articles WHERE type='REC' ORDER BY uid desc,pub_date limit $item_count";
    $result = query($sql);
    $count = 0;
    echo('<ul>');
    while ($row = mysqli_fetch_array($result)) {
        $uid = $row['uid'];
        $title = $row['title'];
        $desc = $row['description'];
        $icon = $row['image'];
        $pub_date = str_replace('-','.',$row['pub_date']);
        if(empty($icon))
            $icon = 'ig04_70-70.jpg';
        if($count == 3) {
            if($_show_image) {
                echo('<li class="m-none"><a href="javascript:loadArticle('.$uid.')" class="fancybox">');
                echo('<img src="../theme/cn/images/content/img/'.$icon.'">');
                echo('<span><b>'.$title.'</b>'.$desc.'</span></a></li>');
            }
            else {
                echo('<li class="m-none"><a href="javascript:loadArticle('.$uid.')" class="fancybox"><b>'.$title.'</b><p>'.$desc.'</p><i>'.$pub_date.'</i></a></li>');
            }
        }
        else {
            if($_show_image) {
                echo('<li><a href="javascript:loadArticle('.$uid.')" class="fancybox">');
                echo('<img src="../theme/cn/images/content/img/'.$icon.'">');
                echo('<span><b>'.$title.'</b>'.$desc.'</span></a></li>');
            }
            else {
                echo('<li><a href="javascript:loadArticle('.$uid.')" class="fancybox"><b>'.$title.'</b><p>'.$desc.'</p><i>'.$pub_date.'</i></a></li>');
            }
        }
        $count++;
    }
    echo('</ul>');
}

?>
