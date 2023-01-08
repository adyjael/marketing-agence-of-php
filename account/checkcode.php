<?php

    if(isset($_GET["code"])){
    require_once("../config/conection.php");
        $conexao = new Conexao;

        $token = $_GET["code"];

        $selec_token = $conexao->conectar()->prepare("SELECT * FROM utilizadores  WHERE token_recupercao =:token");
        $selec_token->bindParam(":token",$token);
        $selec_token->execute();

        if($selec_token->rowCount()){
            echo json_encode(array("erro" => 0));
        }else{
            echo json_encode(array("erro" => 1, "mensagem" => "Codigo de verificação incoreto"));
        }

    }


