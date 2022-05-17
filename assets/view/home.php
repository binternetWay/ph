<?php 
session_name(md5('ph_primario'.$_SERVER['REMOTE_ADDR'].$_SERVER['HTTP_USER_AGENT']));
session_start();

$hash = md5($_SESSION['nome'].date('l jS \of F Y'));

if ($hash != $_SESSION['token']) {
    header('Location: logout');
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

<?php include_once '../includes/loader.php'; ?>
<?php include_once '../includes/navbar.php'; ?>

<div class="banner"><div id="banner" class="banner__select"></div></div>
<div id="container__service" class="container__service"></div>

<div id="shop" class="bg__popup" style="display: none;">
<div class="container__shop">
    <div id="close" class="shop__box--top"><i class="fa-solid fa-xmark"></i></div>
    <div class="shop__box--img" id="shop__box--img"></div>
    <div class="shop__box--info">
        <div class="info__line">
            <span class="info__name">Nome Serviço:</span>
            <span id="name__service" class="info">HBO Max</span>
        </div>
        <div class="info__line">
            <span class="info__name">Data de Inicio:</span>
            <span id="inicio__service" class="info">17/05/2022</span>
        </div>
        <div class="info__line">
            <span class="info__name">Data de Final:</span>
            <span id="fim__service" class="info">16/06/2022</span>
        </div>
        <div class="info__line">
            <span class="info__name">Valor do Serviço:</span> 
            <span id="valor__service" class="info">R$ 16,90</span>
        </div>
        <div class="info__line">
            <span class="info__name">Valor da Proxima fatura:</span> 
            <span id="valorTotal__service" class="info">R$ 116,80</span>
        </div>
    </div>
    <div class="shop__box--buttom"><button class="btn__contratar" type="submit">Confirmar Plano</button></div>
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

