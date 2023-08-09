<?php
require_once __DIR__ . '../../helpers/include.php';

if (isset($_POST['user_data']) && $_POST['user_data'] == 1) {
    $room_imgs = single_data($db, 'users', ' id = ' . $_POST['user_id']);
    echo json_encode($room_imgs);
    return;
    die;
}


if (isset($_POST['approve']) && $_POST['approve'] == 1) {
    $room_check = single_data($db, 'rooms', ' id = ' . $_POST['req_id']);
    if ($room_check['capacity'] > $room_check['current']) {
        $res = update($db, 'users', ['room_id' => $_POST['req_id'],'requested_room' => 0], ' id = ' . $_POST['user_id']);
        if ($res) {
            $room = single_data($db, 'rooms', ' id = ' . $_POST['req_id']);
            echo json_encode($room);
            return;
            die;
        }
        echo 0;
        die;
    }
    echo  2;
    die;
}


if (isset($_POST['all_rejected']) && $_POST['all_rejected'] == 1) {
    $res = update($db, 'users', ['requested_room' => 0], ' requested_room = ' . $_POST['req_id']);
    if ($res) {
        echo 1;
        die;
    }
    echo 0;
    die;
}
if (isset($_POST['rejected']) && $_POST['rejected'] == 1) {
    $res = update($db, 'users', ['requested_room' => 0], ' id = ' . $_POST['user_id']);
    if ($res) {
        echo 1;
        die;
    }
    echo 0;
    die;
}
