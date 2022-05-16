<?php
session_name(md5('ph'.$_SERVER['REMOTE_ADDR'].$_SERVER['HTTP_USER_AGENT']));
session_start();

if (!isset($_REQUEST['cod']) || $_SESSION['token'] != md5(date('l jS \of F Y').$_REQUEST['cod'])) {
    header('Location: ../../index.php');
}

?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="stylesheet" href="../css/home.css">
    <link rel="stylesheet" href="../css/temp.css">
    <link rel="stylesheet" href="../css/main.css">
    <title>Streaming</title>
</head>

<body>
<?php include_once '../includes/loader.php'; ?>
<?php include_once '../includes/navbar.php'; ?>

<div class="banner__select">
    <div class="border__grd--top"></div>
    <div class="border__grd--bottom"></div>
</div>

<div class="container__service">


    <div  class="container__categoria">
        <div class="cetegoria__name">Destaques</div>
        <div id="cat1" class="service__list">
            <div class="service_item">
                <img src="../img/banner/tnt.jpg" alt="">
            </div>
            <div class="service_item">
                <img src="../img/banner/hbomax.jpg" alt="">
            </div>
            <div class="service_item">
                <img src="../img/banner/deezer.jpg" alt="">
            </div>
        </div>
    </div>
    
   
    <div class="service_item">
        <img src="../img/banner/hube.jpg" alt="">
    </div>
    <div class="service_item">
        <img src="../img/banner/looke.jpg" alt="">
    </div>
    <div class="service_item">
        <img src="../img/banner/ubook.jpg" alt="">
    </div>
</div>


<div class="container__app">
</div>


</body>
<script src="../js/home.js" type="text/javascript"></script>
</html>

