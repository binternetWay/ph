<?php
require_once "../modal/PlayHub.php";
require_once "../modal/PDO_Conexao.php";
require_once "../modal/Contratos.php";

@session_name(md5('ph_primario'.$_SERVER['REMOTE_ADDR'].$_SERVER['HTTP_USER_AGENT']));
@session_start();
if (!isset($_SESSION['codigo_plano']) && !isset($_SESSION['tipo_contrato'])) {
    header('Location: ../logout');
}
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
                                            TO_CHAR((CURRENT_DATE+30), 'DD/MM') AS data_final

                                            FROM catalogo
                                            LEFT JOIN plano ON plano.id = catalogo.cod_plano_id
                                            LEFT JOIN categoria ON categoria.id = catalogo.categoria_id
                                            LEFT JOIN servico ON servico.id = catalogo.servico_id

                                            LEFT JOIN preco ON (preco.categoria_id = catalogo.categoria_id 
                                                                                    AND preco.cod_plano_id = catalogo.cod_plano_id
                                                                                    AND preco.tipo_contrato = catalogo.tipo_contrato)

WHERE catalogo.tipo_contrato = 'FD'
AND plano.cod_plano = '750.2022'");

$stmt->execute();
$servicos = $stmt->fetchAll(PDO::FETCH_ASSOC);

$lista = array(
    array(
        'id'=>"1",
        'nome'=>"HBO Max",
        'codigo_index'=>"HBX",
        'id_categoria'=>"1",
        'src_img'=>"hbomax.jpg",
        'destque'=>"0",));

$contrato = new Contratos();
$cont = $contrato->Quantidade_Contratos($_SESSION['cpf']);

for ($i=0; $i < count($cont); $i++) { 
    if ($cont[$i]['numero_contrato'] == $_SESSION['contrato']) {
        $resultado[0] = $cont[$i]['tipo_contrato'];
        $resultado[1] = $cont[$i]['codigo_servico'];
    }
}
$_SESSION['tipo_contrato'] = $resultado[0];
$ph = $contrato->valores_de_servico($resultado[1], $resultado[0]);

$play = new PH();


$playhub = $play->buscar_inscricao('reginaldo.silva');
// $playhub = $play->buscar_inscricao($_SESSION['cpf']);

//Final
echo json_encode(array($servicos, $lista, $ph, $playhub));
?>