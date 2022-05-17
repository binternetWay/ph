<?php 
session_name(md5('ph_primario'.$_SERVER['REMOTE_ADDR'].$_SERVER['HTTP_USER_AGENT']));
session_start();

if (!password_verify(password_hash(md5(date('l jS \of F Y')), PASSWORD_DEFAULT), $_SESSION['token'])) {
    //header('Location: logout');
}
 
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="stylesheet" href="assets/css/home.css">
    <link rel="stylesheet" href="assets/css/main.css">
    <title>Home</title>
    <script src="assets/js/home.js" type="text/javascript"></script>
</head>

<body>

<?php include_once 'assets/includes/loader.php'; ?>
<?php include_once 'assets/includes/navbar.php'; ?>

<div class="banner">
    <div id="banner" class="banner__select"></div>
    <!-- <div class="border__grd--top"></div> -->
    <!-- <div class="border__grd--bottom"></div> -->
</div>

<div id="container__service" class="container__service"></div>

<div id="shop" class="bg__popup" style="display: none;">
<div class="container__shop">
    <div id="close" class="shop__box--top"><i class="fa-solid fa-xmark"></i></div>
    <div class="shop__box--img" id="shop__box--img"></div>
</div>
</div>

<script type='text/javascript'>
<?php
$lista = array(
    array('nome'=>"Tnt",'link'=>"assets/img/banner/galinha.jpg"),
    array('nome'=>"HBO Max",'link'=>"assets/img/banner/hbomax.jpg"),
    array('nome'=>"HBO Max",'link'=>"assets/img/banner/looke.jpg"),
    array('nome'=>"HBO Max",'link'=>"assets/img/banner/ubook.jpg"),
    array('nome'=>"HBO Max",'link'=>"assets/img/banner/hube.jpg"),
    array('nome'=>"HBO Max",'link'=>"assets/img/banner/deezer.jpg"),
    array('nome'=>"HBO Max",'link'=>"assets/img/banner/ritualfit.jpg"),
    array('nome'=>"HBO Max",'link'=>"assets/img/banner/supercomics.jpg")
);
$js_array = json_encode($lista);
echo "var servico = ". $js_array . ";\n";
?>

<?php
$lista = array(
    array('nome'=>"HBO Max",'link'=>"assets/img/banner/hbomax.jpg"),
    array('nome'=>"HBO Max",'link'=>"assets/img/banner/looke.jpg"),
    array('nome'=>"HBO Max",'link'=>"assets/img/banner/ubook.jpg")
);
$js_array = json_encode($lista);
echo "var myservice = ". $js_array . ";\n";
?>

createCategoriaService(myservice,'Meus Serviços');
createCategoriaService(servico,'destaque');
document.getElementById('close').onclick = function get (){openShop();}
</script>

</body>
</html>

