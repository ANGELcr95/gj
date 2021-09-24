<?php
error_reporting(0);
session_start();
require 'database.php';

$resp = NULL;
$message = NULL;
$correo = $_POST['email'];
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

        $stmtc = $conn->prepare("SELECT *  FROM codigosSmartFit WHERE idUsuario IS NULL limit 1");
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
            $_SESSION['codigo'] = $results['codigo'];
            $codigoresp = $results['codigo'];
            $message = "Le enviaremos el siguiente codigo ". $codigoresp . " a su correo electronico " .$correo;

            $timeNdate=date("Y-m-d");

            $datac = [
                'timeNdate' => $timeNdate,
                'documento' => $documento
            ];
            $sql = "UPDATE codigosSmartFit SET fechaRedime=:timeNdate WHERE idUsuario=:documento";
            $stmt= $conn->prepare($sql);
            $stmt->execute($datac);

            $recordsa = $conn->prepare('SELECT * FROM codigosSmartFit WHERE idUsuario=:documento'); 
		    $recordsa->bindParam(':documento', $results['documento']); 
		    $recordsa->execute();
            $resultsa = $recordsa->fetch(PDO::FETCH_ASSOC);
            $_SESSION['fechaRedime'] = $resultsa['fechaRedime'];
            
            if( $recordsa->execute()){
                $name = $_SESSION['nombre_asociado'];
                $asunto = "Envío de cupón de Smartfit";
                //$codigoresp = "44848";
                $email = $_POST['email'];
                $header = "From: mcamacho@gekoestudio.com" ."\r\n";
                $header.= "Reply-To: $correo " ."\r\n";
                $header .= "X-Mailer: PHP/". phpversion();
                $header .= 'MIME-Version: 1.0' . "\r\n";
                $header .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
                
                
                //$msg = "Este es un mensaje el cual anexa un cupon $codigoresp Smarfit";

                $msg = '<html><body>';
                $msg .= '<table align="center" border="0" cellpadding="0" cellspacing="0" style="border-collapse:collapse; background-color:#f0f0f0; padding:20px;" width="100%">
                    <tbody>
                        <tr>
                            <td align="center" style="padding:20px;">
                            <table align="center" border="0" cellpadding="0" cellspacing="0" style="border-collapse:collapse; background-color:#f9f9f9; max-width:600px; min-width:320px;">
                                <tbody>
                                    <tr>
                                        <td style="line-height:18px; border: solid 1px #ccc;">
                                        <table border="0" cellpadding="0" cellspacing="0" style="border-collapse:collapse; width:100%; background-color:#f9f9f9;">
                                        <tbody>
                                                <tr height="30">
                                                    <td align="center" style="text-align:left; padding: 20px;"><span style="font-size:14px; font-family: tahoma,geneva,sans-serif; color:#696969;">';
                
                $msg .= '<strong>Nombre asociado:</strong><br/>' . $name . '<br/><br/>';
                $msg .= '<strong>Código Smartfit:</strong><br/>' . $codigoresp . '<br/><br/>';
                $msg .= '<strong>Enviado al email:</strong><br/>' . $email . '<br/><br/>';
                //$msg .= '<strong>Redimido:</strong><br/>' . utf8_decode($fecha) . '<br/><br/>';
            
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
                
                //$mail->MsgHTML(utf8_decode($message));
                
                $mail = @mail($email,utf8_decode($asunto),utf8_decode($msg),$header);
                

                /*if(!$mail->Send()) {
                    echo "Mailer Error: " . $mail->ErrorInfo;
                  } else {
                      echo $quote_sent_label;
                      echo $quote_buttons;
                  }*/

                if($mail) {
                    //echo "<script> alert ('Mensaje enviado con éxito')</script>";
                }
                session_start();
                session_unset();
                session_destroy();
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
		<link rel="stylesheet" href="index.css">
		<link rel="stylesheet" href="conditions.css">
        <link href="https://fonts.googleapis.com/css2?family=Rubik:wght@400;700&display=swap" rel="stylesheet">

        <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    </head>

    <header>
        <div class="contenedor">
        <img src="images/cropped-logo.png" style="margin-bottom:35px;">
        <h2 style="color: white; margin-bottom: 40px; font-weight: lighter;">¡Redime tus cupones de <b>SmartFit</b> aquí!</h3>
            <form action="singUpCC.php" method="post" id="formulario" >
                <div class="formulario__grupo" id="grupo__email">
                    <div class="formulario__grupo-input">
                        <input type="email" id="password1"  class="formulario__input" name="email" placeholder="Ingresa tu email" >
                        <i class="formulario__validacion-estado fas fa-times-circle"></i>
                    </div>
                    <p class="formulario__input-error">El correo deber contener siguiente estructura:  example@outlook.com .</p>
                </div>
                <input type="submit" id="into1" value="Send" >
            </form>
        </div>
                
        <?php if(isset($message)) : ?> 
            <div id="modal_container3"  class="modal-container3 show3">
                <div class="modal3">
                    <?php if(!empty($message )) : ?> 
                        <p class="message"><?=$message ?></p>
                    <?php endif; ?>
                        <button id="close3">Cerrar</button>
                </div>
            </div>
        <?php endif; ?>
            
        <script src="jsSingUpCC.js"></script>
        <script src="https://kit.fontawesome.com/2c36e9b7b1.js" crossorigin="anonymous"></script>
	</header>
</html>


