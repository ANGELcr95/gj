<?php
error_reporting(0);
session_start();

$name = $_SESSION['user_asociado'];
$correo = $_SESSION['correo'];
$codigoresp =$_SESSION['codigo'];

//$message = "Gracias " .$name. " su código de SmartFit es " .$codigoresp. " el cual fue enviado a su correo " .$correo;

$message =' <h3>'.$name.'</h3>
            <p>Haz redimido tu cupón para suscribirte a <b>Smartfit.</b><br>
            Presenta el siguiente código en las instalaciones del gimnasio para recibir tu beneficio:<br>
            <br>
            <span style="font-size:24px;font-weight:bold;color:black;padding:30px;display:block;background-color:lightyellow;border:1px dashed brown;text-align:center">'.$codigoresp.'</span>
            <p>Puedes anotarlo y tomarle una foto, por seguridad también te lo enviamos a tu correo electrónico.</p>';

    //session_start();

    //session_unset();

    //session_destroy();
?>

<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="utf-8"/>
        <title>Smartfit Coomeva</title>
        <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1,maximum-scale=1, minimum-scale=1">
		<link rel="stylesheet" href="logout.css">
		<link rel="stylesheet" href="conditions.css">
    </head>

    <header>

            <div class="contenedor">
                        <img src="images/cropped-logo.png" style="margin-bottom:35px;">
                        <h2 style="color: white; margin-bottom: 40px; font-weight: lighter;">¡Tu código de <b style="color: #fdb825;">SmartFit</b> ha sido enviado!</h3>
                    </div>
                        
                <div id="modal_container4"  class="modal-container4 show4" style="height: auto;">
                    <div class="modal4">
                        <?php if(!empty($message )) : ?> 
                            <p class="message"><?=$message ?></p>
                        <?php endif; ?>
                            <button id="close4">Salir</button>
                    </div>
                </div>
        
        <script src="logout.js"></script>
        <script src="https://kit.fontawesome.com/2c36e9b7b1.js" crossorigin="anonymous"></script>
	</header>
</html>


