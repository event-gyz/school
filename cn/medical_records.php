<?php
header('Content-Type:text/plain;charset=utf-8');
session_start();

include("inc.php"); 

if(isset($_POST['type']) && $_POST['type'] == 'diary'){
//    print_r($_POST);exit;
    $date = $_POST['date'];
    $hospital = $_POST['hospital'];
    $doctor = $_POST['doctor'];
    $symptom = $_POST['symptom'];
    $note = $_POST['note'];
    $_token = $_SESSION['user_token'];
    $member_uid = $CMEMBER->accessFromToken($_token);

    $sql = "INSERT INTO wap_diagnoses (`date`,doctor,hospital, symptom,note,uid)  value('{$date}','{$doctor}','{$hospital}','{$symptom}','{$note}','{$member_uid}')";
    $result = query($sql);
    if($result!=null) {
        header("Location:medical_record.php");
//                die(genResponse(true, "添加成功"));
    }
    die(genResponse(false,$_v_ERROR_REGISTER_FAILED."，添加失败"));

}

if(isset($_POST['type']) && $_POST['type'] == 'update'){
    $id = $_POST['id'];
    $date = $_POST['date'];
    $hospital = $_POST['hospital'];
    $doctor = $_POST['doctor'];
    $symptom = $_POST['symptom'];
    $note = $_POST['note'];
    $_token = $_SESSION['user_token'];

    if ($supervisor_uid = $CMEMBER->accessFromToken($_token)) {

        $sql = "update wap_diagnoses set note='{$note}',symptom='{$symptom}',doctor='{$doctor}',hospital='{$hospital}',date='{$date}' where id=$id";
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
    $sql = "select * from wap_diagnoses {$where} group by date";
    $result = query_result_list($sql);
    if($result){
        var_dump($result);
    }
    echo "无数据";
}

if(isset($_GET['type']) && $_GET['type'] == "delete"){
    $sql = "delete from wap_diagnoses where id=".$_GET['id'];
    if(query_delete($sql)){
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
