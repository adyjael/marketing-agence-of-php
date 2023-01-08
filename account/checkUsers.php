<?php
require("../config/conection.php");

class Acesso
{
    private $con = null;
    public function __construct($conexao)
    {
        $this->con = $conexao;
    }
    public function send()
    {
        if (empty($_POST) || $this->con == null) {
            echo json_encode(array("erro" => 1, "mensagem" => "Ocorreu um erro interno no servidor."));
            return;
        }
        switch (true) {
                // VERIFICAR SE O TIPO DO POST É LOGIN OU REGISTER E CADASTRAR NO BANCO DE DADOS
            case (isset($_POST["type"]) && $_POST["type"] == "login" && isset($_POST["email"]) && isset($_POST["senha"])):
                $email = htmlspecialchars($_POST["email"]);
                $senha = htmlspecialchars($_POST["senha"]);
                echo $this->login($email, $senha);
                break;

            case (isset($_POST["type"]) && $_POST["type"] == "register" && isset($_POST["email"]) && isset($_POST["senha"]) && isset($_POST["apelido"]) && isset($_POST["tel"]) && isset($_POST["nome"])):
                $email = htmlspecialchars($_POST["email"]);
                $nome = htmlspecialchars($_POST["nome"]);
                $senha = password_hash($_POST["senha"], PASSWORD_DEFAULT);
                $data = date('Y-m-d H:i:s');
                $apelido = $_POST["apelido"];
                $tel = $_POST["tel"];

                echo $this->register($email, $senha, $nome, $apelido, $tel, $data);
                break;

            case (isset($_POST["type"]) && $_POST["type"] == "adm_add_utilizador" && isset($_POST["email"]) && isset($_POST["senha"]) && isset($_POST["apelido"]) && isset($_POST["tel"]) && isset($_POST["nome"]) &&  isset($_POST["adm"])):
                $email = htmlspecialchars($_POST["email"]);
                $nome = htmlspecialchars($_POST["nome"]);
                $senha = password_hash($_POST["senha"], PASSWORD_DEFAULT);
                $data = date('Y-m-d H:i:s');
                $adm = $_POST["adm"];
                $apelido = $_POST["apelido"];
                $tel = $_POST["tel"];
                echo $this->admAddUtilizador($email, $senha, $nome, $apelido, $tel, $data, $adm);
                break;
            case (isset($_POST["type"]) && $_POST["type"] == "adm_delete_user" && isset($_POST["id"])):
                $id = ($_POST["id"]);
                echo $this->admDeleteUtilizador($id);
                break;
            case (isset($_POST["type"]) && $_POST["type"] == "adm_edit_user" && isset($_POST["email"]) && isset($_POST["apelido"]) && isset($_POST["tel"]) && isset($_POST["nome"]) &&  isset($_POST["id"])):
                $email = htmlspecialchars($_POST["email"]);
                $nome = htmlspecialchars($_POST["nome"]);
                $apelido = $_POST["apelido"];
                $tel = $_POST["tel"];
                $id = $_POST["id"];
                $adm = 1;

                echo $this->admEditUtilizador($email, $nome, $apelido, $tel, $id, $adm);
                break;
            case (isset($_POST["type"]) && $_POST["type"] == "edit_user" && isset($_POST["apelido"]) && isset($_POST["tel"]) && isset($_POST["nome"]) &&  isset($_POST["id"])):

                $nome = htmlspecialchars($_POST["nome"]);
                $apelido = $_POST["apelido"];
                $tel = $_POST["tel"];
                $id = $_POST["id"];
                echo $this->editUtilizador($nome, $apelido, $tel, $id);
                break;
            case (isset($_POST["type"]) && $_POST["type"] == "edit_user_senha" && isset($_POST["id"]) && isset($_POST["senha"])):
                $id = ($_POST["id"]);
                $senha = password_hash($_POST["senha"], PASSWORD_DEFAULT);
                echo $this->editUtilizadorSenha($senha, $id);
                break;
        }
    }

    private function login($email, $senha)
    {
        $conexao = $this->con;

        $query = $conexao->prepare("SELECT * FROM utilizadores WHERE email = ?");
        $query->execute(array($email));

        if ($query->rowCount()) {
            $user = $query->fetchAll(PDO::FETCH_ASSOC)[0];
            if (password_verify($senha, $user["senha"])) {
                session_start();
                $_SESSION["user"] = array($user["nome"], $user["adm"], $user["id"]);

                return json_encode(array("erro" => 0, "adm" =>  $_SESSION["user"][1]));
            } else {
                return json_encode(array("erro" => 1, "mensagem" => "A senha está incoreta!"));
            }
        } else {
            return json_encode(array("erro" => 1, "mensagem" => "Este email não está cadastrado!"));
        }
    }

