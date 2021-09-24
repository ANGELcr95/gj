<?php
	session_start();
	// $nombreAsociado = utf8_decode("Luis");
	// $name = utf8_decode("Luis");
	// $codigo = utf8_decode("123");
	// $subject_label = utf8_decode("asunto");
	// //$email = "luis@email.com";
	// $fecha = utf8_decode("agosto 20");
	// $email = "webadmin@coomevarecreacion.tv";

	$nombreAsociado = utf8_decode($_SESSION['user_asociado']);
	$name = utf8_decode($_SESSION['user_asociado']);
	$codigo = utf8_decode("123");
	$subject_label = utf8_decode("asunto");
	//$email = "luis@email.com";
	$fecha = utf8_decode($_SESSION['fechaRedime']);
	$email =  $_SESSION['codigo'];

/* MAILER OPTIONS*/
	require_once('class.phpmailer.php');
	include("class.smtp.php"); // optional, gets called from within class.phpmailer.php if not already loaded

	$mail             = new PHPMailer();

	//$mail->IsSMTP(); // telling the class to use SMTP
	$mail->Host       = "ssl://coomevarecreacion.tv"; // SMTP server
	$mail->SMTPDebug  = 1;                     // enables SMTP debug information (for testing)
	                                           // 1 = errors and messages
	                                           // 2 = messages only
	$mail->SMTPAuth   = true;                  // enable SMTP authentication
	$mail->Port       = 465;                   // set the SMTP port for the GMAIL server
	$mail->Username   = "noresponder@coomevarecreacion.tv"; // SMTP account username
	$mail->Password   = "70o,$~QjSH~2?)&rf4";        // SMTP account password
	/*$mail->SMTPSecure = true;*/
	$mail->SMTPSecure = "tls";                 // Enable encryption, 'ssl' also accepted

	$mail->SetFrom('noresponder@coomevarecreacion.tv', utf8_decode('Coomeva Recreación TV'));

	$mail->AddReplyTo("noresponder@coomevarecreacion.tv",utf8_decode("Coomeva Recreación TV"));

	$mail->Subject    = $subject_label;

	$mail->AltBody    = "To view the message, please use an HTML compatible email viewer!"; // optional, comment out and test

	$address = $email;
	$mail->AddAddress($address, $name);

	$mail->AddBCC('lbarona@gekoestudio.com');

	$message = '<html><body>';
	$message = '<table align="center" border="0" cellpadding="0" cellspacing="0" style="border-collapse:collapse; background-color:#f0f0f0; padding:20px;" width="100%">
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
	
	$message .= '<strong>Nombre asociado:</strong><br/>' . utf8_decode($nombreAsociado) . '<br/><br/>';
	$message .= '<strong>Código Smartfit:</strong><br/>' . utf8_decode($codigo) . '<br/><br/>';
	$message .= '<strong>Enviado al email:</strong><br/>' . utf8_decode($email) . '<br/><br/>';
	$message .= '<strong>Redimido:</strong><br/>' . utf8_decode($fecha) . '<br/><br/>';

	$message .= '
									</td>
								</tr>
							</tbody>
						</table>
					</td>
					</tr>
					<tr>
						<td style="line-height:18px; height:10px; background-color:#f0f0f0;">&nbsp;</td>
					</tr>';
	$message .= '</tbody>
				</table>
				</td>
			</tr>
		</tbody>
	</table>
	</html>
	</body>';


	$mail->MsgHTML(utf8_decode($message));

	if(!$mail->Send()) {
	  echo "Mailer Error: " . $mail->ErrorInfo;
	} else {
		echo $quote_sent_label;
		echo $quote_buttons;
	}
?>
</body>