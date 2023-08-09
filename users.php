<?php require_once 'layout/admin/header.php'; ?>
<?php include_once 'layout/admin/sidebar.php'; ?>
<?php
// $users = all_data($db, 'users');
$rooms = all_data($db, 'rooms', ' is_active = 1');
$departments = all_data($db, 'departments');
// $qry = "SELECT *,users.id as user_id, users.is_active as user_active FROM users LEFT JOIN rooms ON users.room_id = rooms.id LEFT JOIN departments ON users.dept_id = departments.id ";
$qry = "SELECT *,users.id as user_id, users.is_active as user_active ,
( SELECT count(dept_id) FROM users as depus WHERE users.dept_id = depus.dept_id ) as dept_count
FROM users LEFT JOIN rooms ON users.room_id = rooms.id LEFT JOIN departments ON users.dept_id = departments.id ";
// echo $qry;
// die;
if ((isset($_GET['token']) && $_GET['token'] != '') && isset($_GET['sort']) && $_GET['sort'] != '') {
    $qry .= " WHERE `users`.`" . $_GET['token'] . '` = ' . $_GET['sort'];
}

$qry .= ' ORDER BY `users`.`id` DESC ';
$users = qry($db, $qry, true, true);

if (isset($_POST['field'])) {
    $data =   [$_POST['field'] => $_POST['val'], 'room_id' => 0];
    if (
        ($_POST['field'] == 'is_active' && $_POST['val'] == 0) ||
        ($_POST['field'] == 'is_verified' && $_POST['val'] == 0)
    ) {
        $data['room_id'] = 0;
    }
    room_current($db, $_POST);
    update($db, 'users', $data, ' id = ' . $_POST['id']);
    js_redirect('users.php');
}

if (isset($_POST['user_id'])) {
    $user_id = $_POST['user_id'];
    $check = single_data($db, 'users', " (cnic = '" . $_POST['cnic'] . "'  OR email = '" . $_POST['email'] . "')" . " AND id <> $user_id");
    if (is_array($check) && count($check) > 0) {
        js_alert('CNIC or Email alreay exist');
    } else {
        $err = false;
        if (isset($_FILES['image']['name']) && !empty($_FILES['image']['name'])) {
            $res = ext_check($_FILES['image'], ['jpg', 'png', 'jpeg']);
            if ($res) {
                $_POST['image'] = file_upload('images/users', $_FILES['image'], $_POST['user_old_img']);
            } else {
                js_alert('please upload an image');
                $err = true;
            }
        }
        if ($err == false) {
            unset($_POST['user_id'], $_POST['user_old_img']);
            update($db, 'users', $_POST, ' id = ' . $user_id);
            js_alert('User updated successfully');
            js_redirect('users.php');
        }
    }
}

if (isset($_POST['delete'])) {
    del_data($db, 'users', $_POST['id']);
    js_redirect('users.php');
}
?>

<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Update User</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form method="post" enctype="multipart/form-data">
                <div class="modal-body">
                    <input type="hidden" name='user_id' class="form-control" id="user-id">
                    <input type="hidden" name='user_old_img' class="form-control" id="user-oldimg">
                    <div class="mb-3">
                        <label for="user-first" class="col-form-label">First Name:</label>
                        <input type="text" name='first_name' class="form-control" id="user-first">
                    </div>
                    <div class="mb-3">
                        <label for="user-last" class="col-form-label">Last Name:</label>
                        <input type="text" name='last_name' class="form-control" id="user-last">
                    </div>
                    <div class="mb-3">
                        <label for="user-email" class="col-form-label">Email:</label>
                        <input type="email" name='email' class="form-control" id="user-email">
                    </div>
                    <div class="mb-3">
                        <label for="user-cnic" class="col-form-label">CNIC:</label>
                        <input type="text" name='cnic' class="form-control" id="user-cnic">
                    </div>
                    <div class="mb-3">
                        <label for="user-password" class="col-form-label">Password:</label>
                        <input type="password" name='password' class="form-control" id="user-password">
                    </div>
                    <div class="mb-3">
                        <label for="user-phone" class="col-form-label">Phone:</label>
                        <input type="text" name='phone' class="form-control" id="user-phone">
                    </div>
                    <div class="mb-3">
                        <label for="user-address" class="col-form-label">Address:</label>
                        <input type="text" name='address' class="form-control" id="user-address">
                    </div>
                    <div class="mb-3">
                        <label for="user-city" class="col-form-label">city:</label>
                        <input type="text" name='city' class="form-control" id="user-city">
                    </div>
                    <div class="mb-3">
                        <label for="user-dob" class="col-form-label">DOB:</label>
                        <input type="date" name='dob' class="form-control" id="user-dob">
                    </div>
                    <div class="mb-3">
                        Gender<br>
                        Male <input type="radio" class="gender" name="gender" value="male">
                        Female <input type="radio" class="gender" name="gender" value="female">
                        Custom<input type="radio" class="gender" name="gender" value="custom">
                    </div>
                    <div class="mb-3">
                        <label for="user-dept" class="col-form-label">Department:</label>
                        <select class="form-control" id="user-dept" name="dept_id">
                            <option value="0">--Select a department--</option>
                            <?php
                            foreach ($departments as $key => $dept) {
                            ?>
                                <option value="<?= $dept['id'] ?>"><?= $dept['name'] ?></option>
                            <?php
                            }
                            ?>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="user-blood" class="col-form-label">Blood Group:</label>
                        <select id="user-blood" class="form-control" name="blood_group">
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
                    </div>
                    <div class="mb-3">
                        <label for="user-image" class="col-form-label">User Image:</label>
                        <input type="file" name="image" class="form-control" id="user-image">
                    </div>
                    <div class="mb-3">
                        <img src="" class="w-50" alt="" id="user-img">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">Update</button>
                </div>
            </form>
        </div>
    </div>