    private function register($email, $senha, $nome, $apelido, $tel, $data)
    {
        $conexao = $this->con;

        $query_email = $conexao->prepare("SELECT email FROM utilizadores WHERE email = ?");
        $query_email->execute(array($email));

        if ($query_email->rowCount()) {
            return json_encode(array("erro" => 1, "mensagem" => "Este email ja se encontra cadastrado"));
        } else {

            $query = $conexao->prepare("INSERT INTO utilizadores (email, senha, nome, adm,data,apelido,tel) VALUES (?, ?, ?, ?,?,?,?)");

            if ($query->execute(array($email, $senha, $nome, 1, $data, $apelido, $tel))) {
                return json_encode(array("erro" => 0, "mensagem" => "Novo utilizador cadastrado com successo."));
            } else {
                return json_encode(array("erro" => 1, "mensagem" => "Ocorreu um erro ao cadastrar usuario."));
            }
        }
    }
    private function editUtilizador($nome, $apelido, $tel, $id)
    {
        $conexao = $this->con;
        //$query = $conexao->prepare("UPDATE utilizadores SET email= ?, senha = ?, nome = ?, adm = ?,apelido = ?,tel = ? WHERE id = $id)");
        $query = "UPDATE utilizadores SET nome=:nome,apelido= :apelido, tel=:tel WHERE id = :id";

        $stmt = $conexao->prepare($query);
        $stmt->bindParam(":nome", $nome);
        $stmt->bindParam(":apelido", $apelido);
        $stmt->bindParam(":tel", $tel);
        $stmt->bindParam(":id", $id);
        $stmt->execute();

        if ($query == true) {
            return json_encode(array("erro" => 0));
        } else {
            return json_encode(array("erro" => 1, "mensagem" => "Ocorreu um erro ao cadastrar usuario."));
        }
    }

    private function editUtilizadorSenha($senha, $id)
    {
        $conexao = $this->con;
        $query = "UPDATE utilizadores SET senha = :senha WHERE id = :id";
        $stmt = $conexao->prepare($query);
        $stmt->bindParam(":senha", $senha);
        $stmt->bindParam(":id", $id);
        $stmt->execute();

        if ($query == true) {
            return json_encode(array("erro" => 0, "mensagem" => "Senha salva com successo"));
        } else {
            return json_encode(array("erro" => 1, "mensagem" => "Ocorreu um erro ao editar a senha do utilizador."));
        }
    }
    private function admAddUtilizador($email, $senha, $nome, $apelido, $tel, $data, $adm)
    {
        $conexao = $this->con;

        $query = $conexao->prepare("SELECT * FROM utilizadores WHERE email = ?");
        $query->execute(array($email));

        if ($query->rowCount()) {
            return json_encode(array("erro" => 1, "mensagem" => "Este email ja se encontra cadastrado"));
        } else {

            $query = $conexao->prepare("INSERT INTO utilizadores (email, senha, nome, adm,data,apelido,tel) VALUES (?, ?, ?, ?,?,?,?)");

            if ($query->execute(array($email, $senha, $nome, $adm, $data, $apelido, $tel))) {
                return json_encode(array("erro" => 0));
            } else {
                return json_encode(array("erro" => 1, "mensagem" => "Ocorreu um erro ao cadastrar usuario."));
            }
        }
    }
    private function admEditUtilizador($email, $nome, $apelido, $tel, $id, $adm)
    {
        $conexao = $this->con;
        //$query = $conexao->prepare("UPDATE utilizadores SET email= ?, senha = ?, nome = ?, adm = ?,apelido = ?,tel = ? WHERE id = $id)");
        $query = "UPDATE utilizadores SET nome=:nome,email=:email, adm =:adm, apelido= :apelido, tel=:tel WHERE id = :id";

        $stmt = $conexao->prepare($query);
        $stmt->bindParam(":nome", $nome);
        $stmt->bindParam(":email", $email);
        $stmt->bindParam(":adm", $adm);
        $stmt->bindParam(":apelido", $apelido);
        $stmt->bindParam(":tel", $tel);
        $stmt->bindParam(":id", $id);
        $stmt->execute();

        if ($query == true) {
            return json_encode(array("erro" => 0));
        } else {
            return json_encode(array("erro" => 1, "mensagem" => "Ocorreu um erro ao cadastrar usuario."));
        }
    }

    private function admDeleteUtilizador($id)
    {

        $conexao = $this->con;
        $query = $conexao->prepare("DELETE FROM utilizadores WHERE id = ?");

        if ($query->execute(array($id)) == true) {
            $agenda_cliente = $conexao->prepare("DELETE FROM clientes_agenda WHERE utilizador_id = ?");
            if ($agenda_cliente->execute(array($id)) == true) {
                return json_encode(array("erro" => 0));
            }
        } else {
            return json_encode(array("erro" => 1, "mensagem" => "Ocorreu um erro ao deletar usuario."));
        }
    }
};
$conexao = new Conexao();
$classe  = new Acesso($conexao->conectar());
$classe->send();
