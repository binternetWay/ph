<?php 
include_once 'conexao.php';

if(!$_SESSION['usuario']){
    header('Location: /login.php');
    exit();
}

$usuario = $_SESSION['usuario'];
$query = "SELECT id, usuario from usuario  WHERE usuario = '{$usuario}'";

$consulta = mysqli_query($conexao, $query);
if(mysqli_num_rows($consulta) > 0){
    while($linha = mysqli_fetch_assoc($consulta)){
        $usuario = $linha['usuario'];
        $id_usuario = $linha['id'];
    }
}
?>