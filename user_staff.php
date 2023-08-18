<?php require_once 'layout/user/header.php'; ?>
<?php
check_login_user();
$staff = all_data($db, 'staff');
?>

<div style="margin-left: 300px;">
    <div>
        <table border="1">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Image</th>
                    <th>Name</th>
                    <th>Role</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($staff as $index => $single) {
                ?>
                    <tr>
                        <td><?= $index + 1 ?></td>
                        <td><img src="<?= uploads($single['image']) ?>" width="50"></td>
                        <td><?= $single['name'] ?></td>
                        <td><?= $single['role'] ?></td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>
</div>
<?php require_once 'layout/user/footer.php'; ?>
