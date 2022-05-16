<?php 
session_start();
include_once 'config/vSessao.php'; 
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="stylesheet" href="css/home.css">
    <link rel="stylesheet" href="css/temp.css">
    <link rel="stylesheet" href="css/main.css">
    <title>Home</title>
    <script src="/js/home.js" type="text/javascript"></script>
</head>

<body>

<?php include_once 'ads/loader.php'; ?>
<?php include_once 'ads/navbar.php'; ?>

<div class="banner">
    <div id="banner" class="banner__select"></div>
    <!-- <div class="border__grd--top"></div> -->
    <!-- <div class="border__grd--bottom"></div> -->
</div>

<div id="container__service" class="container__service"></div>


<script type='text/javascript'>
<?php
$lista = array(
    array('nome'=>"Tnt",'link'=>"/img/banner/galinha.jpg"),
    array('nome'=>"HBO Max",'link'=>"/img/banner/hbomax.jpg"),
    array('nome'=>"HBO Max",'link'=>"/img/banner/looke.jpg"),
    array('nome'=>"HBO Max",'link'=>"/img/banner/ubook.jpg"),
    array('nome'=>"HBO Max",'link'=>"/img/banner/hube.jpg"),
    array('nome'=>"HBO Max",'link'=>"/img/banner/deezer.jpg"),
    array('nome'=>"HBO Max",'link'=>"/img/banner/ritualfit.jpg"),
    array('nome'=>"HBO Max",'link'=>"/img/banner/supercomics.jpg")
);
$js_array = json_encode($lista);
echo "var servico = ". $js_array . ";\n";
?>

<?php
$lista = array(
    array('nome'=>"HBO Max",'link'=>"/img/banner/hbomax.jpg"),
    array('nome'=>"HBO Max",'link'=>"/img/banner/looke.jpg"),
    array('nome'=>"HBO Max",'link'=>"/img/banner/ubook.jpg")
);
$js_array = json_encode($lista);
echo "var myservice = ". $js_array . ";\n";
?>

createCategoriaService(myservice,'Meus Serviços');
createCategoriaService(servico,'destaque');

</script>

</body>
</html>

