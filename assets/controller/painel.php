<?php
require_once "../modal/PDO_Conexao.php";
require_once "../modal/Contratos.php";

$stmt = PDO_Conexao::getInstance()->prepare("SELECT *,  TO_CHAR(CURRENT_DATE, 'DD/MM') AS data_inicio, TO_CHAR((CURRENT_DATE+30), 'DD/MM') AS data_final
                                            FROM catalogo");

$stmt->execute();
$servicos = $stmt->fetchAll(PDO::FETCH_ASSOC);

$lista = array(
    array('nome'=>"HBO Max",'src_img'=>"assets/img/banner/hbomax.jpg"),
    array('nome'=>"HBO Max",'src_img'=>"assets/img/banner/looke.jpg"),
    array('nome'=>"HBO Max",'src_img'=>"assets/img/banner/ubook.jpg")
);

$contrato = new Contratos();

$cont = $contrato->Quantidade_Contratos($_SESSION['cpf']);

for ($i=0; $i < count($cont); $i++) { 
    if ($cont[$i]['numero_contrato'] == $_SESSION['contrato']) {
        $resultado[0] = $cont[$i]['tipo_contrato'];
        $resultado[1] = $cont[$i]['codigo_servico'];
    }
}

$ph = $contrato->valores_de_servico($resultado[1], $resultado[0]);

echo json_encode(array($servicos, $lista, $ph));
?>