</div>

<div style="margin-left: 200px;">
    <div class="m-5">
        <a class="btn btn-sm btn-info" href="users.php">All</a>
        <a class="btn btn-sm btn-info" href="?token=is_verified&sort=1">Verified</a>
        <a class="btn btn-sm btn-info" href="?token=is_verified&sort=0">Un Verified</a>
        <a class="btn btn-sm btn-info" href="?token=is_active&sort=1">Active</a>
        <a class="btn btn-sm btn-info" href="?token=is_active&sort=0">Un Active</a>
        <a class="btn btn-sm btn-info" href="?token=room_id&sort=0">Room not assigned</a>
    </div>
    <div>
        <table border="1">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Image</th>
                    <th>Name</th>
                    <th>Department</th>
                    <th>Phone</th>
                    <th>DOB</th>
                    <th>City</th>
                    <th>Request</th>
                    <th>Assign/Change room</th>
                    <th>action</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($users as $index => $single) {
                    // pr($single,1);
                ?>
                    <tr>
                        <td><?= $index + 1 ?></td>
                        <td><img src="<?= uploads($single['image']) ?>" width="50"></td>
                        <td><?= $single['first_name'] . ' ' . $single['last_name'] ?></td>
                        <td><?= $single['name'] ?></td>
                        <td><?= $single['phone'] ?></td>
                        <td><?= date('d-m-Y', strtotime($single['dob'])) ?></td>
                        <td><?= $single['city'] ?></td>
                        <td>
                            <p> <?= ($single['requested_room'] == 0 ? 'not requested' :  ROOM_PREFIX . $single['requested_room']) ?></p>
                            <?php if ($single['requested_room'] > 0) { ?>
                                <button class="btn btn-success btn-sm req-room" data-user_id="<?= $single['user_id'] ?>" data-req_id="<?= $single['requested_room'] ?>">Approved</button>
                                <button class="btn btn-danger btn-sm rej-room" data-user_id="<?= $single['user_id'] ?>">Reject</button>
                            <?php } ?>
                        </td>
                        <td>
                            <select class="assign-room" data-pre_id="<?= $single['room_id'] ?>" data-is_active="<?= $single['user_active'] ?>" data-is_verified="<?= $single['is_verified'] ?>" data-user_id="<?= $single['user_id'] ?>">
                                <option value="0">--Select a Room</option>
                                <?php
                                foreach ($rooms as $key => $room) {
                                ?>
                                    <option <?= $room['current'] >= $room['capacity'] ? 'disabled' : '' ?> <?= ($single['room_id'] == $room['id'] ? 'selected' : '') ?> value="<?= $room['id'] ?>"><?= ROOM_PREFIX . ' ' . $room['number'] ?></option>
                                <?php
                                }
                                ?>
                            </select>
                        </td>
                        <td>
                            <?= '<form action="" method="POST">
                                <input type="hidden" name="id" value="' . $single['user_id'] . '">
                                <input type="submit" name="delete" value="Delete" class="btn btn-sm btn-danger">
                            </form>'; ?>
                            <?php
                            if ($single['is_verified'] == 0) {
                                echo '<form action="" method="POST">
                                <input type="hidden" name="id" value="' . $single['user_id'] . '">
                                <input type="hidden" name="field" value="is_verified">
                                <input type="hidden" name="val" value="1">
                                <input type="hidden" name="pre_id" value="0">
                                <input type="submit" value="Verify" class="btn btn-sm btn-success">
                            </form>';
                            } else {
                                echo '<form action="" method="POST">
                                <input type="hidden" name="id" value="' . $single['user_id'] . '">
                                <input type="hidden" name="field" value="is_verified">
                                <input type="hidden" name="val" value="0">
                                <input type="hidden" class="pre_id' . $single['user_id'] . '" name="pre_id" value="' . $single['room_id'] . '">
                                <input type="button" value="Un Verify" class="btn btn-sm btn-danger action-btn">
                            </form>';
                            }
                            ?>
                            <?php
                            if ($single['user_active'] == 0) {
                                echo '<form action="" method="POST">
                                <input type="hidden" name="id" value="' . $single['user_id'] . '">
                                <input type="hidden" name="field" value="is_active">
                                <input type="hidden" name="val" value="1">
                                <input type="hidden" name="pre_id" value="0">
                                <input type="submit" value="Active" class="btn btn-sm btn-success">
                            </form>';
                            } else {
                                echo '<form action="" method="POST">
                                <input type="hidden" name="id" value="' . $single['user_id'] . '">
                                <input type="hidden" name="field" value="is_active">
                                <input type="hidden" name="val" value="0">
                                <input type="hidden" class="pre_id' . $single['user_id'] . '" name="pre_id" value="' . $single['room_id'] . '">
                                <input type="button" value="De Active" class="btn btn-sm btn-danger action-btn">
                            </form>';
                            }
                            ?>
                            <button type="button" class="btn btn-sm btn-primary update-user" data-user_id="<?= $single['user_id'] ?>" data-bs-toggle="modal" data-bs-target="#exampleModal">Update</button>
                        </td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>
</div>
<?php require_once 'layout/admin/footer.php'; ?>

<script>
    $('.assign-room').change(function() {
        let ele = $(this);
        let user_id = ele.data('user_id');
        let is_active = ele.data('is_active');
        let pre_id = ele.data('pre_id');
        let room_id = ele.val();
        ele.data('pre_id', room_id);
        if (is_active != 1) {
            ele.val(0);
            alert('Please active this user');
            return false;
        }
        let is_verified = ele.data('is_verified');
        if (is_verified != 1) {
            ele.val(0);
            alert('Please verify this user');
            return false;
        }
        if (room_id != '') {
            $.ajax({
                url: "ajax/room.php",
                type: 'post',
                data: {
                    assign_room: 1,
                    user_id: user_id,
                    room_id: room_id,
                    pre_id: pre_id
                },
                success: function(res) {
                    let data = JSON.parse(res);
                    if (data.success == 1) {
                        if (room_id == 0) {
                            alert('Room removed')
                        } else {
                            if (room_id != 0) {
                                let capacity = data.room.capacity;
                                let current = data.room.current;
                                if (current >= capacity) {
                                    $(`option[value=${room_id}]`).attr('disabled', true);
                                }
                            }
                            if (pre_id != 0) {
                                let pre_capacity = data.pre_room.capacity;
                                let pre_current = data.pre_room.current;
                                if (pre_capacity >= pre_current) {
                                    $(`option[value=${pre_id}]`).attr('disabled', false)
                                }
                                $(`.pre_id${user_id}`).val(room_id);
                            }
                            alert('Room assigned');
                        }
                    } else {
                        alert('Server error');
                    }
                }
            })
        }
    });

    $('.action-btn').click(function() {
        let action = $(this).val();
        let decision = confirm(`If you ${action} this user, then the room will also be removed from the user.`);
        if (decision) {
            $(this).closest('form').submit();
        }
    })

    $('.update-user').click(function() {
        let user_id = $(this).data('user_id');
        $.ajax({
            url: 'ajax/user.php',
            type: 'post',
            data: {
                user_data: 1,
                user_id: user_id
            },
            success: function(res) {
                if (res) {
                    let user = JSON.parse(res);
                    dept = user.dept_id;
                    blood = user.blood_group;
                    $('#user-id').val(user_id);
                    $('#user-first').val(user.first_name);
                    $('#user-last').val(user.last_name);
                    $('#user-email').val(user.email);
                    $('#user-cnic').val(user.cnic);
                    $('#user-phone').val(user.phone);
                    $('#user-address').val(user.address);
                    $('#user-city').val(user.city);
                    $('#user-dob').val(user.dob);
                    $('#user-dept').val(user.dept_id);
                    $('#user-blood').val(user.blood_group);
                    $('#user-oldimg').val(user.image);
                    $(`.gender[value="${user.gender}"]`).prop("checked", true);
                    $('#user-img').attr('src', `<?= uploads('${user.image}') ?>`);
                }
            }
        });
    })

    $('.req-room').click(function() {
        let req_id = $(this).data('req_id');
        let user_id = $(this).data('user_id');
        $.ajax({
            url: 'ajax/user.php',
            type: 'post',
            data: {
                user_id,
                req_id,
                approve: 1
            },
            success: function(req) {
                if (req == 2) {
                    let reject_check = confirm('room is already filled do you want to reject all room request on for this room');
                    if (reject_check) {
                        reject_all(req_id);
                    }
                } else if (req == 0) {
                    alert('Server error');
                } else {
                    let room = JSON.parse(req);
                    if (room.capacity <= room.current) {
                        let reject_check = confirm('room is filled now do you want to reject all room request on for this room');
                        if (reject_check) {
                            reject_all(req_id);
                        }
                    }
                }
            }
        })
    });

    $('.rej-room').click(function() {
        let user_id = $(this).data('user_id');
        $.ajax({
            url: 'ajax/user.php',
            type: 'post',
            data: {
                rejected: 1,
                user_id
            },
            success: function(res) {
                if (res == 1) {
                    alert('rejected');
                } else {
                    alert('server error')
                }

            }
        })
    });

    function reject_all(req_id) {
        $.ajax({
            url: 'ajax/user.php',
            type: 'post',
            data: {
                all_rejected: 1,
                req_id
            },
            success: function(res) {
                if ($res == 1) {

                    alert('Successfully rejected all users');
                } else {
                    alert('server error');
                }
            }
        })
    }
</script>