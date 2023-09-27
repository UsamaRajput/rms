<?php require_once 'layout/admin/header.php';?>
<?php include_once 'layout/admin/sidebar.php';?>

<?php 
$user_count = all_data($db,'users','',true);
$room_count = all_data($db,'rooms','',true);
?>
<head>
    <link rel="icon" href="<?= assets('favicon.png', 2) ?>">
    <script src="https://kit.fontawesome.com/b3cac23527.js" crossorigin="anonymous"></script>
    <meta name="viewport content=width-device-width, initial-scale-1.0">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400&display=swap" rel="stylesheet">


</head>


    <div class="Box">
        <button class="button2">
            <div class="ba"> <i class="fa fa-bar-chart" aria-hidden="true"></i> </div> DASHBOARD
        </button>
        <button class="button">
            <div class="ba">
                <i class="fa fa-users" aria-hidden="true"></i>
            </div> TOTAL CANDIDATE <span><?= $user_count?></span>
        </button>
        <br> <br><br>
        <Button class="button1">
            <div class="ba"> <i class="fa fa-bed" aria-hidden="true"></i> </div> TOTAL ROOMS 
            <span><?= $room_count?></span>
            <br>
        </Button>
    </div>
<?php require_once 'layout/admin/footer.php' ;?>