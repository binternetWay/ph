<?php

session_name(md5('ph_primario'.$_SERVER['REMOTE_ADDR'].$_SERVER['HTTP_USER_AGENT']));
session_start();

if (isset($_POST['s_contrato']) && isset($_POST['contrato'])) {
    $_SESSION['contrato'] = $_POST['contrato'];
    $_SESSION['token'] = md5($_SESSION['nome'].date('l jS \of F Y'));

    $_SESSION['tipo_contrato'] = 'RT';
    $_SESSION['codigo_plano'] = '150.2022';
    
    header('Location: /ph/painel');
}
else
    header('Location: /ph/logout');

