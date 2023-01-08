<?php
if (isset($_POST) && !empty($_POST)) {

    require_once("../config/conection.php");
    $conexao = new Conexao();

    $titulo = $_POST["titulo"];
    $arr = explode(" ", $titulo);
    $titulo_url = implode("-", $arr);
    $descricao = $_POST["descricao"];
    $conteudo = $_POST["conteudo"];
    $categoria = $_POST["categoria"];
    $id = $_POST["id"];

    $query = $conexao->conectar()->prepare("UPDATE noticias SET titulo = :titulo,titulo_url=:titulo_url,descricao=:descricao,conteudo=:conteudo,categoria=:categoria WHERE id = :id");
    $query->bindParam("titulo",$titulo);
    $query->bindParam("titulo_url",$titulo_url);
    $query->bindParam("descricao",$descricao);
    $query->bindParam("conteudo",$conteudo);
    $query->bindParam("categoria",$categoria);
    $query->bindParam("id",$id);
    $query->execute();

    if($query == true){
        echo json_encode(array("erro"=>0, "mensagem" => "Noticia editada con sucesso"));
    }else{
        echo json_encode(array("erro"=>1,"mensagem"=> "Erro ao editar a noticia"));
    }
    
} else {

    die("Não existe post");
}
