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
<div id="container__shop" class="container__shop">
    <div id="close" class="shop__box--top"><i class="fa-solid fa-xmark"></i></div>
    <div class="shop__box--img" id="shop__box--img"></div>

<?php 
    $retorno = 0;
    if ($retorno == 1) {
        $voucher = '<div class="retorno__playhub">
                        <div class="retorno__line">
                            <span class="retorno__line--name">Voucher:</span>
                            <span class="retorno__line--voucher">123456</span>
                            <button class="retorno__line--btn" type="submit">Copiar Voucher</button>
                        </div>
                    </div>';
        $btn_aderir = '';

    } else {
        $voucher = '';
        $btn_aderir = '<form method="POST" action="assets/controller/inscricao.php">
                            <input name="cod__servico" id="cod__servico"type="hidden"></input>
                            <div class="shop__box--buttom"><button class="btn__contratar" type="submit">Confirmar Plano</button></div>
                        </form>';
    }

?>
    <?php echo $voucher ?>
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
        <div class="info__line">
            <span class="info__name">Valor do Serviço:</span> 
            <span id="valor__service" class="info"></span>
        </div>
        
        <div class="info__title"><span class="title"></span></div>
        <div class="info__title"><span class="title"></span></div>
        <div class="info__title"><span class="title">Informações da fatura</span></div>
        <div class="info__title"><span class="title"></span></div>

        <div class="info__line">
            <span class="info__name">Vencimento da Fatuta:</span> 
            <span id="dtProxFatura" class="info">10/06/2022</span>
        </div>

        <div class="info__line">
            <span class="info__name">Valor da Proxima fatura:</span> 
            <span id="valorTotal__service" class="info">R$ 116,80</span>
        </div>
    </div>
    <?php echo $btn_aderir ?>

</div>
</div>

<script src="assets/js/painel.js"></script>

</body>
</html>

