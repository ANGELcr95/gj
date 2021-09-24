<?php

$name = "NOMBRE Y APELLIDO ASOCIADO";
$codigoresp = "123456ABCDEF";

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

echo $msg;

?>