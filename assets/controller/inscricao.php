<?php

require_once "assets/modal/PlayHub.php";

session_name(md5('ph_primario'.$_SERVER['REMOTE_ADDR'].$_SERVER['HTTP_USER_AGENT']));
session_start();

if (condition) {
    
    $usuario = $_SESSION['cpf'];

    $produto = $_POST['cod__servico'];

    $ph = new PH();

    $ph->inscrever($produto, $usuario);

}
