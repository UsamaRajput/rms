<?php require_once 'layout/admin/header.php'; ?>
<?php include_once 'layout/admin/sidebar.php'; ?>
<?php
$rooms = all_data($db, 'rooms');
if (isset($_POST['add_room'])) {

    $exists = all_data($db, 'rooms', " number = '" . $_POST['number'] . "'", true);
    if ($exists > 0) {
        js_alert('Room number already exists');
    } else {
        unset($_POST['add_room']);
        $res = insert($db, 'rooms', $_POST);
        if ($res) {
            if (isset($_FILES['images']) && !empty($_FILES['images'])) {
                $room_id = mysqli_insert_id($db);
                $images_name = muliple_uploads('images/rooms', $_FILES['images']);
                foreach ($images_name as $key => $value) {
                    insert($db, 'room_images', ['room_id' => $room_id, 'image' => $value]);
                }
            }
            js_alert('Room added successfully');
            js_redirect('rooms.php');
        } else {
            js_alert('Server error');
        }
    }
}

if (isset($_POST['update_room'])) {

    if ($_POST['room_pre'] != $_POST['number']) {
        $exists = all_data($db, 'rooms', " number = '" . $_POST['number'] . "'", true);
    } else {
        $exists = 0;
    }

    if ($exists > 0) {
        js_alert('Room number already exists');
    } else {
        $id = $_POST['room_id'];
        unset($_POST['update_room'], $_POST['room_pre'], $_POST['room_id']);
        $res = update($db, 'rooms', $_POST, ' id = ' . $id);
        if ($res) {
            if (isset($_FILES['images']) && !empty($_FILES['images'])) {
                // js_alert('hiiii');
                $images_name = muliple_uploads('images/rooms', $_FILES['images']);
                foreach ($images_name as $key => $value) {
                    insert($db, 'room_images', ['room_id' =>  $id, 'image' => $value]);
                }
            }
            js_alert('Room updated successfully');
            js_redirect('rooms.php');
        } else {
            js_alert('Server error');
        }
    }
}

if (isset($_POST['field'])) {
    $data =   [$_POST['field'] => $_POST['val'],'current'=>0];
    update($db,'users',['room_id'=>0],' room_id = ' .$_POST['id']);
    update($db, 'rooms', $data, ' id = ' . $_POST['id']);
    js_redirect('rooms.php');
}

