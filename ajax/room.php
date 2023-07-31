<?php
require_once __DIR__ . '../../helpers/include.php';

if (isset($_POST['assign_room']) && $_POST['assign_room'] == 1) {
    if (isset($_POST['room_id']) && isset($_POST['user_id'])) {
        $data = ['room_id' => $_POST['room_id']];
        $pre_room = single_data($db, 'rooms', ' id = ' . $_POST['pre_id']);
        if($pre_room){
            update($db, 'rooms', ['current' =>  $pre_room['current'] - 1], ' id = ' . $_POST['pre_id'] . ' AND current > 0');
        }
        $current_room = single_data($db, 'rooms', ' id = ' . $_POST['room_id']);
        if($current_room){
            update($db, 'rooms', ['current' => $current_room['current'] + 1], ' id = ' . $_POST['room_id'] . ' AND capacity > current');
        }
        $res = update($db, 'users', $data, ' id = ' . $_POST['user_id']);
        if ($res) {
            echo 1;
            return;
            die;
        } else {
            echo 0;
            return;
            die;
        }
    }
}

if (isset($_POST['room_imgs']) && $_POST['room_imgs'] == 1) {
    $room_imgs = all_data($db, 'room_images', ' room_id = ' . $_POST['room_id']);
    echo json_encode($room_imgs);
    return;
    die;
}

if (isset($_POST['img_delete']) && $_POST['img_delete'] == 1) {
    unlink(__DIR__ . '/../uploads/' . $_POST['image']);
    echo del_data($db, 'room_images', $_POST['id']);
    return;
    die;
}
