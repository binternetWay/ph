<?php

require_once '../modal/PDO_Voalle.php';
require_once '../modal/Contratos.php';

session_name(md5('ph'.$_SERVER['REMOTE_ADDR'].$_SERVER['HTTP_USER_AGENT']));
session_start();

if (isset($_POST['search']) && isset($_POST['cpf'])) {
    $v = PDO_Voalle::getInstance()->prepare(Contratos::get_contratos());
    $cpf = preg_replace('/[\@\.\;\/" "-]+/ ', '', $_POST['cpf']);

    $v->execute(array(':cpf' => $cpf));
    
    if ($v->rowCount() == 1) {
        $contrato = $v->fetchAll(PDO::FETCH_ASSOC)[0]['numero_contrato'];
        $_SESSION['token'] = md5(date('l jS \of F Y').md5($contrato));
        $_SESSION['cpf'] = $_POST['cpf'];
        $_SESSION['contrato'] = $contrato;
        
        header('Location: ../view/streaming.php?cod='.md5($contrato));
    }
    elseif ($v->rowCount() > 1) {
        $_SESSION['token'] = md5(date('l jS \of F Y')).md5($cpf);
        $_SESSION['cpf'] = $cpf;
        
        header('Location: ../view/usuarios.php?cod='.md5($cpf));
    }
    else
        header('Location: logout');
}
else
        header('Location: logout');

