<?php require_once 'layout/admin/header.php'; ?>
<?php include_once 'layout/admin/sidebar.php'; ?>
<?php
$news = all_data($db, 'news');
if (isset($_POST['add_news'])) {
    $exists = all_data($db, 'news', " title = '" . $_POST['title'] . "'", true);
    if ($exists > 0) {
        js_alert('News title already exists');
    } else {
        unset($_POST['add_news']);
        file_upload('images/news', $_FILES['image']);
        $res = insert($db, 'news', $_POST);
        if ($res) {
            js_alert('News added successfully');
            js_redirect('news.php');
        } else {
            js_alert('Server error');
        }
    }
}

if (isset($_POST['update_news'])) {

    if ($_POST['pre_title'] != $_POST['title']) {
        $exists = all_data($db, 'news', " title = '" . $_POST['title'] . "'", true);
    } else {
        $exists = 0;
    }

    if ($exists > 0) {
        js_alert('News title already exists');
    } else {
        $id = $_POST['news_id'];
        $del_img = $_POST['del_img'];
        unset($_POST['update_news'], $_POST['pre_title'], $_POST['news_id'],$_POST['del_img']);
        $res = update($db, 'news', $_POST, ' id = ' . $id);
        if ($res) {
            if (isset($_FILES['image']) && !empty($_FILES['image'])) {
                file_upload('images/news', $_FILES['image'],$del_img);
            }
            js_alert('News updated successfully');
            js_redirect('news.php');
        } else {
            js_alert('Server error');
        }
    }
}

if (isset($_POST['delete'])) {
    del_data($db, 'news', $_POST['id']);
    js_redirect('news');
}

?>

<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Update News</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form method="post" enctype="multipart/form-data">
                <div class="modal-body">

                    <input type="hidden" name='news_id' class="form-control" id="news-id">
                    <input type="hidden" name='pre_title' class="form-control" id="news-pre">
                    <input type="hidden" name='del_img' class="form-control" id="news-delimg">
                    <div class="mb-3">
                        <label for="news-num" class="col-form-label">News title:</label>
                        <input type="text" name='title' class="form-control" id="news-title">
                    </div>
                    <div class="mb-3">
                        <label for="news-desc" class="col-form-label">News Description:</label>
                        <textarea name="description" class="form-control" id="news-desc" cols="30" rows="10"></textarea>
                    </div>
                    <div class="mb-3">
                        <label for="news-date" class="col-form-label">News Date:</label>
                        <input type="date" name='issue_date' class="form-control" id="news-date">
                    </div>
                    <div class="mb-3">
                        <select name="type" class="form-control">
                            <option value="0">News</option>
                            <option value="1">Clip</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="news-img" class="col-form-label">News Image:</label>
                        <input type="file" name="image" class="form-control" id="news-img">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" name="update_news" class="btn btn-primary">Update</button>
                </div>
            </form>
        </div>
    </div>
</div>

<div style="margin-left: 300px;">
    <div>
        <form method="post" enctype="multipart/form-data">
            <input type="text" value="<?= $_POST['title'] ?? '' ?>" name="title" placeholder="News title" />
            <textarea value="<?= $_POST['description'] ?? '' ?>" name="description" placeholder="Capacity"></textarea>
            <input type="date" name="issue_date">
            <select name="type">
                <option value="0">News</option>
                <option value="1">Clip</option>
            </select>
            <input type="file" name="image">
            <input type="submit" name="add_news" value="Add News">
        </form>
    </div>
    <div>
        <table border="1">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Images</th>
                    <th>title</th>
                    <th>Description</th>
                    <th>Date</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($news as $index => $single) {
                ?>
                    <tr>
                        <td><?= $index + 1 ?></td>
                        <td>
                            <img width="50" src="<?= uploads($single['image']) ?>">
                        </td>
                        <td class="news_title"><?= $single['title']; ?></td>
                        <td class="news_desc"><?= $single['description']; ?></td>
                        <td class="news_date"><?= date('d-m-Y',strtotime($single['issue_date'])); ?></td>
                        <td>
                            <button type="button" class="btn btn-sm btn-primary update-news" data-del_img="<?= $single['image']?>" data-news_id="<?= $single['id'] ?>" data-bs-toggle="modal" data-bs-target="#exampleModal">Update</button>
                            <?= '<form method="POST">
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

<script>
    $('.update-news').click(function() {
        let room_id = $(this).data('news_id');
        let del_img = $(this).data('del_img');
        let tr = $(this).closest('tr');
        let news_title = tr.find('.news_title').html();
        let news_desc = tr.find('.news_desc').html();
        let news_date = tr.find('.news_date').html();
        $('#room-num').val(room_title);
        $('#room-pre').val(room_title);
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

    function del_img(img_id, image) {
        $.ajax({
            url: 'ajax/room.php',
            type: 'post',
            data: {
                img_delete: 1,
                id: img_id,
                image: image
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