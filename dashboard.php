<?php
include_once("./config/conection.php");
include_once("./templates/header.php");

if (isset($_SESSION["user"]) && is_array($_SESSION["user"])) {

  $nome = $_SESSION["user"][0];
  $adm  = $_SESSION["user"][1];
  $id = $_SESSION["user"][2];
} else {
  echo "<script>window.location = './account/login.php'</script>";
}
?>

<div class="container mt-2">
  <div class="row mx-4">
    <div class="custon col-md-12" style="height: 60px;">
      <h2>Bem vindo ao nosso site <?= $nome ?></h2>
    </div>
  </div>
  <div class="row-4 mx-4 mt-4">
    <div class="custon col-md-4">
      <h3>Meus Agendamentos</h3>
      <?php
      $conexao = new Conexao();
      $query = $conexao->conectar()->prepare("SELECT * FROM clientes_agenda WHERE utilizador_id = :utilizador_id");
      $query->bindParam(":utilizador_id", $id);
      $query->execute();

      if ($query->rowCount()) {
        $agendas = $query->fetchAll();
      ?>
        <span><?= count($agendas) ?></span> <span><i class="fa-regular fa-calendar-days"></i> </span><br>
        <a class="btn btn-primary w-50" href="agendamento.php">Ver</a>
    </div>
  <?php  } else { ?>
    <span>0</span> <span><i class="fa-regular fa-calendar-days"></i> </span><br>
    <a class="btn btn-primary w-50" href="agendamento.php">Marcar</a>
  </div>
<?php } ?>
</div>
</div>

