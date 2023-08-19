<?php require_once 'layout/user/header.php';?>

<?php $content = single_data($db,'webcontent')?>


<div class="row">
    <div class="col-md-12">
        <img src="<?= uploads($content['main_image'])?>" class="w-100" />
    </div>
    <div class="col-md-12">
        <h1><?= $content['title']?></h1>
        <p><?= $content['description']?></p>
    </div>
    <div class="col-md-4">
        <img src="<?= uploads($content['sup_image']) ?>" class="img-fluid" />
        <h3><?= $content['sup_name']?></h3>
    </div>
    <div class="col-md-8">
        <p><?= $content['sup_message']?></p>
    </div>
</div>



<?php require_once 'layout/user/footer.php' ;?>

<script>
    document.title = "Rms home";
</script>