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
    <title>Admim Agendamentos</title>
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
        <div class="container">
            <?php
            $conexao = new Conexao();
            $query = $conexao->conectar()->prepare("SELECT * FROM clientes_agenda ORDER BY data");
            $query->execute();

            if ($query->rowCount()) {
                $agemdamentos = $query->fetchAll();
            ?>
                <div class=" d-flex justify-content-around my-2">
                    <h3>Todos os agemdemantos (<?= count($agemdamentos) ?>)</h3>
                    <h3 class="h3_agenda" style="margin-right: 70px;"><a style="text-decoration: none;color:#51b3ec;" href="#marcaragendamento" data-bs-toggle="modal" data-bs-target="#addAgendaModal"><i class="fa-solid fa-circle-plus"></i> Nova Agenda</a></h3>
                </div>

                <table class="table mt-3 table-striped table-responsive-sm">
                    <thead>

                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Assunto</th>
                            <th scope="col">Data</th>
                            <th scope="col">Hora</th>
                            <th scope="col">Nome do utilizador</th>
                            <th scope="col">Ações</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($agemdamentos as $agemdamento) :  ?>
                            <tr>
                                <th scope="row"><?= $agemdamento["id"] ?></th>
                                <td><?= $agemdamento["titulo"] ?></td>
                                <td><?php

                                    $data_inicial = date("Y/m/d", strtotime($agemdamento["data"]));
                                    $data_final = date("Y/m/d");

                                    $diferenca = strtotime($data_inicial) - strtotime($data_final);
                                    $dias = floor($diferenca / (60 * 60 * 24));
                                        if($dias == 0){
                                            echo "<span class=' text-primary'>Está marcação é hoje " . date("d/m/Y", strtotime($agemdamento["data"])) . "</span>";
                                        }else if($dias < 0){
                                            echo "<span class=' text-danger'>Ja foi realizada no dia " . date("d/m/Y", strtotime($agemdamento["data"])) . "</span>";
                                        }
                                        
                                        else{
                                            echo date("d/m/Y", strtotime($agemdamento["data"]));
                                        }
                                    ?></td>
                                <td><?= date("H:i", strtotime($agemdamento["hora"])) ?></td>
                                <td>
                                    <?php
                                    $utilizador = $conexao->conectar()->prepare("SELECT nome,apelido FROM utilizadores WHERE id = ?");
                                    $utilizador->execute(array($agemdamento["utilizador_id"]));
                                    $nomeUtilizador = $utilizador->fetch();
                                    print_r($nomeUtilizador["nome"] . " " . $nomeUtilizador["apelido"]);
                                    ?>
                                </td>
                                <td><button onclick="visualizar(<?= $agemdamento['id'] ?>)" class=" btn btn-outline-secondary">Vizualizar</button>
                                    <button onclick="editarAgenda(<?= $agemdamento['id'] ?>)" class="btn btn-outline-primary">Editar</button>
                                    <button delete="<?= $agemdamento["id"] ?>" class="btn btn-outline-danger btn_delete_agenda">Remover</button>
                                </td>
                            </tr>

                        <?php endforeach;  ?>
                    </tbody>
                </table>
            <?php } else { ?>
                <div class="mt-5">
                    <h3>Os utulizadores ainda não fizeram agemdamentos </h3>
                    <h3 class="h3_agenda" style="margin-right: 70px;"><a style="text-decoration: none;color:#51b3ec;" href="#marcaragendamento" data-bs-toggle="modal" data-bs-target="#addAgendaModal"><i class="fa-solid fa-circle-plus"></i> Nova Agenda</a></h3>
                </div>
            <?php
            } ?>
        </div>
    </div>


    <!-- MODAIS ----------------------------------MODAIS -->


    <!-- MODAL DE MARCAR AGENDAMENTO -->

    <div class="modal modal-lg fade" id="addAgendaModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Marcar Agendamento</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="formAgenda">

                        <!-- <input type="hidden" id="utilizador_id" value="<? //$id 
                                                                            ?>" class="form-control"> -->
                        <select class="form-control" name="" id="utilizador_id">
                            <option value="0" selected>Selecione o utilizador</option>
                            <?php
                            $query = $conexao->conectar()->prepare('SELECT id, nome,apelido FROM utilizadores WHERE adm > 0');
                            $query->execute();
                            $result = $query->fetchAll(PDO::FETCH_ASSOC);
                            print_r($result);
                            foreach ($result as $utilizador) :
                            ?>

                                <option value="<?= $utilizador["id"] ?>"><?= $utilizador["nome"] . " " . $utilizador["apelido"] ?></option>
                            <?php endforeach; ?>
                        </select>
                        <div class="mb-3">
                            <label for="titulo" class="col-form-label">Titilo:</label>
                            <input type="text" id="titulo" class="form-control">
                        </div>
                        <div class="mb-3">
                            <label for="data" class="col-form-label">Data:</label>
                            <input type="date" class="form-control" id="data">
                        </div>
                        <div class="mb-3">
                            <label for="hora" class="col-form-label">Hora:</label>
                            <select class="form-control" name="" id="hora">
                                <option value="0">Selecione a hora</option>
                                <option value="08:00">08:00</option>
                                <option value="08:30">08:30</option>
                                <option value="09:00">09:00</option>
                                <option value="09:30">09:30</option>
                                <option value="10:00">10:00</option>
                                <option value="10:30">10:30</option>
                                <option value="11:00">11:00</option>
                                <option value="11:30">11:30</option>
                                <option value="13:00">13:00</option>
                                <option value="13:30">13:30</option>
                                <option value="14:00">14:00</option>
                                <option value="14:30">14:30</option>
                                <option value="15:00">15:00</option>
                                <option value="15:30">15:30</option>
                                <option value="16:00">16:00</option>
                                <option value="16:30">16:30</option>
                                <option value="17:00">17:00</option>
                                <option value="17:30">17:30</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="message-text" class="col-form-label">Dados do Agendamento:</label>
                            <textarea rows="4" class="form-control" id="message-text"></textarea>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fechar</button>
                            <button type="submit" id="btn_agendar" class="btn btn-primary">Marcar</button>
                        </div>
                    </form>
                </div>

            </div>
        </div>
    </div>

    <!-- FIM DO MODAL DE MARCAR AGENDAMENTO -->

    <!--MODAL DE EDITAR AGENDAMENTO -->
    <div class="modal modal-lg fade" id="editAgenda" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Editar Agendamento</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="formEditAgenda">
                        <input type="hidden" id="utilizador_id" class="form-control">

                        <div class="mb-3">
                            <label for="titulo" class="col-form-label">Titilo:</label>
                            <input type="text" id="editTitulo" class="form-control">
                        </div>
                        <div class="mb-3">
                            <label for="data" class="col-form-label">Data:</label>
                            <input type="date" class="form-control" id="editData">
                        </div>
                        <div class="mb-3">
                            <label for="hora" class="col-form-label">Hora:</label>
                            <select class="form-control" name="" id="editHora">
                                <option value="08:00">08:00</option>
                                <option value="08:30">08:30</option>
                                <option value="09:00">09:00</option>
                                <option value="09:30">09:30</option>
                                <option value="10:00">10:00</option>
                                <option value="10:30">10:30</option>
                                <option value="11:00">11:00</option>
                                <option value="11:30">11:30</option>
                                <option value="13:00">13:00</option>
                                <option value="13:30">13:30</option>
                                <option value="14:00">14:00</option>
                                <option value="14:30">14:30</option>
                                <option value="15:00">15:00</option>
                                <option value="15:30">15:30</option>
                                <option value="16:00">16:00</option>
                                <option value="16:30">16:30</option>
                                <option value="17:00">17:00</option>
                                <option value="17:30">17:30</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="message-text" class="col-form-label">Dados do Agendamento:</label>
                            <textarea rows="4" class="form-control" id="edit-message-text"></textarea>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                            <button type="submit" id="btn_edit_agendar" class="btn btn-primary">Salvar</button>
                        </div>
                    </form>
                </div>

            </div>
        </div>
    </div>
    <!--FIM DO MODAL DE EDITAR AGENDAMENTO -->

    <!-- MODAL VIZUALIZAR AGENDAMENTO-->

    <div class="modal fade" id="visualizarAgenda" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered ">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Visualizar Marcação</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p class=" fw-bold">Assunto: <span id="visuassunto" class=" fw-light">Faklr</span></p>
                    <p class=" fw-bold">Data: <span id="visudata" class=" fw-light">Faklr</span></p>
                    <p class=" fw-bold">hora: <span id="visuhora" class=" fw-light">Faklr</span></p>
                    <p class=" fw-bold">Descrição: <span id="visudesc" class=" fw-light">Faklr</span></p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fechar</button>
                </div>
            </div>
        </div>
    </div>
    <!-- FIM DO MODAL VIZUALIZAR AGENDAMENTO -->

    <script src="../js/jquery.js"></script>
    <script src="../js/sweetealert2.js"></script>
    <script src="../js/Ajax.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    <script>
        async function editarAgenda(id) {
            const dados = await fetch("./modalEditAgenda.php?id=" + id)
            var resposta = await dados.json();
            console.log(resposta)

            if (resposta["erro"]) {

                Swal.fire({
                    icon: "error",
                    title: "Oops...",
                    text: resposta["msg"],
                });

            } else {
                var agendas = new Array();
                agendas.push(resposta["dados"][0])
                var edit_titulo = agendas[0].titulo
                var edit_data = agendas[0].data
                var edit_descricao = agendas[0].descricao
                var edit_hora = agendas[0].hora


                var ModalEditAgenda = new bootstrap.Modal(document.getElementById("editAgenda"))
                ModalEditAgenda.show();
                document.querySelector("#editTitulo").value = edit_titulo;
                //document.querySelector("#editHora").value = edit_hora;
                document.querySelector("#editData").value = edit_data;
                $("#editHora option:selected").text(edit_hora)
                document.querySelector("#edit-message-text").value = edit_descricao;
                $("#btn_edit_agendar").attr("edit_id", id)
                // document.getElementById("editTitulo").value = 
            }
        };

        async function visualizar(id) {
            const dados = await fetch("../modalEditAgenda.php?id_vizu=" + id)
            var resposta = await dados.json();
            console.log(resposta)

            if (resposta["erro"]) {

                Swal.fire({
                    icon: "error",
                    title: "Oops...",
                    text: resposta["msg"],
                });

            } else {
                var agendas = new Array();
                agendas.push(resposta["dados"][0])
                var visu_titulo = agendas[0].titulo
                var visu_data = new Date(agendas[0].data).toLocaleDateString()
                var visu_descricao = agendas[0].descricao
                var visu_hora = agendas[0].hora
                console.log(new Date(agendas[0].hora).toLocaleDateString())



                var ModalEditAgenda = new bootstrap.Modal(document.getElementById("visualizarAgenda"))
                ModalEditAgenda.show();
                document.querySelector("#visuassunto").innerHTML = visu_titulo;
                document.querySelector("#visuhora").innerHTML = visu_hora;
                document.querySelector("#visudata").innerHTML = visu_data;
                document.querySelector("#visudesc").innerHTML = visu_descricao;
                //$("#btn_edit_agendar").attr("edit_id",id)
            }
        };
    </script>
</body>

</html>