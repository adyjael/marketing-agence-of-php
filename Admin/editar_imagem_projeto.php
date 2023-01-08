<?php


if(isset($_POST["id_edit_imagem"]) && !empty($_POST["id_edit_imagem"])){

    include_once("../config/conection.php");
    $conexao = new Conexao();
    $id = $_POST["id_edit_imagem"];

if(isset($_FILES['img_edit_img_projeto'])) {


    $imagem = $_FILES['img_edit_img_projeto'];

    $uploads_dir = 'imagem_projeto/';
    $nome_imagem = $imagem['name'];
    $novo_nome_imagem = uniqid();
    $extensao = strtolower(pathinfo($nome_imagem, PATHINFO_EXTENSION));
    if ($extensao != "jpg" && $extensao != "png" && $extensao != "jpeg" && $extensao != "webp") {
        die("Tipo de arquivo não aceito");
    }
    $path = $uploads_dir . $novo_nome_imagem . "." . $extensao;
    $deu_certo = move_uploaded_file($imagem["tmp_name"], $path);

    $query = $conexao->conectar()->prepare("UPDATE projetos SET imagem = :imagem WHERE id = :id");
    $query->bindParam(":imagem",$path);
    $query->bindParam(":id",$id);
    $query->execute();
    if($query == true){
        header("Location: project.php");
    }else{
        echo "Erro a atualizar a imagem";
    }
}
}else{
    echo "não exite post";
}

