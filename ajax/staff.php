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