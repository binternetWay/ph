<?php

require_once "../modal/PDO_Voalle.php";
require_once "../modal/PDO_Conexao.php";
require_once "../modal/Voalle.php";
require_once "../modal/Usuario.php";
require_once "../modal/Contratos.php";

session_name(md5('ph_primario'.$_SERVER['REMOTE_ADDR'].$_SERVER['HTTP_USER_AGENT']));
session_start();


if ($_SESSION['csrf'] != $csrf) {
    header('Location: ../../logout');
}

if (isset($_POST['alterar_plano']) && isset($_POST['cod_plano'])) {

    $z = new Contratos();
    $x = new Voalle();
    $y = new Usuario($_SESSION['cpf']);

    $stt = PDO_Conexao::getInstance()->prepare($z->get_planos());
    $stt->execute(array(':preco' => $y->getValorContrato()));
    $servicos = $stt->fetchAll(PDO::FETCH_ASSOC);
    $array = array_search($_POST['cod_plano'], array_column($servicos, 'cod_plano'));
    if ($servicos[$array]['cod_plano'] != $_POST['cod_plano']) {
        header('Location: ../../planos');
        die();
    }

    $solicitacao = $x->NovaSolicitacao($y->getNumeroCliente(), $y->getPlano(), $_POST['cod_plano'], $y->getBase(), $y->getContrato());

    if ($solicitacao != false) {
        $_SESSION['protocolo'] = $solicitacao;

        header('Location: ../../planos');
    }
    else {
        $_SESSION['protocolo'] = '';

        header('Location: ../../planos');
    }
}
else {
    $_SESSION['msg'] = 'erro';

    header('Location: ../../logout');
}