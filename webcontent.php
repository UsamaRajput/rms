<?php require_once 'layout/admin/header.php'; ?>
<?php include_once 'layout/admin/sidebar.php'; ?>
<?php
$content = single_data($db, 'webcontent'); 

if(isset($_POST['update']) && !empty($_POST['update']))
{
    $params = $_POST;
    if(isset($_FILES['sup_image']) && !empty($_FILES['sup_image'])){
        $params['sup_image'] = file_upload('images/web',$_FILES['sup_image'],$params['old_sup_img']);
        unset($params['old_sup_img']);
    }
    if(isset($_FILES['main_image']) && !empty($_FILES['main_image'])){
        $params['main_image'] = file_upload('images/web',$_FILES['main_image'],$params['old_main_img']);
        unset($params['old_main_img']);
    }
    unset($params['update']);
    $res = update($db,'webcontent',$params,'id = 1');
    if($res)
    {
        js_redirect();
    }else{
        js_alert('server error');
    }

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
  <form action="" method="post" enctype="multipart/form-data">
  <input type="hidden" name="old_sup_img" value="<?= $content['sup_image'] ?>">
    <input type="hidden" name="old_main_img" value="<?= $content['main_image'] ?>">
    suprident image
    <img src="<?= uploads($content['main_image']) ?>" width="50">
    <input type="file" name="main_image">
    <br>
    <input type="text" name="title" placeholder="title" value="<?= $content['title']; ?>">
    <br>
    <textarea name="description" id="" cols="30" rows="10" placeholder="description"><?= $content['description']; ?></textarea>
    <br>suprident image
    <img src="<?= uploads($content['sup_image']) ?>" width="50">
    <input type="file" name="sup_image">
    <br>
    <input type="text" name="sup_name" id="" value="<?= $content['sup_name']; ?>">
    <br>
    <textarea name="sup_message" id="" cols="30" rows="10" placeholder="message"><?= $content['sup_message']; ?></textarea>
    <br>
    <input type="submit" value="update" name="update">
  </form>

</div>
<?php require_once 'layout/admin/footer.php'; ?>