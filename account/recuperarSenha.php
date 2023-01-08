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
            <form id="form_verificar_email">
                <h1>Recuperar senha</h1>
                <div class="col-md-6">
                    <label for="email">Email</label>
                    <input class="form-control" type="text" name="email" id="email" placeholder="Digite seu email">
                </div>
                <button class="btn btn-primary" id="btn_verificar_email">Verificar</button>
            </form>
            <form id="form_verificar_code" style="display: none;">
                <h1>Codigo de verificação</h1>
                <p>Enviamos um codigo verificaçao para o seu email</p>
                <div class="col-md-6">
                    <label for="email">Codigo</label>
                    <input class="form-control" type="text" name="codigo_verificação" id="code" placeholder="Coloque o codigo aqui">
                </div>
                <button id="btn_verificar_code">Verificar</button>
            </form>


            <form id="form_recuperar_senha" style="display: none;">
                <h1>Recuperar senha</h1>
                <div class="col-md-6">
                    <label for="email">Nova senha</label>
                    <input class="form-control" type="text" name="senha" id="senha" placeholder="Coloque o codigo aqui">
                </div>
                <div class="col-md-6">
                    <label for="email">Confirma senha</label>
                    <input class="form-control" type="text" name="confirm_senha" id="confirm_senha" placeholder="Coloque o codigo aqui">
                </div>
                <button id="btn_salvar_senha">Salvar senha</button>
            </form>


        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    <script src="../js/jquery.js"></script>
    <script src="../js/sweetealert2.js"></script>
    <script src="../js/Ajax.js"></script>
    <script>
        $("#btn_verificar_email").on("click", async function(e) {
            e.preventDefault();

            var email = $("#form_verificar_email #email").val();

            if (email.trim() == "") {
                Swal.fire({
                    icon: "info",
                    title: "Informação",
                    text: "Preencha o campo email",
                });
            } else {
                const dados = await fetch("checkemail.php?email=" + email)
                var resposta = await dados.json();
                console.log(resposta)
                var email = resposta.email;

                if (resposta["erro"] == 1) {

                    Swal.fire({
                        icon: "error",
                        title: "Oops...",
                        text: resposta["mensagem"],
                    });

                } else {
                    Swal.fire({
                        icon: "success",
                        title: "Enviado",
                        text: resposta["mensagem"] + " " + resposta["email"],
                    });

                    $("#form_verificar_email").hide();
                    $("#form_verificar_code").show();
                    $("#btn_salvar_senha").attr("email", email);
                }

            }
        })

        $("#btn_salvar_senha").on("click", async function(e) {
            e.preventDefault();

            var email = $(this).attr("email")
            var senha = $("#form_recuperar_senha #senha").val()
            var confirm_senha = $("#form_recuperar_senha #confirm_senha").val()

            if (senha.trim() == "" && confirm_senha.trim() == "") {
                Swal.fire({
                    icon: "info",
                    title: "Informação",
                    text: "Preencha todos os campos",
                });
            } else if (senha !== confirm_senha) {
                Swal.fire({
                    icon: "info",
                    title: "Informação",
                    text: "As duas senhas tem que ser iguais",
                });
            } else if (senha.length < 8) {
                Swal.fire({
                    icon: "info",
                    title: "Informação",
                    text: "A senha ten que ter no minimo 8 caracteres",
                });
            } else {


                const dados = await fetch("updateSenha.php?email=" + email + "&senha=" + senha)
                var resposta = await dados.json();
                console.log(resposta)

                if (resposta["erro"] == 1) {

                    Swal.fire({
                        icon: "error",
                        title: "Oops...",
                        text: resposta["mensagem"],
                    });

                } else {

                    Swal.fire({
                        icon: "success",
                        title: "Success",
                        text: resposta["mensagem"],
                    });
                    setTimeout(function() {
                        document.location = "login.php";
                    }, 1800);

                }

            }



        })


        $("#btn_verificar_code").on("click", async function(e) {
            e.preventDefault();

            var code = $("#form_verificar_code #code").val();

            if (code.trim() == "") {
                Swal.fire({
                    icon: "info",
                    title: "Informação",
                    text: "Preencha o codigo de verificação",
                });
            } else {


                const dados = await fetch("checkcode.php?code=" + code)
                var resposta = await dados.json();
                console.log(resposta)

                if (resposta["erro"] == 1) {

                    Swal.fire({
                        icon: "error",
                        title: "Oops...",
                        text: resposta["mensagem"],
                    });

                } else {
                    $("#form_verificar_code").hide();
                    $("#form_recuperar_senha").show();

                }

            }



        })
    </script>

</body>

</html>