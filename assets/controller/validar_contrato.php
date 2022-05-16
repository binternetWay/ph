<?php

require_once '../modal/PDO_Voalle.php';
require_once '../modal/PDO_Conexao.php';
require_once '../modal/Contratos.php';

session_name(md5('ph_primario'.$_SERVER['REMOTE_ADDR'].$_SERVER['HTTP_USER_AGENT']));
session_start();

if (isset($_POST['search']) && isset($_POST['cpf'])) {
    $v = PDO_Conexao::getInstance()->prepare("SELECT * FROM usuario WHERE cpf = :cpf");

    $v->execute(array(':cpf' => $_POST['cpf']));

    if ($v->rowCount() > 0) {
        $_SESSION['parametro'] = md5("seu pai de calcinha");
        $_SESSION['cpf'] = $_POST['cpf'];
        header('Location: login');
    }
    else
        echo "Include de usuario";
        $_SESSION['parametro'] = md5("seu pai de calcinha");
        $_SESSION['cpf'] = $_POST['cpf'];
        header('Location: login');
}
else
    header('Location: logout');

