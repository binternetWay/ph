<?php

session_name(md5('ph_primario'.$_SERVER['REMOTE_ADDR'].$_SERVER['HTTP_USER_AGENT']));
session_start();

require_once "../modal/PDO_Conexao.php";
require_once "../modal/Usuario.php";

$token = md5($_SESSION['nome'].date('l jS \of F Y'));

if ($_SESSION['token'] != $token) {
    header('Location: logout');
}

if (isset($_SESSION['protocolo']) && $_SESSION['protocolo'] != false) {
    # code...
}
?>
<!DOCTYPE html>
<html lang="pt-PT">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- Importação de fonte -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    
    <link rel="stylesheet" href="assets/css/login.css">
    <link rel="stylesheet" href="assets/css/main.css">
    <link rel="stylesheet" href="assets/css/planos.css">
    <title>Planos</title>
</head>

<body>
    <?php include_once '../includes/loader.php'?>
    <div class="popup__notificacao" id="popup__notificacao">
        <div class="notificacao">
            <span class="texto__notificacao">Seu protocolo foi aberto!<br> Liberamos para você um acesso provisório.  <br> Numero do protocolo:&nbsp;<span class="protocolo" id="protocolo"></span></span>
            <a class="btn__login--protocolo" href="/ph/logout">Login</a>
        </div>
    </div>

    <div id="popup" class="popup__select" style="display: none;">
        <div class="container__confirmacao">
            <div id="close" class="popup__box--top"><i class="fa-solid fa-xmark"></i></div>
            <div class="popup__box--title"><span class="title__popup">Novo Plano</span></div>
            <div class="info__newPlano">
                <div class="info__line"><span>Velocidade:</span><span id="velocidade"></span></div>
                <div class="info__line"><span>Valor:</span><span id="valor_plano"></span></div>
                <div class="info__line--center"><span>Benefícios</span></div>
                <div class="info__line--center" id="benef" style="margin-top: 25px;"></div>
            </div>
            <form class="form__conf" action="alterar_plano" method="POST">
                <div class="popup__box--title" style="margin-top: 25px;"><span class="title__popup">Confirmação</span></div>
                <div class="popup__box--mid">
                    <input type="checkbox" required>
                    <label class="text__confirmacao">Declaro estar ciente sobre a Alteração do Plano realizado, bem como, observância da fidelidade de 12 meses. Concordo com as cláusulas e condições do novo <a href="#">Termo de Adesão.</a></label>
                </div>
                <input type="hidden" value="2022.750" name="cod_plano" id="cod_plano">
                <div class="btn__line">
                    <button class="btn btn__nao" type="submit">não</button>
                    <button class="btn btn__sim" type="submit" name="alterar_plano">SIM</button>
                </div>
            </form>
        </div>
    </div>
    <svg class="login__page-wave" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1440 320">
        <path class="wave1" fill-opacity="1" d="M0,128L48,117.3C96,107,192,85,288,85.3C384,85,480,107,576,133.3C672,160,768,192,864,218.7C960,245,1056,267,1152,261.3C1248,256,1344,224,1392,208L1440,192L1440,0L1392,0C1344,0,1248,0,1152,0C1056,0,960,0,864,0C768,0,672,0,576,0C480,0,384,0,288,0C192,0,96,0,48,0L0,0Z"></path>
        <path class="wave2" fill-opacity="0.6" d="M0,256L21.8,266.7C43.6,277,87,299,131,293.3C174.5,288,218,256,262,250.7C305.5,245,349,267,393,261.3C436.4,256,480,224,524,213.3C567.3,203,611,213,655,218.7C698.2,224,742,224,785,202.7C829.1,181,873,139,916,133.3C960,128,1004,160,1047,154.7C1090.9,149,1135,107,1178,106.7C1221.8,107,1265,149,1309,170.7C1352.7,192,1396,192,1418,192L1440,192L1440,0L1418.2,0C1396.4,0,1353,0,1309,0C1265.5,0,1222,0,1178,0C1134.5,0,1091,0,1047,0C1003.6,0,960,0,916,0C872.7,0,829,0,785,0C741.8,0,698,0,655,0C610.9,0,567,0,524,0C480,0,436,0,393,0C349.1,0,305,0,262,0C218.2,0,175,0,131,0C87.3,0,44,0,22,0L0,0Z"></path>
    </svg>
    <div class="principal__container">
        <div class="container__login">
            <div class="container__login-top">
                <div class="logo"><img class="logo__img-white" src="https://www.internetway.com.br/assets/img/whiteLogo.svg" alt="logo com a escrita internet way"></div>
                <div class="logo"><img class="logo__img-black" src="assets/img/logo/bLogo.png" alt="logo com a escrita internet way"></div>
            </div>
            <div class="container__login--mid_msg">
                <span class="msg1">Ops...!</span>
                <span class="msg2">Parece que esse contrato inda não tem um plano compativel com a plataforma de streaming!</span>
            </div>
            
            
            <div class="container__login--mid_title"><span class="title__processo">Escolha o melhor para você:</span></div>
            <div class="container__login-mid_alter">
                <div id="arLeft" class="arLeft"><i class="fa-solid fa-angle-left"></i></div>

                <div id="container__plano" class="container__plano"></div>

                <div id="arRight" class="arRight"><i class="fa-solid fa-angle-left"></i></div>
            </div>
            
            <script>
            <?php
            $x = new Usuario($_SESSION['cpf']);
                $stmt = PDO_Conexao::getInstance()->prepare("SELECT velocidade, preco, servico_minimo,
                                MAX(servico1) AS servico1,
                                MAX(servico2) AS servico2,
                                MAX(servico3) AS servico3,
                                MAX(servico4) AS servico4
                                
                                FROM(SELECT 
                                plano.velocidade, 
                                plano.preco,
                                '0.00' AS servico_minimo,
                                CASE WHEN categoria_id = 1 THEN categoria.src_img ELSE ' ' END AS servico1,
                                CASE WHEN categoria_id = 2 THEN categoria.src_img ELSE ' ' END AS servico2,
                                CASE WHEN categoria_id = 3 THEN categoria.src_img ELSE ' ' END AS servico3,
                                CASE WHEN categoria_id = 4 THEN categoria.src_img ELSE ' ' END AS servico4
                                
                                FROM preco
                                LEFT JOIN categoria ON categoria.id = preco.categoria_id
                                LEFT JOIN plano ON plano.id = preco.cod_plano_id
                                WHERE tipo_contrato = 'FD'
                                AND preco >= :preco
                                AND qtd_free > 0) AS analitico
                                GROUP BY velocidade, preco, servico_minimo
                                ORDER BY preco");

                $stmt->execute(array(':preco' => $x->getValorContrato()));

                $planos = $stmt->fetchAll(PDO::FETCH_ASSOC);
                
                $lista = json_encode($planos,true);
                echo "var lista_planos = ". $lista .";\n";
            ?>
            </script>



            <div class="container__login-buttom">
                <i class="fa-brands fa-whatsapp"></i>
                <span>Fale Conosco</span>
            </div>
        </div>
    </div>
    <script>
        var jsProtocolo = '<?php echo $_SESSION['protocolo']?>';
    </script>
    <svg class="login__page-wave" style="bottom: 0;" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1440 320">
        <path class="wave1" fill-opacity="0.5" d="M0,32L60,64C120,96,240,160,360,181.3C480,203,600,181,720,149.3C840,117,960,75,1080,80C1200,85,1320,139,1380,165.3L1440,192L1440,320L1380,320C1320,320,1200,320,1080,320C960,320,840,320,720,320C600,320,480,320,360,320C240,320,120,320,60,320L0,320Z"></path>
    </svg>
</body>

<!-- page JS -->
<?php include_once '../includes/jsPadrao.php' ?>
<script src="assets/js/planos.js"></script>
</html>
