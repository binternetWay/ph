<?php 
session_name(md5('ph_primario'.$_SERVER['REMOTE_ADDR'].$_SERVER['HTTP_USER_AGENT']));
session_start();

$hash = md5($_SESSION['nome'].date('l jS \of F Y'));

if ($hash != $_SESSION['token'] || !isset($_SESSION['contrato'])) {
    header('Location: logout');
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- Toast CSS -->
    <link href="assets/build/toastr.css" rel="stylesheet">

    <link rel="stylesheet" href="assets/css/home.css">
    <link rel="stylesheet" href="assets/css/main.css">
    <title>Home</title>
    <script src="assets/js/home.js" type="text/javascript"></script>
</head>

<body>

<?php include_once '../includes/loader_home.php'; ?>
<?php include_once '../includes/navbar.php'; ?>

<div class="banner"><div id="banner" class="banner__select"></div></div>
<div id="container__service" class="container__service"></div>

<div id="shop" class="bg__popup" style="display: none;">
<div id="container__shop" class="container__shop">
    <div id="close" class="shop__box--top"><i class="fa-solid fa-xmark"></i></div>
    <div class="shop__box--img" id="shop__box--img"></div>

    <div id="voucher" class="retorno__playhub" style="display: none;">
        <div class="retorno__line">
            <span class="retorno__line--name">Instruções de ativação:</span>
            <input id="retorno__voucher"class="retorno__line--voucher" value="" disabled="disabled" type="hidden">
            <a style="width: 100%;" id="link__tutorial" href=""><button id="click__copy" class="retorno__line--btn" onclick="clickCopy()" type="submit">Tutorial</button></a>
        </div>
    </div>

    <div class="shop__box--info">
        <div class="info__title"><span class="title">Informações do serviço</span></div>
        <div class="info__title"><span class="title"></span></div>

        <div class="info__line">
            <span class="info__name">Nome Serviço:</span>
            <span id="name__service" class="info"></span>
        </div>
        <div class="info__line">
            <span class="info__name">Data de Inicio:</span>
            <span id="inicio__service" class="info"></span>
        </div>
        <div class="info__line">
            <span class="info__name">Data de Final:</span>
            <span id="fim__service" class="info"></span>
        </div>
    </div>

    <form id="form_btn" method="POST" action="assets/controller/inscricao.php" style="display: none;" >
        <input name="cod__servico" id="cod__servico" type="hidden">
        <div class="shop__box--buttom"><button class="btn__contratar" type="submit">Confirmar serviço</button></div>
    </form>

</div>
</div>

<script src="assets/js/painel.js"></script>
<script src="assets/build/toastr.min.js"></script>

<script>
    toastr.options = {
    "closeButton": false,
    "debug": false,
    "newestOnTop": false,
    "progressBar": true,
    "positionClass": "toast-top-right",
    "preventDuplicates": true,
    "onclick": null,
    "showDuration": "300",
    "hideDuration": "1000",
    "timeOut": "5000",
    "extendedTimeOut": "1000",
    "showEasing": "swing",
    "hideEasing": "linear",
    "showMethod": "fadeIn",
    "hideMethod": "fadeOut"
    }

  <?php if (isset($_SESSION['msg']) && $_SESSION['msg'] == 'erro_ph'): ?>
    toastr.warning("Erro ao inserir serviço!");
  <?php endif ?>

  <?php if (isset($_SESSION['msg']) && $_SESSION['msg'] == 'erro_valor'): ?>
    toastr.warning("Erro ao adicionar servico!");
  <?php endif ?>

  <?php $_SESSION['msg'] = null; ?>
</script>

</body>
</html>

