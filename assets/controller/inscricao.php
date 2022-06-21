<?php

require_once "../modal/PlayHub.php";
require_once "../modal/Contratos.php";

session_name(md5('ph_primario'.$_SERVER['REMOTE_ADDR'].$_SERVER['HTTP_USER_AGENT']));
session_start();

if (isset($_POST['cod__servico'])) {
    
    $usuario = $_SESSION['cpf'];

    $produto = $_POST['cod__servico'];
    $ph = new PH();

    $contrato = new Contratos();

    $stmt = PDO_Conexao::getInstance()->prepare("
        SELECT 
        catalogo.tipo_contrato,
        plano.cod_plano,
        servico.nome,
        servico.codigo_playhub AS codigo_index,
        servico.src_img,
        catalogo.categoria_id,
        preco.valor,
        TO_CHAR(CURRENT_DATE, 'DD/MM') AS data_inicio, 
        TO_CHAR((date_trunc('month', CURRENT_DATE) + interval '1 month' - interval '1 day')::date, 'DD/MM') AS data_final

        FROM catalogo
        LEFT JOIN plano ON plano.id = catalogo.cod_plano_id
        LEFT JOIN categoria ON categoria.id = catalogo.categoria_id
        LEFT JOIN servico ON servico.id = catalogo.servico_id

        LEFT JOIN preco ON (preco.categoria_id = catalogo.categoria_id 
                                                AND preco.cod_plano_id = catalogo.cod_plano_id
                                                AND preco.tipo_contrato = catalogo.tipo_contrato)

        WHERE catalogo.tipo_contrato = :tipo_contrato
        AND plano.cod_plano = :cod_plano
        ".$contrato->Categorias($_SESSION['cpf']));

    $stmt->execute(array(':tipo_contrato' => $_SESSION['tipo_contrato'], ':cod_plano' => $_SESSION['codigo_plano']));
    $servicos = $stmt->fetchAll(PDO::FETCH_ASSOC);

    if ($stmt->rowCount() > 0) {
        if (array_search($_POST['cod__servico'], array_column($servicos, 'codigo_index')) != '') {
            
            $playhub = $ph->inscrever($produto, $usuario);
            $bd = $ph->insertar_inscricao($produto);

            if ($bd == false) {
                $_SESSION['msg'] = 'erro_ph';
                header('Location: painel');
            }
            else {
                $_SESSION['msg'] = 'sucesso_servico';
                header('Location: painel');

            }
        
        }
        else{
            $_SESSION['msg'] = 'erro_ph';
            header('Location: painel');
        
        }
        
    }
}
else{
    $_SESSION['msg'] = 'erro_ph';
    header('Location: painel');

}

