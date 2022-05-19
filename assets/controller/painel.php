<?php
require_once "../modal/PDO_Conexao.php";

$stmt = PDO_Conexao::getInstance()->prepare("SELECT *,  TO_CHAR(CURRENT_DATE, 'DD/MM') AS data_inicio, TO_CHAR((CURRENT_DATE+30), 'DD/MM') AS data_final FROM catalogo");

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

echo json_encode(array($lista, $servicos));
?>