<?php
session_name(md5('ph_primario'.$_SERVER['REMOTE_ADDR'].$_SERVER['HTTP_USER_AGENT']));
session_start();

$token = md5(uniqid(rand(), true));
$_SESSION['csrf'] = $token;
?>

<!DOCTYPE html>
<html lang="pt-PT">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <!-- Toast CSS -->
    <link href="assets/build/toastr.css" rel="stylesheet">
    
    <!-- Importação de fonte -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    
    <link rel="stylesheet" href="assets/css/login.css">
    <link rel="stylesheet" href="assets/css/main.css">

    <style>
        .container__login {
            width: 40%;
            height: 80%;
            max-width: 400px;
            max-height: 490px;
        }
    </style>
    
    <title>Login</title>
</head>

<body>
    <?php include_once '../includes/loader.php'; ?>
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
            <div class="container__login-mid">
                <div class="form__logins">
                    <form method="POST" action="editar_senha">

                        <div class="form__line">
                            <i class="fa-solid fa-user"></i>
                            <input type="text" id="cpf" name="cpf" value="<?= @$_SESSION['cpf'] ?>" placeholder="Digite seu CPF" required="required"/>
                        </div>

                        <div class="form__line">
                            <i class="far fa-calendar-alt"></i>
                            <input type="date" id="data" name="data" placeholder="Data de nascimento" required="required" />
                        </div>

                        <div class="form__line">
                            <i class="fas fa-file-contract"></i>
                            <input type="number" id="contrato" name="contrato" placeholder="Contrato" required="required" />
                        </div>

                        <div class="form__line">
                            <i class="fa-solid fa-key"></i>
                            <input type="password" id="senha" name="senha" placeholder="Senha" required="required" />
                        </div>
                        
                        <div class="form__line">
                            <i class="fa-solid fa-key"></i>
                            <input type="password" id="c_senha" name="c_senha" placeholder="Confirme a senha" required="required" />
                        </div>

                        <div class="form__line">
                            <button type="submit" name="salvar" id="salvar">Salvar</button>
                        </div>
                        <input type="hidden" name="csrf" value="<?= $token ?>" />

                    </form>
                </div>
            </div>
            <div class="container__login-buttom">
                <i class="fa-brands fa-whatsapp"></i>
                <span>Fale Conosco</span>
            </div>
        </div>
    </div>
    <svg class="login__page-wave" style="bottom: 0;" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1440 320">
        <path class="wave1" fill-opacity="0.5" d="M0,32L60,64C120,96,240,160,360,181.3C480,203,600,181,720,149.3C840,117,960,75,1080,80C1200,85,1320,139,1380,165.3L1440,192L1440,320L1380,320C1320,320,1200,320,1080,320C960,320,840,320,720,320C600,320,480,320,360,320C240,320,120,320,60,320L0,320Z"></path>
    </svg>
</body>
<script src="assets/build/toastr.min.js"></script>

<script>
var primSenha = document.getElementById('senha');
var segSenha = document.getElementById('c_senha');
var btn = document.getElementById('salvar');

function validePass () {
    if (primSenha.value != '' && segSenha.value != ''){
        if (primSenha.value == segSenha.value){
            primSenha.style = "border: 3px solid var(--main-sucesse);";
            segSenha.style = "border: 3px solid var(--main-sucesse);";
            btn.disabled = false;
        } else {
            primSenha.style = "border: 3px solid var(--main-danger);";
            segSenha.style = "border: 3px solid var(--main-danger);";
            btn.disabled = true;
        }
    }
}
primSenha.onchange = function get() {validePass()};
segSenha.onchange = function get() {validePass()};
</script>

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

  <?php if (isset($_SESSION['msg']) && $_SESSION['msg'] == 'erro_usuario'): ?>
    toastr.warning("Erro, usuário ou senha incorreta!");
  <?php endif ?>

  <?php if (isset($_SESSION['msg']) && $_SESSION['msg'] == 'cadastro_realizado'): ?>
    toastr.success("Usuário cadastrado com sucesso!");
  <?php endif ?>


  <?php $_SESSION['msg'] = null; ?>

</script>	

<!-- page JS -->
<?php include_once '../includes/jsPadrao.php' ?>
</html>


