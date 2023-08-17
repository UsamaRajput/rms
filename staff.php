<?php require_once 'layout/admin/header.php'; ?>
<?php include_once 'layout/admin/sidebar.php'; ?>

<?php
$staff = all_data($db, 'staff');
?>

<div style="margin-left: 300px;">
    <div id="newinput">
        <?php
        foreach ($staff as $key => $single) {
        ?>
            <div class="row">
                <div class="col-md-2">
                    <input type="text" class="name" value="<?= $single['name'] ?>">
                </div>
                <div class="col-md-2">
                    <img src="<?= uploads($single['image']) ?>" class="img-fluid" alt="">
                </div>
                <div class="col-md-2">
                    <input type="file" class="image">
                </div>
                <div class="col-md-2">
                    <input type="text" class="role" value="<?= $single['role'] ?>">
                </div>
                <div class="col-md-2">
                    <?php if ($single['is_active'] == 1) { ?>
                        <input type="button" class="btn btn-danger btn-sm" data-active="<?= $single['is_active'] ?>" data-id="<?= $single['id'] ?>" value="de active" onclick="activeDeactive(this)">
                    <?php } else { ?>
                        <input type="button" class="btn btn-primary btn-sm" data-id="<?= $single['id'] ?>" data-active="<?= $single['is_active'] ?>" value="active" onclick="activeDeactive(this)">
                    <?php } ?>
                </div>
                <div class="col-md-2">
                    <input type="button" data-id="<?= $single['id'] ?>" value="delete" class='btn btn-danger btn-sm'>
                </div>
            </div>
        <?php } ?>
    </div>
    <button id="rowAdder" type="button" class="btn btn-dark">
        <span class="bi bi-plus-square-dotted">
        </span> ADD
    </button>
</div>
<?php require_once 'layout/admin/footer.php'; ?>
<script type="text/javascript">
    function activeDeactive(ele) {
        let is_active = $(ele).data('active');
        let id = $(ele).data('id');
        is_active = is_active == 1 ? 0 : 1;
        let showText = is_active == 1 ? 'de active' : 'active';
        let showClass = is_active == 1 ? 'btn-danger' : 'btn-primary';
        let remClass = is_active == 1 ? 'btn-primary' : 'btn-danger';
        $.ajax({
            url: 'ajax/staff.php',
            type: 'post',
            data: {
                is_active,
                id
            },
            success: function(res) {
                if (res == 1) {
                    $(ele).data('active', is_active);
                    alert('rem' + remClass)
                    alert("add" + showClass)
                    alert("show" + showText)
                    $(ele).val(showText)
                    $(ele).removeClass(remClass).addClass(showClass);
                    alert('updated')
                } else {
                    alert('server error')
                }
                // alert(res);
            }
        })
    }
</script>
<script type="text/javascript">
    $("#rowAdder").click(function() {
        let lastRow = $('#newinput').find('.row').last();
        let pname = lastRow.find('.name').val()
        let prole = lastRow.find('.role').val()

        if (pname.length > 0) {
            if (prole.length > 0) {
                newRowAdd =
                    `
                    <div class="row">
                            <div class="col-md-2">
                                <input type="text" class="name">
                            </div>
                            <div class="col-md-2">
                            <img src="<?= uploads('images/default_user.png') ?>" class="img-fluid" alt="">
                            </div>
                            <div class="col-md-2">
                                <input type="file" class="image" >
                            </div>
                            <div class="col-md-2">
                                <input type="text" class="role" >
                            </div>
                            <div class="col-md-2">
                                <input type="button" class="btn btn-primary btn-sm"  data-active='1' value='active'  >
                            </div>
                            <div class="col-md-2">
                                <input type="button" value="delete" class='btn btn-danger' >
                            </div>
                        </div>
                    `;

                $('#newinput').append(newRowAdd);
            } else {
                alert('please add role');
            }

        } else {
            alert('please add name');
        }


    });

    $("body").on("click", "#DeleteRow", function() {
        $(this).parents("#row").remove();
    })
</script>