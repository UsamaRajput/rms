<?php require_once 'layout/admin/header.php';?>
<?php include_once 'layout/admin/sidebar.php';?>

<?php 
$user_count = all_data($db,'users','',true);
$room_count = all_data($db,'rooms','',true);
?>

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
            <div class="ba"> <i class="fa fa-desktop" aria-hidden="true"></i> </div> TOTAL ROOMS 
            <span><?= $room_count?></span>
            <br>
        </Button>
    </div>
<?php require_once 'layout/admin/footer.php' ;?>
