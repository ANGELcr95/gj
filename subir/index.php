<?php
error_reporting(0);
session_start();
require 'database.php';

$message = NULL;

if (!empty($_POST['number'])) { 
	$records = $conn->prepare('SELECT  documento, nombre_asociado FROM usuarios WHERE documento=:number'); 
	$records->bindParam(':number', $_POST['number']); 
	$records->execute();  
	$results = $records->fetch(PDO::FETCH_ASSOC);

	if (($_POST['number']) == $results['documento']) {
		$_SESSION['user_documento'] = $results['documento'];
		$_SESSION['user_asociado'] = $results['nombre_asociado']; //aqui exportro el nombre de la persona
		$user = $results['nombre_asociado'];

		$datebring = NULL;
		$dir = array();
		$cont = 0;

		$recordsa = $conn->prepare('SELECT * FROM codigosSmartFit WHERE idUsuario=:documento'); 
		$recordsa->bindParam(':documento', $results['documento']); 
		$recordsa->execute();  
		while($resultsa = $recordsa->fetch(PDO::FETCH_ASSOC)) {
			$dir[$cont] = $resultsa['idUsuario'];
			$cont++;
		}

		if($cont > 1 )  {
			$message1 = 'Hola ' .$user. ", ya redimiste tus dos cupones!";
		} else {
			header('Location:singUpCC.php');
		}

  	} else {

    $message = 'El número de identificación no se encuentra habilitado en nuestra base de datos ';
		session_start();

		session_unset();

		session_destroy();
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
    </head>

    <header>
		<div class="contenedor">
            <div class="titulo">
                <h1>Smartfit Coomeva</h1>
                <div class="contenedor">
                    <img src="images/cropped-logo.png" >
                    <h2 style="color: white; font-weight: lighter;">¡Solicita tu código de <b style="color: #fdb825;">SmartFit</b> aquí!</h2>
                </div>
            </div>

			<form action="index.php" method="post" id="formulario">
				<div class="formulario__grupo" id="grupo__number">
					<p style="margin-bottom:15px; font-size:1.5rem;"><b>Para iniciar, ingresa tu número de documento:</b></p>
					<div class="formulario__grupo-input">
						<input type="number" id="usuario" class="formulario__input" name="number" placeholder="Ingresa tu cedula aquí" >
						<i class="formulario__validacion-estado fas fa-times-circle"></i>
					</div>
					<!-- <p class="formulario__input-error">El número de cédula solo debe contener números, al menos cuantro dígitos.</p> -->
				</div>
				<div class="formulario__grupo" id="grupo__condiciones">
						<input type="checkbox" id="condiciones" name ="condiciones"  >
						<button  id="conditions">He leído y acepto los términos y condiciones</button> 
						<i class="formulario__validacion-estado fas fa-times-circle"></i>
					<p class="formulario__input-error">Debe aceptar términos y condiciones</p>
				</div>
				<div class="formulario__grupo" id="grupo__condiciones" style="max-width:600px; display:flex; align-items:start;">
						<input type="checkbox" id="condiciones" name ="condiciones" style="margin-top:4px;">
						<div class="contConditions" style="width:95%; text-align: left;">
							<button  id="conditions" style="color: #333; text-align: left; font-size:12px;">Al registrarse a este servicio y en calidad de titular de la información autoriza a la Cooperativa Médica del Valle y de Profesionales de Colombia – COOMEVA y sus sucesores o cesionarias para que traten la información suministrada de acuerdo a la <a target="_blank" href="https://www.coomeva.com.co/descargar.php?idFile=27261" style="color: #fd0276;">Política de Protección de Datos Personales del GECC.</a> Los procedimientos establecidos para ejercer sus derechos a conocer, actualizar, rectificar y suprimir la información y revocar la autorización, pueden ser consultados en la nuestra <a target="_blank" href="https://www.coomeva.com.co/publicaciones/41275/importante-politica-de-proteccion-de-datos-personales/" style="color: #fd0276;">página web.</a></button> 
							<i class="formulario__validacion-estado fas fa-times-circle"></i>
						<p class="formulario__input-error">Debe aceptar términos y condiciones</p>
					</div>
				</div>

				<input type="submit" id="into1" value="Enviar" >
			</form>
				


			<div>
				<div id="modal_container" class="modal-container">
					<div class="modal">
						<h2>He leído y acepto los términos y condiciones</h2>
						<p>
							Haciendo clic aquí aceptas las condiciones del sitio, recibir de vez en cuando nuestros mensajes y materiales de promoción, via correo electrónico o cualquier otro formulario de contacto que nos proporciones. Si no deseas recibir dichos materiales o avisos de promociones, simplemente avísanos en cualquier momento.
						</p>
						<button id="close">Cerrar</button>
					</div>
				</div>
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

			<?php if(isset($message1)) : ?> 
				<div id="modal_container2"  class="modal-container2 show2">
					<div class="modal2">
						<?php if(!empty($message1 )) : ?> 
							<p class="message"><?=$message1 ?></p>
						<?php endif; ?>
						<button id="close2" onclick="cerrar2();">Cerrar</button>
					</div>
				</div>
			<?php endif; ?>

		</div>
		
		<script src="js.js"></script>
		<script src="https://kit.fontawesome.com/2c36e9b7b1.js" crossorigin="anonymous"></script>
	</header> 
</html>