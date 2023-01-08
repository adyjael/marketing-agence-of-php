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
$query = $conexao->conectar()->prepare("SELECT * FROM noticias");
$query->execute();
$result = $query->fetchAll(PDO::FETCH_ASSOC);



?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <link type="image/png" sizes="16x16" rel="icon" href="../img/favicon/icons8-dashboard-layout-16.png">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="../css/header.css">
  <link rel="stylesheet" href="../css/noticias.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css" integrity="sha512-xh6O/CkQoPOWDdYTDqeRdPCVd1SpvCA9XXcUnZS2FmJNp1coAFzvtCN9BmamE+4aHK8yyUHUSCcJHgXloTyT2A==" crossorigin="anonymous" referrerpolicy="no-referrer" />
  <link rel="stylesheet" href="../css/bootstrap.css">
  <title>Admin noticias</title>
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
    <div class=" container mt-2">

      <?php if (isset($_GET["addPost"])) {  ?>
        <form method="POST" action="./publicar_noticias.php" class="row" enctype="multipart/form-data">
          <div class="col-md-6 mb-2">
            <label for="title">Titulo da noticia:</label>
            <input type="text" name="titulo" class=" form-control">
          </div>
          <div class="col-md-6 mb-2">
            <label for="descrição">Descrição</label>
            <input type="text" class="form-control" name="descricao" placeholder="Breve descrição">
          </div>
          <div class="col-md-6 mb-2">
            <label for="image">Capa da noticia:</label>
            <input type="file" class=" form-control" name="capa_noticia" id="capa_noticia">
          </div>
          <div class="col-md-6 mb-2">
            <label for="cate">Categoria</label>
            <select class="form-control" name="categoria" id="categoria">
              <option value="Selecione a categoria" selected disabled>Selecione a categoria</option>
              <?php
              $categorias = $conexao->conectar()->prepare("SELECT * FROM categoria");
              $categorias->execute();
              $categorias = $categorias->fetchAll(PDO::FETCH_ASSOC);
              foreach ($categorias as $categoria) :
              ?>
                <option value="<?= $categoria["categoria"] ?>"><?= $categoria["categoria"] ?></option>

              <?php endforeach;  ?>
            </select>
          </div>
          <div>
            <label for="Conteudo">Conteudo:</label>
            <textarea name="conteudo" id="editor" cols="30" rows="20"></textarea>
          </div>


          <button class="btn col-3 btn-primary mt-2">Publicar</button>
        </form>

      <?php } elseif (isset($_GET["titulo"])) {
        $titulo = $_GET["titulo"];

        $query = $conexao->conectar()->prepare("SELECT * FROM noticias WHERE titulo_url = :titulo");
        $query->bindParam(":titulo", $titulo);
        $query->execute();

        $noticias = $query->fetchAll(PDO::FETCH_ASSOC);

      ?>
        <?php foreach ($noticias as $noticia) :  ?>
          <div class=" col-md-8">

            <p><?= $noticia["descricao"] ?></p>
            <h3>Conteudo</h3>
            <?= $noticia["conteudo"] ?>
            <p><?= date("d/m/Y", strtotime($noticia["data"])) ?></p>
            <p><?= date("H:i", strtotime($noticia["hora"])) ?></p>
          </div>

        <?php endforeach; ?>

      <?php } else if (isset($_GET["id"]) && !empty($_GET["id"])) {

        $id = $_GET["id"];
        $query = $conexao->conectar()->prepare("SELECT * FROM noticias WHERE id = :id");
        $query->bindParam(":id", $id);
        $query->execute();
        $noticias = $query->fetchAll(PDO::FETCH_ASSOC);
      ?>
        <h1>Edita a imagem da noticia: <span><?= $noticias[0]["titulo"] ?></span> </h1>


        <form action="editar_imagem_noticias.php" method="post" enctype="multipart/form-data">

          <div class="col-md-12 mb-2">
            <input type="hidden" name="id_edit_imagem" value="<?= $noticias[0]["id"] ?>">
            <label for="img_projeto">Nova imagem da noticia </label>
            <input type="file" class="form-control" name="img_edit_img_noticias" id="img_projeto">
          </div>
          <button class="btn btn-primary">Editar imagem</button>
        <?php } else { ?>
          <h2 class="text-center">Total noticias (<?= count($result)  ?>)</h2>
          <a class="btn btn-primary" href="noticias.php?addPost">Nova noticia</a>

          <?php $noticias = $conexao->conectar()->prepare("SELECT * FROM noticias");
          $noticias->execute();
          $noticias = $noticias->fetchAll(PDO::FETCH_ASSOC); ?>
          <div class="noticias">
            <?php foreach ($noticias as $noticia) : ?>

              <div class="noticia">
                <img src="<?= $noticia["imagem"]  ?>" alt="<?= $noticia["titulo"] ?>">
                <a href="?editar_imagem&id=<?= $noticia["id"] ?>">Editar imagem </a>

                <h3><a href="../noticias.php?titulo=<?= $noticia["titulo_url"] ?>"><?= $noticia["titulo"] ?></a></h3>
                <p><?= $noticia["descricao"] ?></p>
                <div class="span">
                  <span>Categoria: <a href="#"><?= $noticia["categoria"] ?></a></span>
                  <span><?= date("d/m/Y", strtotime($noticia["data"])) ?></span>
                </div>
                <button class="btn btn-primary" onclick="editNoticias(<?= $noticia['id'] ?>)">Editar</button>

                <form action="./delete_noticias.php" method="post">
                  <input type="hidden" name="id" value="<?= $noticia["id"] ?>">
                  <button class="btn btn-danger" id="btn_delete_noticias">Remover</button>
                </form>
              </div>

            <?php endforeach; ?>
          </div>

        <?php  } ?>
    </div>
  </div>




  <!--MODAL DE EDITAR  NOTICIAS -->
  <div class="modal modal-lg fade" id="edit_nuticia" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Editar noticia</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <form id="FormEditarNoticias" enctype="multipart/form-data">
            <input type="hidden" id="utilizador_id" class="form-control">

            <div class="mb-3">
              <label for="titulo" class="col-form-label">Titulo</label>
              <input type="text" id="titulo" class="form-control">
            </div>
            <div class="mb-3">
              <label for="data" class="col-form-label">Descrição:</label>
              <input type="text" class="form-control" id="descricao">
            </div>
            <div class="mb-3">
              <label for="hora" class="col-form-label">Categoria</label>
              <select class="form-control" id="categoria">
                <?php
                $categoria = $conexao->conectar()->prepare("SELECT * FROM categoria");
                $categoria->execute();
                $categoria = $categoria->fetchAll(PDO::FETCH_ASSOC);
                foreach ($categoria as $cate) :
                ?>
                  <option value="<?= $cate["categoria"] ?>"><?= $cate["categoria"] ?></option>

                <?php endforeach;  ?>
              </select>

            </div>
            <div class="mb-3">
              <label for="conteudo" class="col-form-label">Conteudo</label>
              <textarea name="conteudo" id="conteudo" cols="100" rows="20"></textarea>
            </div>



            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
              <button type="submit" id="btn_editar_noticias" class="btn btn-primary">Editar noticias</button>
            </div>
          </form>
        </div>

      </div>
    </div>
  </div>

  <!-- FIM DO MODAL EDITAR  NOTICIAS -->



  <script src="../js/jquery.js"></script>
  <script src="../ckeditor/ckeditor.js"></script>
  <script src="../ckeditor/samples/js/sample.js"></script>
  <script src="../js/sweetealert2.js"></script>
  <script src="../js/Ajax.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
  <script>
    initSample();


    async function editNoticias(id) {
      const dados = await fetch("./modalEditNoticias.php?id=" + id);
      var resposta = await dados.json();
      console.log(resposta)

      var noticia = new Array();
      noticia.push(resposta["dados"][0])
      var titulo = noticia[0].titulo
      var conteudo = noticia[0].conteudo
      var descricao = noticia[0].descricao
      var categoria = noticia[0].categoria

      var ModalEditAgenda = new bootstrap.Modal(document.getElementById("edit_nuticia"))
      ModalEditAgenda.show();
      document.querySelector("#FormEditarNoticias #titulo").value = titulo;
      document.querySelector("#FormEditarNoticias #descricao").value = descricao;
      document.querySelector("#FormEditarNoticias #conteudo").value = conteudo
      $("#categoria option:selected").text(categoria)

      $("#btn_editar_noticias").attr("editar_noticias", id);


    }
  </script>
</body>

</html>