<?php

if(isset($_POST["id"]) && !empty($_POST["id"])){
    require_once("../config/conection.php");
    $conexao = new Conexao();
    
    $id = $_POST["id"];

    $query = $conexao->conectar()->prepare("DELETE FROM projetos WHERE id = :id");
    $query->bindParam(":id",$id);
    $query->execute();
    if($query== true){
        header("Location: ./project.php");
    }else{
        echo json_encode(array("erro"=>true, "mensagem" => "Erro a deletar projeto"));
    }


}else{
    die("Não existe o post");
}