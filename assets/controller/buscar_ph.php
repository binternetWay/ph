<?php

require_once "../modal/PDO_Conexao.php";
require_once "../modal/PDO_Voalle.php";
require_once "../modal/PlayHub.php";

$ph = new PH();

echo "<pre>";
session_name(md5('ph_primario'.$_SERVER['REMOTE_ADDR'].$_SERVER['HTTP_USER_AGENT']));
session_start();

var_dump($_SESSION);
//var_dump($ph->buscar_inscricao('tarzan.carteiro'));