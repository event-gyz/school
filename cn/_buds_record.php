<?php
header('Content-Type:text/plain;charset=utf-8');
session_start();

include("inc.php");
if(isset($_GET['type']) && $_GET['type'] == 'save'){

    $buds_type = $_GET['buds_type'];
    $date = $_GET['date'];
    $_token = $_SESSION['user_token'];
    if ($supervisor_uid = $CMEMBER->accessFromToken($_token)) {
        $sql = "select * from wap_buds where buds_type='{$buds_type}' and uid=$supervisor_uid";
        $re = M()->find($sql);
        if($re){
            $sql = "update wap_buds set `date`='{$date}' where buds_type='{$buds_type}' and uid=$supervisor_uid";
        }else{
            $sql = "INSERT INTO wap_buds (`buds_type`,`date`,uid) VALUES ('{$buds_type}','{$date}',$supervisor_uid)";
        }
        $res = M()->execute($sql);

        echo json_encode(['errno'=>1,'msg'=>'保存成功']);

    }
    exit;
}

if(isset($_POST['type']) && $_POST['type'] == 'update'){
    $id = $_POST['id'];
    $weight = $_POST['weight'];
    $height = $_POST['height'];
    $files = $_POST['file'];
    $date = $_POST['date'];
    $_token = $_SESSION['user_token'];

    if ($supervisor_uid = $CMEMBER->accessFromToken($_token)) {

        if(isset($_FILES['new_file']) && !empty($_FILES['new_file'])){
            $picurl = ceanza_upload("new_file");
        }else{
            $picurl = '"'.$files.'"';
        }
        $sql = "update wap_height set weight='{$weight}',height='{$height}',picurl='{$picurl}',`date`='{$date}' where id=$id";
        $result = query($sql);
        if($result!=null) {
            header("Location:height_record_list.php");
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
    $sql = "select * from grow_diary {$where} group by date";
    $result = query_result_list($sql);
    if($result){
        var_dump($result);
    }
    echo "无数据";
}

if(isset($_GET['type']) && $_GET['type'] == "delete"){
    $sql = "delete from wap_height where id=".$_GET['id'];
    if(query_delete($sql)){
        $url = base64_decode($_GET['back']);
        header("Location:height_record_list.php");
    }
}

?>
