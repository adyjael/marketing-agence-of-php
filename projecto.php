<?php include("./templates/header.php")  ?>

<?php
include_once("./config/conection.php");
$conexao = new Conexao();

?>
<div class="p-3 w-100" style="background-color: #ccc;">
    <div class="container">
        <h3>Projetos</h3>
    </div>
</div>

<div class="container mt-2">
    <?php
    $query = $conexao->conectar()->prepare("SELECT * FROM projetos");
    $query->execute();
    $projetos = $query->fetchAll(PDO::FETCH_ASSOC);
    ?>
    <section class="empresa mt-4">
        <h3 class="mt-4 mb-3 text-center">Projetos realizados pela nossa empresa</h3>
        <div class="empresa_projeto mt-5">

            <?php foreach ($projetos as $projeto) : ?>
                <div class="projeto">
                    <h3><?= $projeto["nome"] ?></h3>
                    <div id="gallery">
                        <a href="./Admin/<?= $projeto['imagem'] ?>" data-fancybox>
                            <img src="./Admin/<?= $projeto['imagem'] ?>" alt="<?= $projeto['nome'] ?>" />
                        </a>
                        <a class="btn" href="#visualizar-projeto" onclick="visualizarProjeto(<?= $projeto['id'] ?>)">Visualizar</a>

                    </div>
                </div>
            <?php endforeach;  ?>

        </div>
        <!-- MODAL VIZUALIZAR PROJETOS-->

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


        <script>
            async function visualizarProjeto(id) {
                const dados = await fetch("Admin/modalEditProjeto.php?id=" + id);
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
                document.querySelector(".visu").innerHTML = nome;
                document.querySelector("#visudesc").innerHTML = descricao;
                document.querySelector("#visudata_inicio").innerHTML = data_inicio;
                document.querySelector("#visudata_fim").innerHTML = data_fim;
                document.querySelector("#visumais_info").innerHTML = mais_info;
                document.querySelector("#visuTecnologias").innerHTML = tecnologias_utilizadas;
            }
        </script>

        <?php include_once("./templates/footer.php")  ?>