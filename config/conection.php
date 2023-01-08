<?php
    Class Conexao{
        private $server = "127.0.0.1";
        private $usuario = "root";
        private $senha = "";
        private $banco = "caso_pratico_php";

        public function conectar(){
            try{
                $conexao = new PDO("mysql:host=$this->server;dbname=$this->banco", $this->usuario, $this->senha);
                $conexao->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            }catch(PDOException $erro){
                $conexao = null;
               echo  $erro->getMessage();
            }

            return $conexao;
        }
    };   
?>