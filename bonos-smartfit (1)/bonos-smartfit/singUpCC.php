<?php
error_reporting(0);
session_start();
require 'database.php';

$resp = NULL;
$_SESSION['correo']= $_POST['email']; //aqui exportro em email
$correo = $_POST['email'];
$user = $_SESSION['user_asociado'];

$message =' <h3>'.$user.'</h3>

            <p style="font-size: 1rem;">Hemos validado tu número de documento, <br>para continuar con el proceso de envío de tu cupón, <br/><b>debes ingresar tu correo electrónico.</b></p>';
$documento = $_SESSION['user_documento'];

if (!empty($_POST['email'])) {
    $data = [
        'correo' => $correo,
        'documento' => $documento,
    ];
    $sql = "UPDATE usuarios SET emailUsuario=:correo WHERE documento=:documento";
    $stmt= $conn->prepare($sql);
    $stmt->execute($data);

    if($stmt->execute($data)){

        $stmtc = $conn->prepare("SELECT *  FROM codigosSmartFit WHERE idUsuario IS NULL limit 1;");
        $stmtc->execute();
        $userc = $stmtc->fetch(PDO::FETCH_ASSOC);
        $respid = $userc['id'];
        $respcodigo = $userc['codigo'];

        if($stmtc->execute()){
            $datab = [
                'documento' => $documento,
                'respid' => $respid
            ];
            $sql = "UPDATE codigosSmartFit SET idUsuario=:documento WHERE id=:respid";
            $stmt= $conn->prepare($sql);
            $stmt->execute($datab);
        } 
        if($stmt->execute($datab)){
            $records = $conn->prepare("SELECT * FROM codigosSmartFit WHERE idUsuario=:documento ORDER BY codigosSmartFit.id DESC LIMIT 1"); 
            $records->bindParam(':documento', $documento); 
            $records->execute();  
            $results = $records->fetch(PDO::FETCH_ASSOC);
            $_SESSION['codigo'] = $results['codigo'];  //aqui exportro em codigo
            $codigoresp = $results['codigo'];

            $offset=5*60*60;
            $dateFormat="Y-m-d H:i:s";
            $timeNdate=gmdate($dateFormat, time()-$offset);

            $datac = [
                'timeNdate' => $timeNdate,
                'documento' => $documento
            ];
            $sql = "UPDATE codigosSmartFit SET fechaRedime=:timeNdate WHERE idUsuario=:documento ORDER BY codigosSmartFit.id DESC LIMIT 1";
            $stmt= $conn->prepare($sql);
            $stmt->execute($datac);

            $recordsa = $conn->prepare('SELECT * FROM codigosSmartFit WHERE idUsuario=:documento'); 
		    $recordsa->bindParam(':documento', $results['documento']); 
		    $recordsa->execute();
            $resultsa = $recordsa->fetch(PDO::FETCH_ASSOC);
            $fecha = $resultsa['fechaRedime'];
            
            if( $recordsa->execute()){
                $name = $_SESSION['user_asociado'];
                $subject_label = utf8_decode("Envío de cupón de Smartfit");
                $address = $_POST['email'];

                require_once('class.phpmailer.php');
                include("class.smtp.php"); // optional, gets called from within class.phpmailer.php if not already loaded

                $mail             = new PHPMailer();

                $mail->IsSMTP(); // telling the class to use SMTP
                $mail->Host       = "in-v3.mailjet.com"; // SMTP server
                //$mail->SMTPDebug  = 1;                     // enables SMTP debug information (for testing)
                                                            // 1 = errors and messages
                                                            // 2 = messages only
                $mail->SMTPAuth   = true;                  // enable SMTP authentication
                //$mail->Port       = 465;                   // set the SMTP port for the GMAIL server
                $mail->Port       = 587;                   // set the SMTP port for the GMAIL server
                $mail->Username   = "cbc6e90952e482ff1d2b4b8c7335633d"; // SMTP account username
                //$mail->Password   = "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";        // SMTP account password - cuenta suspendida
                $mail->Password   = "d0bc5c833c6bb6c2de5f05b9f879f7e4";        // SMTP account password

                //$mail->SMTPSecure = true;
                $mail->SMTPSecure = "tls";                 // Enable encryption, 'ssl' also accepted
                //$mail->addCustomHeader('X-SES-CONFIGURATION-SET', $configurationSet);
                $mail->SetFrom('noresponder@coomevarecreacion.tv', utf8_decode('Coomeva Recreación TV'));
	            $mail->AddReplyTo("noresponder@coomevarecreacion.tv",utf8_decode("Coomeva Recreación TV"));
	            $mail->Subject    = $subject_label;
                
                $mail->AddAddress($address, $name);

                $mail->AddBCC('lbarona@gekoestudio.com');

                $msg = '<html><body>';
                $msg .= '<table align="center" border="0" cellpadding="0" cellspacing="0" style="border-collapse:collapse; background-color: #131722; padding:50px;" width="100%; border-top: #fd0276 solid 20px; background: url(images/bg-smartfit.jpg) top center no-repeat;
                background-size: cover;">
                    <tbody>
                        <tr>
                            <td align="center" style="padding:40px 0;">
                                <table align="center" border="0" cellpadding="0" cellspacing="0" style="border-collapse:collapse; max-width:600px; min-width:450px;">
                                    <tbody>
                                        <tr>
                                            <td style="margin-top: 40px; margin-bottom:40px;">
                                                <img src="https://coomevarecreacion.tv/bonos-smartfit/images/cropped-logo.png" style="max-width:400px">
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </td>
                        <tr>
                            <td align="center" style="padding:20px;">
                            <table align="center" border="0" cellpadding="0" cellspacing="0" style="border-collapse:collapse; background-color:#f9f9f9; max-width:600px; min-width:450px;">
                                <tbody>
                                    <tr>
                                        <td style="line-height:18px; border: solid 1px #ccc;">
                                        <table border="0" cellpadding="0" cellspacing="0" style="border-collapse:collapse; width:100%; background-color:#f9f9f9;">
                                        <tbody>
                                                <tr height="30">
                                                    <td align="center" style="text-align:left; padding: 20px;"><span style="font-size:14px; font-family: tahoma,geneva,sans-serif; color:#696969;">
                                                    <h3>'.$name.'</h3>
                                                    <p>Haz redimido tu cupón para suscribirte a <b>Smartfit.</b><br>
                                                    Presenta el siguiente código en las instalaciones del gimnasio para recibir tu beneficio:<br>
                                                    <br>
                                                    <span style="
                                                    font-size: 24px;
                                                    font-weight: bold;
                                                    color: black;
                                                    padding: 30px;
                                                    display: block;
                                                    background-color: lightyellow;
                                                    border: 1px dashed brown;
                                                    text-align: center;">'.$codigoresp.'</span><br>
                                                    <br>
                                                    <br>
                                                    <a href="https://coomevarecreacion.tv" target="_blank" style="color: #fd0276; font-size: 18px;"><b>CoomevaRecreación.TV</b></a>';
                $msg .= '
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </td>
                                </tr>
                                <tr>
                                    <td style="line-height:18px; height:10px; background-color:#f0f0f0;">&nbsp;</td>
                                </tr>';
                $msg .= '</tbody>
                            </table>
                            </td>
                        </tr>
                    </tbody>
                </table>
                </html>
                </body>';
                
                $mail->MsgHTML(utf8_decode($msg));
                
                //$mail = @mail($email,utf8_decode($asunto),utf8_decode($msg),$header);
                

                if(!$mail->Send()) {
                    echo "Mailer Error: " . $mail->ErrorInfo;
                  } else {
                      //echo $quote_sent_label;
                      //echo $quote_buttons;
                  }

                if($mail) {
                    header('Location:logout.php');
                    //echo "<script> alert ('Mensaje enviado con éxito')</script>";
                }else{
                    session_start();

                    session_unset();

                    session_destroy();
                }
           
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="utf-8"/>
        <title>Smartfit Coomeva</title>
        <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1,maximum-scale=1, minimum-scale=1">
        <!-- aqui cambie a index -->
		<link rel="stylesheet" href="singUpCC.css">
        <!--<link rel="stylesheet" href="index.css">-->
		<link rel="stylesheet" href="conditions.css">
        <link href="https://fonts.googleapis.com/css2?family=Rubik:wght@400;700&display=swap" rel="stylesheet">

        <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    </head>

    
    <header>
        <div class="contenedor">
            <h1>Smartfit Coomeva</h1>

            <div class="contenedor">
                <img src="images/cropped-logo.png" style="margin-bottom:35px;">
                <h2 style="color: white; margin-bottom: 40px; font-weight: lighter;">¡Solicita tu código de <b style="color: #fdb825;">SmartFit</b> aquí!</h2>
            </div>

            <div id="modal_container4"  class="modal-container4 show4" style="height: auto;">
                <div class="modal4">
                    <?php if(!empty($message )) : ?> 
                        <p class="message"><?=$message ?></p>
                    <?php endif; ?>

                    <form action="singUpCC.php" method="post" id="formulario" >
                        <div class="formulario__grupo" id="grupo__email">
                            <div class="formulario__grupo-input">
                                <input type="email" id="password1"  class="formulario__input" name="email" placeholder="Ingresa tu email" >
                                <i class="formulario__validacion-estado fas fa-times-circle"></i>
                            </div>
                            <p class="formulario__input-error">El correo debe tener la siguiente estructura: correo@outlook.com</p>
                        </div>
                        <input type="submit" id="into1" value="Send" >
                    </form>
                </div>
        </div>

        <script src="jsSingUpCC.js"></script>
        <script src="https://kit.fontawesome.com/2c36e9b7b1.js" crossorigin="anonymous"></script>
	</header>
</html>


