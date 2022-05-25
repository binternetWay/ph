<?php

require_once "../modal/PDO_Conexao.php";
require_once "../modal/PDO_Voalle.php";
require_once "../modal/PlayHub.php";

$ph = new PH();

echo "<pre>";
var_dump($ph->buscar_usuario('tarzan.carteiro'));