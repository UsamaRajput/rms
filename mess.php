
<?php require_once 'layout/admin/header.php'; ?>
<?php include_once 'layout/admin/sidebar.php'; ?>
<?php
$mess = all_data($db, 'mess');?>

<div style="margin-left: 300px;">
    <div>
        <table border="1">
            <thead>
                <tr>
                    <th>Day</th>
                    <th>Dish 1</th>
                    <th>Dish 2</th>
                    <th>Update</th>
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
                        <td><input type="button" class="btn btn-sm btn-primary update-dish" value="update" data-day="<?= $single['day'] ?>" /></td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>
</div>
<?php require_once 'layout/admin/footer.php'; ?>

<script>
    $('.update-dish').click(function(e) {
        e.preventDefault();
        let day = $(this).data('day');
        let ele = $(this).closest('tr');
        let dish1 = ele.find(`#dish1${day}`).val();
        let dish2 = ele.find(`#dish2${day}`).val();
        let dish1_units = ele.find(`#dish1-units${day}`).val();
        let dish2_units = ele.find(`#dish2-units${day}`).val();
        // console.log( {
        //         dish_update: 1,
        //         day: day,
        //         dish1: dish1,
        //         dish2: dish2,
        //         dish1_units: dish1_units,
        //         dish2_units: dish2_units
        //     });
        $.ajax({
            url: 'ajax/room.php',
            type: 'post',
            data: {
                dish_update: 1,
                day: day,
                dish1: dish1,
                dish2: dish2,
                dish1_units: dish1_units,
                dish2_units: dish2_units
            },
            success: function(res) {
                // console.log(res);
                if(res == 1){
                    alert('dish update');
                }else{
                    alert('server error')
                }
            }
        })

    })
</script>