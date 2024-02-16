<?php require_once 'layout/admin/header.php'; ?>
<?php include_once 'layout/admin/sidebar.php'; ?>
<?php
$news = all_data($db, 'news');
if (isset($_POST['add_news'])) {
    $exists = all_data($db, 'news', " type =  1 ", true);
    if ($exists > 0) {
        js_alert('Notis can only be one please remove first notis');
    } else {
        unset($_POST['add_news']);
        if (isset($_FILES['image']) && !empty($_FILES['image'])) {
            $_POST['image'] = file_upload('images/news', $_FILES['image']);
        }
        $res = insert($db, 'news', $_POST);
        if ($res) {
            js_alert('News added successfully');
            js_redirect('news.php');
        } else {
            js_alert('Server error');
        }
    }
}

if (isset($_POST['field'])) {
    $data = [$_POST['field'] => $_POST['val']];
    update($db, 'news', $data, ' id = ' . $_POST['id']);
    js_redirect('news.php');
}

if (isset($_POST['update_news'])) {
    $exists = all_data($db, 'news', " type = 1 AND id <> " . $_POST['news_id'], true);

    if ($exists > 0) {
        js_alert('Notis can only be one please remove first notis!');
    } else {
        $id = $_POST['news_id'];
        $del_img = $_POST['del_img'];
        unset($_POST['update_news'], $_POST['news_id'], $_POST['del_img']);
        if (isset($_FILES['image']) && !empty($_FILES['image'])) {
            $_POST['image'] = file_upload('images/news', $_FILES['image'], $del_img);
        }
        $res = update($db, 'news', $_POST, ' id = ' . $id);
        if ($res) {
            js_alert('News updated successfully');
            js_redirect('news.php');
        } else {
            js_alert('Server error');
        }
    }
}

if (isset($_POST['delete'])) {
    delete_file('uploads/' . $_POST['delete_img']);
    del_data($db, 'news', $_POST['id']);
    js_redirect('news.php');
}

?>

<div class="modal fade" id="myModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Update News</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form method="post" enctype="multipart/form-data">
                <div class="modal-body">
                    <input type="hidden" name='news_id' class="form-control" id="news-id">
                    <!-- <input type="hidden" name='pre_title' class="form-control" id="news-pre"> -->
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
                        <label for="news-type" class="col-form-label">News type:</label>
                        <select name="type" id="news-type" class="form-control">
                            <option value="0">News</option>
                            <option value="1">Clip</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="news-img" class="col-form-label">News Image:</label>
                        <input type="file" name="image" class="form-control">
                    </div>
                    <div class="mb-3">
                        <img src="" id="news-img" alt="">
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
            <textarea value="<?= $_POST['description'] ?? '' ?>" name="description" placeholder="News Description"><?= $_POST['description'] ?? '' ?></textarea>
            <input type="date" value="<?= $_POST['issue_date'] ?? '' ?>" name="issue_date">
            <select name="type">
                <option <?= $_POST['type'] ?? '' == 0 ? 'selected' : '' ?> value="0">News</option>
                <option <?= $_POST['type'] ?? '' == 1 ? 'selected' : '' ?> value="1">Clip</option>
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
                    <th>Type</th>
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
                        <td class="news_date"><?= date('d-m-Y', strtotime($single['issue_date'])); ?></td>
                        <td class="type">
                            <select name="type" class="type-change" data-id="<?= $single['id'] ?>">
                                <option <?= $single['type'] == 0 ? 'selected' : '' ?> value="0">News</option>
                                <option <?= $single['type'] == 1 ? 'selected' : '' ?> value="1">Clip</option>
                            </select>
                        </td>
                        <td>
                            <button type="button" class="btn btn-sm btn-primary update-news" data-news_id="<?= $single['id'] ?>">Update</button>
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
                                <input type="submit" value="De Active" class="btn btn-sm btn-danger ">
                            </form>';
                            }
                            ?>
                            <?= '<form method="POST">
                                <input type="hidden" name="id" value="' . $single['id'] . '">
                                <input type="hidden" name="delete_img" value="' . $single['image'] . '">
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
    var myModal = new bootstrap.Modal(document.getElementById('myModal'), {
        keyboard: false
    })
    // fetch news data 
    $('.update-news').click(function() {
        let news_id = $(this).data('news_id');
        $.ajax({
            url: 'ajax/news.php',
            type: 'post',
            data: {
                fetch_news: 1,
                news_id: news_id
            },
            success: function(res) {
                if (res != 'null') {
                    let news = JSON.parse(res);
                    $('#news-id').val(news.id);
                    $('#news-delimg').val(news.image);
                    $('#news-img').attr('src', 'uploads/' + news.image);
                    $('#news-title').val(news.title);
                    $('#news-desc').val(news.description);
                    $('#news-date').val(news.issue_date);
                    $('#news-type').val(news.type);
                    myModal.show()
                } else {
                    alert('Something wrong');
                }

            }
        });
    });

    $('.type-change').change(function() {
        let type = $(this).val();
        let news_id = $(this).data('id');
        $.ajax({
            url: 'ajax/news.php',
            type: 'post',
            data: {
                action_news: 1,
                news_id: news_id,
                type: type
            },
            success: function(res) {
                if (res == 2) {
                    $(this).val(0);
                    alert('clip news already exist');
                } else if (res == 'true') {
                    alert('news updated')
                } else {
                    alert('server error')
                }
            }
        })
    });
</script>
