<?php


if (isset($_POST) && !empty($_POST)) {

    include_once("../config/conection.php");
    $conexao = new Conexao();

    if (isset($_FILES['capa_noticia'])) {


        $imagem = $_FILES['capa_noticia'];

        $uploads_dir = 'capa_noticia/';
        $nome_imagem = $imagem['name'];
        $novo_nome_imagem = uniqid();
        $extensao = strtolower(pathinfo($nome_imagem, PATHINFO_EXTENSION));
        if ($extensao != "jpg" && $extensao != "png" && $extensao != "jpeg" && $extensao != "webp") {
            die("Tipo de arquivo não aceito");
        }
        $path = $uploads_dir . $novo_nome_imagem . "." . $extensao;
        $deu_certo = move_uploaded_file($imagem["tmp_name"], $path);
    }

    $titulo = $_POST["titulo"];

    $arr = explode(" ", $titulo);
    $titulo_url = implode("-", $arr);
    $descricao = $_POST["descricao"];
    $conteudo = $_POST["conteudo"];
    $categoria = $_POST["categoria"];
    $data = date("Y/m/d");
    $hora = date("H:i");

    $query = $conexao->conectar()->prepare("INSERT INTO noticias (titulo,titulo_url,descricao,conteudo,categoria,imagem,data,hora) VALUES (:titulo,:titulo_url,:descricao,:conteudo,:categoria,:imagem,:data,:hora)");

    $query->bindParam(":titulo", $titulo);
    $query->bindParam(":titulo_url", $titulo_url);
    $query->bindParam(":descricao", $descricao);
    $query->bindParam(":conteudo", $conteudo);
    $query->bindParam(":categoria", $categoria);
    $query->bindParam(":imagem", $path);
    $query->bindParam(":data", $data);
    $query->bindParam(":hora", $hora);
    $query->execute();

    if ($query == true) {
        header("Location: noticias.php");
    } else {
        die("Erro a publicar a noticia");
    }
} else {
    header("Location: ../index.php");
}
