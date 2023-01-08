<?php

if (isset($_GET["email"]) && isset($_GET["senha"])) {
    require_once("../config/conection.php");
    $conexao = new Conexao;

    $email = htmlspecialchars($_GET["email"]);
    $senha = password_hash($_GET["senha"], PASSWORD_DEFAULT);
    $sqlUpdateSenha = $conexao->conectar()->prepare("UPDATE utilizadores SET senha =:senha WHERE email = :email");
    $sqlUpdateSenha->bindParam(":senha", $senha);
    $sqlUpdateSenha->bindParam(":email", $email);
    $sqlUpdateSenha->execute();
    if ($sqlUpdateSenha == true) {

        echo json_encode(array("erro" => 0, "mensagem" => "Senha trocada com successo"));
    } else {
        echo json_encode(array("erro" => 1, "mensagem" => "Erro a trocar a senha"));
    }
} else {
    echo json_encode(array("erro" => 1, "mensagem" => "Não exite post"));
}
