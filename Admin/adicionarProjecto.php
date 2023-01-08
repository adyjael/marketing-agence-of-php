<?php

    if(isset($_POST) && !empty($_POST) && isset($_POST["tecnologias"])){
        require_once("../config/conection.php");



        $nome = $_POST["nome_projeto"];
        $descricao = $_POST["descricao_projeto"];
        $tecnologias = implode(",",$_POST["tecnologias"]);
        $data_inicio = date("Y/m/d", strtotime($_POST["data_inicio"]));
        $data_fim = date("Y/m/d",strtotime( $_POST["data_fim"]));
        $mais_informacao = $_POST["mais_info"];
        if($nome =="" || $descricao == ""){
            die("Preencha todos os campos");
        }
        if($data_inicio > $data_fim){
            die("Data do inicio não pode ser maior que a data fim");
        }
        
        if(isset($_FILES['img_projeto'])) {

            $imagem = $_FILES['img_projeto'];
            $uploads_dir = 'imagem_projeto/';
            $nome_imagem = $imagem['name'];
            $novo_nome_imagem = uniqid();
            $extensao = strtolower(pathinfo($nome_imagem, PATHINFO_EXTENSION));
            if ($extensao != "jpg" && $extensao != "png" && $extensao != "jpeg" && $extensao != "webp") {
                die("Tipo de imagem não aceito");
            }
            $path = $uploads_dir . $novo_nome_imagem . "." . $extensao;
            $deu_certo = move_uploaded_file($imagem["tmp_name"], $path);
        }


        $conexao = new Conexao();
        $query = $conexao->conectar()->prepare("INSERT INTO projetos (nome,descricao,imagem,tecnologias_utilizadas,mais_info,data_inicio,data_fim) VALUES (:nome,:descricao,:imagem,:tecnologias_utilizadas,:mais_info,:data_inicio,:data_fim) ");
        $query->bindParam(":nome",$nome);
        $query->bindParam(":descricao",$descricao);
        $query->bindParam(":imagem",$path);
        $query->bindParam(":tecnologias_utilizadas",$tecnologias);
        $query->bindParam(":mais_info",$mais_informacao);
        $query->bindParam(":data_inicio",$data_inicio);
        $query->bindParam(":data_fim",$data_fim);
        $query->execute();
        if($query == true){
            header("Location: project.php");
        }else{
            die("Erro a adicionar projetos");
        }
    }else{
        die("Preecha as tecnologias");
    }

