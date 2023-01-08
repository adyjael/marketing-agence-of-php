<?php

    if(isset($_POST) && !empty($_POST)){
        require_once("../config/conection.php");
        $conexao = new Conexao();

        $id = $_POST["id"];
        $nome = $_POST["nome"];
        $descricao = $_POST["descricao"];
        $tecnologias_utilizadas = $_POST["tecnologias"];
        $data_inicio = date("Y/m/d",strtotime($_POST["data_inicio"]));
        $data_fim = date("Y/m/d",strtotime($_POST["data_fim"]));
        $mais_info = $_POST["mais_info"];

        if($data_inicio > $data_fim){
            echo json_encode(array("erro"=> true,"mensagem" => "A data inicio não pode maior que a data fim"));
            return false;
        }

        $query = $conexao->conectar()->prepare("UPDATE projetos SET nome=:nome,descricao=:descricao,tecnologias_utilizadas=:tecnologias_utilizadas,data_inicio=:data_inicio,data_fim=:data_fim,mais_info=:mais_info WHERE id = :id");
        $query->bindParam(":nome",$nome);
        $query->bindParam(":descricao",$descricao);
        $query->bindParam(":tecnologias_utilizadas",$tecnologias_utilizadas);
        $query->bindParam(":data_inicio",$data_inicio);
        $query->bindParam(":data_fim",$data_fim);
        $query->bindParam(":mais_info",$mais_info);
        $query->bindParam(":id",$id);
        $query->execute();
        if($query == true){
            echo json_encode(array("erro"=> false, "mensagem"=> "Projeto editado con successo"));
        }else{
            echo json_encode(array("erro"=>true, "mensagem" => "Eroo a editar o projeto"));
        }


    }else{
        die("Não existe post");
    }
