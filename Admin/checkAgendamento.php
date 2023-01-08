<?php

include_once("../config/conection.php");

class Agendamento
{
    private $con = null;

    public function __construct($conexao)
    {
        $this->con = $conexao;
    }

    public function agendar()
    {
        if (empty($_POST) || $this->con == null) {
            return;
        }

        if (isset($_POST["type"]) && $_POST["type"] == "marcar_agenda" && isset($_POST["titulo"]) && isset($_POST["utilizador_id"])  && isset($_POST["data"]) && isset($_POST["descricao"]) && isset($_POST["hora"])) {
            $titulo = $_POST["titulo"];
            $utilizador_id = $_POST["utilizador_id"];
            $hora = date("H:i", strtotime($_POST["hora"]));
            $descricao = $_POST["descricao"];
            $data = date('Y-m-d H:i:s', strtotime($_POST["data"]));
            $dataAtual = date('Y-m-d');
            if ($data < $dataAtual) {
                echo json_encode(array("erro" => 1, "mensagem" => "Você inseriu uma data passada."));
                return;
            } else {
                $this->marcarAgendamento($titulo, $data, $hora, $descricao, $utilizador_id);
                echo json_encode(array("erro" => 0, "mensagem" => "Agendamento marcado com successo."));
            }
        } else if (isset($_POST["type"]) && $_POST["type"] == "delete" && isset($_POST["id"])) {
            $id = $_POST["id"];
            $this->deletarAgendamento($id);
        } else  if (isset($_POST["type"]) && $_POST["type"] == "edit" && isset($_POST["titulo"]) && isset($_POST["id"])  && isset($_POST["data"]) && isset($_POST["descricao"]) && isset($_POST["hora"])) {

            $titulo = $_POST["titulo"];
            $id = $_POST["id"];
            $hora = date("H:i", strtotime($_POST["hora"]));
            $descricao = $_POST["descricao"];
            $data = date('Y-m-d H:i:s', strtotime($_POST["data"]));
            $dataAtual = date('Y-m-d');
            if ($data < $dataAtual) {
                echo json_encode(array("erro" => 1, "mensagem" => "Você inseriu uma data passada."));
                return;
            } else {
                $this->editarAgendamento($id, $titulo, $data, $hora, $descricao);
                echo json_encode(array("erro" => 0, "mensagem" => "Agendamento editado com successo."));
            }
        }
    }

    private function marcarAgendamento($titulo, $data, $hora, $descricao, $utilizador_id)
    {
        $conexao = $this->con;

        //$data = date('Y-m-d H:i:s',strtotime($data))

        $query = $conexao->prepare("INSERT INTO clientes_agenda (titulo,data,hora,descricao,utilizador_id) VALUES (?, ?, ?,?, ?)");

        if ($query->execute(array($titulo, $data, $hora, $descricao, $utilizador_id))) {
            //return json_encode(array("erro" => 0, "mensagem" =>  "Agendamento marcado com suc" ));
        } else {
            return json_encode(array("erro" => 1, "mensagem," =>  "Erro ao fazer a marcação"));
        }
    }
    private function editarAgendamento($id, $titulo, $data, $hora, $descricao)
    {
        $conexao = $this->con;
        $query_select = $conexao->prepare("SELECT data from clientes_agenda WHERE id = :id LIMIT 1");
        $query_select->bindParam(":id", $id);
        $query_select->execute();
        $query_select_data = $query_select->fetchAll(PDO::FETCH_ASSOC);

        $query_update = $conexao->prepare("UPDATE clientes_agenda SET titulo = ?, data = ?, hora = ?, descricao = ? WHERE id = ?");

        if ($query_update->execute(array($titulo, $data, $hora, $descricao, $id))) {
            //return json_encode(array("erro" => 0, "mensagem" =>  "Agendamento editado com suc" ));
        } else {
            return json_encode(array("erro" => 1, "mensagem," =>  "Erro ao editar a maracação"));
        }
    }

    private function deletarAgendamento($id)
    {
        $conexao = $this->con;

        $query = $conexao->prepare("DELETE FROM `clientes_agenda` WHERE id = ?");
        if ($query->execute(array($id))) {
            echo json_encode(array("erro" => 0, "mensagem" => "Agendamento deletado com successo."));
        } else {
            return json_encode(array("erro" => 1, "mensagem" => "Ocoreu um erro a deletar o agendamento."));
        }
    }
}








$conexao = new Conexao();
$classe  = new Agendamento($conexao->conectar());
$classe->agendar();
