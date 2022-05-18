<?php

if (isset($_POST['ph_confirmar']) && isset($_POST['contrato'])) {
    
    require_once '../modal/PDO_Voalle.php';
    require_once '../modal/Contratos.php';

    session_name(md5('ph'.$_SERVER['REMOTE_ADDR'].$_SERVER['HTTP_USER_AGENT']));
    session_start();

    $v = PDO_Voalle::getInstance()->prepare(Contratos::get_contratos());

    $v->execute(array(':cpf' => $_SESSION['cpf']));

    $contrato = $v->fetchAll(PDO::FETCH_ASSOC)[$_POST['contrato']]['numero_contrato'];

    $_SESSION['token'] = md5(date('l jS \of F Y').md5($contrato));
    $_SESSION['contrato'] = $contrato;

    header('Location: ../view/streaming.php?cod='.md5($contrato));
}
else{
    echo "Erro";
    header('Location: logout.php');
}
