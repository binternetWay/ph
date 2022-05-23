<?php

session_name(md5('ph_primario'.$_SERVER['REMOTE_ADDR'].$_SERVER['HTTP_USER_AGENT']));
session_start();

$token = md5($_SESSION['nome'].date('l jS \of F Y'));

if ($_SESSION['token'] != $token) {
    header('Location: logout');
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
    <title>Planos</title>
</head>

<body>
    <?php include_once '../includes/loader.php'?>

    <div id="popup" class="popup__select" style="display: none;">
        <div class="container__confirmacao">
            <div id="close" class="popup__box--top"><i class="fa-solid fa-xmark"></i></div>
            <div class="popup__box--mid"><span>Pode ser utilizado em contrato de adesão, para uma ordem de serviço ou de um termo de uso, ou ainda, na aprovação de um orçamento ou proposta comercial. É o equivalente a uma assinatura manual, mas com a facilidade do digital.</span></div>
        </div>
    </div>
    <style>
    .popup__select{
        position: absolute;
        display: flex;
        justify-content: center;
        align-items: center;

        width: 100%;
        height: 100%;
        background-color: rgba(255, 255, 255, .15);  
        backdrop-filter: blur(5px);
        z-index: 200;
    }
    .container__confirmacao{
        display: flex;
        justify-content: flex-start;
        align-items: center;
        flex-direction: column;

        width: 55%;
        height: 70%;
        max-width: 400px;
        max-height: 430px;
        padding: 20px;
        background-color: var(--bg1-default);
        border-radius: 20px;
        box-shadow: 0 4px 12px 0 rgb(35 35 35 / 16%);
        z-index: 10;
    }

    .popup__box--top{
        display: flex;
        align-items: center;

        width: 100%;
        height: 50px;
        z-index: 500;
    }

    .popup__box--top i{
        margin: 0px 11px;
        padding: 2px 7px;
        border-radius:  50%;
        font-size: 30px;
        color: var(--text-default);
        background-color: var(--main-danger);

        cursor: pointer;
        transition: 0.3s;
    }

    .popup__box--top i:hover{
        transform: scale(0.80);
        transition: 0.3s;
    }
    /* Mobile layout */
    @media only screen and (max-width: 680px) {
        .container__confirmacao{
            width: 100%;
            height: 100%;
            max-width: none;
            max-height: none;
            border-radius: 0px;
            padding: 0px 5px;
        }
    }

    </style>
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
                <span class="msg2">Parece que esse contrato inda não tem um plano compativel com a plataforma de Streaming!</span>
            </div>
            
            
            <div class="container__login--mid_title"><span class="title__processo">Escolha o melhor para você:</span></div>
            <div class="container__login-mid_alter">
                <div id="arLeft" class="arLeft"><i class="fa-solid fa-angle-left"></i></div>
                <div id="container__plano" class="container__plano"></div>
                <div id="arRight" class="arRight"><i class="fa-solid fa-angle-left"></i></div>
            </div>

            <script>
            <?php
                $planos = array(
                    array('velocidade'=>'100MB','preco'=>'69.90','sugestao'=>'0'),
                    array('velocidade'=>'150MB','preco'=>'79.90','sugestao'=>'1'),
                    array('velocidade'=>'300MB','preco'=>'89.90','sugestao'=>'0'),
                    array('velocidade'=>'500MB','preco'=>'99.90','sugestao'=>'0'),
                    array('velocidade'=>'750MB','preco'=>'189.90','sugestao'=>'0'));
                $lista = json_encode($planos,true);
                echo "var lista_planos = ". $lista . ";\n";
            ?>
            </script>

            <style>
                .container__login {
                    width: 50%;
                    height: 70%;
                    max-width: 400px;
                    max-height: 445px;
                }
                .container__login--mid_msg{
                    margin-top: 20px;
                    display: flex;
                    flex-direction: column;
                    align-items: center;
                    justify-content: center;
                    width: 100%;
                }
                .msg1{
                    color: black;
                    text-align: center;
                    padding: 0px 10px;
                    font-size: 15px;
                    font-weight: 800;
                }
                .msg2{
                    color: black;
                    text-align: center;
                    padding: 0px 30px;
                }
                .container__login--mid_title{
                    margin-top: 20px;
                }
                .title__processo{
                    font-size: 13px;
                    text-transform: uppercase;
                    font-weight: 300;
                    color: var(--bg3-default);
                }
                .container__login-mid_alter{
                    display: flex;
                    flex-direction: row;
                    width: 100%;
                }
                .container__plano{
                    display: flex;
                    flex-direction: row;
                    cursor: pointer;
                    overflow-x: auto;   

                    padding: 15px;
                    width: 100%;
                }
                .arLeft{
                    display: flex;
                    align-items: center;
                    padding: 30px 5px;
                    font-size: 20px;
                    color: var(--bg-type2);
                    cursor:pointer;
                }
                .arRight{
                    display: flex;
                    align-items: center;
                    padding: 30px 5px;
                    font-size: 20px;
                    color: var(--bg-type2);
                    transform: rotate(180deg);
                    cursor:pointer;
                }
                .select_plano{
                    display: flex;
                    justify-content: center;
                    align-items: center;
                    flex-direction: column;

                    margin: 0px 5px;
                    width: 25%;
                    min-width: 90px;
                    height: 100px;
                    border-radius:  10px;
                    border: 3px solid transparent;
                    background-color: var(--bg-type2);
                    transition: 0.3s;
                }
                .select_plano:hover{
                    transform: scale(1.05);
                    border: 3px solid var(--bg2-contracts);
                    transition: 0.3s;
                }
                .velocidade{
                    margin: 5px 0px;
                    color: var(--bg1-default);
                    font-size: 20px;
                    font-weight: 900;
                }
                .preco{
                    margin: 1px 0px;
                    color: var(--bg1-default);
                    font-size: 15px;
                    font-weight: 400;
                }
                /* Mobile layout */
                @media only screen and (max-width: 680px) {
                    .select_plano:hover{
                        border: 3px solid var(--bg1-default);
                    }
                    .container__login {
                        padding: 0px;
                        max-width: none;
                        max-height: none;
                        height: 100%;
                        width: 100%;
                    }
                    .msg1{
                        color: var(--bg1-default);
                    }
                    .msg2{
                        color: var(--bg1-default);
                    }
                }
            </style>
            <div class="container__login-buttom">
                <i class="fa-brands fa-facebook-square"></i>
                <i class="fa-brands fa-instagram-square"></i>
            </div>
        </div>
    </div>
    <svg class="login__page-wave" style="bottom: 0;" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1440 320">
        <path class="wave1" fill-opacity="0.5" d="M0,32L60,64C120,96,240,160,360,181.3C480,203,600,181,720,149.3C840,117,960,75,1080,80C1200,85,1320,139,1380,165.3L1440,192L1440,320L1380,320C1320,320,1200,320,1080,320C960,320,840,320,720,320C600,320,480,320,360,320C240,320,120,320,60,320L0,320Z"></path>
    </svg>
</body>

<!-- page JS -->
<?php include_once '../includes/jsPadrao.php' ?>
<script src="assets/js/planos.js"></script>
</html>
