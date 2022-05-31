<?php

require_once "../modal/PlayHub.php";
require_once "../modal/Voalle.php";
require_once "../modal/Contratos.php";

session_name(md5('ph_primario'.$_SERVER['REMOTE_ADDR'].$_SERVER['HTTP_USER_AGENT']));
session_start();

if (isset($_POST['cod__servico'])) {
    
    $usuario = $_SESSION['cpf'];

    $produto = $_POST['cod__servico'];
    $ph = new PH();
    $voalle = new Voalle();

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

                WHERE catalogo.tipo_contrato = '".$_SESSION['tipo_contrato']."'
                AND plano.cod_plano = '".$_SESSION['codigo_plano']."'
                AND servico.codigo_playhub = '".$produto."'");

    $stmt->execute();
    $servicos = $stmt->fetchAll(PDO::FETCH_ASSOC)[0];

    $z = new Contratos();
    
    $stt = PDO_Voalle::getInstance()->prepare($z->get_contratos());
    $stt->execute(array(':cpf' => $_SESSION['cpf']));

    $row = $stt->fetchAll(PDO::FETCH_ASSOC)[0];

    if ($row['tipo_faturmento'] == 1) {
        $data = date('Y-m', strtotime('-1 month', strtotime(date($row['prox_vencimento']))))."-01";
    }
    else{
        $data = substr(date($row['prox_vencimento']),0 ,7)."-01";
    }

    $valor_sva = $servicos['valor'] * 0.70;
    $valor_scm = $servicos['valor'] * 0.30;

    if ($voalle->Criar_Valor($valor_sva, $_SESSION['contrato'], $servicos['codigo_sva'], $data) == false) {
        $_SESSION['msg'] = 'erro_valor';
        header('Location: /ph/painel');
    }
    if ($voalle->Criar_Valor($valor_scm, $_SESSION['contrato'], $servicos['codigo_scm'], $data) == false) {
        $_SESSION['msg'] = 'erro_valor';
        header('Location: /ph/painel');
    }

    $playhub = $ph->inscrever($produto, $usuario);
    $bd = $ph->insertar_inscricao($_POST['cod__servico']);

    if ($bd == false) {
        $_SESSION['msg'] = 'erro_ph';
        header('Location: /ph/painel');
    }

}

header('Location: /ph/painel');