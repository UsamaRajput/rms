<?php
require_once __DIR__ . '../../helpers/include.php';


if (isset($_POST['fetch_news']) && $_POST['fetch_news'] == 1) {
    $res = single_data($db, 'news', ' id = ' . $_POST['news_id'] ?? 0);
    echo json_encode($res);
    return '';
    die;
}


if (isset($_POST['action_news']) && $_POST['action_news'] == 1) {
    $check = all_data($db, 'news', " type = '" . $_POST['type'] . "'", true);
    if ($_POST['type'] == 1 && $check > 0) {
        $res = 2;
    } else {
        $res = update($db, 'news', ['type' => $_POST['type']], ' id = ' . $_POST['news_id']);
    }
    echo json_encode($res);
    return '';
    die;
}
