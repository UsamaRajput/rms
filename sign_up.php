<?php require_once __DIR__ . '/helpers/include.php'; ?>

<?php
$dept = all_data($db, 'departments');

if (isset($_POST['sign_up'])) {
    $email = $_POST['email'];
    $cnic = $_POST['cnic'];
    $res = mysqli_query($db, "SELECT * FROM users WHERE email = '$email' OR cnic = '$cnic' ");
    if (mysqli_num_rows($res) > 0) {
        js_alert('Email Already Exist');
    } else {
        $_POST['password'] = password_hash($_POST['password'], PASSWORD_DEFAULT);
        unset($_POST['sign_up']);
        $ext =  ['png', 'jpg', 'jpeg'];
        if (ext_check($_FILES['image'], $ext)) {
            $_POST['image'] = file_upload('images/users', $_FILES['image']);
            $insert_user = insert($db, 'users', $_POST);
            if ($insert_user) {
                js_alert('You have successfully registered for dashboard access, but verification from the admin is required.');
                js_redirect('login.php');
            } else {
                js_alert('Server Error');
            }
        } else {
            js_alert('Please upload an image');
        }
    }
}

?>
<!DOCTYPE html>
<html>

<head>
    <link rel="icon" href="Untitled-2PJ.png">
    <title>
        index</title>
    <link rel="stylesheet" href="Signup.css">
</head>

<body class="body">
    <div class="title">
        <h2 class="Signup"> Sign up</h2>
    </div>
    <div class="subtitle"> Help you to connect with us. </div>
    <hr>
    <h3 class="information">Personal Information</h3>
    <form method="post" enctype="multipart/form-data">
        <div class="txt_field">
            <input type="text" name="first_name" value="<?= $_POST['first_name'] ?? '' ?>" placeholder="First name">
            <input type="text" name="last_name" value="<?= $_POST['last_name'] ?? '' ?>" placeholder="Last name"> <br>
            <input type="email" name="email" value="<?= $_POST['email'] ?? '' ?>" placeholder="Email address"> <br>
            <input type="text" name="cnic" value="<?= $_POST['cnic'] ?? '' ?>" placeholder="CNIC number"> <br>
            <input type="password" name="password" value="<?= $_POST['password'] ?? '' ?>" placeholder="Password">
        </div>

        <input class="file-upload-input" type="file" name="image">
        <br><br>
        Phone Number <br>

        <input type="text" name="phone" placeholder="03*********" value="<?= $_POST['phone'] ?? '' ?>" class="phone1">
        <br>
        Address <br>
        <input type="text" name="address" value="<?= $_POST['address'] ?? '' ?>" placeholder="Address" class="phone1">
        <input type="text" name="city" value="<?= $_POST['city'] ?? '' ?>" placeholder="City" class="phone1">
        <br>
        Blood Group
        <br>
        <select class="blood" name="blood_group">
            <option value="">--Select a blood group--</option>
            <option value="A+">A +</option>
            <option value="A-">A -</option>
            <option value="B+">B +</option>
            <option value="B-">B -</option>
            <option value="AB+">AB +</option>
            <option value="AB-">AB -</option>
            <option value="O+">O +</option>
            <option value="O-">O -</option>
        </select>
        <br>
        <select class="blood" name="dept_id">
            <option value="">--Select a department--</option>
            <?php
            foreach ($dept as $single) {
            ?>
                <option <?= ($_POST['dept_id'] ?? '') == $single['id'] ? 'selected' : '' ?> value="<?= $single['id']; ?>"><?= $single['name']; ?></option>
            <?php
            }
            ?>
        </select>
        <br>
        <div class="dob">
            <input type="date" name="dob" value="<?= $_POST['dob'] ?? '' ?>">
        </div>
        <br>
        Gender<br>
        Male <input type="radio" name="gender" value="male">
        Female <input type="radio" name="gender" value="female">
        Custom<input type="radio" name="gender" value="custom">

        <br> <input type="submit" value="Signup" name="sign_up">
        <br><br>
    </form>
    Already have account <a href="login.php" div class="login">Login</a>
    </div>

    <br><br>


</body>

</html>