<?php require_once 'layout/user/header.php'; ?>
<?php
check_login_user();
$user = single_data($db, 'users', ' id = 2');
$rooms = all_data($db, 'rooms');
?>

<div style="margin-left: 300px;">
    <div id="room-no">Requested Room: <span> <?= ($user['requested_room'] == 0 ? 'Not requested' :  ROOM_PREFIX . $user['requested_room']) ?> </span></div>
    <div>
        <table border="1">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Images</th>
                    <th>Number</th>
                    <th>Capacity</th>
                    <th>Current</th>
                    <?php
                    // if (isset($_SESSION['user_id']) && !empty($_SESSION['user_id'])) {
                    ?>
                        <th>Request to Approve</th>
                    <?php 
                // }
                 ?>
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
                            <?php
                            // if (isset($_SESSION['user_id']) && !empty($_SESSION['user_id'])) {

                            if (($single['current'] >= $single['capacity']) && $user['requested_room'] <= 0 && $user['room_id'] == 0) {
                            ?>
                                <button class="btn btn-sm btn-danger full-room" disabled>Full</button>
                            <?php } else if (($single['current'] <= $single['capacity']) && $user['requested_room'] <= 0 && $user['room_id'] == 0) { ?>
                                <button class="btn btn-sm btn-primary request-room" data-id="<?= $single['id'] ?>">Request</button>
                            <?php } else if ($user['requested_room'] > 0 && $user['room_id'] == 0) {
                            ?>
                                <button class="btn btn-sm btn-info full-room" disabled>Requested</button>
                            <?php } else {
                            ?>
                                <button class="btn btn-sm btn-info full-room" disabled>Room alloted</button>
                            <?php
                                // }
                            } ?>
                        </td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>
</div>
<?php require_once 'layout/user/footer.php'; ?>

<script>
    $('.request-room').click(function() {
        let id = $(this).data('id');
        let user_id = 2;
        $.ajax({
            url: 'ajax/room.php',
            type: 'post',
            data: {
                id,
                user_id,
                request_room: 1
            },
            success: function(res) {
                if (res == 1) {
                    $('.request-room , .full-room').html('Requested').attr('disabled', true).removeClass('btn-primary btn-danger request-room').addClass('btn-info');
                    $('#room-no span').html(`<?= ROOM_PREFIX ?>${id}`)
                    alert('Room Requested');
                } else {
                    alert('server error')
                }
            }
        })
    });
</script>