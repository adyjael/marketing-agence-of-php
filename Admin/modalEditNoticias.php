<?php

include_once("../config/conection.php");
$conexao = new Conexao();

$id = filter_input(INPUT_GET,"id",FILTER_SANITIZE_NUMBER_INT);

if(!empty($id)){
    $query_data =$conexao->conectar()->prepare("SELECT * FROM noticias WHERE id = :id LIMIT 1");
    $query_data->bindParam(":id",$id);
    $query_data->execute();

    $result = $query_data->fetchAll(PDO::FETCH_ASSOC);
    $resposta = ["erro" => false, "dados" => $result];
}else{
    $resposta = ["erro" => true, "msg" => "Erro ao editar agenda"];
}
 

echo json_encode($resposta);