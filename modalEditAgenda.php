
<?php
include_once("./config/conection.php");
$conexao = new Conexao();

$id = filter_input(INPUT_GET,"id",FILTER_SANITIZE_NUMBER_INT);
$id_vizu = filter_input(INPUT_GET,"id_vizu",FILTER_SANITIZE_NUMBER_INT);

if(!empty($id)){
    $query_data =$conexao->conectar()->prepare("SELECT titulo,data,hora,descricao FROM clientes_agenda WHERE id = :id LIMIT 1");
    $query_data->bindParam(":id",$id);
    $query_data->execute();
    $result = $query_data->fetchAll(PDO::FETCH_ASSOC);

    $data_inicial = date("Y/m/d", strtotime($result[0]["data"]));
    $data_final = date("Y/m/d");

    $diferenca = strtotime($data_inicial) - strtotime($data_final);
    $dias = floor($diferenca / (60 * 60 * 24));
    if($dias <= 3 && $dias >=0){
      $resposta = ["erro" => true, "msg" => "Você não pode editar a agenda porque falta menos de 72h"];
    }else{
      $resposta = ["erro" => false, "dados" => $result];
    }

    
}else if(!empty($id_vizu)){
  $query_data =$conexao->conectar()->prepare("SELECT titulo,data,hora,descricao FROM clientes_agenda WHERE id = :id LIMIT 1");
  $query_data->bindParam(":id",$id_vizu);
  $query_data->execute();
  $result = $query_data->fetchAll(PDO::FETCH_ASSOC);

  $resposta = ["erro" => false, "dados" => $result];

}else{
    $resposta = ["erro" => true, "msg" => "Erro"];
}
 



echo json_encode($resposta);




