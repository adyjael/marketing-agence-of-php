<?php include("./templates/header.php")  ?>

<?php
include_once("./config/conection.php");
$conexao = new Conexao();
?>
<?php
if (isset($_GET["titulo"])) {

  setlocale(LC_TIME, 'pt_BR', 'pt_BR.utf-8', 'pt_BR.utf-8', 'portuguese');
  date_default_timezone_set('America/Sao_Paulo');

  $titulo = $_GET["titulo"];
  $query = $conexao->conectar()->prepare("SELECT * FROM noticias WHERE titulo_url = :titulo");
  $query->bindParam(":titulo", $titulo);
  $query->execute();

  $noticias = $query->fetchAll(PDO::FETCH_ASSOC);
?>
  <?php foreach ($noticias as $noticia) :  ?>

    <div class=" text-center bg-image" style="
      background-image: url('./Admin/<?= $noticia["imagem"] ?>');
      height: 600px;
    ">
      <div class="mask" style="background-color: rgba(0, 0, 0, 0.6);height:600px;">
        <div class="d-flex justify-content-center align-items-center h-100">
          <div class="text-white">
            <h1 class="mb-3"><?= $noticia["titulo"] ?></h1>
            <img style="border-radius: 50%;" src="https://secure.gravatar.com/avatar/3039a72a3b1773c080cc6c8d36228e7f?s=80&d=mm&r=g" alt="">
            <h4 class="mb-3">Adyjael neto</h4>
            <p class=" fs-3 fw-bold"><?= strftime('%A, %d de %B de %Y', strtotime($noticia["data"])); ?></p>
          </div>
        </div>
      </div>
      <div class="imgi">
        <img class="mt-5" src="./Admin/<?= $noticia["imagem"] ?>" alt="">
        <div>
          <p class="content_not"><?= $noticia["conteudo"] ?></p>
        </div>
      </div>

      <?php include_once("./templates/footer.php")  ?>
    </div>

  <?php endforeach; ?>

<?php } else { ?>


  <div class="p-3 w-100" style="background-color: #ccc;">
    <div class="container">
      <h3>Noticia</h3>
    </div>
  </div>

  <div class="container mt-2">
    <?php
    $query = $conexao->conectar()->prepare("SELECT * FROM noticias ORDER BY id DESC");
    $query->execute();
    $noticias = $query->fetchAll(PDO::FETCH_ASSOC);
    ?>
    <div class="blog mt-5">
      <div class="blog_content">
        <?php foreach ($noticias as $noticia) :  ?>
          <div>
            <img src="./Admin/<?= $noticia["imagem"] ?>" alt="<?= $noticia["titulo"] ?>">
            <a href="?titulo=<?= $noticia["titulo_url"] ?>"><?= $noticia["titulo"] ?></a>
            <p><?= $noticia["descricao"] ?></p>
            <div>
              <a href="?titulo=<?= $noticia["titulo_url"] ?>" class="btn">Ler mais</a>
            </div>
          </div>

        <?php endforeach; ?>

      </div>
    </div>

  </div>
  <?php include_once("./templates/footer.php")  ?>
<?php } ?>