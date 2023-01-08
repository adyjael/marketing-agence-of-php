<?php

include_once("./config/conection.php");

$conexao = new Conexao;
$query = $conexao->conectar()->prepare('SELECT * FROM projetos  LIMIT 3 ');
$query->execute();
$result = $query->fetchAll(PDO::FETCH_ASSOC);

?>

<?php include("./templates/header.php")  ?>
<div class="container">

    <div class="baner">

        <div class="content_baner">
            <h1>Marketing <br> strategy</h1>
            <p>Utilizamos dados para acelerar o crescimento das empresas implementando estratégias criativas e inovadoras de marketing digital.</p>
            <a class="btn" href="./agendamento.php">Marcar conversa</a>
        </div>
        <div class="img_baner">
            <img width="500px" class="tbhn" src="./img/thumb_1.png" alt="">
        </div>
    </div>

    <div class="ultimas_not mt-3 mb-5">
        <h2>Ultimas noticias</h2>
        <?php $query = $conexao->conectar()->prepare("SELECT titulo,titulo_url,imagem FROM noticias ORDER BY id DESC LIMIT 5");
        $query->execute();
        $noticia = $query->fetchAll(PDO::FETCH_ASSOC);

        foreach ($noticia as $not) : ?>
            <div class="minipost  mt-5">
                <img src="./Admin/<?= $not['imagem'] ?>" alt="">
                <a href="noticias.php?titulo=<?= $not["titulo_url"] ?>"><?= $not["titulo"] ?></a><br>
            </div>

        <?php endforeach;  ?>
    </div>

    <section class="empresa mt-5">
        <h2 class="">Projetos</h2>
        <div class="empresa_projeto" id="empresa_projeto">

            <?php foreach ($result as $projeto) : ?>
                <div class="projeto mt-5">
                    <h3><?= $projeto["nome"] ?></h3>
                    <div id="gallery">
                        <a href="./Admin/<?= $projeto['imagem'] ?>" data-fancybox>
                            <img src="./Admin/<?= $projeto['imagem'] ?>" alt="<?= $projeto['nome'] ?>" />
                        </a>
                        <a class="btn" href="#" onclick="visualizarProjeto('<?= $projeto['id'] ?>')">Sobre o projeto</a>
                    </div>
                </div>
            <?php endforeach;  ?>


        </div>
    </section>

</div>

<div class="modal fade" id="visualizarProjeto" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered ">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title visu" id="exampleModalLabel">Visualizar Projeto</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p class=" fw-bold">Nome: <span id="visuNome" class="fw-normal">Faklr</span></p>
                <p class=" fw-bold">Descrição: <span id="visudesc" class="fw-normal">Faklr</span></p>
                <p class=" fw-bold">Inicio do projeto: <span id="visudata_inicio" class="fw-normal">Faklr</span></p>
                <p class=" fw-bold">Fim do projeto: <span id="visudata_fim" class="fw-normal">Faklr</span></p>
                <p class=" fw-bold">Tecnologias utilizadas: <span id="visuTecnologias" class=" fw-normal">Faklr</span></p>
                <p class=" fw-bold">Informações adicionais: <span id="visumais_info" class=" fw-normal">Faklr</span></p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fechar</button>
            </div>
        </div>
    </div>
</div>



<!-- FIM DO MODAL VIZUALIZAR PROJETOS -->

<script>
    async function visualizarProjeto(id) {
        const dados = await fetch("Admin/modalEditProjeto.php?id=" + id);
        var resposta = await dados.json();
        console.log(resposta);
        var projetos = new Array();
        projetos.push(resposta["dados"][0])
        var nome = projetos[0].nome
        var descricao = projetos[0].descricao
        var mais_info = projetos[0].mais_info
        var tecnologias_utilizadas = projetos[0].tecnologias_utilizadas;
        var formatter = new Intl.DateTimeFormat('pt-BR');
        var data_in = new Date(projetos[0].data_inicio);
        var data_inicio = formatter.format(data_in);
        var data_fi = new Date(projetos[0].data_fim);
        var data_fim = formatter.format(data_fi);
        var ModalEditAgenda = new bootstrap.Modal(document.getElementById("visualizarProjeto"))
        ModalEditAgenda.show();

        document.querySelector("#visuNome").innerHTML = nome;
        document.querySelector(".visu").innerHTML = nome;
        document.querySelector("#visudesc").innerHTML = descricao;
        document.querySelector("#visudata_inicio").innerHTML = data_inicio;
        document.querySelector("#visudata_fim").innerHTML = data_fim;
        document.querySelector("#visumais_info").innerHTML = mais_info;
        document.querySelector("#visuTecnologias").innerHTML = tecnologias_utilizadas;
    }
</script>

<?php include("./templates/footer.php")  ?>