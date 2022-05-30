<?php

require_once "../modal/PlayHub.php";

session_name(md5('ph_primario'.$_SERVER['REMOTE_ADDR'].$_SERVER['HTTP_USER_AGENT']));
session_start();

if (isset($_POST['cod__servico'])) {
    
    $usuario = $_SESSION['cpf'];

    $produto = $_POST['cod__servico'];
    $ph = new PH();

    $playhub = $ph->inscrever($produto, 'reginaldo.silva');
    $bd = $ph->insertar_inscricao($_POST['cod__servico']);

    if ($bd == false) {
        header('Location: /logout');
    }


}

header('Location: /ph/painel');