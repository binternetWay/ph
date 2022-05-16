<?php
session_start();
include_once 'conexao.php';

if (empty($_POST['usuario']) || empty($_POST['senha'])){
    header('Location: /login.php');
    exit();
}

$usuario = mysqli_real_escape_string($conexao, $_POST['usuario']);
$senha = mysqli_real_escape_string($conexao, $_POST['senha']);
$query = "SELECT usuario FROM usuario WHERE usuario = '{$usuario}' AND senha = '{$senha}';";
$resultado = mysqli_query($conexao, $query);
$row = mysqli_num_rows($resultado);

if($row == 1){
    $_SESSION['usuario'] = $usuario;
    header('Location: /home.php');
} else {
    $_SESSION['nao_autenticado'] = true;
    header('Location: /login.php');
}
?>