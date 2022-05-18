<?php

require_once '../modal/PDO_Voalle.php';
require_once '../modal/PDO_Conexao.php';
require_once '../modal/Contratos.php';

session_name(md5('ph_primario'.$_SERVER['REMOTE_ADDR'].$_SERVER['HTTP_USER_AGENT']));
session_start();

if (isset($_POST['search']) && isset($_POST['cpf']) && !isset($_POST['primeira__senha']) && !isset($_POST['senha']) && !isset($_POST['iniciar'])) {
    $v = PDO_Conexao::getInstance()->prepare("SELECT * FROM usuario WHERE cpf = :cpf");
    $_POST['cpf'] = preg_replace('/[\@\.\;\/" "-]+/ ', '', $_POST['cpf']);
    $v->execute(array(':cpf' => $_POST['cpf']));

    if ($v->rowCount() > 0) {

        $_SESSION['parametro'] = md5("seu pai de calcinha");
        $_SESSION['cpf'] = $_POST['cpf'];
        header('Location: login');
    }
    else {
        $_SESSION['condicao'] = true;
        $_SESSION['cpf'] = $_POST['cpf'];
        header('Location: login');
    }    
}
elseif (isset($_POST['iniciar']) && isset($_POST['cpf']) && !isset($_POST['primeira__senha']) && isset($_POST['senha'])){
    //Começa o login
    $_POST['cpf'] = preg_replace('/[\@\.\;\/" "-]+/ ', '', $_POST['cpf']);
    $z = PDO_Conexao::getInstance()->prepare("SELECT * FROM usuario WHERE cpf = :cpf");
    $z->execute(array(':cpf' => $_POST['cpf']));

    if ($z->rowCount() > 0) {
        $fetch = $z->fetchAll(PDO::FETCH_ASSOC)[0];

        if (password_verify($_POST['senha'], $fetch['senha'])) {
            $_SESSION['cpf'] = $fetch['cpf'];
            $_SESSION['token'] = md5($fetch['nome'].date('l jS \of F Y'));
            $_SESSION['nome'] = $fetch['nome'];

            $lista = new Contratos ();
            $lista = $lista->Quantidade_Contratos($_POST['cpf']);

            if (count($lista) == 1) {
                $contrato = $lista[0]['numero_contrato'];
                $_SESSION['token'] = md5($fetch['nome'].date('l jS \of F Y'));
                $_SESSION['cpf'] = $_POST['cpf'];
                $_SESSION['contrato'] = $contrato;
                header('Location: /ph/painel');
            }
            elseif (count($lista) > 1) {
                $_SESSION['div'] = md5('contratos'.date('l jS \of F Y'));
                header('Location: /ph/contrato');
            }

            
        }
        else {
            $_SESSION['msg'] = "erro_usuario";

            header('Location: /ph/logout');
        }
    }
    else{
        $_SESSION['msg'] = "erro_usuario";
        
        header('Location: /ph/logout');
    }
        
}
elseif(isset($_POST['primeira__senha']) && isset($_POST['segunda__senha']) && $_POST['primeira__senha'] == $_POST['segunda__senha']){
    $_POST['cpf'] = preg_replace('/[\@\.\;\/" "-]+/ ', '', $_POST['cpf']);
    
    $x = PDO_Voalle::getInstance()->prepare(Contratos::get_contratos());

    $x->execute(array(':cpf' => $_POST['cpf']));

    $fetch = $x->fetchAll(PDO::FETCH_ASSOC)[0];

    if ($x->rowCount() > 0) {
        $y = PDO_Conexao::getInstance()->prepare("INSERT INTO usuario (usuario, senha, cpf, nome, telefone, email) VALUES (:usuario, :senha, :cpf, :nome, :telefone, :email)");

        $y->bindParam(':usuario', $_POST['cpf']);
        $y->bindParam(':senha', password_hash($_POST['primeira__senha'], PASSWORD_DEFAULT));
        $y->bindParam(':cpf', $_POST['cpf']);
        $y->bindParam(':nome', $fetch['nome']);
        $y->bindParam(':telefone', $fetch['telefone']);
        $y->bindParam(':email', $fetch['email']);

        $y->execute();

        if ($y->rowCount() > 0) {
            $_SESSION['token'] = md5($fetch['nome'].date('l jS \of F Y'));
            $_SESSION['nome'] = $fetch['nome'];
            header('Location: /ph/painel');
        }
        else{ 
            $_SESSION['msg'] = "erro_contrato";
            header('Location: logout');
        }
    }
    else{
        header('Location: logout');
    }
}
elseif(isset($_POST['senha']) && isset($_POST['c_senha']) && $_POST['senha'] != $_POST['c_senha']){
    $_SESSION['msg'] = "erro_senha";
    header('Location: logout');
}
else{
    header('Location: logout');
}