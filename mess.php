<?php require_once 'layout/admin/header.php'; ?>
<?php include_once 'layout/admin/sidebar.php'; ?>
<?php
$dept = all_data($db, 'mess');
if (isset($_POST['name'])) {
    $exists = all_data($db, 'mess', " name = '" . $_POST['name'] . "'", true);
    if ($exists > 0) {
        js_alert('department already exists');
    } else {
        $res = insert($db, 'mess', $_POST);
        if ($res) {
            js_alert('department added successfully');
            js_redirect('mess.php');
        } else {
            js_alert('Server error');
        }
    }
}

if (isset($_POST['delete'])) {
    del_data($db, 'mess', $_POST['id']);
    js_redirect('mess.php');
}
?>

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
                <?php foreach ( range(1,7) as $single) {
                ?>
                    <tr>
                        <td><?=  date('l', strtotime("Sunday +{$single} days")) ?></td>
                        <td><?= $single ?></td>
                        <td></td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>
</div>
<?php require_once 'layout/admin/footer.php'; ?>