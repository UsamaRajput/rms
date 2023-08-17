<?php
require_once __DIR__ . '../../helpers/include.php';

if(isset($_POST['is_active'])){
    $res = update($db,'staff',['is_active'=>$_POST['is_active']],'id = '. $_POST['id']);
    if($res){
        echo 1;
        return ;die;
    }else{
        echo 0;
        return ;die;
    }
}

if(isset($_POST['del_staff'])){
    $res = del_data($db,'staff',$_POST['id']);
    if($res){
        delete_file(__DIR__.'/../uploads/'.$_POST['old']);
        echo 1;
        die;
    }else{
        echo 0;
        die;
    }
}

if(isset($_POST['add_staff']) && $_POST['add_staff']){
    $arr = $_POST;
    if(isset($_FILES['image']['name']) && !empty($_FILES['image']['name']))
    {
        $arr['image'] = file_upload('images/staff',$_FILES['image']);
    }
    unset($arr['add_staff']);
    $res = insert($db,'staff',$arr);

    if($res){
        $last_id = mysqli_insert_id($db);
        $data = single_data($db,'staff','id = '.$last_id);
        if($data){
            echo json_encode($data);
            die;
        }
        echo 1;
        die;
    }
    echo 0;
    die;
}