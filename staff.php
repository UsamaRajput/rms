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
                    <input type="hidden" class="old-img" value="<?= $single['image'] ?>">
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
                    <input type="button" data-id="<?= $single['id'] ?>" data-old="<?= $single['image']?>" value="delete" class='btn btn-danger btn-sm del-btn' onclick="delPerson(this)">
                    <input type="button" data-id="<?= $single['id'] ?>" value="update" class='btn btn-primary btn-sm' onclick="updatePerson(this)">
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
    function delPerson(ele) {
        let element = $(ele).closest('.row');
        let id = $(ele).data('id');
        let old = $(ele).data('old');
        $.ajax({
            url: "ajax/staff.php",
            type: 'post',
            data: {
                del_staff: 1,
                id,old
            },
            success: function(res) {
                if (res == 1) {
                    element.remove();
                } else {
                    alert('server error');
                }
            }
        })
    }

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
                    $(ele).val(showText)
                    $(ele).removeClass(remClass).addClass(showClass);
                    alert('updated')
                } else {
                    alert('server error')
                }
            }
        })
    }

    function addPerson(element) {
        let thisEle = $(element);
        let ele = $(element).closest('.row');
        let name = ele.find('.name').val();
        let img = ele.find('.image')[0].files;
        let role = ele.find('.role').val();
        let fd = new FormData();
        fd.append('image', img[0]);
        fd.append('name', name);
        fd.append('role', role);
        fd.append('add_staff', 1);

        $.ajax({
            url: 'ajax/staff.php',
            type: "post",
            contentType: false,
            processData: false,
            data: fd,
            success: function(res) {
                if(res == 0){
                    alert('server error')
                }else if(res == 1){
                    window.location.href = window.location.href;
                }else{
                    let data = JSON.parse(res);
                    ele.find('img').attr('src',"uploads/"+data.image);
                    ele.find('.old-img').val(data.image);
                    
                    ele.find('.del-btn').data('old',data.image).data('id',data.id);
                    thisEle.data('id',data.id).val('update').attr('onclick',"updatePerson(this)");
                    alert('added')
                    $("#rowAdder").show();
                }
            }
        })
    }

    function updatePerson(element){
        let thisEle = $(element);
        let id = thisEle.data('id');
        let ele = $(element).closest('.row');
        let name = ele.find('.name').val();
        let oldImg = ele.find('.old-img').val();
        let img = ele.find('.image')[0].files;
        let role = ele.find('.role').val();
        let fd = new FormData();
        fd.append('image', img[0]);
        fd.append('name', name);
        fd.append('role', role);
        fd.append('id', id);
        fd.append('oldImg', oldImg);
        fd.append('update_staff', 1);

        $.ajax({
            url: 'ajax/staff.php',
            type: "post",
            contentType: false,
            processData: false,
            data: fd,
            success: function(res) {
                if(res == 0){
                    alert('server error')
                }else if(res == 1){
                    window.location.href = window.location.href;
                }else{
                    let data = JSON.parse(res);
                    ele.find('img').attr('src',"uploads/"+data.image);
                    ele.find('.old-img').val(data.image);
                    
                    ele.find('.del-btn').data('old',data.image);
                    alert('updated');
                }
            }
        })
    }
</script>
<script type="text/javascript">
    $("#rowAdder").click(function() {
        let ele = $(this);
        let lastRow = $('#newinput').find('.row').last();
        let pname = lastRow.find('.name').val()
        let prole = lastRow.find('.role').val()
        if (pname == undefined || pname.length > 0) {
            if (pname == undefined || prole.length > 0) {
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
                                <input type="button" class="btn btn-danger btn-sm" data-active="1" data-id="0" value="de active" onclick="activeDeactive(this)">
                            </div>
                            <div class="col-md-2">
                                <input type="button" value="delete" class='btn btn-danger btn-sm del-btn' data-id='0' onclick="delPerson(this)">
                                <input type="button" value="add" class='btn btn-primary btn-sm' data-id='0' onclick="addPerson(this)">
                            </div>
                        </div>
                    `;

                $('#newinput').append(newRowAdd);
                ele.hide();
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