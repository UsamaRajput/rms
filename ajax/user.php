<?php
require_once __DIR__ . '../../helpers/include.php';

if (isset($_POST['user_data']) && $_POST['user_data'] == 1) {
    $room_imgs = single_data($db,'users',' id = ' . $_POST['user_id']);
    echo json_encode($room_imgs);
    return;die;
}
