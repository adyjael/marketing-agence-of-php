<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/header.css">
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@fancyapps/ui/dist/fancybox.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css" integrity="sha512-xh6O/CkQoPOWDdYTDqeRdPCVd1SpvCA9XXcUnZS2FmJNp1coAFzvtCN9BmamE+4aHK8yyUHUSCcJHgXloTyT2A==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.1/css/all.css" integrity="sha384-50oBUHEmvpQ+1lW4y57PTFmhCaXp0ML5d60M1M7uH2+nqUivzIebhndOJK28anvf" crossorigin="anonymous">
    <?php $titulo_pagina = "Agencia digital"; ?>
    <title><?= $titulo_pagina ?></title>
</head>

<body>

    <?php

    session_start();
    if (isset($_SESSION["user"]) && is_array($_SESSION["user"])) { ?>

        <nav id="navbar_top" class="navbar navbar-expand-lg navbar-light" style="background-color: #0a3455;">
            <a style="color: #b467c3;" class="navbar-brand fw-bold" href="../Caso_praico_php/">MS</a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span style="color: #007bff;" class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav mr-auto">
                    <li class="nav-item active">
                        <a class="nav-link text-white" href="./dashboard.php">Dashboard <span class="sr-only">(current)</span></a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-white" href="./agendamento.php">Agendamentos</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-white" href="./projecto.php">Projetos</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-white" href="./noticias.php">Noticias</a>
                    </li>
                </ul>
                <div class="form-inline my-2 my-lg-0">
                    <ul class="navbar-nav mr-auto">
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle text-white" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <img width="30px" style="border-radius: 50%;" src="https://secure.gravatar.com/avatar/3039a72a3b1773c080cc6c8d36228e7f?s=80&d=mm&r=g" alt="">
                                <?= $_SESSION["user"][0]; ?>
                            </a>
                            <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                                <a class="dropdown-item" href="./perfil.php">Minha conta</a>
                                <a class="dropdown-item" href="./account/logout.php">Sair</a>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>

    <?php } else { ?>
        <nav id="navbar_top" class="navbar navbar-expand-lg navbar-light" style="background-color: #0a3455;">
            <a style="color: #b467c3;" class="navbar-brand fw-bold" href="../Caso_praico_php/">MS</a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span style="color: #007bff;" class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav mr-auto">
                    <li class="nav-item active">
                        <a class="nav-link text-white" href="index.php">Home <span class="sr-only">(current)</span></a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-white" href="./projecto.php">Projetos</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-white" href="./noticias.php">Noticias</a>
                    </li>
                </ul>
                <div class="form-inline my-2 my-lg-0">
                    <ul class="navbar-nav mr-auto">
                        <li class="nav-item text-white">
                            <a class="nav-link text-white" href="./account/login.php">Login</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link text-white" href="./account/register.php">Registro</a>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>
    <?php } ?>