if (isset($_POST['delete'])) {
    $room_imgs = all_data($db, 'room_images', ' room_id = ' . $_POST['id']);
    foreach ($room_imgs as $key => $value) {
        delete_file(__DIR__ . '/uploads/' . $value['image']);
    }
    del_custom($db, 'room_images', ' room_id = ' . $_POST['id']);
    del_data($db, 'rooms', $_POST['id']);
    js_redirect('rooms.php');
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
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Update Room</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form method="post" enctype="multipart/form-data">
                <div class="modal-body">

                    <input type="hidden" name='room_id' class="form-control" id="room-id">
                    <input type="hidden" name='room_pre' class="form-control" id="room-pre">
                    <div class="mb-3">
                        <label for="room-num" class="col-form-label">Room Number:</label>
                        <input type="number" name='number' class="form-control" id="room-num">
                    </div>
                    <div class="mb-3">
                        <label for="room-cap" class="col-form-label">Room Capacity:</label>
                        <input type="number" name='capacity' class="form-control" id="room-cap">
                    </div>
                    <div class="mb-3">
                        <label for="room-img" class="col-form-label">Room Images:</label>
                        <input type="file" multiple name="images[]" class="form-control" id="room-img">
                    </div>
                    <div class="mb-3" id="room-images">

                    </div>

                </div>
                <div class="modal-footer">
                    <button type="submit" name="update_room" class="btn btn-primary">Update</button>
                </div>
            </form>
        </div>
    </div>
</div>

<div style="margin-left: 300px;">
    <div>
        <form method="post" enctype="multipart/form-data">
            <input type="number" value="<?= $_POST['number'] ?? '' ?>" name="number" placeholder="Room number" />
            <input type="number" value="<?= $_POST['capacity'] ?? '' ?>" name="capacity" placeholder="Capacity" />
            <input type="file" multiple name="images[]">
            <input type="submit" name="add_room" value="add room">
        </form>
    </div>
    <div>
        <table border="1">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Images</th>
                    <th>Number</th>
                    <th>Capacity</th>
                    <th>Current</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($rooms as $index => $single) {
                ?>
                    <tr>
                        <td><?= $index + 1 ?></td>
                        <td>
                            <?php
                            $room_imgs = all_data($db, 'room_images', ' room_id = ' . $single['id']);
                            foreach ($room_imgs as $key => $img) {
                            ?>
                                <img width="50" src="<?= uploads($img['image']) ?>">
                            <?php
                            }
                            ?>
                        </td>
                        <td class="room_nmber"><?= ROOM_PREFIX . $single['number'] ?></td>
                        <td class="room_capacity"><?= $single['capacity'] ?></td>
                        <td><?= $single['current'] ?></td>
                        <td>
                            <button type="button" class="btn btn-sm btn-primary update-room" data-room_id="<?= $single['id'] ?>" data-bs-toggle="modal" data-bs-target="#exampleModal">Update</button>
                            <?= '<form action="" method="POST">
                                <input type="hidden" name="id" value="' . $single['id'] . '">
                                <input type="submit" name="delete" value="Delete" class="btn btn-sm btn-danger">
                            </form>'; ?>
                            <?php
                            if ($single['is_active'] == 0) {
                                echo '<form action="" method="POST">
                                <input type="hidden" name="id" value="' . $single['id'] . '">
                                <input type="hidden" name="field" value="is_active">
                                <input type="hidden" name="val" value="1">
                                <input type="submit" value="Active" class="btn btn-sm btn-success">
                            </form>';
                            } else {
                                echo '<form action="" method="POST">
                                <input type="hidden" name="id" value="' . $single['id'] . '">
                                <input type="hidden" name="field" value="is_active">
                                <input type="hidden" name="val" value="0">
                                <input type="button" value="De Active" class="btn btn-sm btn-danger action-btn">
                            </form>';
                            }
                            ?>
                        </td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>
</div>
<?php require_once 'layout/admin/footer.php'; ?>

<script>
    $('.update-room').click(function() {
        let room_id = $(this).data('room_id');
        let tr = $(this).closest('tr');
        let room_number = parseInt(tr.find('.room_nmber').html().split('<?= ROOM_PREFIX ?>').join(''));
        let room_capacity = parseInt(tr.find('.room_capacity').html());
        $('#room-num').val(room_number);
        $('#room-pre').val(room_number);
        $('#room-cap').val(room_capacity);
        $('#room-id').val(room_id);
        $('#room-images').html('')
        $.ajax({
            url: 'ajax/room.php',
            type: 'post',
            data: {
                room_imgs: 1,
                room_id: room_id
            },
            success: function(res) {
                let imgs = JSON.parse(res);
                let img_html = '';
                imgs.forEach(element => {
                    img_html += `
                    <div class="row" id="delimg-${element.id}">
                            <div class="col-md-8"><img class=" w-50" src="<?= uploads('${element.image}') ?>"/></div>
                            <div class="col-md-4"><a href='javascript:;' class="btn btn-sm btn-danger" onclick='del_img(${element.id},"${element.image}")'>delete</a></div>
                        </div>
                    `;
                });
                $('#room-images').html(img_html);
            }
        });
    })

    function del_img(img_id,image) {
        $.ajax({
            url: 'ajax/room.php',
            type: 'post',
            data: {
                img_delete: 1,
                id: img_id,
                image:image
            },
            success: function(res) {
                if (res) {
                    $('#delimg-' + img_id).fadeOut();
                    alert('Image deleted')
                } else {
                    alert('Server error')
                }
            }
        })
    }

    $('.action-btn').click(function() {
        let action = $(this).val();
        let decision = confirm(`If you ${action} this room, then user are dealocated room.`);
        if (decision) {
            $(this).closest('form').submit();
        }
    })
</script>