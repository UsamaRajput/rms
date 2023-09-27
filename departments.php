<?php require_once 'layout/admin/header.php'; ?>
<?php include_once 'layout/admin/sidebar.php'; ?>
<?php
$dept = all_data($db, 'departments');
if (isset($_POST['name'])) {
    $exists = all_data($db, 'departments', " name = '" . $_POST['name'] . "'", true);
    if ($exists > 0) {
        js_alert('department already exists');
    } else {
        $res = insert($db, 'departments', $_POST);
        if ($res) {
            js_alert('department added successfully');
            js_redirect('departments.php');
        } else {
            js_alert('Server error');
        }
    }
}

if (isset($_POST['delete'])) {
    del_data($db, 'departments', $_POST['id']);
    js_redirect('departments.php');
}
?>
<head>
    <link rel="icon" href="<?= assets('favicon.png', 2) ?>">
    <script src="https://kit.fontawesome.com/b3cac23527.js" crossorigin="anonymous"></script>
    <meta name="viewport content=width-device-width, initial-scale-1.0">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400&display=swap" rel="stylesheet">
</head>
<div style="margin-left: 300px;">
    <div>
        <form method="post">
            <input type="text" value="<?= $_POST['name'] ?? '' ?>" name="name" placeholder="Department name" />
            <input type="submit" value="add department">
        </form>
    </div>
    <div>
        <table border="1">
            <thead>
                <tr>
                    <th>#</th>
                    <th>name</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($dept as $index => $single) {
                ?>
                    <tr>
                        <td><?= $index ?></td>
                        <td><?= $single['name'] ?></td>
                        <td>
                            <?= '<form action="" method="POST">
                                <input type="hidden" name="id" value="' . $single['id'] . '">
                                <input type="submit" name="delete" value="Delete" class="btn btn-sm btn-danger">
                            </form>'; ?>
                        </td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>
</div>
<?php require_once 'layout/admin/footer.php'; ?>