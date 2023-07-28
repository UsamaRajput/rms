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
function assets($url = null, $cond )
{
    if($cond == 2)
        $folder = 'images/';
    elseif($cond == 1)
        $folder = 'css/';
    elseif($cond == 3)
        $folder = 'js/';
    else 
        $folder = '';

    if ($url != null) {
        return SITE_URL . 'assets/' . $folder . $url.'?refresh='.time();
    }
    return SITE_URL;
}
function check_login($db, $check = true)
{
    if ($check == true) {
        if (!(isset($_SESSION['user_id']) && $_SESSION['name'] && $_SESSION['email'])) {
            if (isset($_SESSION['user_id'])) {
                update($db, 'users', ['is_logged_in' => 0], " id = {$_SESSION['user_id']} ");
            }
            js_redirect('login.php');
        }
    } elseif ($check == false) {
        if ((isset($_SESSION['user_id']) && $_SESSION['name'] && $_SESSION['email'])) {
            js_redirect('dashboard.php');
        }
    }
}

function set_user_session($params = array())
{
    $_SESSION['user_id'] = $params['id'];
    $_SESSION['name'] = $params['first_name'].' '.$params['last_name'];
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
/**
 * JAVASCRIPT FUNCTIONS
 */
function js_alert($data)
{
    echo "<script>
            alert('$data');
        </script>";
}

function js_redirect($loc)
{
    echo "<script>
            window.location.href = '" . site_url($loc) . "';
        </script>";
}
