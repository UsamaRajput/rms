<?php require_once __DIR__ . '/helpers/include.php'; ?>

<?php
login_redirect();
$name = '';
$email = '';

if (isset($_POST['sign_in'])) {
    $email = $_POST['email'];
    $password = $_POST['password'];
    if (!(empty($email) || empty($password))) {
        $qry = mysqli_query($db, "SELECT * FROM users WHERE email = '$email' AND `is_active` = 1");
        if (mysqli_num_rows($qry) > 0) {
            $row = mysqli_fetch_assoc($qry);
            if ($row['is_verified'] != 1) {
                js_alert('You are not verified from admin');
            } else {
                if (password_verify($password, $row['password'])) {
                    set_user_session($row);
                    if ($row['is_admin'] == 1) {
                        js_redirect('dashboard.php');
                    } else {
                        js_redirect('index.php');
                    }
                } else {
                    js_alert('Password Not Match In Our Credentials');
                }
            }
        } else {
            js_alert('Email is not available Please Sign up');
        }
    } else {
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
    <link rel="Stylesheet" href="<?= assets('login.css', 1) ?>">

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