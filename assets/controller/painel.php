<?php
require_once "../modal/PlayHub.php";
require_once "../modal/PDO_Conexao.php";
require_once "../modal/Contratos.php";

@session_name(md5('ph_primario'.$_SERVER['REMOTE_ADDR'].$_SERVER['HTTP_USER_AGENT']));
@session_start();

$stmt = PDO_Conexao::getInstance()->prepare("
SELECT servico.nome, servico.codigo_playhub, servico.src_img, categoria_id

FROM catalogo
LEFT JOIN plano ON plano.id = catalogo.cod_plano_id
LEFT JOIN servico ON servico.id = catalogo.servico_id
LEFT JOIN categoria ON categoria.id = catalogo.categoria_id

WHERE tipo_contrato = 'RT'
AND cod_plano = '50.2022'");

$stmt->execute();
$servicos = $stmt->fetchAll(PDO::FETCH_ASSOC);

$lista = array(
    array(
        'id'=>"1",
        'nome'=>"HBO Max",
        'codigo_index'=>"HBX",
        'id_categoria'=>"1",
        'src_img'=>"assets/img/banner/hbomax.jpg",
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

echo json_encode(array($servicos, $lista, $ph, $playhub));
?>