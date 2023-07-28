<?php require_once __DIR__ . '/helpers/include.php'; ?>

<?php
// check_login($db, false);

$name = '';
$email = '';
// if (isset($_POST['sign_up'])) {
//     $name = $_POST['name'];
//     $email = $_POST['email'];
//     $password = $_POST['password'];
//     if (!(empty($name) || empty($email) || empty($password))) {
//         $hash_password = password_hash($password, PASSWORD_DEFAULT);
//         $res = mysqli_query($db,"SELECT * FROM users WHERE email = '$email'");
//         if (mysqli_num_rows($res) > 0) {
//             js_alert('Email Already Exist');
//         } else {
//             $data = [
//                 'name' => $name,
//                 'email' => $email,
//                 'password' => $hash_password,
//             ];
//             $insert_user = insert($db, 'users', $data);
//             if ($insert_user) {
//                 $last_id = mysqli_insert_id($db);
//                 set_user_session($last_id, $name, $email);
//                 js_redirect('client/index.php');
//             }
//         }
//     } else {
//         js_alert('All Fields are Required');
//     }
// }

if (isset($_POST['sign_in'])) {
    $email = $_POST['email'];
    $password = $_POST['password'];
    if (!(empty($email) || empty($password))) {
        $qry = mysqli_query($db,"SELECT * FROM users WHERE email = '$email' AND `is_active` = 1 AND `is_verified` = 1");
        if (mysqli_num_rows($qry) > 0) {
            $row = mysqli_fetch_assoc($qry);
            if (password_verify($password, $row['password'])) {
                set_user_session($row);
                js_redirect('client/index.php');
            } else {
                js_alert('Password Not Match In Our Credentials');
            }
        } else {
            js_alert('Email is not available Please Sign up');
        }
    }else{
        js_alert('All fields are required');
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <link rel="icon" href="<?= assets('logo.jpg', 2) ?>">
    <script src="https://kit.fontawesome.com/b3cac23527.js" crossorigin="anonymous"></script>
    <meta name="viewport content=width-device-width, initial-scale-1.0">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400&display=swap" rel="stylesheet">
    <title>Mess Management System</title>
    <link rel="Stylesheet" href="<?= assets('login.css',1)?>">
    <style>
        form{
            background-color: black;
        }
    </style>
</head>

<body>
    <div class="center"><br>
        <center>
            <i class="fa-solid fa-user"></i>
            <h1 div class="h1">Login Portal</h1>
        </center>
        <form method="post">
            <div class="txt_field">
                <input type="text" id="email" name="email" required>
                <label for="email">Email</label>
            </div>
            <div class="txt_field">
                <input type="password" id="password" name="password" required>
                <label for="password">Password</label>
                <br>
            </div>
            <br>
            <!-- <a href="D:/FYP-2023/forget password/forget password.html" div class="password">Forget password?</a><br> -->
            <button class="button" type="submit" name="sign_in"> Login</button>
            <div class="Signup_link">
                Not a member? <a href="sign_up.php" div class="signup">Signup</a>
            </div>
        </form>
    </div>

</body>

</html>