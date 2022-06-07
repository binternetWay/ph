<?php

require_once "assets/modal/Voalle.php";
require_once "assets/modal/PDO_Voalle.php";
require_once "assets/modal/Contratos.php";
require_once "assets/modal/PlayHub.php";
require_once "assets/modal/Usuario.php";

session_name(md5('ph_primario'.$_SERVER['REMOTE_ADDR'].$_SERVER['HTTP_USER_AGENT']));
session_start();

// $c = new Voalle();
// $x = new Contratos();

// $cpf = $_SESSION['cpf'];

// $stmt = PDO_Voalle::getInstance()->prepare($x->get_contratos());

// $stmt->execute(array(':cpf' => $cpf));

// $resultado = $stmt->fetchAll(PDO::FETCH_ASSOC)[0];

// echo "<pre>";
// var_dump($resultado);

//$c->NovaSolicitacao($resultado['numero_cliente'], $resultado['numero_contrato'], $resultado['plano'], '2022.100');

$x = new Usuario('40434653861');

//var_dump($x->buscar_usuario('reginaldo.silvaa'));

var_dump($x->getContrato());
