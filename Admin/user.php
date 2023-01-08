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
    <title>Admin utilizadores</title>
 
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
            $query = $conexao->conectar()->prepare("SELECT * FROM utilizadores");
            $adm = $conexao->conectar()->prepare("SELECT adm FROM utilizadores WHERE adm = 0");
            $adm->execute();
            $query->execute();
            $utilizadores = $query->fetchAll();
            ?>
            <div class=" d-flex justify-content-around">
                <h3 class=" my-3">Total Utilizadores (<?= count($utilizadores) - $adm->rowCount() ?>)</h3>
                <h3 class="my-3">Total Adm (<?= $adm->rowCount() ?>)</h3>
                <h3 class="my-3" style="margin-right: 70px;"><a style="text-decoration: none;color:#51b3ec;" href="#adicionarUtilizador" data-bs-toggle="modal" data-bs-target="#adicionarUtilizador"><i class="fa-solid fa-circle-plus"></i> Novo utilizador</a></h3>
            </div>
            <table class="table table-striped table-responsive-md">
                <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Nome</th>
                        <th scope="col">Apelido</th>
                        <th scope="col">Telemovel</th>
                        <th scope="col">Email</th>
                        <th scope="col">ADM</th>
                        <th scope="col">Data do cadastro</th>
                        <th scope="col">Ações</th>
                    </tr>
                </thead>
                <tbody>

                    <?php foreach ($utilizadores as $utilizador) : ?>
                        <tr>
                            <td><?= $utilizador["id"] ?></td>
                            <td><?= $utilizador["nome"] ?></td>
                            <td><?= $utilizador["apelido"] ?></td>
                            <td>(+351) <?= $utilizador["tel"] ?></td>
                            <td><?= $utilizador["email"] ?></td>
                            <td><?= $utilizador["adm"] ? "Não" : "<span class=' fw-bold'>Sim</span>"; ?></td>
                            <td><?= date("d/m/Y", strtotime($utilizador["data"])) ?></td>
                            <td><button class="btn btn-primary" onclick="admEditUser(<?= $utilizador['id']  ?>)">Editar</button>
                                <button delete="<?= $utilizador["id"] ?>" class="btn btn-danger btn_adm_delete_user">Remover</button>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>

        </div>
    </div>

    <!-- -------------MODAL-----------------MODAL------------------MODAL--------------MODAL----------MODAL -->

    <!--MODAL DE ADICIONAR O USUARIO -->
    <div class="modal modal-lg fade" id="adicionarUtilizador" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Cadastrar utilizadores</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="formAdmAddUtilizador">
                        <input type="hidden" id="utilizador_id" class="form-control">

                        <div class="mb-3">
                            <label for="titulo" class="col-form-label">Nome:</label>
                            <input type="text" id="nome" class="form-control">
                        </div>
                        <div class="mb-3">
                            <label for="data" class="col-form-label">Apelido:</label>
                            <input type="text" class="form-control" id="apelido">
                        </div>
                        <div class="mb-3">
                            <label for="hora" class="col-form-label">Telemovel:</label>
                            <input type="text" id="tel" class="form-control">
                        </div>
                        <div class="mb-3">
                            <label for="hora" class="col-form-label">Email:</label>
                            <input type="text" id="email" class="form-control">
                        </div>
                        <div class="mb-3">
                            <label for="hora" class="col-form-label">Senha:</label>
                            <input type="text" id="password" class="form-control">
                        </div>
                        <div class="mb-3">
                            <label for="hora" class="col-form-label">Adm</label>
                            <select class="form-control" id="adm">
                                <option value="1">Não</option>
                                <option value="0">Sim</option>
                            </select>

                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                            <button type="submit" id="btn_adm_cadastrar_utilizador" class="btn btn-primary">Cadastrar</button>
                        </div>
                    </form>
                </div>

            </div>
        </div>
    </div>

    <!-- FIM DO MODAL ADICIONAR USUARIO -->

    <!--MODAL DE editar O USUARIO -->
    <div class="modal modal-lg fade" id="editUser" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Editar Usuario: <span id="usertitle"></span> </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="formAdmEditUtilizador">
                        <input type="hidden" id="utilizador_id" class="form-control">

                        <div class="mb-3">
                            <label for="titulo" class="col-form-label">Nome:</label>
                            <input type="text" id="editUserName" class="form-control">
                        </div>
                        <div class="mb-3">
                            <label for="data" class="col-form-label">Apeliso:</label>
                            <input type="text" class="form-control" id="userApelido">
                        </div>
                        <div class="mb-3">
                            <label for="hora" class="col-form-label">Telemovel:</label>
                            <input type="text" id="editUserTel" class="form-control">
                        </div>
                        <div class="mb-3">
                            <label for="hora" class="col-form-label">Email:</label>
                            <input type="text" id="editUserEmail" class="form-control">
                        </div>
                        <div class="mb-3">
                            <label for="hora" class="col-form-label">Adm</label>
                            <select name="" class="form-control" id="editUserAdm">
                                <option value="1" selected disabled>Não</option>
                            </select>

                        </div>


                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                            <button type="submit" id="btn_adm_edit_user" class="btn btn-primary">Salvar</button>
                        </div>
                    </form>
                </div>

            </div>
        </div>
    </div>

    <!-- FIM DO MODAL Editar USUARIO -->




    <script src="../js/jquery.js"></script>
    <script src="../js/sweetealert2.js"></script>
    <script src="../js/Ajax.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    <script>
        async function admEditUser(id) {

            if (id == 3) {
                Swal.fire({
                    icon: "info",
                    title: "Informação",
                    text: "Para editar este usuario entre em contacto com o Desenvolvedor do site",
                });
            } else {

                const dados = await fetch("../Admin/modalEditUser.php?id=" + id)
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
                    var edit_nome = agendas[0].nome
                    var edit_apelido = agendas[0].apelido
                    var edit_tel = agendas[0].tel
                    var edit_email = agendas[0].email

                    var ModalEditAgenda = new bootstrap.Modal(document.getElementById("editUser"))
                    ModalEditAgenda.show();
                    document.querySelector("#usertitle").innerHTML = edit_nome + " " + edit_apelido;
                    document.querySelector("#editUserName").value = edit_nome;
                    document.querySelector("#userApelido").value = edit_apelido;
                    document.querySelector("#editUserTel").value = edit_tel;
                    document.querySelector("#editUserEmail").value = edit_email;

                    $("#btn_adm_edit_user").attr("adm_adit_id", id);
                }


            }
        };
    </script>
</body>

</html>