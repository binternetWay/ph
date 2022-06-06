<?php

require_once "../modal/PDO_Voalle.php";
require_once "../modal/Voalle.php";
require_once "../modal/Usuario.php";

if (isset($_POST['alterar_plano']) && isset($_POST['cod_plano'])) {

    session_name(md5('ph_primario'.$_SERVER['REMOTE_ADDR'].$_SERVER['HTTP_USER_AGENT']));
    session_start();

    $x = new Voalle();
    $y = new Usuario($_SESSION['cpf']);

    $solicitacao = $x->NovaSolicitacao($y->getNumeroCliente(), $y->getPlano(), $_POST['cod_plano'], $y->getBase(), $y->getContrato());

    if ($solicitacao != false) {
        $_SESSION['protocolo'] = $solicitacao;

        header('Location: planos');
    }
    else {
        $_SESSION['protocolo'] = '';

        header('Location: planos');
    }
}