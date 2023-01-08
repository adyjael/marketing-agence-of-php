<?php



use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

include "../vendor/autoload.php";
include "../config/conection.php";
$conexao = new Conexao;

if (isset($_GET["email"])) {
    $email = htmlspecialchars($_GET["email"]);
    $query = $conexao->conectar()->prepare("SELECT * FROM utilizadores WHERE email=:email LIMIT 1");
   $query->bindParam(":email",$email);
   $query->execute();

    if($query->rowCount()){

        $query = $query->fetchAll(PDO::FETCH_ASSOC);
        $nome = $query[0]["nome"];
        $apelido = $query[0]["apelido"];
        $email = $query[0]["email"];

        $mail = new PHPMailer(true);
        $token =  rand(1000,99999);

        $token_insert = $conexao->conectar()->prepare("UPDATE utilizadores SET token_recupercao=:token WHERE email = :email");
        $token_insert->bindParam(":token",$token);
        $token_insert->bindParam(":email",$email);
        $token_insert->execute();

        if($token_insert == true){

            try {
                //Server settings
                //$mail->SMTPDebug = SMTP::DEBUG_SERVER; 
                $mail->isSMTP();                                            //Send using SMTP
                $mail->Host       = 'smtp.gmail.com';                     //Set the SMTP server to send through
                $mail->SMTPAuth   = true;      
                $mail->SMTPSecure = 'tls';                             //Enable SMTP authentication
                $mail->Username   = 'casopraticophp@gmail.com';                     //SMTP username
                $mail->Password   = 'buphqxjykpmerovy';                            //SMTP password
                $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;            //Enable implicit TLS encryption
                $mail->Port       = 465;                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`
            
                //Recipients
                $mail->setFrom('casopraticophp@gmail.com', 'Caso pratico php');
                $mail->addAddress($email, "$nome $apelido");     //Add a recipient
            
                $assunto = "Recuperacao de senha";
                $mensagem = " <h1>Codigo de verificação</h1>
                            <p style='font-size:30px;color:red;'>$token</p>";
            

                //Content
                $mail->isHTML(true);                                  //Set email format to HTML
                $mail->Subject = $assunto;
                $mail->Body    = $mensagem;
                $mail->AltBody = $mensagem;
                $mail->send();
                echo json_encode(array("erro" => 0, "mensagem" => "Enviamos um codigo de verificação para o seu email", "email" => $email));
            } catch (Exception $e) {
                echo "Mensagem não foi enviada. Email Error: {$mail->ErrorInfo}";
            }
        }
    }else {
        echo json_encode(array("erro" => 1, "mensagem" => "Não encontramos nenhuma conta com este email"));
    }
}