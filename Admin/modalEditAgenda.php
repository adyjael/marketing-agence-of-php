
<?php
include_once("../config/conection.php");
$conexao = new Conexao();

$id = filter_input(INPUT_GET,"id",FILTER_SANITIZE_NUMBER_INT);
$id_vizu = filter_input(INPUT_GET,"id_vizu",FILTER_SANITIZE_NUMBER_INT);

if(!empty($id)){
    $query_data =$conexao->conectar()->prepare("SELECT titulo,data,hora,descricao FROM clientes_agenda WHERE id = :id LIMIT 1");
    $query_data->bindParam(":id",$id);
    $query_data->execute();
    $result = $query_data->fetchAll(PDO::FETCH_ASSOC);
      $resposta = ["erro" => false, "dados" => $result];
    

    
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








/*session_start();

if (isset($_SESSION["user"]) && is_array($_SESSION["user"])) {

  $nome = $_SESSION["user"][0];
  $adm  = $_SESSION["user"][1];
  $id = $_SESSION["user"][2];
  if ($adm != 1) {
    session_destroy();
    echo "<script>window.location = '../account/login.php'</script>";
  }
} else {
  echo "<script>window.location = '../account/login.php'</script>";
}
*/



