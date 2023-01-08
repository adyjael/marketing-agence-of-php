<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/register.css">
    <title>Register</title>
</head>
<body>
    <div class="container">
        <div class="content">
            <form id="formRegister">
                <h1>Criar conta</h1>
                <div>
                    <label for="name">Nome</label>    
                    <input type="text" name="nome" id="nome" placeholder="Digite o seu nome">	
                </div>
                <div>
                    <label for="name">Apelido</label>    
                    <input type="text" name="apelido" id="apelido" placeholder="Digite o seu apelido">	
                </div>
                <div>
                    <label for="name">Telemovel</label>    
                    <input type="text" name="tel" id="tel" placeholder="Digite o seu contato">	
                </div>
                <div>
                    <label for="email">Email</label>    
                    <input type="text" name="email" id="email" placeholder="Digite o seu email">	
                </div>
                <div>
                    <label for="password">Password</label>    
                    <input type="text" name="password" id="password" placeholder="Digite uma senha">	
                </div>
                <button id="btn_register" type="submit">Cadastro</button>
            </form>
         <span class="text_sign">ja possui uma conta? <a href="login.php">Entrar</a></span>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    <script src="../js/jquery.js"></script>
    <script src="../js/sweetealert2.js"></script>
    <script src="../js/Ajax.js"></script>
</body>
</html>