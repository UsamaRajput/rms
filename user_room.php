<?php require_once 'layout/user/header.php'; ?>

<?php
check_login_user();

$qry = "SELECT *,
            users.id as user_id ,
            departments.name as dept_name
            FROM users 
            LEFT JOIN rooms ON rooms.id = users.room_id 
            LEFT JOIN departments ON departments.id = users.dept_id 
        WHERE users.id = " . $_SESSION['user_id'];
$room = qry($db, $qry, true);
$room_imgs = all_data($db, 'room_images', ' room_id = ' . ($room['room_id'] ?? 0));

$mate_qry = "SELECT *,
            users.id as user_id ,
            departments.name as dept_name
            FROM users 
            LEFT JOIN departments ON departments.id = users.dept_id 
            WHERE users.room_id = " . $room['room_id'];
$mates = qry($db, $mate_qry, true, true);

?>

<?php
foreach ($room_imgs as $key => $value) {
?>
    <img src="<?= uploads($value['image']) ?>" alt="" class="w-25">
<?php
}
?>
<div class="row">
    <div class="col-md-6">
        <h1>Your Information</h1>
        <p><?= $room['first_name'] . ' ' . $room['last_name'] ?></p>
        <p><span>Email: </span><?= $room['email'] ?></p>
        <p><span>Department: </span><?= $room['dept_name'] ?></p>
        <h1>Room</h1>
        <?php if (!empty($room['room_id'])) { ?>
            <p><?= ROOM_PREFIX . $room['number'] ?></p>
            <p><span>Capacity: </span><?= $room['capacity'] ?></p>
            <p><span>Current: </span><?= $room['current'] ?></p>
        <?php } else { ?>
            <h2>Not room allocated</h2>
        <?php } ?>
    </div>
    <div class="col-md-6">
        <h1>Mates</h1>
        <?php
        if (!empty($room['room_id'])) {

            foreach ($mates as $key => $value) {
                // pr( $_SESSION['user_id'],1);
                if ($value['user_id'] != $_SESSION['user_id']) {
        ?>
                    <img src="<?= uploads($value['image']) ?>" class="w-25" alt="">
                    <p><span>Name: </span><?= $value['first_name'] . ' ' . $value['last_name'] ?></p>
                    <p><span>Department: </span><?= $value['dept_name'] ?></p>
                    <p><span>Email: </span><?= $value['email'] ?></p>
                    <p><span>Phone: </span><?= $value['phone'] ?></p>

            <?php
                }
            }
        } else { ?>
            <h2>Not room allocated</h2>
        <?php } ?>

    </div>
</div>
<?php require_once 'layout/user/footer.php'; ?>