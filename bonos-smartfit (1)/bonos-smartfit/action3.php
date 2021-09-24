<?php
	session_start();
	// $nombreAsociado = utf8_decode("Luis");
	// $name = utf8_decode("Luis");
	// $codigo = utf8_decode("123");
	// $subject_label = utf8_decode("asunto");
	// //$email = "luis@email.com";
	// $fecha = utf8_decode("agosto 20");
	// $email = "webadmin@coomevarecreacion.tv";

	//$nombreAsociado = utf8_decode($_SESSION['user_asociado']);
	//$name = utf8_decode($_SESSION['user_asociado']);
	$name = "Luis Barona";
	$codigoresp = utf8_decode("123ABC");
	$subject_label = utf8_decode("asunto");
	$address = "luisbarona83@gmail.com";
	//$fecha = utf8_decode($_SESSION['fechaRedime']);
	//$email =  $_SESSION['codigo'];

/* MAILER OPTIONS*/
	require_once('class.phpmailer.php');
	include("class.smtp.php"); // optional, gets called from within class.phpmailer.php if not already loaded

	$mail             = new PHPMailer();

	$mail->IsSMTP(); // telling the class to use SMTP
	$mail->Host       = "in-v3.mailjet.com"; // SMTP server
	$mail->SMTPDebug  = 1;                     // enables SMTP debug information (for testing)
	                                           // 1 = errors and messages
	                                           // 2 = messages only
	$mail->SMTPAuth   = true;                  // enable SMTP authentication
	//$mail->Port       = 465;                   // set the SMTP port for the GMAIL server
	$mail->Port       = 587;                   // set the SMTP port for the GMAIL server
	$mail->Username   = "cbc6e90952e482ff1d2b4b8c7335633d"; // SMTP account username
	//$mail->Password   = "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";        // SMTP account password
	$mail->Password   = "d0bc5c833c6bb6c2de5f05b9f879f7e4";        // SMTP account password
	//$mail->SMTPSecure = true;
	$mail->SMTPSecure = "tls";                 // Enable encryption, 'ssl' also accepted
	//$mail->addCustomHeader('X-SES-CONFIGURATION-SET', $configurationSet);
	$mail->Debugoutput = 'html';

	$mail->SetFrom('noresponder@coomevarecreacion.tv', utf8_decode('Coomeva Recreación TV'));

	$mail->AddReplyTo("noresponder@coomevarecreacion.tv",utf8_decode("Coomeva Recreación TV"));

	$mail->Subject    = $subject_label;

	$mail->AltBody    = "To view the message, please use an HTML compatible email viewer!"; // optional, comment out and test

	 // Specify the content of the message.
	 $mail->isHTML(true);
	 //$mail->Subject    = $subject;
	 //$mail->Body       = $bodyHtml;
	 //$mail->AltBody    = $bodyText;
	
	//$address = $email;
	//echo $address;
	//echo $name;
	//echo $mail->Host;
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

	if(!$mail->Send()) {
	  echo "Mailer Error: " . $mail->ErrorInfo;
	  //echo "An error occurred. {$e->errorMessage()}", PHP_EOL; //Catch errors from PHPMailer.
	  //echo "Email not sent. {$mail->ErrorInfo}", PHP_EOL; //Catch errors from Amazon SES.
	} else {
		echo "Message sent!";
		//echo $quote_sent_label;
		//echo $quote_buttons;
	}
?>
</body>