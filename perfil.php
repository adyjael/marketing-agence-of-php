<?php
include_once("./config/conection.php");
include("./templates/header.php");
if (isset($_SESSION["user"]) && is_array($_SESSION["user"])) {

  $nome = $_SESSION["user"][0];
  $adm  = $_SESSION["user"][1];
  $id = $_SESSION["user"][2];
} else {
  echo "<script>window.location = './account/login.php'</script>";
}

?>
  <?php
  $conexao = new Conexao();
  $query = "SELECT * FROM utilizadores WHERE id = :id LIMIT 1";
  $stmt = $conexao->conectar()->prepare($query);
  $stmt->bindParam(":id", $id);
  $stmt->execute();

  $utilizador = $stmt->fetchAll(PDO::FETCH_ASSOC)[0];
  ?>


    <div class="container mt-5">
      <div class="conta d-flex flex-column justify-content-center align-items-center">
        <div class="img">
          <i class="fa-solid fa-user"></i><br>
          <span><?= $utilizador["nome"] ?></span>
        </div>
        <form class="info row w-75 m-auto" id="formEditUser">
          <input type="hidden" id="id" value="<?= $id ?>">
          <div class="col-md-6 mt-2">
            <label for="nome">Nome</label>
            <input value="<?= $utilizador["nome"] ?>" id="nome" type="text" class="form-control" disabled>
          </div>
          <div class="col-md-6 mt-2">
            <label for="apelido">Apelido</label>
            <input value="<?= $utilizador["apelido"] ?>" id="apelido" type="text" class="form-control" disabled>
          </div>
          <div class="col-md-6 mt-2">
            <label for="tel">Telemovel</label>
            <input value="<?= $utilizador["tel"] ?>" id="tel" type="text" class="form-control " disabled>
          </div>
          <div class="col-md-6 mt-2">
            <label for="email">Email</label>
            <input value="<?= $utilizador["email"] ?>" type="text" class="form-control " disabled>
          </div>
          <div class="col-md-6 mt-2">
            <input id="editar" value="Editar" type="button" class="btn btn-primary">
            <input disabled id="btn_edit_user" class="btn btn-primary" value="Salvar" type="button">
          </div>
        </form>
      </div>
      <div class="senha mt-3 justify-content-center align-items-center">
          <h3 class="text-center">Mudar senha</h3>
        <form id="formEditSenhaUser" class="row w-75 m-auto">
          <input type="hidden" id="id" value="<?= $id ?>">
          <div class="col-md-6">
            <label for="novasenha">Nova senha</label>
            <input type="text" id="nova_senha" class=" form-control">
          </div>
          <div class="col-md-6">
            <label for="confirmar_senha">Confirmar senha</label>
           <input type="text" id="confirmar_senha" class=" form-control">
          </div>
          <div class="col-md-6">
          <button id="btn_edit_user_senha" class="btn mt-2 btn-primary">Salvar senha</button>
          </div>
        </form>
      </div>
    </div>

  <script src="./js/jquery.js"></script>
  <script src="./js/sweetealert2.js"></script>
  <script src="./js/Ajax.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
  <script>
    $("#editar").on("click", function() {
      document.getElementById("nome").disabled = false;
      document.getElementById("apelido").disabled = false;
      document.getElementById("tel").disabled = false;
      document.getElementById("btn_edit_user").disabled = false
      document.getElementById("editar").disabled = true;
    })
  </script>
</body>

</html>