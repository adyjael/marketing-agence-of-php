<?php

include_once("../config/conection.php");
session_start();

if (isset($_SESSION["user"]) && is_array($_SESSION["user"])) {


  $adm  = $_SESSION["user"][1];
  $nome = $_SESSION["user"][0];
  if ($adm != 0) {
    session_destroy();
    echo "<script>window.location = '../account/login.php'</script>";
  }
} else {
  echo "<script>window.location = '../account/login.php'</script>";
}

$conexao = new Conexao();
$query = $conexao->conectar()->prepare("SELECT * FROM utilizadores");
$query->execute();
$result = $query->fetchAll();



?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <link type="image/png" sizes="16x16" rel="icon" href="../img/favicon/icons8-dashboard-layout-16.png">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="../css/header.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css" integrity="sha512-xh6O/CkQoPOWDdYTDqeRdPCVd1SpvCA9XXcUnZS2FmJNp1coAFzvtCN9BmamE+4aHK8yyUHUSCcJHgXloTyT2A==" crossorigin="anonymous" referrerpolicy="no-referrer" />
  <link rel="stylesheet" href="../css/bootstrap.css">
  <title>Dashboard Admin</title>
  <style>

  </style>
</head>

<body>

  <header id="header" class="header">
    <i id="menu" class="fa-solid fa-bars"></i>
    <h3>Painel admin</h3>

    <a class="right" href="../account/logout.php">Sair</a>

  </header>

  <div class="sidenav" id="sidenav">
    <a href="../Admin/"><i class="fa-solid fa-house"></i> Admin</a>
    <a href="../Admin/agemdamento.php"> <i class="fa-regular fa-calendar-days"></i> Agendamento</a>
    <a href="../Admin/project.php"><i class="fa-solid fa-stairs"></i> Projetos</a>
    <a href="../Admin/noticias.php"><i class="fa-solid fa-newspaper"></i> Notícias</a>
    <a href="../Admin/user.php"><i class="fa-solid fa-user"></i> Utilizadores</a>

  </div>


  <div class="main">
    <div class="container mt-2">
      <div class="row mx-4">
        <div class="custon col-md-12" style="height: 60px;">
          <h2>Bem vindo ao seu painel <?= $nome ?></h2>
        </div>
      </div>
      <div class="row mx-4 mt-3">
        <div class="custon me-5 mb-5 col-md-5">
          <h3>Total Agendamentos</h3>
          <?php
          $conexao = new Conexao();
          $query = $conexao->conectar()->prepare("SELECT * FROM clientes_agenda");
          $query->execute();
          $agendas = $query->fetchAll();
          ?>
          <span><?= count($agendas) ?></span> <span><i class="fa-regular fa-calendar-days"></i> </span><br>
          <a class="btn btn-primary w-50" href="agemdamento.php">Ver</a>
        </div>
        <div class="custon mb-5  col-md-5">
          <h3>Total Utilizadores</h3>
          <?php
          $query = $conexao->conectar()->prepare("SELECT * FROM utilizadores");
          $query->execute();
          $utilizadores = $query->fetchAll();
          ?>
          <span><?= count($utilizadores) ?></span> <span><i class="fa-regular fa-calendar-days"></i> </span><br>
          <a class="btn btn-primary w-50" href="user.php">Ver</a>
        </div>

        <div class="custon me-5 col-md-5">
          <h3>Total Noticias</h3>
          <?php
          $query = $conexao->conectar()->prepare("SELECT * FROM noticias");
          $query->execute();
          $noticias = $query->fetchAll();
          ?>
          <span><?= count($noticias) ?></span> <span><i class="fa-regular fa-calendar-days"></i> </span><br>
          <a class="btn btn-primary w-50" href="noticias.php">Ver</a>
        </div>
        <div class="custon me-2 col-md-5">
          <h3>Total Projetos</h3>
          <?php
          $query = $conexao->conectar()->prepare("SELECT * FROM projetos");
          $query->execute();
          $projetos = $query->fetchAll();
          ?>
          <span><?= count($projetos) ?></span> <span><i class="fa-regular fa-calendar-days"></i> </span><br>
          <a class="btn btn-primary w-50" href="project.php">Ver</a>
        </div>
      </div>
    </div>
  </div>
  </div>


  <script src="../js/jquery.js"></script>
  <script src="../js/sweetealert2.js"></script>
  <script src="../js/Ajax.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>

</body>

</html>