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
$query = $conexao->conectar()->prepare("SELECT * FROM projetos");
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
  <title>Admin projetos</title>
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

      <?php if (isset($_GET["addProject"])) {  ?>
        <form method="POST" action="./adicionarProjecto.php" class="row w-50 m-auto" enctype="multipart/form-data">
          <div class="col-md-12 mb-2">
            <label for="title">Nome do projeto:</label>
            <input type="text" placeholder="Digite o nome do projeto" name="nome_projeto" class=" form-control">
          </div>

          <div class="col-md-12 mb-2">
            <label for="descrição">Descrição</label>
            <input type="text" class="form-control" name="descricao_projeto" placeholder="Breve descrição">
          </div>
          <div class="col-md-12 mb-2">
            <label for="img_projeto">Imagem do projeto:</label>
            <input type="file" class=" form-control" name="img_projeto" id="img_projeto">
          </div>
          <div class="col-md-12 mb-2">
            <label for="cate">Tecnologias utilizadas no projeto:</label><br>
            <div class="form-check form-check-inline">
              <input class="form-check-input" name="tecnologias[]" type="checkbox" id="HTML/CSS" value="HTML/CSS">
              <label class="form-check-label" for="HTML/CSS">HTML/CSS</label>
            </div>
            <div class="form-check form-check-inline">
              <input class="form-check-input" name="tecnologias[]" type="checkbox" id="JAVASCRIPT" value="JAVASCRIPT">
              <label class="form-check-label" for="JAVASCRIPT">JAVASCRIPT</label>
            </div>
            <div class="form-check form-check-inline">
              <input class="form-check-input" name="tecnologias[]" type="checkbox" id="PYTHON" value="PYTHON">
              <label class="form-check-label" for="PYTHON">PYTHON</label>
            </div><br>
            <div class="form-check form-check-inline">
              <input class="form-check-input" name="tecnologias[]" type="checkbox" id="C#" value="C#">
              <label class="form-check-label" for="C#">C#</label>
            </div>
            <div class="form-check form-check-inline">
              <input class="form-check-input" name="tecnologias[]" type="checkbox" id="PHP" value="PHP">
              <label class="form-check-label" for="PHP">PHP</label>
            </div>
            <div class="form-check form-check-inline">
              <input class="form-check-input" name="tecnologias[]" type="checkbox" id="JAVA" value="JAVA">
              <label class="form-check-label" for="JAVA">JAVA</label>
            </div>
            <div class="form-check form-check-inline">
              <input class="form-check-input" name="tecnologias[]" type="checkbox" id="SQL" value="SQL">
              <label class="form-check-label" for="SQL">SQL</label>
            </div>

          </div>
          <div class="col-md-6 mb-2">
            <label for="data_inicio">Data inicio projeto:</label>
            <input type="date" class="form-control" name="data_inicio">
          </div>
          <div class="col-md-6 mb-2">
            <label for="descrição">Data fim projeto:</label>
            <input type="date" class="form-control" name="data_fim">
          </div>

          <div>
            <label for="mais_info">Mais informações:</label>
            <textarea class="form-control" name="mais_info" id="mais_info" placeholder="OPICIONAL" cols="60" rows="8"></textarea>
          </div>


          <button class="btn col-3 btn-primary mt-2">Adicionar</button>
        </form>
      <?php }else if (isset($_GET["id"])) {  

          $id = $_GET["id"];
          $query = $conexao->conectar()->prepare("SELECT * FROM projetos WHERE id = :id");
          $query->bindParam(":id",$id);
          $query->execute();
          $projeto = $query->fetchAll(PDO::FETCH_ASSOC);
        ?>
    <h1>Edita a imagem do projeto: <span><?=$projeto[0]["nome"]?></span> </h1>
        

        <form action="editar_imagem_projeto.php" method="post" enctype="multipart/form-data">
          
        <div class="col-md-12 mb-2">
            <input type="hidden" name="id_edit_imagem" value="<?=$projeto[0]["id"]?>">
            <label for="img_projeto">Nova imagem para o projrto </label>
            <input type="file" class="form-control" name="img_edit_img_projeto" id="img_projeto">
          </div>
          <button class="btn btn-primary">Editar imagem</button>
        </form>


      
      
     <?php }else { ?>
        <h2 class="text-center">Total projectos (<?= count($result)  ?>)</h2>
        <a class="btn btn-primary" href="?addProject">Novo projeto</a>

        <?php $projetos = $conexao->conectar()->prepare("SELECT * FROM projetos");
        $projetos->execute();
        $projetos = $projetos->fetchAll(PDO::FETCH_ASSOC);

        ?>


        <div class="noticias">
          <?php foreach ($projetos as $projeto) : ?>


            <div class="noticia">
            <img src="<?= $projeto["imagem"]  ?>" alt="<?=$projeto["nome"] ?>">
            <a href="?editar_img&id=<?= $projeto["id"]?>">Editar imagem</a>
              <h3><?= $projeto["nome"] ?></h3>
              <button class="btn btn-primary" onclick="editarProjeto(<?= $projeto['id'] ?>)">Editar</button>
              <button class="btn btn-primary" onclick="visualizarProjeto(<?= $projeto['id'] ?>)">Visualizar</button>
              <form action="./delete_projetos.php" method="post">
                <input type="hidden" name="id" value="<?=$projeto["id"] ?>">
              <button class="btn btn-danger" id="btn_delete_projeto">Remover</button>
              </form>
            </div>



          <?php endforeach; ?>
        </div>



      <?php } ?>
    </div>
  </div>


    <!--MODAL DE EDITAR  PROJETOS -->
    <div class="modal modal-lg fade" id="edit_projetos" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Editar Projeto</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <form id="FormEditarProjetos" enctype="multipart/form-data">
            <input type="hidden" id="utilizador_id" class="form-control">

            <div class="mb-3">
              <label for="titulo" class="col-form-label">Nome</label>
              <input type="text" id="nome" class="form-control">
            </div>
            <div class="mb-3">
              <label for="data" class="col-form-label">Descrição:</label>
              <input type="text" class="form-control" id="descricao">
            </div>
            <div class="mb-3">
              <label for="data" class="col-form-label">Tecnologias utilizadas:</label>
              <input type="text" class="form-control" id="tecnologias_utilizadas">
            </div>
            <div class="mb-3">
             <label for="data_inicio">Data inicio</label>
             <input type="date" id="data_inicio" class="form-control">
            </div>
            <div class="mb-3">
             <label for="data_fim">Data fim</label>
             <input type="date" id="data_fim" class="form-control">
            </div>
            <div class="mb-3">
              <label for="conteudo" class="col-form-label">Informações adicionais</label>
              <textarea class="form-control" id="mais_info" cols="100" rows="8"></textarea>
            </div>
         


            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
              <button type="submit" id="btn_editar_projetos" class="btn btn-primary">Salvar</button>
            </div>
          </form>
        </div>

      </div>
    </div>
  </div>

  <!-- FIM DO MODAL EDITAR  PROJETOS -->

  <!-- MODAL VIZUALIZAR PROJETOS-->

  <div class="modal fade" id="visualizarProjeto" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered ">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Visualizar Projeto</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p class=" fw-bold">Nome: <span id="visuNome" class="fw-normal">Faklr</span></p>
                    <p class=" fw-bold">Descrição: <span id="visudesc" class="fw-normal">Faklr</span></p>
                    <p class=" fw-bold">Data_inicio: <span id="visudata_inicio" class="fw-normal">Faklr</span></p>
                    <p class=" fw-bold">Data_fim: <span id="visudata_fim" class="fw-normal">Faklr</span></p>
                    <p class=" fw-bold">Tecnologias utilizadas: <span id="visuTecnologias" class="fw-normal">Faklr</span></p>
                    <p class=" fw-bold">Informações adicionais: <span id="visumais_info" class="fw-normal">Faklr</span></p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fechar</button>
                </div>
            </div>
        </div>
    </div>



    <!-- FIM DO MODAL VIZUALIZAR PROJETOS -->


  <script src="../js/jquery.js"></script>
  <script src="../js/sweetealert2.js"></script>
  <script src="../js/Ajax.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>

  <script>
    async function editarProjeto(id) {
      const dados = await fetch("./modalEditProjeto.php?id=" + id);
      var resposta = await dados.json();
      console.log(resposta);

      var projetos = new Array();
      projetos.push(resposta["dados"][0])
      var nome = projetos[0].nome
      var descricao = projetos[0].descricao
      var data_inicio = projetos[0].data_inicio
      var data_fim = projetos[0].data_fim
      var mais_info = projetos[0].mais_info
      var tecnologias_utilizadas = projetos[0].tecnologias_utilizadas;
      var ModalEditAgenda = new bootstrap.Modal(document.getElementById("edit_projetos"))
      ModalEditAgenda.show();

      document.querySelector("#FormEditarProjetos #nome").value = nome;
      document.querySelector("#FormEditarProjetos #descricao").value = descricao;
      document.querySelector("#FormEditarProjetos #data_inicio").value = data_inicio;
      document.querySelector("#FormEditarProjetos #data_fim").value = data_fim;
      document.querySelector("#FormEditarProjetos #mais_info").value = mais_info;
      document.querySelector("#FormEditarProjetos #tecnologias_utilizadas").value = tecnologias_utilizadas;
      $("#btn_editar_projetos").attr("editar_projetos", id);


    }

    async function visualizarProjeto(id) {
      const dados = await fetch("./modalEditProjeto.php?id=" + id);
      var resposta = await dados.json();
      console.log(resposta);

      var projetos = new Array();
      projetos.push(resposta["dados"][0])
      var nome = projetos[0].nome
      var descricao = projetos[0].descricao
      var data_inicio = projetos[0].data_inicio
      var data_fim = projetos[0].data_fim
      var mais_info = projetos[0].mais_info
      var tecnologias_utilizadas = projetos[0].tecnologias_utilizadas;
      var ModalEditAgenda = new bootstrap.Modal(document.getElementById("visualizarProjeto"))
      ModalEditAgenda.show();

      document.querySelector("#visuNome").innerHTML = nome;
      document.querySelector("#visudesc").innerHTML = descricao;
      document.querySelector("#visudata_inicio").innerHTML = data_inicio;
      document.querySelector("#visudata_fim").innerHTML = data_fim;
      document.querySelector("#visumais_info").innerHTML = mais_info;
      document.querySelector("#visuTecnologias").innerHTML = tecnologias_utilizadas;
    }
  </script>


</body>

</html>