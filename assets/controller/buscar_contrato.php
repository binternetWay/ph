<?php

require_once "../modal/PDO_Conexao.php";
require_once "../modal/PDO_Voalle.php";
require_once "../modal/Contratos.php";

session_name(md5('ph_primario'.$_SERVER['REMOTE_ADDR'].$_SERVER['HTTP_USER_AGENT']));
session_start();

if (isset($_POST['s_contrato']) && isset($_POST['contrato'])) {
    $_SESSION['contrato'] = $_POST['contrato'];
    $_SESSION['token'] = md5($_SESSION['nome'].date('l jS \of F Y'));
    
    $stmt = PDO_Conexao::getInstance()->prepare("SELECT DISTINCT plano 
    FROM preco
    ORDER BY plano ASC");
    $sql = new Contratos();
    $stt = PDO_Voalle::getInstance()->prepare($sql->get_contratos());

    $stmt->execute();
    $stt->execute(array(':cpf' => $_SESSION['cpf']));

    $row = $stmt->fetchAll(PDO::FETCH_ASSOC);
    $rs = $stt->fetchAll(PDO::FETCH_ASSOC);

    for ($i=0; $i < count($rs); $i++) { 
        if ($rs[$i]['numero_contrato'] == $_POST['contrato']) {
            $codigo_do_servico = $rs[$i]['codigo_servico'];
        }
    }
    for ($i=0; $i < count($row); $i++) { 
        if(in_array($codigo_do_servico, $row[$i])){
            $valor = $row[$i]['plano'];
        }
    }
    
    if (isset($valor)) {
        header('Location: /ph/painel');
    }
    else{
        header('Location: /ph/planos');
    }

}
else
    header('Location: /ph/logout');

