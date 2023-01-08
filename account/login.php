<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/login.css">
    <script src="../js/sweetealert2.js"></script>
    <title>Login</title>
</head>
<body>
    <div class="container">
        <div class="content">
            <form id="formLogin">
                <h1>Entrar na sua conta</h1>
                <div class="col-md-6">
                    <label for="email">Email</label>    
                    <input class="form-control" type="text" name="email" id="email" placeholder="Digite seu email">	
                </div>
                <div>
                    <label for="password">Password</label>    
                    <input type="text" class=" form-control" name="password" id="password" placeholder="Digite a sua senha">
                    <a style="color: #51b3ec;margin:5px;" href="recuperarSenha.php">Esqueceu a senha?</a>
                </div>
                <button id="btn_login" type="submit">Login</button>
            </form>
            <span class="text_sign">Não tem conta? <a href="register.php">Criar</a></span>
        </div>
    </div>

    <?php 

    if(isset($_GET["msg"])){
        echo '<script>
        Swal.fire({
            icon: "info",
            title: "Informaçao",
            text: "Precisas fazer login para marcar uma conversa!",
          });

        </script>';
    }
    ?>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    <script src="../js/jquery.js"></script>
    <script src="../js/sweetealert2.js"></script>
    <script src="../js/Ajax.js"></script>

</body>
</html>