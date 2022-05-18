<?php
require_once "../modal/PDO_Conexao.php";

$stmt = PDO_Conexao::getInstance()->prepare("SELECT *,  TO_CHAR(CURRENT_DATE, 'DD/MM') AS data_inicio, TO_CHAR((CURRENT_DATE+30), 'DD/MM') AS data_final
                                            FROM catalogo");

$stmt->execute();
$servicos = $stmt->fetchAll(PDO::FETCH_ASSOC);
$lista = array(
    array('nome'=>"HBO Max",'src_img'=>"assets/img/banner/hbomax.jpg"),
    array('nome'=>"HBO Max",'src_img'=>"assets/img/banner/looke.jpg"),
    array('nome'=>"HBO Max",'src_img'=>"assets/img/banner/ubook.jpg")
);

echo json_encode(array($servicos, $lista));
?>