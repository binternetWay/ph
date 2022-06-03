<?php

require_once "../modal/PlayHub.php";
require_once "../modal/Contratos.php";

session_name(md5('ph_primario'.$_SERVER['REMOTE_ADDR'].$_SERVER['HTTP_USER_AGENT']));
session_start();

if (isset($_POST['cod__servico'])) {
    
    $usuario = $_SESSION['cpf'];

    $produto = $_POST['cod__servico'];
    $ph = new PH();

    $stmt = PDO_Conexao::getInstance()->prepare("
                SELECT 
                servico.id,
                catalogo.tipo_contrato,
                plano.cod_plano,
                servico.nome,
                servico.codigo_playhub AS codigo_index,
                servico.src_img,
                catalogo.categoria_id,
                preco.valor,
                servico.codigo_sva,
                servico.codigo_scm,
                TO_CHAR(CURRENT_DATE, 'DD/MM') AS data_inicio, 
                TO_CHAR((CURRENT_DATE+30), 'DD/MM') AS data_final

                FROM catalogo
                LEFT JOIN plano ON plano.id = catalogo.cod_plano_id
                LEFT JOIN categoria ON categoria.id = catalogo.categoria_id
                LEFT JOIN servico ON servico.id = catalogo.servico_id

                LEFT JOIN preco ON (preco.categoria_id = catalogo.categoria_id 
                                                        AND preco.cod_plano_id = catalogo.cod_plano_id
                                                        AND preco.tipo_contrato = catalogo.tipo_contrato)

                WHERE catalogo.tipo_contrato = :tipo_contrato
                AND plano.cod_plano = :cod_plano
                AND servico.codigo_playhub = :codigo_playhub");

    $stmt->execute(array(':tipo_contrato' => $_SESSION['tipo_contrato'], ':cod_plano' => $_SESSION['codigo_plano'], ':codigo_playhub' => $produto));
    $servicos = $stmt->fetchAll(PDO::FETCH_ASSOC)[0];

    $playhub = $ph->inscrever($produto, $usuario);
    $bd = $ph->insertar_inscricao($_POST['cod__servico']);

    if ($bd == false) {
        $_SESSION['msg'] = 'erro_ph';
        header('Location: /ph/painel');
    }

}

header('Location: /ph/painel');