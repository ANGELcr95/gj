<?php
session_start();
require 'database.php'; 
$message = NULL;
$user = NULL;
if (!empty($_POST['number'])) { 
  $records = $conn->prepare('SELECT  documento, nombre_asociado FROM usuarios WHERE documento=:number'); 
  $records->bindParam(':number', $_POST['number']); 
  $records->execute();  
  $results = $records->fetch(PDO::FETCH_ASSOC);

  if (($_POST['number']) == $results['documento']) {
	$_SESSION['user_documento'] = $results['documento'];
	$user = $results['nombre_asociado'];
	$_SESSION['nombre_asociado'] = $results['nombre_asociado'];
	
    // $_SESSION['user_id'] = $results['id']; // se hace con l aintension de exportar el dato del id a otras paginas
    $message1 = 'Hola ' .$user. ", ingresa por favor tu correo electronico para enviarte tu ¡CUPON!";
    // header("Location: singUpCC.php"); //redirecciona
  } 
  else {
    $message = 'Su numero de identificacion no esta registrada en nuestra base de datos';
  }
}

?>


<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="utf-8"/>
        <title>Coomeva Cupón</title>
        <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1,maximum-scale=1, minimum-scale=1">
		<link rel="stylesheet" href="index.css">
		<link rel="stylesheet" href="conditions.css">
		<link rel="preconnect" href="https://fonts.googleapis.com">
		<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
		<link href="https://fonts.googleapis.com/css2?family=Rubik:wght@400;700&display=swap" rel="stylesheet">

		<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>

  <!--<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/css/bootstrap.min.css" integrity="sha384-B0vP5xmATw1+K9KRQjQERJvTumQW0nPEzvF6L/Z6nronJ3oUOFUFpCjEUQouq2+l" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-Piv4xVNRyMGpqkS2by6br4gNJ7DXjqk09RmUpJ8jgGtD7zP9yug3goQfGII0yAns" crossorigin="anonymous"></script>-->
    </head>

    <header>
	
	<div class="contenedor">
      <img src="images/cropped-logo.png" style="margin-bottom:35px;">
      <h2 style="color: white; margin-bottom: 40px; font-weight: lighter;">¡Redime tus cupones de <b>SmartFit</b> aquí!</h3>
				<form action="index.php" method="post" id="formulario" >

				<div class="formulario__grupo" id="grupo__number">
					<div class="formulario__grupo-input">
						<input type="number" id="usuario" class="formulario__input" name="number" placeholder="Ingresa numero cedula" >
						<i class="formulario__validacion-estado fas fa-times-circle"></i>
					</div>
					<p class="formulario__input-error">El numero de cedula solo debe contener numeros y minimo de 4 digitos</p>
				</div>

					<input type="submit" id="into1" value="Send" >
			</form> 
			
			<div class="formulario__grupo" id="grupo__condiciones">
					<input type="checkbox" id="condiciones" name ="condiciones"  >
					<button  id="conditions">Terminos y condiciones</button> 
					<i class="formulario__validacion-estado fas fa-times-circle"></i>
				<p class="formulario__input-error">Debe aceptar terminos y condiciones</p>
			</div>
			
			<div>
				<div id="modal_container" class="modal-container">
					<div class="modal">
						<h2>Es una prueba de Acepto Condiciones</h2>
						<p>
							Lorem ipsum dolor sit amet, consectetur adipisicing elit. Itaque assumenda dignissimos illo explicabo natus quia repellat, praesentium voluptatibus harum ipsam dolorem cumque labore sunt dicta consectetur, nesciunt maiores delectus maxime?
						</p>
						<button id="close">Cerrar</button>
					</div>
				</div>
			</div>

			<?php if(!empty($user)) : ?> 
				<div>
				<di id="modal_container2"  class="modal-container2 show2">
					<div class="modal2">
						<?php if(!empty($message1)) : ?> 
							<p class="message"><?=$message1?></p>
						<?php endif; ?>
							<button id="close2">Cerrar</button>
					</div>
				</di>
				</div>
			<?php endif; ?>

			<?php if(isset($message)) : ?> 

				<div>
				<di id="modal_container3"  class="modal-container3 show3">
					<div class="modal3">
						<?php if(!empty($message )) : ?> 
							<p class="message"><?=$message ?></p>
						<?php endif; ?>
							<button id="close3">Cerrar</button>
					</div>
				</di>
				</div>
			<?php endif; ?>

		</div>
		<script src="js.js"></script>
		<script src="https://kit.fontawesome.com/2c36e9b7b1.js" crossorigin="anonymous"></script>
	</header> 
</html>



			