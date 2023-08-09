<?php require_once 'layout/user/header.php'; ?>
<?php
check_login_user();

$mess = all_data($db, 'mess');?>

<div style="margin-left: 300px;">
    <div>
        <table border="1">
            <thead>
                <tr>
                    <th>Day</th>
                    <th>Dish 1</th>
                    <th>Dish 2</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($mess as $single) {
                ?>
                    <tr>
                        <td><?= date('l', strtotime("Sunday +{$single['day']} days")) ?></td>
                        <td>
                            <input type="text" value="<?= $single['dish1'] ?>" id="dish1<?= $single['day'] ?>">
                            <input type="text" value="<?= $single['dish1_units'] ?>" id="dish1-units<?= $single['day'] ?>">
                        </td>
                        <td>
                            <input type="text" value="<?= $single['dish2'] ?>" id="dish2<?= $single['day'] ?>">
                            <input type="text" value="<?= $single['dish2_units'] ?>" id="dish2-units<?= $single['day'] ?>">
                        </td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>
</div>
<?php require_once 'layout/user/footer.php'; ?>