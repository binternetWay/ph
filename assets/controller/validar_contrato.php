<?php

require_once '../modal/PDO_Voalle.php';
require_once '../modal/PDO_Conexao.php';
require_once '../modal/Contratos.php';

session_name(md5('ph_primario'.$_SERVER['REMOTE_ADDR'].$_SERVER['HTTP_USER_AGENT']));
session_start();

//Primeira Etapa, Apos informar o CPF para login
if (isset($_POST['search']) && isset($_POST['cpf']) 
        && !isset($_POST['primeira__senha']) && !isset($_POST['senha']) && !isset($_POST['iniciar'])) {
    
    $v = PDO_Conexao::getInstance()->prepare("SELECT * FROM usuario WHERE cpf = :cpf");
    $_POST['cpf'] = preg_replace('/[\@\.\;\/" "-]+/ ', '', $_POST['cpf']);
    $v->execute(array(':cpf' => $_POST['cpf']));

    //Se o cpf existir no nosso banco de dados.
    if ($v->rowCount() > 0) {

        //Cria parametro inserir a senha
        $_SESSION['parametro'] = md5("seu pai de calcinha");
        $_SESSION['cpf'] = $_POST['cpf'];

        header('Location: login');
    }
    else {
        $sql = New Contratos();
        $stt = PDO_Voalle::getInstance()->prepare($sql->get_contratos());
        $stt->execute(array(':cpf' => $_POST['cpf']));
        if ($stt->rowCount() > 0) {
            //Cria parametro para cadastro do usuario em nossa base
            $_SESSION['condicao'] = true;
            $_SESSION['cpf'] = $_POST['cpf'];

            header('Location: login');
        }
        else {
            $_SESSION['msg'] = "erro_usuario_nao";
            header('Location: login');
        }
        
    }    
}

//Login após inserir a senha
elseif (isset($_POST['iniciar']) && isset($_POST['cpf']) && isset($_POST['senha']) 
            && !isset($_POST['primeira__senha'])){
    
    $_POST['cpf'] = preg_replace('/[\@\.\;\/" "-]+/ ', '', $_POST['cpf']);
    $z = PDO_Conexao::getInstance()->prepare("SELECT * FROM usuario WHERE cpf = :cpf");
    $z->execute(array(':cpf' => $_POST['cpf']));

    //Verifica se o usuario existe
    if ($z->rowCount() > 0) {
        $fetch = $z->fetchAll(PDO::FETCH_ASSOC)[0];

        // Verifica se a senha esta correta
        if (password_verify($_POST['senha'], $fetch['senha'])) {
            $_SESSION['cpf'] = $fetch['cpf'];
            $_SESSION['token'] = md5($fetch['nome'].date('l jS \of F Y'));
            $_SESSION['nome'] = $fetch['nome'];

            $lista = new Contratos();

            $lista = $lista->Quantidade_Contratos($_POST['cpf']);

            //Verifica quantos contratos existe na Voalle 
            if (count($lista) == 1) {

                //Se for 1 vai direto para o painel
                $contrato = $lista[0]['numero_contrato'];
                $_SESSION['div'] = md5('contratos'.date('l jS \of F Y'));
                $_SESSION['cpf'] = $_POST['cpf'];
                $_SESSION['contrato'] = $contrato;
                header('Location: /ph/contrato');
            }
            elseif (count($lista) > 1) {

                //Se for mais de 1 contrato vai para a seleção de contratos
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
        $_SESSION['msg'] = "erro_usuario_nao";
        
        header('Location: /ph/logout');
    }
        
}
// Condição para cadastrar o usuario em nosso banco de dados
elseif(isset($_POST['primeira__senha']) && isset($_POST['segunda__senha']) && $_POST['primeira__senha'] == $_POST['segunda__senha']){
    $_POST['cpf'] = preg_replace('/[\@\.\;\/" "-]+/ ', '', $_POST['cpf']);
    
    $sql = New Contratos();

    $x = PDO_Voalle::getInstance()->prepare($sql->get_contratos());

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

            //Se cadastro for realizado com sucesso vai para o painel
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
        $_SESSION['msg'] = "erro_contrato";

        header('Location: logout');
    }
}
// Se "Confiramr senha" for incorreta
elseif(isset($_POST['senha']) && isset($_POST['c_senha']) && $_POST['senha'] != $_POST['c_senha']){
    $_SESSION['msg'] = "erro_senha";
    header('Location: logout');
}
else{
    header('Location: logout');
}