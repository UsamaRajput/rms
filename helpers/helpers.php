<?php

/**
 * TESTING FUNCTIONS
 */

function pr($data, $exit = null)
{
    echo '<pre>';
    print_r($data);
    echo '</pre>';
    if ($exit != null) {
        die;
    }
}

/**
 * Custom Functions PHP
 */
function site_url($url = null)
{
    if ($url != null) {
        return SITE_URL . $url;
    }
    return SITE_URL;
}
function assets($url = null, $cond)
{
    if ($cond == 2)
        $folder = 'images/';
    elseif ($cond == 1)
        $folder = 'css/';
    elseif ($cond == 3)
        $folder = 'js/';
    else
        $folder = '';

    if ($url != null) {
        return SITE_URL . 'assets/' . $folder . $url . '?refresh=' . time();
    }
    return SITE_URL;
}
function uploads($name = null)
{

    if ($name != null) {
        return SITE_URL . 'uploads/' . $name;
    }
    return "";
    // return SITE_URL;
}

function  login_redirect()
{
    if (isset($_SESSION['user_id']) && isset($_SESSION['name']) && isset($_SESSION['email']) && isset($_SESSION['is_admin']) && $_SESSION['is_admin'] != 1) {
        js_redirect('index.php');
    }

    if (isset($_SESSION['user_id']) && isset($_SESSION['name']) && isset($_SESSION['email']) && isset($_SESSION['is_admin']) && $_SESSION['is_admin'] == 1) {
        js_redirect('dashboard.php');
    }
}


function check_login_user()
{
    if (!(isset($_SESSION['user_id']) && isset($_SESSION['name']) && isset($_SESSION['email'])
    )) {
        js_redirect('login.php');
    }
}

function check_login_admin()
{
    if (!(isset($_SESSION['user_id']) &&
        isset($_SESSION['name']) &&
        isset($_SESSION['email']) &&
        isset($_SESSION['is_admin']) &&
        $_SESSION['is_admin'] == 1)) {
        js_redirect('login.php');
    }
}

function set_user_session($params = array())
{
    $_SESSION['user_id'] = $params['id'];
    $_SESSION['name'] = $params['first_name'] . ' ' . $params['last_name'];
    $_SESSION['email'] = $params['email'];
    $_SESSION['is_admin'] = $params['is_admin'];
}

function unset_user_session()
{
    unset($_SESSION['user_id']);
    unset($_SESSION['name']);
    unset($_SESSION['email']);
    unset($_SESSION['is_admin']);
}

function logout($db)
{
    $id = isset($_SESSION['user_id']) ? $_SESSION['user_id'] : 0;
    update($db, 'users', ['is_logged_in' => 0], " id = {$id} ");
    unset_user_session();
    js_redirect('login.php');
}

function ext_check($file, $exts = array())
{
    $img_arr = explode('.', $file['name']);
    $img_ext = end($img_arr);
    return in_array($img_ext, $exts);
}
function muliple_uploads($dest, $files)
{
    $total_files = count($files['name']);
    $images_name = array();
    for ($i = 0; $i < $total_files; $i++) {
        $img_name = $dest . '/' . time() . '_' . str_replace(' ', '_', $files['name'][$i]);
        // You may want to add more checks here to validate the file type, size, etc.
        if (move_uploaded_file($files['tmp_name'][$i], 'uploads/' . $img_name)) {
            $images_name[] = $img_name;
        }
    }
    return $images_name;
}
function file_upload($dest, $file = array(), $del = '')
{
    if ($del != '') {
        if (file_exists(__DIR__ . '/../uploads/' . $del)) {
            unlink(__DIR__ . '/../uploads/' . $del);
        }
    }
    $img_name = $dest . '/' . time() . '_' . str_replace(' ', '_', $file['name']);
    $tmp_path = $file['tmp_name'];
    $res = move_uploaded_file($tmp_path, __DIR__ . '/../uploads/' . $img_name);
    if ($res) {
        return $img_name;
    } else {
        return false;
    }
}

function delete_file($des)
{

    if (file_exists($des) && is_file($des)) {
        return  unlink($des);
    }
}

function room_current($db, $params)
{
    $pre_room = single_data($db, 'rooms', ' id = ' . ($params['pre_id'] ?? 0));
    if ($pre_room) {
        update($db, 'rooms', ['current' =>  $pre_room['current'] - 1], ' id = ' . $params['pre_id'] . ' AND current > 0');
    }
    $current_room = single_data($db, 'rooms', ' id = ' . ($params['room_id'] ?? 0));
    if ($current_room) {
        update($db, 'rooms', ['current' => $current_room['current'] + 1], ' id = ' . $params['room_id'] . ' AND capacity > current');
    }
    return 1;
}
/**
 * JAVASCRIPT FUNCTIONS
 */
function js_alert($data)
{
    echo "<script>
            alert('$data');
        </script>";
}

function js_redirect($loc = null)
{
    if ($loc == null) {
        echo "<script>
            window.location.href = window.location.href;
            </script>";
    } else {
        echo "<script>
            window.location.href = '" . site_url($loc) . "';
            </script>";
    }
}
