<?php

if(isset($_POST["id"])){
    require_once("../config/conection.php");
    $conexao = new Conexao();
    
    $id = $_POST["id"];

    $query = $conexao->conectar()->prepare("DELETE FROM noticias WHERE id = :id");
    $query->bindParam(":id",$id);
    $query->execute();
    if($query== true){
        header("Location: ./noticias.php");
    }else{
        echo json_encode(array("erro"=>true, "mensagem" => "Erro a deletar noticia"));
    }


}else{
    die("Não existe o post");
}